<?php

class M_paket extends CI_Model{
	protected $_table = 'paket';

	public function lihat(){
		$this->db->order_by('harga', 'ASC');
		$query = $this->db->get($this->_table);
		return $query->result();
	}

	public function jumlah(){
		$query = $this->db->get($this->_table);
		return $query->num_rows();
	}

	private function _uploadImage()
	{
		$config['upload_path']          = './Gambar/Paket/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['file_name']            = $this->product_id;
		$config['overwrite']			= true;
		$config['max_size']             = 2000; // 1MB
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('image')) {
			return $this->upload->data("file_name");
		}
		
		return "default.jpg";
	}

	public function lihat_stok(){
		$query = $this->db->get_where($this->_table, 'stok >= 0');
		return $query->result();
	}

	public function lihat_stok2(){
		$query = $this->db->get_where($this->_table, 'stok > 0');
		return $query->result();
	}

	public function lihat_id_1($id_paket){
		$query = $this->db->get_where($this->_table, ['id_paket' => $id_paket]);
		return $query->row();
	}
	
	public function lihat_id_2($id_paket){
		$query = $this->db->get_where($this->_table, ['id_paket' => $id_paket]);
		return $query->result();
	}

	public function lihat_nama_paket($nama_paket){
		$query = $this->db->select('*');
		$query = $this->db->where(['nama_paket' => $nama_paket]);
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	public function tambah($data){
		return $this->db->insert($this->_table, $data);
	}

	public function plus_stok($stok, $nama_paket){
		$query = $this->db->set('stok', 'stok+' . $stok, false);
		$query = $this->db->where('nama_paket', $nama_paket);
		$query = $this->db->update($this->_table);
		return $query;
	}

	public function min_stok($stok, $nama_paket){
		$query = $this->db->set('stok', 'stok-' . $stok, false);
		$query = $this->db->where('nama_paket', $nama_paket);
		$query = $this->db->update($this->_table);
		return $query;
	}

	public function ubah($data, $id_paket){
		$query = $this->db->set($data);
		$query = $this->db->where(['id_paket' => $id_paket]);
		$query = $this->db->update($this->_table);
		return $query;
	}

	public function hapus($id_paket){
		return $this->db->delete($this->_table, ['id_paket' => $id_paket]);
	}
}