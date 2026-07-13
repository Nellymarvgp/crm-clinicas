<option selected value="">--- Seleccione una cita ---</option>
@if (!empty($appointment))
    @foreach ($appointment as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
@endif
