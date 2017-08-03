<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');		
		$this->load->helper('url');			
		$this->load->helper('cookie');
		$this->load->database();
		$this->load->model('frontpage_model');
		$this->data['front_page'] = $this->frontpage_model->get_front_page(current_url());
		$this->load->model('init_model');
		$this->data['user_id'] = $this->init_model->get_user_id($this->data['front_page']);
		if($this->data['user_id'] !== null){
			$init_data = $this->init_model->get_init_data($this->data['user_id'])->result();
			if(empty($init_data)){
				$this->data['init_data'] = null;
			}else{
				$this->data['init_data'] = $init_data;
			}				
		}else{
			$this->data['init_data'] = null;
		}
		$this->load->model('mail_model');	
		ini_set('date.timezone', 'Asia/Jakarta');
		$this->data['title'] = 'Home';		
	}
	
	public function start($front_id = null){	
		if($front_id == null){
			redirect('authentication/front_no_permission');
		}else{
			if($this->data['user_id'] === null){
				redirect('authentication/front_no_permission');
			}else{
				$this->data['subtitle'] = 'Start';			
				$this->data['role_access'] = array('1','2','3','4','5');	
				$this->load->view('front_header', $this->data);
				$this->load->view('front_start');
				$this->load->view('front_footer');				
			}
		}
	}

	public function welcome($front_id = null){
		if($front_id == null){
			redirect('authentication/front_no_permission');
		}else{
			if($this->data['user_id'] === null){
				redirect('authentication/front_no_permission');
			}else{
				$this->data['subtitle'] = 'Welcome';			
				$this->data['role_access'] = array('1','2','3','4','5');	
				$this->load->view('front_header', $this->data);
				$this->load->view('front_welcome');
				$this->load->view('front_footer');
			}
		}
	}

	public function sign_in($front_id=null){
		if($front_id == null){
			redirect('authentication/front_no_permission');
		}else{
			if($this->data['user_id'] === null){
				redirect('authentication/front_no_permission');
			}else{
				$tables = array('COMPANY', 'GUEST');					
				$this->db->select('GUEST.ID');
				$this->db->select('GUEST.GUEST_NAME');
				$this->db->select('GUEST.GUEST_PHONE');
				$this->db->select('GUEST.GUEST_EMAIL');
				$this->db->select('GUEST.COMPANY_ID');
				$this->db->select('COMPANY.COMPANY_NAME');
				$this->db->from($tables);
				$this->db->order_by('GUEST_NAME', 'ASC');		
				$this->db->where('GUEST_STATUS', '1');		
				$this->db->where('COMPANY_STATUS', '1');		
				$names = array('1', $this->data['user_id']);
				$this->db->where_in('GUEST.USER_ID', $names);				
				$this->db->where('GUEST.COMPANY_ID=COMPANY.ID');		
				$query = $this->db->get(); 
				$this->data['record'] = $query->result();	
			
				//company list
				$tables = array('COMPANY', 'REF_GENERAL');		
				$this->db->select('COMPANY.ID');
				$this->db->select('COMPANY.COMPANY_NAME');
				$this->db->select('REF_GENERAL.REF_NAME');
				$this->db->from($tables);	
				$this->db->where('COMPANY.COMPANY_STATUS', '1');		
				$this->db->where('REF_GENERAL.REF_STATUS', '1');		
				$this->db->where('COMPANY.REF_GENERAL_ID=REF_GENERAL.ID');
				$this->db->where('REF_GENERAL.REF_NAME !=', 'Expedition');
				$names = array('1', $this->data['user_id']);
				$this->db->where_in('COMPANY.USER_ID', $names);						
				$this->db->order_by('COMPANY.COMPANY_NAME', 'ASC');			
				$query = $this->db->get(); 
				$this->data['record1'] = $query->result();			
			
				$this->data['subtitle'] = 'Sign In';			
				$this->data['role_access'] = array('1','2','3','4','5');	
				$this->load->view('front_header', $this->data);
				$this->load->view('front_sign_in');
				$this->load->view('front_footer');
			}
		}		
	}

	public function sign_in_need($front_id=null){
		if($front_id == null){
			redirect('authentication/front_no_permission');
		}else{
			if($this->data['user_id'] === null){
				redirect('authentication/front_no_permission');
			}else{
				if(isset($_POST['submit'])){
					//check company
					$this->db->select('ID');
					$this->db->select('COMPANY_NAME');
					$this->db->from('COMPANY');		
					$this->db->where('COMPANY_STATUS', '1');	
					$names = array('1', $this->data['user_id']);
					$this->db->where_in('USER_ID', $names);						
					$this->db->where('COMPANY_NAME', $_POST['company']);				
					$this->db->where('REF_GENERAL_ID', '2');				
					$this->db->limit(1);				
					$query = $this->db->get(); 
					$this->data['record'] = $query->result();	
					if($query->num_rows()!=1){
						//insert ke database
						$this->data['saveddata'] = array(
							'COMPANY_NAME' => $_POST['company'],
							'REF_GENERAL_ID' => 2,
							'USER_ID' => $_POST['id']
						);								
						$this->db->insert('COMPANY', $this->data['saveddata']);	
						$company_id = $this->db->insert_id();
					}else{		
						foreach($this->data['record'] as $item){
							$company_id = $item->ID;
						}
					}
					
					//checking guest
					$tables = array('GUEST', 'COMPANY');
					$this->db->select('GUEST.ID');
					$this->db->select('GUEST_NAME');
					$this->db->select('COMPANY_ID');
					$this->db->from($tables);		
					$this->db->where('GUEST_STATUS', '1');		
					$names = array('1', $this->data['user_id']);
					$this->db->where_in('GUEST.USER_ID', $names);							
					$this->db->where('GUEST_NAME', $_POST['name']);		
					$this->db->where('GUEST_EMAIL', $_POST['email']);		
					$this->db->where('COMPANY.COMPANY_NAME', $_POST['company']);
					$this->db->where('COMPANY.ID=COMPANY_ID');						
					$this->db->limit(1);				
					$query = $this->db->get(); 
					$this->data['record1'] = $query->result();	
					if($query->num_rows()!=1){
						//insert ke database
						$this->data['saveddata'] = array(
							'GUEST_NAME' => $_POST['name'],
							'GUEST_PHONE' => $_POST['phone'],
							'GUEST_EMAIL' => $_POST['email'],
							'USER_ID' => $_POST['id'],
							'COMPANY_ID' => $company_id
						);			
						$this->db->insert('GUEST', $this->data['saveddata']);
						$guest_id = $this->db->insert_id();
					}else{
						foreach($this->data['record1'] as $val){
							$guest_id = $val->ID;
						}					
						$this->data['saveddata'] = array(
							'GUEST_NAME' => $_POST['name'],
							'GUEST_PHONE' => $_POST['phone'],
							'GUEST_EMAIL' => $_POST['email'],
							'USER_ID' => $_POST['id'],
							'COMPANY_ID' => $company_id
						);	
						$this->db->where('ID', $guest_id);
						$this->db->update('GUEST', $this->data['saveddata']);				
					}
					
					$tables = array('REF_GENERAL', 'REF_TYPE');					
					$this->db->select('REF_GENERAL.ID');
					$this->db->select('REF_NAME');
					$this->db->select('REF_TYPE_NAME');
					$this->db->from($tables);
					$this->db->order_by('REF_NAME', 'ASC');		
					$this->db->where('REF_GENERAL.REF_TYPE_ID=REF_TYPE.ID');		
					$this->db->where('REF_TYPE_NAME', 'NEEDS_TYPE');			
					$this->db->where('REF_NAME', $_POST['need']);			
					$query = $this->db->get(); 
					$this->data['record10'] = $query->result();	
					foreach($this->data['record10'] as $item){
						$ref_id = $item->ID;
					}					
					
					//check if has signin
					//date_default_timezone_set('UTC');
					$tables = array('GUEST_BOOK', 'GUEST');	
					$this->db->select('GUEST_BOOK.ID');
					$this->db->select('GUEST_ID');
					$this->db->from($tables);		
					$this->db->where('GUEST_BOOK_STATUS', '1');	
					$this->db->where('GUEST_BOOK.GUEST_ID=GUEST.ID');	
					$names = array('1', $this->data['user_id']);
					$this->db->where_in('GUEST_BOOK.USER_ID', $names);							
					$this->db->where('GUEST.GUEST_NAME', $_POST['name']);
					$this->db->where('DATE(GUEST_BOOK.CREATE_DATE)', date("Y-m-d"));		
					//$this->db->limit(1);			
					$query = $this->db->get(); 
					$this->data['record20'] = $query->result();	
/* 					var_dump($this->data['record20']);
					die; */
					
					if($query->num_rows()>=1){
						$this->data['name'] = $_POST['name'];		
						$this->data['company'] = $_POST['company'];		
						$this->data['email'] = $_POST['email'];		
						$this->data['phone'] = $_POST['phone'];
						$this->data['warning'] = array(
							'text' => 'Ops, Today you have signed in, Sign out first.',
						);							
					}else{
						//execute guestbook
						if($_POST['need'] == 'Meet Someone'){
							$this->db->select('ID');
							$this->db->select('EMPLOYEE_NAME');
							$this->db->select('EMPLOYEE_EMAIL');
							$this->db->from('EMPLOYEES');		
							$this->db->where('EMPLOYEE_STATUS', '1');	
							$names = array('1', $this->data['user_id']);
							$this->db->where_in('USER_ID', $names);							
							$this->db->where('EMPLOYEE_NAME', $_POST['who']);
							$this->db->limit(1);			
							$query = $this->db->get(); 
							$this->data['record11'] = $query->result();
							if($query->num_rows()==1){
								foreach($this->data['record11'] as $item){
									$employee_id = $item->ID;
									$employee_email = $item->EMPLOYEE_EMAIL;
								}
								$this->data['saveddata'] = array(
										'GUEST_ID' => $guest_id,
										'EMPLOYEES_ID' => $employee_id,
										'REF_GENERAL_ID' => $ref_id,
										'USER_ID' => $_POST['id'],
									);								
								$this->db->insert('GUEST_BOOK', $this->data['saveddata']);
								//redirect(base_url().'front/welcome/'.$this->data['front_page']);
								//send email
								$message = 'NOTIFICATION<br><br>You have a guest from<br>Name : '.$_POST['name'].'<br>Email : '.$_POST['email'].'<br>Company : '.$_POST['company'];
							$this->mail_model->sent_from_gmail($employee_email, 'Guest : '.$_POST['name'], $message, $message);								
								redirect('front/thanks/2/'.$this->data['front_page']);
							}else{
								$this->data['name'] = $_POST['name'];		
								$this->data['company'] = $_POST['company'];		
								$this->data['email'] = $_POST['email'];		
								$this->data['phone'] = $_POST['phone'];
								$this->data['warning'] = array(
									'text' => 'Ops, Employee Name is not valid, Try a new one.',
								);								
							}
						}else if($_POST['need'] == 'Meeting'){
							if($_POST['meeting'] != ''){
								$this->data['saveddata'] = array(
										'GUEST_ID' => $guest_id,
										'MEETING_ID' => $_POST['meeting'],
										'REF_GENERAL_ID' => $ref_id,
										'USER_ID' => $_POST['id'],
									);								
								$this->db->insert('GUEST_BOOK', $this->data['saveddata']);
								//redirect(base_url().'front/welcome/'.$this->data['front_page']);
								redirect('front/thanks/2/'.$this->data['front_page']);
							}	else {
								$this->data['name'] = $_POST['name'];		
								$this->data['company'] = $_POST['company'];		
								$this->data['email'] = $_POST['email'];		
								$this->data['phone'] = $_POST['phone'];
								$this->data['warning'] = array(
									'text' => 'Ops, No meeting today, please select other necessity.',
								);								
							}				
						}else{
								$this->data['saveddata'] = array(
										'GUEST_ID' => $guest_id,
										'REF_GENERAL_ID' => $ref_id,
										'USER_ID' => $_POST['id'],
										'OTHER_NEEDS' => $_POST['oneed'],
									);								
								$this->db->insert('GUEST_BOOK', $this->data['saveddata']);
								//redirect(base_url().'front/welcome/'.$this->data['front_page']);								
								redirect('front/thanks/2/'.$this->data['front_page']);
						}						
					}
					
				}else if(isset($_POST['next'])){
					$this->data['name'] = $_POST['name'];		
					$this->data['company'] = $_POST['company'];		
					$this->data['email'] = $_POST['email'];		
					$this->data['phone'] = $_POST['phone'];
				}else{
					redirect('authentication/front_no_permission');	
				}
				
				$this->data['subtitle'] = 'Necessity';			
				$this->data['role_access'] = array('1','2','3','4','5');		
				//needs list
				$tables = array('REF_GENERAL', 'REF_TYPE');					
				$this->db->select('REF_GENERAL.ID');
				$this->db->select('REF_NAME');
				$this->db->select('REF_TYPE_NAME');
				$this->db->from($tables);
				$this->db->order_by('REF_NAME', 'ASC');		
				$this->db->where('REF_GENERAL.REF_TYPE_ID=REF_TYPE.ID');		
				$this->db->where('REF_TYPE_NAME', 'NEEDS_TYPE');			
				$query = $this->db->get(); 
				$this->data['record1'] = $query->result();

				//load data	
				$this->db->select('ID');
				$this->db->select('EMPLOYEE_NAME');
				$this->db->from('EMPLOYEES');
				$this->db->order_by('EMPLOYEE_NAME', 'ASC');		
				$this->db->where('EMPLOYEE_STATUS', '1');	
				$names = array('1', $this->data['user_id']);
				$this->db->where_in('USER_ID', $names);						
				$query = $this->db->get(); 
				$this->data['record2'] = $query->result();

				$cur_date = date('Y-m-d');
				$tables = array('MEETING', 'MEETING_ROOM');	
				$this->db->select('MEETING.ID');
				$this->db->select('AGENDA');
				$this->db->select('ROOM_NAME');
				$this->db->from($tables);
				$this->db->order_by('MEETING_TIME', 'ASC');		
				$this->db->where('MEETING_STATUS', '1');		
				$this->db->where('MEETING_ROOM_ID=MEETING_ROOM.ID');
				$names = array('1', $this->data['user_id']);
				$this->db->where_in('MEETING.USER_ID', $names);							
				$this->db->like('MEETING_TIME', $cur_date, 'after'); 		
				$query = $this->db->get(); 
				$this->data['record3'] = $query->result();							
				
				$this->load->view('front_header', $this->data);
				$this->load->view('front_sign_in_need');
				$this->load->view('front_footer');						
			}
		}		
	}	

	public function delivery($front_id = null){
		if($front_id == null){
			redirect('authentication/front_no_permission');
		}else{
			if($this->data['user_id'] === null){
				redirect('authentication/front_no_permission');
			}else{
				if(isset($_POST['submit'])){
					//check company
					$this->db->select('ID');
					$this->db->select('COMPANY_NAME');
					$this->db->from('COMPANY');		
					$this->db->where('COMPANY_STATUS', '1');	
					$names = array('1', $this->data['user_id']);
					$this->db->where_in('USER_ID', $names);						
					$this->db->where('COMPANY_NAME', $_POST['company']);				
					$this->db->where('REF_GENERAL_ID', '1');				
					$this->db->limit(1);				
					$query = $this->db->get(); 
					$this->data['record'] = $query->result();	
					if($query->num_rows()!=1){
						//insert ke database
						$this->data['saveddata'] = array(
							'COMPANY_NAME' => $_POST['company'],
							'REF_GENERAL_ID' => 1,
							'USER_ID' => $_POST['id']
						);								
						$this->db->insert('COMPANY', $this->data['saveddata']);	
						$company_id = $this->db->insert_id();
					}else{		
						foreach($this->data['record'] as $item){
							$company_id = $item->ID;
						}
					}
					
					$this->db->select('ID');
					$this->db->select('EMPLOYEE_NAME');
					$this->db->select('EMPLOYEE_EMAIL');
					$this->db->from('EMPLOYEES');		
					$this->db->where('EMPLOYEE_STATUS', '1');	
					$names = array('1', $this->data['user_id']);
					$this->db->where_in('USER_ID', $names);							
					$this->db->where('EMPLOYEE_NAME', $_POST['for']);
					$this->db->limit(1);			
					$query = $this->db->get(); 
					$this->data['record11'] = $query->result();
					if($query->num_rows()==1){
						foreach($this->data['record11'] as $item){
							$employee_id = $item->ID;
							$employee_email = $item->EMPLOYEE_EMAIL;
						}
						$this->data['saveddata'] = array(
								'PACKAGE_NAME' => 'Package from '.$_POST['company'].' to '.$_POST['for'],
								'EMPLOYEES_ID' => $employee_id,
								'COMPANY_ID' => $company_id,
								'USER_ID' => $_POST['id'],
							);								
						$this->db->insert('PACKAGES', $this->data['saveddata']);
						//send email
						$message = 'NOTIFICATION<br><br>You get package from '.$_POST['company'].'<br>Date : '.date('F d, Y').'<br>Time : '.date('H:i:s');
						$this->mail_model->sent_from_gmail($employee_email, 'Package from '.$_POST['company'], $message, $message);
						
						redirect('front/thanks/2/'.$this->data['front_page']);							
					}else{
						$this->data['company'] = $_POST['company'];
						$this->data['warning'] = array(
							'text' => 'Ops, Employee Name is not valid, Try a new one.',
						);								
					}									
				}
				
				//load data	
				//company list
				$tables = array('COMPANY', 'REF_GENERAL');		
				$this->db->select('COMPANY.ID');
				$this->db->select('COMPANY.COMPANY_NAME');
				$this->db->select('REF_GENERAL.REF_NAME');
				$this->db->from($tables);	
				$this->db->where('COMPANY.COMPANY_STATUS', '1');		
				$this->db->where('REF_GENERAL.REF_STATUS', '1');		
				$this->db->where('COMPANY.REF_GENERAL_ID=REF_GENERAL.ID');
				$this->db->where('REF_GENERAL.REF_NAME =', 'Expedition');
				$names = array('1', $this->data['user_id']);
				$this->db->where_in('COMPANY.USER_ID', $names);						
				$this->db->order_by('COMPANY.COMPANY_NAME', 'ASC');			
				$query = $this->db->get(); 
				$this->data['record1'] = $query->result();	
				
				$this->db->select('ID');
				$this->db->select('EMPLOYEE_NAME');
				$this->db->from('EMPLOYEES');
				$this->db->order_by('EMPLOYEE_NAME', 'ASC');		
				$this->db->where('EMPLOYEE_STATUS', '1');	
				$names = array('1', $this->data['user_id']);
				$this->db->where_in('USER_ID', $names);						
				$query = $this->db->get(); 
				$this->data['record2'] = $query->result();
				
				$this->data['subtitle'] = 'Delivery';			
				$this->data['role_access'] = array('1','2','3','4','5');	
				$this->load->view('front_header', $this->data);
				$this->load->view('front_delivery');
				$this->load->view('front_footer');
			}
		}		
	}
	
	public function sign_out($front_id = null){
		if($front_id == null){
			redirect('authentication/front_no_permission');
		}else{
			if($this->data['user_id'] === null){
				redirect('authentication/front_no_permission');
			}else{
				$this->db->select('GUEST_BOOK.ID');
				$this->db->select('REF_NAME');
				$this->db->select('GUEST_NAME');
				$this->db->select('COMPANY_NAME');
				$this->db->select('GUEST_BOOK_STATUS');
				$this->db->select('GUEST_BOOK.CREATE_DATE');
				$this->db->from('GUEST_BOOK');	
				$this->db->join('REF_GENERAL', 'REF_GENERAL.ID = GUEST_BOOK.REF_GENERAL_ID', 'left');			
				$this->db->join('GUEST', 'GUEST.ID = GUEST_BOOK.GUEST_ID', 'left');	
				$this->db->join('COMPANY', 'COMPANY.ID = GUEST.COMPANY_ID', 'left');
				$names = array('1', $this->data['user_id']);
				$this->db->where_in('GUEST_BOOK.USER_ID', $names);				
				$this->db->where('GUEST_BOOK_STATUS', '1');
				$this->db->order_by('GUEST_BOOK.CREATE_DATE', 'DESC');
				$query = $this->db->get(); 
				$this->data['record1'] = $query->result();
					
				//var_dump($this->data['record1']);
				if(isset($_POST['submit'])){
					$this->db->select('GUEST_BOOK.ID');
					$this->db->select('REF_NAME');
					$this->db->select('GUEST_NAME');
					$this->db->select('COMPANY_NAME');
					$this->db->select('GUEST_BOOK_STATUS');
					$this->db->select('GUEST_BOOK.CREATE_DATE');
					$this->db->from('GUEST_BOOK');	
					$this->db->join('REF_GENERAL', 'REF_GENERAL.ID = GUEST_BOOK.REF_GENERAL_ID', 'left');			
					$this->db->join('GUEST', 'GUEST.ID = GUEST_BOOK.GUEST_ID', 'left');	
					$this->db->join('COMPANY', 'COMPANY.ID = GUEST.COMPANY_ID', 'left');
					$names = array('1', $this->data['user_id']);
					$this->db->where_in('GUEST_BOOK.USER_ID', $names);				
					$this->db->where('GUEST_BOOK_STATUS', '1');
					$this->db->where('GUEST_NAME', $_POST['name']);
					$this->db->order_by('GUEST_BOOK.CREATE_DATE', 'DESC');
					$query = $this->db->get(); 
					$this->data['record2'] = $query->result();

					if($query->num_rows()<1){
						$this->data['warning'] = array(
							'text' => 'Ops, Guest Name not found, Try a new one.',
						);						
					}
				}
				
				$this->db->select('GUEST_BOOK.ID');
				$this->db->select('REF_NAME');
				$this->db->select('GUEST_NAME');
				$this->db->select('COMPANY_NAME');
				$this->db->select('GUEST_BOOK_STATUS');
				$this->db->select('GUEST_BOOK.CREATE_DATE');
				$this->db->from('GUEST_BOOK');	
				$this->db->join('REF_GENERAL', 'REF_GENERAL.ID = GUEST_BOOK.REF_GENERAL_ID', 'left');			
				$this->db->join('GUEST', 'GUEST.ID = GUEST_BOOK.GUEST_ID', 'left');	
				$this->db->join('COMPANY', 'COMPANY.ID = GUEST.COMPANY_ID', 'left');
				$names = array('1', $this->data['user_id']);
				$this->db->where_in('GUEST_BOOK.USER_ID', $names);				
				$this->db->where('GUEST_BOOK_STATUS', '1');
				$this->db->order_by('GUEST_BOOK.CREATE_DATE', 'DESC');
				$query = $this->db->get(); 
				$this->data['record1'] = $query->result();				
				
				$this->data['subtitle'] = 'Sign Out';			
				$this->data['role_access'] = array('1','2','3','4','5');	
				$this->load->view('front_header', $this->data);
				$this->load->view('front_sign_out');
				$this->load->view('front_footer');				
			}
		}
	}
	
	public function sign_out_conf($gid=null, $front_id = null){
		if($front_id == null){
			redirect('authentication/front_no_permission');
		}else{
			if($this->data['user_id'] === null){
				redirect('authentication/front_no_permission');
			}else{
				if(isset($_POST['submit'])){
					$this->db->set('GUEST_BOOK_STATUS', '0');
					$this->db->set('RATING', $_POST['rating']);
					$this->db->where('ID', $gid);
					$this->db->update('GUEST_BOOK');	
					redirect('front/thanks/1/'.$this->data['front_page']);
				}else{
					$this->db->select('GUEST_BOOK.ID');
					$this->db->select('REF_NAME');
					$this->db->select('GUEST_NAME');
					$this->db->select('COMPANY_NAME');
					$this->db->select('GUEST_BOOK_STATUS');
					$this->db->select('GUEST_BOOK.CREATE_DATE');
					$this->db->from('GUEST_BOOK');	
					$this->db->join('REF_GENERAL', 'REF_GENERAL.ID = GUEST_BOOK.REF_GENERAL_ID', 'left');			
					$this->db->join('GUEST', 'GUEST.ID = GUEST_BOOK.GUEST_ID', 'left');	
					$this->db->join('COMPANY', 'COMPANY.ID = GUEST.COMPANY_ID', 'left');
					$names = array('1', $this->data['user_id']);
					$this->db->where_in('GUEST_BOOK.USER_ID', $names);				
					$this->db->where('GUEST_BOOK_STATUS', '1');
					$this->db->where('GUEST_BOOK.ID', $gid);
					$this->db->order_by('GUEST_BOOK.CREATE_DATE', 'DESC');
					$query = $this->db->get(); 
					$this->data['record2'] = $query->result();
					if($query->num_rows()<1){
							redirect('authentication/front_no_permission');						
					}
					$this->data['subtitle'] = 'Sign Out';			
					$this->data['role_access'] = array('1','2','3','4','5');	
					$this->load->view('front_header', $this->data);
					$this->load->view('front_sign_out_conf');
					$this->load->view('front_footer');					
				}		
			}
		}
	}
	
	public function thanks($redirect= null, $front_id=null){
		if($front_id == null){
			redirect('authentication/front_no_permission');
		}else{
			$this->data['subtitle'] = 'Sign Out';			
			$this->data['role_access'] = array('1','2','3','4','5');	
			$this->load->view('front_header', $this->data);
			$this->load->view('front_thanks');
			$this->load->view('front_footer');
			
			if($redirect == '1'){
				header( "refresh:2;url=".base_url().'front/start/'.$this->data['front_page'] );
			}else if($redirect == '2'){
				header( "refresh:2;url=".base_url().'front/welcome/'.$this->data['front_page'] );
			}else{
				
			}
		}
	}
	
	public function foto($front_id = null){
		if($front_id == null){
			redirect('authentication/front_no_permission');
		}else{
			if($this->data['user_id'] === null){
				redirect('authentication/front_no_permission');
			}else{
				$this->data['subtitle'] = 'Welcome';			
				$this->data['role_access'] = array('1','2','3','4','5');	
				$this->load->view('front_header', $this->data);
				$this->load->view('front_foto');
				$this->load->view('front_footer');
			}
		}
	}	
}


