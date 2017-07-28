			  <div class="panel-body">
				<?php foreach($record as $item): ?>
				<h4>Input your password to complete registration</h4>
				<form method="post" class="form-horizontal">
				  <fieldset>
					<div class="form-group">
					<label for="name" class="col-sm-2">Name:<br></label>
					<div class="col-sm-10">
					<input class="form-control input-lg" id="name" type="text" name="name" value="<?php echo $item->USER_ALIAS; ?>" placeholder="Name" required readonly>
					</div>
					</div>
					<div class="form-group">
					<label for="email" class="col-sm-2">Username / Email:<br></label>
					<div class="col-sm-10">
					<input class="form-control input-lg" id="email" type="email" name="email" value="<?php echo $item->USERNAME; ?>" placeholder="Valid Email" required readonly>
					</div>
					</div>
					<input type="hidden" name="id" value="<?php echo $item->ID; ?>">
						<div class="form-group">	
						<label for="password" class="col-sm-2 hidden-sm-xs">Password:<br></label>
						<div class="col-sm-10">		
						<input class="form-control input-lg" id="password" type="password" name="password" value="" placeholder="Password" required>
						</div>
						</div>
						<div class="form-group">	
						<label for="password2" class="col-sm-2 hidden-sm-xs">Repeat Password:<br></label>
						<div class="col-sm-10">		
						<input class="form-control input-lg" id="password2" type="password" name="password2" value="" placeholder="Repeat Password" required>
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
				<?php endforeach; ?>
			  </div>			  
			</div> 
		</div> 
	</div>				
</div>		