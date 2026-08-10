@extends('layouts.master-layouts')

@section('title')
    {{ 'Reporte mensual de pago a doctores' }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')
            {{ 'Reportes' }}
        @endslot
        @slot('li_1')
            {{ 'Finanzas' }}
        @endslot
        @slot('li_2')
            {{ 'Pago mensual a doctores' }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ url('doctor-monthly-payout-report') }}" class="row g-3 align-items-end mb-4">
                        <div class="col-md-3">
                            <label for="month" class="form-label">{{ 'Mes' }}</label>
                            <select id="month" name="month" class="form-select">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ (int) $selectedMonth === $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year" class="form-label">{{ 'Año' }}</label>
                            <input type="number" min="2000" max="2100" id="year" name="year" class="form-control"
                                value="{{ $selectedYear }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">{{ 'Filtrar' }}</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>{{ 'Doctor' }}</th>
                                    <th>{{ 'Pacientes atendidos' }}</th>
                                    <th>{{ 'Citas completadas' }}</th>
                                    <th>{{ 'Total servicios' }}</th>
                                    <th>{{ 'Precio final consulta' }}</th>
                                    <th>{{ '% Doctor' }}</th>
                                    <th>{{ 'Total a pagar' }}</th>
                                    <th>{{ 'Pendiente' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $item)
                                    <tr>
                                        <td>{{ $item->doctor_name }}</td>
                                        <td>{{ number_format((int) $item->attended_patients) }}</td>
                                        <td>{{ number_format((int) $item->completed_appointments) }}</td>
                                        <td>${{ number_format((float) $item->total_services_amount, 2) }}</td>
                                        <td>${{ number_format((float) $item->total_final_consultation_price, 2) }}</td>
                                        <td>{{ number_format((float) $item->doctor_payment_percentage, 2) }}%</td>
                                        <td>${{ number_format((float) $item->doctor_payable_amount, 2) }}</td>
                                        <td>${{ number_format((float) $item->pending_payment_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">{{ 'No hay resultados para el periodo seleccionado.' }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{ 'Total' }}</th>
                                    <th>{{ number_format((int) $totals['attended_patients']) }}</th>
                                    <th>{{ number_format((int) $totals['completed_appointments']) }}</th>
                                    <th>${{ number_format((float) $totals['total_services_amount'], 2) }}</th>
                                    <th>${{ number_format((float) $totals['total_final_consultation_price'], 2) }}</th>
                                    <th>-</th>
                                    <th>${{ number_format((float) $totals['doctor_payable_amount'], 2) }}</th>
                                    <th>${{ number_format((float) $totals['pending_payment_amount'], 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
