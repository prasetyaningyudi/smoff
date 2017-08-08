<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');		
		$this->load->helper('url');		
		$this->load->database();
		$this->load->model('menu_model'); //can replace with cookies or session
		$this->data['menu'] = $this->menu_model->get_menu();
		$this->data['sub_menu'] = $this->menu_model->get_sub_menu();
		$this->load->model('init_model');				
		if(isset($this->session->userdata['is_logged_in'])){
			$init_data = $this->init_model->get_init_data($this->session->userdata['ID'])->result();
			if(empty($init_data)){
				$this->data['init_data'] = null;
			}else{
				$this->data['init_data'] = $init_data;
			}			
		}else{
			$this->data['init_data'] = null;
		}
		$this->data['title'] = 'Upload';		
	}
	
	public function index(){
		if(isset($_POST['submit'])){
			var_dump($_FILES['uploadfile']['name']);
			var_dump($_FILES['uploadfile']['type']);
			var_dump($_FILES['uploadfile']['size']);
			var_dump($_FILES['uploadfile']['tmp_name']);
			var_dump($_FILES['uploadfile']['error']);
			
			$fp      = fopen($_FILES['uploadfile']['tmp_name'], 'r');
			$content = fread($fp, $_FILES['uploadfile']['size']);
			//$content = addslashes($content);
			fclose($fp);			
			
			$this->data['saveddata'] = array(
				'DATA_FILE' => $content,
				'TYPE_FILE' => $_FILES['uploadfile']['type'],
			);			
			$this->db->insert('FILE', $this->data['saveddata']);			
			
		}
		$this->data['subtitle'] = 'Tes';			
		$this->data['data_table'] = 'no';
		$this->data['role_access'] = array('5');				
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('upload_index');
		$this->load->view('section_footer');			
	}
	
}
