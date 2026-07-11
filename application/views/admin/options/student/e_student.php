        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('Student_controller/view_student'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <?= form_open_multipart('Student_controller/e_student/' . $student['id']); ?>
          <div class="col-lg p-0">
            <div class="row">
              <div class="col-lg-3">
              <div class="card" style="width: 100%; height: 100%">
                    <!-- Image Preview -->
                    <img id="previewImage" src="<?= base_url('images/st-uploads/') . $student['image']; ?>" class="card-img-top w-75 mx-auto pt-3">
                    <div class="card-body mt-3">
                      <label for="image">Change student Image</label>
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
                  <h5 class="card-header">student Master Data</h5>
                  <div class="card-body">
                    <h5 class="card-title">Edit student</h5>
                    <p class="card-text">Form to edit student in system</p>
                    <div class="row">
                      <div class="col-lg-8">
                        <div class="form-group">
                          <label for="student_id" class="col-form-label">student ID</label>
                          <input type="text" readonly class="form-control-plaintext" name="e_id" value="<?= $student['id']; ?>">
                        </div>
                      </div>
                      <div class="col-lg-8">
                        <div class="form-group">
                          <label for="f_name" class="col-form-label">student First Name</label>
                          <input type="text" class="form-control" name="f_name" id="f_name" value="<?= $student['f_name']; ?>">
                          <?= form_error('f_name', '<small class="text-danger">', '</small>') ?>
                        </div>
                      </div>
                      <div class="col-lg-8">
                        <div class="form-group">
                          <label for="m_name" class="col-form-label">student Middle Name</label>
                          <input type="text" class="form-control" name="m_name" id="m_name" value="<?= $student['m_name']; ?>">
                          <?= form_error('m_name', '<small class="text-danger">', '</small>') ?>
                        </div>
                      </div>
                      <div class="col-lg-8">
                        <div class="form-group">
                          <label for="l_name" class="col-form-label">student Last Name</label>
                          <input type="text" class="form-control" name="l_name" id="l_name" value="<?= $student['l_name']; ?>">
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
                              <input class="form-check-input" type="radio" name="e_gender" id="m" value="M" <?php if ($student['gender'] == 'M') {
                                                                                                              echo 'checked';
                                                                                                            }; ?>>
                              <label class="form-check-label" for="m">
                                Male
                              </label>
                              <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="e_gender" id="f" value="F" <?php if ($student['gender'] == 'F') {
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
                          <label for="e_birth_date" class="col-form-label">student D.O.B</label>
                          <div class="col-lg p-0">
                            <input type="date" class="form-control" name="e_birth_date" id="e_birth_date" value="<?= $student['birth_date']; ?>">
                            <?= form_error('e_birth_date', '<small class="text-danger">', '</small>') ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="e_enrolled_date" class="col-form-label">Enrolled Date</label>
                          <div class="col-lg p-0">
                            <input type="date" class="form-control" name="e_enrolled_date" id="e_enrolled_date" max="<?= date('Y-m-d', time()); ?>" value="<?= $student['enrolled_date']; ?>">
                            <?= form_error('e_enrolled_date', '<small class="text-danger">', '</small>') ?>
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