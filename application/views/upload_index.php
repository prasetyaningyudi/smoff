			  <div class="panel-body">
				<form method="post" enctype="multipart/form-data" class="form-horizontal">
				  <fieldset>
					<div class="form-group">
					<label for="name" class="col-sm-2">Upload File:<br></label>
					<div class="col-sm-10">
					<input type="hidden" name="MAX_FILE_SIZE" value="5000" />
					<input class="form-control input-lg" id="uploadfile" type="file" name="uploadfile" value="" placeholder="Upload File" required>
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