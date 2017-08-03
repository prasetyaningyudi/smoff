
			  <div class="panel-body">
				<table id="my_table" class="table table-striped">
					<thead>
					<tr>
						<th class="text-center">Id</th>
						<th>Username</th>
						<th>Alias</th>
						<th>Role</th>
						<th>Status</th>
						<th class="text-center">Update Status</th>
						<th class="text-center">Update</th>
					</tr>
					</thead>
					<tbody>
					<?php $i=1; foreach ($record as $item):?>
					<tr>		
						
						<td  class="text-center"><?php echo $item->ID;?></td>
						<td><?php echo $item->USERNAME;?></td>
						<td><?php echo $item->USER_ALIAS;?></td>
						<td><?php echo $item->ROLE_NAME;?></td>
						<td>
							<?php 
								if($item->USER_STATUS == '1'){echo 'Active';}else{echo 'Inactive';}
							?>
						</td>
						<td class="text-center">
							<?php if($item->ROLE_ID != '1'): ?>
							<?php if($item->USER_STATUS == '0'): ?>
								<a class="btn-sm btn-warning" role="button" title="update status" href="<?php echo base_url().'user/update_status/'.$item->ID;?>">
									enable
								</a>
							<?php else: ?>
								<a class="btn-sm btn-danger" role="button" title="update status" href="<?php echo base_url().'user/update_status/'.$item->ID;?>">
									disable
								</a>
							<?php endif; ?>
							<?php endif; ?>
						</td>						
						<td class="text-center">
							<a class="btn-sm btn-primary" role="button" title="update" href="<?php echo base_url().'user/update/'.$item->ID;?>">
								update
							</a>
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