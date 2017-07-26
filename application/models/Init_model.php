<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Init_model extends CI_Model {

	public function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
	}

		public function get_init_data($user_id){
			$this->db->select('ID');	
			$this->db->select('APP_NAME');	
			$this->db->select('OFFICE_NAME');	
			$this->db->select('ICON');	
			$this->db->select('FRONT_ICON');	
			$this->db->select('THEME');	
			$this->db->select('FRONT_PAGE');	
			$this->db->from('INIT_DATA');
			$this->db->where('USER_ID', $user_id);		
			$this->db->limit(1);
			$query = $this->db->get();	 
			return $query;
		}	
		
		public function get_user_id($front_page){
			$tables = array('INIT_DATA', 'USER');		
			$this->db->select('INIT_DATA.ID');	
			$this->db->select('USER_ID');	
			$this->db->from($tables);
			$this->db->where('USER_ID=USER.ID');		
			$this->db->where('USER.USER_STATUS', '1');		
			$this->db->where('FRONT_PAGE', $front_page);		
			$this->db->limit(1);
			$query = $this->db->get();	 
			$result = $query->result();	
			if($result !== null){
				foreach($result as $item){
					$user_id = $item->USER_ID;
				}
				return $user_id;
			}else{
				return null;
			}
		}
}