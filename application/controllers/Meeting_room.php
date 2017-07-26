<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meeting_room extends CI_Controller {
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
		$this->data['title'] = 'Meeting Room';		
	}

	public function index(){
		//load list
		$this->db->select('ID');
		$this->db->select('ROOM_NAME');
		$this->db->select('ROOM_STATUS');
		$this->db->from('MEETING_ROOM');	
		if($this->session->userdata['ROLE_ID'] == '4'){
			$this->db->where('USER_ID', $this->session->userdata['ID']);	
		}		
		$this->db->order_by('ROOM_NAME', 'ASC');		
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
		$this->load->view('meeting_room_index');
		$this->load->view('section_footer');		
	}
	
	public function create(){
		if(isset($_POST['submit'])){
			$this->db->select('ID');
			$this->db->select('ROOM_NAME');
			$this->db->from('MEETING_ROOM');
			$this->db->where('USER_ID', $this->session->userdata['ID']);
			$this->db->where('ROOM_NAME', $_POST['name']);		
			$query = $this->db->get();
			if($query->num_rows()==1){
				$this->data['warning'] = array(
					'text' => 'Ops, Meeting Room Name already exist, Try a new one.',
				);
			}else{
				//insert ke database
				$this->data['saveddata'] = array(
					'ROOM_NAME' => $_POST['name'],
					'USER_ID' => $_POST['user']
				);			
				$this->db->insert('MEETING_ROOM', $this->data['saveddata']);
				redirect('meeting_room');				
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
		$this->load->view('meeting_room_create');
		$this->load->view('section_footer');

	}

	public function update($id=null){
		if($id == null){
			redirect('authentication/no_permission');
		}else{
			//load
			$this->db->select('ID');
			$this->db->select('ROOM_NAME');
			$this->db->select('ROOM_STATUS');
			$this->db->from('MEETING_ROOM');	
			$this->db->WHERE('ID', $id);
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}			
			$this->db->order_by('ROOM_NAME', 'ASC');		
			$query = $this->db->get(); 
			$this->data['record'] = $query->result();
			
			if($query->result() != null){
				if(isset($_POST['submit'])){
					$this->db->select('ID');
					$this->db->select('ROOM_NAME');
					$this->db->from('MEETING_ROOM');
					$this->db->where('ROOM_NAME', $_POST['name']);
					$this->db->where('USER_ID', $this->session->userdata['ID']);	
					$query = $this->db->get();
					if($query->num_rows()==1){
						$this->data['warning'] = array(
							'text' => 'Ops, Meeting Room Name already exist, Try a new one.',
						);
					}else{
						//insert ke database
						$this->data['saveddata'] = array(
							'ROOM_NAME' => $_POST['name'],
							'USER_ID' => $_POST['user'],
						);								
						$this->db->where('ID', $id);
						$this->db->update('MEETING_ROOM', $this->data['saveddata']);
						redirect('meeting_room');				
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
				$this->load->view('meeting_room_update');
				$this->load->view('section_footer');
			}else{
				redirect('meeting_room');
			}						
		}
	}

	public function update_status($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('ROOM_STATUS');	
			$this->db->from('MEETING_ROOM');
			$this->db->where('ID', $id);
			if($this->session->userdata['ROLE_ID'] == '4'){
				$this->db->where('USER_ID', $this->session->userdata['ID']);	
			}						
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result != null){
				foreach($result as $item){
					$status = $item->ROOM_STATUS;
				}
				if($status == '1'){
					$new_status = '0';
				}else if($status == '0'){
					$new_status = '1';
				}
				//Update Status di database
				$this->db->set('ROOM_STATUS', $new_status);
				$this->db->where('ID', $id);
				$this->db->update('MEETING_ROOM');	
				redirect('meeting_room');
			}else{
				redirect('meeting_room');
			}
		}		
	}	
}


