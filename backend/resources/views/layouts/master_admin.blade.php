<!DOCTYPE html>
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- Mirrored from www.cliptheme.com/demo/clip-two/Html-Admin/clip-two-html-bs4/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 26 Sep 2020 19:42:12 GMT -->

<head>
    <title>@yield('title', '"R&R Property Reservation LLC.| Your Property, Our Priority"')</title>
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimum-scale=1,maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="ClipTwo - Responsive Admin Template build with Bootstrap" name="description">
    <meta content="ClipTheme" name="author">
  

    <link rel="icon" href="{{ asset('resources/lib/backend/assets/images/custom/favicon.png') }}" type="image/png" sizes="32x32">
    


    <link
        href="https://fonts.googleapis.com/css?family=Lato:100,300,400,400italic,600,700|Raleway:100,300,400,500,600,700|Crete+Round:400italic"
        rel="stylesheet" type="text/css">
  

    <link rel="stylesheet" href="{{ asset('resources/lib/backend/assets/css/vendors.bundle.min.css') }}">


    
    <link rel="stylesheet" href="{{ asset('resources/lib/backend/assets/css/theme.bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/lib/backend/assets/css/themes/theme-1.min.css') }}">


    <link rel="stylesheet" href="{{ asset('resources/lib/backend/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.standalone.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('resources/lib/backend/vendor/select2/dist/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('resources/lib/backend/vendor/wickedpicker/dist/wickedpicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('resources/lib/backend/vendor/datatables/media/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('resources/lib/backend/vendor/sweetalert/dist/sweetalert.css') }}">

<script
  src="https://code.jquery.com/jquery-3.5.1.slim.js"
  integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM="
  crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
    <div id="app">

        
<!-- left nav part================================ -->
@include('layouts.includes.leftnav_admin')
<!-- left nav part================================ -->


        <div class="app-content">
            
            


<!-- top nav part================================ -->
@include('layouts.includes.topnav_admin')
<!-- top nav part================================ -->



<!-- content part================================ -->

@yield('content')

<!-- content part================================ -->

<!-- footer part================================ -->


        </div>
        

        <!-- footer -->

        <footer>
            <div class="footer-inner">
                <div class="pull-left">
                    <span class="text-bold text-uppercase">
                        All Rights Reserved By R&R Property Reservation LLC.
                    </span>. 

                    <span>
                       &copy; <span class="current-year"></span> R&R Powered by <a href="https://synergyinterface.com/" target="_blank">Synergy Interface Ltd</a>
                    </span>
                </div>

                <div class="pull-right">
                    <span class="go-top">
                        <i class="ti-angle-up"></i>
                    </span>
                </div>
            </div>
        </footer>

        <!-- footer -->


    </div>
    

    <script src="{{ asset('resources/lib/backend/assets/js/vendors.bundle.min.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/vendor/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    
    


    <script src="{{ asset('resources/lib/backend/vendor/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>

    <script src="{{ asset('resources/lib/backend/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/vendor/autosize/dist/autosize.min.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/vendor/selectFx/classie.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/vendor/selectFx/selectFx.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/vendor/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/vendor/wickedpicker/dist/wickedpicker.min.js') }}"></script>


    <script src="{{ asset('resources/lib/backend/vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/vendor/datatables/media/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('resources/lib/backend/vendor/blockUI/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/vendor/jquery-mockjax/dist/jquery.mockjax.min.js') }}"></script>

    <script src="{{ asset('resources/lib/backend/vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/assets/js/main.min.js') }}"></script>





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
    <script src="{{ asset('resources/lib/backend/assets/js/form-elements.min.js') }}"></script>
    <script src="{{ asset('resources/lib/backend/assets/js/index.min.js') }}"></script>
    
    <script src="{{ asset('resources/lib/backend/assets/js/table-data.min.js') }}"></script>
    
    <script>
        /*$(document).ready(function () {
            Index.init()
        })*/

        jQuery(document).ready(function () {
          FormElements.init();
        });

        jQuery(document).ready(function () {
            //TableData.init();


        });

        $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable({
              'paging'      : true,
              'lengthChange': true,
              'searching'   : true,
              'ordering'    : true,
              'info'        : true,
              'autoWidth'   : false
            })

            /*$('#example5').DataTable({
              "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
            });*/


          var table = $('#example5').DataTable( {
           
            scrollY: '300',
            scrollX: true,
            fixedColumns: true,
            fixedHeader: true,
            //pageLength: 100,
            "lengthMenu": [[10, 20, 500, -1], [10, 20, 500, "All"]],

              dom: 'Bfrtip',
                     buttons: [
              {
                  extend: 'copyHtml5',
                  exportOptions: {
                      columns: [ 0, ':visible' ]
                  }
              },
              {
                  extend: 'excelHtml5',
                  exportOptions: {
                      columns: ':visible'
                  }
              },
               {
                  extend: 'csvHtml5',
                  exportOptions: {
                      columns: ':visible'
                  }
              },
              {
                  extend: 'pdfHtml5',
                  exportOptions: {
                      columns: [ 0, 1, 2, 5 ]
                  }
              },
              'colvis'
          ],
              //"order": [[ 0, "desc" ]],

              "columnDefs": [ {
              "visible": true,
              "targets": -1
          }]


          });
            
      })
    </script>



    <script>
        /** add active class and stay opened when selected */
        var url = window.location;

        // for sidebar menu entirely but not cover treeview
        $('ul.main-navigation-menu a').filter(function () {
            return this.href == url;
        }).parent().addClass('active');

        // for treeview
        $('ul.sub-menu a').filter(function () {
            return this.href == url;
        }).parentsUntil(".main-navigation-menu > .sub-menu").addClass('active');
    </script>

    




</body>
<!-- Mirrored from www.cliptheme.com/demo/clip-two/Html-Admin/clip-two-html-bs4/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 26 Sep 2020 19:49:05 GMT -->

</html>