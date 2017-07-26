<?php
	//Grant access to user or guest
	$have_role = false;
	if(isset($this->session->userdata['is_logged_in'])) {
		foreach($role_access as $item){
			if($this->session->userdata['ROLE_ID'] == $item){
				$have_role = true;
			}
		} 
	}else{
		foreach($role_access as $item){
			if('5' == $item){
				$have_role = true;
			}
		}	
	}	
	if($have_role == false){
		header("location: " . base_url()."authentication/no_permission");
	}		
?>
<?php	
	if($init_data !== null){
		foreach($init_data as $item){
			$app_name = $item->APP_NAME;
			$office_name = $item->OFFICE_NAME;				
			$icon = $item->ICON;				
			$theme = $item->THEME;				
		}
	}else{
		$app_name = 'App Name';
		$office_name = 'Company Name';
		$icon = 'book';				
		$theme = 'dark';		
	}	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title>
		<?php 
			if(isset($subtitle)){
				echo ucwords(strtolower($subtitle.' '));
			}
			if(isset($title)){
				echo ucwords(strtolower($title));
			}
			echo ' | '.ucwords(strtolower($app_name)).' '.ucwords(strtolower($office_name));
		?>	
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/w3.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui.css">		
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/front_style.css">
	
	<script type='text/javascript' src="<?php echo base_url(); ?>js/jquery-3.1.0.min.js"></script>
	<script type='text/javascript' src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>		
	<script type='text/javascript' src="<?php echo base_url(); ?>js/custom-autocomplete.js"></script>		
</head>
<body>