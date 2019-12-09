<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('M_Login', 'login');
        if(!$this->session->userdata('login')){
            redirect('login');
        }
    }

    public function index()
    {
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "SMK Pustek";
        $this->load->view('home', $data);
    }

}