  

  <?php $__env->startSection('title'); ?>
      <?php echo e("R&R Property Reservation LLC.| Your Property, Our Priority :: Login"); ?>

  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('content'); ?>

<style type="text/css">
  .has-error{
    color: red;
  }
</style>

<!-- ================================================================================================================= -->
<!-- box-login -->

            <div class="box-login">
                <form class="form-login"
                    method="post" action="<?php echo e(route('auth.login.store')); ?>">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?> ">
        <?php if($errors->all()): ?>
          <div class="alert alert-danger">
            <ul>
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        <?php endif; ?>

        <?php if(Session::has('message')): ?>
          <div class="alert alert-info">
            <?php echo e(Session::get('message')); ?>

          </div>
        <?php endif; ?>


<fieldset>
    <legend>Sign in to your account</legend>
    <p>Please enter your name and password to log in.</p>
    <div class="form-group">
      <span class="input-icon">
        <input type="text" class="form-control <?php echo e($errors->has('email') ? 'has-error' : ''); ?>"
                name="email" id="email" placeholder="Email" value="<?php echo e(old('email')); ?>"> 
                <i class="fa fa-user"></i>
      </span>
      <span class="glyphicon glyphicon-envelope form-control-feedback" style="color:red"><?php echo e($errors->first('email')); ?></span>
    </div>


    <div class="form-group form-actions">
      <span class="input-icon">
        <input type="password"
                class="form-control password <?php echo e($errors->has('password') ? 'has-error' : ''); ?>" name="password" placeholder="Password"> 
                <i class="fa fa-lock"></i> 

      </span>
      <span class="glyphicon glyphicon-envelope form-control-feedback" style="color:red"><?php echo e($errors->first('password')); ?></span>
      </div>
    <div class="form-actions">
        <button type="submit"
        class="btn btn-primary pull-right">Login <i
        class="fa fa-arrow-circle-right"></i>
        </button>
    </div>
</fieldset>
                </form>








              <!-- footer area -->
                <div class="copyright"> <span
                        class="text-bold text-uppercase"></span> <span>All Rights Reserved By R&R Property Reservation LLC.</span>

                      <span>
                       &copy; <span class="current-year"></span> R&R Powered by <a href="https://synergyinterface.com/" target="_blank">Synergy Interface Ltd</a>
                    </span>
                      </div>
              <!-- footer area -->


                    

            </div>

            <!-- box-login -->


<!-- ================================================================================================================= -->



  <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.extra', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\php\angularlaravel\vizzclub\backend\resources\views/extra/login.blade.php ENDPATH**/ ?>