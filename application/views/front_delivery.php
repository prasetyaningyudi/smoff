<script>
$(function() {
	var availableTags = [
		<?php foreach ($record1 as $item):?>
		{
			value: <?php echo '"'.$item->COMPANY_NAME.'",'; ?>
			label: <?php echo '"'.$item->COMPANY_NAME.'",'; ?>
		},
		<?php endforeach;?>
	];
	
$( '#company' ).autocomplete({
		source: availableTags,
		minLength: 2,
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
	
$( '#for' ).autocomplete({
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
		<div class="w3-center w3-col m12"><h2>Delivery</h2></div>
		<div class="w3-col m12">
			<input class="w3-input w3-round w3-border w3-light-gray w3-xlarge" id="company" type="text" name="company" placeholder="From Expedition" value="<?php if(isset($company)){echo $company;} ?>" required>
		</div>
		<div class="w3-col m12">
			<input class="w3-input w3-round w3-border w3-light-gray w3-xlarge" type="text" name="for" id="for" placeholder="Delivery for" required>
		</div>		
		<div class="w3-col m12">
			<input type="submit" class="w3-btn w3-block w3-round w3-blue-grey w3-xxlarge" name="submit" value="Submit">
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