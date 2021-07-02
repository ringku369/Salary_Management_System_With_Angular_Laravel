<!DOCTYPE html>
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- Mirrored from www.cliptheme.com/demo/clip-two/Html-Admin/clip-two-html-bs4/login_signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 26 Sep 2020 19:51:46 GMT -->

<head>
    <title><?php echo $__env->yieldContent('title', '"R&R Property Reservation LLC.| Your Property, Our Priority"'); ?></title>
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimum-scale=1,maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="ClipTwo - Responsive Admin Template build with Bootstrap" name="description">
    <meta content="ClipTheme" name="author">
    
    <link rel="icon" href="<?php echo e(asset('resources/lib/backend/assets/images/custom/favicon.png')); ?>" type="image/png" sizes="32x32">


    



    <link rel="manifest" href="<?php echo e(asset('resources/lib/backend/assets/images/manifest.json')); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo e(asset('resources/lib/backend/assets/images/ms-icon-144x144.png')); ?>">
    <meta name="theme-color" content="#ffffff">


    <link
        href="https://fonts.googleapis.com/css?family=Lato:100,300,400,400italic,600,700|Raleway:100,300,400,500,600,700|Crete+Round:400italic"
        rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('resources/lib/backend/assets/css/vendors.bundle.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('resources/lib/backend/assets/css/theme.bundle.min.css')); ?>">


    <link rel="stylesheet" href="<?php echo e(asset('resources/lib/backend/assets/css/themes/theme-1.min.css')); ?>">
</head>

<body class="login">
    <div class="row">
        <div class="main-login col-10 offset-1 col-sm-8 offset-sm-2 col-md-4 offset-md-4">
            <div class="logo margin-top-30"></div>
            
            <!-- box-login -->
  
  <?php echo $__env->yieldContent('content'); ?>
  

        </div>
    </div>
    <script src="<?php echo e(asset('resources/lib/backend/assets/js/vendors.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('resources/lib/backend/vendor/jquery-validation/dist/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('resources/lib/backend/assets/js/main.min.js')); ?>"></script>
    <script>
        NProgress.configure({
            showSpinner: !1
        }), NProgress.start(), NProgress.set(.4);
        var interval = setInterval(function () {
            NProgress.inc()
        }, 1e3);
        jQuery(document).ready(function () {
            NProgress.done(), clearInterval(interval), Main.init()
        })
    </script>
    <script src="<?php echo e(asset('resources/lib/backend/assets/js/login.min.js')); ?>"></script>
    <script>
        jQuery(document).ready(function () {
            Login.init()
        })
    </script>
</body>
<!-- Mirrored from www.cliptheme.com/demo/clip-two/Html-Admin/clip-two-html-bs4/login_signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 26 Sep 2020 19:51:47 GMT -->

</html><?php /**PATH E:\xampp\htdocs\php\angularlaravel\vizzclub\backend\resources\views/layouts/extra.blade.php ENDPATH**/ ?>