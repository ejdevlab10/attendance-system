<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('department_model');
        $this->load->model('Admin_model');
        $this->load->helper('url');
        $this->load->library('ciqrcode');
    }

    public function view_student() {
        $data['title'] = 'Student';
        $data['items'] = $this->department_model->getStudent();
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('admin/options/student/index', $data);
        $this->load->view('templates/admin_footer');
    }

    // Add student
    public function add_student() {
        $data['title'] = 'Student';
        $data['department'] = $this->db->get('department')->result_array();
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        // Form Validation
        $this->form_validation->set_rules('f_name', 'Student Name', 'required|trim');
        $this->form_validation->set_rules('m_name', 'Student Name', 'required|trim');
        $this->form_validation->set_rules('l_name', 'Student Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('e_gender', 'Gender', 'required');
        $this->form_validation->set_rules('e_birth_date', 'Birth Date', 'required|trim');
        $this->form_validation->set_rules('e_enrolled_date', 'Enrolled Date', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('admin/options/student/a_student', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->store_student();
        }
    }

    private function store_student() {
        $f_name = $this->input->post('f_name');
        $m_name = $this->input->post('m_name');
        $l_name = $this->input->post('l_name');
        $department = $this->input->post('d_id');
        $email = $this->input->post('email');
        $gender = $this->input->post('e_gender');
        $birth_date = $this->input->post('e_birth_date');
        $enrolled_date = $this->input->post('e_enrolled_date');

        // Check Email
        if ($this->db->get_where('student', ['email' => $email])->num_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Email already used!</div>');
            redirect('Student_controller/view_student');
        }

        // Upload image
        $config['upload_path'] = './images/st-uploads/';
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

        // Store student without QR code
        $student_data = [
            'f_name' => $f_name,
            'm_name' => $m_name,
            'l_name' => $l_name,
            'email' => $email,
            'gender' => $gender,
            'image' => $image,
            'birth_date' => $birth_date,
            'enrolled_date' => $enrolled_date,
            'department_id' => $department,
            'qr_code' => null,
            'qr_image' => null
        ];
        $this->db->insert('student', $student_data);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Successfully added a new student!</div>');
        redirect('Student_controller/view_student');
    }

    

    // Edit student data
    public function e_student($e_id) {
        $data['title'] = 'Student';
        $data['student'] = $this->db->get_where('student', ['id' => $e_id])->row_array();
        $data['department_current'] = $this->db->get_where('student', ['id' => $e_id])->row_array();
        $data['department'] = $this->db->get('department')->result_array();
        $data['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

        $this->form_validation->set_rules('f_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('m_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('l_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('e_gender', 'Gender', 'required');
        $this->form_validation->set_rules('e_birth_date', 'Birth Date', 'required|trim');
        $this->form_validation->set_rules('e_enrolled_date', 'Enrolled Date', 'required|trim');
        $this->form_validation->set_rules('d_id', 'Department', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('admin/options/student/e_student', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $f_name = $this->input->post('f_name');
            $l_name = $this->input->post('l_name');
            $m_name = $this->input->post('m_name');
            $gender = $this->input->post('e_gender');
            $birth_date = $this->input->post('e_birth_date');
            $enrolled_date = $this->input->post('e_enrolled_date');
            $d_id = $this->input->post('d_id');

            // Config Upload Image
            $config['upload_path'] = './images/st-uploads/';
            $config['allowed_types'] = 'jpg|png|jpeg|jfif';
            $config['max_size'] = '4096';
            $config['file_name'] = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

            // load library upload and pass config
            $this->load->library('upload', $config);

            if ($_FILES['image']['name']) {
                if ($this->upload->do_upload('image')) {
                    $image = $this->upload->data('file_name');
                    $old_image = $data['student']['image'];
                    if ($old_image != 'default.png') {
                        unlink('./images/st-uploads/' . $old_image);
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
                'enrolled_date' => $enrolled_date,
                'department_id' => $d_id,
            ];
            $this->_editStudent($e_id, $data, ['department_id' => $d_id]);
        }
    }

    private function _editStudent($e_id, $data) {
        $this->db->update('student', $data, ['id' => $e_id]);
        $upd = $this->db->affected_rows();
    
        if ($upd > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Successfully updated an student!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
                No changes were made to the student record.</div>');
        }
        redirect('Student_controller/view_student');
    }
    
	// Delete student
	public function delete_student($id) {
		$emp = $this->db->get_where('student', ['id' => $id])->row_array();
		if ($emp['image'] != 'default.png') {
			unlink('./images/st-uploads/' . $emp['image']);
		}
        if ($emp['qr_image'] != 'default.png') {
			unlink('./images/qrcodes/student/' . $emp['qr_image']);
		}
		$this->db->delete('student', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Successfully deleted an student!</div>');
		redirect('Student_controller/view_student');
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

}