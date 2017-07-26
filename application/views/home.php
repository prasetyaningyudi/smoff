			  <div class="panel-body">
				  <?php if(isset($this->session->userdata['is_logged_in'])): ?>
					<h2>Hello, <?php echo $this->session->userdata['USER_ALIAS']; ?></h2>
						<?php if($valid === TRUE): ?>
							<h4>How are you today? Feels good right.<br>Lets start your work with access menus on the left sidebar. </h4>
						<?php else: ?>
							<?php if($this->session->userdata['ROLE_ID'] == '4'): ?>	
								<h4>Ops, It looks like it's first time you login, Please input some initial data first</h4>
								<div class="row">
									<div class="col-sm-3">
										<a class="btn btn-primary btn-lg btn-square" href="<?php echo base_url()."home/init_data"; ?>" role="button">Initial Data</a>
									</div>
									<div class="col-sm-3">
										
									</div>
									<div class="col-sm-3">
										
									</div>							
								</div>									
							<?php else: ?>
								<h4>How are you today? Feels good right.<br>Lets start your work with access menus on the left sidebar. </h4>
								<div class="row">
									<div class="col-sm-3">
										<a class="btn btn-warning btn-lg btn-square" href="<?php echo base_url()."user"; ?>" role="button">Manage Users</a>	
									</div>
									<div class="col-sm-3">
										
									</div>
									<div class="col-sm-3">
										
									</div>							
								</div>									
							<?php endif; ?>										
						<?php endif; ?>										
				  <?php else: ?>
				  <!--<div class="collapse navbar-collapse">-->
				  <div>
					<h2>Hello, Guest</h2>
					<h4>How are you today? Feels good right.<br>This Web App is about Visitor Management. If you want to try our services. Just click the button below to start.</h4>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<a class="btn btn-info btn-lg btn-square" href="<?php echo base_url().'guest/signup'; ?>" role="button">Sign Up</a>	
						</div>
						<div class="col-sm-6">
							<a class="btn btn-info btn-lg btn-square" href="<?php echo base_url().'authentication/login'; ?>" role="button">Log In</a>	
						</div>					
					</div>					
				  <?php endif; ?>
			  </div>			  
			</div> 
		</div> 
	</div>				
</div>		