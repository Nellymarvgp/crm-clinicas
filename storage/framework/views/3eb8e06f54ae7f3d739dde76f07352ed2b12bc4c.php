<?php $__env->startSection('title'); ?>
    <?php echo e(__('Agendar Cita')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- Calender -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/fullcalendar/fullcalendar.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(URL::asset('build/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(URL::asset('build/libs/bootstrap-timepicker/bootstrap-timepicker.min.css')); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/datatables/datatables.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- start page title -->
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?>
            Agendar Cita
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?>
            Panel
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?>
            Cita Agendada
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <a href="<?php echo e(url('/appointment/create')); ?>" class="btn btn-primary text-white waves-effect waves-light mb-4">
                <i class="mdi mdi-arrow-left  font-size-16 align-middle me-2"></i> <?php echo e(__('Volver')); ?>

            </a>
            <a href="<?php echo e(url('/pending-appointment')); ?>" class="btn btn-outline-primary waves-effect waves-light mb-4 ms-2">
                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> <?php echo e(__('Ver Citas')); ?>

            </a>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <blockquote><?php echo e(__('Agendar Cita')); ?></blockquote>
                    <form action="<?php echo e(url('appointment-store')); ?>" id="" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php if($role != 'patient'): ?>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="control-label"><?php echo e(__('Paciente ')); ?><span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2 <?php $__errorArgs = ['appointment_for'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="appointment_for" id="patient">
                                        <option hidden selected disabled><?php echo e(__('Seleccione')); ?></option>
                                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($patient->id); ?>"><?php echo e($patient->first_name); ?>

                                                <?php echo e($patient->last_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['appointment_for'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="appointment_for" value="<?php echo e($user->id); ?>">
                        <?php endif; ?>
                        <?php if($role != 'doctor'): ?>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="control-label"><?php echo e(__('Odontólogo ')); ?><span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="form-control select2 sel-doctor <?php $__errorArgs = ['appointment_with'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="appointment_with" id="doctor">
                                        <option hidden selected disabled><?php echo e(__('Seleccione')); ?></option>
                                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($doctor->doctor->id); ?>"
                                                <?php echo e(old('appointment_with') == $doctor->doctor->id ? 'selected' : ''); ?>>
                                                <?php echo e($doctor->first_name); ?>

                                                <?php echo e($doctor->last_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['appointment_with'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="appointment_with" value="<?php echo e(@$user->doctor->id); ?>" id="doctor">
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="control-label"><?php echo e(__('Fecha ')); ?><span class="text-danger">*</span></label>
                                <div class="input-group datepickerdiv">
                                    <input type="text"
                                        class="form-control appointment-date <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="appointment_date" id="datepicker" data-provide="datepicker"
                                        data-date-autoclose="true" autocomplete="off"
                                        <?php echo e(old('appointment_date', date('Y-m-d'))); ?>>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                    <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <?php if($role !== 'doctor'): ?>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="" class="d-block"><?php echo e(__('Horario Disponible')); ?><span
                                            class="text-danger">*</span></label>
                                    <div class="btn-group availble_time" role="group">


                                    </div>
                                    <?php $__errorArgs = ['available_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php if($errors->has('available_time')): ?>
                                        <div class="error " role="alert">
                                            <?php echo e($errors->first('available_time')); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif($role == 'doctor'): ?>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="" class="d-block"><?php echo e(__('Horario Disponible')); ?> <span
                                            class="text-danger">*</span></label>
                                    <div class="btn-group availble_time" role="group">
                                        <?php $__currentLoopData = $doctor_available_time; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="btn btn-outline-secondary me-2">
                                                <input type="radio" name="available_time"
                                                    class="btn-check available-time <?php $__errorArgs = ['available_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e($item->id); ?>">
                                                <?php echo e($item->from . ' a ' . $item->to); ?>

                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php $__errorArgs = ['available_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php if($errors->has('available_time')): ?>
                                        <div class="error " role="alert">
                                            <?php echo e($errors->first('available_time')); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="" class="d-block"><?php echo e(__('Horario Disponible')); ?><span
                                        class="text-danger">*</span></label>
                                <div class="btn-group availble_slot d-block" role="group">
                                    <small class="text-muted d-block mb-2">Puedes seleccionar una o varias horas consecutivas.</small>
                                    <?php $__errorArgs = ['available_slot'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php if($errors->has('available_slot')): ?>
                                        <div class="error " role="alert">
                                            <?php echo e($errors->first('available_slot')); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo e(__('Crear Cita')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- Calender Js-->
    <script src="<?php echo e(URL::asset('build/libs/jquery-ui/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/moment/moment.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/fullcalendar/fullcalendar.min.js')); ?>"></script>
    <!-- Get App url in Javascript file -->
    <script type="text/javascript">
        var aplist_url = "<?php echo e(url('appointmentList')); ?>";
    </script>
    <!-- Init js-->
    <script src="<?php echo e(URL::asset('build/js/pages/form-advanced.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/appointment.js')); ?>"></script>
    <script>
        let datep = $('#datepicker');
        var roles = '<?php echo e($role); ?>';
        if (roles == 'doctor') {
            var day_doctor = '<?php echo e($dayArray); ?>';
            $(".datepickerdiv").prepend(datep);
            $('#datepicker').datepicker({
                startDate: new Date(),
                daysOfWeekDisabled: day_doctor
            });
        }

        function days(day) {
            $('#datepicker').remove();
            $(".datepickerdiv").prepend(datep);
            $('#datepicker').datepicker({
                startDate: new Date(),
                daysOfWeekDisabled: day
            });
        }
        $('.sel-doctor').change(function(e) {
            e.preventDefault();
            $('.day').removeClass('disabled disabled-date');
            $('.availble_time').empty();
            var doctorId = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                type: "post",
                url: "<?php echo e(route('doctor_by_day_time')); ?>",
                data: {
                    doctor_id: doctorId,
                    _token: token,
                },
                success: function(response) {
                    var res_data = response.data[0];
                    var day = [];
                    if (res_data !== null) {
                        if (res_data.sun == 0)
                            day.push(0);
                        if (res_data.mon == 0)
                            day.push(1);
                        if (res_data.tue == 0)
                            day.push(2);
                        if (res_data.wen == 0)
                            day.push(3);
                        if (res_data.thu == 0)
                            day.push(4);
                        if (res_data.fri == 0)
                            day.push(5);
                        if (res_data.sat == 0)
                            day.push(6);
                        days(day);
                    }
                    var availble_time = response.data[1];
                    if (availble_time.length === 0) {
                        $('.availble_time').append('<span class="text-muted">No hay horarios disponibles para este odontólogo.</span>');
                    } else {
                        var uniqueTimes = {};
                        $.each(availble_time, function(key, value) {
                            var timeKey = value.from + '|' + value.to;
                            if (uniqueTimes[timeKey]) {
                                return;
                            }
                            uniqueTimes[timeKey] = true;
                            $('.availble_time').append(
                                '<label class="btn btn-outline-secondary me-2 "><input type="radio" name="available_time" class="btn-check available-time <?php $__errorArgs = ['available_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="' +
                                value.id + '" >' + formatAppointmentTime(value.from) + ' a ' + formatAppointmentTime(value.to) + '</label>');
                        });
                    }
                    activeAvailableTime();
                },
                error: function(response) {
                    $('.availble_time').empty().append('<span class="text-danger">No se pudieron cargar los horarios disponibles.</span>');
                }
            });
        });
        // datepicker change
        $(document).on('change', '#datepicker', function() {
            $('.availble_slot').empty();
        });
        // doctor available time show
        $(document).on('click', '.available-time', function() {
            $('.availble_slot').empty();
            var token = $("input[name='_token']").val();
            var timeId = $(this).val();
            var dates = $('#datepicker').val();
            var doctorId = $("#doctor").val();
            $.ajax({
                type: "post",
                url: "<?php echo e(route('timeBySlot')); ?>",
                data: {
                    timeId: timeId,
                    _token: token,
                    dates: dates,
                    doctorId: doctorId
                },
                success: function(response) {
                    var available_slot = response.data[0];
                    var uniqueSlots = {};
                    $.each(available_slot, function(key, value) {
                        var slotKey = value.from + '|' + value.to;
                        if (uniqueSlots[slotKey]) {
                            return;
                        }
                        uniqueSlots[slotKey] = true;
                        if (value.appointment.length == 0) {
                            $('.availble_slot').append(
                                '<label class="btn btn-outline-secondary m-2"><input type="checkbox" name="available_slot[]" class="btn-check available-slot"  value="' +
                                value.id + '">' + formatAppointmentTime(value.from) + ' a ' + formatAppointmentTime(value.to) +
                                '</label>');
                        } else {
                            $('.availble_slot').append(
                                '<label class="btn alert-secondary m-2"><input type="checkbox" name="available_slot[]" class="btn-check available-slot"  value="' +
                                value.id + '" disabled>' + formatAppointmentTime(value.from) + ' a ' + formatAppointmentTime(value.to) +
                                '</label>');
                        }
                    });

                    // Slot checkboxes can remain selected at the same time.
                },
                error: function(error) {
                    console.log(error);
                    toastr.error('Something went wrong!', {
                        timeOut: 10000
                    });
                }
            });
        });

        function formatAppointmentTime(timeValue) {
            if (!timeValue) {
                return '';
            }

            var parts = String(timeValue).split(':');
            var hours = parseInt(parts[0], 10);
            var minutes = parts[1] || '00';
            var period = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12 || 12;

            return String(hours).padStart(2, '0') + ':' + minutes + period;
        }

        // available time activation
        function activeAvailableTime() {
            if ($(".availble_time").length) {
                $(".availble_time label").click(function() {
                    var activeLabel = $(".availble_time label.active");
                    if (activeLabel.length) {
                        activeLabel.removeClass("active");
                    }
                    $(this).addClass("active");
                });
            }
        }
            $(document).on('change', '.available-slot', function() {
                $(this).closest('label').toggleClass('active', this.checked);
            });
        activeAvailableTime();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/appointment/appointment_create.blade.php ENDPATH**/ ?>