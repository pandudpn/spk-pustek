<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Data extends CI_Model {

    public function showAllUser($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
                id_user,
                nama,
                username,
				akses
			FROM 
                users, (SELECT @row := 0) r
            WHERE
                id_user != ".$this->session->userdata('id')."
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				`nama` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR `username` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR (SELECT CASE akses WHEN 1 THEN 'Administrator' ELSE 'Kepala Sekolah' END) LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY id_user DESC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	public function showAllGuru($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
                kode_guru,
                nama_guru,
                no_telp,
				alamat,
				jenis,
				date_format(ts_guru, '%d %M %Y') as tanggal,
				jk,
				tempat_lahir, tgl_lahir
			FROM 
                guru, (SELECT @row := 0) r
            ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " WHERE ( ";    
			$sql .= "
				`nama_guru` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR `no_telp` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR `alamat` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR `pendidiakn` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR date_format(ts_guru, '%d %M %Y') LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY nama_guru ASC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	public function showAllPeriode($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
                id_periode,
                nama_periode
			FROM 
                periode, (SELECT @row := 0) r
            ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " WHERE ( ";    
			$sql .= "
				`nama_periode` LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY id_periode ASC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	public function showAllKriteria($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
				id_kriteria,
				nama_kriteria,
				bobot,
				cb
			FROM 
                kriteria, (SELECT @row := 0) r
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				`nama_kriteria` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR `bobot` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR `cb` LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY nama_kriteria ASC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	public function showAllSubkriteria($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
				b.id_kriteria,
				id_subkriteria,
				nama_kriteria, nama_subkriteria
			FROM 
				subkriteria a
			INNER JOIN
				kriteria b
			ON
				b.id_kriteria = a.id_kriteria, (SELECT @row := 0) r
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				`nama_kriteria` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR `nama_subkriteria` LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY b.id_kriteria ASC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	public function insertUser($nama, $username, $password){
		$data = array(
			'nama'		=> $nama,
			'username'	=> $username,
			'password'	=> $password,
			'akses'		=> 2
		);
		return $this->db->insert('users', $data);
	}

	public function insertGuru($nip, $nama, $telp, $alamat, $pendidikan, $jk, $tempat, $tgl_lahir){
		$data = array(
			'kode_guru'	=> $nip,
			'nama_guru'	=> $nama,
			'no_telp'	=> $telp,
			'alamat'	=> $alamat,
			'jenis'		=> $pendidikan,
			'jk'		=> $jk,
			'tempat_lahir' => $tempat,
			'tgl_lahir'	=> $tgl_lahir
		);
		return $this->db->insert('guru', $data);
	}

	public function insertPeriode($nama){
		$data = array(
			'nama_periode'	=> $nama,
		);
		return $this->db->insert('periode', $data);
	}

	public function insertKriteria($nama, $bobot, $cb){
		$data = array(
			'nama_kriteria'	=> $nama,
			'bobot'			=> $bobot,
			'cb'			=> $cb
		);
		return $this->db->insert('kriteria', $data);
	}

	public function insertSubkriteria($kriteria, $nama){
		$data = array(
			'id_kriteria'		=> $kriteria,
			'nama_subkriteria'	=> $nama
		);
		return $this->db->insert('subkriteria', $data);
	}

	public function hapusUser($id){
		$this->db->where('id_user', $id);
		return $this->db->delete('users');
	}

	public function hapusGuru($nip){
		$this->db->where('kode_guru', $nip);
		return $this->db->delete('guru');
	}

	public function hapusPeriode($id){
		$this->db->where('id_periode', $id);
		return $this->db->delete('periode');
	}

	public function hapusSubkriteria($id){
		$this->db->where('id_subkriteria', $id);
		return $this->db->delete('subkriteria');
	}

	public function editUser($id){
		return $this->db->get_where('users', ['id_user' => $id]);
	}

	public function editGuru($nip){
		return $this->db->get_where('guru', ['kode_guru' => $nip]);
	}

	public function editPeriode($id){
		return $this->db->get_where('periode', ['id_periode' => $id]);
	}

	public function editKriteria($id){
		return $this->db->get_where('kriteria', ['id_kriteria' => $id]);
	}

	public function editSubkriteria($id){
		return $this->db->get_where('subkriteria', ['id_subkriteria' => $id]);
	}
	
	public function updateUser($id, $nama){
		$this->db->where('id_user', $id);
		return $this->db->update('users', ['nama' => $nama]);
	}

	public function updateGuru($nip, $nama, $alamat, $telp, $pendidikan, $jk, $tempat, $tgl_lahir){
		$data = array(
			'nama_guru'	=> $nama,
			'alamat'	=> $alamat,
			'no_telp'	=> $telp,
			'jenis'=> $pendidikan,
			'jk'		=> $jk,
			'tempat_lahir' => $tempat,
			'tgl_lahir'	=> $tgl_lahir
		);
		$this->db->where('kode_guru', $nip);
		return $this->db->update('guru', $data);
	}

	public function updatePeriode($id, $nama){
		$data = array(
			'nama_periode'	=> $nama,
		);
		$this->db->where('id_periode', $id);
		return $this->db->update('periode', $data);
	}

	public function updateKriteria($id, $nama, $bobot, $cb){
		$this->db->where('id_kriteria', $id);
		return $this->db->update('kriteria', ['nama_kriteria' => $nama, 'bobot' => $bobot, 'cb' => $cb]);
	}

	public function updateSubkriteria($id, $kriteria, $nama){
		$this->db->where('id_subkriteria', $id);
		return $this->db->update('subkriteria', ['id_kriteria' => $kriteria, 'nama_subkriteria' => $nama]);
	}

	public function cek_username($username){
		return $this->db->get_where('users', ['username' => $username]);
	}

	public function cek_nip($nip){
		return $this->db->get_where('guru', ['kode_guru' => $nip]);
	}

	public function getGuru(){
		return $this->db->get('guru');
	}

	public function getKriteria(){
		return $this->db->get('kriteria');
	}

	public function getSubkriteria(){
		return $this->db->get('subkriteria');
	}

	public function getPeriode(){
		return $this->db->get('periode');
	}

}

/* End of file M_Data.php */
