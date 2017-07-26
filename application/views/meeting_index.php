
			  <div class="panel-body">
				<table id="my_table" class="table table-striped">
					<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Date Time</th>
						<th>Duration</th>
						<th>Agenda</th>
						<th>Room</th>
						<th>PIC</th>
						<?php if(isset($this->session->userdata['is_logged_in'])): ?>
						<th class="text-center">Participant</th>
						<th class="text-center">Update</th>
						<th class="text-center">Trash</th>
						<?php endif; ?>
					</tr>
					</thead>
					<tbody>
					<?php $i=1; foreach ($record as $item):?>
					<tr>		
						<td class="text-center"><?php echo $i++; ?></td>
						<td><?php echo $item->MEETING_TIME;?></td>
						<td><?php echo $item->DURATION;?></td>
						<td><?php echo $item->AGENDA;?></td>
						<td><?php echo $item->ROOM_NAME;?></td>
						<td><?php echo $item->EMPLOYEE_NAME;?></td>
						<?php if(isset($this->session->userdata['is_logged_in'])): ?>	
						<td class="text-center">
							<a class="btn-sm btn-warning" role="button" title="participant" href="<?php echo base_url().'meeting/participant/'.$item->ID;?>">
								participant
							</a>
						</td>						
						<td class="text-center">
							<a class="btn-sm btn-primary" role="button" title="update" href="<?php echo base_url().'meeting/update/'.$item->ID;?>">
								update
							</a>
						</td>
						<td class="text-center">
							<a class="btn-sm btn-danger" role="button" title="update" href="<?php echo base_url().'meeting/delete/'.$item->ID;?>">
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