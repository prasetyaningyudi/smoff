<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');		
		$this->load->helper('url');			
		$this->load->helper('cookie');
		$this->load->database();
		$this->load->model('upload_model');
		$this->load->model('menu_model');
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
		$this->data['title'] = 'Home';		
	}
	
	public function index(){	
/* 		$this->data['subtitle'] = 'Index';			
		$this->data['data_table'] = 'no';
		$this->data['role_access'] = array('1','2','3','4');		 */
		
/* 		if($this->init_data_validation()){
			$this->data['valid'] = TRUE;
			$this->set_cookies_init();
		}else{
			$this->data['valid'] = FALSE;
			$this->set_cookies_init_none();
		}		 */
		
		//view
/* 		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('home');
		$this->load->view('section_footer'); */
		redirect('home/welcome');
	}	
	
	public function welcome($message=null){
		if($message == 'signup_success'){
			$this->data['message'] = 'signup_success';
		}else{
			$this->data['message'] =  null;
		}
		$this->data['subtitle'] = 'Welcome';			
		$this->data['data_table'] = 'no';
		$this->data['role_access'] = array('1','2','3','4','5');	

		if(isset($this->session->userdata['is_logged_in'])) {
			if($this->init_data_validation()){
				$this->data['valid'] = TRUE;
			}else{
				$this->data['valid'] = FALSE;
			}			
		}else{
			$this->data['valid'] = FALSE;		
		}				
		
		//view
		$this->load->view('section_header', $this->data);
		$this->load->view('section_navbar');
		$this->load->view('section_sidebar');
		$this->load->view('section_breadcurm');
		$this->load->view('section_content_title');
		$this->load->view('home');
		$this->load->view('section_footer');
	}
	
	public function init_data(){
		if(isset($_POST['submit'])){
				if ( preg_match('/\s/',$_POST['fpage']) ){
					$this->data['warning'] = array(
						'text' => 'Ops, Front page cannot contain white space',
					);
				}else{
					$this->db->select('ID');	
					$this->db->select('FRONT_PAGE');		
					$this->db->from('INIT_DATA');	
					$this->db->where('FRONT_PAGE', $_POST['fpage']);			
					$query = $this->db->get();	
					if($query->num_rows()==1){
						$this->data['warning'] = array(
							'text' => 'Ops, Front Page Name already exist, Try a new one.',
						);
					}else{
						if($_FILES['flogo']['name'] != ''){
/* 							var_dump($_FILES['flogo']);
							var_dump($_FILES['flogo']['name']);
							var_dump($_FILES['flogo']['type']);
							var_dump($_FILES['flogo']['size']);
							var_dump($_FILES['flogo']['tmp_name']);
							var_dump($_FILES['flogo']['error']);							 */
							if($_FILES['flogo']['error'] == 0){
								if($_FILES['flogo']['type'] == 'image/png' or $_FILES['flogo']['type'] == 'image/jpeg'){
									//upload file
									$last_id = $this->upload_model->insert_file($_FILES['flogo']['name'], $_FILES['flogo']['type'], $_FILES['flogo']['size'],$_FILES['flogo']['tmp_name']);
/* 									var_dump($last_id); */
									
									//insert ke database
									$this->data['saveddata'] = array(
										'APP_NAME' => $_POST['app'],
										'OFFICE_NAME' => $_POST['office'],
										'ICON' => $_POST['icon'],
										'FRONT_PAGE' => $_POST['fpage'],
										'THEME' => $_POST['theme'],
										'USER_ID' => $_POST['user'],
										'FILE_ID' => $last_id
									);			
									$this->db->insert('INIT_DATA', $this->data['saveddata']);
									//$this->set_cookies_init();
									redirect('home/update_data');										
								}else{
									$this->data['warning'] = array(
										'text' => 'Ops, File Upload must be image with extention jpg, jpeg, or png',
									);									
								}
							}else{
								$this->data['warning'] = array(
									'text' => 'Ops, Upload logo error, Maybe cause size file more than '.($_POST['MAX_FILE_SIZE']/1000000).'MB',
								);														
							}							
						}else{
									//insert ke database
									$this->data['saveddata'] = array(
										'APP_NAME' => $_POST['app'],
										'OFFICE_NAME' => $_POST['office'],
										'ICON' => $_POST['icon'],
										'FRONT_PAGE' => $_POST['fpage'],
										'THEME' => $_POST['theme'],
										'USER_ID' => $_POST['user'],
									);			
									$this->db->insert('INIT_DATA', $this->data['saveddata']);
									//$this->set_cookies_init();
									redirect('home/update_data');									
						}				
					}
				}	
		}
		if($this->init_data_validation()){
			redirect('home/update_data');
		}else{
			$this->data['subtitle'] = 'Initial Data';			
			$this->data['data_table'] = 'no';
			$this->data['role_access'] = array('1','2','3','4');
			
			//view
			$this->load->view('section_header', $this->data);
			$this->load->view('section_navbar');
			$this->load->view('section_sidebar');
			$this->load->view('section_breadcurm');
			$this->load->view('section_content_title');
			$this->load->view('init_create');
			$this->load->view('section_footer');
		}							

	}
	
	public function update_data(){
		if(isset($_POST['submit'])){
			if($_FILES['flogo']['name'] != ''){
				if($_FILES['flogo']['error'] == 0){
					if($_FILES['flogo']['type'] == 'image/png' or $_FILES['flogo']['type'] == 'image/jpeg'){
						if($_POST['fid'] != ''){
							//upload file
							$last_id = $this->upload_model->update_file($_POST['fid'], $_FILES['flogo']['name'], $_FILES['flogo']['type'], $_FILES['flogo']['size'],$_FILES['flogo']['tmp_name']);
							
							//update ke database
							$this->data['saveddata'] = array(
								'APP_NAME' => $_POST['app'],
								'OFFICE_NAME' => $_POST['office'],
								'ICON' => $_POST['icon'],
								'THEME' => $_POST['theme'],
								'USER_ID' => $_POST['user'],
							);		
							$this->db->where('ID', $_POST['id']);
							$this->db->update('INIT_DATA', $this->data['saveddata']);
							redirect('home/update_data');	
						}else{
							//upload file
							$last_id = $this->upload_model->insert_file($_FILES['flogo']['name'], $_FILES['flogo']['type'], $_FILES['flogo']['size'],$_FILES['flogo']['tmp_name']);
							
							//update ke database
							$this->data['saveddata'] = array(
								'APP_NAME' => $_POST['app'],
								'OFFICE_NAME' => $_POST['office'],
								'ICON' => $_POST['icon'],
								'THEME' => $_POST['theme'],
								'USER_ID' => $_POST['user'],
								'FILE_ID' => $last_id,
							);		
							$this->db->where('ID', $_POST['id']);
							$this->db->update('INIT_DATA', $this->data['saveddata']);
							redirect('home/update_data');								
						}
					}else{
						$this->data['warning'] = array(
							'text' => 'Ops, File Upload must be image with extention jpg, jpeg, or png',
						);									
					}
				}else{
					$this->data['warning'] = array(
						'text' => 'Ops, Upload logo error, Maybe cause size file more than '.($_POST['MAX_FILE_SIZE']/1000000).'MB',
					);														
				}							
			}else{
				//update ke database
				$this->data['saveddata'] = array(
					'APP_NAME' => $_POST['app'],
					'OFFICE_NAME' => $_POST['office'],
					'ICON' => $_POST['icon'],
					'THEME' => $_POST['theme'],
					'USER_ID' => $_POST['user'],
				);		
				$this->db->where('ID', $_POST['id']);
				$this->db->update('INIT_DATA', $this->data['saveddata']);
				redirect('home/update_data');								
			}		
		}else{
			if($this->init_data_validation()){
				$this->data['subtitle'] = 'Initial Data';			
				$this->data['data_table'] = 'no';
				$this->data['role_access'] = array('1','2','3','4',);
				
				$this->db->select('ID');	
				$this->db->select('APP_NAME');	
				$this->db->select('OFFICE_NAME');	
				$this->db->select('ICON');	
				$this->db->select('FRONT_ICON');	
				$this->db->select('FRONT_PAGE');	
				$this->db->select('FILE_ID');	
				$this->db->select('THEME');	
				$this->db->from('INIT_DATA');	
				$this->db->where('USER_ID', $this->session->userdata['ID']);			
				$this->db->order_by('ID', 'DESC');	
				$this->db->limit(1);
				$query = $this->db->get();	
				$this->data['record'] = $query->result();			
				
				//view
				$this->load->view('section_header', $this->data);
				$this->load->view('section_navbar');
				$this->load->view('section_sidebar');
				$this->load->view('section_breadcurm');
				$this->load->view('section_content_title');
				$this->load->view('init_update');
				$this->load->view('section_footer');				
			}else{
				redirect('home/init_data');
			}			
		}		
	}
	
	private function init_data_validation(){
		$query = $this->init_model->get_init_data($this->session->userdata['ID']);
		if($query->num_rows()==1){
			$valid = TRUE;		
		}else{
			$valid = FALSE;		
		}		
		return $valid;
	}
}


