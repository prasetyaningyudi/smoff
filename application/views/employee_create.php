			  <div class="panel-body">
					<form action="" id="inputform" method="post" class="form-horizontal">
					  <fieldset>
						<div class="form-group">	
						<label for="name" class="col-sm-2">Employee Name:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="name" type="text" name="name" value="" placeholder="Employee Name" required>
						</div>
						</div>
						<div class="form-group">	
						<label for="email" class="col-sm-2">Employee Email:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="email" type="email" name="email" value="" placeholder="Employee Email" required>
						</div>
						</div>
						<div class="form-group">	
						<label for="phone" class="col-sm-2">Employee Phone:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="phone" type="text" name="phone" value="" placeholder="Employee Phone">
						</div>
						</div>						
						<input type="hidden" name="user" value="<?php echo $this->session->userdata['ID']; ?>">						
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