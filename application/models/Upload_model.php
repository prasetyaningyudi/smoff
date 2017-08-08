<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model {

	public function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
	}

	public function insert_file($name, $type, $size, $tmp){
		$fp      = fopen($tmp, 'r');
		$content = fread($fp, $size);
		fclose($fp);			
		$i = strrpos($name,'.');
		$ext = substr($name, $i+1);
		$insert = array(
			'DATA_FILE' => $content,
			'TYPE_FILE' => $type,
			'EXT_FILE' => $ext,
			'SIZE_FILE' => $size,
		);			
		$this->db->insert('FILE', $insert); 
		return $this->db->insert_id();
	}	
	
	public function update_file($fid, $name, $type, $size, $tmp){
		$fp      = fopen($tmp, 'r');
		$content = fread($fp, $size);
		fclose($fp);			
		$i = strrpos($name,'.');
		$ext = substr($name, $i+1);
		$insert = array(
			'DATA_FILE' => $content,
			'TYPE_FILE' => $type,
			'EXT_FILE' => $ext,
			'SIZE_FILE' => $size,
		);		
		$this->db->where('ID', $fid);
		$this->db->update('FILE', $insert); 
		return $fid;
	}		
}