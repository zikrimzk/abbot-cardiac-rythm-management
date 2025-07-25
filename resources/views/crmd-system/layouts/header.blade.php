 <!-- [ Header Topbar ] start -->
 <header class="pc-header">
     <div class="header-wrapper"> 
        
        <!-- [Mobile Media Block] start -->
         <div class="me-auto pc-mob-drp">
             <ul class="list-unstyled">
                 <li class="pc-h-item pc-sidebar-popup">
                     <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                         <i class="ti ti-menu-2"></i>
                     </a>
                 </li>
                 <li class="pc-h-item">
                    <div class="fw-bold f-16 text-uppercase text-dark d-none d-md-block">Cardiac Rythm Management Division</div>
                </li>
             </ul>
         </div>
         <!-- [Mobile Media Block end] -->
        
         <div class="ms-auto">
             <ul class="list-unstyled">
                 <li class="dropdown pc-h-item">
                     <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                         role="button" aria-haspopup="false" aria-expanded="false">
                         <i class="fas fa-user-circle"></i>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                         <a href="{{ route('staff-account-page') }}" class="dropdown-item">
                             <i class="ti ti-user"></i>
                             <span>My Account</span>
                         </a>
                         <a href="{{ route('staff-logout-get') }}" class="dropdown-item">
                             <i class="ti ti-power"></i>
                             <span>Logout</span>
                         </a>
                     </div>
                 </li>
             </ul>
         </div>
     </div>
 </header>
 <!-- [ Header ] end -->
