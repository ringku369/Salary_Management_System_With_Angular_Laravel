<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('distributor.dashboard') }}" class="logo">
   

@if (@$_SESSION["logo"] )
 
  <img src="{{ asset( 'storage/app/' . $_SESSION['logo']) }}" class="responsive no-repeat" alt="logo" style="width: 230px; height: 35px">
@else
  <img src="{{ asset('resources/assets/dms/dist/img/logo.png') }}" class="responsive no-repeat" alt="logo" style="width: 230px; height: 35px">
@endif


    
      

    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <!-- <span class="sr-only">Toggle navigation</span> -->
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">


<!-- =====returnCount================= -->
@if (@$_SESSION["returnCount"] > 0)
  
<!-- =====notification================= -->
<li class="dropdown notifications-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-bell-o"></i>
    <span class="label label-warning">
      {{$_SESSION["returnCount"]}}
   </span>
  </a>
  <ul class="dropdown-menu">
    <li class="header">You have 
      {{$_SESSION["returnCount"]}}
     notifications</li>
    <li>
      <!-- inner menu: contains the actual data -->
      <ul class="menu">
        <li>
          <a href="{{ route('distributor.returnProduct') }}">
            <i class="fa fa-undo text-aqua"></i> 
              {{$_SESSION["returnCount"]}}
             piece product want to return 
          </a>
        </li>
      </ul>
    </li>
    <li class="footer"><a href="{{ route('distributor.returnProduct') }}">View all</a></li>
  </ul>
</li>

<!-- =====notification================= -->
@endif
<!-- =====returnCount================= -->



          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
@if (Auth::user()->photo)
  <img src="{{ asset( 'storage/app/' . Auth::user()->photo) }}" class="user-image" alt="User Image">
@else
  <img src="{{ asset('resources/assets/dms/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
@endif
              
              <span class="hidden-xs">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">

@if (Auth::user()->photo)
  <img src="{{ asset( 'storage/app/' . Auth::user()->photo) }}" class="user-image" alt="User Image">
@else
  <img src="{{ asset('resources/assets/dms/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
@endif

                <p>
                  {{Auth::user()->firstname}} {{Auth::user()->lastname}} - Distributor
                  <small>Registered on {{ substr(Auth::user()->created_at, 0,4) }}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-info btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
@if (Auth::user()->photo)
  <img src="{{ asset( 'storage/app/' . Auth::user()->photo) }}" class="img-circle" alt="User Image">
@else
  <img src="{{ asset('resources/assets/dms/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
@endif
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          
          <li><a href="{{ route('distributor.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-cog"></i>
            <span>Profile </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('distributor.distributor') }}"><i class="fa fa-circle-o text-aqua"></i>Profile</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Returns </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('distributor.returnProduct')}}"><i class="fa fa-circle-o text-aqua"></i>Return Product</a></li>
            <li><a href="{{route('distributor.returndProduct')}}"><i class="fa fa-circle-o text-aqua"></i>Direct Return</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Approve </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('distributor.dailyPurchaseApprove') }}"><i class="fa fa-circle-o text-aqua"></i>Daily Purchase Approve</a></li>
          </ul>
        </li>

        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Purchase </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('distributor.purchase') }}"><i class="fa fa-circle-o text-aqua"></i>Purchase Product</a></li>
          </ul>
        </li> -->

        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Sales </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('distributor.sale') }}"><i class="fa fa-circle-o text-aqua"></i>Sale Product</a></li>
          </ul>
        </li>

        


        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Reports </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('distributor.dailyRetailerStockReportForRetailer') }}"><i class="fa fa-circle-o text-aqua"></i>Daily Retailer Stock Report</a></li>


            <li><a href="{{ route('distributor.dailyStockReport') }}"><i class="fa fa-circle-o text-aqua"></i>Daily Stock Report</a></li>

            <li><a href="{{ route('distributor.dailyPurchaseReport') }}"><i class="fa fa-circle-o text-aqua"></i>Daily Purchase Report</a></li>

            <li><a href="{{ route('distributor.dailySalesReport') }}"><i class="fa fa-circle-o text-aqua"></i>Daily Sales Report</a></li>

            <!-- <li><a href="{{ route('distributor.dailyCampaignReport') }}"><i class="fa fa-circle-o text-aqua"></i>Daily Campaign Report</a></li> -->


            <li><a href="{{ route('distributor.dailyPurchaseReportV1') }}"><i class="fa fa-circle-o text-aqua"></i>Distributor Purchase Report</a></li>

            <li><a href="{{ route('distributor.dailySalesReportV1') }}"><i class="fa fa-circle-o text-aqua"></i>Distributor Sales Report</a></li>

            <li><a href="{{ route('distributor.dailyStockReportV1') }}"><i class="fa fa-circle-o text-aqua"></i>Distributor Stock Report</a></li>

            <li><a href="{{ route('distributor.dailyRtlStockReportV1') }}"><i class="fa fa-circle-o text-aqua"></i>Retailer Stock Report</a></li>

            
            
          </ul>

        </li>






        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Reports </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('distributor.dailySalesReport') }}"><i class="fa fa-circle-o text-aqua"></i>Daily Sales Report</a></li>
        
            <li><a href="{{ route('distributor.dailyCampaignReport') }}"><i class="fa fa-circle-o text-aqua"></i>Daily Campaign Report</a></li>
          </ul>
        </li>
        
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Warranty Check </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('distributor.wcheckProduct') }}"><i class="fa fa-circle-o text-aqua"></i>Warranty Check</a></li>
          </ul>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Verify </span>
          </a>
          <ul class="treeview-menu">
            <li><a target="_blank" href="{{ route('guest.verifySamsungProduct') }}"><i class="fa fa-circle-o text-aqua"></i>Verify Product</a></li>
          </ul>
        </li> -->


        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Accounts Section</span>
          </a>
        
          
          <ul class="treeview-menu">
            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i>
                <span>Settings</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o text-red"></i> Distributor Stock</a></li>
                <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> View Distributor Slaes</a></li>
                <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> Distributor Invoice History</a></li>
              </ul>
            </li>
        
        
            <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i>
                <span>Report</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o text-red"></i> Distributor Stock</a></li>
                <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> View Distributor Slaes</a></li>
                <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> Distributor Invoice History</a></li>
              </ul>
            </li>
        
        
          </ul>
        
        
        </li>
        
         -->







      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>