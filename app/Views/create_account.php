<div class="container">
	<div class="col-4 offset-4">
		<?php validation_list_errors() ?>
		<?php echo form_open(base_url() . 'login/create_account'); ?>

		<h2 class="text-center">Create an Account</h2>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="New Email" required="required" name="new_email">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="New Username" required="required" name="new_username">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="New Phone Number" required="required" name="new_phone">
		</div>
		<div class="form-group">
			<input type="password" class="form-control" placeholder="New Password" required="required"
				name="new_password">
		</div>
		<div class="form-group">
			<input type="password" class="form-control" placeholder="Confirm Password" required="required"
				name="confirm_password">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Create</button>
		</div>

		<?php echo form_close(); ?>
	</div>
</div>