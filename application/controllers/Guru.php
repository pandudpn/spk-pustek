<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {
    
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
        $data['judul']  = "Data Guru - SMK Pustek";
        $this->load->view('guru/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->data->showAllGuru($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['kode_guru']."</center>";
			$nestedData[]	= "<center>".$row['nama_guru']."</center>";
            $nestedData[]	= "<center>".$row['no_telp']."</center>";
            $nestedData[]	= "<center>".$row['jenis']."</center>";
            $nestedData[]   = "<center>".$row['tempat_lahir'].", ".date('d F Y', strtotime($row['tgl_lahir']))."</center>";
            $nestedData[]   = "<center><a href='".site_url('guru/edit/'.$row['kode_guru'])."' id='EditGuru'><i class='mdi mdi-pencil-outline'></i> Edit</a> | <a href='".site_url('guru/hapus/'.$row['kode_guru'])."' id='HapusGuru'><i class='mdi mdi-trash-can-outline'></i> Hapus</a></center>";

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
            $nip        = $this->input->post('kode_guru');
            $nama       = $this->input->post('nama');
            $telp       = $this->input->post('telp');
            $alamat     = $this->input->post('alamat');
            $pendidikan = $this->input->post('pendidikan');
            $jk         = $this->input->post('jk');
            $tempat     = $this->input->post('tempat');
            $tgl_lahir  = $this->input->post('tgl');

            $ins        = $this->data->insertGuru($nip, $nama, $telp, $alamat, $pendidikan, $jk, $tempat, $tgl_lahir);
            if($ins){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
            }else{
                $status['status']   = "error";
                $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam Query ataupun Code. Silahkan hubungi <i>Developer</i>.</font>";
            }
            echo json_encode($status);
        }else{
            $this->load->view('guru/tambah');
        }
    }

    public function hapus($id){
        if($this->input->is_ajax_request()){
            $hapus = $this->data->hapusGuru($id);

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

    public function edit($nip){
        if(!empty($nip)){
            if($this->input->post()){
                $nama       = $this->input->post('nama');
                $alamat     = $this->input->post('alamat');
                $telp       = $this->input->post('telp');
                $pendidikan = $this->input->post('pendidikan');
                $jk         = $this->input->post('jk');
                $tempat     = $this->input->post('tempat');
                $tgl_lahir  = $this->input->post('tgl');

                $update = $this->data->updateGuru($nip, $nama, $alamat, $telp, $pendidikan, $jk, $tempat, $tgl_lahir);
                if($update){
                    $status['status']   = "success";
                    $status['pesan']    = "<font style='color:green;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
                }else{
                    $status['status']   = "error";
                    $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan dalam Query ataupun Code. Silahkan hubungi <i>Developer</i>.</font>";
                }
                echo json_encode($status);
            }else{
                $data['guru']    = $this->data->editGuru($nip)->row();
                $data['nip']     = $nip;
                $this->load->view('guru/edit', $data);
            }
        }
    }

    public function ajax_kode_guru(){
        $nip = $this->input->post('kode_guru');
        $cek_nip = $this->data->cek_nip($nip);

        if($cek_nip->num_rows() > 0){
            $status['status']   = 0;
            $status['pesan']    = "<font style='color:red;' size='2'>Kode Guru sudah tersedia!</font>";
        }else{
            $status['status']   = 1;
        }
        echo json_encode($status);
    }

}