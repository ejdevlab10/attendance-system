<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('department_model');
        $this->load->model('Admin_model');
        $this->load->helper('url');
        $this->load->library('ciqrcode');
    }

    // Dashboard page
    public function index() {
        $dquery = "SELECT department_id AS d_id, COUNT(id) AS qty FROM employee GROUP BY d_id";
        $data['d_list'] = $this->db->query($dquery)->result_array();
        $data['title'] = 'Dashboard';
        $data['display'] = $this->department_model->getDataForDashboard();
        $data['title'] = 'Dashboard';
        $data['items'] = $this->department_model->getDepartment();
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('admin/index', $data); // Dashboard Page
        $this->load->view('templates/admin_footer');
    }

    // View departments
    public function view_departments() {
        $data['title'] = 'Department';
        $data['items'] = $this->department_model->getDepartment();
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('admin/options/department/index', $data);
        $this->load->view('templates/admin_footer');
    }

    // Add new department
    public function add_dep() {
        $data['title'] = 'Department';
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        $this->form_validation->set_rules('id', 'Department ID', 'required|trim|exact_length[3]|alpha');
        $this->form_validation->set_rules('name', 'Department Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('admin/options/department/a_dept', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->_addDept();
        }
    }

    // Store department in database
    public function store_dep() {
        $data = [
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name')
        ];

        $checkId = $this->db->get_where('department', ['id' => $data['id']])->num_rows();
        if ($checkId > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Failed to add, ID used!</div>');
        } else {
            $this->db->insert('department', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Successfully added a new department!</div>');
        }
        redirect('Admin_controller/view_departments');
    }

    // Edit department
    public function edit_dep($d_id) {
        $data['title'] = 'Department';
        $data['d_old'] = $this->db->get_where('department', ['id' => $d_id])->row_array();
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);


        $this->form_validation->set_rules('d_name', 'Department Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('admin/options/department/e_dept', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $name = $this->input->post('d_name');
            $this->_editDept($d_id, $name);
        }
    }

    private function _editDept($d_id, $name) {
        $data = ['name' => $name];
        $this->db->update('department', $data, ['id' => $d_id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Successfully edited a department!</div>');
        redirect('Admin_controller/view_departments');
    }

    // Delete department
    public function delete_dep($id) {
        $this->db->delete('department', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Successfully deleted a department!</div>');
        redirect('Admin_controller/view_departments');
    }

    // Employee functions ---------------------------------------------------------------------------------------------------

    // View employee
    public function view_employee() {
        $data['title'] = 'Employee';
        $data['items'] = $this->department_model->getEmployee();
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('admin/options/employee/index', $data);
        $this->load->view('templates/admin_footer');
    }

    // Add employee
    public function add_employee() {
        $data['title'] = 'Employee';
        $data['department'] = $this->db->get('department')->result_array();
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        // Form Validation
        $this->form_validation->set_rules('f_name', 'Employee Name', 'required|trim');
        $this->form_validation->set_rules('m_name', 'Employee Name', 'required|trim');
        $this->form_validation->set_rules('l_name', 'Employee Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('e_gender', 'Gender', 'required');
        $this->form_validation->set_rules('e_birth_date', 'Birth Date', 'required|trim');
        $this->form_validation->set_rules('e_hire_date', 'Hire Date', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('admin/options/employee/a_employee', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->store_employee();
        }
    }

    private function store_employee() {
        $f_name = $this->input->post('f_name');
        $m_name = $this->input->post('m_name');
        $l_name = $this->input->post('l_name');
        $department = $this->input->post('d_id');
        $email = $this->input->post('email');
        $gender = $this->input->post('e_gender');
        $birth_date = $this->input->post('e_birth_date');
        $hire_date = $this->input->post('e_hire_date');

        // Check Email
        if ($this->db->get_where('employee', ['email' => $email])->num_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Email already used!</div>');
            redirect('Admin_controller/view_employee');
        }

        // Upload image
        $config['upload_path'] = './images/uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|jfif';
        $config['max_size'] = 4096;
        $config['file_name'] = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

        $this->load->library('upload', $config);
        $image = 'default.png';
        if ($_FILES['image']['name']) {
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data('file_name');
            }
        }

        // Store employee without QR code
        $employee_data = [
            'f_name' => $f_name,
            'm_name' => $m_name,
            'l_name' => $l_name,
            'email' => $email,
            'gender' => $gender,
            'image' => $image,
            'birth_date' => $birth_date,
            'hire_date' => $hire_date,
            'department_id' => $department,
            'qr_code' => null,
            'qr_image' => null
        ];
        $this->db->insert('employee', $employee_data);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Successfully added a new employee!</div>');
        redirect('Admin_controller/view_employee');
    }

    

    // Edit employee data
    public function e_employee($e_id) {
        $data['title'] = 'Employee';
        $data['employee'] = $this->db->get_where('employee', ['id' => $e_id])->row_array();
        $data['department_current'] = $this->db->get_where('employee', ['id' => $e_id])->row_array();
        $data['department'] = $this->db->get('department')->result_array();
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        $this->form_validation->set_rules('f_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('m_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('l_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('e_gender', 'Gender', 'required');
        $this->form_validation->set_rules('e_birth_date', 'Birth Date', 'required|trim');
        $this->form_validation->set_rules('e_hire_date', 'Hire Date', 'required|trim');
        $this->form_validation->set_rules('d_id', 'Department', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('admin/options/employee/e_employee', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $f_name = $this->input->post('f_name');
            $l_name = $this->input->post('l_name');
            $m_name = $this->input->post('m_name');
            $gender = $this->input->post('e_gender');
            $birth_date = $this->input->post('e_birth_date');
            $hire_date = $this->input->post('e_hire_date');
            $d_id = $this->input->post('d_id');

            // Config Upload Image
            $config['upload_path'] = './images/uploads/';
            $config['allowed_types'] = 'jpg|png|jpeg|jfif';
            $config['max_size'] = '4096';
            $config['file_name'] = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

            // load library upload and pass config
            $this->load->library('upload', $config);

            if ($_FILES['image']['name']) {
                if ($this->upload->do_upload('image')) {
                    $image = $this->upload->data('file_name');
                    $old_image = $data['employee']['image'];
                    if ($old_image != 'default.png') {
                        unlink('./images/uploads/' . $old_image);
                    }
                }
            } else {
                $image = 'default.png';
            }

            $data = [
                'f_name' => $f_name,
                'm_name' => $m_name,
                'l_name' => $l_name,
                'gender' => $gender,
                'image' => $image,
                'birth_date' => $birth_date,
                'hire_date' => $hire_date,
                'department_id' => $d_id,
            ];
            $this->_editEmployee($e_id, $data, ['department_id' => $d_id]);
        }
    }

    private function _editEmployee($e_id, $data) {
        $this->db->update('employee', $data, ['id' => $e_id]);
        $upd = $this->db->affected_rows();
    
        if ($upd > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Successfully updated an employee!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
                No changes were made to the employee record.</div>');
        }
        redirect('Admin_controller/view_employee');
    }
    
	// Delete employee
	public function delete_employee($id) {
		$emp = $this->db->get_where('employee', ['id' => $id])->row_array();
		if ($emp['image'] != 'default.png') {
			unlink('./images/uploads/' . $emp['image']);
		}
        if ($emp['qr_image'] != 'default.png') {
			unlink('./images/qrcodes/employee/' . $emp['qr_image']);
		}
		$this->db->delete('employee', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Successfully deleted an employee!</div>');
		redirect('Admin_controller/view_employee');
	}
	public function view_users() {
        $data['title'] = 'Users';
        $query = "SELECT employee.id AS e_id,
                        employee.department_id AS d_id,
                        users.username AS u_username,
                        employee.f_name AS f_name,
                        employee.l_name AS l_name,
                        employee.m_name AS m_name
                  FROM employee
                  LEFT JOIN users ON employee.id = users.employee_id";
    
        $data['data'] = $this->db->query($query)->result_array();    
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('users/index', $data);
        $this->load->view('templates/admin_footer');
    }
    
    public function a_users($e_id) {
        $empDep = $this->db->get_where('employee', ['id' => $e_id])->row_array();
        $data['title'] = 'Users';
        $data['username'] = $empDep['department_id'] . $empDep['id'];
        $data['e_id'] = $empDep['id'];
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        $this->form_validation->set_rules('u_username', 'Username', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('u_password', 'Password', 'required|trim|min_length[6]');

        if ($this->form_validation->run() == false) {
        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('users/a_users', $data);
        $this->load->view('templates/admin_footer');
        } else {
        $username = $this->input->post('u_username');
        if ($empDep['department_id'] != 'ADM') {
            $role_id = 2;
        } else {
            $role_id = 1;
        }
        $data = [
            'username' => $username,
            'password' => password_hash($this->input->post('u_password'), PASSWORD_DEFAULT),
            'employee_id' => $this->input->post('e_id'),
            'role_id' => $role_id
        ];
        $this->_addUsers($data);
        }
    }
    private function _addUsers($data)
    {
        $this->db->insert('users', $data);
        $rows = $this->db->affected_rows();
        if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Successfully created an account!</div>');
        } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Failed to create account!</div>');
        }
		redirect('Admin_controller/view_users');
    }
    public function e_users($username)
  {
    $data['title'] = 'Users';
    $data['users'] = $this->db->get_where('users', ['username' => $username])->row_array();
    $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

    if ($this->form_validation->run() == false) {
        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('users/e_users', $data);
        $this->load->view('templates/admin_footer');
    } else {
      $data = ['password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)];
      $this->_editUsers($data, $username);
    }
  }
    private function _editUsers($data, $username)
    {
        $this->db->update('users', $data, ['username' => $username]);
        $rows = $this->db->affected_rows();
        if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Successfully edited an account!</div>');
        } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Failed to edit account!</div>');
        }
		redirect('Admin_controller/view_users');
    }

    public function d_users($username)
    {
        $this->db->delete('users', ['username' => $username]);
        $rows = $this->db->affected_rows();
        if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Successfully deleted an account!</div>');
        } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Failed to delete account!</div>');
        }
		redirect('Admin_controller/view_users');
    }

// scanner 

    public function scanner_page() {
        $data['title'] = 'Scanner';
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('admin/options/scanner', $data);
        $this->load->view('templates/admin_footer', $data);
    }
    
        public function attendance_records() {
        $this->load->model('Admin_model');
        $data['title'] = 'Attendance Record';

        $from = $this->input->get('from_date');
        $to = $this->input->get('to_date');

        if ($from && $to) {
            $attendance = $this->Admin_model->get_attendance_between_dates($from, $to);
        } else {
            $attendance = $this->Admin_model->get_all_attendance_with_employee();
        }

        // Compute total work hours or ongoing work duration
        foreach ($attendance as &$record) {
            if ($record->in_time) {
                $inTime = new DateTime($record->in_time);
                
                if ($record->out_time) {
                    // User already timed out – show total duration
                    $outTime = new DateTime($record->out_time);
                    $interval = $inTime->diff($outTime);
                    $record->hours_since_last_in = $interval->format('%h hrs %i mins');
                } else {
                    // Still working – show ongoing time since time-in
                    $now = new DateTime();
                    $interval = $inTime->diff($now);
                    $record->hours_since_last_in = $interval->format('%h hrs %i mins (ongoing)');
                }
            } else {
                $record->hours_since_last_in = '—';
            }
        }

        $data['attendance'] = $attendance;

        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('admin/options/attendance_view', $data);
        $this->load->view('templates/admin_footer', $data);
    }

    public function export_attendance_csv()
    {

        // Get date filters
        $from = $this->input->get('from_date');
        $to = $this->input->get('to_date');

        // Fetch attendance based on date range or all
        if ($from && $to) {
            $attendance = $this->Admin_model->get_attendance_between_dates($from, $to);
            $filename = "attendance_{$from}_to_{$to}.csv";
        } else {
            $attendance = $this->Admin_model->get_all_attendance_with_employee();
            $filename = 'attendance_all.csv';
        }

        // Set headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Open stream
        $output = fopen('php://output', 'w');

        // Header row
        fputcsv($output, ['#', 'Employee ID', 'Full Name', 'In Time', 'In Status', 'Out Time', 'Out Status', 'Notes', 'Total Work Hours']);

        // Rows
        $i = 1;
        foreach ($attendance as $row) {
            $emp_id = str_pad($row->employee_id, 3, '0', STR_PAD_LEFT);
            $full_name = "{$row->l_name}, {$row->f_name} {$row->m_name}";

            // Calculate work duration if available
            $total_hours = '—';
            if ($row->in_time && $row->out_time) {
                $in = new DateTime($row->in_time);
                $out = new DateTime($row->out_time);
                $interval = $in->diff($out);
                $total_hours = $interval->format('%h hrs %i mins');
            }

            fputcsv($output, [
                $i++, 
                $emp_id, 
                $full_name, 
                $row->in_time ?? '—', 
                $row->in_status ?? '—', 
                $row->out_time ?? '—', 
                $row->out_status ?? '—', 
                $row->notes ?? '—',
                $total_hours
            ]);
        }

        fclose($output);
        exit;
    }

}