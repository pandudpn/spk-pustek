<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subkriteria extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Login', 'login');
        $this->load->model('M_Data', 'data');
        if(!$this->session->userdata('login')){
            redirect('login');
        }
    }
    
    public function index()
    {
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Data Subkriteria";
        $this->load->view('subkriteria/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->data->showAllSubkriteria($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

        $data	= array();
        $no = 1;
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$no++."</center>";
			$nestedData[]	= "<center>Kriteria - <b>".$row['nama_kriteria']."</b></center>";
            $nestedData[]	= "<center title='".$row['nama_subkriteria']."'>".substr($row['nama_subkriteria'], 0, 30)."</center>";
            $nestedData[]   = "<center><a href='".site_url('subkriteria/edit/'.$row['id_subkriteria'])."' id='EditKriteria'><i class='mdi mdi-pencil-outline'></i> Edit</a> | <a href='".site_url('subkriteria/hapus/'.$row['id_subkriteria'])."' id='Hapus'><i class='mdi mdi-trash-can-outline'></i> Hapus</a></center>";

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
            $kriteria   = $this->input->post('kriteria');
            $nama       = $this->input->post('nama');
            
            $ins        = $this->data->insertSubkriteria($kriteria, $nama);
            if($ins){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i>Berhasil</font>";
            }else{
                $status['status']   = "erro";
                $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam JSON, silahkan periksa kembali!</font>";
            }
            echo json_encode($status);
        }else{
            $data['kriteria']   = $this->data->getKriteria()->result();
            $this->load->view('subkriteria/tambah', $data);
        }
    }

    public function hapus($id){
        if($this->input->is_ajax_request()){
            $hapus = $this->data->hapusSubkriteria($id);

            if($hapus){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i>Berhasil</font>";
            }else{
                $status['status']   = "erro";
                $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam JSON, silahkan periksa kembali!</font>";
            }
            echo json_encode($status);
        }
    }

    public function edit($id){
        if(!empty($id)){
            if($this->input->post()){
                $kriteria   = $this->input->post('kriteria');
                $nama       = $this->input->post('nama');

                $update     = $this->data->updateSubkriteria($id, $kriteria, $nama);
                if($update){
                    $status['status']   = "success";
                    $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i>Berhasil</font>";
                }else{
                    $status['status']   = "erro";
                    $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam JSON, silahkan periksa kembali!</font>";
                }
                echo json_encode($status);
            }else{
                $data['subkriteria']    = $this->data->editSubkriteria($id)->row();
                $data['kriteria']       = $this->data->getKriteria()->result();
                $data['id']             = $id;
                $this->load->view('subkriteria/edit', $data);
            }
        }else{
            show_404();
        }
    }

}

/* End of file Subkriteria.php */
