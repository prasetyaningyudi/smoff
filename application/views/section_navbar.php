<?php	
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
<div id="header" class="no-margin">
	<nav class="navbar navbar-default my-navbar">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed menu-toggle" data-toggle="collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				 </button>	

				<a class="navbar-brand my-title" href="<?php echo base_url(); ?>">
					<span class="glyphicon glyphicon-<?php echo $icon; ?>"></span> 
					<b>
						<?php
							echo $app_name.' '.$office_name;
						?>
					</b>
				</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<button class="navbar-toggle collapse in menu-toggle" data-toggle="collapse"> 
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</li>
				</ul>
			</div>
		</div>
	</nav>	
</div>