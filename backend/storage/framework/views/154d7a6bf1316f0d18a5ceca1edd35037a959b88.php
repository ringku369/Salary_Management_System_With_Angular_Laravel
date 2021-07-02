<!DOCTYPE html>

<html lang="en">

<head>

        <!-- ==============================================
        Basic Page Needs
        =============================================== -->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->

        
        <title><?php echo $__env->yieldContent('title', '"R&R Property Reservation LLC.| Your Property, Our Priority"'); ?></title>

        <meta name="description" content="">
        <meta name="subject" content="">
        <meta name="author" content="">

        <!-- ==============================================
        Favicons
        =============================================== -->


        <link rel="shortcut icon" href="<?php echo e(asset('resources/lib/frontend/assets/images/favicon.png')); ?>">
        <link rel="apple-touch-icon" href="<?php echo e(asset('resources/lib/frontend/assets/images/apple-touch-icon.png')); ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('resources/lib/frontend/assets/images/apple-touch-icon-72x72.png')); ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('resources/lib/frontend/assets/images/apple-touch-icon-114x114.png')); ?>">

        <!-- ==============================================
        Vendor Stylesheet
        =============================================== -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="<?php echo e(asset('resources/lib/frontend/assets/css/vendor/bootstrap.min.css')); ?>">

        <link rel="stylesheet" href="<?php echo e(asset('resources/lib/frontend/assets/css/vendor/slider.min.css')); ?>">
        
        <link rel="stylesheet" href="<?php echo e(asset('resources/lib/frontend/assets/css/vendor/icons.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('resources/lib/frontend/assets/css/vendor/animation.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('resources/lib/frontend/assets/css/vendor/gallery.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('resources/lib/frontend/assets/css/vendor/cookie-notice.min.css')); ?>">

        <!-- ==============================================
        Custom Stylesheet
        =============================================== -->
        <link rel="stylesheet" href="<?php echo e(asset('resources/lib/frontend/assets/css/default.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('resources/lib/frontend/assets/css/theme-light-blue.css')); ?>">

        

        <link rel="stylesheet" href="<?php echo e(asset('resources/lib/frontend/assets/css/main.css')); ?>">






        <!-- ==============================================
        Theme Settings
        =============================================== -->
        <style>
            :root {
                --header-bg-color: #111111;
                --nav-item-color: #f5f5f5;
                --top-nav-item-color: #f5f5f5;
                --hero-bg-color: #000000;

                --section-1-bg-color: #f5f5f5;
                --section-2-bg-color: #eeeeee;
                --section-3-bg-color: #111111;
                --section-4-bg-color: #191919;
                --section-5-bg-color: #f5f5f5;
                --section-6-bg-color: #111111;

                --footer-bg-color: #191919;
            }
        </style>
        
    </head>

    <body>

        <!-- Header -->
        <header id="header">

<!-- top nav part================================ -->
<?php echo $__env->make('layouts.includes.topnav_guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- top nav part================================ -->
            

        </header>
        
<!-- slider nav part================================ -->
<!--include('layouts.includes.slider_guest')-->
<!-- slider nav part================================ -->




<!-- content part================================ -->

<?php echo $__env->yieldContent('content'); ?>

<!-- content part================================ -->

<!-- footer part================================ -->

        
<!-- Footer -->

<!-- Footer nav part================================ -->
<?php echo $__env->make('layouts.includes.footer_guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Footer nav part================================ -->

<!-- Modal nav part================================ -->
<?php echo $__env->make('layouts.includes.modal_guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Modal nav part================================ -->


 

<!-- ==============================================
Vendor Scripts
=============================================== -->
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/jquery.easing.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/jquery.inview.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/ponyfill.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/slider.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/animation.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/progress-radial.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/bricklayer.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/gallery.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/shuffle.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/cookie-notice.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/vendor/particles.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/lib/frontend/assets/js/main.js')); ?>"></script>

<!-- #endregion Global ========================= -->



<script type="text/javascript">

$('#registerForm').on('submit',function(event){
    event.preventDefault();
    let url = $(this).attr('action');
    let method = $(this).attr('method');
    let formdata = $(this).serialize();

    let success_area = $('.successMsg');
    let error_area = $('.errorMsg');
    let submitBtn = $('.submitBtn');

    let faLoader = $('.faLoader');

    submitBtn.attr({disabled: 'disabled'});
    faLoader.css({display: 'block'});

    $.ajax({
      url: url,
      type:method,
      data:formdata,
      success:function(response){
        faLoader.css({display: 'none'});
        submitBtn.removeAttr('disabled');
        success_area.find('.alert-success').remove();
        error_area.find('.alert-danger').remove();
        success_area.append(
          '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.success+'</div>'
          );

        $("#registerForm :input[type='text'], :input[type='email'], textarea[name='experience']").val('');
      },
      error: function(xhr,status,error ) {
        faLoader.css({display: 'none'});
        submitBtn.removeAttr('disabled');
        errorMsg(xhr.responseJSON,error_area);
      }

    });

    function errorMsg(msg,errorArea){
      success_area.find('.alert-success').remove();
      errorArea.find('.alert-danger').remove();
      for (let index = 0; index < msg.length; index++) {
        const element = msg[index];
        errorArea.append(
          '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+element+'</div>'
        );
      }
    }

  });


$('#subscribeForm').on('submit',function(event){
    event.preventDefault();


    let url = $(this).attr('action');
    let method = $(this).attr('method');
    let formdata = $(this).serialize();

    //console.log(formdata);

    let success_area = $('.successMsg1');
    let error_area = $('.errorMsg1');
    let submitBtn = $('.submitBtn1');
    let faLoader = $('.faLoader');

    submitBtn.attr({disabled: 'disabled'});
    faLoader.css({display: 'block'});

    $.ajax({
      url: url,
      type:method,
      data:formdata,
      success:function(response){
        faLoader.css({display: 'none'});
        success_area.find('.alert-success').remove();
        error_area.find('.alert-danger').remove();
        submitBtn.removeAttr('disabled');
        success_area.append(
          '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.success+'</div>'
          );
        $("#subscribeForm :input[type='text'], :input[type='email'], textarea[name='experience']").val('');

      },
      error: function(xhr,status,error ) {
        faLoader.css({display: 'none'});
        submitBtn.removeAttr('disabled');
        errorMsg(xhr.responseJSON,error_area);
        console.log(xhr);
        console.log(status);
        console.log(error);
      }

    });

    function errorMsg(msg,errorArea){
      success_area.find('.alert-success').remove();
      errorArea.find('.alert-danger').remove();
      for (let index = 0; index < msg.length; index++) {
        const element = msg[index];
        errorArea.append(
          '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+element+'</div>'
        );
      }
    }

  });
  </script>




    </body>

<!-- Mirrored from leverage.codings.dev/demo-5 by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Dec 2020 07:15:20 GMT -->
</html><?php /**PATH E:\xampp\htdocs\php\angularlaravel\vizzclub\backend\resources\views/layouts/master_guest.blade.php ENDPATH**/ ?>