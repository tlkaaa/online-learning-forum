<div class="container">
    <div class="col-4 offset-4">
        <?php echo form_open(base_url() . 'login/forget_password/submit'); ?>

        <h2 class="text-center">Forget Password</h2>
        <p class="text-center">Enter your email and we will send you a link to reset your password</p>
        <div class="form-group">
            <p style="color:red;"><?php echo $error; ?></p>
            <input type="text" class="form-control" placeholder="Email" required="required" name="email">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>