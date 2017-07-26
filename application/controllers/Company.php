<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {
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
		$this->data['title'] = 'Company';		
	}

	public function index(){
		//load list
		$tables = array('COMPANY', 'REF_GENERAL');			
		$this->db->select('COMPANY.ID');
		$this->db->select('COMPANY_NAME');
		$this->db->select('REF_GENERAL.REF_NAME');
		$this->db->select('COMPANY_STATUS');
		$this->db->from($tables);	
		$this->db->where('COMPANY_STATUS!=', '9');	
		if($this->session->userdata['ROLE_ID'] == '4'){
			$this->db->where('USER_ID', $this->session->userdata['ID']);	
		}		
		$this->db->where('REF_GENERAL_ID=REF_GENERAL.ID');	
		$this->db->order_by('COMPANY_NAME', 'ASC');		
		$query = $this->db->get(); 
		$this->data['record'] = $query->result();
		
		$this->data['subtitle'] = 'View';			
		$this->data['data_table'] = 'yes';
		$this->data['role_access'] = array('1','2','3','4');				
		
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('company_index');
		$this->load->view('section_footer');		
	}
	
	public function create(){
		if(isset($_POST['submit'])){
			$this->db->select('ID');
			$this->db->select('COMPANY_NAME');
			$this->db->from('COMPANY');
			$this->db->where('COMPANY_STATUS!=', '9');
			$this->db->where('USER_ID', $this->session->userdata['ID']);
			$this->db->where('COMPANY_NAME', $_POST['name']);		
			$query = $this->db->get();
			if($query->num_rows()==1){
				$this->data['warning'] = array(
					'text' => 'Ops, Company Name already exist, Try a new one.',
				);
			}else{
				//insert ke database
				$this->data['saveddata'] = array(
					'COMPANY_NAME' => $_POST['name'],
					'USER_ID' => $_POST['user'],
					'REF_GENERAL_ID' => $_POST['type']
				);			
				$this->db->insert('COMPANY', $this->data['saveddata']);
				redirect('company');				
			}	
		}
		
		$tables = array('REF_TYPE', 'REF_GENERAL');		
		$this->db->select('REF_GENERAL.ID');
		$this->db->select('REF_GENERAL.REF_NAME');
		$this->db->from($tables);	
		$this->db->where('REF_TYPE_STATUS', '1');		
		$this->db->where('REF_STATUS', '1');		
		$this->db->where('REF_TYPE.ID=REF_GENERAL.REF_TYPE_ID');
		$this->db->where('REF_TYPE_NAME', 'COMPANY_TYPE');
		$this->db->order_by('REF_GENERAL.REF_NAME', 'ASC');			
		$query = $this->db->get(); 
		$this->data['record1'] = $query->result();			
		
		$this->data['subtitle'] = 'Add';			
		$this->data['data_table'] = 'no';	
		$this->data['role_access'] = array('1','2','3','4');		
		
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('company_create');
		$this->load->view('section_footer');

	}

	public function update($id=null){
		if($id == null){
			redirect('authentication/no_permission');
		}else{
			//load
			$this->db->select('ID');
			$this->db->select('COMPANY_NAME');
			$this->db->select('COMPANY_STATUS');
			$this->db->select('REF_GENERAL_ID');
			$this->db->from('COMPANY');	
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}			
			$this->db->WHERE('ID', $id);			
			$this->db->order_by('COMPANY_NAME', 'ASC');		
			$query = $this->db->get(); 
			$this->data['record'] = $query->result();
			
			
			if($query->result() != null){
				if(isset($_POST['submit'])){
					$this->db->select('ID');
					$this->db->select('COMPANY_NAME');
					$this->db->from('COMPANY');
					$this->db->where('COMPANY_STATUS!=', '9');
					$this->db->where('ID!=', $id);
					$this->db->where('USER_ID', $this->session->userdata['ID']);	
					$this->db->where('COMPANY_NAME', $_POST['name']);		
					$query = $this->db->get();
					if($query->num_rows()==1){
						$this->data['warning'] = array(
							'text' => 'Ops, Company Name already exist, Try a new one.',
						);
					}else{
						//insert ke database
						$this->data['saveddata'] = array(
							'COMPANY_NAME' => $_POST['name'],
							'REF_GENERAL_ID' => $_POST['type']							
						);								
						$this->db->where('ID', $id);
						$this->db->update('COMPANY', $this->data['saveddata']);
						redirect('company');				
					}	
				}	

				$tables = array('REF_TYPE', 'REF_GENERAL');		
				$this->db->select('REF_GENERAL.ID');
				$this->db->select('REF_GENERAL.REF_NAME');
				$this->db->from($tables);	
				$this->db->where('REF_TYPE_STATUS', '1');		
				$this->db->where('REF_STATUS', '1');		
				$this->db->where('REF_TYPE.ID=REF_GENERAL.REF_TYPE_ID');
				$this->db->where('REF_TYPE_NAME', 'COMPANY_TYPE');
				$this->db->order_by('REF_GENERAL.REF_NAME', 'ASC');			
				$query = $this->db->get(); 
				$this->data['record1'] = $query->result();	
				
				$this->data['subtitle'] = 'Update';			
				$this->data['data_table'] = 'no';	
				$this->data['role_access'] = array('1','2','3','4');				
				
				//view
				$this->load->view('section_header', $this->data);
				$this->load->view('section_navbar');
				$this->load->view('section_sidebar');
				$this->load->view('section_breadcurm');
				$this->load->view('section_content_title');
				$this->load->view('company_update');
				$this->load->view('section_footer');
			}else{
				redirect('company');
			}						
		}
	}

	public function update_status($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('COMPANY_STATUS');	
			$this->db->from('COMPANY');
			$this->db->where('ID', $id);
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}						
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result != null){
				foreach($result as $item){
					$status = $item->COMPANY_STATUS;
				}
				if($status == '1'){
					$new_status = '0';
				}else if($status == '0'){
					$new_status = '1';
				}
				//Update Status di database
				$this->db->set('COMPANY_STATUS', $new_status);
				$this->db->where('ID', $id);
				$this->db->update('COMPANY');	
				redirect('company');
			}else{
				redirect('company');
			}
		}		
	}	
	
	public function delete($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('COMPANY_STATUS');	
			$this->db->from('COMPANY');
			$this->db->where('ID', $id);
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}						
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result != null){
				//Update Status di database
				$this->db->set('COMPANY_STATUS', '9');
				$this->db->where('ID', $id);
				$this->db->update('COMPANY');	
				redirect('company');
			}else{
				redirect('company');
			}
		}		
	}		
}


