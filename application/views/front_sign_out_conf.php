<?php foreach ($record2 as $item){
	$guest_id = $item->ID;
	$guest_name = $item->GUEST_NAME;
	$company = $item->COMPANY_NAME;
}
?>


<div class="my-content w3-content">
	<form class="w3-container w3-row-padding w3-height-padding" method="post">
		<div class="w3-center w3-col m12"><h2>Rate Our Service!</h2></div>
		<div class="w3-col m6">
			<input type="hidden" name="id" value="<?php echo $user_id; ?>">
			<input type="hidden" name="gid" value="<?php echo $guest_id; ?>">
			<h2 class="w3-center"><?php echo $guest_name; ?></h2>
		</div>	
		<div class="w3-col m6">
			<h3 class="w3-center"><?php echo $company; ?></h3>
		</div>	
		<div class="my-rating">
		<fieldset class="rating w3-xxlarge">
				<input type="radio" id="star5" name="rating" value="5" required><label class = "full" for="star5"></label>
				<input type="radio" id="star4half" name="rating" value="4.5" required><label class="half" for="star4half"></label>
				<input type="radio" id="star4" name="rating" value="4" required><label class = "full" for="star4"></label>
				<input type="radio" id="star3half" name="rating" value="3.5" required><label class="half" for="star3half"></label>
				<input type="radio" id="star3" name="rating" value="3" required><label class = "full" for="star3"></label>
				<input type="radio" id="star2half" name="rating" value="2.5" required><label class="half" for="star2half"></label>
				<input type="radio" id="star2" name="rating" value="2" required><label class = "full" for="star2"></label>
				<input type="radio" id="star1half" name="rating" value="1.5" required><label class="half" for="star1half"></label>
				<input type="radio" id="star1" name="rating" value="1" required><label class = "full" for="star1"></label>
				<input type="radio" id="starhalf" name="rating" value="0.5" required><label class="half" for="starhalf"></label>
		</fieldset>
		</div>
		<div style="clear:both"></div>
		<div class="w3-col m12 w3-center">
			<input type="submit" class="w3-btn w3-round w3-tiny-red w3-xxlarge w3-section" name="submit" value="Sign Out">
		</div>		
	</form>
</div>