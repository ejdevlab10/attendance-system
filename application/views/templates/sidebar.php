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
    User Profile        </div>

              <li class="nav-item active">

      
      <a class="nav-link pb-0" href="<?= base_url('Profile/index'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
      </li>

    
    <hr class="sidebar-divider mt-3">
  
  <div class="sidebar-heading">
    Options        </div>

      <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('Profile/view_qr'); ?>">
        <i class="fa fa-qrcode"></i>
        <span>QR Code</span></a>
      </li>

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->   