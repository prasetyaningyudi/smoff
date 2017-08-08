<div class="my-content w3-display-container">
  <div class="w3-container w3-row-padding w3-section">
		<div class="w3-col m12 w3-red w3-padding-16 w3-round justify">
			<h2 class="">Warning!</h2>
			<h3 class="">						
				<?php
				if(isset($warning) and $warning !== null){
					echo '<div class="alert alert-warning" role="alert">';
					echo $warning['text'];
					echo '</div>';
				}
			?>
			</h3>
		</div>	
  </div>
</div>