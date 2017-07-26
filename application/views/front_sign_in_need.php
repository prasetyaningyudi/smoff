<script>
$( function() {
	$(".choose-1").hide();
	$(".choose-2").hide();
	$(".choose-3").hide();
	$('#need').change(function() {
		if ($(this).val() === 'Meet Someone') {
			$(".choose-1").show();
			$(".choose-2").hide();	
			$(".choose-3").hide();	
			$('#who').prop('required', true);				
			$('#oneed').prop('required', false);				
		}else if ($(this).val() === 'Meeting') {
			$(".choose-1").hide();
			$(".choose-2").show();
			$(".choose-3").hide();
			$('#who').prop('required', false);
			$('#oneed').prop('required', false);			
		}else{
			$(".choose-1").hide();
			$(".choose-2").hide();	
			$(".choose-3").show();
			$('#who').prop('required', false);	
			$('#oneed').prop('required', true);
		}
	});
});
</script>
<script>
$(function() {
	var availableTags = [
		<?php foreach ($record2 as $item):?>
		{
			value: <?php echo '"'.$item->EMPLOYEE_NAME.'",'; ?>
			label: <?php echo '"'.$item->EMPLOYEE_NAME.'",'; ?>
		},
		<?php endforeach;?>
	];
	
$( '#who' ).autocomplete({
		source: availableTags,
		minLength: 1,
		select: function( event , ui){

		},	
   renderMenu: function( ul, items ) {
      $( ul ).addClass( 'w3-ul w3-white' );
   },
   renderItem: function( ul, item ) {
      return $( '<li>' )
         .append( '<div class="w3-large">'+item.label+'</div>' )
         .appendTo( ul ).addClass('w3-padding-16 w3-hover-light-gray myautocomplete');
   },
});
});
</script>

<div class="my-content w3-display-container">
	<form class="w3-container w3-row-padding w3-height-padding" method="post">
		<input type="hidden" name="id" value="<?php echo $user_id; ?>">
		<div class="w3-center w3-col m12"><h2>Necessity?</h2></div>
		<div class="w3-col m6">
			<input class="w3-input w3-round w3-border w3-white-red w3-small" id="name" type="text" name="name" placeholder="Name" value="<?php echo $name; ?>" required readonly>
		</div>
		<div class="w3-col m6">
			<input class="w3-input w3-round w3-border w3-white-red w3-small" id="company" type="text" name="company" placeholder="Company" value="<?php echo $company; ?>" required readonly>
		</div>
		<div class="w3-col m6">
			<input class="w3-input w3-round w3-border w3-white-red w3-small" id="email" type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required readonly>
		</div>
		<div class="w3-col m6">
			<input class="w3-input w3-round w3-border w3-white-red w3-small" id="phone" type="number" name="phone" placeholder="Phone" value="<?php echo $phone; ?>" readonly>
		</div>	
		<div class="w3-col m12">
			<select class="w3-select w3-round w3-border w3-xlarge w3-light-gray" name="need" id="need">
				<option value="" disabled selected>Necessity</option>
				<?php foreach ($record1 as $item):?>
				<option value="<?php echo $item->REF_NAME;?>"><?php echo $item->REF_NAME;?></option>
				<?php endforeach;?>
			</select>
		</div>
		<div class="w3-col m12">
			<input class="choose-1 w3-input w3-round w3-border w3-light-gray w3-xlarge" type="text" name="who" id="who" placeholder="Meet Who" required>
		</div>
		<div class="w3-col m12">
			<select class="choose-2 w3-select w3-round w3-border w3-xlarge w3-light-gray" name="meeting" id="meeting">
				<?php if($record3 == null): ?>
					<option value="">No Meeting Today</option>
				<?php else: ?>
					<?php foreach ($record3 as $item):?>
					<option value="<?php echo $item->ID;?>"><?php echo $item->ROOM_NAME.' | '.$item->AGENDA;?></option>
					<?php endforeach;?>
				<?php endif; ?>
			</select>
		</div>
		<div class="w3-col m12">
			<input class="choose-3 w3-input w3-round w3-border w3-light-gray w3-xlarge" type="text" name="oneed" id="oneed" placeholder="What needs" required>
		</div>		
		<div class="w3-col m12">
			<input type="submit" class="w3-btn w3-block w3-round w3-blue-grey w3-xxlarge" name="submit" value="Sign In">
		</div>	
		<?php
			if(isset($warning) and $warning !== null){
				echo '<div class="w3-col m12 w3-round w3-red">';
				echo '<h3>'.$warning['text'].'</h3>';
				echo '</div>';
			}
		?>			
	</form>
	
</div>