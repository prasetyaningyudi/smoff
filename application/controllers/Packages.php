<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {
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
		$this->data['title'] = 'Package';		
	}

	public function index($id=null){
		$tables = array('PACKAGES', 'COMPANY', 'EMPLOYEES');		
		$this->db->select('PACKAGES.ID');
		$this->db->select('PACKAGES.PACKAGE_NAME');
		$this->db->select('COMPANY.COMPANY_NAME');
		$this->db->select('EMPLOYEES.EMPLOYEE_NAME');
		$this->db->select('PACKAGES.PACKAGE_STATUS');
		$this->db->select('PACKAGES.CREATE_DATE');
		$this->db->from($tables);	
		$this->db->where('PACKAGES.PACKAGE_STATUS !=', '9');			
		$this->db->where('PACKAGES.COMPANY_ID=COMPANY.ID');
		if($this->session->userdata['ROLE_ID'] == '4'){
			$this->db->where('PACKAGES.USER_ID', $this->session->userdata['ID']);	
		}		
		$this->db->where('PACKAGES.EMPLOYEES_ID=EMPLOYEES.ID');
		if($id !== null){
		$this->db->where('PACKAGES.ID', $id);			
		}
		$this->db->order_by('PACKAGES.CREATE_DATE', 'ASC');			
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
		$this->load->view('packages_index');
		$this->load->view('section_footer');
	}
	
/* 	public function create(){
		if(isset($_POST['submit'])){
			$this->db->select('ID');
			$this->db->select('EMPLOYEE_NAME');
			$this->db->from('EMPLOYEES');		
			$this->db->where('EMPLOYEE_STATUS', '1');		
			$this->db->where('EMPLOYEE_NAME', $_POST['for']);	
			$this->db->limit(1);			
			$query = $this->db->get(); 
			$this->data['record2'] = $query->result();	
			if($query->num_rows()!=1){
				$this->data['warning'] = array(
					'text' => 'Ops, Destination package for not valid, Try a new one.',
				);
			}else{
				foreach($this->data['record2'] as $item){
					$employee_id = $item->ID;
				}				
				//insert ke database
				$this->data['saveddata'] = array(
					'PACKAGE_NAME' => 'Package from '.substr($_POST['from'],1).' to '.$_POST['for'],
					'EMPLOYEES_ID' => $employee_id,
					'COMPANY_ID' => substr($_POST['from'],0,1),
					'USER_ID' => $_POST['user']
				);			
				$this->db->insert('PACKAGES', $this->data['saveddata']);
				redirect('packages/index/'.$this->db->insert_id());					
			}						
		}
		//load data
		$tables = array('COMPANY', 'REF_GENERAL');		
		$this->db->select('COMPANY.ID');
		$this->db->select('COMPANY.COMPANY_NAME');
		$this->db->select('REF_GENERAL.REF_NAME');
		$this->db->from($tables);	
		$this->db->where('COMPANY.COMPANY_STATUS', '1');		
		$this->db->where('REF_GENERAL.REF_STATUS', '1');		
		$this->db->where('COMPANY.REF_GENERAL_ID=REF_GENERAL.ID');
		$this->db->where('REF_GENERAL.REF_NAME', 'Expedition');
		$this->db->order_by('COMPANY.COMPANY_NAME', 'ASC');			
		$query = $this->db->get(); 
		$this->data['record'] = $query->result();		
		
		$this->db->select('ID');
		$this->db->select('EMPLOYEE_NAME');
		$this->db->from('EMPLOYEES');
		$this->db->order_by('EMPLOYEE_NAME', 'ASC');		
		$this->db->where('EMPLOYEE_STATUS', '1');		
		$query = $this->db->get(); 
		$this->data['record1'] = $query->result();		
		
		$this->data['subtitle'] = 'Add';			
		$this->data['data_table'] = 'no';	
		$this->data['role_access'] = array('1','3','4');			
		
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('packages_create');
		$this->load->view('section_footer');
	} */
	
/* 	public function update($id=null){
		if($id == null){
			redirect('authentication/no_permission');
		}else{
			//load
			$tables = array('PACKAGES', 'COMPANY', 'EMPLOYEES');		
			$this->db->select('PACKAGES.ID');
			$this->db->select('PACKAGES.PACKAGE_NAME');
			$this->db->select('COMPANY.COMPANY_NAME');
			$this->db->select('EMPLOYEES.EMPLOYEE_NAME');
			$this->db->select('PACKAGES.PACKAGE_STATUS');
			$this->db->select('PACKAGES.EMPLOYEES_ID');
			$this->db->select('PACKAGES.COMPANY_ID');
			$this->db->select('PACKAGES.CREATE_DATE');
			$this->db->from($tables);	
			$this->db->where('PACKAGES.PACKAGE_STATUS !=', '9');			
			$this->db->where('PACKAGES.COMPANY_ID=COMPANY.ID');
			$this->db->where('PACKAGES.EMPLOYEES_ID=EMPLOYEES.ID');
			$this->db->where('PACKAGES.ID', $id);			
			$this->db->order_by('PACKAGES.CREATE_DATE', 'ASC');			
			$query = $this->db->get(); 
			$this->data['record'] = $query->result();	
			
			if($query->result() !== null){
				if(isset($_POST['submit'])){
					$this->db->select('ID');
					$this->db->select('EMPLOYEE_NAME');
					$this->db->from('EMPLOYEES');		
					$this->db->where('EMPLOYEE_STATUS', '1');		
					$this->db->where('EMPLOYEE_NAME', $_POST['for']);	
					$this->db->limit(1);			
					$query = $this->db->get(); 
					$this->data['record2'] = $query->result();	
					if($query->num_rows()!=1){
						$this->data['warning'] = array(
							'text' => 'Ops, Destination package for not valid, Try a new one.',
						);
					}else{
						foreach($this->data['record2'] as $item){
							$employee_id = $item->ID;
						}				
						//insert ke database
						$this->data['saveddata'] = array(
							'PACKAGE_NAME' => 'Package from '.substr($_POST['from'],1).' to '.$_POST['for'],
							'EMPLOYEES_ID' => $employee_id,
							'COMPANY_ID' => substr($_POST['from'],0,1),
							'USER_ID' => $_POST['user']
						);	
						$this->db->where('ID', $id);
						$this->db->update('PACKAGES', $this->data['saveddata']);
						redirect('packages');					
					}	
				}
				
				$this->db->select('ID');
				$this->db->select('EMPLOYEE_NAME');
				$this->db->from('EMPLOYEES');
				$this->db->order_by('EMPLOYEE_NAME', 'ASC');		
				$this->db->where('EMPLOYEE_STATUS', '1');		
				$query = $this->db->get(); 
				$this->data['record1'] = $query->result();	

				$tables = array('COMPANY', 'REF_GENERAL');		
				$this->db->select('COMPANY.ID');
				$this->db->select('COMPANY.COMPANY_NAME');
				$this->db->select('REF_GENERAL.REF_NAME');
				$this->db->from($tables);	
				$this->db->where('COMPANY.COMPANY_STATUS', '1');		
				$this->db->where('REF_GENERAL.REF_STATUS', '1');		
				$this->db->where('COMPANY.REF_GENERAL_ID=REF_GENERAL.ID');
				$this->db->where('REF_GENERAL.REF_NAME', 'Expedition');
				$this->db->order_by('COMPANY.COMPANY_NAME', 'ASC');			
				$query = $this->db->get(); 
				$this->data['record3'] = $query->result();				
				
				$this->data['subtitle'] = 'Update';			
				$this->data['data_table'] = 'no';	
				$this->data['role_access'] = array('1','3');			
				
				//view
				$this->load->view('section_header', $this->data);
				$this->load->view('section_navbar');
				$this->load->view('section_sidebar');
				$this->load->view('section_breadcurm');
				$this->load->view('section_content_title');
				$this->load->view('packages_update');
				$this->load->view('section_footer');
			}else{
				redirect('packages');
			}						
		}
	}	
 */
	public function update_status($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('PACKAGE_STATUS');	
			$this->db->from('PACKAGES');
			$this->db->where('ID', $id);
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}						
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result != null){
				foreach($result as $item){
					$status = $item->PACKAGE_STATUS;
				}
				if($status == '1'){
					$new_status = '0';
				}else if($status == '0'){
					$new_status = '1';
				}
				//Update Status di database
				$this->db->set('PACKAGE_STATUS', $new_status);
				$this->db->where('ID', $id);
				$this->db->update('PACKAGES');	
				redirect('packages');
			}else{
				redirect('packages');
			}
		}		
	}	
	
	public function delete($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('PACKAGE_STATUS');	
			$this->db->from('PACKAGES');
			$this->db->where('ID', $id);
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}						
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result != null){
				//Update Status di database
				$this->db->set('PACKAGE_STATUS', '9');
				$this->db->where('ID', $id);
				$this->db->update('PACKAGES');	
				redirect('packages');
			}else{
				redirect('packages');
			}
		}		
	}	
}


