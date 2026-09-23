<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Nueva cita generada | {{ AppSetting('title') }}</title>
</head>
<body style="background-color:#f0f3fc; padding: 20px 0px;">
    <div style="margin: 50px 0px;">
        <table cellpadding="0" cellspacing="0" style="font-size: 15px; font-weight: 400; max-width: 700px; border: none; margin: 0 auto; border-radius: 6px; overflow: hidden; background-color: #fff; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15); width:50%; ">
            <thead>
                <tr style="background-color: #242e4d; border: none; height: 70px; font-size: 32px;">
                    <th scope="col">
                        <img src="{{ URL::asset('build/images/logo-light1.png') }}" alt="{{ AppSetting('title') }}"
                            title="{{ AppSetting('title') }}" style="height: 24px;" />
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 30px 24px 0; color: #161c2d; font-size: 18px;">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 30px 0px 10px; color: #829adb; font-size: 18px; font-weight: 600;">
                                        Nueva cita generada
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Detalles del doctor: </b></td>
                                    <td style="padding-top:10px;"><b>Detalles del paciente: </b></td>
                                </tr>
                                <tr>
                                    <td><b>Nombre: </b>{{ $MailAppointment->doctor->user->first_name .' '. $MailAppointment->doctor->user->last_name}}</td>
                                    <td><b>Nombre: </b>{{ $MailAppointment->patient->first_name .' '. $MailAppointment->patient->last_name}}</td>
                                </tr>
                                <tr>
                                    <td><b>Contacto: </b>{{ $MailAppointment->doctor->user->mobile }}</td>
                                    <td><b>Contacto: </b>{{ $MailAppointment->patient->mobile }}</td>
                                </tr>
                                <tr>
                                    <td><b>Correo: </b>{{ $MailAppointment->doctor->user->email }}</td>
                                    <td><b>Correo: </b>{{ $MailAppointment->patient->email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-top:10px;"><b>Reservada por: </b></td>
                                </tr>
                                <tr>
                                    <td><b>Nombre: </b>{{ $MailAppointment->BookedBy->first_name .' '. $MailAppointment->BookedBy->last_name}}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Contacto: </b>{{ $MailAppointment->BookedBy->mobile }}</td>
                                </tr>
                                <tr>
                                    <td><b>Correo: </b>{{ $MailAppointment->BookedBy->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <table border="1" width="100%">
                            <thead>
                                <tr>
                                    <th>Fecha de la cita</th>
                                    <th>Hora de la cita</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $MailAppointment->appointment_date }}</td>
                                    <td>{{ $MailAppointment->timeSlot->from .' a '. $MailAppointment->timeSlot->to  }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 24px 15px; color: #8492a6; font-size: 16px; font-weight: 600;">
                        Gracias
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 24px 15px; color: #8492a6;">
                        {{ AppSetting('title') }} <br> Equipo de soporte
                    </td>
                </tr>
                <tr>
                    <td style="padding: 16px 8px; color: #8492a6; background-color: #f8f9fc; text-align: center;">
                        @php echo Config::get('app.footer_copy_rights') @endphp
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
