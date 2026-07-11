<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Title -->
  <div class="row mb-4">
    <div class="col text-center">
      <h1 class="h2 text-gray-800">
        <?= $account['f_name'] . ' ' . $account['m_name'] . ' ' . $account['l_name']; ?>
      </h1>
    </div>
  </div>

  <!-- Profile Card Full Height -->
  <div class="row justify-content-center">
    <div class="col-xl-11 col-lg-11 col-md-12">

      <div class="card shadow-lg p-4 h-100" style="min-height: 100%;">
        <div class="row h-100">

          <!-- Profile Image Section -->
          <div class="col-md-5 col-lg-4 d-flex flex-column align-items-center justify-content-start mb-4 mb-md-0">
            <div class="border rounded-circle overflow-hidden shadow" style="width: 240px; height: 240px;">
              <img src="<?= base_url('images/uploads/') . $account['image']; ?>" class="img-fluid" style="width: auto; height: auto; object-fit: cover;">
            </div>
            <h4 class="mt-3 text-gray-800 text-center"><?= $account['f_name'] . ' ' . $account['m_name'] . ' ' . $account['l_name']; ?></h4>
          </div>

          <!-- Employee Information Table -->
          <div class="col-md-7 col-lg-8 d-flex flex-column justify-content-start">
            <h5 class="bg-info text-white px-3 py-2 rounded mb-4">Employee Details</h5>
            <table class="table table-striped table-hover table-bordered">
              <tbody>
                <tr>
                  <th scope="row" style="width: 200px;">Employee ID</th>
                  <td><?= $account['id']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Gender</th>
                  <td><?= $account['gender'] == 'M' ? 'Male' : 'Female'; ?></td>
                </tr>
                <tr>
                  <th scope="row">Department</th>
                  <td><?= $account['department']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Birthday</th>
                  <td><?= $account['birth_date']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Joined On</th>
                  <td><?= $account['hire_date']; ?></td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>

</div>
<!-- /.container-fluid -->
