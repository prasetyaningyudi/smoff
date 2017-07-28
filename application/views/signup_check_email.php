			  <?php foreach($record as $item): ?>
				<div class="panel-body">
					<h2>Thank for your sign up <span class="text-danger bold"><?php echo $item->USER_ALIAS; ?></span></H2>
					<h4>Please check your email <span class="text-primary"><?php echo $item->USERNAME; ?></span> to complete your account registration.</h4>
			  </div>
				<?php endforeach; ?>
			</div> 
		</div> 
	</div>				
</div>		