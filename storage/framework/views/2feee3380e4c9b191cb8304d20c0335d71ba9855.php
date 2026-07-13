<?php $__env->startSection('title'); ?>
    <?php echo e(__('Invoice Details')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- start page title -->
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?>
            Invoice Details
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?>
            Dashboard
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?>
            Invoice List
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_3'); ?>
            Invoice Details
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <!-- end page title -->
    <div class="row d-print-none">
        <div class="col-12">
            <a href="<?php echo e(url('invoice-list')); ?>">
                <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                    <i class="bx bx-arrow-back font-size-16 align-middle me-2"></i><?php echo e(__('Back to Invoice List')); ?>

                </button>
            </a>
            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4">
                <i class="fa fa-print"></i>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-16"><?php echo e(__('Invoice #')); ?> <?php echo e($invoice_detail->id); ?></h4>
                        <div class="mb-4">
                            <img src="<?php echo e(URL::asset('build/images/logo-dark.png')); ?>" alt="logo" height="20" />
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-3">
                            <address>
                                <strong><?php echo e(__('Patient Details')); ?></strong><br>
                                <?php echo e($invoice_detail->patient->first_name . ' ' . $invoice_detail->patient->last_name); ?><br>
                                <i class="mdi mdi-phone"></i> <?php echo e($invoice_detail->patient->mobile); ?><br>
                                <i class="mdi mdi-email"></i> <?php echo e($invoice_detail->patient->email); ?><br>
                            </address>
                        </div>
                        <div class="col-3">
                            <address>
                                <strong><?php echo e(__('Doctor Details')); ?></strong><br>
                                <?php echo e($invoice_detail->doctor->user->first_name . ' ' . $invoice_detail->doctor->user->last_name); ?><br>
                                <i class="mdi mdi-phone"></i> <?php echo e($invoice_detail->doctor->user->mobile); ?><br>
                                <i class="mdi mdi-email"></i> <?php echo e($invoice_detail->doctor->user->email); ?><br>
                            </address>
                        </div>
                        <div class="col-3">
                            <address>
                                <strong><?php echo e(__('Payment Details')); ?></strong><br>
                                <?php echo e(__('Payment Mode :')); ?> <?php echo e($invoice_detail->payment_mode); ?><br>
                                <?php echo e(__('Payment Status :')); ?> <?php echo e($invoice_detail->payment_status); ?><br>
                                <?php if($invoice_detail->transaction != null): ?>
                                    <?php echo e(__('Order Id :')); ?> <?php echo e($invoice_detail->transaction->order_id); ?><br>
                                    <?php echo e(__('Transaction No:')); ?> <?php echo e($invoice_detail->transaction->transaction_no); ?><br>
                                    <?php echo e(__('Payment Method:')); ?> <?php echo e($invoice_detail->transaction->payment_method); ?><br>
                                <?php endif; ?>
                            </address>
                        </div>
                        <div class="col-3 pull-right">
                            <address>
                                <strong><?php echo e(__('Invoice date: ')); ?></strong><?php echo e($invoice_detail->created_at); ?><br>
                                <strong><?php echo e(__('Appointment date: ')); ?></strong><?php echo e($invoice_detail->appointment->appointment_date . ' ' . $invoice_detail->appointment->timeSlot->from . ' to ' . $invoice_detail->appointment->timeSlot->to); ?>

                            </address>
                        </div>
                    </div>
                    <div class="py-2 mt-3">
                        <h3 class="font-size-15 fw-bold"><?php echo e(__('Invoice summary')); ?></h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 70px;"><?php echo e(__('No.')); ?></th>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <th class="text-end"><?php echo e(__('Amount')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sub_total = 0;
                                ?>

                                <?php $__currentLoopData = $invoice_detail->invoice_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index + 1); ?></td>
                                        <td><?php echo e($item->title); ?></td>
                                        <td class="text-end">$<?php echo e($item->amount); ?></td>
                                    </tr>
                                    <?php
                                        $sub_total += $item->amount;
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="2" class="text-end"><?php echo e(__('Sub Total')); ?></td>
                                    <td class="text-end">$<?php echo e($sub_total); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border-0 text-end">
                                        <strong><?php echo e(__('Tax (5%)')); ?></strong>
                                    </td>
                                    <td class="border-0 text-end">$<?php echo e(($sub_total * 5) / 100); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border-0 text-end">
                                        <strong><?php echo e(__('Total')); ?></strong>
                                    </td>
                                    <td class="border-0 text-end">
                                        <h4 class="m-0">$<?php echo e($sub_total + ($sub_total * 5) / 100); ?></h4>
                                        <?php $sum=$sub_total + ($sub_total * 5) / 100 ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border-0 text-end">
                                        <?php if($invoice_detail->payment_status == 'Unpaid'): ?>
                                            <div class="row justify-content-end">
                                                
                                                
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    Payment
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <span class="btn btn-success btn-sm btn-rounded waves-effect waves-light"
                                                style="display: inline;">Paid</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Choose payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="chekout" method="POST" action="/stripe/<?php echo e($invoice_detail->id); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="">
                            <ul class="cart-total list-unstyled d-none">
                                <li>
                                    <span>Total</span>
                                    <span class="cart-total__total">$<?php echo e($sum); ?></span>
                                </li>
                            </ul>
                            <div class="cart-page__buttons text-center">
                                <button class="btn btn-primary btn-lg w-100">
                                    <i class="btn-curve"></i>
                                    <span class="btn-title">Stripe</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <form id="chekout" method="POST" action="/razorpay-payment/<?php echo e($invoice_detail->id); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mt-2">
                            <ul class="cart-total list-unstyled d-none">
                                <li>
                                    <span>Total</span>
                                    <span class="cart-total__total">$<?php echo e($sum); ?></span>
                                </li>
                            </ul>
                            <div class="cart-page__buttons text-center">
                                <button class="btn btn-primary btn-lg w-100">
                                    <i class="btn-curve"></i>
                                    <span class="btn-title">Razorpay</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\patient\patient-invoice-view.blade.php ENDPATH**/ ?>