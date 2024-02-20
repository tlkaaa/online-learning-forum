<div class="container">
	<div class="col-4 offset-4">
		<?php validation_list_errors() ?>
		<?php echo form_open(base_url() . 'login/reset/' . $token) ; ?>

		<h2 class="text-center">Enter a New Password</h2>
		<div class="form-group">
			<input type="password" class="form-control" placeholder="New Password" required="required"
				name="password">
		</div>
		<div class="form-group">
			<input type="password" class="form-control" placeholder="Confirm Password" required="required"
				name="confirm_password">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Submit</button>
		</div>

		<?php echo form_close(); ?>
	</div>
</div>