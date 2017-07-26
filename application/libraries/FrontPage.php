<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontpage{
	
	public function get_front_page($url=null){
		$result = explode("/",$url);
		return end($result);
	}
}