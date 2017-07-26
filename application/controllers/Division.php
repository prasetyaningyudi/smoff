<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Division extends CI_Controller {
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
		$this->data['title'] = 'Division';		
	}

	public function index(){
		//load list
		$this->db->select('ID');
		$this->db->select('DIVISION_NAME');
		$this->db->select('DIVISION_STATUS');
		$this->db->from('DIVISION');
		$this->db->where('DIVISION_STATUS !=', '9');	
		if($this->session->userdata['ROLE_ID'] == '4'){
			$this->db->where('USER_ID', $this->session->userdata['ID']);	
		}		
		$this->db->order_by('DIVISION_NAME', 'ASC');		
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
		$this->load->view('division_index');
		$this->load->view('section_footer');		
	}
	
	public function create(){
		if(isset($_POST['submit'])){
			$this->db->select('ID');
			$this->db->select('DIVISION_NAME');;
			$this->db->from('DIVISION');
			$this->db->where('DIVISION_NAME', $_POST['name']);
			$this->db->where('USER_ID', $this->session->userdata['ID']);			
			$this->db->where('DIVISION_STATUS !=', '9');				
			$query = $this->db->get();
			if($query->num_rows()==1){
				$this->data['warning'] = array(
					'text' => 'Ops, Division already exist, Try a new one.',
				);
			}else{
				//insert ke database
				$this->data['saveddata'] = array(
					'DIVISION_NAME' => $_POST['name'],
					'USER_ID' => $_POST['user']
				);			
				$this->db->insert('DIVISION', $this->data['saveddata']);
				redirect('division');				
			}	
		}
		
		$this->data['subtitle'] = 'Add';			
		$this->data['data_table'] = 'no';	
		$this->data['role_access'] = array('1','2','3','4');	
		
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('division_create');
		$this->load->view('section_footer');

	}

	public function update($id=null){
		if($id == null){
			redirect('authentication/no_permission');
		}else{
			//load
			$this->db->select('ID');
			$this->db->select('DIVISION_NAME');
			$this->db->from('DIVISION');	
			$this->db->WHERE('ID', $id);
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}			
			$this->db->order_by('DIVISION_NAME', 'ASC');		
			$query = $this->db->get(); 
			$this->data['record'] = $query->result();
			
			if($query->result() != null){
				if(isset($_POST['submit'])){
					$this->db->select('ID');
					$this->db->select('DIVISION_NAME');
					$this->db->from('DIVISION');
					$this->db->where('DIVISION_NAME', $_POST['name']);
					$this->db->where('USER_ID', $this->session->userdata['ID']);	
					$this->db->where('ID !=', $id);		
					$this->db->where('DIVISION_STATUS !=', '9');		
					$query = $this->db->get();
					if($query->num_rows()==1){
						$this->data['warning'] = array(
							'text' => 'Ops, Division already exist, Try a new one.',
						);
					}else{
						//insert ke database
						$this->data['saveddata'] = array(
							'DIVISION_NAME' => $_POST['name'],
						);								
						$this->db->where('ID', $id);
						$this->db->update('DIVISION', $this->data['saveddata']);
						redirect('division');				
					}	
				}				
				$this->data['subtitle'] = 'Update';			
				$this->data['data_table'] = 'no';	
				$this->data['role_access'] = array('1','2','3','4');		
				
				//view
				$this->load->view('section_header', $this->data);
				$this->load->view('section_navbar');
				$this->load->view('section_sidebar');
				$this->load->view('section_breadcurm');
				$this->load->view('section_content_title');
				$this->load->view('division_update');
				$this->load->view('section_footer');
			}else{
				redirect('division');
			}						
		}
	}

	public function update_status($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('DIVISION_STATUS');	
			$this->db->from('DIVISION');
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}					
			$this->db->where('ID', $id);	
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result != null){
				foreach($result as $item){
					$status = $item->DIVISION_STATUS;
				}
				if($status == '1'){
					$new_status = '0';
				}else if($status == '0'){
					$new_status = '1';
				}
				//Update Status di database
				$this->db->set('DIVISION_STATUS', $new_status);
				$this->db->where('ID', $id);
				$this->db->update('DIVISION');	
				redirect('division');
			}else{
				redirect('division');
			}
		}		
	}	
	
	public function delete($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('DIVISION_STATUS');	
			$this->db->from('DIVISION');
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}					
			$this->db->where('ID', $id);	
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result != null){
				//Update Status di database
				$this->db->set('DIVISION_STATUS', '9');
				$this->db->where('ID', $id);
				$this->db->update('DIVISION');	
				redirect('division');
			}else{
				redirect('division');
			}
		}		
	}	
}


