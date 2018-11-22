<script src="<?php echo HTTP_JS_PATH; ?>dist/jquery.validate.js"></script>
<section class="panel">
		<header class="panel-heading"> Profile </header>
		<div class="panel-body">
			<form id="edit_frm" name="edit_frm" class="form-horizontal cmxform" action="<?php echo $form_url;?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
						<label class="col-md-2 control-label" for="email">First Name</label>
						<div class="col-md-4">
							<input name="first_name" placeholder="Enter First Name" class="form-control input-md"  type="text" value="<?php echo $detail[0]->first_name;?>">
							<span class="help-block error error_first_name" id="pointemail"><?php echo form_error('first_name'); ?></span> 
						</div>
				</div>
				<div class="form-group">
						<label class="col-md-2 control-label" for="email">Last Name</label>
						<div class="col-md-4">
							<input name="last_name" placeholder="Enter Last Name" class="form-control input-md"  type="text"  value="<?php echo $detail[0]->last_name;?>">
							<span class="help-block error error_last_name" id="pointemail"><?php echo form_error('last_name'); ?></span> 
						</div>
				</div>
				
				<div class="form-group">
						<label class="col-md-2 control-label" for="email">Email</label>
						<div class="col-md-4">
							<input name="email_address" placeholder="Enter Email" class="form-control input-md" type="email" value="<?php echo $detail[0]->email_address;?>" readonly>
							<span class="help-block error error_email_address" id="pointemail"><?php echo form_error('email_address'); ?></span> 
						</div>
				</div>
				<div class="form-group">
						<label class="col-md-2 control-label" for="image">Profile Picture</label>
						<div class="col-md-4">
								
								<?php
								$display = "block";
								if($detail[0]->profile_image != ""){
									$file = BASE_PATH."admin-user-profile/".$detail[0]->profile_image;
									$filepath = base_url("assets/upload/admin-user-profile/".$detail[0]->profile_image);
								if(file_exists($file))
								{ 
									$display = "none";
									?>
								<div id="image_id">
									<img src="<?php echo $filepath; ?>" height="100px" width="100px" style=" margin-top:25px "/>
									<span class="profile-remove-span df-cursor" data-id="<?php echo $detail[0]->admin_id;?>" data-image="<?php echo $file?>"><i class="icon icon-remove profile-icon-remove"></i></span>
								</div>
								<?php } } ?>
								<input style="display: <?php echo $display; ?>" id="profile_image" name="profile_image" class="form-control input-md"  type="file">
								<span class="help-block" id="pointemail"><?php echo form_error('picture'); ?></span> </div>
				</div>
				<div class="form-group">
						<label class="col-md-2 control-label" for="Add"></label>
						<div class="col-md-4">
								<button type="submit" id="Add" name="Add" class="btn btn-success"><i class="icon-file-text"></i> Save</button>
								<button type="button" id="Cancel" name="Cancel"  onclick="javascript:window.location.href='<?php echo base_url()?>admin/dashboard';" class="btn btn-primary"><i class="icon-remove"></i> Cancel</button>
						</div>
				</div>
				</form> </div>
</section>
<script type="text/javascript">
$(document).ready(function() {
	
	// validate form on keyup and submit
	$("#edit_frm").validate({
	    rules: {
	        first_name:{
	            noSpace: true,
	            required: true,
	            alphanumeric: true,
	            maxlength : 12
	        },
	        last_name: {
	            noSpace: true,
	            required: true,
	            alphanumeric: true,
	            maxlength : 12
	        },
	        profile_image: {
                    required: true,
                    extension: "jpg,jpeg,png"
                },
	    },
	    messages: {
	        first_name:{
	            required : FIRST_NAME_BLANK_VALIDATION,
	            noSpace  : FIRST_NAME_SPACE_VALIDATION,
	            maxlength: FIRST_NAME_12_VALIDATION
	        }, 
	        last_name: {
	            required : LAST_NAME_BLANK_VALIDATION,
	            noSpace  : LAST_NAME_SPACE_VALIDATION,
	            maxlength: LAST_NAME_12_VALIDATION
	        },
	        profile_image: {
                    required : PROFILE_IMAGE,
                    extension: "You're only allowed to upload jpg or png images."
                },
	    },
	    submitHandler: function (form) {
	        $("div.loading_image.body_image").show();
	        form.submit();
	    }
	});

	$('.profile-remove-span').on('click', function () {
        $("div.loading_image.body_image").show();
        $.ajax({
            type: "POST",
            data: {"image":$(this).attr('data-image'),"id":$(this).attr('data-id')},
            url: base_url + "dashboard/deleteprofileimg",
            dataType: 'json',
            success: function (data) {
                $("div.loading_image.body_image").hide();
                    if(data.status == 'success')
                    {
                        success_message(data.msg);
                        $("#profile_image").show();
                        $("#image_id").hide();
                    }
                    else if(data.status == 'error')
                    {
                        error_message(data.msg);
                    }
            },
        });
    });
});
</script>