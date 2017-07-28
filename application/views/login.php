			  <div class="panel-body">
				<form action="<?php echo base_url().'authentication/login_validation'; ?>" method="post" class="form-horizontal">
				  <fieldset>
					<div class="form-group">
					<label for="nomor" class="col-sm-2">Email:<br></label>
					<div class="col-sm-10">
					<input class="form-control input-lg" id="username" type="text" name="username" value="" placeholder="Email as Username" required>
					</div>
					</div>
					<div class="form-group">
					<label for="nomor" class="col-sm-2">Password:<br></label>
					<div class="col-sm-10">
					<input class="form-control input-lg" id="password" type="password" name="password" value="" placeholder="password" required>
					</div>
					</div>	
					<div class="form-group">
					<div class="col-sm-2">
					<input type="submit" name="submit" value="Submit" class="btn btn-default btn-lg">
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