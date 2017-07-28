			  <div class="panel-body">
				<form method="post" class="form-horizontal">
				  <fieldset>
					<div class="form-group">
					<label for="name" class="col-sm-2">Name:<br></label>
					<div class="col-sm-10">
					<input class="form-control input-lg" id="name" type="text" name="name" value="" placeholder="Name" required>
					</div>
					</div>
					<div class="form-group">
					<label for="email" class="col-sm-2">Email:<br></label>
					<div class="col-sm-10">
					<input class="form-control input-lg" id="email" type="email" name="email" value="" placeholder="Valid Email" required>
					</div>
					</div>					
					<div class="form-group">
					<div class="col-sm-2">
					<input type="submit" name="submit" value="Sign Up" class="btn btn-default btn-lg">
					</div>
					<div class="col-sm-10">
						<?php
							if(isset($warning) and $warning !== null){
								echo '<div class="alert alert-warning" role="alert">';
								echo $warning['text'];
								echo '</div>';
							}
						?>
					</div>					
					</div>					
				  </fieldset>	
				</form>
			  </div>			  
			</div> 
		</div> 
	</div>				
</div>		