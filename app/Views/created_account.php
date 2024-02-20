<div class="container">
	<div class="col-4 offset-4">
		<?php echo form_open(base_url() . 'login/create_account'); ?>

		<h2 class="text-center">Account Created!</h2>
       
        <div class="form-group">
			<?php echo "User " . $created_user . " Created!"; ?>
			<p>An Email have been sent to your email address for verification</p>
		</div>
		<div class="form-group">
        <a href="<?php echo base_url(); ?>login" class="float-right">Go to Login In</a>
		</div>

		<?php echo form_close(); ?>
	</div>
</div>