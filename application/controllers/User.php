<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Login', 'login');
        $this->load->model('M_Data', 'data');
        if(!$this->session->userdata('login')){
            redirect(base_url());
        }
    }
    
    public function index()
    {
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Data User - SMK Pustek";
        $this->load->view('user/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->data->showAllUser($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
            $nestedData[]   = "<center><a href='".site_url('user/edit/'.$row['id_user'])."' id='EditUser'><i class='mdi mdi-pencil-outline'></i> Edit</a> | <a href='".site_url('user/hapus/'.$row['id_user'])."' id='HapusUser'><i class='mdi mdi-trash-can-outline'></i> Hapus</a></center>";
			$nestedData[]	= "<center>".$row['nama']."</center>";
            $nestedData[]	= "<center>".$row['username']."</center>";

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data
			);

		echo json_encode($json_data);
    }

    public function tambah(){
        if($this->input->post()){
            $nama       = $this->input->post('nama');
            $username   = $this->input->post('username');
            $password   = sha1(sha1($this->input->post('password')));

            $ins        = $this->data->insertUser($nama, $username, $password);
            if($ins){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
            }else{
                $status['status']   = "error";
                $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam Query ataupun Code. Silahkan hubungi <i>Developer</i>.</font>";
            }
            echo json_encode($status);
        }else{
            $this->load->view('user/tambah');
        }
    }

    public function hapus($id){
        if($this->input->is_ajax_request()){
            $hapus = $this->data->hapusUser($id);

            if($hapus){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
            }else{
                $status['status']   = "error";
                $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam Query ataupun Code. Silahkan hubungi <i>Developer</i>.</font>";
            }
            echo json_encode($status);
        }
    }

    public function edit($id){
        if(!empty($id)){
            if($this->input->post()){
                $nama       = $this->input->post('nama');

                $update = $this->data->updateUser($id, $nama);
                if($update){
                    $status['status']   = "success";
                    $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
                }else{
                    $status['status']   = "error";
                    $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam Query ataupun Code. Silahkan hubungi <i>Developer</i>.</font>";
                }
                echo json_encode($status);
            }else{
                $data['user']   = $this->data->editUser($id)->row();
                $data['id']     = $id;
                $this->load->view('user/edit', $data);
            }
        }
    }

    public function ajax_username(){
        $username = $this->input->post('username');
        $cek_username = $this->data->cek_username($username);

        if($cek_username->num_rows() > 0){
            $status['status']   = 0;
            $status['pesan']    = "<font style='color:red;' size='2'>Username sudah tersedia, silahkan gunakan username lain!</font>";
        }else{
            $status['status']   = 1;
        }
        echo json_encode($status);
    }

}