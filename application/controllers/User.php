<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
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
		$this->data['title'] = 'User';		
	}

	public function index(){
		//load user list
		$tables = array('ROLE', 'USER');
		$this->db->select('USER.ID');
		$this->db->select('USER.USERNAME');
		$this->db->select('USER.PASSWORD');
		$this->db->select('USER.USER_ALIAS');
		$this->db->select('USER.USER_STATUS');
		$this->db->select('USER.ROLE_ID');
		$this->db->select('ROLE.ROLE_NAME');	
		$this->db->from($tables);
		$this->db->WHERE('USER.ROLE_ID = ROLE.ID');
		$this->db->order_by('ROLE.ID', 'ASC');		
		$this->db->order_by('USER.ID', 'ASC');	
		$query = $this->db->get(); 
		$this->data['record'] = $query->result();
		
		$this->data['subtitle'] = 'View';			
		$this->data['data_table'] = 'yes';
		$this->data['role_access'] = array('1');			
		
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('user_index');
		$this->load->view('section_footer');		
	}
	
	public function create(){
		if(isset($_POST['submit'])){
			$this->db->select('ID');
			$this->db->select('USERNAME');
			$this->db->from('USER');
			$this->db->where('USERNAME', $_POST['username']);		
			$query = $this->db->get();
			if($query->num_rows()==1){
				$this->data['warning'] = array(
					'text' => 'Ops, Username already exist, Try a new one.',
				);
			}else if($_POST['password'] != $_POST['password2']){
				$this->data['warning'] = array(
					'text' => 'Ops, Please ensure you type repeat password same with password.',
				);
			}else{
				//insert ke database
				$this->data['saveddata'] = array(
					'USERNAME' => $_POST['username'],
					'PASSWORD' => md5($_POST['password']),
					'USER_ALIAS' => $_POST['alias'],
					'ROLE_ID' => $_POST['role'],
				);			
				$this->db->insert('USER', $this->data['saveddata']);
				redirect('user');				
			}	
		}
		//load data
		$this->db->select('ID');
		$this->db->select('ROLE_NAME');
		$this->db->from('ROLE');
		$this->db->order_by('ID', 'ASC');		
		$this->db->where('ID !=', '1');		
		$this->db->where('ID !=', '5');		
		$query = $this->db->get(); 
		$this->data['record'] = $query->result();	
		
		$this->data['subtitle'] = 'Add';			
		$this->data['data_table'] = 'no';	
		$this->data['role_access'] = array('1');			
		
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('user_create');
		$this->load->view('section_footer');

	}

	public function update($id=null){
		if($id == null){
			redirect('authentication/no_permission');
		}else{
			//load user list
			$tables = array('ROLE', 'USER');
			$this->db->select('USER.ID');
			$this->db->select('USER.USERNAME');
			$this->db->select('USER.PASSWORD');
			$this->db->select('USER.USER_ALIAS');
			$this->db->select('USER.USER_STATUS');
			$this->db->select('USER.ROLE_ID');		
			$this->db->select('ROLE.ROLE_NAME');		
			$this->db->from($tables);
			$this->db->WHERE('USER.ROLE_ID = ROLE.ID');
			$this->db->WHERE('USER.ID', $id);	
			$query = $this->db->get(); 
			$this->data['record'] = $query->result();
			
			if($query->result() !== null){
				if(isset($_POST['submit'])){
					if($_POST['password'] != $_POST['password2']){
						$this->data['warning'] = array(
							'text' => 'Ops, Please ensure you type repeat password same with password.',
						);
					}else{
						if($_POST['password'] == '' or $_POST['password'] === null){
							//insert ke database
							$this->data['saveddata'] = array(
								'USER_ALIAS' => $_POST['alias'],
								'ROLE_ID' => $_POST['role'],
							);								
						}else{
							//insert ke database
							$this->data['saveddata'] = array(
								'PASSWORD' => md5($_POST['password']),
								'USER_ALIAS' => $_POST['alias'],
								'ROLE_ID' => $_POST['role'],
							);								
						}
						$this->db->where('ID', $id);
						$this->db->update('USER', $this->data['saveddata']);
						redirect('user');				
					}	
				}				
				//load data
				$this->db->select('ID');
				$this->db->select('ROLE_NAME');
				$this->db->from('ROLE');
				$this->db->order_by('ID', 'ASC');		
				$this->db->where('ID !=', '1');		
				$this->db->where('ID !=', '5');		
				$query = $this->db->get(); 
				$this->data['record1'] = $query->result();	
				
				$this->data['subtitle'] = 'Update';			
				$this->data['data_table'] = 'no';	
				$this->data['role_access'] = array('1');			
				
				//view
				$this->load->view('section_header', $this->data);
				$this->load->view('section_navbar');
				$this->load->view('section_sidebar');
				$this->load->view('section_breadcurm');
				$this->load->view('section_content_title');
				$this->load->view('user_update');
				$this->load->view('section_footer');
			}else{
				redirect('user');
			}						
		}
	}

	public function update_status($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('USER_STATUS');	
			$this->db->from('USER');
			$this->db->where('ID', $id);	
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result !== null){
				foreach($result as $item){
					$status = $item->USER_STATUS;
				}
				if($status == '1'){
					$new_status = '0';
				}else if($status == '0'){
					$new_status = '1';
				}
				//Update Status di database
				$this->db->set('USER_STATUS', $new_status);
				$this->db->where('ID', $id);
				$this->db->update('USER');	
				redirect('user');
			}else{
				redirect('user');
			}
		}		
	}	
}


