<div class="my-content w3-display-container">
	<form class="w3-container w3-row-padding w3-height-padding" action="<?php echo base_url().'authentication/m_login_validation'; ?>"method="post">
		<div class="w3-center w3-col m12"><h2>Login</h2></div>
		<div class="w3-col m12">
			<input class="w3-input w3-round w3-border w3-light-gray w3-xlarge" id="username" type="text" name="username" placeholder="Email" value="" required>
		</div>
		<div class="w3-col m12">
			<input class="w3-input w3-round w3-border w3-light-gray w3-xlarge" type="password" name="password" id="password" placeholder="Password" required>
		</div>		
		<div class="w3-col m12">
			<input type="submit" class="w3-btn w3-block w3-round w3-blue-grey w3-xxlarge" name="submit" value="Submit">
		</div>	
		<?php
			if(isset($warning) and $warning !== null){
				echo '<div class="w3-col m12 w3-round w3-red">';
				echo '<h3>'.$warning['text'].'</h3>';
				echo '</div>';
			}
		?>			
	</form>
</div>