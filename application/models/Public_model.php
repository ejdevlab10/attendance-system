<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Public_model extends CI_Model
{
  public function getAllEmployeeData($username)
  {
    $data = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $data['employee_id'];


    $query = "SELECT  employee.id AS `id`,
                      employee.f_name AS `f_name`,
                      employee.l_name AS `l_name`,
                      employee.m_name AS `m_name`,
                      employee.gender AS `gender`,
                      employee.image AS `image`,
                      employee.qr_image AS `qr_image`,
                      employee.birth_date AS `birth_date`,
                      employee.hire_date AS `hire_date`,
                      department.name AS `department`
                FROM  employee
          INNER JOIN  department ON employee.department_id = department.id
               WHERE `employee`.`id` = $e_id";
    return $this->db->query($query)->row_array();
  }
}
