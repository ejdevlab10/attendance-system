<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class department_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function getDataForDashboard() {
      $d['employee'] = $this->db->get('employee')->result_array();
      $d['c_employee'] = $this->db->get('employee')->num_rows();
      $d['department'] = $this->db->get('department')->result_array();
      $d['c_department'] = $this->db->get('department')->num_rows();
      $d['users'] = $this->db->get('users')->result_array();
      $d['c_users'] = $this->db->get('users')->num_rows();

      return $d;
    }

    public function getDepartment() {
        return $this->db->get('department')->result_array();
    }

    public function getEmployee() {
        return $this->db->get('employee')->result_array();
    }

    public function getStrand() {
        return $this->db->get('strand')->result_array();
    }

    public function getStudent() {
        return $this->db->get('student')->result_array();
    }

    public function checkProductImage($id) {
        return $this->db->get_where('employee', ['id' => $id]);
    }

}
?>
