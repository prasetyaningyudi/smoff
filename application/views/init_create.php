			  <div class="panel-body">
					<form action="" id="inputform" method="post" class="form-horizontal">
					  <fieldset>
						<div class="form-group">	
						<label for="app" class="col-sm-2">Application Name:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="app" type="text" name="app" value="" placeholder="Application Name" required>
						</div>
						</div>					  
						<div class="form-group">	
						<label for="office" class="col-sm-2">Office Name:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="office" type="text" name="office" value="" placeholder="Office Name" required>
						</div>
						</div>	
						<div class="form-group">	
						<label for="ficon" class="col-sm-2">Front Icon:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="ficon" type="text" name="ficon" value="" placeholder="Check available list at http://fontawesome.io/icons/ example (quora, book, bank, etc)" required>
						</div>
						</div>
						<div class="form-group">	
						<label for="fpage" class="col-sm-2">Front Page:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="fpage" type="text" name="fpage" value="" placeholder="Input front page address with nospace, max 10 character" maxlength="10" required>
						</div>						
						</div>						  					  
						<div class="form-group">	
						<label for="icon" class="col-sm-2">Admin Icon:<br></label>	
						<div class="col-sm-10">
						<select class="form-control" id="icon" name="icon" form="inputform">
							<option value="book">Book</option>	
							<option value="envelope">Envelope</option>	
							<option value="home">Home</option>	
							<option value="file">File</option>	
						</select>
						</div>					  
						</div>	
						<div class="form-group">	
						<label for="theme" class="col-sm-2">Admin Theme:<br></label>	
						<div class="col-sm-10">
						<select class="form-control" id="theme" name="theme" form="inputform">
							<option value="dark">Dark</option>	
							<option value="light">Light</option>	
							<option value="blue">Blue</option>	
						</select>
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