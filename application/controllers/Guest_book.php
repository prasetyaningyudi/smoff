<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guest_book extends CI_Controller {
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
		$this->data['title'] = 'Guest Book';		
	}

	public function index($id=null){	
		$this->db->select('GUEST_BOOK.ID');
		$this->db->select('REF_NAME');
		$this->db->select('GUEST_NAME');
		$this->db->select('OTHER_NEEDS');
		$this->db->select('EMPLOYEES.EMPLOYEE_NAME');
		$this->db->select('MEETING.AGENDA');
		$this->db->select('GUEST_BOOK_STATUS');
		$this->db->select('GUEST_BOOK.CREATE_DATE');
		$this->db->from('GUEST_BOOK');	

		if($id !== null){
			$this->db->where('GUEST_BOOK.ID', $id);			
		}
		if($this->session->userdata['ROLE_ID'] == '4'){
			$this->db->where('GUEST_BOOK.USER_ID', $this->session->userdata['ID']);	
		}		
		$this->db->join('REF_GENERAL', 'REF_GENERAL.ID = GUEST_BOOK.REF_GENERAL_ID', 'left');			
		$this->db->join('GUEST', 'GUEST.ID = GUEST_BOOK.GUEST_ID', 'left');			
		$this->db->join('EMPLOYEES', 'EMPLOYEES.ID = GUEST_BOOK.EMPLOYEES_ID', 'left');			
		$this->db->join('MEETING', 'MEETING.ID = GUEST_BOOK.MEETING_ID', 'left');			
		$this->db->where('GUEST_BOOK_STATUS !=', '9');
		$this->db->order_by('GUEST_BOOK.CREATE_DATE', 'DESC');		
		
		$query = $this->db->get(); 
		$this->data['record'] = $query->result();	
		
		$this->data['subtitle'] = 'View';			
		$this->data['data_table'] = 'yes';
		$this->data['role_access'] = array('1','3','4');			
		
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('guest_book_index');
		$this->load->view('section_footer');
	}
	
/* 	public function create(){
		if(isset($_POST['submit'])){
			if($_POST['email'] == '' and $_POST['phone'] == ''){
				$this->data['warning'] = array(
					'text' => 'Ops, Please fill one of these information, Email or Phone',
				);				
			}else{
				$this->db->select('ID');
				$this->db->select('COMPANY_NAME');
				$this->db->from('COMPANY');		
				$this->db->where('COMPANY_STATUS', '1');		
				if($_POST['cid'] == ''){
					$this->db->where('COMPANY_NAME', $_POST['company']);	
				}else{
					$this->db->where('ID', $_POST['cid']);	
				}				
				$this->db->limit(1);				
				$query = $this->db->get(); 
				$this->data['record'] = $query->result();					
				if($query->num_rows()!=1){
					//insert ke database
					if($_POST['user'] == ''){
						$this->data['saveddata'] = array(
							'COMPANY_NAME' => $_POST['company'],
							'REF_GENERAL_ID' => 2,
							'USER_ID' => 1,							
						);								
					}else{
						$this->data['saveddata'] = array(
							'COMPANY_NAME' => $_POST['company'],
							'REF_GENERAL_ID' => 2,
							'USER_ID' => $_POST['user']
						);								
					}
					$this->db->insert('COMPANY', $this->data['saveddata']);	
					$cid = $this->db->insert_id();
				}else{		
					foreach($this->data['record'] as $item){
						$cid = $item->ID;
					}
				}
				
				//checking guest
				$this->db->select('ID');
				$this->db->select('GUEST_NAME');
				$this->db->from('GUEST');		
				$this->db->where('GUEST_STATUS', '1');		
				$this->db->where('COMPANY_ID', $cid);		
				if($_POST['id'] == ''){
					$this->db->where('GUEST_NAME', $_POST['name']);	
				}else{
					$this->db->where('ID', $_POST['id']);	
				} */
/* 				if($_POST['email'] != ''){
					$this->db->where('GUEST_EMAIL', $_POST['email']);
				}
				if($_POST['phone'] != ''){
					$this->db->where('GUEST_PHONE', $_POST['phone']);
				}	 */			
/* 				$this->db->limit(1);				
				$query = $this->db->get(); 
				$this->data['record1'] = $query->result();	
				if($_POST['user'] == ''){
					$user = null;
				}else{
					$user = $_POST['user'];
				}				
				if($query->num_rows()!=1){
					//insert ke database
					$this->data['saveddata'] = array(
						'GUEST_NAME' => $_POST['name'],
						'GUEST_PHONE' => $_POST['phone'],
						'GUEST_EMAIL' => $_POST['email'],
						'USER_ID' => $user,
						'COMPANY_ID' => $cid
					);			
					$this->db->insert('GUEST', $this->data['saveddata']);
					$gid = $this->db->insert_id();
				}else{
					foreach($this->data['record1'] as $val){
						$gid = $val->ID;
					}					
					$this->data['saveddata'] = array(
						'GUEST_NAME' => $_POST['name'],
						'GUEST_PHONE' => $_POST['phone'],
						'GUEST_EMAIL' => $_POST['email'],
						'USER_ID' => $user,
						'COMPANY_ID' => $cid
					);	
					$this->db->where('ID', $gid);
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
					$rid = $item->ID;
				}
				
				//execute guestbook
				if($_POST['need'] == 'Meet Someone'){
					$valid =false;					
					$eid= '';
					$did= '';
					if($_POST['wid'] == ''){
						$this->db->select('ID');
						$this->db->select('EMPLOYEE_NAME');
						$this->db->from('EMPLOYEES');		
						$this->db->where('EMPLOYEE_STATUS', '1');								
						$this->db->where('EMPLOYEE_NAME', $_POST['who']);
						$this->db->limit(1);			
						$query = $this->db->get(); 
						$this->data['record2'] = $query->result();
						if($query->num_rows()==1){
							$valid = true;
							foreach($this->data['record2'] as $item){
								$eid = $item->ID;
							}
						}	
						$this->db->select('ID');
						$this->db->select('DIVISION_NAME');
						$this->db->from('DIVISION');		
						$this->db->where('DIVISION_STATUS', '1');							
						$this->db->where('EMPLOYEE_NAME', $_POST['who']);
						$this->db->limit(1);			
						$query = $this->db->get(); 
						$this->data['record2'] = $query->result();	
						if($query->num_rows()==1){
							$valid = true;
							foreach($this->data['record2'] as $item){
								$did = $item->ID;
							}						
						}							
					}else {
						if(substr($_POST['wid'], 0,1) == 'E'){
							$this->db->select('ID');
							$this->db->select('EMPLOYEE_NAME');
							$this->db->from('EMPLOYEES');		
							$this->db->where('EMPLOYEE_STATUS', '1');								
							$this->db->where('ID', substr($_POST['wid'], 1));
							$this->db->limit(1);			
							$query = $this->db->get(); 
							$this->data['record2'] = $query->result();
							if($query->num_rows()==1){
								$valid = true;
								foreach($this->data['record2'] as $item){
									$eid = $item->ID;
								}
							}							
						}else if(substr($_POST['wid'], 0,1) == 'D'){
							$this->db->select('ID');
							$this->db->select('DIVISION_NAME');
							$this->db->from('DIVISION');		
							$this->db->where('DIVISION_STATUS', '1');							
							$this->db->where('ID', substr($_POST['wid'], 1));
							$this->db->limit(1);			
							$query = $this->db->get(); 
							$this->data['record2'] = $query->result();	
							if($query->num_rows()==1){
								$valid = true;
								foreach($this->data['record2'] as $item){
									$did = $item->ID;
								}						
							}							
						}						
					}

					if($valid == false){
						$this->data['warning'] = array(
							'text' => 'Ops, Employee or Division is not valid, Try a new one.',
						);						
					}else{
						if($eid != ''){
							$this->data['saveddata'] = array(
									'GUEST_ID' => $gid,
									'EMPLOYEES_ID' => $eid,
									'REF_GENERAL_ID' => $rid,
									'USER_ID' => $user,
								);								
							$this->db->insert('GUEST_BOOK', $this->data['saveddata']);								
						}else{
							$this->data['saveddata'] = array(
									'GUEST_ID' => $gid,
									'DIVISION_ID' => $did,
									'REF_GENERAL_ID' => $rid,
									'USER_ID' => $user,
								);								
							$this->db->insert('GUEST_BOOK', $this->data['saveddata']);	
							redirect('guest_book/index/'.$this->db->insert_id());
						}
					}				
				}else if($_POST['need'] == 'Meeting'){
					$this->data['saveddata'] = array(
							'GUEST_ID' => $gid,
							'MEETING_ID' => $_POST['meeting'],
							'REF_GENERAL_ID' => $rid,
							'USER_ID' => $user,
						);								
					$this->db->insert('GUEST_BOOK', $this->data['saveddata']);	
					redirect('guest_book/index/'.$this->db->insert_id());
				}else{
					$this->data['saveddata'] = array(
							'GUEST_ID' => $gid,
							'REF_GENERAL_ID' => $rid,
							'USER_ID' => $user,
						);								
					$this->db->insert('GUEST_BOOK', $this->data['saveddata']);	
					redirect('guest_book/index/'.$this->db->insert_id());
				}
			}				
		} */
/* 		//guest list
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
		$this->db->where('GUEST.COMPANY_ID=COMPANY.ID');		
		$query = $this->db->get(); 
		$this->data['record'] = $query->result();	

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
		$this->data['record1'] = $query->result();			 */
		
/* 		//company list
		$tables = array('COMPANY', 'REF_GENERAL');		
		$this->db->select('COMPANY.ID');
		$this->db->select('COMPANY.COMPANY_NAME');
		$this->db->select('REF_GENERAL.REF_NAME');
		$this->db->from($tables);	
		$this->db->where('COMPANY.COMPANY_STATUS', '1');		
		$this->db->where('REF_GENERAL.REF_STATUS', '1');		
		$this->db->where('COMPANY.REF_GENERAL_ID=REF_GENERAL.ID');
		$this->db->where('REF_GENERAL.REF_NAME !=', 'Expedition');
		$this->db->order_by('COMPANY.COMPANY_NAME', 'ASC');			
		$query = $this->db->get(); 
		$this->data['record2'] = $query->result();			
		
		//load data	
		$this->db->select('ID');
		$this->db->select('EMPLOYEE_NAME');
		$this->db->from('EMPLOYEES');
		$this->db->order_by('EMPLOYEE_NAME', 'ASC');		
		$this->db->where('EMPLOYEE_STATUS', '1');		
		$query = $this->db->get(); 
		$this->data['record3'] = $query->result();	

		$this->db->select('ID');
		$this->db->select('DIVISION_NAME');
		$this->db->from('DIVISION');
		$this->db->order_by('DIVISION_NAME', 'ASC');		
		$this->db->where('DIVISION_STATUS', '1');		
		$query = $this->db->get(); 
		$this->data['record4'] = $query->result();		

		$cur_date = date('Y-m-d');
		
		$tables = array('MEETING', 'MEETING_ROOM');	
		$this->db->select('MEETING.ID');
		$this->db->select('AGENDA');
		$this->db->select('ROOM_NAME');
		$this->db->from($tables);
		$this->db->order_by('AGENDA', 'ASC');		
		$this->db->where('MEETING_STATUS', '1');		
		$this->db->where('MEETING_ROOM_ID=MEETING_ROOM.ID');		
		$this->db->like('MEETING_TIME', $cur_date, 'after'); 		
		$query = $this->db->get(); 
		$this->data['record5'] = $query->result();			
		
		$this->data['subtitle'] = 'Sign In';			
		$this->data['data_table'] = 'no';	
		$this->data['role_access'] = array('1','3','4');			
		
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('guest_book_create');
		$this->load->view('section_footer');
	} */
	
/* 	public function update($id=null){
		if($id == null){
			redirect('authentication/no_permission');
		}else{
			
			if($query->result() !== null){
				if(isset($_POST['submit'])){

				}
			}else{
				redirect('packages');
			}						
		}
	}	 */

/* 	public function sign_out($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('GUEST_BOOK_STATUS');	
			$this->db->from('GUEST_BOOK');
			$this->db->where('ID', $id);	
			$this->db->where('GUEST_BOOK_STATUS', '1');	
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result !== null){
				//Update Status di database
				$this->db->set('GUEST_BOOK_STATUS', '0');
				$this->db->where('ID', $id);
				$this->db->update('GUEST_BOOK');	
				redirect('guest_book');
			}else{
				redirect('guest_book');
			}
		}		
	}	 */
	
	public function delete($id=null){
		if($id === null){
			redirect('authentication/no_permission');
		}else{
			//load data
			$this->db->select('ID');	
			$this->db->select('GUEST_BOOK_STATUS');	
			$this->db->from('GUEST_BOOK');
			$this->db->where('ID', $id);	
			$query = $this->db->get();	
			$result = $query->result();
			
			if($result !== null){
				//Update Status di database
				$this->db->set('GUEST_BOOK_STATUS', '9');
				$this->db->where('ID', $id);
				$this->db->update('GUEST_BOOK');	
				redirect('guest_book');
			}else{
				redirect('guest_book');
			}
		}		
	}

/* 	public function signout(){
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
		if(isset($_POST['submit'])){
			if($_POST['id']==''){
				$this->data['warning'] = array(
					'text' => 'Ops, Guest Book name not valid, try another',
				);
				$this->db->where('1!=', '1');
			}else{
				$this->db->where('GUEST_BOOK.ID', $_POST['id']);			
			}			
		}else{
			$this->db->where('1!=', '1');	
		}
		$this->db->where('GUEST_BOOK_STATUS', '1');		
		$this->db->order_by('GUEST_BOOK.CREATE_DATE', 'DESC');		
		
		$query = $this->db->get();
		$this->data['record'] = $query->result();	
		
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
		$this->db->where('GUEST_BOOK_STATUS', '1');
		$this->db->order_by('GUEST_BOOK.CREATE_DATE', 'DESC');		
		
		$query = $this->db->get();
		$this->data['record1'] = $query->result();		
		
		$this->data['subtitle'] = 'View';			
		$this->data['data_table'] = 'yes';
		$this->data['role_access'] = array('1','3','4');			
		
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('guest_book_signout');
		$this->load->view('section_footer');		
	}
 */	
}


