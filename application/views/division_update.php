			  <div class="panel-body">
					<form action="" id="inputform" method="post" class="form-horizontal">
					  <fieldset>
						<?php foreach ($record as $item):?>
						<div class="form-group">	
						<label for="name" class="col-sm-2">Division Name:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="name" type="text" name="name" value="<?php echo $item->DIVISION_NAME;?>" placeholder="Division Name" required>
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
						<?php endforeach;?>						
					</fieldset>	
					</form>				
			  </div>			  
			</div> 
		</div> 
	</div>				
</div>		