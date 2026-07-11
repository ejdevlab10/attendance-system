<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function getAdmin($username)
    {
        $account = $this->db->get_where('users', ['username' => $username])->row_array();
        if (!$account) {
            return null; // return a default array
        }
        
        $e_id = $account['employee_id'];
        
        $query = "SELECT  employee.id AS `id`,
                            employee.f_name AS `f_name`,
                            employee.l_name AS `l_name`,
                            employee.m_name AS `m_name`,
                            employee.gender AS `gender`,
                            employee.image AS `image`,
                            employee.birth_date AS `birth_date`,
                            employee.hire_date AS `hire_date`
                    FROM  employee
                    WHERE `employee`.`id` = '$e_id'";
        
        return $this->db->query($query)->row_array();
    }
    public function get_all_attendance_with_employee()
    {
        $this->db->select('attendance.*, employee.f_name, employee.m_name, employee.l_name, employee.id as employee_id');
        $this->db->from('attendance');
        $this->db->join('employee', 'employee.id = attendance.employee_id');
        $this->db->order_by('attendance.in_time', 'DESC');
        return $this->db->get()->result();
    }

    // Student usernames
    public function getStudentAccount($username)
    {
        $account = $this->db->get_where('users', ['username' => $username])->row_array();
        if (!$account) {
            return null; // return a default array
        }
        
        $s_id = $account['student_id'];
        
        $query = "SELECT  student.id AS `id`,
                            student.f_name AS `f_name`,
                            student.l_name AS `l_name`,
                            student.m_name AS `m_name`,
                            student.gender AS `gender`,
                            student.image AS `image`,
                            student.birth_date AS `birth_date`,
                            student.enrolled_date AS `enrolled_date`
                    FROM  student
                    WHERE `student`.`id` = '$s_id'";
        
        return $this->db->query($query)->row_array();
    }

    // Student
    public function get_all_attendance_with_student()
    {
        $this->db->select('attendance.*, student.f_name, student.m_name, student.l_name, student.id as student_id');
        $this->db->from('attendance');
        $this->db->join('student', 'student.id = attendance.student_id');
        $this->db->order_by('attendance.in_time', 'DESC');
        return $this->db->get()->result();
    }

    public function get_attendance_between_dates($from, $to)
    {
        $this->db->select('attendance.*, employee.f_name, employee.m_name, employee.l_name, employee.id as employee_id');
        $this->db->from('attendance');
        $this->db->join('employee', 'employee.id = attendance.employee_id');
        $this->db->where('DATE(attendance.in_time) >=', $from);
        $this->db->where('DATE(attendance.in_time) <=', $to);
        $this->db->order_by('attendance.in_time', 'DESC');
        return $this->db->get()->result();
    }

}
