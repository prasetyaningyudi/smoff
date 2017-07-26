<script type='text/javascript'>
$(document).ready(function() {
    $('#my_table').DataTable({
		"order": [],
	});
} );
</script>
<script>
$( function() {
	var pic= [
		<?php foreach ($record1 as $item):?>
		{
			value: <?php echo '"'.$item->GUEST_NAME.'",'; ?>
			label: <?php echo '"'.$item->GUEST_NAME.' | '.$item->COMPANY_NAME.'",'; ?>
			id: <?php echo '"'.$item->ID.'",'; ?>
		},
		<?php endforeach;?>	
	];	
	$( "#name" ).autocomplete({
		source: pic,
		minLength: 1,
		select: function( event , ui){
			if(ui.item.id != ''){
				$("#id").val(ui.item.id);		
			}else{
				$("#id").val('');				
			}	
		}		
	});
    $("#name").keypress(function(){		
		$("#id").val('');
    });		
} );	
</script>  
			  <div class="panel-body">
					<form action="" id="inputform" method="post" class="form-horizontal">
					  <fieldset>
						<input type="hidden" id="id" name="id" value="">
						<div class="form-group">	
						<label for="name" class="col-sm-2">Guest Name:<br></label>
						<div class="col-sm-8">		
						<input class="form-control" id="name" type="text" name="name" value="" placeholder="Guest Name" required>
						</div>
						<div class="col-sm-2">
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
			  
				<table id="my_table" class="table table-striped">
					<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Guest Name</th>
						<th>Company</th>
						<th>Necesity</th>
						<th>Status</th>
						<th>Sign In Time</th>
						<th class="text-center">Sign Out</th>
					</tr>
					</thead>
					<tbody>
					<?php $i=1; foreach ($record as $item):?>
					<tr>		
						<td class="text-center"><?php echo $i++; ?></td>
						<td><?php echo $item->GUEST_NAME;?></td>
						<td><?php echo $item->COMPANY_NAME;?></td>
						<td><?php echo $item->REF_NAME;?></td>
						<td>
							<?php 
								if($item->GUEST_BOOK_STATUS == '1'){echo 'Sign In';}else{echo 'Sign Out';}
							?>
						</td>
						<td><?php echo $item->CREATE_DATE;?></td>						
					
						<td class="text-center">
							<?php if($item->GUEST_BOOK_STATUS == '1'): ?>
								<a class="btn-sm btn-warning" role="button" title="update status" href="<?php echo base_url().'guest_book/sign_out/'.$item->ID;?>">
									Sign Out
								</a>
							<?php else: ?>

							<?php endif; ?>
						</td>	
						
					</tr>
					<?php endforeach;?>	
					</tbody>
				</table>			
			  </div>			  
			</div> 
		</div> 
	</div>				
</div>		