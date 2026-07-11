  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
  <div class="sidebar-brand-icon">
    <i class="fas fa-user-check"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Attendance System</div>
</a>


<!-- Query Menu -->

  <div class="sidebar-heading">
    Admin        </div>

              <li class="nav-item active">

      
      <a class="nav-link pb-0" href="<?= base_url('Admin_controller/index'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
      </li>

    
    <hr class="sidebar-divider mt-3">
  
  <div class="sidebar-heading">
    Options        </div>

      <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('Admin_controller/view_departments'); ?>">
        <i class="fas fa-fw fa-building"></i>
        <span>Department</span></a>
      </li>

      <li class="nav-item">
      
      <a class="nav-link pb-0" href="<?= base_url('Admin_controller/view_employee'); ?>">
        <i class="fas fa-fw fa-id-badge"></i>
        <span>Employee</span></a>
      </li>
      
      <li class="nav-item">
      
      <a class="nav-link pb-0" href="<?= base_url('Student_controller/view_student'); ?>">
        <i class="fas fa-fw fa-graduation-cap"></i>
        <span>Students</span></a>
      </li>
      

      <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('Admin_controller/view_users'); ?>">
        <i class="fas fa-fw fa-users"></i>
        <span>Users</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('Admin_controller/scanner_page'); ?>">
        <i class="fa fa-qrcode"></i>
        <span>Scanner</span></a>
      </li>

    
    <hr class="sidebar-divider mt-3">
  
  <div class="sidebar-heading">
    Attendance        </div>

              <li class="nav-item">
      
      <a class="nav-link pb-0" href="<?= base_url('Admin_controller/attendance_records'); ?>">
        <i class="fas fa-fw fa-paste"></i>
        <span>Print Report</span></a>
      </li>

    
    <hr class="sidebar-divider mt-3">
          </li>

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->   
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Alerts -->
                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if (!empty($account)): ?>
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $account['f_name']; ?></span>
                            <img class="img-profile rounded-circle" src="<?= base_url('images/uploads/') . $account['image']; ?>">
                        <?php else: ?>
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                            <img class="img-profile rounded-circle" src="<?= base_url('images/uploads/default.png'); ?>">
                        <?php endif; ?>
                    </a>

                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->
