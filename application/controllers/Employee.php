<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
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
		$this->data['title'] = 'Employee';		
	}

	public function index(){
		//load list
		$this->db->select('ID');
		$this->db->select('EMPLOYEE_NAME');
		$this->db->select('EMPLOYEE_PHONE');
		$this->db->select('EMPLOYEE_EMAIL');
		$this->db->select('EMPLOYEE_STATUS');
		$this->db->from('EMPLOYEES');
		$this->db->where('EMPLOYEE_STATUS !=', '9');
		if($this->session->userdata['ROLE_ID'] == '4'){
			$this->db->where('USER_ID', $this->session->userdata['ID']);	
		}
		$this->db->order_by('EMPLOYEE_NAME', 'ASC');		
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
		$this->load->view('employee_index');
		$this->load->view('section_footer');		
	}
	
	public function create(){
		if(isset($_POST['submit'])){
			$this->db->select('ID');
			$this->db->select('EMPLOYEE_EMAIL');;
			$this->db->from('EMPLOYEES');
			$this->db->where('EMPLOYEE_EMAIL', $_POST['email']);
			$this->db->where('USER_ID', $this->session->userdata['ID']);
			$this->db->where('EMPLOYEE_STATUS !=', '9');				
			$query = $this->db->get();
			if($query->num_rows()==1){
				$this->data['warning'] = array(
					'text' => 'Ops, Email already exist, Try a new one.',
				);
			}else{
				//insert ke database
				$this->data['saveddata'] = array(
					'EMPLOYEE_NAME' => $_POST['name'],
					'EMPLOYEE_EMAIL' => $_POST['email'],
					'EMPLOYEE_PHONE' => $_POST['phone'],
					'USER_ID' => $_POST['user']
				);			
				$this->db->insert('EMPLOYEES', $this->data['saveddata']);
				redirect('employee');				
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
		$this->load->view('employee_create');
		$this->load->view('section_footer');

	}

	public function update($id=null){
		if($id == null){
			redirect('authentication/no_permission');
		}else{
			//load
			$this->db->select('ID');
			$this->db->select('EMPLOYEE_NAME');
			$this->db->select('EMPLOYEE_EMAIL');
			$this->db->select('EMPLOYEE_PHONE');
			$this->db->select('EMPLOYEE_STATUS');
			$this->db->from('EMPLOYEES');	
			$this->db->WHERE('ID', $id);
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}
			$this->db->order_by('EMPLOYEE_NAME', 'ASC');		
			$query = $this->db->get(); 
			$this->data['record'] = $query->result();
			if($query->result() != null){
				if(isset($_POST['submit'])){
					$this->db->select('ID');
					$this->db->select('EMPLOYEE_EMAIL');
					$this->db->from('EMPLOYEES');
					$this->db->where('EMPLOYEE_EMAIL', $_POST['email']);		
					$this->db->where('ID !=', $id);	
					$this->db->where('USER_ID', $this->session->userdata['ID']);					
					$this->db->where('EMPLOYEE_STATUS !=', '9');		
					$query = $this->db->get();
					if($query->num_rows()==1){
						$this->data['warning'] = array(
							'text' => 'Ops, Email already exist, Try a new one.',
						);
					}else{
						//insert ke database
						$this->data['saveddata'] = array(
							'EMPLOYEE_NAME' => $_POST['name'],
							'EMPLOYEE_EMAIL' => $_POST['email'],
							'EMPLOYEE_PHONE' => $_POST['phone'],
						);								
						$this->db->where('ID', $id);
						$this->db->update('EMPLOYEES', $this->data['saveddata']);
						redirect('employee');				
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
				$this->load->view('employee_update');
				$this->load->view('section_footer');
			}else{
				redirect('employee');
			}						
		}
	}

	public function update_status($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('EMPLOYEE_STATUS');	
			$this->db->from('EMPLOYEES');
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}			
			$this->db->where('ID', $id);	
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result != null){
				foreach($result as $item){
					$status = $item->EMPLOYEE_STATUS;
				}
				if($status == '1'){
					$new_status = '0';
				}else if($status == '0'){
					$new_status = '1';
				}
				//Update Status di database
				$this->db->set('EMPLOYEE_STATUS', $new_status);
				$this->db->where('ID', $id);
				$this->db->update('EMPLOYEES');	
				redirect('employee');
			}else{
				redirect('employee');
			}
		}		
	}	
	
	public function delete($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('EMPLOYEE_STATUS');	
			$this->db->from('EMPLOYEES');
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}						
			$this->db->where('ID', $id);	
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result != null){
				//Update Status di database
				$this->db->set('EMPLOYEE_STATUS', '9');
				$this->db->where('ID', $id);
				$this->db->update('EMPLOYEES');	
				redirect('employee');
			}else{
				redirect('employee');
			}
		}		
	}	
}


