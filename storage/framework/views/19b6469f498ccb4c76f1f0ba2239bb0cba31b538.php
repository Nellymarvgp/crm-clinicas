<?php $__env->startSection('title'); ?> Buscar Doctor <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        /* Usar los mismos colores del tema principal */
        :root {
            --primary-color: #d1cba4;
            --secondary-color: #7c7c7b;
            --text-color: #7c7c7b;
            --bg-light: #f6f3e8;
        }

        .doctor-finder {
            margin-top: 82px; /* Mismo margen que PrimerBloque */
            padding: 50px 0;
            background-color: var(--bg-light);
        }

        .filters-section {
            background-color: var(--primary-color);
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .filters-section label {
            color: var(--text-color);
            font-weight: 500;
        }

        .filters-section .form-control,
        .filters-section .form-select {
            border: 1px solid rgba(255, 255, 255, 0.3);
            background-color: rgba(255, 255, 255, 0.9);
        }

        .doctor-card {
            background: #fff;
            border-radius: 10px;
            padding: 40px;
            margin-bottom: 30px;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .doctor-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 3px solid var(--primary-color);
        }

        .doctor-card h5 {
            color: var(--text-color);
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: 600;
        }

        .doctor-card .specialty {
            color: var(--secondary-color);
            font-weight: 500;
            margin-bottom: 15px;
            display: block;
        }

        .doctor-card p {
            color: var(--text-color);
            font-size: 14px;
            margin-bottom: 20px;
        }

        .view-schedule-btn {
            background: #d1cba4 !important;
            border: none !important;
            color: #7c7c7b !important;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px 0;
        }
        .view-schedule-btn:hover {
            background: #7c7c7b !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(124,124,123,0.3);
            color: #fff !important;
            text-decoration: none;
        }

        #scheduleModal .modal-content {
            border-radius: 15px;
            border: none;
        }
        #scheduleModal .modal-header {
            padding: 0;
        }
        #scheduleModal .doctor-info {
            padding: 0px;
        }
        #scheduleModal .avatar-xl {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 3px solid #d1cba4;
        }
        #scheduleModal .modal-title {
            color: #7c7c7b;
            position: relative;
            padding-bottom: 10px;
        }
        #scheduleModal .modal-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 2px;
            background: #d1cba4;
        }
        #scheduleModalBody ul {
            margin: 0;
            padding: 0;
        }
        #scheduleModalBody ul li {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #scheduleModalBody ul li:last-child {
            border-bottom: none;
        }
        #scheduleModalBody ul li strong {
            color: #7c7c7b;
        }
        #scheduleModalBody ul li span {
            color: #7c7c7b;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
            color: var(--text-color);
        }

        .section-title h2 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 16px;
            color: rgba(124, 124, 123, 0.85);
        }

        .time-slot {
            background-color: var(--primary-color) !important;
            color: var(--text-color);
            font-weight: 500;
            border-radius: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .time-slot:hover {
            background-color: var(--secondary-color) !important;
            color: #fff;
            transform: translateY(-2px);
        }

        .days-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin: 15px 0;
        }

        .days-grid .day {
            padding: 8px;
            text-align: center;
            background-color: #f5f5f5;
            border-radius: 5px;
            cursor: default;
            opacity: 0.5;
        }

        .days-grid .day.active {
            background-color: var(--primary-color);
            color: var(--text-color);
            opacity: 1;
            font-weight: 500;
        }

        /* Estilos para el horario */
        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
        }

        .day-column {
            text-align: center;
        }

        .day-column h6 {
            margin-bottom: 10px;
            padding: 5px;
            background-color: var(--primary-color);
            color: var(--text-color);
            border-radius: 5px;
        }

        .time-slots {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .time-slot {
            padding: 5px;
            background-color: #f8f9fa;
            border-radius: 4px;
            font-size: 12px;
            color: var(--text-color);
        }

        .time-slot:hover {
            background-color: var(--secondary-color);
            color: white;
            cursor: pointer;
        }

        .day-column.inactive {
            opacity: 0.5;
        }

        .day-column.inactive .time-slots {
            display: none;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="doctor-finder">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Encuentra tu Doctor</h2>
                <p>Selecciona el departamento y encuentra el especialista que necesitas</p>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="departmentFilter" class="form-label">Departamento</label>
                            <select class="form-select" id="departmentFilter">
                                <option value="">Todos los departamentos</option>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="searchDoctor" class="form-label">Buscar por nombre</label>
                            <input type="text" class="form-control" id="searchDoctor" placeholder="Nombre del doctor...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctors Grid -->
            <div class="row" id="doctorsGrid">
                <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-6 doctor-item" 
                         data-department="<?php echo e($doctor->department ? $doctor->department->id : ''); ?>">
                        <div class="doctor-card">
                            <?php if($doctor->user && $doctor->user->profile_photo): ?>
                                <img src="<?php echo e(URL::asset('storage/images/users/'.$doctor->user->profile_photo)); ?>" alt="Doctor Photo">
                            <?php else: ?>
                                <img src="<?php echo e(URL::asset('build/images/users/avatar-1.jpg')); ?>" alt="Default Photo">
                            <?php endif; ?>
                            <h5>Dr. <?php echo e($doctor->user ? $doctor->user->first_name.' '.$doctor->user->last_name : 'Doctor'); ?></h5>
                            <span class="specialty"><?php echo e($doctor->department ? $doctor->department->name : 'Departamento'); ?></span>
                            <a href="<?php echo e(url('/schedule-appointment')); ?>?doctor_id=<?php echo e($doctor->id); ?>" class="btn view-schedule-btn">
                                <i class="fas fa-calendar-alt me-2"></i>Agendar Cita
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Schedule Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pt-0">
                    <div class="doctor-info">
                        <img src="" alt="Doctor Photo" class="rounded-circle avatar-xl mb-3" id="modalDoctorPhoto">
                        <h4 class="mb-1" id="modalDoctorName"></h4>
                        <p class="text-muted" id="modalDoctorDept"></p>
                    </div>
                    <h5 class="modal-title mb-3">Horario de Atención</h5>
                    <div id="scheduleModalBody"></div>
                    <div class="mt-4">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="/schedule-appointment" class="btn view-schedule-btn" >
                                <i class="fas fa-calendar-alt me-2"></i>Agendar Cita
                            </a>
                        <?php else: ?>
                            <a href="/schedule-appointment" class="btn view-schedule-btn">
                                <i class="fas fa-sign-in-alt me-2"></i>Agendar Cita
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            // Filter doctors by department
            $('#departmentFilter').on('change', function() {
                var departmentId = $(this).val();
                filterDoctors();
            });

            // Filter doctors by name
            $('#searchDoctor').on('keyup', function() {
                filterDoctors();
            });

            function filterDoctors() {
                var departmentId = $('#departmentFilter').val();
                var searchText = $('#searchDoctor').val().toLowerCase();

                $('.doctor-item').each(function() {
                    var doctorDepartment = $(this).data('department');
                    var doctorName = $(this).find('h5').text().toLowerCase();
                    var showByDepartment = !departmentId || doctorDepartment == departmentId;
                    var showByName = !searchText || doctorName.includes(searchText);
                    
                    $(this).toggle(showByDepartment && showByName);
                });
            }

            // Handle schedule modal
            $('.view-schedule-btn').on('click', function() {
                const doctorId = $(this).data('doctor-id');
                const doctorName = $(this).data('doctor-name');
                const doctorPhoto = $(this).data('doctor-photo');
                const doctorDept = $(this).data('doctor-dept');
                const scheduleUrl = `/doctor/${doctorId}/schedule`;

                // Clear previous schedule and show loading message
                $('#scheduleModalBody').html('<p class="text-center">Cargando horario...</p>');
                $('#modalDoctorName').text(doctorName);
                $('#modalDoctorPhoto').attr('src', doctorPhoto);
                $('#modalDoctorDept').text(doctorDept);

                $.ajax({
                    url: scheduleUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let scheduleHtml = '';
                        if (response.schedule && Object.keys(response.schedule).length > 0) {
                            scheduleHtml += '<ul class="list-unstyled">';
                            const daysOrder = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                            const daysSpanish = {
                                'mon': 'Lunes',
                                'tue': 'Martes',
                                'wed': 'Miércoles',
                                'thu': 'Jueves',
                                'fri': 'Viernes',
                                'sat': 'Sábado',
                                'sun': 'Domingo'
                            };

                            daysOrder.forEach(day => {
                                if (response.schedule[day] === 1 && response.slots[day] && response.slots[day].length > 0) {
                                    scheduleHtml += `<li class="mb-3"><strong>${daysSpanish[day]}:</strong> `;
                                    response.slots[day].forEach(slot => {
                                        scheduleHtml += `<span class="badge bg-light text-dark me-2">${slot.from} - ${slot.to}</span>`;
                                    });
                                    scheduleHtml += '</li>';
                                } else {
                                    scheduleHtml += `<li class="mb-3"><strong>${daysSpanish[day]}:</strong> <em>No disponible</em></li>`;
                                }
                            });
                            scheduleHtml += '</ul>';
                        } else {
                            scheduleHtml = '<p class="text-center">Horario no disponible para esta semana.</p>';
                        }
                        $('#scheduleModalBody').html(scheduleHtml);
                        
                        // Update appointment button
                        $('#scheduleAppointmentBtn').attr('href', `/appointment/create?doctor_id=${doctorId}`);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error fetching schedule:", textStatus, errorThrown);
                        // Clear schedule on error and show message
                        $('#scheduleModalBody').html('<p class="text-center text-danger">Error al cargar el horario. Por favor, inténtelo de nuevo.</p>');
                    }
                });
            });

            // Update modal with doctor info
            $('#scheduleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var doctorName = button.data('doctor-name');
                var doctorPhoto = button.data('doctor-photo');
                var doctorDept = button.data('doctor-dept');
                
                $('#modalDoctorName').text(doctorName);
                $('#modalDoctorPhoto').attr('src', doctorPhoto);
                $('#modalDoctorDept').text(doctorDept);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/doctor/find.blade.php ENDPATH**/ ?>