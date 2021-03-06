<!--Top Navbar -->

            <header class="navbar navbar-expand-lg navbar-light navbar-static-top">
                <div class="navbar-header"><a href="#" class="sidebar-mobile-toggler float-left d-lg-none"
                        class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off"
                        data-toggle-target="#app" data-toggle-click-outside="#sidebar"><i class="ti-align-justify"></i>
                    </a><a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <img style="height: 50px; width:150px" src="{{ asset('resources/lib/backend/assets/images/custom/logo.png') }}" alt="ClipTwo">
                    </a><a href="#" class="sidebar-toggler float-right d-none d-lg-block d-xl-block"
                        data-toggle-class="app-sidebar-closed" data-toggle-target="#app"><i
                            class="ti-align-justify"></i></a></div>
                <div class="container-navbar-right">
                    <ul class="navbar-right">
                        {{-- <li class="dropdown"><a href="javascript:void(0)" data-parent-tab="#offTab"
                                data-tab="#off-users" class="dropdown-toggle" data-toggle-class="app-offsidebar-open"
                                data-toggle-target="#app" data-toggle-click-outside="#off-sidebar"><span
                                    class="dot-badge partition-red animated infinite pulse"></span> <i
                                    class="ti-comment animated bounce"></i> <span
                                    class="d-none d-md-block d-lg-block d-xl-block">MESSAGES</span></a></li>

                        <li class="dropdown"><a href class="dropdown-toggle" data-parent-tab="#offTab"
                                data-tab="#off-activities" class="dropdown-toggle"
                                data-toggle-class="app-offsidebar-open" data-toggle-target="#app"
                                data-toggle-click-outside="#off-sidebar"><i class="ti-check-box"></i> <span
                                    class="d-none d-md-block d-lg-block d-xl-block">ACTIVITIES</span></a></li>

                        <li class="dropdown d-none"><a href class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="ti-world"></i> <span
                                    class="d-none d-md-block d-lg-block d-xl-block">English</span></a>
                            <div role="menu" class="dropdown-menu dropdown-menu-right dropdown-light"><a href="#"
                                    class="dropdown-item">Deutsch </a><a href="#" class="dropdown-item">English </a><a
                                    href="#" class="dropdown-item">Italiano</a></div>
                        </li> --}}
                        
                        <li class="dropdown current-user  d-md-block d-lg-block d-xl-block">
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('resources/lib/backend/assets/images/custom/avatar1.png') }}"
                                    alt="Peter"> <span class="username">{{Auth::user()->firstname . " ". Auth::user()->lastname}} <i class="ti-angle-down"></i></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-dark">
                                {{-- <li><a href="pages_user_profile.html">My Profile</a></li>
                                <li><a href="pages_calendar.html">My Calendar</a></li>
                                <li><a hef="pages_messages.html">My Messages (3)</a></li>
                                <li><a href="login_lockscreen.html">Lock Screen</a></li> --}}
                                <li><a href="{{ route('logout') }}">Log Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- <a class="dropdown-off-sidebar sidebar-mobile-toggler d-md-block d-lg-block"
                    data-toggle-class="app-offsidebar-open" data-toggle-target="#app"
                    data-toggle-click-outside="#off-sidebar"></a> &nbsp; <a
                    class="dropdown-off-sidebar d-none d-sm-block" data-toggle-class="app-offsidebar-open"
                    data-toggle-target="#app" data-toggle-click-outside="#off-sidebar">&nbsp;</a> -->
            </header>

            <!-- Top Navbar