<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\Invoice;
use App\InvoiceDetail;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
    }

    /**
     * Get Monthly Users and Revenue.
     *
     * @return Array
     */
    public function getMonthlyUsersRevenue()
    {
        $patients =  User::whereHas('roles', function ($q) {
            $q->where('slug', 'patient');
        })->select(DB::raw('count(id) as `total_patient`'), DB::raw('MONTH(created_at) Month'))
            ->whereYear('created_at', Carbon::now()->year)->groupBy(DB::raw('MONTH(created_at)'))->get();

        $revenue = DB::select('SELECT MONTH(invoices.created_at) AS Month,SUM(invoice_details.amount) AS total_revenue
        FROM invoices, invoice_details WHERE invoices.id = invoice_details.invoice_id AND YEAR(invoices.created_at) = YEAR(CURDATE()) AND invoices.payment_status = "Paid" AND invoice_details.is_deleted = 0 AND invoices.is_deleted = 0
        GROUP BY MONTH(invoices.created_at)');

        $data = [
            'total_patient' => $patients,
            'total_revenue' => $revenue
        ];
        return $data;
    }

    public function getMonthlyInvoice()
    {
        $paid_invoice =  Invoice::selectRaw('COUNT(id) as paid_invoice, MONTH(created_at) as Month')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->where('is_deleted', 0)
            ->where('payment_status', 'Paid')
            ->get();

        $unpaid_invoice =  Invoice::selectRaw('COUNT(*) as unpaid_invoice, MONTH(created_at) as Month')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->where('is_deleted', 0)
            ->where('payment_status', 'Unpaid')
            ->get();

        $invoiceData = [
            'paid_invoice' => $paid_invoice,
            'unpaid_invoice' => $unpaid_invoice
        ];

        return $invoiceData;
    }

    /**
     * Get Monthly Appointments for each doctor.
     *
     * @return Array
     */
    public function getMonthlyAppointments()
    {
        $user = Sentinel::getUser();
        $doctor_info = Doctor::where('user_id', '=', $user->id)->first();
        $appointments = Appointment::select(DB::raw('MONTH(appointment_date) Month'), DB::raw('count(id) as `total_appointment`'))
            ->whereYear('created_at', Carbon::now()->year)->groupBy(DB::raw('MONTH(appointment_date)'))->where('appointment_with', $doctor_info->id)->get();
        return $appointments;
    }

    /**
     * Get Monthly monthly earning.
     *
     * @return Array
     */
    public static function getMonthlyEarning()
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $userId = $user->id;
        
        if ($role == 'patient') {
            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', date('m'))->where('payment_status', 'Paid')->where('patient_id', $userId)->pluck('id');
            $currentMonthEarning = InvoiceDetail::whereIn('invoice_id', $invoice)->where('is_deleted', 0)->sum('amount');
            $preInvoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->where('payment_status', 'Paid')->whereMonth('created_at', Carbon::now()->subMonth()->month)->where('patient_id', $userId)->pluck('id');
            $prevMonthEarning = InvoiceDetail::whereIn('invoice_id', $preInvoice)->where('is_deleted', 0)->sum('amount');
        } elseif ($role == 'doctor') {
            $doctor_info = Doctor::where('user_id', '=', $user->id)->first();

            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', date('m'))->where('doctor_id', $doctor_info->id)->where('payment_status', 'Paid')->pluck('id');

            $currentMonthEarning = InvoiceDetail::whereIn('invoice_id', $invoice)->where('is_deleted', 0)->sum('amount');
            $preInvoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', Carbon::now()->subMonth()->month)->where('payment_status', 'Paid')->where('doctor_id', $doctor_info->id)->pluck('id');

            $prevMonthEarning = InvoiceDetail::whereIn('invoice_id', $preInvoice)->where('is_deleted', 0)->sum('amount');
        } else {
            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', date('m'))->where('payment_status', 'Paid')->pluck('id');
            $currentMonthEarning = InvoiceDetail::whereIn('invoice_id', $invoice)->where('is_deleted', 0)->sum('amount');

            $preInvoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', Carbon::now()->subMonth()->month)->where('payment_status', 'Paid')->pluck('id');
            $prevMonthEarning = InvoiceDetail::whereIn('invoice_id', $preInvoice)->where('is_deleted', 0)->sum('amount');
        }
        $diff = $currentMonthEarning - $prevMonthEarning;
        if ($prevMonthEarning == 0) {
            $total_diff = 100;
        } else {
            $total_diff = $diff / $prevMonthEarning * 100;
        }
        $data = [
            'monthlyEarning' => $currentMonthEarning,
            'diff' => number_format($total_diff, 2)
        ];
        return $data;
    }

    /**
     * Monthly payout report for all doctors.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function doctorMonthlyPayoutReport(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;

        if (!in_array($role, ['admin', 'accountant'])) {
            return view('error.403');
        }

        $selectedMonth = (int) $request->get('month', Carbon::now()->month);
        $selectedYear = (int) $request->get('year', Carbon::now()->year);

        $reports = Doctor::query()
            ->leftJoin('users', 'users.id', '=', 'doctors.user_id')
            ->leftJoin('appointments', function ($join) use ($selectedMonth, $selectedYear) {
                $join->on('appointments.appointment_with', '=', 'doctors.id')
                    ->where('appointments.status', 1)
                    ->where('appointments.is_deleted', 0)
                    ->whereMonth('appointments.appointment_date', $selectedMonth)
                    ->whereYear('appointments.appointment_date', $selectedYear);
            })
            ->leftJoinSub(
                DB::table('invoices')
                    ->join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
                    ->where('invoices.is_deleted', 0)
                    ->where('invoice_details.is_deleted', 0)
                    ->groupBy('invoices.appointment_id')
                    ->selectRaw('invoices.appointment_id, SUM(invoice_details.amount) as total_services_amount'),
                'appointment_services',
                function ($join) {
                    $join->on('appointment_services.appointment_id', '=', 'appointments.id');
                }
            )
            ->where('doctors.is_deleted', 0)
            ->where('users.is_deleted', 0)
            ->groupBy('doctors.id', 'users.first_name', 'users.last_name', 'doctors.doctor_payment_percentage')
            ->selectRaw('doctors.id as doctor_id')
            ->selectRaw('users.first_name, users.last_name')
            ->selectRaw('COALESCE(doctors.doctor_payment_percentage, 0) as doctor_payment_percentage')
            ->selectRaw('COUNT(DISTINCT appointments.id) as completed_appointments')
            ->selectRaw('COUNT(DISTINCT appointments.appointment_for) as attended_patients')
            ->selectRaw('COALESCE(SUM(appointment_services.total_services_amount), 0) as total_services_amount')
            ->selectRaw('COALESCE(SUM(COALESCE(appointments.final_consultation_price, 0)), 0) as total_final_consultation_price')
            ->selectRaw('COALESCE(SUM((COALESCE(appointments.final_consultation_price, 0) * COALESCE(doctors.doctor_payment_percentage, 0)) / 100), 0) as doctor_payable_amount')
            ->orderBy('users.first_name')
            ->orderBy('users.last_name')
            ->get()
            ->map(function ($item) {
                $item->doctor_name = trim(($item->first_name ?? '') . ' ' . ($item->last_name ?? ''));
                // There is no payment ledger yet, so pending equals payable for now.
                $item->pending_payment_amount = (float) $item->doctor_payable_amount;
                return $item;
            });

        $totals = [
            'completed_appointments' => $reports->sum('completed_appointments'),
            'attended_patients' => $reports->sum('attended_patients'),
            'total_services_amount' => $reports->sum('total_services_amount'),
            'total_final_consultation_price' => $reports->sum('total_final_consultation_price'),
            'doctor_payable_amount' => $reports->sum('doctor_payable_amount'),
            'pending_payment_amount' => $reports->sum('pending_payment_amount'),
        ];

        return view('reports.doctor-monthly-payout', compact(
            'user',
            'role',
            'reports',
            'totals',
            'selectedMonth',
            'selectedYear'
        ));
    }
}
