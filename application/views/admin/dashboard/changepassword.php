<link href="<?php echo HTTP_CSS_PATH; ?>starter-template.css" rel="stylesheet">
<script src="<?php echo HTTP_JS_PATH; ?>dist/jquery.validate.js"></script>
<style>
.top_success
{
	    color: #40B354;
    font-weight: bold;
    font-size: initial;
}
.top_error
{
	    color: #f00;
    font-weight: bold;
    font-size: initial;
}
.tcenter
{
	text-align:center;
	padding-bottom: 20px;
}
</style>
<section class="panel">
    <header class="panel-heading">
        Change Password
    </header>
    <div class="panel-body">
        <form id="change_pwd_form" name="change_pwd_form" class="form-horizontal cmxform" action="<?php echo $form_url;?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-lg-2 col-sm-2 control-label" for="inputEmail1"><span style="color:red;float: left;">*</span>&nbsp;Old Password</label>
                <div class="col-lg-4">
                    <input type="password" placeholder="Enter Old Password" name="old_password" maxlength="15" class="form-control" />
                    <label class="error" id="old_error"><?php echo form_error('old_password'); ?>
                        <?php
                        if($this->session->userdata('result_change_password') == "failed_old")
                        {
                        echo "<span>Please enter valid old password.</span>";
                        }
                        ?>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-sm-2 control-label" for="inputEmail1"><span style="color:red;float: left;">*</span>&nbsp;New Password</label>
                <div class="col-lg-4">
                    <input type="password" placeholder="Enter New Password" name="new_password" id="new_password" maxlength="15" class="form-control">
                    <label class="error" id="newpass_error"><?php echo form_error('new_password'); ?></label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-sm-2 control-label" for="inputEmail1"><span style="color:red;float: left;">*</span>&nbsp;Confirm Password</label>
                <div class="col-lg-4">
                    <input type="password" placeholder="Enter Confirm Password" name="confirm_password"  maxlength="15" class="form-control">
                    <label class="error" id="confirm_error"><?php echo form_error('confirm_password'); ?>
                        <?php
                        if($this->session->userdata('result_change_password') == "failed_confirm")
                        {
                        echo "<span>New password and confirm password must match.</span>";
                        }
                        ?>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="Add"></label>
                <div class="col-md-4">
                    <button type="submit" id="Add" name="Add" onClick="return check_validation();" class="btn btn-success"><i class="icon-file-text"></i> Save</button>
                    <button type="button" id="Cancel" name="Cancel" class="btn btn-primary mrg-form-btn" onclick="javascript:window.location.href='<?php echo base_url()?>admin';"><i class="icon-remove"></i>  Cancel</button>
                </div>
            </div>
        </form>
    </div>
</section>
<?php $this->session->set_userdata('result_change_password',''); ?>
</section>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery.validator.addMethod("noSpace", function(value, element) { 
            return value.indexOf(" ") < 0 && value != ""; 
        }, "No space please and don't leave it empty");

    // validate form on keyup and submit
    $("#change_pwd_form").validate({
        rules: {
            old_password:{
                noSpace: true,
                required: true,
                minlength: 8,
                maxlength : 15,
            },
            new_password: {
                noSpace: true,
                required: true,
                minlength: 8,
                maxlength : 15,
            },
            confirm_password: {
                noSpace: true,
                required: true,
                minlength: 8,
                maxlength : 15,
                equalTo: "#new_password",
            }
        },
        messages: {
            old_password:{
                required : PASSWORD_BLANK,
                noSpace  : PASSWORD_SPACE_VALIDATION,
                minlength: PASSWORD_MIN,
                maxlength: PASSWORD_MAX,
            }, 
            new_password: {
                required : PASSWORD_BLANK,
                noSpace  : PASSWORD_SPACE_VALIDATION,
                minlength: PASSWORD_MIN,
                maxlength: PASSWORD_MAX,
            },
            confirm_password: {
                required: CONFIRM_BLANK,
                noSpace  : PASSWORD_SPACE_VALIDATION,
                minlength: PASSWORD_MIN,
                maxlength: PASSWORD_MAX,
                equalTo: PASSWORD_MATCH
            },
        },
        submitHandler: function (form) {
            $("div.loading_image.body_image").show();
            form.submit();
        }
    });
});
</script>