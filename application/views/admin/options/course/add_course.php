        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('Student_controller/view_course'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>
          <form action="<?= base_url();?>store_course" method="POST" class="col-lg-5  p-0">
            <div class="card">
              <h5 class="card-header">Course Master Data</h5>
              <div class="card-body">
                <h5 class="card-title">Add New Course</h5>
                <p class="card-text">Form to add new course to system</p>
                <form>
                  <div class="form-group">
                    <label for="id" class="col-form-label-lg">Course ID</label>
                    <input type="text" class="form-control form-control-lg" name="id" id="id">
                    <?= form_error('id', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="name" class="col-form-label-lg">Course Name</label>
                    <input type="text" class="form-control form-control-lg" name="name" id="name">
                    <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
                    <span class="icon text-white">
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="text">Add to system</span>
                  </button>
                </form>
              </div>
            </div>
          </form>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->