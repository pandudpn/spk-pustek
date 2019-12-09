<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisa extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Login', 'login');
        $this->load->model('M_Data', 'data');
        $this->load->model('M_Analisa', 'analisa');
        if(!$this->session->userdata('login')){
            redirect(base_url());
        }
    }

    public function perhitungan(){
        if($this->input->post()){
            $i  = 0;
            $nilai_akhir = 0;
            foreach($this->input->post('guru') AS $key => $val){
                $guru           = $val;
                $kriteria       = $this->input->post('kriteria')[$key];
                $tahunajaran    = $this->input->post('tahunajaran')[$key];
                $nilai          = $this->input->post('nilai_kriteria')[$key];
                $periode        = $this->input->post('periode')[$key];

                $cek_validasi   = $this->analisa->cek_validasi_guru_nilai($guru, $kriteria, $tahunajaran);

                if($cek_validasi->num_rows() > 0){
                    $status['status']   = "error";
                    $status['pesan']    = "<font style='color:red;' size='3'>Guru Tersebut sudah pernah di nilai pada Periode <i><b>".$periode."</b></i></font>";
                }else{
                    $ins    = $this->analisa->insertNilai($guru, $kriteria, $tahunajaran, $nilai);

                    if($ins){
                        $i++;
                    }
                }
            }

            if($i > 0){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='3'><i class='mdi mdi-check-outline'></i> Berhasil membuat alternatif penilaian</font>";
            }
            echo json_encode($status);
        }else{
            $data['login']          = $this->login->getDataLogin();
            $data['judul']          = "Analisa Perhitungan - SMK Pustek";
            $data['guru']           = $this->data->getGuru()->result();
            $data['kriteria']       = $this->data->getKriteria()->result();
            $data['subkriteria']    = $this->data->getSubkriteria()->result();
            $data['periode']        = $this->data->getPeriode()->result();
            $this->load->view('analisa/nilai', $data);
        }
    }

    public function normalisasi($periode){
        if($this->input->post()){
            foreach($this->input->post('guru') AS $key => $val){
                $ins    = [
                    'kode_guru'     => $val,
                    'nilai_akhir'   => $this->input->post('nilai_akhir')[$key],
                    'id_periode'    => $periode,
                    'status'        => 'Tidak Terpilih'
                ];

                $insert = $this->analisa->insertHasil($ins);
                if($insert){
                    $status['status']   = 'success';
                    $status['pesan']    = '<font style="color:green;" size="3"><i class="mdi mdi-check-all"></i> Berhasil menyimpan hasil perhitungan.</font>';
                }
            }
            echo json_encode($status);
        }else{
            $data['login']      = $this->login->getDataLogin();
            $data['judul']      = 'Normalisasi Perhitungan';
            $data['periode']    = $periode;
            $data['evaluasi']   = $this->analisa->getNilaiEvaluasi($periode)->result();
            $data['maxmin']     = $this->analisa->getNilaiMaxMin($periode)->result();
            $data['kriteria']   = $this->data->getKriteria()->result();

            $this->load->view('analisa/normalisasi', $data);
        }
    }

    public function pilih(){
        $data['login']      = $this->login->getDataLogin();
        $data['judul']      = "Pemilihan Guru Terbaik - SMK Pustek";
        $data['periode']    = $this->data->getPeriode()->result();
        $this->load->view('analisa/pilih', $data);
    }

    public function hasilkeputusan($tahun){
        if($this->input->post()){
            $guru   = $this->input->post('guru');
            
            $update = $this->analisa->updateHasil($guru, $tahun);

            if($update){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='3'>Berhasil memilih guru terbaik pada periode <b>".$tahun."</b></font>";
            }else{
                $status['status']   = "error";
                $status['pesan']    = "<font style='color:red; size='3'>Terjadi kesalahan pada JSON, Silahkan periksa kembali</font>";
            }
            echo json_encode($status);
        }else{
            $data['hasil']      = $this->analisa->getNilai($tahun);
            $data['cek']        = $this->analisa->cekHasil($tahun);
            $data['tahun']      = $tahun;
            $this->load->view('analisa/hasilkeputusan', $data);
        }
    }

    public function cetakHasilKeputusan(){
        if($this->input->get('tahunajaran') != ''){
            echo json_encode($this->analisa->getGuruTerbaik($this->input->get('tahunajaran'))->row());
        }else{
            $data['login']  = $this->login->getDataLogin();
            $data['judul']  = "Cetak Hasil Keputusan - SMK Pustek";
            $data['periode']= $this->data->getPeriode()->result();

            $this->load->view('analisa/cetakhasilkeputusan', $data);
        }
    }

    public function cetakGuruTerbaik($tahunajaran){
        $guru   = $this->analisa->getGuruTerbaik($tahunajaran);
        $this->load->library('cfpdf');
        $judul  = "Laporan Hasil Pemilihan Guru Terbaik ".$guru->row()->nama_periode;

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
        $pdf->setFont('Arial', 'b', 11);
        $pdf->cell(0, 8, "", 0, 1, "C");
        $pdf->cell(0, 8, "LAPORAN HASIL PEMILIHAN GURU TERBAIK", 0, 1, "C");
        $pdf->Ln();
        $pdf->setFont('Arial', '', 11);
        $pdf->cell(0, 8, 'Berdasarkan kebijakan SMK Pustek Serpong, hasil seleksi guru terbaik pada tahun '. $guru->row()->nama_periode .' adalah : ', 0, 1, 'L');
        $pdf->Ln();
        $pdf->cell(60, 8, 'Nama Guru', 0, 0, 'L');
        $pdf->cell(10, 8, ':', 0, 0, 'L');
        $pdf->cell(120, 8, $guru->row()->nama_guru, 0, 0, 'L');
        $pdf->Ln();
        $pdf->cell(60, 8, 'Kode Guru', 0, 0, 'L');
        $pdf->cell(10, 8, ':', 0, 0, 'L');
        $pdf->cell(120, 8, $guru->row()->kode_guru, 0, 0, 'L');
        $pdf->Ln();
        $pdf->cell(60, 8, 'Jenis Guru', 0, 0, 'L');
        $pdf->cell(10, 8, ':', 0, 0, 'L');
        $pdf->cell(120, 8, $guru->row()->jenis, 0, 0, 'L');
        $pdf->Ln();
        $pdf->cell(60, 8, 'Nama Sekolah', 0, 0, 'L');
        $pdf->cell(10, 8, ':', 0, 0, 'L');
        $pdf->cell(120, 8, 'SMK Pustek Serpong', 0, 0, 'L');
        $pdf->Ln();
        $pdf->cell(60, 8, 'Periode Penilaian', 0, 0, 'L');
        $pdf->cell(10, 8, ':', 0, 0, 'L');
        $pdf->cell(120, 8, $guru->row()->nama_periode, 0, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->cell(0, 8, "Demikian surat ini dibuat agar dipergunakan sebagaimana mestinya.", 0, 1, "L");
        $pdf->Ln();
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