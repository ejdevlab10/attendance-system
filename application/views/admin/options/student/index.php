        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <div class="row">
            <div class="col-lg-3">
              <a href="<?= base_url('Student_controller/add_student'); ?>" class="btn btn-info btn-icon-split mb-4">
                <span class="icon text-white-600">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Add New student</span>
              </a>
            </div>
            <div class="col-lg-5 offset-lg-4">
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>

          <!-- Data Table student-->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables student</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>ID</th>
                      <th>Full Name</th>
                      <th>Gender</th>
                      <th>Image</th>
                      <th>Date of Birth</th>
                      <th>Enrolled Date</th>
                      <th>Actions</th>
                      <th>QR</th>
                    </tr>
                  </thead>
                
                  <tbody>
                    <?php
                    $i = 1;
                    foreach ($items as $item) :
                    ?>
                      <?php if ($item['id'] == 0) {
                        continue;
                      } ?>
                      <tr>
                        <td class=" align-middle"><?= $i++; ?></td>
                        <td class=" align-middle"><?= $item['id']; ?></td>
                        <td class=" align-middle"><?= $item['l_name']; ?>, <?= $item['f_name']; ?> <?= $item['m_name']; ?></td>
                        <td class=" align-middle"><?php if ($item['gender'] == 'M') {
                                                    echo 'Male';
                                                  } else {
                                                    echo 'Female';
                                                  }; ?></td>
                        <td class="text-center"><img src="<?= base_url('images/st-uploads/') . $item['image']; ?>" style="width: 100px; height:100px" class="img-rounded"></td>
                        <td class=" align-middle"><?= $item['birth_date']; ?></td>
                        <td class=" align-middle"><?= $item['enrolled_date']; ?></td>
                        <td class="text-center align-middle">
                          <a href="<?= base_url('Student_controller/e_student/') . $item['id'] ?>" class="btn btn-primary btn-circle">
                            <span class="icon text-white" title="Edit">
                              <i class="fas fa-edit"></i>
                            </span>
                          </a> 
                          <a href="<?= base_url('Student_controller/delete_student/') . $item['id'] ?>" class="btn btn-danger btn-circle" onclick="return confirm('Deleted student will lost forever. Still want to delete?')">
                            <span class="icon text-white" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                            </span>
                          </a>
                        </td>
                        <td class="text-center align-middle">
                          <?php if ($item['qr_image']): ?>
                              <img src="<?= base_url('images/qrcodes/student/' . $item['qr_image']) ?>" width="100">
                          <?php else: ?>
                              <a href="<?= base_url('qr_con/generate_student_qr/' . $item['id']) ?>" class="btn btn-sm btn-primary">Generate QR</a>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->