<nav data-aos="zoom-out" data-aos-delay="800" class="navbar navbar-expand">
                <div class="container header">

                    <!-- Navbar Brand-->
                    <a class="navbar-brand" href="{{ route('guest.home') }}">
                    
                            <img src="{{ asset('resources/lib/frontend/assets/images/logos.png') }}" width="156" height="86" alt="r&r">
                    
                    </a>

                    <!-- Nav holder -->
                    <div class="ml-auto"></div>

                    <!-- Navbar Items -->
                    <ul class="navbar-nav items">
                        <li class="nav-item dropdown">
                            <a href="{{ route('guest.home') }}" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="{{ route('guest.aboutUs') }}" class="nav-link">About Us </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="{{ route('guest.traning') }}" class="nav-link">Training </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link">Services <i class="icon-arrow-down"></i></a>
                            <ul class="dropdown-menu">
                                
                                <li class="nav-item">
                                    <a href="{{ route('guest.propertyInspection') }}" class="nav-link">Property Inspections</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('guest.rehabRenovation') }}">Rehab- Renovation
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('guest.structuralRehab') }}">Structural Rehab</a>
                                </li>
                                 <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('guest.environmental') }}">Environmental and Hazard Remediation</a>
                                </li>
                                 <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('guest.trashOuts') }}">Trash Outs</a>
                                </li>
                                 <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('guest.repairs') }}">Repairs and Replacements</a>
                                </li>
                                 <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('guest.lawn') }}">Lawn Maintenance</a>
                                </li>
                                 <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('guest.roofing') }}">Roofing</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Navbar Toggle -->
                    <ul class="navbar-nav toggle">
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#menu">
                                <i class="icon-menu m-0"></i>
                            </a>
                        </li>
                    </ul>

                    <!-- Navbar Action -->
                    <ul class="navbar-nav action">
                        <li class="nav-item ml-3">
                            <a href="tel:+6466373190" target="_blank" class="btn ml-lg-auto primary-button"><i class="icon-phone"></i>646-637-3190</a>
                            <!-- 
                                Suggestion: Replace the purchase button above with a contact button.
                                
                                <a href="#contact" class="smooth-anchor btn ml-lg-auto primary-button"><i class="icon-rocket"></i>CONTACT US</a>
                            -->
                        </li>
                         <li class="nav-item ml-3">
                            <a href="#" data-target="#register" data-toggle="modal" class="btn ml-lg-auto primary-button"><i class="icon-people"></i>Vendor Signup</a>
                            <!-- 
                                Suggestion: Replace the purchase button above with a contact button.
                                
                                <a href="#contact" class="smooth-anchor btn ml-lg-auto primary-button"><i class="icon-rocket"></i>CONTACT US</a>
                            -->
                        </li>
                    </ul>
                </div>
            </nav>