<!doctype html>
<html>
​
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Invoice  | <?php echo e(AppSetting('title')); ?></title>
</head>
​
<body style="background-color:#f0f3fc; padding: 20px 0px;">
    <div style="margin: 50px 0px;">
​
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
                                    <td style="padding-bottom: 10px; color: #161c2d; font-size: 18px; ">
                                        Hello, <b><?php echo e($invoice->patient->first_name .' '.$invoice->patient->last_name); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Doctor Details: </b></td>
                                    <td><b>Invoice Date&Time: </b></td>
                                </tr>
                                <tr>
                                    <td><b>Name: </b><?php echo e(@$invoice->doctor->user->first_name .' '. @$invoice->doctor->user->last_name); ?></td>
                                    <td><?php echo e($invoice->created_at); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Contact: </b><?php echo e(@$invoice->doctor->user->mobile); ?></td>
                                    <td><b>Appointment Date&Time: </b></td>
                                </tr>
                                <tr>
                                    <td><b>Email: </b><?php echo e(@$invoice->doctor->user->email); ?></td>
                                    <td><?php echo e($invoice->appointment->appointment_date); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php echo e($invoice->appointment->timeSlot->from .' to '.$invoice->appointment->timeSlot->to); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px 24px 10px; color: #161c2d; font-size: 18px; font-weight: 600;">
                        Bellow you can find your invoice
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 24px 24px 24px;">
                        <div style="display: block; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                <tbody>
                                    <tr style="background-color: rgba(47,117,208, 0.1); color: #2f75d0; overflow-x: hidden;">
                                        <td style="text-align: left; padding: 12px; border-top: 1px solid #dee2e6; ">
                                            <b>Title</b>
                                        </td>
                                        <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6;">
                                            <b>Amount</b>
                                        </td>
                                    </tr>
                                    <?php
                                        $discount_amount = 0;
                                    ?>
                                    <?php if($invoice->invoice_detail): ?>
                                        <?php
                                            $sub_total = 0;
                                        ?>
                                        <?php $__currentLoopData = $invoice->invoice_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td style="text-align: left; padding: 12px; border-top: 1px solid #dee2e6;">
                                                        <br/>
                                                        <?php echo e($key+1); ?>.
                                                    <b><?php echo e($item->title); ?></b>
                                                </td>
                                                <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6;">
                                                    $<?php echo e($item->amount); ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $sub_total += $item->amount;
                                        ?>
                                    <?php endif; ?>
                                    <tr>
                                        <td style="text-align: center; padding: 12px; border-top: 1px solid #dee2e6;">
                                            <strong><?php echo e(__("Sub Total")); ?></strong>
                                        </td>
                                        <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6;">
                                            $<?php echo e($item->amount); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center; padding: 12px; ">
                                            <strong><?php echo e(__("Tax (5%)")); ?></strong>
                                        </td>
                                        <td style="text-align: end; padding: 12px;;">
                                            $<?php echo e(($sub_total * 5) / 100); ?>

                                        </td>
                                    </tr>
                                    <tr style="background-color: rgba(47,117,208, 0.1); color: #2f75d0; overflow-x: hidden;">
                                        <th scope="row" style="text-align: center; padding: 12px; border-top: 1px solid rgba(47,117,208, 0.1);">
                                            Total
                                        </th>
                                        <td style="text-align: end; font-weight: 700; font-size: 18px; padding: 12px; border-top: 1px solid rgba(47,117,208, 0.1);">
                                            $<?php echo e($sub_total + ($sub_total * 5) / 100); ?>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 24px 15px;  font-size: 16px;">
                        <b>Payment Method: </b><?php echo e($invoice->payment_mode); ?>

                    </td>
                </tr>

                <tr>
                    <td style="padding: 15px 24px 15px;  font-size: 16px;">
                        <b>Payment Status: </b><?php echo e($invoice->payment_status); ?>

                    </td>

                </tr>
                <?php if($invoice->transaction != Null): ?>
                    <td style="padding: 15px 24px 15px;  font-size: 16px;">
                        <b>Order Id: </b><?php echo e($invoice->transaction->order_id); ?><br>
                        <b>Transaction No: </b><?php echo e($invoice->transaction->transaction_no); ?><br>
                        <b>Payment Method: </b><?php echo e($invoice->transaction->payment_method); ?><br>
                    </td>
                <?php endif; ?>
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
​
    </div>
</body>
​
</html>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\emails\invoice.blade.php ENDPATH**/ ?>