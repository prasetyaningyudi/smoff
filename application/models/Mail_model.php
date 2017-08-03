<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_model extends CI_Model {
	
	public function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
		require_once FCPATH.'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
	}	
	
	public function sent_from_gmail($ToEmail, $subject, $MessageHTML, $MessageTEXT){
		$MessageHTML .= '<br><br><br>OVIS : Smart System for Smart Office.';
		$MessageTEXT .= '<br><br><br>OVIS : Smart System for Smart Office.';
		//Create a new PHPmailer instance
		$mail = new PHPmailer;

		$mail->IsSMTP(); // Use SMTP
		$mail->Host        = "smtp.gmail.com"; // Sets SMTP server
		//$mail->SMTPDebug   = 1; // 2 to enable SMTP debug information
		$mail->SMTPAuth    = TRUE; // enable SMTP authentication
		$mail->SMTPSecure  = "ssl"; //Secure conection
		$mail->Port        = 465; // set the SMTP port
		$mail->Username    = 'prasetyaningyudi@gmail.com'; // SMTP account username
		$mail->Password    = '261084Oke.Yudi'; // SMTP account password
		$mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
		$mail->CharSet     = 'UTF-8';
		$mail->Encoding    = '8bit';
		$mail->Subject     = $subject;
		$mail->ContentType = 'text/html; charset=utf-8\r\n';
		$mail->From        = 'prasetyaningyudi@gmail.com';
		$mail->FromName    = 'OVIS';
		$mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line

		$mail->AddAddress( $ToEmail ); // To:
		$mail->isHTML( TRUE );
		$mail->Body    = $MessageHTML;
		

		$mail->AltBody = $MessageTEXT;
		$mail->Send();
		$mail->SmtpClose();

		if ( $mail->IsError() ) { // ADDED - This error checking was missing
			return FALSE;
		}else{
			return TRUE;
		}	
	}
	
	
	public function sent_from_kemenkeu(){
		$config = array();
		$config['useragent'] = 'CodeIgniter';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'webmail.kemenkeu.go.id';
		$config['smtp_port'] = 587;		
		$config['smtp_user'] = 'yudi.prasetyo@kemenkeu.go.id';
		$config['smtp_pass'] = '191284Oke.';		 
		$config['smtp_timeout'] = 5;
		$config['wordwrap'] = TRUE;
		$config['wrapchars'] = 76;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = TRUE;
		$config['priority'] = 3;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['bcc_batch_mode'] = FALSE;
		$config['bcc_batch_size'] = 200;
		return $this->load->library('email', $config);
	}
}