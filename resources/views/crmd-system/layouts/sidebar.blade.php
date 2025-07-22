 <style>
     /* Professional Medical Sidebar Enhancement */

     /* Main Sidebar Container */
     .pc-sidebar {
         background: transparent;
         /* box-shadow: 2px 0 15px rgba(0, 0, 0, 0.08); */
         border-right: 1px solid #e5e7eb;
     }

     /* Logo Header Area */
     .pc-sidebar .m-header {
         background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
         padding: 25px 20px;
         border-bottom: 2px solid #e2e8f0;
         position: relative;
     }

     .pc-sidebar .m-header::after {
         content: '';
         position: absolute;
         bottom: 0;
         left: 20px;
         right: 20px;
         height: 1px;
         background: linear-gradient(90deg, transparent, #3b82f6, transparent);
     }

     .pc-sidebar .b-brand {
         display: inline-flex;
         align-items: center;
         justify-content: center;
         padding: 18px 24px;
         /* background: #ffffff; */
         border-radius: 12px;
         /* box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); */
         border: 1px solid #f1f5f9;
         transition: all 0.3s ease;
         text-decoration: none;
     }

     .pc-sidebar .b-brand:hover {
         /* box-shadow: 0 6px 20px rgba(59, 130, 246, 0.15); */
         transform: translateY(-1px);
     }

     /* Navigation Content Area */
     .pc-sidebar .navbar-content {
         padding: 20px 15px;
         background: #f8f9fa;
     }

     /* Navigation List */
     .pc-sidebar .pc-navbar {
         list-style: none;
         padding: 0;
         margin: 0;
     }

     /* Section Captions */
     .pc-sidebar .pc-item.pc-caption {
         margin: 12px 0 8px;
     }

     .pc-sidebar .pc-caption label {
         color: #64748b;
         font-size: 11px;
         font-weight: 600;
         text-transform: uppercase;
         letter-spacing: 0.5px;
         padding: 0 16px;
         display: block;
         position: relative;
     }

     .pc-sidebar .pc-caption label::before {
         content: '';
         position: absolute;
         left: 0;
         top: 15%;
         width: 3px;
         height: 12px;
         background: #3b82f6;
         border-radius: 2px;
     }

     /* Navigation Items */
     .pc-sidebar .pc-item:not(.pc-caption) {
         margin: 2px 0;
     }

     .pc-sidebar .pc-link {
         display: flex;
         align-items: center;
         padding: 12px 16px;
         color: #374151;
         text-decoration: none;
         border-radius: 8px;
         transition: all 0.2s ease;
         font-weight: 500;
         font-size: 14px;
         position: relative;
         border: 1px solid transparent;
     }

     .pc-sidebar .pc-link:hover {
         background: #f8fafc;
         color: #1f2937;
         /* border-color: #e5e7eb; */
     }

     /* Active State */
     .pc-sidebar .pc-link.active,
     .pc-sidebar .pc-link:active {
         /* background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); */
         color: #000000;
         /* box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25); */
     }

     /* Icons */
     .pc-sidebar .pc-micon {
         display: flex;
         align-items: center;
         justify-content: center;
         width: 32px;
         height: 32px;
         margin-right: 12px;
         flex-shrink: 0;
     }

     .pc-sidebar .pc-icon {
         font-size: 16px;
         color: inherit;
     }

     /* Menu Text */
     .pc-sidebar .pc-mtext {
         flex: 1;
         font-size: 14px;
         font-weight: 500;
         letter-spacing: 0.2px;
     }

     /* Submenu Arrow */
     .pc-sidebar .pc-arrow {
         margin-left: auto;
         opacity: 0.6;
         font-size: 12px;
         transition: transform 0.2s ease;
     }

     /* Submenu Styles */
     .pc-sidebar .pc-submenu {
         list-style: none;
         padding: 0;
         margin: 4px 0 0 0;
         background: #f8fafc;
         border-radius: 6px;
         border: 1px solid #e5e7eb;
         overflow: hidden;
     }

     .pc-sidebar .pc-submenu .pc-item {
         border-bottom: 1px solid #e5e7eb;
     }

     .pc-sidebar .pc-submenu .pc-item:last-child {
         border-bottom: none;
     }

     .pc-sidebar .pc-submenu .pc-link {
         padding: 10px 16px 10px 48px;
         font-size: 13px;
         font-weight: 400;
         color: #6b7280;
         background: transparent;
         border: none;
         border-radius: 0;
         position: relative;
     }

     .pc-sidebar .pc-submenu .pc-link:hover {
         background: #ffffff;
         color: #374151;
         border-color: transparent;
     }

     .pc-sidebar .pc-submenu .pc-link:hover::before {
         background: #3b82f6;
         transform: translateY(-50%) scale(1.2);
     }

     /* Custom Scrollbar */
     .pc-sidebar .navbar-content::-webkit-scrollbar {
         width: 4px;
     }

     .pc-sidebar .navbar-content::-webkit-scrollbar-track {
         background: #f1f5f9;
     }

     .pc-sidebar .navbar-content::-webkit-scrollbar-thumb {
         background: #cbd5e1;
         border-radius: 2px;
     }

     .pc-sidebar .navbar-content::-webkit-scrollbar-thumb:hover {
         background: #94a3b8;
     }

     /* Medical Theme Accent */
     .pc-sidebar::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         width: 4px;
         height: 100%;
         background: linear-gradient(180deg, #002e77 0%, #96bfff  50%);
         z-index: 1;
     }

     /* Responsive Adjustments */
     @media (max-width: 768px) {
         .pc-sidebar .m-header {
             padding: 20px 15px;
         }

         .pc-sidebar .navbar-content {
             padding: 15px 12px;
         }

         .pc-sidebar .pc-link {
             padding: 14px;
         }

         .pc-sidebar .pc-mtext {
             font-size: 15px;
         }
     }
 </style>
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
                             <span class="pc-micon">
                                 <i class="pc-icon fas fa-file-medical"></i>
                             </span>
                         </span>
                         <span class="pc-mtext">Implant</span>
                     </a>
                 </li>

                 <li class="pc-item">
                     <a href="{{ route('manage-sales-billing') }}" class="pc-link">
                         <span class="pc-micon">
                             <span class="pc-micon">
                                 <i class="pc-icon fas fa-file-invoice-dollar"></i>
                             </span>
                         </span>
                         <span class="pc-mtext">Sales Billing</span>
                     </a>
                 </li>

                 <li class="pc-item pc-hasmenu">
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
                         <li class="pc-item"><a class="pc-link" href="{{ route('manage-quotation-page') }}">Manage
                                 Quotation</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="{{ route('manage-company-page') }}">Manage
                                 Company</a>
                         </li>
                         <li class="pc-item"><a class="pc-link" href="{{ route('assign-generator-model-page') }}">Assign
                                 Generator
                                 & Model</a>
                         </li>
                     </ul>
                 </li>

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

             <br><br><br><br>
             <br><br><br><br>

         </div>
     </div>
 </nav>
 <!-- [ Sidebar Menu ] end -->
