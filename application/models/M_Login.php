<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Login extends CI_Model {

    function validasi_login($username, $password)
	{
		return $this->db
			->select('*')
			->where('username', $username)
			->where('password', $password)
			->limit(1)
			->get('users')->row();
    }
    
    public function getDataLogin(){
        $id = $this->session->userdata('id');

        return $this->db->get_where('users', array('id_user' => $id))->row();
    }

}