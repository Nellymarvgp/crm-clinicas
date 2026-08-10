/*
 Template Name: Doctorly - Hospital & Clinic Management Laravel System
 Author: Lndinghub(Themesbrand)
 File: Appointment
 */
$(document).ready(function() {

    function getCsrfToken() {
        return $("input[name='_token']").val() || $('#csrf_token_value').val() || $('meta[name="csrf-token"]').attr('content');
    }

    $('.dt').on('change', function() {
        //alert();
        $("#btn_create").removeAttr('disabled');
    });

    $('#btn_create').on('click', function(e) {
        e.preventDefault();
        var p_id = $('#myselect2').val();
        var date = $('#datepicker-autoclose').val();
        var time = $('#timepicker1').val();
        //alert(time);

        $.ajax({
            type: 'POST',
            url: '../user_operation/chkappointment',
            dataType: 'json',
            data: {
                p_id: p_id,
                date: date,
                time: time
            },
            success: function(data) {
                if (data.status == 1) {
                    $(".status").css('color', 'red');
                    $(".status").text("Appointment booked on this day");
                    $("#btn_create").prop('disabled', 'true');
                } else if (data.status == 2) {
                    $(".status").css('color', 'red');
                    $(".status").text("Time slot allocated to other patient");
                } else {
                    $(".status").css('color', 'green');
                    $(".status").text("Appointment booked Successfully");
                }
            },
            error: function(data) {
                alert('oops! Something Went Wrong!!!');
            }
        });
    });

    $("#appointment_form").on("submit", function(e) {
        e.preventDefault();
        var route = $('#appointment_form').data('route');
        var form_data = $(this);
        $.ajax({
            type: 'POST',
            url: route,
            data: form_data.serialize(),
            success: function(response) {
                if (response.status == 'error') {
                    $(".status").css('color', 'red');
                    $(".status").text(response.message);
                    console.log(response.message);
                } else {
                    $(".status").css('color', 'green');
                    $(".status").text(response.message);
                }
            },
            error: function() {
                console.log("Something went Wrong!!!");
                $(".status").css('color', 'red');
                $(".status").text('Something went Wrong!!!');
            }
        });

    });

    $(document).on('click', '.complete', function(e) {
        var id = $(this).data('id');
        var token = getCsrfToken();
        var status = 1;
        var finalAmountInput = prompt('Ingrese el monto final de la cita:', '0');

        if (finalAmountInput === null) {
            return;
        }

        var finalAmount = parseFloat(String(finalAmountInput).replace(',', '.'));
        if (isNaN(finalAmount) || finalAmount < 0) {
            toastr.error('Debe ingresar un monto válido mayor o igual a 0.');
            return;
        }

        $(this).attr('disabled', true);

        if (confirm('¿Seguro que deseas completar la cita?')) {

            $.ajax({
                type: "post",
                url: "/appointment-status/" + id,
                data: { 'appointment_id': id, '_token': token, 'status': status },
                beforeSend: function() {
                    $('#preloader').show()
                },
                success: function(response) {
                    $.ajax({
                        type: "post",
                        url: "/appointment-final-price/" + id,
                        data: {
                            _token: token,
                            final_consultation_price: finalAmount
                        },
                        success: function(priceResponse) {
                            toastr.success('Cita completada y monto final guardado.');
                            location.reload();
                        },
                        error: function(priceError) {
                            toastr.warning('La cita se completó, pero no se pudo guardar el monto final.');
                            location.reload();
                        }
                    });
                },
                error: function(response) {
                    $('.complete[data-id="' + id + '"]').attr('disabled', false);
                    toastr.error(response.responseJSON && response.responseJSON.Message ? response.responseJSON.Message : 'No se pudo completar la cita.');
                },
                complete: function() {
                    $('#preloader').hide();
                }
            });
        } else {
            $('.complete[data-id="' + id + '"]').attr('disabled', false);
        }
    });
    $(document).on('click', '.cancel', function(e) {
        var id = $(this).data('id');
        var token = getCsrfToken();
        var status = 2;
        $(this).attr('disabled', true);
        if (confirm('Are you sure you want to cancel appointment?')) {

            $.ajax({
                type: "post",
                url: "/appointment-status/" + id,
                data: { 'appointment_id': id, '_token': token, 'status': status },
                beforeSend: function() {
                    $('#pageloader').show();
                },
                success: function(response) {
                    toastr.success(response.Message);
                    $('.cancel[data-id="' + id + '"]').attr('disabled', false);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(response) {
                    $('.cancel[data-id="' + id + '"]').attr('disabled', false);
                    toastr.error(response.responseJSON.Message);
                },
                complete: function() {
                    $('#pageloader').hide();
                }
            });
        } else {
            $('.cancel[data-id="' + id + '"]').attr('disabled', false);
        }
    });

});
