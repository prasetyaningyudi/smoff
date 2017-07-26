
			  <div class="panel-body">
				<table id="my_table" class="table table-striped">
					<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Guest Name</th>
						<th>Necesity</th>						
						<th>Desc</th>						
						<th>Status</th>
						<th>Sign In Time</th>
						<?php if(isset($this->session->userdata['is_logged_in'])): ?>
						<th class="text-center">Trash</th>
						<?php endif; ?>
					</tr>
					</thead>
					<tbody>
					<?php $i=1; foreach ($record as $item):?>
					<tr>		
						<td class="text-center"><?php echo $i++; ?></td>
						<td><?php echo $item->GUEST_NAME;?></td>
						<td><?php echo $item->REF_NAME;?></td>
						
						<?php if($item->REF_NAME == 'Meet Someone'): ?>
						<td><?php echo $item->EMPLOYEE_NAME;?></td>
						<?php elseif($item->REF_NAME == 'Meeting'): ?>
						<td><?php echo $item->AGENDA;?></td>
						<?php elseif($item->REF_NAME == 'Other needs'): ?>
						<td><?php echo $item->OTHER_NEEDS;?></td>
						<?php endif; ?>						
						
						<td>
							<?php 
								if($item->GUEST_BOOK_STATUS == '1'){echo 'Sign In';}else{echo 'Sign Out';}
							?>
						</td>
						<td><?php echo $item->CREATE_DATE;?></td>						
						<?php if(isset($this->session->userdata['is_logged_in'])): ?>
						<td class="text-center">
							<a class="btn-sm btn-danger" role="button" title="update" href="<?php echo base_url().'guest_book/delete/'.$item->ID;?>">
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