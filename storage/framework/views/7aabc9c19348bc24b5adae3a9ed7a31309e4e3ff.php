        <?php echo $__env->make('layouts.common-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;

        <?php echo $__env->yieldContent('script'); ?>
        <!-- App js -->
        <script src="<?php echo e(URL::asset('build/js/app.min.js')); ?>"></script>
        <script>
            <?php if(Session::has('success')): ?>
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.success("<?php echo e(session('success')); ?>");
            <?php endif; ?>
            <?php if(Session::has('error')): ?>
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                }
                toastr.error("<?php echo e(session('error')); ?>");
            <?php endif; ?>
            <?php if(Sentinel::getUser()): ?>
                function notifyCount() {
                    var load_count = $('.badge-pill').html();
                    var token = $("input[name='_token']").val();
                    $.ajax({
                        type: "get",
                        url: "/notification-count",
                        data: {
                            _token: token,
                        },
                        success: function(data) {
                            $('.badge-pill').html(data);
                            if (load_count < data) {
                                notificationShow();
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
                setInterval(function() {
                    notifyCount();
                }, 10000);
            <?php endif; ?>
            <?php if(Sentinel::getUser()): ?>
                function notificationShow() {
                    var token = $("input[name='_token']").val();
                    $.ajax({
                        type: "POST",
                        url: "/top-notification",
                        data: {
                            _token: token,
                        },
                        success: function(data) {
                            $('.notification-list-scroll').html(data.options);
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
                setInterval(function() {
                    notificationShow();
                }, 5000);
            <?php endif; ?>
        </script>
        <?php echo $__env->yieldContent('script-bottom'); ?>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\layouts\footer-script.blade.php ENDPATH**/ ?>