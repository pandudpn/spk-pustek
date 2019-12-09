<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('M_Login', 'login');
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		if($this->form_validation->run() == FALSE){
			$data['judul']	= "Login";
			$this->load->view('login', $data);
		}else{
			$username = $this->input->post('username');
			$password = sha1(sha1($this->input->post('password')));

			$user = $this->login->validasi_login($username, $password);
			if($user){
				$user_data = array(
					'id'		=> $user->id_user,
					'username'	=> $this->input->post('username'),
					'akses'		=> $user->akses,
					'nama'		=> $user->nama,
					'login'		=> true
				);
				$this->session->set_userdata($user_data);
				redirect(base_url());
			}else{
				$this->session->set_flashdata('salah', 'Username atau Password anda Salah!');
				redirect('login');
			}
		}
    }

    public function logout(){
        $data = array('id','username','login','akses', 'nama');
		$this->session->unset_userdata($data);
		redirect('login');
    }

}