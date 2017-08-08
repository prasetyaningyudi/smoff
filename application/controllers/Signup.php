<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {
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
		$this->load->model('mail_model');
		$this->data['title'] = 'Sign Up';		
	}
	
	public function index(){				
		if(isset($_POST['submit'])){
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$this->data['warning'] = array(
					'text' => 'Ops, Email not valid try a new one',
				);					
			}else{
				$this->db->select('ID');
				$this->db->select('USERNAME');
				$this->db->from('USER');
				$this->db->where('USER_STATUS!=', '9');
				$this->db->where('USERNAME', $_POST['email']);
				$query = $this->db->get();				
				if($query->num_rows()==1){
					$this->data['warning'] = array(
						'text' => 'Ops, Email already registered, Try a new one.',
					);	
				}else{
					//insert ke database
					$this->data['saveddata'] = array(
						'USERNAME' => $_POST['email'],
						'PASSWORD' => md5($_POST['email']),
						'USER_ALIAS' => $_POST['name'],
						'USER_STATUS' => '5',
						'ROLE_ID' => 4
					);			
					$this->db->insert('USER', $this->data['saveddata']);
					$id = $this->db->insert_id();
					
					//sent mail
					$linkConfirmation = '<a href="'.base_url().'signup/signup_conf/'.md5($_POST['email']).'">'.base_url().'signup/signup_conf/'.md5($_POST['email']).'</a>';
					$message = 'Thank for your sign up<br>Please click this link '.$linkConfirmation.' to complete your registration.';
					$this->mail_model->sent_from_gmail($_POST['email'], 'Mail confirmation', $message, $message);
					redirect('signup/email_conf/'.$id);		
				}				
			}
		}
		$this->data['subtitle'] = '';			
		$this->data['data_table'] = 'no';
		$this->data['role_access'] = array('5');				
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('signup_index');
		$this->load->view('section_footer');			
	}
	
	public function email_conf($id=null){
		if($id==null){
			redirect('authentication/no_permission');
		}else{
			$this->db->select('ID');
			$this->db->select('USERNAME');
			$this->db->select('USER_ALIAS');
			$this->db->from('USER');
			$this->db->where('USER_STATUS', '5');
			$this->db->where('ID', $id);
			$query = $this->db->get();
			$this->data['record'] = $query->result();		
			
			$this->data['subtitle'] = 'Email Confirmation';			
			$this->data['data_table'] = 'no';
			$this->data['role_access'] = array('5');			
			//view
			$this->load->view('section_header', $this->data);
			$this->load->view('section_navbar');
			$this->load->view('section_sidebar');
			$this->load->view('section_breadcurm');
			$this->load->view('section_content_title');
			$this->load->view('signup_check_email');
			$this->load->view('section_footer');					
		}
	}
	
	public function signup_conf($md5=null){
		if($md5==null){
			redirect('authentication/no_permission');
		}else{
			$this->db->select('ID');
			$this->db->select('USERNAME');
			$this->db->select('USER_ALIAS');
			$this->db->from('USER');
			$this->db->where('USER_STATUS', '5');
			$this->db->where('PASSWORD', $md5);
			$query = $this->db->get();
			$this->data['record'] = $query->result();		
			if($query->num_rows()<1){
				$this->data['warning'] = array(
					'text' => 'Ops, Signup confirmation code not valid, Sign up first.',
				);	
			}else{
				if(isset($_POST['submit'])){
					if($_POST['password'] != $_POST['password2']){
						$this->data['warning'] = array(
							'text' => 'Ops, Please ensure you type confirm password same with password.',
						);
					}else{
						//insert ke database
							$this->data['saveddata'] = array(
								'PASSWORD' => md5($_POST['password']),
								'USER_STATUS' => '1',
							);								
						$this->db->where('ID', $_POST['id']);
						$this->db->update('USER', $this->data['saveddata']);
						
						//add login session
						$tables = array('ROLE', 'USER');
						$this->db->select('USER.ID');
						$this->db->select('USER.USERNAME');
						$this->db->select('USER.USER_ALIAS');
						$this->db->select('USER.ROLE_ID');
						$this->db->select('ROLE.ROLE_NAME');
						$this->db->from($tables);
						$this->db->where('USER.ID', $_POST['id']);	
						$this->db->where('ROLE.ID=USER.ROLE_ID');
						$this->db->where('USER_STATUS','1');		
						$query = $this->db->get(); 
						$result = $query->result();	
						
						foreach($result as $item){
							$data_session=array(
								'ID'=>$item->ID,
								'USERNAME'=>$item->USERNAME,
								'USER_ALIAS'=>$item->USER_ALIAS,
								'ROLE_ID'=>$item->ROLE_ID,
								'ROLE_NAME'=>$item->ROLE_NAME,
								'is_logged_in'=>1
							);
						}
						$this->session->sess_expiration = '2';
						$this->session->sess_expire_on_close = 'true';
						$this->session->set_userdata($data_session);							
						redirect('home/welcome/signup_success');							
					}
				}
			}			
			$this->data['subtitle'] = 'Confirmation';			
			$this->data['data_table'] = 'no';
			$this->data['role_access'] = array('5');			
			//view
			$this->load->view('section_header', $this->data);
			$this->load->view('section_navbar');
			$this->load->view('section_sidebar');
			$this->load->view('section_breadcurm');
			$this->load->view('section_content_title');
			$this->load->view('signup_conf');
			$this->load->view('section_footer');				
		}
	}
	
}