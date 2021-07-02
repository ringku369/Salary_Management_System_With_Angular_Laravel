<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('retailer.dashboard') }}" class="logo">
   

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
                  {{Auth::user()->firstname}} {{Auth::user()->lastname}} - Retailer
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
          
          <li><a href="{{ route('retailer.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-cog"></i>
            <span>Profile </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('retailer.retailer')}}"><i class="fa fa-circle-o text-aqua"></i>Profile</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Returns </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('retailer.returnProduct')}}"><i class="fa fa-circle-o text-aqua"></i>Return Product</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Dont Worry </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('retailer.dontWorry')}}"><i class="fa fa-circle-o text-aqua"></i>Don't Worry</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Reports </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('retailer.dailySalesReport') }}"><i class="fa fa-circle-o text-aqua"></i>Daily Sales Report</a></li>

            <li><a href="{{ route('retailer.dailyCampaignReport') }}"><i class="fa fa-circle-o text-aqua"></i>Daily Campaign Report</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Warranty Check </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('retailer.wcheckProduct') }}"><i class="fa fa-circle-o text-aqua"></i>Warranty Check</a></li>
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
        </li>


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