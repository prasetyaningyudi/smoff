			  <div class="panel-body">
					<form action="" id="inputform" method="post" class="form-horizontal">
					  <fieldset>
					  <?php foreach ($record as $item):?>
						<div class="form-group">	
						<label for="username" class="col-sm-2">Username:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="username" type="text" name="username" value="<?php echo $item->USERNAME;?>" placeholder="Username" required readonly>
						</div>
						</div>		
						<div class="form-group">	
						<label for="password0" class="col-sm-2">Old Password:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="password0" type="password" name="password0" value="<?php echo $item->PASSWORD;?>" placeholder="Password" required readonly>
						</div>
						</div>						
						<div class="form-group">	
						<label for="password" class="col-sm-2">New Password:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="password" type="password" name="password" value="" placeholder="New Password">
						</div>
						</div>
						<div class="form-group">	
						<label for="password2" class="col-sm-2">Repeat New Password:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="password2" type="password" name="password2" value="" placeholder="Repeat New Password">
						</div>
						</div>
						<div class="form-group">	
						<label for="alias" class="col-sm-2">User Alias:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="alias" type="text" name="alias" value="<?php echo $item->USER_ALIAS;?>" placeholder="User Alias" required>
						</div>
						</div>
						<?php if($item->ROLE_ID != '1'): ?>
						<div class="form-group">	
						<label for="role" class="col-sm-2">Role:<br></label>
						<div class="col-sm-10">	
						<select class="form-control" id="role" name="role" form="inputform">
							<?php foreach ($record1 as $item1):?>
								<?php if($item1->ID == $item->ROLE_ID){
										$selected = 'selected';
									}else{
										$selected = '';
									}
								?>
							<option value="<?php echo $item1->ID;?>" <?php echo $selected;?>><?php echo $item1->ROLE_NAME;?></option>	
							<?php endforeach;?>
						</select>  
						</div>
						</div>
						<?php else: ?>
							<input type="hidden" name="role" value="<?php echo $item->ROLE_ID;?>">
						<?php endif; ?>						
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
					<?php endforeach;?>
					</fieldset>	
					</form>				
			  </div>			  
			</div> 
		</div> 
	</div>				
</div>		