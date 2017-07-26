			  <div class="panel-body">
					<form action="" id="inputform" method="post" class="form-horizontal">
					  <fieldset>
						<div class="form-group">	
						<label for="username" class="col-sm-2 hidden-sm-xs">Username:<br></label>
						<div class="col-sm-10">		
						<input class="form-control input-lg" id="username" type="text" name="username" value="" placeholder="Username" required>
						</div>
						</div>					  
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
						<label for="alias" class="col-sm-2 hidden-sm-xs">User Alias:<br></label>
						<div class="col-sm-10">		
						<input class="form-control input-lg" id="alias" type="text" name="alias" value="" placeholder="User Alias" required>
						</div>
						</div>
						<div class="form-group">	
						<label for="role" class="col-sm-2 hidden-sm-xs">Role:<br></label>
						<div class="col-sm-10">	
						<select class="form-control input-lg" id="role" name="role" form="inputform">
							<?php foreach ($record as $item):?>
							<option value="<?php echo $item->ID;?>"><?php echo $item->ROLE_NAME;?></option>	
							<?php endforeach;?>
						</select>  
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