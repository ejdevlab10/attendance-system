<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-3">
      <a href="<?= base_url('Admin_controller/view_employee'); ?>" class="btn btn-secondary btn-icon-split mb-4">
        <span class="icon text-white">
          <i class="fas fa-chevron-left"></i>
        </span>
        <span class="text">Back</span>
      </a>
    </div>
    <div class="col-lg-5 offset-lg-4">
      <?= $this->session->flashdata('message'); ?>
    </div>
  </div>

  <div class="col-lg-10 p-0">
    <?= form_open_multipart('Admin_controller/add_employee'); ?>
    <div class="card">
      <h5 class="card-header">Employee Master Data</h5>
      <div class="card-body">
        <h5 class="card-title">Add New Employee</h5>
        <p class="card-text">Form to add new employee to the system</p>

        <div class="row">
          <div class="col-lg-6">
            <!-- First Name -->
            <div class="form-group row mb-3">
              <label for="f_name" class="col-form-label col-lg-4">First Name</label>
              <div class="col-lg-8 p-0">
                <input type="text" class="form-control" name="f_name" id="f_name" autofocus>
                <?= form_error('f_name', '<small class="text-danger">', '</small>') ?>
              </div>
            </div>

            <!-- Middle Name -->
            <div class="form-group row mb-3">
              <label for="m_name" class="col-form-label col-lg-4">Middle Name</label>
              <div class="col-lg-8 p-0">
                <input type="text" class="form-control" name="m_name" id="m_name">
                <?= form_error('m_name', '<small class="text-danger">', '</small>') ?>
              </div>
            </div>

            <!-- Last Name -->
            <div class="form-group row mb-3">
              <label for="l_name" class="col-form-label col-lg-4">Last Name</label>
              <div class="col-lg-8 p-0">
                <input type="text" class="form-control" name="l_name" id="l_name">
                <?= form_error('l_name', '<small class="text-danger">', '</small>') ?>
              </div>
            </div>

            <!-- Department -->
            <div class="form-group row mb-3">
              <label for="d_id" class="col-form-label col-lg-4">Department Name</label>
              <div class="col-lg-8 p-0">
                <select class="form-control" name="d_id" id="d_id">
                  <?php foreach ($department as $dpt) : ?>
                    <option value="<?= $dpt['id'] ?>"><?= $dpt['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <!-- Email -->
            <div class="form-group row mb-3">
              <label for="email" class="col-form-label col-lg-4">Email</label>
              <div class="col-lg-8 p-0">
                <input type="email" class="form-control" name="email" id="email">
                <?= form_error('email', '<small class="text-danger">', '</small>') ?>
              </div>
            </div>

            <!-- Gender -->
            <div class="form-group row mb-3">
              <label class="col-form-label col-lg-4">Gender</label>
              <div class="col-lg-8 p-0 d-flex align-items-center">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="e_gender" id="m" value="M" checked>
                  <label class="form-check-label mr-3" for="m">Male</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="e_gender" id="f" value="F">
                  <label class="form-check-label" for="f">Female</label>
                </div>
              </div>
            </div>

            <!-- Birth Date -->
            <div class="form-group row mb-3">
              <label for="e_birth_date" class="col-form-label col-lg-4">Date of Birth</label>
              <div class="col-lg-8 p-0">
                <input type="date" class="form-control" name="e_birth_date" id="e_birth_date" min="1990-01-01" max="<?= date('Y-m-d'); ?>">
                <?= form_error('e_birth_date', '<small class="text-danger">', '</small>') ?>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <!-- Image Preview Card -->
            <div class="card mb-4">
              <div class="card-header">Employee Image</div>
              <div class="card-body text-center">
                <img id="previewImage" src="<?= base_url('images/uploads/default.png'); ?>" alt="Preview"
                     style="width: 200px; height: 200px; object-fit: cover; border: 1px solid #ccc; border-radius: 10px;">
                <input type="file" name="image" id="image" class="form-control-file mt-2">
              </div>
            </div>

            <!-- Hire Date -->
            <div class="form-group row mb-3">
              <label for="e_hire_date" class="col-form-label col-lg-4">Hired Date</label>
              <div class="col-lg-8 p-0">
                <input type="date" class="form-control" name="e_hire_date" id="e_hire_date" min="2000-01-01" max="<?= date('Y-m-d'); ?>">
                <?= form_error('e_hire_date', '<small class="text-danger">', '</small>') ?>
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
          <span class="icon text-white">
            <i class="fas fa-plus-circle"></i>
          </span>
          <span class="text">Add to system</span>
        </button>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</div>

<!-- Image Preview Script -->
<script>
  document.getElementById('image').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file && file.type.startsWith('image/')) {
      document.getElementById('previewImage').src = URL.createObjectURL(file);
    }
  });
</script>
