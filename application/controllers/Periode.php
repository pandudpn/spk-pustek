<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Periode extends CI_Controller {

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
        $data['judul']  = "Data Periode - SMK Pustek";
        $this->load->view('periode/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->data->showAllPeriode($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

        $data	= array();
        $no     = 1;
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$no++."</center>";
			$nestedData[]	= "<center>".$row['nama_periode']."</center>";
            $nestedData[]   = "<center><a href='".site_url('periode/edit/'.$row['id_periode'])."' id='EditGuru'><i class='mdi mdi-pencil-outline'></i> Edit</a> | <a href='".site_url('periode/hapus/'.$row['id_periode'])."' id='HapusGuru'><i class='mdi mdi-trash-can-outline'></i> Hapus</a></center>";

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

            $ins        = $this->data->insertPeriode($nama);
            if($ins){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
            }else{
                $status['status']   = "error";
                $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam Query ataupun Code. Silahkan hubungi <i>Developer</i>.</font>";
            }
            echo json_encode($status);
        }else{
            $this->load->view('periode/tambah');
        }
    }

    public function hapus($id){
        if($this->input->is_ajax_request()){
            $hapus = $this->data->hapusPeriode($id);

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

                $update = $this->data->updatePeriode($id, $nama);
                if($update){
                    $status['status']   = "success";
                    $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
                }else{
                    $status['status']   = "error";
                    $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam Query ataupun Code. Silahkan hubungi <i>Developer</i>.</font>";
                }
                echo json_encode($status);
            }else{
                $data['periode']    = $this->data->editPeriode($id)->row();
                $data['id']         = $id;
                $this->load->view('periode/edit', $data);
            }
        }
    }

}

/* End of file Periode.php */
