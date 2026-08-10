<?php $__env->startSection('title', 'Agendar Cita'); ?>

<?php $__env->startSection('css'); ?>
<!-- Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_green.css">

<style>
    .btn-success, .btn-outline-success {
        background-color: var(--secondary-color) !important;
        border-color: var(--secondary-color) !important;
        color: white !important;
    }
    
    .btn-outline-success {
        background-color: transparent !important;
        color: var(--secondary-color) !important;
    }
    
    .btn-outline-success:hover, .btn-outline-success.active {
        background-color: var(--secondary-color) !important;
        color: white !important;
    }
    
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: var(--secondary-color) !important;
        border-color: var(--secondary-color) !important;
    }
    
    .form-control:focus {
        border-color: var(--secondary-color) !important;
        box-shadow: 0 0 0 0.2rem rgba(79, 177, 177, 0.25) !important;
    }
    
    .required:after {
        content: " *";
        color: red;
    }
    
    /* Ajustes para espacio por el menú fijo */
    .content-wrapper {
        padding-top: 90px;
        padding-bottom: 40px;
    }
    
    /* Estilos específicos para flatpickr */
    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected.inRange, .flatpickr-day.startRange.inRange, .flatpickr-day.endRange.inRange, .flatpickr-day.selected:focus, .flatpickr-day.startRange:focus, .flatpickr-day.endRange:focus, .flatpickr-day.selected:hover, .flatpickr-day.startRange:hover, .flatpickr-day.endRange:hover, .flatpickr-day.selected.prevMonthDay, .flatpickr-day.startRange.prevMonthDay, .flatpickr-day.endRange.prevMonthDay, .flatpickr-day.selected.nextMonthDay, .flatpickr-day.startRange.nextMonthDay, .flatpickr-day.endRange.nextMonthDay {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Agendar una Cita</h4>
                    </div>
                    <div class="card-body">
                        <div id="error-container" class="alert alert-danger" style="display: none;"></div>
                        <div id="success-container" class="alert alert-success" style="display: none;"></div>
                        
                        <form id="appointment-form" method="POST" action="<?php echo e(route('public.appointment.store')); ?>">
                            <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
                            <?php echo csrf_field(); ?>
                            <h5 class="mb-4">Información Personal</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name" class="required">Nombre Completo</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                        <div class="invalid-feedback" id="name-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="required">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                        <div class="invalid-feedback" id="email-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="required">Teléfono</label>
                                        <input type="text" class="form-control" id="phone" name="phone" required>
                                        <div class="invalid-feedback" id="phone-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="age" class="required">Edad</label>
                                        <input type="number" class="form-control" id="age" name="age" required min="1" max="120">
                                        <div class="invalid-feedback" id="age-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender" class="required">Sexo</label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="">Seleccionar</option>
                                            <option value="Male">Masculino</option>
                                            <option value="Female">Femenino</option>
                                            <option value="Other">Otro</option>
                                        </select>
                                        <div class="invalid-feedback" id="gender-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address" class="required">Dirección</label>
                                        <input type="text" class="form-control" id="address" name="address" required>
                                        <div class="invalid-feedback" id="address-error"></div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-4">Detalles de la Cita</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="doctor_id" class="required">Doctor</label>
                                        <select id="doctor_id" name="doctor_id" class="form-control">
                                            <option value="">Seleccionar doctor</option>
                                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($doctor->id); ?>" 
                                                    <?php if(isset($selectedDoctorId) && $selectedDoctorId == $doctor->id): ?> selected <?php endif; ?>>
                                                    Dr. <?php echo e($doctor->user ? $doctor->user->first_name.' '.$doctor->user->last_name : 'Doctor'); ?>

                                                    (<?php echo e($doctor->department ? $doctor->department->name : 'Sin departamento'); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div id="doctor_id-error" class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="hidden" id="calendar-mode" name="calendar_mode" value="standard">
                            
                            <!-- Sistema de calendario estándar -->
                            <div id="standard-calendar-container" class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date" class="required">Fecha de la Cita</label>
                                        <input type="text" class="form-control" id="date" name="date" readonly required>
                                        <div class="invalid-feedback" id="date-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="time" class="required">Hora de la Cita</label>
                                        <select class="form-control" id="time" name="time" required disabled>
                                            <option value="">Primero selecciona un doctor y una fecha</option>
                                        </select>
                                        <input type="hidden" id="slot_id" name="slot_id">
                                        <div class="invalid-feedback" id="time-error"></div>
                                        <div class="invalid-feedback" id="slot_id-error"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg">Agendar Cita</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<!-- jQuery (necesario para bootstrap) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Flatpickr para el calendario -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Variables
        const doctorSelect = document.getElementById('doctor_id');
        const dateInput = document.getElementById('date');
        const timeSelect = document.getElementById('time');
        const slotIdInput = document.getElementById('slot_id');
        const appointmentForm = document.getElementById('appointment-form');
        const errorContainer = document.getElementById('error-container');
        const successContainer = document.getElementById('success-container');
        
        const calendarModeInput = document.getElementById('calendar-mode');
        
        // Variables para el calendario
        let doctorId = '';
        let availableDays = [];
        
        // Obtener el token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        console.log('Inicializando datepicker...');
        
        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        // Initialize date picker with Spanish locale
        try {
            const datePicker = flatpickr("#date", {
                locale: "es",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "l, d F Y",
                minDate: "today",
                disableMobile: "true",
                disable: [
                    function(date) {
                        // Disable all days initially
                        return true;
                    }
                ],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        loadTimeSlots(dateStr);
                    }
                }
            });
            
            console.log('Datepicker inicializado correctamente');
            
            // Si hay un doctor preseleccionado, cargamos sus días disponibles automáticamente
            if (doctorSelect.value) {
                doctorId = doctorSelect.value;
                loadAvailableDays();
            }

            // Doctor selection change
            doctorSelect.addEventListener('change', function() {
                doctorId = this.value;
                dateInput.value = '';
                
                if (doctorId) {
                    loadAvailableDays();
                } else {
                    resetDatePicker();
                    resetTimeSlots();
                }
            });

            // Load available days for the selected doctor
            function loadAvailableDays() {
                if (!doctorId) return;
                
                $.ajax({
                    url: '<?php echo e(route('public.doctor.available.days')); ?>',
                    method: 'POST',
                    data: {
                        doctor_id: doctorId,
                        _token: csrfToken
                    },
                    success: function(data) {
                        if (data.days && Array.isArray(data.days)) {
                            availableDays = data.days;
                            updateDatePickerConfig();
                        } else {
                            // Si no hay días disponibles, mostrar mensaje
                            console.warn('No se encontraron días disponibles para este doctor');
                            availableDays = [];
                            updateDatePickerConfig();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar días disponibles:', error);
                        showError('Error al cargar los días disponibles: ' + error);
                    }
                });
            }

            // Update date picker configuration with available days
            function updateDatePickerConfig() {
                datePicker.set('disable', [
                    function(date) {
                        // Check if the day of week is in available days
                        return !availableDays.includes(date.getDay());
                    }
                ]);
            }

            // Reset date picker
            function resetDatePicker() {
                datePicker.set('disable', [
                    function(date) {
                        return true;
                    }
                ]);
            }
        } catch (error) {
            console.error('Error al inicializar el datepicker:', error);
        }

        // Load time slots for the selected date
        function loadTimeSlots(date) {
            if (!doctorId || !date) return;
            
            $.ajax({
                url: '<?php echo e(route('public.doctor.available.slots')); ?>',
                method: 'POST',
                data: {
                    doctor_id: doctorId,
                    date: date,
                    _token: csrfToken
                },
                success: function(data) {
                    // Enable select
                    timeSelect.disabled = false;
                    
                    // Clear previous options
                    timeSelect.innerHTML = '';
                    
                    // Add default option
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = 'Seleccionar hora';
                    timeSelect.appendChild(defaultOption);
                    
                    if (data.slots && Array.isArray(data.slots) && data.slots.length > 0) {
                        // Add time slots
                        data.slots.forEach(slot => {
                            if (slot && slot.time && slot.display_time && slot.id) {
                                const option = document.createElement('option');
                                option.value = slot.time;
                                option.textContent = slot.display_time;
                                option.dataset.slotId = slot.id;
                                timeSelect.appendChild(option);
                            }
                        });
                        
                        // Handle time selection change
                        timeSelect.addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            if (selectedOption && selectedOption.dataset.slotId) {
                                slotIdInput.value = selectedOption.dataset.slotId;
                            } else {
                                slotIdInput.value = '';
                            }
                        });
                    } else {
                        // No slots available
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = data.error || 'No hay horarios disponibles para esta fecha';
                        timeSelect.appendChild(option);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar horarios disponibles:', error);
                    showError('Error al cargar los horarios disponibles: ' + error);
                    
                    // Reset time slots on error
                    resetTimeSlots();
                }
            });
        }

        // Reset time slots
        function resetTimeSlots() {
            timeSelect.disabled = true;
            timeSelect.innerHTML = '<option value="">Primero selecciona un doctor y una fecha</option>';
            slotIdInput.value = '';
        }

        // Show success message
        function showSuccess(message) {
            successContainer.textContent = message;
            successContainer.style.display = 'block';
            errorContainer.style.display = 'none';
            
            // Hide after 5 seconds
            setTimeout(() => {
                successContainer.style.display = 'none';
            }, 5000);
        }
        
        // Reset form errors
        function resetFormErrors() {
            // Hide error container
            errorContainer.style.display = 'none';
            
            // Reset all input validation states
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
                const errorElement = document.getElementById(input.id + '-error');
                if (errorElement) errorElement.textContent = '';
            });
        }

        // Función para mostrar errores
        function showError(message) {
            errorContainer.textContent = message;
            errorContainer.style.display = 'block';
            successContainer.style.display = 'none';
            
            // Ocultar el mensaje después de 5 segundos
            setTimeout(() => {
                errorContainer.style.display = 'none';
            }, 5000);
        }
        
        // Se mantiene modo estandar de calendario.
        calendarModeInput.value = 'standard';
        
        // Envio del formulario de cita publica.
        if (appointmentForm) {
            appointmentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validar formulario
                if (!validateForm()) {
                    return false;
                }
                
                // Reset form errors
                resetFormErrors();
                
                // Show loading state
                const submitButton = document.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';
                
                // Enviar el formulario
                const formData = new FormData(this);
                formData.append('_token', csrfToken);
                
                $.ajax({
                    url: '<?php echo e(route('public.appointment.store')); ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        // Restaurar estado del botón
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                        
                        if (data.success) {
                            // Success
                            showSuccess(data.message || '¡Cita agendada correctamente!');
                            
                            // Reset form
                            appointmentForm.reset();
                            if (typeof resetDatePicker === 'function') {
                                resetDatePicker();
                            }
                            if (typeof resetTimeSlots === 'function') {
                                resetTimeSlots();
                            }
                            
                            // Redirect to success page after 2 seconds
                            setTimeout(() => {
                                window.location.href = data.redirect || '/';
                            }, 2000);
                        } else {
                            // Error
                            if (data.errors) {
                                // Display field validation errors
                                for (const field in data.errors) {
                                    const errorElement = document.getElementById(field + '-error');
                                    if (errorElement) {
                                        document.getElementById(field).classList.add('is-invalid');
                                        errorElement.textContent = data.errors[field][0];
                                    }
                                }
                            }
                            
                            showError(data.message || 'Ha ocurrido un error al agendar la cita');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Restaurar estado del botón
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                        
                        console.error('Error:', xhr.responseText);
                        let errorMessage = 'Error de conexión';
                        try {
                            const response = xhr.responseJSON;
                            if (response) {
                                errorMessage = response.message || 'Error del servidor';
                                
                                // Mostrar detalles del error en consola para depuración
                                if (response.error_details) {
                                    console.error('Detalles del error:', response.error_details);
                                }
                                
                                // Si hay errores de validación, mostrarlos en los campos correspondientes
                                if (response.errors) {
                                    Object.keys(response.errors).forEach(field => {
                                        const errorElement = document.getElementById(field + '-error');
                                        const inputElement = document.getElementById(field);
                                        if (errorElement && inputElement) {
                                            inputElement.classList.add('is-invalid');
                                            errorElement.textContent = response.errors[field][0];
                                        }
                                    });
                                }
                            } else if (xhr.status === 500) {
                                errorMessage = 'Error interno del servidor. Por favor contacta al administrador.';
                            } else if (xhr.status === 419) {
                                errorMessage = 'La sesión ha expirado. Por favor recarga la página e intenta nuevamente.';
                            } else if (xhr.status === 429) {
                                errorMessage = 'Demasiadas solicitudes. Por favor espera unos minutos e intenta nuevamente.';
                            }
                        } catch (e) {
                            errorMessage = 'Error al procesar la solicitud: ' + error;
                        }
                        showError(errorMessage);
                    }
                });
            });
        } else {
            console.error('El formulario de citas no se encontró');
        }
        
        // Función para validar el formulario
        function validateForm() {
            let hasError = false;
            
            // Validar campos obligatorios
            const requiredFields = document.querySelectorAll('.required');
            requiredFields.forEach(field => {
                const input = field.querySelector('input, select');
                if (input && !input.value) {
                    input.classList.add('is-invalid');
                    const errorElement = document.getElementById(input.id + '-error');
                    if (errorElement) errorElement.textContent = 'Este campo es obligatorio';
                    hasError = true;
                }
            });
            
            if (!dateInput.value) {
                showError('Por favor selecciona una fecha para la cita');
                hasError = true;
            } else if (!timeSelect.value) {
                showError('Por favor selecciona una hora para la cita');
                hasError = true;
            }
            
            return !hasError;
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/public/appointments/create.blade.php ENDPATH**/ ?>