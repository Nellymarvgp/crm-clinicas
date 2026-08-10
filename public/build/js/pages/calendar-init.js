/*
 Template Name: Doctorly - Hospital & Clinic Management Laravel System
 Author: Lndinghub(Themesbrand)
 File: Calendar Init
 */


!function ($) {
    "use strict";
    var CalendarPage = function () { };

    CalendarPage.prototype.init = function () {
        moment.locale('es');
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        function formatTimeValue(value) {
            if (!value) {
                return '';
            }
            var parsed = moment(value, ['HH:mm:ss', 'HH:mm']);
            return parsed.isValid() ? parsed.format('HH:mm') : value;
        }

        function formatTimeRange(from, to) {
            var fromText = formatTimeValue(from);
            var toText = formatTimeValue(to);
            if (!fromText) {
                return 'Sin horario';
            }
            return toText ? (fromText + ' a ' + toText) : fromText;
        }

        function getStatusLabel(status) {
            var parsedStatus = parseInt(status, 10);
            if (parsedStatus === 1) {
                return 'Completada';
            }
            if (parsedStatus === 2) {
                return 'Cancelada';
            }
            return 'Pendiente';
        }

        function getStatusBadge(status) {
            var parsedStatus = parseInt(status, 10);
            if (parsedStatus === 1) {
                return '<span class="badge badge-pill text-white" style="background-color:#198754;">Completada</span>';
            }
            if (parsedStatus === 2) {
                return '<span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelada</span>';
            }
            return '<span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>';
        }

        function getActionButtonsByStatus(appointmentId, status) {
            var parsedStatus = parseInt(status, 10);
            var html = "<a class='btn btn-primary btn-sm mb-1' href='/appointment-view/" + appointmentId + "'>Ver</a>";

            if (parsedStatus !== 1) {
                html += " <button type='button' class='btn btn-success btn-sm complete mb-1' data-id='" + appointmentId + "'>Completar</button>";
                html += " <button type='button' class='btn btn-danger btn-sm cancel mb-1' data-id='" + appointmentId + "'>Cancelar</button>";
            }

            return html;
        }

        function getCalendarEventColors(status) {
            var parsedStatus = parseInt(status, 10);
            if (parsedStatus === 1) {
                return {
                    backgroundColor: '#198754',
                    borderColor: '#198754',
                    textColor: '#ffffff'
                };
            }
            if (parsedStatus === 2) {
                return {
                    backgroundColor: '#dc3545',
                    borderColor: '#dc3545',
                    textColor: '#ffffff'
                };
            }
            return {
                backgroundColor: '#0dcaf0',
                borderColor: '#0dcaf0',
                textColor: '#ffffff'
            };
        }

        /*  className colors
    
         className: default(transparent), important(red), chill(pink), success(green), info(blue)
    
         */


        /* initialize the external events
         -----------------------------------------------------------------*/

        

        /* initialize the calendar
         -----------------------------------------------------------------*/
         var calendarEl = document.getElementById('calendar');

        var SITEURL = "{{url('/')}}"
        var calendar = new FullCalendar.Calendar(calendarEl, {
            editable: true,
            droppable: true,
            selectable: true,
            initialView: 'dayGridMonth',
            locale: 'es',
            themeSystem: 'bootstrap',
            weekNumbers: true,
            headerToolbar: {
                left: 'prev,next today',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
                center: 'title',
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Lista'
            },
            // firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
            longPressDelay: 1,
            events: SITEURL + "/cal-appointment-show",
            // displayEventTime: true,
            dayMaxEventRows: true, // for all non-TimeGrid views
            // allDaySlot: false,
            views: {
                timeGrid: {
                    dayMaxEventRows: 5 // adjust to 6 only for timeGridWeek/timeGridDay
                }
            },
            select: function (date) {
                var start = date.start;
                var dt = moment(start).format('YYYY-MM-DD');
                $('#selected_date').html(moment(start).format('DD/MM/YYYY'));
                $('#appointment_list').hide();
                $('#new_list').show();
                $.ajax({
                    method: 'get',
                    url: aplist_url,
                    data: { date: dt },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 'error') {
                            $('#new_list').html('<h6>No se encontraron citas para ' + moment(start).format('DD/MM/YYYY') + '</h6>');
                        } else {
                            var t = 1;
                            var data = response.appointments;
                            var list = '<table class="table table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"><thead class="thead-light"><tr><th>Nro.</th>';
                            if (response.role == 'doctor') {
                                list += '<th>Nombre del Paciente</th>';
                                list += '<th>Número del Paciente</th>';
                            } else if (response.role == 'patient') {
                                list += '<th>Nombre del Odontólogo</th>';
                                list += '<th>Número del Odontólogo</th>';
                            } else {
                                list += '<th>Nombre del Paciente</th><th>Nombre del Odontólogo</th>';
                                list += '<th>Número del Paciente</th>';
                            }

                            list += '<th>Hora</th><th>Estado</th></tr></thead><tbody>';
                            if (response.role == 'doctor' || response.role == 'receptionist' || response.role == 'admin') {
                                list = list.replace('</tr></thead><tbody>', '<th>Acción</th></tr></thead><tbody>');
                            }
                            if (response.role == 'receptionist') {

                                $.each(data, function (i, appointments) {
                                    let DFirst_name = appointments.doctor.user.first_name;
                                    let DLast_name = appointments.doctor.user.last_name;
                                    let PFirst_name = appointments.patient.first_name;
                                    let PLast_name = appointments.patient.last_name;
                                    let from = appointments.time_slot ? appointments.time_slot.from : 'Sin horario';
                                    let to = appointments.time_slot ? appointments.time_slot.to : '';
                                    let mobile = appointments.patient.mobile
                                    let timeText = formatTimeRange(from, to);
                                    let statusBadge = getStatusBadge(appointments.status);
                                    let actions = getActionButtonsByStatus(appointments.id, appointments.status);
                                    list += "<tr><td>" + t + "</td><td>" + DFirst_name + "&nbsp;" + DLast_name + "</td><td>" + PFirst_name + "&nbsp;" + PLast_name + "</td><td>" + mobile + "</td><td>" + timeText +
                                        "</td><td>" + statusBadge + "</td><td>" + actions + "</td></tr>";
                                    t++;
                                });

                            } else if (response.role == 'admin') {
                                $.each(data, function (i, appointments) {
                                    let DFirst_name = appointments.doctor && appointments.doctor.user ? appointments.doctor.user.first_name : '';
                                    let DLast_name = appointments.doctor && appointments.doctor.user ? appointments.doctor.user.last_name : '';
                                    let PFirst_name = appointments.patient ? appointments.patient.first_name : '';
                                    let PLast_name = appointments.patient ? appointments.patient.last_name : '';
                                    let from = appointments.time_slot ? appointments.time_slot.from : 'Sin horario';
                                    let to = appointments.time_slot ? appointments.time_slot.to : '';
                                    let mobile = appointments.patient ? appointments.patient.mobile : '';
                                    let timeText = formatTimeRange(from, to);
                                    let statusBadge = getStatusBadge(appointments.status);
                                    let actions = getActionButtonsByStatus(appointments.id, appointments.status);
                                    list += "<tr><td>" + t + "</td><td>" + PFirst_name + "&nbsp;" + PLast_name + "</td><td>" + DFirst_name + "&nbsp;" + DLast_name + "</td><td>" + mobile + "</td><td>" + timeText + "</td><td>" + statusBadge + "</td><td>" + actions + "</td></tr>";
                                    t++;
                                });

                            } else if (response.role == 'patient') {
                                $.each(data, function (i, appointments) {
                                    let first_name = appointments.doctor.user.first_name;
                                    let last_name = appointments.doctor.user.last_name;
                                    let from = appointments.time_slot ? appointments.time_slot.from : 'Sin horario';
                                    let to = appointments.time_slot ? appointments.time_slot.to : '';
                                    let mobile = appointments.doctor.user.mobile
                                    let timeText = formatTimeRange(from, to);
                                    let statusBadge = getStatusBadge(appointments.status);
                                    list += "<tr><td>" + t + "</td><td>" + first_name + "&nbsp;" + last_name + "</td><td>" + mobile + "</td><td>" + timeText +
                                        "</td><td>" + statusBadge + "</td></tr>";
                                    t++;
                                });

                            } else if (response.role == 'doctor') {
                                $.each(data, function (i, appointments) {
                                    let first_name = appointments.patient.first_name;
                                    let last_name = appointments.patient.last_name;
                                    let from = appointments.time_slot ? appointments.time_slot.from : 'Sin horario';
                                    let to = appointments.time_slot ? appointments.time_slot.to : '';
                                    let mobile = appointments.patient.mobile
                                    let timeText = formatTimeRange(from, to);
                                    let statusBadge = getStatusBadge(appointments.status);
                                    let actions = getActionButtonsByStatus(appointments.id, appointments.status);
                                    list += "<tr><td>" + t + "</td><td>" + first_name + "&nbsp;" + last_name + "</td><td>" + mobile + "</td><td>" + timeText +
                                        "</td><td>" + statusBadge + "</td><td>" + actions + "</td></tr>";
                                    t++;
                                });

                            }
                            list += "</tbody></table>";

                            $('#new_list').html(list);
                        }
                    },
                    error: function () {
                        console.log('Errors...Something went wrong!!!!');
                    }
                });
            },
            events: function (date, callback) {
                var start = moment(date.start).format('YYYY-MM-DD')
                var end = moment(date.end).format('YYYY-MM-DD')
                // console.log(start);
                $.ajax({
                    type: "get",
                    url: "/cal-appointment-show",
                    data: {
                        start: start,
                        end: end,
                        title: 'appointment',
                    },
                    success: function (response) {
                        var appEvents = [];
                        $(response.appointments).each(function (key, value) {
                            var statusLabel = getStatusLabel(value.status);
                            var badge = value.total_appointment == 1
                                ? (value.total_appointment + ' Cita ' + statusLabel)
                                : (value.total_appointment + ' Citas ' + statusLabel);
                            var colors = getCalendarEventColors(value.status);
                            appEvents.push({
                                title: badge,
                                start: value.appointment_date,
                                end: value.appointment_date,
                                backgroundColor: colors.backgroundColor,
                                borderColor: colors.borderColor,
                                textColor: colors.textColor,
                            });
                        });
                        callback(appEvents);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            },
        });
        calendar.render();
    }
    //init
    $.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage
}(window.jQuery),

    //initializing 
    function ($) {
        "use strict";
        $.CalendarPage.init()
    }(window.jQuery);