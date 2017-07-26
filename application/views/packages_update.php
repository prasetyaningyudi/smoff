				<script>
				$( function() {
					var availableTags = [
						<?php foreach ($record1 as $item):?>
						<?php echo '"'.$item->EMPLOYEE_NAME.'",'; ?>
						<?php endforeach;?>
					];
					$( "#for" ).autocomplete({
					  source: availableTags,
					  minLength: 2
					});
				} );
				</script>
			  <div class="panel-body">
					<form action="" id="inputform" method="post" class="form-horizontal">
					  <fieldset>
					  <?php foreach ($record as $item):?>
						<div class="form-group">	
						<label for="from" class="col-sm-2">Package From:<br></label>
						<div class="col-sm-10">	
						<select class="form-control" id="from" name="from" form="inputform">
							<?php foreach ($record3 as $item1):?>
								<?php if($item1->ID == $item->COMPANY_ID){
										$selected = 'selected';
									}else{
										$selected = '';
									}
								?>							
							<option value="<?php echo $item1->ID.$item1->COMPANY_NAME;?>" <?php echo $selected;?>><?php echo $item1->COMPANY_NAME;?></option>	
							<?php endforeach;?>
						</select>  
						</div>
						</div>
						<div class="form-group">	
						<label for="for" class="col-sm-2">Package For:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="for" type="text" name="for" value="<?php echo $item->EMPLOYEE_NAME;?>" placeholder="Package For" required>
						</div>
						</div>						
						<?php
							if(isset($this->session->userdata['is_logged_in'])) {
								$user_id = $this->session->userdata['ID'];
							}else{
								$user_id = 0;
							}
						?>
						<input type="hidden" name="user" value="<?php echo $user_id; ?>">						
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