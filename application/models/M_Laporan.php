<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Laporan extends CI_Model {

    public function getRanking($tahun){
        $this->db->join('guru b', 'b.kode_guru = a.kode_guru', 'left');
        $this->db->join('periode c', 'c.id_periode = a.id_periode', 'left');
        $this->db->order_by('nilai_akhir', 'desc');
        return $this->db->get_where('hasil a', ['a.id_periode' => $tahun]);
    }

    public function getKriteria(){
        return $this->db->get('kriteria');
    }

    public function getHasilGuruTerbaik(){
        $this->db->join('guru b', 'b.kode_guru = a.kode_guru');
        $this->db->join('periode c', 'c.id_periode = a.id_periode');
        return $this->db->get_where('hasil a', ['status' => 'Terpilih']);
    }

    public function showAllRanking($tahun, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
                b.kode_guru,
                nama_guru, nilai_akhir,
                a.id_periode,
                nama_periode
			FROM 
                hasil a
            LEFT JOIN
                guru b
            ON
                b.kode_guru = a.kode_guru
            LEFT JOIN
                periode c
            ON
                c.id_periode = a.id_periode, (SELECT @row := 0) r
            WHERE
                a.id_periode = '$tahun'
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				`nama_guru` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR `nilai_akhir` LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY nilai_akhir DESC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }

    public function showAllGuruTerbaik($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
                b.kode_guru,
                nama_guru, nilai_akhir,
                c.id_periode,
                nama_periode
			FROM 
                hasil a
            LEFT JOIN
                guru b
            ON
                b.kode_guru = a.kode_guru
            LEFT JOIN
                periode c
            ON
                c.id_periode = a.id_periode, (SELECT @row := 0) r
            WHERE
                status = 'Terpilih'
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				`nama_guru` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR `nilai_akhir` LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
        
		$sql .= " ORDER BY id_periode DESC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }
    
    public function getEvaluasi($tahun){
        $this->db->order_by('status', 'desc');
        $this->db->join('hasil b', 'b.kode_guru = a.kode_guru', 'left');
        $this->db->join('periode c', 'c.id_periode = a.periode', 'left');
        return $this->db->get_where('nilai_evaluasi a', ['periode' => $tahun]);
    }

}

/* End of file M_Laporan.php */
