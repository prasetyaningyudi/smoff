<?php		
	foreach($init_data as $item){			
		$icon = $item->FRONT_ICON;
		$file_id = $item->FILE_ID;
		$front_page = $item->FRONT_PAGE;
	}
?>
<div class="my-content w3-display-container">
	<div class="w3-animate-opacity">
		<?php if($file_id != ''): ?>
			<div class="w3-display-20 w3-logo w3-text-lime"><?php echo '<img width="300px" src="data:image/jpeg;base64,'.base64_encode( $flogo ).'"/>'; ?></div>
		<?php else: ?>
			<div class="w3-display-20 w3-logo w3-text-lime"><span class="fa fa-<?php echo $icon; ?>"></span></div>
		<?php endif; ?>
			<div class="w3-display-middle w3-large"><a class="w3-button w3-round w3-xxlarge w3-teal w3-hover-aqua" href="<?php echo base_url().'front/welcome/'.$front_page; ?>">Tap to start <i class="fa fa-long-arrow-right"></i></a></div>
	</div>
</div>