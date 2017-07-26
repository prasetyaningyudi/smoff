<!-- content goes here -->
<div class="my-content">
	<div class="row">
		<div class="col-lg-12">			
			<div class="panel panel-brown">
			  <div class="panel-heading">
				<div class="panel-title">
				<?php 
					if(isset($subtitle)){
						echo $subtitle.' ';
					}
					if(isset($title)){
						echo $title.' ';
					}					
				?>				
				</div>
			  </div>
<?php if(isset($data_table) and $data_table == 'yes'): ?>	
<script type='text/javascript'>
$(document).ready(function() {
	$('#my_table').DataTable({
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
	});
} );
</script>
<?php endif; ?>	
