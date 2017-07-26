	<div id="content">
		<div class="my-breadcurm">
			<div class="col-xs-6 no-margin">
				<?php 
					if($title !== 'Home'){
						echo 'Home / ';
					}
					if(isset($title)){
						echo $title.' ';
					}
					if(isset($subtitle)){
						echo '/ '.$subtitle.' ';
					}				
				?>
			</div>
			<div class="col-xs-6 text-right no-margin">
				<?php if(isset($this->session->userdata['is_logged_in'])): ?>
					Login as : <?php echo $this->session->userdata('ROLE_NAME'); ?> | <a href="<?php echo base_url().'authentication/logout'; ?>" title="">Logout</a>
				<?php else: ?>
					<?php if($subtitle != 'Login'): ?>
						<b><a href="<?php echo base_url().'authentication/login'; ?>" title="">Login</a></b>
					<?php endif; ?>	
				<?php endif; ?>	
			</div>
		</div>