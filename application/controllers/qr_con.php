<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class qr_con extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('department_model');
        $this->load->model('Admin_model');
        $this->load->helper('url');
        $this->load->library('ciqrcode');
    }
    // Generate QR for employee
    public function generate_employee_qr($id) {
        $employee = $this->db->get_where('employee', ['id' => $id])->row_array();
        if (!$employee) {
            show_error('Employee not found');
        }

        // Generate QR content
        $qr_code_value = 'employee-' . $employee['id'] . '-' . $employee['birth_date']. '-' . time() ;
        $qr_filename = $employee['f_name'] . '-' . $employee['l_name'] . '-' . time() .  '.png';
        $qr_save_path = FCPATH . 'images/qrcodes/employee/' . $qr_filename;

        // Generate QR
        $params = [
            'data' => $qr_code_value,
            'level' => 'H',
            'size' => 10,
            'savename' => $qr_save_path,
        ];
        $this->ciqrcode->generate($params);

        // Save QR data to employee
        $this->db->update('employee', [
            'qr_code' => $qr_code_value,
            'qr_image' => $qr_filename
        ], ['id' => $id]);

        $this->session->set_flashdata('message', '<div class="alert alert-success">QR Code generated successfully!</div>');
        redirect('Admin_controller/view_employee');
    }
    // Generate QR for student
    public function  generate_student_qr($id) {
        $student = $this->db->get_where('student', ['id' => $id])->row_array();
        if (!$student) {
            show_error('Student not found');
        }

        // Generate QR content
        $qr_code_value = 'student-' . $student['id'] . '-' . $student['birth_date']. '-' . time() ;
        $qr_filename = $student['f_name'] . '-' . $student['l_name'] . '-' . time() .  '.png';
        $qr_save_path = FCPATH . 'images/qrcodes/student/' . $qr_filename;

        // Generate QR
        $params = [
            'data' => $qr_code_value,
            'level' => 'H',
            'size' => 10,
            'savename' => $qr_save_path,
        ];
        $this->ciqrcode->generate($params);

        // Save QR data to student
        $this->db->update('student', [
            'qr_code' => $qr_code_value,
            'qr_image' => $qr_filename
        ], ['id' => $id]);

        $this->session->set_flashdata('message', '<div class="alert alert-success">QR Code generated successfully!</div>');
        redirect('Student_controller/view_student');
    }
    
     // Method for scanning QR code
    public function scan_qr() {
        $input = json_decode(file_get_contents('php://input'), true);
        $qr_code = $input['qr_code'];
    
        // Look up employee by qr_code content
        $employee = $this->db->get_where('employee', ['qr_code' => $qr_code])->row_array();
    
        if (!$employee) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'QR not recognized.'
                ]));
        }
    
        $today = date('Y-m-d');
        $attendance = $this->db->get_where('attendance', [
            'employee_id' => $employee['id'],
            'DATE(in_time)' => $today
        ])->row_array();
    
        if (!$attendance) {
            // First scan = time in
            $this->db->insert('attendance', [
                'employee_id' => $employee['id'],
                'in_time' => date('Y-m-d H:i:s'),
                'in_status' => 'On Time'
            ]);
    
            $message = 'Time-in recorded for ' . $employee['f_name'] . ' ' . $employee['l_name'];
            $status = 'success';
        } elseif (!$attendance['out_time']) {
            // Second scan = time out
            $this->db->where('id', $attendance['id'])
                ->update('attendance', [
                    'out_time' => date('Y-m-d H:i:s'),
                    'out_status' => 'On Time'
                ]);
    
            $message = 'Time-out recorded for ' . $employee['f_name'] . ' ' . $employee['l_name'];
            $status = 'success';
        } else {
            // Already timed out today
            $message = 'Great job today, ' . $employee['f_name'] . '! See you again tomorrow!';
            $status = 'info';
        }
    
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => $status,
                'message' => $message
            ]));
    }

}