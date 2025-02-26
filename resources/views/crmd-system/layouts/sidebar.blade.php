 <!-- [ Sidebar Menu ] start -->
 <nav class="pc-sidebar">
     <div class="navbar-wrapper">
         <div class="m-header">
             <a href="##" class="b-brand text-primary">
                 <img src="../assets/images/logo/abbott-logo.png" class="img-fluid" width="120" height="60"
                     alt="logo" />
             </a>
         </div>
         <div class="navbar-content">
             <ul class="pc-navbar">
                 <li class="pc-item pc-caption">
                     <label>Main</label>
                 </li>

                 <li class="pc-item">
                     <a href="{{ route('staff-dashboard-page') }}" class="pc-link">
                         <span class="pc-micon">
                             <svg class="pc-icon">
                                 <use xlink:href="#custom-status-up"></use>
                             </svg>
                         </span>
                         <span class="pc-mtext">Dashboard</span>
                     </a>
                 </li>

                 <li class="pc-item pc-caption">
                     <label>Management</label>
                 </li>

                 <li class="pc-item pc-hasmenu">
                     <a href="#!" class="pc-link">
                         <span class="pc-micon">
                             <svg class="pc-icon">
                                 <use xlink:href="#custom-layer"></use>
                             </svg>
                         </span>
                         <span class="pc-mtext">Implant</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Manage
                                 Implant</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Upload Implant
                                 Form</a>
                         </li>
                     </ul>
                 </li>

                 <li class="pc-item">
                     <a href="#!" class="pc-link">
                         <span class="pc-micon">
                             <svg class="pc-icon">
                                 <use xlink:href="#custom-status-up"></use>
                             </svg>
                         </span>
                         <span class="pc-mtext">Patient ID Card</span>
                     </a>
                 </li>


                 <li class="pc-item pc-hasmenu">
                     <a href="#!" class="pc-link">
                         <span class="pc-micon">
                             <svg class="pc-icon">
                                 <use xlink:href="#custom-layer"></use>
                             </svg>
                         </span>
                         <span class="pc-mtext">Sales Billing</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Generate Bill</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Upload
                                 Document</a>
                         </li>
                     </ul>
                 </li>

                 <li class="pc-item">
                     <a href="../widget/w_statistics.html" class="pc-link">
                         <span class="pc-micon">
                             <svg class="pc-icon">
                                 <use xlink:href="#custom-story"></use>
                             </svg>
                         </span>
                         <span class="pc-mtext">Quotation</span>
                     </a>
                 </li>

                 <li class="pc-item pc-caption">
                     <label>System</label>
                 </li>

                 <li class="pc-item pc-hasmenu">
                     <a href="#!" class="pc-link">
                         <span class="pc-micon">
                             <svg class="pc-icon">
                                 <use xlink:href="#custom-layer"></use>
                             </svg>
                         </span>
                         <span class="pc-mtext">Staff</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link" href="{{ route('manage-department-page') }}">Manage
                                 Department</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Manage Staff</a>
                         </li>
                     </ul>
                 </li>

                 <li class="pc-item pc-hasmenu">
                     <a href="#!" class="pc-link">
                         <span class="pc-micon">
                             <svg class="pc-icon">
                                 <use xlink:href="#custom-layer"></use>
                             </svg>
                         </span>
                         <span class="pc-mtext">Hospital & Doctor</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Manage
                                 Hospital</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Manage
                                 Doctor</a>
                         </li>
                     </ul>
                 </li>

                 <li class="pc-item pc-hasmenu">
                     <a href="#!" class="pc-link">
                         <span class="pc-micon">
                             <svg class="pc-icon">
                                 <use xlink:href="#custom-layer"></use>
                             </svg>
                         </span>
                         <span class="pc-mtext">Model</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Manage Model
                                 Category</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Manage
                                 Model</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Manage
                                 Generator</a>
                         </li>
                     </ul>
                 </li>

                 <li class="pc-item pc-hasmenu">
                     <a href="#!" class="pc-link">
                         <span class="pc-micon">
                             <svg class="pc-icon">
                                 <use xlink:href="#custom-layer"></use>
                             </svg>
                         </span>
                         <span class="pc-mtext">Others</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Manage Product
                                 Group</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="../admins/course-dashboard.html">Manage
                                 Region</a>
                         </li>
                     </ul>
                 </li>
             </ul>
         </div>
     </div>
 </nav>
 <!-- [ Sidebar Menu ] end -->
