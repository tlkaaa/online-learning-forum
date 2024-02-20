<div class="container">
    <div class="rol">
        <div class="col-6 offset-3">
            <?php validation_list_errors() ?>
            <?php echo form_open(base_url() . 'profile/check_update'); ?>
            <p class="text-center">Update My details</p>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="New Email" required="required" name="email_update">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="New Phone Number" required="required"
                    name="phone_update">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>

</div>