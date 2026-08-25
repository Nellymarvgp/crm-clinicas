<?php $__env->startSection('title'); ?><?php echo e(__('Update Patient')); ?><?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        <?php echo e(__('Update Patient Details')); ?>

                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php echo e(__('Update Patient Details')); ?>

                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="<?php echo e(url('/dashboard')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle me-2"></i><?php echo e(__('Back to Dashboard')); ?>

                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Basic Information')); ?></blockquote>
                        <form action="<?php echo e(url('profile-update')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('First Name ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="first_name" id="FirstName" tabindex="1"
                                                value="<?php if($patient): ?><?php echo e(old('first_name', $patient->first_name)); ?><?php elseif(old('first_name')): ?><?php echo e(old('first_name')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter First Name')); ?>">
                                            <?php $__errorArgs = ['first_name'];
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
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="formmessage"><?php echo e(__('Gender ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" tabindex="3"
                                                name="gender">
                                                <option selected disabled><?php echo e(__('-- Select Gender --')); ?></option>
                                                <option value="Male" <?php if(($patient_info && $patient_info->gender == 'Male') || old('gender') == 'Male'): ?> selected <?php endif; ?>><?php echo e(__('Male')); ?></option>
                                                <option value="Female" <?php if(($patient_info && $patient_info->gender == 'Female') || old('gender') == 'Female'): ?> selected <?php endif; ?>><?php echo e(__('Female')); ?>

                                                </option>
                                                <option value="Other" <?php if(($patient_info && $patient_info->gender == 'Other') || old('gender') == 'Other'): ?> selected <?php endif; ?>><?php echo e(__('Other')); ?></option>
                                            </select>
                                            <?php $__errorArgs = ['gender'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Email ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="5" name="email" id="patientEmail" value="<?php if($patient): ?><?php echo e(old('email', $patient->email)); ?><?php elseif(old('email')): ?><?php echo e(old('email')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Email')); ?>">
                                            <?php $__errorArgs = ['email'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Current Address ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <textarea id="formmessage" name="address" tabindex="7"
                                                class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"
                                                placeholder="<?php echo e(__('Enter Current Address')); ?>"><?php if($patient && $patient_info): ?><?php echo e($patient_info->address); ?><?php elseif(old('address')): ?><?php echo e(old('address')); ?><?php endif; ?></textarea>
                                            <?php $__errorArgs = ['address'];
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
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Last Name ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="2" name="last_name" id="LastName" value="<?php if($patient): ?><?php echo e(old('last_name', $patient->last_name)); ?><?php elseif(old('last_name')): ?><?php echo e(old('last_name')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Last Name')); ?>">
                                            <?php $__errorArgs = ['last_name'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Age ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="4" name="age" id="patientAge" value="<?php if($patient && $patient_info ): ?><?php echo e(old('age', $patient_info->age)); ?><?php elseif(old('age')): ?><?php echo e(old('age')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Age')); ?>">
                                            <?php $__errorArgs = ['age'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Contact Number ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" class="form-control <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="6" name="mobile" id="patientMobile"
                                                value="<?php if($patient): ?><?php echo e(old('mobile', $patient->mobile)); ?><?php elseif(old('mobile')): ?><?php echo e(old('mobile')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Contact Number')); ?>">
                                            <?php $__errorArgs = ['mobile'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Profile Photo ')); ?></label>
                                            <img class="<?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> "
                                                src="<?php if($patient && $patient->profile_photo != null): ?><?php echo e(URL::asset('storage/images/users/' . $patient->profile_photo)); ?><?php else: ?><?php echo e(URL::asset('build/images/users/noImage.png')); ?><?php endif; ?>" onclick="triggerClick()"
                                                data-bs-toggle="tooltip" data-placement="top"
                                                title="Click to Upload Profile Photo" id="profile_display" />
                                            <input type="file"
                                                class="form-control <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="8" name="profile_photo" id="profile_photo" style="display:none;"
                                                onchange="displayProfile(this)">
                                            <?php $__errorArgs = ['profile_photo'];
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
                            </div>
                            <blockquote><?php echo e(__('Medical Information')); ?></blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Height ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="height" tabindex="9" value="<?php if($patient && $patient_info && $medical_info): ?><?php echo e(old('height', $medical_info->height)); ?><?php elseif(old('height')): ?><?php echo e(old('height')); ?><?php endif; ?>"
                                                id="patientHeight" placeholder="<?php echo e(__('Enter Height In Centimeter')); ?>">
                                            <?php $__errorArgs = ['height'];
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
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="formmessage"><?php echo e(__('Blood Group ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['b_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="11" name="b_group">
                                                <option selected disabled><?php echo e(__('-- Select Blood Group --')); ?></option>
                                                <option value="A+" <?php if(($medical_info && $medical_info->b_group == 'A+') || old('b_group') == 'A+'): ?> selected <?php endif; ?>><?php echo e(__('A+')); ?></option>
                                                <option value="A-" <?php if(($medical_info && $medical_info->b_group == 'A-') || old('b_group') == 'A-'): ?> selected <?php endif; ?>><?php echo e(__('A-')); ?></option>
                                                <option value="B+" <?php if(($medical_info && $medical_info->b_group == 'B+') || old('b_group') == 'B+'): ?> selected <?php endif; ?>><?php echo e(__('B+')); ?></option>
                                                <option value="B-" <?php if(($medical_info && $medical_info->b_group == 'B-') || old('b_group') == 'B-'): ?> selected <?php endif; ?>><?php echo e(__('B-')); ?></option>
                                                <option value="O+" <?php if(($medical_info && $medical_info->b_group == 'O+') || old('b_group') == 'O+'): ?> selected <?php endif; ?>><?php echo e(__('O+')); ?></option>
                                                <option value="O-" <?php if(($medical_info && $medical_info->b_group == 'O-') || old('b_group') == 'O-'): ?> selected <?php endif; ?>><?php echo e(__('O-')); ?></option>
                                                <option value="AB+" <?php if(($medical_info && $medical_info->b_group == 'AB+') || old('b_group') == 'AB+'): ?> selected <?php endif; ?>><?php echo e(__('AB+')); ?></option>
                                                <option value="AB-" <?php if(($medical_info && $medical_info->b_group == 'AB-') || old('b_group') == 'AB-'): ?> selected <?php endif; ?>><?php echo e(__('AB-')); ?></option>
                                            </select>
                                            <?php $__errorArgs = ['b_group'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Pulse ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['pulse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="13" name="pulse" value="<?php if($patient && $patient_info && $medical_info): ?><?php echo e(old('pulse', $medical_info->pulse)); ?><?php elseif(old('pulse')): ?><?php echo e(old('pulse')); ?><?php endif; ?>"
                                                id="patientPulse" placeholder="<?php echo e(__('Enter Pulse')); ?>">
                                            <?php $__errorArgs = ['pulse'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Allergy ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['allergy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="15" name="allergy" id="patientAllergy"
                                                value="<?php if($patient && $patient_info && $medical_info): ?><?php echo e(old('allergy', $medical_info->allergy)); ?><?php elseif(old('allergy')): ?><?php echo e(old('allergy')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Allergy Symptoms')); ?>">
                                            <?php $__errorArgs = ['allergy'];
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
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Weight ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="10" name="weight" id="patientWeight"
                                                value="<?php if($patient && $patient_info && $medical_info): ?><?php echo e(old('weight', $medical_info->weight)); ?><?php elseif(old('weight')): ?><?php echo e(old('weight')); ?><?php endif; ?>" placeholder="<?php echo e(__('Enter Weight')); ?>">
                                            <?php $__errorArgs = ['weight'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Blood Pressure ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="tel"
                                                class="form-control <?php $__errorArgs = ['b_pressure'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="12" name="b_pressure" id="blood_pressure"
                                                value="<?php if($patient && $patient_info && $medical_info): ?><?php echo e(old('b_pressure', $medical_info->b_pressure)); ?><?php elseif(old('b_pressure')): ?><?php echo e(old('b_pressure')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Blood Pressure')); ?>">
                                            <?php $__errorArgs = ['b_pressure'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Respiration ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="tel"
                                                class="form-control <?php $__errorArgs = ['respiration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="14" name="respiration" id="patientRespiration"
                                                value="<?php if($patient && $patient_info && $medical_info): ?><?php echo e(old('respiration', $medical_info->respiration)); ?><?php elseif(old('respiration')): ?><?php echo e(old('respiration')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Respiration')); ?>">
                                            <?php $__errorArgs = ['respiration'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Diet ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['diet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" tabindex="16"
                                                name="diet">
                                                <option selected disabled><?php echo e(__('-- Select Diet --')); ?></option>
                                                <option value="Vegetarian" <?php if(($medical_info && $medical_info->diet == 'Vegetarian') || old('diet') == 'Vegetarian'): ?> selected <?php endif; ?>>
                                                    <?php echo e(__('Vegetarian')); ?></option>
                                                <option value="Non-vegetarian" <?php if(($medical_info && $medical_info->diet == 'Non-vegetarian') || old('diet') == 'Non-vegetarian'): ?> selected <?php endif; ?>>
                                                    <?php echo e(__('Non-vegetarian')); ?></option>
                                                <option value="Vegan" <?php if(($medical_info && $medical_info->diet == 'Vegan') || old('diet') == 'Vegan'): ?> selected <?php endif; ?>><?php echo e(__('Vegan')); ?>

                                                </option>
                                            </select>
                                            <?php $__errorArgs = ['diet'];
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
                                <div class="col-md-12">
                                    <blockquote><?php echo e(__('Medical History')); ?></blockquote>
                                    <p class="text-muted mb-2"><?php echo e(__('All medical history fields are optional.')); ?></p>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Diabetes')); ?> <span class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['diabetes_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="diabetes_status">
                                                <option disabled selected><?php echo e(__('-- Select --')); ?></option>
                                                <option value="si" <?php if(($medical_info && $medical_info->diabetes_status == 'si') || old('diabetes_status') == 'si'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="no" <?php if(($medical_info && $medical_info->diabetes_status == 'no') || old('diabetes_status') == 'no'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                            <?php $__errorArgs = ['diabetes_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Diabetes controlled (yes/no)')); ?></label>
                                            <select class="form-control <?php $__errorArgs = ['diabetes_controlled'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="diabetes_controlled">
                                                <option value=""><?php echo e(__('-- Select --')); ?></option>
                                                <option value="si" <?php if(($medical_info && $medical_info->diabetes_controlled == 'si') || old('diabetes_controlled') == 'si'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="no" <?php if(($medical_info && $medical_info->diabetes_controlled == 'no') || old('diabetes_controlled') == 'no'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                            <?php $__errorArgs = ['diabetes_controlled'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Hypertension')); ?> <span class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['hypertension_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="hypertension_status">
                                                <option disabled selected><?php echo e(__('-- Select --')); ?></option>
                                                <option value="si" <?php if(($medical_info && $medical_info->hypertension_status == 'si') || old('hypertension_status') == 'si'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="no" <?php if(($medical_info && $medical_info->hypertension_status == 'no') || old('hypertension_status') == 'no'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                            <?php $__errorArgs = ['hypertension_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Hypertension controlled (yes/no)')); ?></label>
                                            <select class="form-control <?php $__errorArgs = ['hypertension_controlled'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="hypertension_controlled">
                                                <option value=""><?php echo e(__('-- Select --')); ?></option>
                                                <option value="si" <?php if(($medical_info && $medical_info->hypertension_controlled == 'si') || old('hypertension_controlled') == 'si'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="no" <?php if(($medical_info && $medical_info->hypertension_controlled == 'no') || old('hypertension_controlled') == 'no'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                            <?php $__errorArgs = ['hypertension_controlled'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Currently pregnant')); ?> <span class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['currently_pregnant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="currently_pregnant">
                                                <option disabled selected><?php echo e(__('-- Select --')); ?></option>
                                                <option value="si" <?php if(($medical_info && $medical_info->currently_pregnant == 'si') || old('currently_pregnant') == 'si'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="no" <?php if(($medical_info && $medical_info->currently_pregnant == 'no') || old('currently_pregnant') == 'no'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                            <?php $__errorArgs = ['currently_pregnant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Heart attack history')); ?> <span class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['heart_attack_history'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="heart_attack_history">
                                                <option disabled selected><?php echo e(__('-- Select --')); ?></option>
                                                <option value="si" <?php if(($medical_info && $medical_info->heart_attack_history == 'si') || old('heart_attack_history') == 'si'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="no" <?php if(($medical_info && $medical_info->heart_attack_history == 'no') || old('heart_attack_history') == 'no'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                            <?php $__errorArgs = ['heart_attack_history'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('When was the last heart attack?')); ?></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['last_heart_attack'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="last_heart_attack" value="<?php if($medical_info): ?><?php echo e(old('last_heart_attack', $medical_info->last_heart_attack)); ?><?php else: ?><?php echo e(old('last_heart_attack')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Example: 2 years ago')); ?>">
                                            <?php $__errorArgs = ['last_heart_attack'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Currently taking medications')); ?> <span class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['takes_medications'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="takes_medications">
                                                <option disabled selected><?php echo e(__('-- Select --')); ?></option>
                                                <option value="si" <?php if(($medical_info && $medical_info->takes_medications == 'si') || old('takes_medications') == 'si'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="no" <?php if(($medical_info && $medical_info->takes_medications == 'no') || old('takes_medications') == 'no'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                            <?php $__errorArgs = ['takes_medications'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Which medications?')); ?></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['medications_list'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="medications_list" value="<?php if($medical_info): ?><?php echo e(old('medications_list', $medical_info->medications_list)); ?><?php else: ?><?php echo e(old('medications_list')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Describe medications')); ?>">
                                            <?php $__errorArgs = ['medications_list'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Aspirin in the last 72 hours')); ?> <span class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['aspirin_last_72h'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="aspirin_last_72h">
                                                <option disabled selected><?php echo e(__('-- Select --')); ?></option>
                                                <option value="si" <?php if(($medical_info && $medical_info->aspirin_last_72h == 'si') || old('aspirin_last_72h') == 'si'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="no" <?php if(($medical_info && $medical_info->aspirin_last_72h == 'no') || old('aspirin_last_72h') == 'no'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                            <?php $__errorArgs = ['aspirin_last_72h'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Do you have any disease?')); ?> <span class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['has_disease'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="has_disease">
                                                <option disabled selected><?php echo e(__('-- Select --')); ?></option>
                                                <option value="si" <?php if(($medical_info && $medical_info->has_disease == 'si') || old('has_disease') == 'si'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="no" <?php if(($medical_info && $medical_info->has_disease == 'no') || old('has_disease') == 'no'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                            <?php $__errorArgs = ['has_disease'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e(__('Which disease?')); ?></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['disease_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="disease_details" value="<?php if($medical_info): ?><?php echo e(old('disease_details', $medical_info->disease_details)); ?><?php else: ?><?php echo e(old('disease_details')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Describe the disease')); ?>">
                                            <?php $__errorArgs = ['disease_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Update  Details')); ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var fieldsToHide = ['height', 'b_group', 'pulse', 'allergy', 'weight', 'b_pressure', 'respiration', 'diet'];

                fieldsToHide.forEach(function(fieldName) {
                    var field = document.querySelector('[name="' + fieldName + '"]');
                    if (field) {
                        field.disabled = true;
                        var wrapper = field.closest('.mb-3');
                        if (wrapper) {
                            wrapper.style.display = 'none';
                        }
                    }
                });

                var blockquotes = document.querySelectorAll('blockquote');
                blockquotes.forEach(function(bq) {
                    if (bq.textContent.trim() === 'Medical Information') {
                        bq.style.display = 'none';
                    }
                });
            });

            // Profile Photo
            function triggerClick() {
                document.querySelector('#profile_photo').click();
            }

            function displayProfile(e) {
                if (e.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector('#profile_display').setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(e.files[0]);
                }
            }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\patient\patient-edit.blade.php ENDPATH**/ ?>