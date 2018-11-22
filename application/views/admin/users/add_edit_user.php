<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-daterangepicker/daterangepicker.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="<?php echo HTTP_JS_PATH; ?>dist/jquery.validate.js"></script>

<section class="panel">
    <header class="panel-heading">
       <?php echo $page_title;?>
    </header>
    <div class="panel-body">
        <form id="user_form" name="user_form" class="form-horizontal cmxform" action="<?php echo $form_url;?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo (isset($user_data))?$user_data['user_id']:"";?>">

                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">
                            <span class="error">*</span> First Name
                    </label>
                    <div class="col-md-4">
                        <input name="first_name" placeholder="Enter first name" class="form-control input-md"  type="text" value="<?php echo (isset($user_data))?$user_data['first_name']:"";?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="last_name">
                            <span class="error">*</span> Last Name
                    </label>
                    <div class="col-md-4">
                        <input name="last_name" placeholder="Enter last name" class="form-control input-md"  type="text" value="<?php echo (isset($user_data))?$user_data['last_name']:"";?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">
                            <span class="error">*</span> Email Address
                    </label>
                    <div class="col-md-4">
                        <input id="email_address" name="email_address" placeholder="Enter email" class="form-control input-md"  type="text" value="<?php echo (isset($user_data))?$user_data['email_address']:"";?>">
                    </div>
                </div>

                    <div class="form-group">
                    <label class="col-md-2 control-label">
                            <span class="error">*</span> Birthdate
                    </label>
                    <div class="col-md-4 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input name="birthdate" id="birthdate" placeholder="Enter Date" class="form-control input-md"  type="text" value="<?php echo (isset($user_data))? get_formatted_date($user_data['birthdate']):"";?>">
                    </div>
                </div>

                <?php
                if (!isset($user_data)) 
                    { ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="password">
                            <span class="error">*</span> Password
                        </label>
                        <div class="col-md-4">
                            <input id="password" name="password" placeholder="Enter Password" class="form-control input-md"  type="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="confirm_password">
                            <span class="error">*</span> Confirm Password
                        </label>
                        <div class="col-md-4">
                            <input id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password" class="form-control input-md"  type="password">
                        </div>
                    </div>
                <?php }
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="profile_image">
                        <span class="error">*</span> Profile Image
                    </label>
                    <div class="col-md-4">
                        <?php
                        $display = "block";
                        if(isset($user_data['profile_image']) && $user_data['profile_image'] != "")
                        {
                            $file = BASE_PATH."user_image/".$user_data['profile_image'];
                            $filepath = base_url("assets/upload/user_image/".$user_data['profile_image']);
                            if(file_exists($file))
                            { 
                                $display = "none"; 
                            ?>
                            <div id="image_id_profile_image">
                            <img src="<?php echo base_url("assets/upload/user_image/".$user_data['profile_image']); ?>" name="profile" class="userprofilepic" Height="100px" width="100px">
                            <span style="top:0% !important;" class="profile-remove-span df-cursor" data-id="<?php echo $user_data['user_id'];?>" data-image="<?php echo $file;?>" data-field="profile_image"><i class="icon icon-remove profile-icon-remove"></i></span>
                            </div>
                           <?php }
                        } ?>
                        <input style="display: <?php echo $display; ?>" id="profile_image" name="profile_image" class="form-control input-md"  type="file">                        
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">
                            <span class="error">*</span> Status
                    </label>
                    <div class="col-md-4">
                        <select id="status" name="status" class="form-control input-md">
                            <option  value="1" <?php if(isset($user_data) && $user_data['status'] == '1'){ echo "selected"; }?> >Active</option>
                            <option  value="0" <?php if(isset($user_data) && $user_data['status'] == '0'){ echo "selected"; }?> >Inactive</option>
                        </select>
                    </div>
                </div>
                
            <div class="form-group">
                <label class="col-md-2 control-label" for="Add"></label>
                <div class="col-md-4">
                    <button type="submit" id="save" name="save" class="btn btn-success"><i class="icon-file-text"></i> Save</button>
                    <button type="button" id="Cancel" name="Cancel" class="btn btn-primary" onclick="javascript:window.location.href='<?php echo $btn_cancel?>'" ><i class="icon-remove"></i> Cancel</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script type="text/javascript">
       $(document).ready(function() {
        var day='<?php echo date('d');?>';
        var month='<?php echo date('m');?>';
        var year='<?php echo date('Y');?>';
        // var mydate = year+'/'+month+'/'+day;
        var mydate = day+'-'+month+'-'+year;
        // alert(mydate);
        $('#birthdate').datepicker({ 
           changeMonth: true,
           changeYear: true,
           showAnim: 'slideDown',
           format: 'dd-mm-yyyy',
           endDate:mydate
       });

        $('#email_address').on('blur', function() {
            var email_address = $.trim($(this).val());
            var user_id = $.trim($('#user_id').val());
            if (email_address != "") {
                $("div.loading_image.body_image").show();
                $.ajax({
                    url: "<?php echo base_url('admin/users/check_user_exist') ?>",
                    data:{'email_address':email_address,'user_id' : user_id},
                    type: 'post',
                    dataType: 'json',
                    async: true,
                    success : function(data) {
                        $("div.loading_image.body_image").hide();
                        if(data.status == 'success')
                        {
                            
                        }
                        else if(data.status == 'error')
                        {
                            $("#email_address").val("");
                            error_message(data.msg);
                        }
                    }
                });
            }
        });

        // validate form on keyup and submit
        $("#user_form").validate({
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
                email_address: {
                    required: true,
                    email: true
                },
                password: {
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
                    equalTo: "#password"
                },
                profile_image: {
                    required: true,
                    extension: "jpg,jpeg,png"
                },
                birthdate: "required"
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
                email_address: {
                    required : EMAIL_BLANK_VALIDATION,
                    email : EMAIL_VALID_VALIDATION,
                },
                password: {
                    required : PASSWORD_BLANK,
                    noSpace  : PASSWORD_SPACE_VALIDATION,
                    minlength: PASSWORD_MIN,
                    maxlength: PASSWORD_MAX,
                },
                confirm_password: {
                    required : CONFIRM_BLANK,
                    noSpace  : PASSWORD_SPACE_VALIDATION,
                    minlength: PASSWORD_MIN,
                    maxlength: PASSWORD_MAX,
                    equalTo  : PASSWORD_MATCH
                },                 
                profile_image: {
                    required : PROFILE_IMAGE,
                    extension: "You're only allowed to upload jpg or png images."
                },
                birthdate: ""
            },
            submitHandler: function (form) {
                $("div.loading_image.body_image").show();
                form.submit();
            }
        });

        /*Remove Profile image*/
        $('.profile-remove-span').on('click', function () {
            $("div.loading_image.body_image").show();
            var field = $(this).attr('data-field');
            $.ajax({
                url: base_url + "users/delete_profile_image",
                data: {"image":$(this).attr('data-image'),"id":$(this).attr('data-id'),"field":field},
                type: 'post',
                dataType: 'json',
                async: true,
                success: function (data) {
                    $("div.loading_image.body_image").hide();
                        if(data.status == 'success')
                        {
                            success_message(data.msg);
                            $("#profile_image").show();
                            $("#image_id_"+field).hide();
                        }
                        else if(data.status == 'error')
                        {
                            error_message(data.msg);
                        }
                },
            });
        });
    });

//var KEY = 'AIzaSyCrLbDzygDydvlbMoUJc2QZsCjjmFJUCEI';
</script>
