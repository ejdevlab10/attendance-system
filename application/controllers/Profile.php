<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Public_model');
   
  }
  public function index()
  {
    $data['title'] = 'My Profile';
    $data['account'] = $this->Public_model->getAllEmployeeData($this->session->userdata['username']);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('profile/index', $data);
    $this->load->view('templates/footer');
  }
  public function view_qr()
  {
    $data['title'] = 'My Profile';
    $data['account'] = $this->Public_model->getAllEmployeeData($this->session->userdata['username']);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('profile/userqr', $data);
    $this->load->view('templates/footer');
  }
}
