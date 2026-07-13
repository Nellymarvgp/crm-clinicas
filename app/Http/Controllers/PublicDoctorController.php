<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Departments;
use Illuminate\Http\Request;

class PublicDoctorController extends Controller
{
    /**
     * Display the public doctor finder page.
     *
     * @return \Illuminate\Http\Response
     */
    public function findDoctorPage()
    {
        $doctors = Doctor::with(['user', 'department'])
            ->whereHas('user', function($q) {
                $q->where('is_deleted', 0);
            })
            ->get();
        $departments = Departments::all();
        return view('doctor.find', compact('doctors', 'departments'));
    }

    /**
     * Get the weekly schedule for a specific doctor via AJAX.
     *
     * @param int $id Doctor ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWeeklySchedule($id)
    {
        $doctor = Doctor::with(['availableDays', 'availableTimes'])->findOrFail($id);
        
        return response()->json([
            'schedule' => $doctor->availableDays ? $doctor->availableDays->toArray() : [],
            'slots' => [
                'mon' => $doctor->availableTimes ?? [],
                'tue' => $doctor->availableTimes ?? [],
                'wed' => $doctor->availableTimes ?? [],
                'thu' => $doctor->availableTimes ?? [],
                'fri' => $doctor->availableTimes ?? [],
                'sat' => $doctor->availableTimes ?? [],
                'sun' => $doctor->availableTimes ?? []
            ]
        ]);
    }
}
