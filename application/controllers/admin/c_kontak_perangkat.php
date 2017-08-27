<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_kontak_perangkat extends CI_Controller {
	function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_kontak_perangkat');
        $this->load->helper('url');
    }
	
	function index()    
	{
		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$this->lists();
		}
		else
			redirect('c_login', 'refresh');
    }

    function lists() 
	{
		$colModel['id_kontak_perangkat'] = array('ID',30,TRUE,'center',2);
        $colModel['nama_perangkat'] = array('Nama Perangkat',250,TRUE,'left',2);
        $colModel['jabatan_perangkat'] = array('Jabatan',150,TRUE,'left',2);
		$colModel['nohp_perangkat'] = array('Nomor HP',150,TRUE,'left',2);
		$colModel['alamat_perangkat'] = array('Alamat',150,TRUE,'left',2);
		$colModel['foto_perangkat'] = array('Foto Perangkat',250,TRUE,'left',2);
		$colModel['aksi'] = array('AKSI',50,FALSE,'center',2);
		
		//Populate flexigrid buttons..
        
        //$buttons[] = array('Delete Selected Items','delete','btn');
        $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
		$buttons[] = array('Add','add','btn');
        $buttons[] = array('separator');
        $buttons[] = array('Delete Selected Items','delete','btn');
        $buttons[] = array('separator');
       		
        $gridParams = array(
            'height' => 200,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
			);

        $grid_js = build_grid_js('flex1',site_url('admin/c_kontak_perangkat/load_data'),$colModel,'id_kontak_perangkat','asc',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'PERANGKAT DESA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('kontak_perangkat/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() 
	{
        $this->load->library('flexigrid');
		array('id_kontak_perangkat','nama_perangkat','jabatan_perangkat','nohp_perangkat','alamat_perangkat','foto_perangkat');
		//$valid_fields = array('id_keluarga');
		$this->flexigrid->validate_post('id_kontak_perangkat','asc',$valid_fields);
		$records = $this->m_kontak_perangkat->get_kontak_perangkat_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();	
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_kontak_perangkat,
                $row->id_kontak_perangkat,
				$row->nama_perangkat,
				$row->jabatan_perangkat,
                $row->nohp_perangkat,
				$row->alamat_perangkat,
				$row->foto_perangkat,		
			'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_kontak_perangkat(\''.$row->id_kontak_perangkat.'\')"/>
			<i class="fa fa-pencil"></i>
			</button>'
			);  
		}
		//Print please
		
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }

    function add()
    {
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$s['cek'] = $this->session->userdata('logged_in');
			
			$data['page_title'] = 'Tambah Kontak Perangkat';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('kontak_perangkat/v_tambah', $data, TRUE);		
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login','refresh');
    }

    function simpan_kontak_perangkat() {

		$nama_perangkat = $this->input->post('nama_perangkat', TRUE);
		$jabatan_perangkat = $this->input->post('jabatan_perangkat', TRUE);
		$nohp_perangkat = $this->input->post('nohp_perangkat', TRUE);
		$alamat_perangkat = $this->input->post('alamat_perangkat', TRUE);
		$foto_perangkat = $this->input->post('foto_perangkat', TRUE);

		$this->form_validation->set_rules('nama_perangkat', 'Nama Perangkat', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{
    	$generate= substr(sha1(uniqid(rand(), true)), 0, 3);

		//UPLOAD FOTO PERANGKAT
		$config['upload_path']   =   "./uploads/web/foto_perangkat/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png";
		$config['file_name'] = 'foto_'.$generate;	
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->initialize($config); 
		if(!$this->upload->do_upload('foto_perangkat'))
		{         
			$path_foto_perangkat = $path_foto_perangkat = "uploads/web/foto_perangkat/no_pic.jpg";    
		}
		else
		{
		  	$upload_foto_perangkat = $this->upload->data();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_foto_perangkat['full_path'];
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 570;
			$config['height']   = 225;
			$this->load->library('image_lib', $config); 
			$path_foto_perangkat = "uploads/web/foto_perangkat/".$upload_foto_perangkat['file_name'];
		}
		//END UPLOAD FOTO PERANGKAT
		
			$dataKontakPerangkat = array(
				'nama_perangkat' =>  $nama_perangkat,
				'jabatan_perangkat' =>  $jabatan_perangkat,
				'nohp_perangkat' =>  $nohp_perangkat,
				'alamat_perangkat' =>  $alamat_perangkat,
				'foto_perangkat' => $path_foto_perangkat
				);			
			$this->m_kontak_perangkat->insertKontakPerangkat($dataKontakPerangkat);
				
			redirect('admin/c_kontak_perangkat','refresh');
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['id_kontak_perangkat'] = $id;
			
			/* $konten_background = $this->m_slider_beranda->getKontenBackgroundByIdSliderBeranda($id);
			$konten_logo = $this->m_slider_beranda->getKontenLogoByIdSliderBeranda($id);
			
			$konten_background = str_replace('uploads/web/slider_beranda/','', $konten_background);
			$konten_logo = str_replace('uploads/web/slider_beranda/','', $konten_logo);
			
			$data['konten_background'] = $konten_background;
			$data['konten_logo'] = $konten_logo;
			 */
			
			$data['page_title'] = 'UBAH DATA PERANGKAT';
			$data['hasil'] = $this->m_kontak_perangkat->getKontakPerangkatByIdKontakPerangkat($id);
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('kontak_perangkat/v_ubah', $data, TRUE);

			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }

    function update_kontak_perangkat()
    {
    	$id_kontak_perangkat = $this->input->post('id_kontak_perangkat', TRUE);
		$nama_perangkat = $this->input->post('nama_perangkat', TRUE);
		$jabatan_perangkat = $this->input->post('jabatan_perangkat', TRUE);
		$nohp_perangkat = $this->input->post('nohp_perangkat', TRUE);
		$alamat_perangkat = $this->input->post('alamat_perangkat', TRUE);
		$foto_perangkat = $this->input->post('foto_perangkat', TRUE);

		$foto_perangkat = $this->m_kontak_perangkat->getFotoPerangkatByIdKontakPerangkat($id_kontak_perangkat);
		
		$foto_perangkat = str_replace('uploads/web/foto_perangkat/','', $foto_perangkat);
		
		$this->form_validation->set_rules('nama_perangkat', 'Nama Perangkat', 'required');
		if ($this->form_validation->run() == TRUE)
		{
		//UPLOAD FOTO PERANGKAT
		$config['upload_path']   =   "./uploads/web/foto_perangkat/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png";
		$config['file_name'] = $foto_perangkat;	
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->initialize($config); 
		if(!$this->upload->do_upload('foto_perangkat'))
		{         
			$path_foto_perangkat = $path_foto_perangkat = "uploads/web/foto_perangkat/".$foto_perangkat;    
		}
		else
		{
		  	$upload_foto_perangkat = $this->upload->data();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_foto_perangkat['full_path'];
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 200;
			$config['height']   = 125;
			$this->load->library('image_lib', $config); 
			$path_foto_perangkat = "uploads/web/foto_perangkat/".$upload_foto_perangkat['file_name'];
		}
		//END UPLOAD FOTO PERANGKAT		

		$dataKontakPerangkat = array(
				'id_kontak_perangkat' => $id_kontak_perangkat,
				'nama_perangkat' =>  $nama_perangkat,
				'jabatan_perangkat' =>  $jabatan_perangkat,
				'nohp_perangkat' =>  $nohp_perangkat,
				'alamat_perangkat' =>  $alamat_perangkat,
				'foto_perangkat' => $path_foto_perangkat
				);	
		$this->m_kontak_perangkat->updateKontakPerangkat(array('id_kontak_perangkat' => $id_kontak_perangkat), $dataKontakPerangkat);
		redirect('admin/c_kontak_perangkat','refresh');
		}
		else $this->edit($id_kontak_perangkat);
    }

    function delete()   
    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_kontak_perangkat->deleteKontakPerangkat($id);
            $sucess++;
        }
		
        redirect('admin/c_kontak_perangkat', 'refresh');
    }
}