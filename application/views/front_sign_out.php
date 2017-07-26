<script>
$(function() {
	var availableTags = [
		<?php foreach ($record1 as $item):?>
		{
			value: <?php echo '"'.$item->GUEST_NAME.'",'; ?>
			label: <?php echo '"'.$item->GUEST_NAME.'",'; ?>
			company: <?php echo '"'.$item->COMPANY_NAME.'",'; ?>
		},
		<?php endforeach;?>
	];
	
$( '#name' ).autocomplete({
		source: availableTags,
		minLength: 1,
		select: function( event , ui){

		},	
   renderMenu: function( ul, items ) {
      $( ul ).addClass( 'w3-ul w3-white' );
   },
   renderItem: function( ul, item ) {
      return $( '<li>' )
         .append( '<div class="w3-large">'+item.label+'</div><div>'+item.company+'</div>' )
         .appendTo( ul ).addClass('w3-padding-16 w3-hover-light-gray myautocomplete');
   },
});
});
</script>
<script>
$( function() {
	$(".choose-1").hide();
	<?php if(isset($record2)): ?>
	<?php if($record2 != null): ?>
	$(".choose-1").show();
	<?php endif; ?>
	<?php endif; ?>
});
</script>

<div class="my-content w3-display-container">
	<form class="w3-container w3-row-padding w3-height-padding" method="post">
		<input type="hidden" name="id" value="<?php echo $user_id; ?>">
		<div class="w3-center w3-col m12"><h2>Sign Out</h2></div>
		<div class="w3-col m9">
			<input class="w3-input w3-round w3-border w3-light-gray w3-xlarge" type="text" name="name" id="name" placeholder="Guest Name" required>
		</div>		
		<div class="w3-col m3">
			<input type="submit" class="w3-btn w3-block w3-round w3-blue-grey w3-xlarge" name="submit" value="Submit">
		</div>
		<?php
			if(isset($warning) and $warning !== null){
				echo '<div class="w3-col m12 w3-round w3-red">';
				echo '<h3>'.$warning['text'].'</h3>';
				echo '</div>';
			}
		?>				
	</form>
	<br>
	<div class="choose-1 w3-container w3-row-padding w3-height-padding" style="overflow-x:auto">
		<table class="w3-table-all">
			<thead>
			<tr class="w3-blue-grey">
				<th>Name</th>
				<th>Company</th>
				<th>Signin Time</th>
				<th class="text-center">Sign Out</th>
			</tr>
			</thead>
			<?php if(isset($record2)): ?>
			<?php $i=1; foreach ($record2 as $item):?>
			<tr>
				<td><?php echo $item->GUEST_NAME;?></td>
				<td><?php echo $item->COMPANY_NAME;?></td>
						<td><?php echo $item->CREATE_DATE;?></td>						
					
						<td class="text-center">
							<?php if($item->GUEST_BOOK_STATUS == '1'): ?>
								<a class="w3-btn w3-round w3-tiny-red w3-large" title="update status" href="<?php echo base_url().'front/sign_out_conf/'.$item->ID.'/'.$front_page;?>">
									Sign Out
								</a>
							<?php endif; ?>				
			</tr>
			<?php endforeach;?>
			<?php endif; ?>
		</table>
	</div>
</div>