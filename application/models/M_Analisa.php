<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_analisa extends CI_Model {

    public function insertNilai($guru, $kriteria, $tahunajaran, $nilai){
        $data = array(
            'kode_guru'     => $guru,
            'id_kriteria'   => $kriteria,
            'nilai'         => $nilai,
            'id_periode'  => $tahunajaran
        );
        return $this->db->insert('nilai', $data);
    }

    public function insertHasil($data){
        return $this->db->insert('hasil', $data);
    }

    public function cek_validasi_guru_nilai($guru, $kriteria, $tahun){
        return $this->db->get_where('nilai', ['kode_guru' => $guru, 'id_kriteria' => $kriteria, 'id_periode' => $tahun]);
    }

    public function getNilaiEvaluasi($periode){
        return $this->db->get_where('nilai_evaluasi', ['periode' => $periode]);
    }

    public function getNilaiMaxMin($periode){
        $sql    = "SELECT
                    (CASE WHEN cb_1 = 'cost' THEN MIN(k1) ELSE MAX(k1) END) AS nilai_k1,
                    (CASE WHEN cb_2 = 'cost' THEN MIN(k2) ELSE MAX(k2) END) AS nilai_k2,
                    (CASE WHEN cb_3 = 'cost' THEN MIN(k3) ELSE MAX(k3) END) AS nilai_k3,
                    (CASE WHEN cb_4 = 'cost' THEN MIN(k4) ELSE MAX(k4) END) AS nilai_k4
                    FROM
                        nilai_evaluasi
                    WHERE
                        periode = '$periode'";
        return $this->db->query($sql);
    }

    public function getNilai($tahun){
        $this->db->join('guru b', 'b.kode_guru = a.kode_guru', 'left');
        $this->db->order_by('nilai_akhir', 'desc');
        return $this->db->get_where('hasil a', ['id_periode' => $tahun]);
    }

    public function cekHasil($tahun){
        $this->db->join('guru b', 'b.kode_guru = a.kode_guru', 'left');
        $this->db->order_by('nilai_akhir', 'desc');
        $this->db->where_in('status', 'Terpilih');
        return $this->db->get_where('hasil a', ['id_periode' => $tahun]);
    }

    public function updateHasil($guru, $tahun){
        $this->db->where('kode_guru', $guru);
        $this->db->where('id_periode', $tahun);
        return $this->db->update('hasil', ['status' => 'Terpilih']);
    }

    public function getGuruTerbaik($tahun){
        $this->db->join('guru b', 'b.kode_guru = a.kode_guru');
        $this->db->join('periode c', 'c.id_periode = a.id_periode', 'left');
        return $this->db->get_where('hasil a', ['a.id_periode' => $tahun, 'status' => 'Terpilih']);
    }

    public function getMax($id){
		$sql = "SELECT
				max(t1.absen) AS absen, max(t1.pendagogik) AS pendagogik, 
				max(t1.kepribadian) AS kepribadian, max(t1.sosial) AS sosial, 
				max(t1.professional) AS professional
				FROM
				(
				SELECT nama_guru, dk1.nip, id_evaluasi, nama_kriteria, dk1.id_kriteria, bobot, jumlah_nilai AS absen,
				NULL AS pendagogik, NULL AS kepribadian, NULL AS sosial, 
				NULL AS professional FROM detail_kriteria dk1, guru g1, kriteria kr1
				WHERE dk1.id_kriteria = kr1.id_kriteria AND dk1.nip = g1.nip AND dk1.id_kriteria = 1
				UNION
				SELECT nama_guru, dk1.nip, id_evaluasi, nama_kriteria, dk1.id_kriteria, bobot, NULL AS absen,
				jumlah_nilai AS pendagogik, NULL AS kepribadian, NULL AS sosial, 
				NULL AS professional FROM detail_kriteria dk1, guru g1, kriteria kr1
				WHERE dk1.id_kriteria = kr1.id_kriteria AND dk1.nip = g1.nip AND dk1.id_kriteria = 2
				UNION
				SELECT nama_guru, dk1.nip, id_evaluasi, nama_kriteria, dk1.id_kriteria, bobot, NULL AS absen,
				NULL AS pendagogik, jumlah_nilai AS kepribadian, NULL AS sosial, 
				NULL AS professional FROM detail_kriteria dk1, guru g1, kriteria kr1
				WHERE dk1.id_kriteria = kr1.id_kriteria AND dk1.nip = g1.nip AND dk1.id_kriteria = 3
				UNION
				SELECT nama_guru, dk1.nip, id_evaluasi, nama_kriteria, dk1.id_kriteria, bobot, NULL AS absen,
				NULL AS pendagogik, NULL AS kepribadian, jumlah_nilai AS sosial, 
				NULL AS professional FROM detail_kriteria dk1, guru g1, kriteria kr1
				WHERE dk1.id_kriteria = kr1.id_kriteria AND dk1.nip = g1.nip AND dk1.id_kriteria = 4
				UNION
				SELECT nama_guru, dk1.nip, id_evaluasi, nama_kriteria, dk1.id_kriteria, bobot, NULL AS absen,
				NULL AS pendagogik, NULL AS kepribadian, NULL AS sosial, 
				jumlah_nilai AS professional FROM detail_kriteria dk1, guru g1, kriteria kr1
				WHERE dk1.id_kriteria = kr1.id_kriteria AND dk1.nip = g1.nip AND dk1.id_kriteria = 5
				) AS t1
				WHERE t1.id_evaluasi = '$id'";

		return $this->db->query($sql);
	}

}