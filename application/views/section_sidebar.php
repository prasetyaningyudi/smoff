<?php 
if(isset($this->session->userdata['is_logged_in'])){
	if($init_data != null){
		foreach($init_data as $val){
			$front_page = $val->FRONT_PAGE;
		}		
	}else{
		$front_page = '';
	}
}else{
	$front_page = '';
}
?>
<div id="container" class="no-margin">
	<div id="sidebar">
	<div id="sidebar-up">
		<div class="my-profile">
			<img src="<?php echo base_url(); ?>images/guest.png" width="25px" alt="Photo" class="img-circle"/> 
			<b>
			<?php  
				if(isset($this->session->userdata['is_logged_in'])){
					echo $this->session->userdata('USER_ALIAS');
				}else{
					echo 'Guest';
				}
			?>
			</b>
		</div>
		<div class="my-menu">
			<ul class="sidebar-nav" id="menu" style="list-style-type:none;">
				<?php foreach ($menu as $item):?>
					<li>
						<a href="<?php echo base_url().$item->PERMALINK; ?>"><span class="glyphicon glyphicon-<?php echo $item->MENU_ICON; ?>"></span> <?php echo $item->MENU_NAME; ?></a>
						<ul class="" style="list-style-type:none;">
						<?php foreach ($sub_menu as $sub_item):?>
							<?php if($item->ID ==  $sub_item->MENU_ID): ?>
								<?php if($item->MENU_NAME == 'Front Page'): ?>
									<li><a target='_blank' href="<?php echo base_url().'front/start/'.$front_page; ?>">- &nbsp;&nbsp;<span class="glyphicon glyphicon-<?php echo $sub_item->MENU_ICON; ?>"></span> <?php echo $sub_item->MENU_NAME; ?></a></li>								
								<?php else: ?>
									<li><a href="<?php echo base_url().$sub_item->PERMALINK; ?>">- &nbsp;&nbsp;<span class="glyphicon glyphicon-<?php echo $sub_item->MENU_ICON; ?>"></span> <?php echo $sub_item->MENU_NAME; ?></a></li>								
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach;?>
						</ul>					
					</li>
				<?php endforeach;?>	
			</ul>		
		</div>
	</div>
	</div>