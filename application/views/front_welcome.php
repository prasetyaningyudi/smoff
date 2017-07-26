<?php		
	foreach($init_data as $item){			
		$front_page = $item->FRONT_PAGE;
	} 
?>
<div class="my-content w3-display-container">
	<div class="w3-container w3-row-padding w3-height-padding w3-animate-opacity">
		<div class="w3-center w3-col m12"><h2>What do you want?</h2></div>
		<div class="w3-col m4">
			<a class="w3-btn w3-block w3-round w3-blue-grey w3-xxlarge w3-padding-48" href="<?php echo base_url().'front/sign_in/'.$front_page; ?>">Sign In</a>
		</div>
		<div class="w3-col m4">
			<a class="w3-btn w3-block w3-round w3-tiny-red w3-xxlarge w3-padding-48" href="<?php echo base_url().'front/sign_out/'.$front_page; ?>">Sign Out</a>
		</div>		
		<div class="w3-col m4">
			<a class="w3-btn w3-block w3-round w3-blue-grey w3-xxlarge w3-padding-48" href="<?php echo base_url().'front/delivery/'.$front_page; ?>">Delivery</A>
		</div>		
	</div>
</div>