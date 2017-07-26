
			  <div class="panel-body">
				<table id="my_table" class="table table-striped">
					<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Guest Name</th>
						<th>Necesity</th>
						<th>Status</th>
						<th>Sign In Time</th>
						<?php if(isset($this->session->userdata['is_logged_in'])): ?>
						<th class="text-center">Sign Out</th>
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
						<td>
							<?php 
								if($item->GUEST_BOOK_STATUS == '1'){echo 'Sign In';}else{echo 'Sign Out';}
							?>
						</td>
						<td><?php echo $item->CREATE_DATE;?></td>						
						<?php if(isset($this->session->userdata['is_logged_in'])): ?>
					
						<td class="text-center">
							<?php if($item->GUEST_BOOK_STATUS == '1'): ?>
								<a class="btn-sm btn-warning" role="button" title="update status" href="<?php echo base_url().'guest_book/sign_out/'.$item->ID;?>">
									Sign Out
								</a>
							<?php else: ?>

							<?php endif; ?>
						</td>	
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