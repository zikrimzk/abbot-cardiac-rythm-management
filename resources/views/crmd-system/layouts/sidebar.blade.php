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
                             <i class="fas fa-home pc-icon"></i>
                         </span>
                         <span class="pc-mtext">Dashboard</span>
                     </a>
                 </li>

                 <li class="pc-item pc-caption">
                     <label>Management</label>
                 </li>

                 <li class="pc-item">
                     <a href="{{ route('manage-implant-page') }}" class="pc-link">
                         <span class="pc-micon">
                             <i class="pc-icon fas fa-file-medical-alt"></i>
                         </span>
                         <span class="pc-mtext">Implant</span>
                     </a>
                 </li>

                 {{-- <li class="pc-item">
                     <a href="{{ route('generate-patient-id-card-page') }}" class="pc-link">
                         <span class="pc-micon">
                             <i class="pc-icon fas fa-id-card"></i>
                         </span>
                         <span class="pc-mtext">Patient ID Card</span>
                     </a>
                 </li> --}}

                 <li class="pc-item pc-hasmenu">
                     <a href="javascript: void(0)" class="pc-link">
                         <span class="pc-micon">
                             <span class="pc-micon">
                                 <i class="pc-icon fas fa-file-invoice-dollar"></i>
                             </span>
                         </span>
                         <span class="pc-mtext">Sales Billing</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link" href="{{ route('generate-icf-page') }}">Generate Inventory Consumption Form (ICF)</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="javascript: void(0)">Upload Sales Billing Document</a>
                         </li>
                     </ul>
                 </li>

                 {{-- <li class="pc-item pc-hasmenu">
                     <a href="javascript: void(0)" class="pc-link">
                         <span class="pc-micon">
                             <span class="pc-micon">
                                 <i class="pc-icon fas fa-folder"></i>
                             </span>
                         </span>
                         <span class="pc-mtext">Quotation</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link" href="{{ route('manage-designation-page') }}">Generate
                                 Quotation</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="{{ route('manage-staff-page') }}">Assign Generator
                                 & Model</a>
                         </li>
                     </ul>
                 </li> --}}

                 <li class="pc-item pc-caption">
                     <label>Setting</label>
                 </li>

                 <li class="pc-item pc-hasmenu">
                     <a href="javascript: void(0)" class="pc-link">
                         <span class="pc-micon">
                             <i class="pc-icon fas fa-users-cog"></i>
                         </span>
                         <span class="pc-mtext">User</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link" href="{{ route('manage-designation-page') }}">Manage
                                 Designation</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="{{ route('manage-staff-page') }}">Manage Staff</a>
                         </li>
                     </ul>
                 </li>

                 <li class="pc-item pc-hasmenu">
                     <a href="javascript: void(0)" class="pc-link">
                         <span class="pc-micon">
                             <i class="pc-icon fas fa-hospital-alt"></i>
                         </span>
                         <span class="pc-mtext">Hospital & Doctor</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link" href="{{ route('manage-hospital-page') }}">Manage
                                 Hospital</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="{{ route('manage-doctor-page') }}">Manage
                                 Doctor</a>
                         </li>
                     </ul>
                 </li>

                 <li class="pc-item pc-hasmenu">
                     <a href="javascript: void(0)" class="pc-link">
                         <span class="pc-micon">
                             <i class="pc-icon fas fa-box"></i>
                         </span>
                         <span class="pc-mtext">Model</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">
                         <li class="pc-item">
                             <a class="pc-link" href="{{ route('manage-model-category-page') }}">
                                 Manage Model Category
                             </a>
                         </li>
                         <li class="pc-item">
                             <a class="pc-link" href="{{ route('manage-generator-page') }}">
                                 Manage Generator
                             </a>
                         </li>
                         <li class="pc-item">
                             <a class="pc-link" href="{{ route('manage-model-page') }}">
                                 Manage Model
                             </a>
                         </li>

                     </ul>
                 </li>

                 <li class="pc-item pc-hasmenu">
                     <a href="#!" class="pc-link">
                         <span class="pc-micon">
                             <i class="pc-icon fas fa-cog"></i>
                         </span>
                         <span class="pc-mtext">Others</span>
                         <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                     </a>
                     <ul class="pc-submenu">

                         <li class="pc-item">
                             <a class="pc-link" href="{{ route('manage-region-page') }}">
                                 Manage Region
                             </a>
                         </li>
                         <li class="pc-item">
                             <a class="pc-link" href="{{ route('manage-product-group-page') }}">
                                 Manage Product Group
                             </a>
                         </li>
                         <li class="pc-item">
                             <a class="pc-link" href="{{ route('manage-stock-location-page') }}">
                                 Manage Stock Location
                             </a>
                         </li>

                     </ul>
                 </li>
             </ul>
         </div>
     </div>
 </nav>
 <!-- [ Sidebar Menu ] end -->
