<!doctype html>
<html>
​
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Payment complete successfully  | <?php echo e(AppSetting('title')); ?></title>
</head>
<body style="background-color:#f0f3fc; padding: 20px 0px;">
    <div style="margin: 50px 0px;">
        <table cellpadding="0" cellspacing="0" style="font-size: 15px; font-weight: 400; max-width: 700px; border: none; margin: 0 auto; border-radius: 6px; overflow: hidden; background-color: #fff; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15); width:50%; ">
            <thead>
                <tr style="background-color: #242e4d; border: none; height: 70px; font-size: 32px;">
                    <th scope="col">
                        <img src="<?php echo e(URL::asset('build/images/logo-light1.png')); ?>" alt="<?php echo e(AppSetting('title')); ?>"
                            title="<?php echo e(AppSetting('title')); ?>" style="height: 24px;" />
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
                                        Appointment Cancel
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Doctor Details: </b></td>
                                    <td style="padding-top:10px;"><b>Patient Details: </b></td>

                                </tr>
                                <tr>
                                    <td><b>Name: </b><?php echo e($MailAppointment->doctor->user->first_name .' '. $MailAppointment->doctor->user->last_name); ?></td>
                                    <td><b>Name: </b><?php echo e($MailAppointment->patient->first_name .' '. $MailAppointment->patient->last_name); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Contact: </b><?php echo e($MailAppointment->doctor->user->mobile); ?></td>
                                    <td><b>Contact: </b><?php echo e($MailAppointment->patient->mobile); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Email: </b><?php echo e($MailAppointment->doctor->user->email); ?></td>
                                    <td><b>Email: </b><?php echo e($MailAppointment->patient->email); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding-top:10px;"><b>Cancel By: </b></td>
                                </tr>
                                <tr>
                                    <td><b>Name: </b><?php echo e($CancelBy->first_name .' '. $CancelBy->last_name); ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Contact: </b><?php echo e($CancelBy->mobile); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Email: </b><?php echo e($CancelBy->email); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <table border="1" width="100%">
                            <thead>
                                <tr>
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo e($MailAppointment->appointment_date); ?></td>
                                    <td><?php echo e($MailAppointment->timeSlot->from .' to '. $MailAppointment->timeSlot->to); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 24px 15px; color: #8492a6; font-size: 16px; font-weight: 600;">
                        Thank you
                    </td>
                </tr>

                <tr>
                    <td style="padding: 15px 24px 15px; color: #8492a6;">
                        <?php echo e(AppSetting('title')); ?> <br> Support Team
                    </td>
                </tr>
                <tr>
                    <td style="padding: 16px 8px; color: #8492a6; background-color: #f8f9fc; text-align: center;">
                        <?php echo Config::get('app.footer_copy_rights') ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
​
</html>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\emails\appointment_cancel.blade.php ENDPATH**/ ?>