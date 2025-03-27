<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>{{ $site_name }}</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <!-- [Favicon] icon -->
  <link rel="icon" href="{{asset('storage/uploads/setting_file/' . $logo)}}" type="image/x-icon"> <!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="{{asset('assets/fonts/tabler-icons.min.css') }}" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="{{asset('assets/fonts/feather.css')}}" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="{{asset('assets/fonts/fontawesome.css')}}" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="{{asset('assets/fonts/material.css')}}" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}" id="main-style-link" >
<link rel="stylesheet" href="{{asset('assets/css/style-preset.css')}}" >

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="{{route('dashboard')}}" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="{{asset('storage/uploads/setting_file/1742982177_logo.png')}}" class="img-fluid" style="max-height: 80px;" >
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item">
          <a href="{{ route('dashboard') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Master</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
          <a href="{{route('product.index')}}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-box"></i></span>
            <span class="pc-mtext">Product</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{route('category.index')}}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-layout-grid"></i></span>
            <span class="pc-mtext">Category</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>User Management</label>
          <i class="ti ti-news"></i>
        </li>
        <li class="pc-item">
          <a href="{{route('user.index')}}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-users"></i></span>
            <span class="pc-mtext">User</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{route('role.index')}}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
            <span class="pc-mtext">Role</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{route('permission.index')}}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
            <span class="pc-mtext">Permission</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
            <label>Settings</label>
            <i class="ti ti-news"></i>
          </li>
          <li class="pc-item">
            <a href="{{route('setting.index')}}" class="pc-link">
              <span class="pc-micon"><i class="ti ti-settings"></i></span>
              <span class="pc-mtext">Setting</span>
            </a>
          </li>

     
      </ul>

    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="dropdown pc-h-item d-inline-flex d-md-none">
      <a
        class="pc-head-link dropdown-toggle arrow-none m-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
      </a>
    </li>
  
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
    
    <li class="dropdown pc-h-item header-user-profile">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        data-bs-auto-close="outside"
        aria-expanded="false"
      >
        <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
        <span>{{Auth::user()->name}}</span>
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <div class="d-flex mb-1">
            <div class="flex-shrink-0">
              <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1">{{ Auth::user()->name }}</h6>
              <span>{{ Auth::user()->roles[0]->name }}</span>
            </div>
           
            
          </div>
        </div>
<hr class="my-1">
        <div class="tab-content" id="mysrpTabContent">
          <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">
            
            <a href="{{route('profile.edit')}}" class="dropdown-item">
             
              <button class="btn btn-default" class="dropdown-item"> <i class="ti ti-edit-circle"></i> Edit Profile</button>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                @csrf
                <button type="submit" class="btn btn-default" class="dropdown-item"><i class="ti ti-power"></i> Logout</button>
            </form>

          
          </div>
          
        </div>
      </div>
    </li>
  </ul>
</div>
 </div>
</header>
<!-- [ Header ] end -->


@include($content)

  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0"
            >{{$site_name}} &#9829; 2025.</p
          >
        </div>
        
      </div>
    </div>
  </footer> <!-- Required Js -->
<script src="{{asset('assets/js/plugins/popper.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/simplebar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/fonts/custom-font.js')}}"></script>
<script src="{{asset('assets/js/pcoded.js')}}"></script>
<script src="{{asset('assets/js/plugins/feather.min.js')}}"></script>





<script>layout_change('light');</script>




<script>change_box_container('false');</script>



<script>layout_rtl_change('false');</script>


<script>preset_change("preset-1");</script>


<script>font_change("Public-Sans");</script>

    

  
</body>
<!-- [Body] end -->

</html>