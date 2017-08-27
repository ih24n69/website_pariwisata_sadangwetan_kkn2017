<?php
class M_kontak_perangkat extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->_table='tbl_kontak_perangkat';

		//get instance
		$this->CI = get_instance();
	}
	
	public function get_kontak_perangkat_flexigrid()
    {
        //Build contents query
		
		$this->db->select('*')->from($this->_table);
		
		$this->CI->flexigrid->build_query();
		
        //Get contents
         $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_kontak_perangkat) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count; 
		
        //Return all
        return $return;
    }
  
	function insertKontakPerangkat($data)
	{
		$this->db->insert($this->_table, $data);
	}
	
	function updateKontakPerangkat($where, $data)
	{
		$this->db->where($where);
		$this->db->update('tbl_kontak_perangkat', $data);
		return $this->db->affected_rows();
	}	
	
	function deleteKontakPerangkat($id)
	{
		$this->db->where('id_kontak_perangkat', $id);
		$this->db->delete($this->_table);
	}
	
	function getKontakPerangkatByIdKontakPerangkat($id)
	{
		return $this->db->get_where('tbl_kontak_perangkat',array('id_kontak_perangkat' => $id))->row();
	}

	public function getKontakPerangkat(){
		return $this->db->get('tbl_kontak_perangkat')->result();
	}
	
	public function getKontakPerangkatRow(){

		return $this->db->count_all_results('tbl_kontak_perangkat');
	}
	
	function getNamaPerangkatByIdKontakPerangkat($id_kontak_perangkat)
	{
		$this->db->select('nama_perangkat');
		$this->db->where('id_kontak_perangkat', $id_kontak_perangkat);
		$q = $this->db->get('tbl_kontak_perangkat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['nama_perangkat']);
	}
	
	function getJabatanByIdKontakPerangkat($id_kontak_perangkat)
	{
		$this->db->select('jabatan_perangkat');
		$this->db->where('id_kontak_perangkat', $id_kontak_perangkat);
		$q = $this->db->get('tbl_kontak_perangkat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['jabatan_perangkat']);
	}
	
	function getNomerHpByIdKontakPerangkat($id_kontak_perangkat)
	{
		$this->db->select('nohp_perangkat');
		$this->db->where('id_kontak_perangkat', $id_kontak_perangkat);
		$q = $this->db->get('tbl_kontak_perangkat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['nohp_perangkat']);
	}
	function getAlamatByIdKontakPerangkat($id_kontak_perangkat)
	{
		$this->db->select('alamat_perangkat');
		$this->db->where('id_kontak_perangkat', $id_kontak_perangkat);
		$q = $this->db->get('tbl_kontak_perangkat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['alamat_perangkat']);
	}
	
	function getFotoPerangkatByIdKontakPerangkat($id_kontak_perangkat)
	{
		$this->db->select('foto_perangkat');
		$this->db->where('id_kontak_perangkat', $id_kontak_perangkat);
		$q = $this->db->get('tbl_kontak_perangkat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['foto_perangkat']);
	}
}
?>
