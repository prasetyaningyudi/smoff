<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontpage_model extends CI_Model {

	public function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
	}
				
	public function get_front_page($url=null){
		$result = explode("/",$url);
		return end($result);
	}				

}