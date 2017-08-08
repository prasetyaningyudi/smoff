			  <div class="panel-body">
					<form action="" id="inputform" method="post" enctype="multipart/form-data" class="form-horizontal">
					  <fieldset>
					  <?php foreach ($record as $item):?>
						<div class="form-group">	
						<label for="app" class="col-sm-2">Application Name:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="app" type="text" name="app" value="<?php echo $item->APP_NAME;?>" placeholder="Application Name" required>
						</div>
						</div>					  
						<div class="form-group">	
						<label for="office" class="col-sm-2">Office Name:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="office" type="text" name="office" value="<?php echo $item->OFFICE_NAME;?>" placeholder="Office Name" required>
						</div>
						</div>
						<?php if($item->FILE_ID != ''): ?>
						<div class="form-group">	
						<label for="flogo" class="col-sm-2">Front Logo:<br></label>
						<div class="col-sm-10">		
						<a class="btn btn-block btn-info btn-md" target="_blank" href="<?php echo base_url().'upload/view/'.$item->FILE_ID; ?>">front_logo</a>
						</div>
						</div>
						<?php endif; ?>
						<div class="form-group">	
						<label for="flogo" class="col-sm-2">Update Front Logo:<br></label>
						<div class="col-sm-6">		
						<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
						<input class="form-control" id="flogo" type="file" name="flogo" value="" placeholder="Upload File" accept=".jpg, .jpeg, .png">
						</div>
						<label for="flogo" class="col-sm-4">Image format JPG, JPEG or PNG (Max 2MB)<br></label>
						</div>
						<div class="form-group">	
						<label for="fpage" class="col-sm-2">Front Page:<br></label>
						<div class="col-sm-6">		
						<input class="form-control" id="fpage" type="text" name="fpage" value="<?php echo $item->FRONT_PAGE;?>" placeholder="Input front page address with nospace, max 10 character" maxlength="10" readonly required>
						</div>
						<div class="col-sm-4"><a target="_blank" class="btn btn-block btn-info btn-md" href="<?php echo base_url().'front/start/'.$item->FRONT_PAGE; ?>">Visiting <?php echo $item->FRONT_PAGE;?></a>
						</div>						
						</div>						  
						<div class="form-group">	
						<label for="icon" class="col-sm-2">Icon:<br></label>	
						<div class="col-sm-10">
						<select class="form-control" id="icon" name="icon" form="inputform">
							<option value="book" <?php if($item->ICON == 'Book'){echo 'selected';} ?>>Book</option>	
							<option value="envelope" <?php if($item->ICON == 'envelope'){echo 'selected';} ?>>Envelope</option>	
							<option value="home" <?php if($item->ICON == 'home'){echo 'selected';} ?>>Home</option>	
							<option value="file" <?php if($item->ICON == 'file'){echo 'selected';} ?>>File</option>	
						</select>
						</div>					  
						</div>	
						<div class="form-group">	
						<label for="theme" class="col-sm-2">Theme:<br></label>	
						<div class="col-sm-10">
						<select class="form-control" id="theme" name="theme" form="inputform">
							<option value="dark" <?php if($item->THEME == 'dark'){echo 'selected';} ?>>Dark</option>	
							<option value="light" <?php if($item->THEME == 'light'){echo 'selected';} ?>>Light</option>	
							<option value="blue" <?php if($item->THEME == 'blue'){echo 'selected';} ?>>Blue</option>	
						</select>
						</div>					  
						</div>							
						<input type="hidden" name="id" value="<?php echo $item->ID; ?>">
						<input type="hidden" name="fid" value="<?php echo $item->FILE_ID; ?>">
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