<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {
    
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
        $data['judul']  = "Data Kriteria - SMK Pustek";
        $this->load->view('kriteria/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->data->showAllKriteria($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
			$nestedData[]	= "<center>".$row['nama_kriteria']."</center>";
            $nestedData[]	= "<center>".$row['bobot']."</center>";
            $nestedData[]	= "<center>".$row['cb']."</center>";
            $nestedData[]   = "<center><a href='".site_url('kriteria/edit/'.$row['id_kriteria'])."' id='EditKriteria'><i class='mdi mdi-pencil-outline'></i> Edit</a></center>";

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
            $bobot      = $this->input->post('bobot');
            $cb         = $this->input->post('cb');

            $ins        = $this->data->insertKriteria($nama, $bobot, $cb);
            if($ins){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
            }else{
                $status['status']   = "error";
                $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam Query ataupun Code. Silahkan hubungi <i>Developer</i>.</font>";
            }
            echo json_encode($status);
        }else{
            $this->load->view('kriteria/tambah');
        }
    }

    public function hapus($id){
        if($this->input->is_ajax_request()){
            $hapus = $this->data->hapusKriteria($id);

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
                $bobot      = $this->input->post('bobot');
                $cb         = $this->input->post('cb');

                $update = $this->data->updateKriteria($id, $nama, $bobot, $cb);
                if($update){
                    $status['status']   = "success";
                    $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
                }else{
                    $status['status']   = "error";
                    $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam Query ataupun Code. Silahkan hubungi <i>Developer</i>.</font>";
                }
                echo json_encode($status);
            }else{
                $data['kriteria']   = $this->data->editKriteria($id)->row();
                $data['id']     = $id;
                $this->load->view('kriteria/edit', $data);
            }
        }
    }

}