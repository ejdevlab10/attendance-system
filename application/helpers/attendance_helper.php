<?php
defined('BASEPATH') or exit('No direct script access allowed');

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'] ?? 0;

        $userAccess = $ci->db->get_where('user_access', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function is_weekends()
{
    date_default_timezone_set('Asia/Manila');
    $today = date('l');
    return in_array($today, ['Saturday', 'Sunday']);
}

function is_checked_in()
{
    date_default_timezone_set('Asia/Manila');
    $ci = get_instance();
    $username = $ci->session->userdata('username');
    $today = date('Y-m-d');

    $query = "SELECT 1 FROM `attendance`
              WHERE `username` = ?
              AND FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = ?";
              
    $result = $ci->db->query($query, [$username, $today]);

    return $result->num_rows() > 0;
}

function is_checked_out()
{
    date_default_timezone_set('Asia/Manila');
    $ci = get_instance();
    $username = $ci->session->userdata('username');
    $today = date('Y-m-d');

    $query = "SELECT 1 FROM `attendance`
              WHERE `username` = ?
              AND FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = ?
              AND `out_time` != 0
              AND (`out_status` IS NOT NULL AND `out_status` != '')";

    $result = $ci->db->query($query, [$username, $today]);

    return $result->num_rows() > 0;
}
