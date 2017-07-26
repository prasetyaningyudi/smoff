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
	//set cookies or get cookies
	$this->load->helper('cookie');
	if(get_cookie("toogled") === null){
		//set cookies
		$cookie= array(
		  'name'   => 'toogled',
		  'value'  => 'yes',
		  'expire' => '86400',
		);
		$this->input->set_cookie($cookie);				
	}

	if($init_data !== null){
		foreach($init_data as $item){
			$app_name = $item->APP_NAME;
			$office_name = $item->OFFICE_NAME;				
			$icon = $item->ICON;				
			$theme = $item->THEME;				
		}
	}else{
		$app_name = 'Visitor Management System';
		$office_name = '';
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
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/w3.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui.css">	
	<?php if(isset($data_table) and $data_table == 'yes'): ?>	
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datatables.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/rowReorder.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/responsive.dataTables.min.css">
	<?php endif; ?>		
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
	<?php if($theme !== null): ?>
		<?php if($theme == 'blue'): ?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/theme_blue.css">
		<?php elseif($theme == 'light'): ?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/theme_light.css">
		<?php endif; ?> 
	<?php endif; ?> 
	<script type='text/javascript' src="<?php echo base_url(); ?>js/jquery-3.1.0.min.js"></script>	
	<script type='text/javascript' src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>	
	<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>	
	<?php if(isset($data_table) and $data_table == 'yes'): ?>		
		<script type='text/javascript' src="<?php echo base_url(); ?>js/datatables.min.js"></script>
		<script type='text/javascript' src="<?php echo base_url(); ?>js/dataTables.rowReorder.min.js"></script>
		<script type='text/javascript' src="<?php echo base_url(); ?>js/dataTables.responsive.min.js"></script>
	<?php endif; ?>		
</head>
<body>