
			  <div class="panel-body">
				<table id="my_table" class="table table-striped">
					<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Package Name</th>
						<th>From</th>
						<th>For</th>
						<th>Time Added</th>
						<th>Status</th>
						<?php if(isset($this->session->userdata['is_logged_in'])): ?>
						<th class="text-center">Update Status</th>
						<!--<th class="text-center">Update</th>-->
						<th class="text-center">Trash</th>
						<?php endif; ?>
					</tr>
					</thead>
					<tbody>
					<?php $i=1; foreach ($record as $item):?>
					<tr>		
						<td class="text-center"><?php echo $i++; ?></td>
						<td><?php echo $item->PACKAGE_NAME;?></td>
						<td><?php echo $item->COMPANY_NAME;?></td>
						<td><?php echo $item->EMPLOYEE_NAME;?></td>
						<td><?php echo $item->CREATE_DATE;?></td>
						<td>
							<?php 
								if($item->PACKAGE_STATUS == '1'){echo 'Already Received';}else{echo 'Not Received';}
							?>
						</td>
						<?php if(isset($this->session->userdata['is_logged_in'])): ?>
						<td class="text-center">
							<?php if($item->PACKAGE_STATUS == '0'): ?>
								<a class="btn-sm btn-warning" role="button" title="update status" href="<?php echo base_url().'packages/update_status/'.$item->ID;?>">
									received
								</a>
							<?php else: ?>
								<a class="btn-sm btn-danger" role="button" title="update status" href="<?php echo base_url().'packages/update_status/'.$item->ID;?>">
									not-received
								</a>
							<?php endif; ?>
						</td>	
						<!--
						<td class="text-center">
							<a class="btn-sm btn-primary" role="button" title="update" href="<?php //echo base_url().'packages/update/'.$item->ID;?>">
								update
							</a>
						</td>
						-->
						<td class="text-center">
							<a class="btn-sm btn-danger" role="button" title="update" href="<?php echo base_url().'packages/delete/'.$item->ID;?>">
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