<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Login', 'login');
        $this->load->model('M_Data', 'data');
        $this->load->model('M_Laporan', 'laporan');
        if(!$this->session->userdata('login')){
            redirect('login');
        }
    }
    
    public function ranking(){
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Laporan Perankingan";
        $data['periode']= $this->data->getPeriode()->result();
        $this->load->view('laporan/ranking/index', $data);
    }

    public function detailRanking($tahun){
        $data['ranking'] = $this->laporan->getRanking($tahun);
        $data['tahun']   = $tahun;
        $this->load->view('laporan/ranking/detail', $data);
    }

    public function evaluasi(){
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Laporan Evaluasi Guru";
        $data['periode']= $this->data->getPeriode()->result();
        $this->load->view('laporan/evaluasi/index', $data);
    }

    public function detailEvaluasi($tahun){
        $data['detail'] = $this->laporan->getEvaluasi($tahun);
        $data['kriteria'] = $this->data->getKriteria()->result();
        $data['tahun']  = $tahun;
        $this->load->view('laporan/evaluasi/detail', $data);
    }

    public function hasil(){
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Laporan Guru Terbaik";
        $data['periode']= $this->data->getPeriode()->result();
        $this->load->view('laporan/guruterbaik/index', $data);
    }

    public function showRanking($tahun){
        $requestData	= $_REQUEST;
		$fetch			= $this->laporan->showAllRanking($tahun, $requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
			$nestedData[]	= "<center>".$row['nama_guru']."</center>";
            $nestedData[]	= "<center><b>".number_format($row['nilai_akhir'], 4, ',','.')."</b></center>";

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

    public function showAllGuruTerbaik(){
        $requestData	= $_REQUEST;
		$fetch			= $this->laporan->showAllGuruTerbaik($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
            $nestedData[]	= "<center>".$row['nama_guru']."</center>";
            $nestedData[]	= "<center>".number_format($row['nilai_akhir'], 4, ',','.')."</center>";
            $nestedData[]	= "<center>".$row['nama_periode']."</center>";

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

    public function CetakRanking($tahun){
        $guru   = $this->laporan->getRanking($tahun);
        if($guru->num_rows() > 0){
            $this->load->library('cfpdf');
            $judul  = "Laporan Ranking Guru Tahun Ajaran ".$guru->row()->nama_periode;

            $image  = base_url()."assets/images/logo.png";
            $pdf    = new FPDF();
            $pdf->AddPage();
            $pdf->SetTitle($judul);
            $pdf->setFont('Arial', 'b', 13);
            $pdf->cell(40, 40, $pdf->Image($image, 10, 13, 30), 0, 0, "C");
            $pdf->cell(110, 8, "YAYASAN PENGEMBANGAN SAIN DAN TEKONOLOGI PUSTEK", 0, 1, "C");
            $pdf->setFont('Arial', '', 12);
            $pdf->cell(0, 8, "SEKOLAH MENENGAH KEJURUAN", 0, 1, "C");
            $pdf->setFont('Arial', 'b', 12);
            $pdf->cell(0, 8, "SMK PUSTEK SERPONG", 0, 1, "C");
            $pdf->setFont('Arial', '', 10);
            $pdf->cell(0, 8, "Paket Kehlian : Teknik Permesinan, Teknik Kendaraan Ringan, Teknik Sepeda Motor, ", 0, 1, "C");
            $pdf->cell(0, 8, "Teknik Komputer Jaringan, Multimedia, Akuntansi, Administrasi Perkantoran", 0, 1, "C");
            $pdf->setFont('Arial', '', 12);
            $pdf->cell(0, 8, "TERAKREDITASI. A", 0, 1, "C");
            $pdf->setFont('Arial', '', 10);
            $pdf->cell(0, 8, "Jl. Raya Serpong No. 17 Priyang Kelurahan Pondok Jagung (Samping WTC Matahari) Serpong Utara", 0, 1, "C");
            $pdf->cell(0, 8, "Kota Tangerang Selatan Provinsi Banten Telp/Fax 021 5388243 Website : http://smk.pustekserpong.com/", 0, 1, "C");
            $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
            $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
            $pdf->setFont('Arial', '', 11);
            $pdf->cell(0, 8, "", 0, 1, "C");
            $pdf->cell(0, 8, "LAPORAN RANKING GURU", 0, 1, "C");
            $pdf->cell(0, 8, "SMK PUSTEK SERPONG", 0, 1, "C");
            $pdf->Ln();
            $pdf->cell(10, 7, "No", 1, 0, "C");
            $pdf->cell(110, 7, "Nama Guru", 1, 0, "C");
            $pdf->cell(70, 7, "Nilai Akhir", 1, 0, "C");
            $pdf->Ln();
            $no = 1;
            foreach($guru->result() AS $data){
                $pdf->cell(10, 7, $no++, 1, 0, "C");
                $pdf->cell(110, 7, $data->nama_guru, 1, 0, "L");
                $pdf->cell(70, 7, number_format($data->nilai_akhir, 4, ',','.'), 1, 0, "C");
                $pdf->Ln();
            }
            $pdf->Ln();
            $pdf->cell(0, 8, "Tangerang Selatan, ".date('d F Y'), 0, 1, "R");
            $pdf->cell(0, 8, "Kepala Sekolah SMK PUSTEK", 0, 1, "R");
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->cell(0, 8, "Dr. H.Mahthodah, S. M.Si", 0, 1, "R");
            $pdf->cell(0, 8, "NIP. 19600801 198411 1 001", 0, 0, "R");


            $pdf->Output($judul, "I");
        }else{
            echo "Tidak ada penilaian pada tahun ajaran tersebut.";
        }
    }

    public function cetakkinerjaguru($tahun){
        $guru   = $this->laporan->getEvaluasi($tahun);
        $kriteria = $this->laporan->getKriteria();
        if($guru->num_rows() > 0){
            $this->load->library('cfpdf');
            $judul  = "Laporan Evaluasi Guru Tahun Ajaran ".$guru->row()->nama_periode;

            $image  = base_url()."assets/images/logo.png";
            $pdf    = new FPDF();
            $pdf->AddPage();
            $pdf->SetTitle($judul);
            $pdf->setFont('Arial', 'b', 13);
            $pdf->cell(40, 40, $pdf->Image($image, 10, 13, 30), 0, 0, "C");
            $pdf->cell(110, 8, "YAYASAN PENGEMBANGAN SAIN DAN TEKONOLOGI PUSTEK", 0, 1, "C");
            $pdf->setFont('Arial', '', 12);
            $pdf->cell(0, 8, "SEKOLAH MENENGAH KEJURUAN", 0, 1, "C");
            $pdf->setFont('Arial', 'b', 12);
            $pdf->cell(0, 8, "SMK PUSTEK SERPONG", 0, 1, "C");
            $pdf->setFont('Arial', '', 10);
            $pdf->cell(0, 8, "Paket Kehlian : Teknik Permesinan, Teknik Kendaraan Ringan, Teknik Sepeda Motor, ", 0, 1, "C");
            $pdf->cell(0, 8, "Teknik Komputer Jaringan, Multimedia, Akuntansi, Administrasi Perkantoran", 0, 1, "C");
            $pdf->setFont('Arial', '', 12);
            $pdf->cell(0, 8, "TERAKREDITASI. A", 0, 1, "C");
            $pdf->setFont('Arial', '', 10);
            $pdf->cell(0, 8, "Jl. Raya Serpong No. 17 Priyang Kelurahan Pondok Jagung (Samping WTC Matahari) Serpong Utara", 0, 1, "C");
            $pdf->cell(0, 8, "Kota Tangerang Selatan Provinsi Banten Telp/Fax 021 5388243 Website : http://smk.pustekserpong.com/", 0, 1, "C");
            $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
            $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
            $pdf->setFont('Arial', '', 11);
            $pdf->cell(0, 8, "", 0, 1, "C");
            $pdf->cell(0, 8, "LAPORAN RANKING GURU", 0, 1, "C");
            $pdf->cell(0, 8, "SMK PUSTEK SERPONG", 0, 1, "C");
            $pdf->Ln();
            $pdf->cell(10, 7, "No", 1, 0, "C");
            $pdf->cell(55, 7, "Nama Guru", 1, 0, "C");
            foreach($kriteria->result() AS $kriterias){
                $pdf->cell(25, 7, $kriterias->nama_kriteria, 1, 0, "C");    
            }
            $pdf->cell(25, 7, "Nilai Akhir", 1, 0, "C");
            $pdf->Ln();
            $no = 1;
            foreach($guru->result() AS $data){
                $pdf->cell(10, 7, $no++, 1, 0, "C");
                $pdf->cell(55, 7, $data->nama, 1, 0, "L");
                $pdf->cell(25, 7, number_format($data->k1, 4, ',','.'), 1, 0, "C");
                $pdf->cell(25, 7, number_format($data->k2, 4, ',','.'), 1, 0, "C");
                $pdf->cell(25, 7, number_format($data->k3, 4, ',','.'), 1, 0, "C");
                $pdf->cell(25, 7, number_format($data->k4, 4, ',','.'), 1, 0, "C");
                $pdf->cell(25, 7, number_format($data->nilai_akhir, 4, ',','.'), 1, 0, "C");
                $pdf->Ln();
            }
            $pdf->Ln();
            $pdf->cell(0, 8, "Tangerang Selatan, ".date('d F Y'), 0, 1, "R");
            $pdf->cell(0, 8, "Kepala Sekolah SMK PUSTEK", 0, 1, "R");
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->cell(0, 8, "Dr. H.Mahthodah, S. M.Si", 0, 1, "R");
            $pdf->cell(0, 8, "NIP. 19600801 198411 1 001", 0, 0, "R");


            $pdf->Output($judul, "I");
        }else{
            echo "Tidak ada penilaian pada tahun ajaran tersebut.";
        }
    }

    public function cetakGuruTerbaik(){
        $guru   = $this->laporan->getHasilGuruTerbaik();
        $this->load->library('cfpdf');
        $judul  = "Laporan Hasil Guru Terbaik";

        $image  = base_url()."assets/images/logo.png";
        $pdf    = new FPDF();
        $pdf->AddPage();
        $pdf->SetTitle($judul);
        $pdf->setFont('Arial', 'b', 13);
        $pdf->cell(40, 40, $pdf->Image($image, 10, 13, 30), 0, 0, "C");
        $pdf->cell(110, 8, "YAYASAN PENGEMBANGAN SAIN DAN TEKONOLOGI PUSTEK", 0, 1, "C");
        $pdf->setFont('Arial', '', 12);
        $pdf->cell(0, 8, "SEKOLAH MENENGAH KEJURUAN", 0, 1, "C");
        $pdf->setFont('Arial', 'b', 12);
        $pdf->cell(0, 8, "SMK PUSTEK SERPONG", 0, 1, "C");
        $pdf->setFont('Arial', '', 10);
        $pdf->cell(0, 8, "Paket Kehlian : Teknik Permesinan, Teknik Kendaraan Ringan, Teknik Sepeda Motor, ", 0, 1, "C");
        $pdf->cell(0, 8, "Teknik Komputer Jaringan, Multimedia, Akuntansi, Administrasi Perkantoran", 0, 1, "C");
        $pdf->setFont('Arial', '', 12);
        $pdf->cell(0, 8, "TERAKREDITASI. A", 0, 1, "C");
        $pdf->setFont('Arial', '', 10);
        $pdf->cell(0, 8, "Jl. Raya Serpong No. 17 Priyang Kelurahan Pondok Jagung (Samping WTC Matahari) Serpong Utara", 0, 1, "C");
        $pdf->cell(0, 8, "Kota Tangerang Selatan Provinsi Banten Telp/Fax 021 5388243 Website : http://smk.pustekserpong.com/", 0, 1, "C");
        $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
        $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
        $pdf->setFont('Arial', '', 11);
        $pdf->cell(0, 8, "", 0, 1, "C");
        $pdf->cell(0, 8, "LAPORAN HASIL GURU TERBAIK", 0, 1, "C");
        $pdf->cell(0, 8, "SMK PUSTEK SERPONG", 0, 1, "C");
        $pdf->Ln();
        $pdf->cell(10, 7, "No", 1, 0, "C");
        $pdf->cell(70, 7, "Nama Guru", 1, 0, "C");
        $pdf->cell(55, 7, "Nilai Akhir", 1, 0, "C");
        $pdf->cell(55, 7, "Tahun Ajaran", 1, 0, "C");
        $pdf->Ln();
        $no = 1;
        foreach($guru->result() AS $data){
            $pdf->cell(10, 7, $no++, 1, 0, "C");
            $pdf->cell(70, 7, $data->nama_guru, 1, 0, "L");
            $pdf->cell(55, 7, number_format($data->nilai_akhir, 4, ',','.'), 1, 0, "C");
            $pdf->cell(55, 7, $data->nama_periode, 1, 0, "C");
            $pdf->Ln();
        }
        $pdf->Ln();
        $pdf->cell(0, 8, "Tangerang Selatan, ".date('d F Y'), 0, 1, "R");
        $pdf->cell(0, 8, "Kepala Sekolah SMK PUSTEK", 0, 1, "R");
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->cell(0, 8, "Dr. H.Mahthodah, S. M.Si", 0, 1, "R");
        $pdf->cell(0, 8, "NIP. 19600801 198411 1 001", 0, 0, "R");


        $pdf->Output($judul, "I");
    }

}

/* End of file Laporan.php */
