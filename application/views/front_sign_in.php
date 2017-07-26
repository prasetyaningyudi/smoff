<script>
$(function() {
	var availableTags = [
		<?php foreach ($record as $item):?>
		{
			value: <?php echo '"'.$item->GUEST_NAME.'",'; ?>
			label: <?php echo '"'.$item->GUEST_NAME.'",'; ?>
			phone: <?php echo '"'.$item->GUEST_PHONE.'",'; ?>
			email: <?php echo '"'.$item->GUEST_EMAIL.'",'; ?>
			cname: <?php echo '"'.$item->COMPANY_NAME.'",'; ?>
			gid: <?php echo '"'.$item->ID.'",'; ?>
			cid: <?php echo '"'.$item->COMPANY_ID.'",'; ?>
		},
		<?php endforeach;?>
	];
	
$( '#name' ).autocomplete({
		source: availableTags,
		minLength: 2,
		select: function( event , ui){
			if(ui.item.email != ''){
				$("#email").val(ui.item.email);		
			}
			if(ui.item.phone != ''){
				$("#phone").val(ui.item.phone);	
				$('#phone').prop('readonly', true);			
			}
			if(ui.item.cname != ''){
				$("#company").val(ui.item.cname);		
			}	
		},	
   renderMenu: function( ul, items ) {
      $( ul ).addClass( 'w3-ul w3-white' );
   },
   renderItem: function( ul, item ) {
      return $( '<li>' )
         .append( '<div class="w3-large">'+item.label+'</div><div>'+item.cname+'</div>' )
         .appendTo( ul ).addClass('w3-padding-16 w3-hover-light-gray myautocomplete');
   },
});
});
</script>

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

<div class="my-content w3-display-container">
	<form class="w3-container w3-row-padding w3-height-padding" method="post" action="<?php echo base_url().'front/sign_in_need/'.$front_page;?>">
		<input type="hidden" name="id" value="<?php echo $user_id; ?>">
		<div class="w3-center w3-col m12"><h2>Who are You?</h2></div>
		<div class="w3-col m6">
			<input class="w3-input w3-round w3-border w3-light-gray w3-xlarge" id="name" type="text" name="name" placeholder="Name" required>
		</div>
		<div class="w3-col m6">
			<input class="w3-input w3-round w3-border w3-light-gray w3-xlarge" id="company" type="text" name="company" placeholder="Company" required>
		</div>
		<div class="w3-col m6">
			<input class="w3-input w3-round w3-border w3-light-gray w3-xlarge" id="email" type="email" name="email" placeholder="Email" required>
		</div>
		<div class="w3-col m6">
			<input class="w3-input w3-round w3-border w3-light-gray w3-xlarge" id="phone" type="number" name="phone" placeholder="Phone">
		</div>		
		<div class="w3-col m12">
			<input type="submit" class="w3-btn w3-block w3-round w3-blue-grey w3-xxlarge w3-section" name="next" value="Next">
		</div>
	</form>
</div>