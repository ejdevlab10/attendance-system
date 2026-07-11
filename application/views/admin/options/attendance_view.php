<div class="container-fluid mt-4">
  <h2 class="mb-4 text-center">Employee Attendance Records</h2>
  <form method="get" class="form-inline mb-3">
    <label for="from_date" class="mr-2">From:</label>
    <input type="date" name="from_date" class="form-control mr-3" value="<?= set_value('from_date', $this->input->get('from_date')) ?>">

    <label for="to_date" class="mr-2">To:</label>
    <input type="date" name="to_date" class="form-control mr-3" value="<?= set_value('to_date', $this->input->get('to_date')) ?>">

    <button type="submit" class="btn btn-primary mr-2">Filter</button>
    <a href="<?= base_url('Admin_controller/attendance_records') ?>" class="btn btn-secondary">Reset</a>
  </form>


  <!-- Export and Print Buttons -->
  <div class="mb-3 text-right">
  <a href="<?= base_url('Admin_controller/export_attendance_csv?from_date=' . $this->input->get('from_date') . '&to_date=' . $this->input->get('to_date')) ?>" class="btn btn-success btn-sm">
    <i class="fas fa-file-csv"></i> Export to CSV
  </a>


    <button onclick="window.print()" class="btn btn-info btn-sm mr-2">
      <i class="fas fa-print"></i> Print
    </button>
  </div>
<?php if (!empty($selected_month)): ?>
  <p class="d-print-block d-none text-center font-weight-bold">
    Showing records for: <?= date('F Y', strtotime($selected_month . '-01')); ?>
  </p>
<?php endif; ?>
 <!-- Attendance Data Table -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="attendanceTable" width="100%" cellspacing="0">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Employee ID</th>
              <th>Full Name</th>
              <th>In Time</th>
              <th>In Status</th>
              <th>Out Time</th>
              <th>Out Status</th>
              <th>Notes</th>
              <th>Total Work Hours</th> 
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; foreach ($attendance as $row): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= str_pad($row->employee_id, 3, '0', STR_PAD_LEFT) ?></td>
                <td><?= $row->l_name . ', ' . $row->f_name . ' ' . $row->m_name ?></td>
                <td><?= $row->in_time ?? '—' ?></td>
                <td><?= $row->in_status ?? '—' ?></td>
                <td><?= $row->out_time ?? '—' ?></td>
                <td><?= $row->out_status ?? '—' ?></td>
                <td><?= $row->notes ?? '—' ?></td>
                <td><?= $row->hours_since_last_in ?? '—' ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
