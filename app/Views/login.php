<div class="container">
	<div class="col-4 offset-4">
		<?php echo form_open(base_url() . 'login/check_login'); ?>

		<h2 class="text-center">Login</h2>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Username" required="required" name="username"
				value=<?php echo $test; ?>>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" placeholder="Password" required="required" name="password">
		</div>
		<div class="form-group">
			<?php echo $error; ?>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Log in</button>
		</div>
		<div class="clearfix">
			<label class="float-left form-check-label"><input type="checkbox" name="remember" value="check"> Remember
				me</label>
			<a href="<?php echo base_url()?>login/forget_password" class="float-right">Forgot Password?</a>
			<a href="<?php echo base_url()?>login/create_account" class="float-right">Create Account</a>

		</div>
		<?php echo form_close(); ?>
	</div>
</div>

