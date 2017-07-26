<script>
$( function() {
	var pic= [
		<?php foreach ($record1 as $item):?>
		{
			value: <?php echo '"'.$item->EMPLOYEE_NAME.'",'; ?>
			id: <?php echo '"'.$item->ID.'",'; ?>
		},
		<?php endforeach;?>	
	];	
	$( "#employee" ).autocomplete({
		source: pic,
		minLength: 1,
		select: function( event , ui){
			if(ui.item.id != ''){
				$("#pid").val(ui.item.id);		
			}else{
				$("#pid").val('');				
			}	
		}		
	});
    $("#employee").keypress(function(){		
		$("#pid").val('');
    });		
} );	
</script>  

<script>
$( function() {
	var pic= [
		<?php foreach ($record2 as $item):?>
		{
			value: <?php echo '"'.$item->GUEST_NAME.'",'; ?>
			label: <?php echo '"'.$item->GUEST_NAME.' | '.$item->COMPANY_NAME.'",'; ?>
			id: <?php echo '"'.$item->ID.'",'; ?>
		},
		<?php endforeach;?>	
	];	
	$( "#guest" ).autocomplete({
		source: pic,
		minLength: 1,
		select: function( event , ui){
			if(ui.item.id != ''){
				$("#pid").val(ui.item.id);		
			}else{
				$("#pid").val('');				
			}	
		}		
	});
    $("#guest").keypress(function(){		
		$("#pid").val('');
    });		
} );	
</script> 

			  <div class="panel-body">
					<form action="" id="inputform" method="post" class="form-horizontal">
					  <fieldset>
						<div class="form-group">	
						<label for="employee" class="col-sm-2">Add Employee:<br></label>
						<div class="col-sm-8">		
						<input class="form-control" id="employee" type="text" name="employee" value="" placeholder="Employee Name" required>
						</div>
						<div class="col-sm-2">
						<input type="hidden" id="pid" name="pid" value="">
						<input type="hidden" id="mid" name="mid" value="<?php echo $meeting_id; ?>">						
						<input type="hidden" id="user" name="user" value="<?php echo $this->session->userdata['ID']; ?>">						
						<input type="submit" name="submit" value="Submit" class="btn btn-default btn-lg">
						</div>							
						</div>
						<div class="form-group">
						<div class="col-sm-2">
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
					<form action="" id="inputform" method="post" class="form-horizontal">
					  <fieldset>
						<div class="form-group">	
						<label for="guest" class="col-sm-2">Add Guest:<br></label>
						<div class="col-sm-8">		
						<input class="form-control" id="guest" type="text" name="guest" value="" placeholder="Guest Name" required>
						</div>
						<div class="col-sm-2">
						<input type="hidden" id="pid" name="pid" value="">
						<input type="hidden" id="mid" name="mid" value="<?php echo $meeting_id; ?>">
						<input type="hidden" id="user" name="user" value="<?php echo $this->session->userdata['ID']; ?>">
						<input type="submit" name="submit_guest" value="Submit" class="btn btn-default btn-lg">
						</div>							
						</div>
						<div class="form-group">
						<div class="col-sm-2">
						</div>					
						<div class="col-sm-10">
							<?php
								if(isset($warning1) and $warning1 !== null){
									echo '<div class="alert alert-warning" role="alert">';
									echo $warning1['text1'];
									echo '</div>';
								}
							?>
						</div>							
						</div>								
					</fieldset>	
					</form>							  
			  
				<table id="my_table" class="table table-striped">
					<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Name</th>
						<th>Type</th>
						<?php if(isset($this->session->userdata['is_logged_in'])): ?>
						<th class="text-center">Trash</th>
						<?php endif; ?>
					</tr>
					</thead>
					<tbody>
					<?php $i=1; foreach ($record as $item):?>
					<tr>		
						<td class="text-center"><?php echo $i++; ?></td>
						<td>
							<?php if($item->GUEST_NAME == ''){
								echo $item->EMPLOYEE_NAME;
							}else{
								echo $item->GUEST_NAME;
							}
							?>						
						</td>
						
						<td>
							<?php if($item->GUEST_ID == ''){
								echo 'Employee';
							}else{
								echo 'Guest';
							}
							?>
						</td>
						<?php if(isset($this->session->userdata['is_logged_in'])): ?>					
						<td class="text-center">
							<a class="btn-sm btn-danger" role="button" title="update" href="<?php echo base_url().'meeting/participant_delete/'.$item->MEETING_ID.'/'.$item->ID;?>">
								trash
							</a>
						</td>
						<?php endif; ?>
						
					</tr>
					<?php endforeach;?>	
					</tbody>
				</table>			
			  </div>			  
			</div> 
		</div> 
	</div>				
</div>		