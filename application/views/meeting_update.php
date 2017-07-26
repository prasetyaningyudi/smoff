  <script>
  $( function() {
    $( "#date" ).datepicker();
  } );
  </script>
  
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
	$( "#pic" ).autocomplete({
		source: pic,
		minLength: 1,
		select: function( event , ui){
			if(ui.item.id != ''){
				$("#pic_id").val(ui.item.id);		
			}else{
				$("#pic_id").val('');				
			}	
		}		
	});
    $("#pic").keypress(function(){		
		$("#pic_id").val('');
    });		
} );	
</script>  
			  <div class="panel-body">
					<form action="" id="inputform" method="post" class="form-horizontal">
					  <fieldset>
						<?php foreach ($record2 as $item):?>
						<div class="form-group">	
						<label for="date" class="col-sm-2">Date:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="date" type="date" name="date" value="<?php echo date("m/d/Y", strtotime($item->MEETING_TIME));?>" placeholder="MM/DD/YYYY" required>
						</div>
						</div>		
						<div class="form-group">	
						<label for="time" class="col-sm-2">Time:<br></label>
						<div class="col-sm-10">		
						<select class="form-control" id="time" name="time" form="inputform">
							<?php for($i=0; $i<24;$i++):?>
								<?php if(date("G", strtotime($item->MEETING_TIME)) == $i){
										$selected = 'selected';
									}else{
										$selected = '';
									}
								?>							
							<option value="<?php if($i < 10){echo '0'.$i;}else{echo $i;}?>" <?php echo $selected;?>><?php if($i < 10){echo '0'.$i.':00';}else{echo $i.':00';}?>
							</option>	
							<?php endfor;?>
						</select>
						</div>
						</div>							
						<div class="form-group">	
						<label for="duration" class="col-sm-2">Duration (hours):<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="duration" type="number" name="duration" min="1" max="10" value="<?php echo $item->DURATION;?>" placeholder="Duration (hours)" required>
						</div>
						</div>						  
						<div class="form-group">	
						<label for="agenda" class="col-sm-2">Agenda:<br></label>
						<div class="col-sm-10">		
						<textarea class="form-control" id="agenda" name="agenda" rows="2" placeholder="Agenda" required><?php echo $item->AGENDA;?></textarea>
						</div>
						</div>	
						<div class="form-group">	
						<label for="room" class="col-sm-2">Room:<br></label>
						<div class="col-sm-10">	
						<select class="form-control" id="room" name="room" form="inputform">
							<?php foreach ($record as $val):?>
								<?php if($item->MEETING_ROOM_ID == $val->ID){
										$selected = 'selected';
									}else{
										$selected = '';
									}
								?>								
							<option value="<?php echo $val->ID;?>" <?php echo $selected;?>><?php echo $val->ROOM_NAME;?></option>	
							<?php endforeach;?>
						</select>  
						</div>
						</div>	
						<div class="form-group">	
						<label for="pic" class="col-sm-2">PIC:<br></label>
						<div class="col-sm-10">		
						<input class="form-control" id="pic" type="text" name="pic" value="<?php echo $item->EMPLOYEE_NAME;?>" placeholder="PIC" required>
						</div>
						</div>						
						<input type="hidden" id="pic_id" name="pic_id" value="<?php echo $item->PIC_ID;?>">
						<input type="hidden" name="user" value="<?php echo $this->session->userdata['ID']; ?>">
						<div class="form-group">
						<div class="col-sm-2">
						<input type="submit" name="submit" value="Submit" class="btn btn-default btn-lg">
						</div>					
						<div class="col-sm-8">
							<?php
								if(isset($warning) and $warning !== null){
									echo '<div class="alert alert-warning" role="alert">';
									echo $warning['text'];
									echo '</div>';
								}
							?>
						</div>	
						<div class="col-sm-2 text-right">
						<input type="reset" name="reset" value="Reset" class="btn btn-default btn-lg">
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