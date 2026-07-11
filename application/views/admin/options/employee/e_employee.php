        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('Admin_controller/view_employee'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <?= form_open_multipart('Admin_controller/e_employee/' . $employee['id']); ?>
          <div class="col-lg p-0">
            <div class="row">
              <div class="col-lg-3">
              <div class="card" style="width: 100%; height: 100%">
                    <!-- Image Preview -->
                    <img id="previewImage" src="<?= base_url('images/uploads/') . $employee['image']; ?>" class="card-img-top w-75 mx-auto pt-3">
                    <div class="card-body mt-3">
                      <label for="image">Change Employee Image</label>
                      <input type="file" name="image" id="image" class="mt-2">
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

              </div>
              <div class="col-lg-6">
                <div class="card">
                  <h5 class="card-header">Employee Master Data</h5>
                  <div class="card-body">
                    <h5 class="card-title">Edit Employee</h5>
                    <p class="card-text">Form to edit employee in system</p>
                    <div class="row">
                      <div class="col-lg-8">
                        <div class="form-group">
                          <label for="employee_id" class="col-form-label">Employee ID</label>
                          <input type="text" readonly class="form-control-plaintext" name="e_id" value="<?= $employee['id']; ?>">
                        </div>
                      </div>
                      <div class="col-lg-8">
                        <div class="form-group">
                          <label for="f_name" class="col-form-label">Employee First Name</label>
                          <input type="text" class="form-control" name="f_name" id="f_name" value="<?= $employee['f_name']; ?>">
                          <?= form_error('f_name', '<small class="text-danger">', '</small>') ?>
                        </div>
                      </div>
                      <div class="col-lg-8">
                        <div class="form-group">
                          <label for="m_name" class="col-form-label">Employee Middle Name</label>
                          <input type="text" class="form-control" name="m_name" id="m_name" value="<?= $employee['m_name']; ?>">
                          <?= form_error('m_name', '<small class="text-danger">', '</small>') ?>
                        </div>
                      </div>
                      <div class="col-lg-8">
                        <div class="form-group">
                          <label for="l_name" class="col-form-label">Employee Last Name</label>
                          <input type="text" class="form-control" name="l_name" id="l_name" value="<?= $employee['l_name']; ?>">
                          <?= form_error('l_name', '<small class="text-danger">', '</small>') ?>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="e_gender" class="col-form-label">Gender</label>
                          <div class="row col-lg">
                            <div class="form-check form-check-inline my-0">
                              <input class="form-check-input" type="radio" name="e_gender" id="m" value="M" <?php if ($employee['gender'] == 'M') {
                                                                                                              echo 'checked';
                                                                                                            }; ?>>
                              <label class="form-check-label" for="m">
                                Male
                              </label>
                              <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="e_gender" id="f" value="F" <?php if ($employee['gender'] == 'F') {
                                                                                                              echo 'checked';
                                                                                                            }; ?>>
                              <label class="form-check-label" for="f">
                                Female
                              </label>
                            </div>
                          </div>
                          <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="e_birth_date" class="col-form-label">Employee D.O.B</label>
                          <div class="col-lg p-0">
                            <input type="date" class="form-control" name="e_birth_date" id="e_birth_date" value="<?= $employee['birth_date']; ?>">
                            <?= form_error('e_birth_date', '<small class="text-danger">', '</small>') ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="e_hire_date" class="col-form-label">Hire Date</label>
                          <div class="col-lg p-0">
                            <input type="date" class="form-control" name="e_hire_date" id="e_hire_date" max="<?= date('Y-m-d', time()); ?>" value="<?= $employee['hire_date']; ?>">
                            <?= form_error('e_hire_date', '<small class="text-danger">', '</small>') ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="d_id" class="col-form-label">Department</label>
                          <select class="form-control" name="d_id" id="d_id">
                            <?php foreach ($department as $dpt) : ?>
                              <option value="<?= $dpt['id'] ?>" <?php if ($dpt['id'] ==  $department_current['department_id']) {
                                                                  echo 'selected';
                                                                }; ?>><?= $dpt['name'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
                      <span class="icon text-white">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="text">Save Changes</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?= form_close(); ?>
        </div>
        <!-- /.container-fluid -->