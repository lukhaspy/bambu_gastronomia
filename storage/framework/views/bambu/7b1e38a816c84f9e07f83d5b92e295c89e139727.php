

<?php $__env->startSection('content'); ?>
    <div class="col-lg-4 col-md-6 ml-auto mr-auto">
        <form class="form" method="post" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <div class="card card-login card-white">
                <div class="card-header ">
                    <img src="<?php echo e(asset('assets')); ?>/img/header.png" class="ml-4"   alt="">
                    <p class="card-title mb-5"></p>
                </div>
                <div class="card-body">
                    <div class="input-group<?php echo e($errors->has('email') ? ' has-danger' : ''); ?>">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-email-85"></i>
                            </div>
                        </div>
                        <input type="email" name="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" placeholder="Email">
                        <?php echo $__env->make('alerts.feedback', ['field' => 'email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="input-group<?php echo e($errors->has('password') ? ' has-danger' : ''); ?>">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-lock-circle"></i>
                            </div>
                        </div>
                        <input type="password" placeholder="Clave" name="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>">
                        <?php echo $__env->make('alerts.feedback', ['field' => 'password'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" href="" class="btn btn-primary btn-lg btn-block mb-3">Log in</button>
                    <!--<div class="pull-left">
                        <h6>
                            <a href="<?php echo e(route('register')); ?>" class="link footer-link">Create Account</a>
                        </h6>
                    </div>-->
                    
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['class' => 'login-page', 'page' => 'Bambu Gastronomia', 'contentClass' => 'login-page', 'section' => 'auth'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\laragon\www\bambu_gastronomia\resources\views/auth/login.blade.php ENDPATH**/ ?>