<script src="<?php echo HTTP_JS_PATH; ?>dist/jquery.validate.js"></script>
<section class="panel">
    <header class="panel-heading">
       <?php echo $page_title;?>
    </header>
    <div class="panel-body">
        <form id="noti_setting_form" name="noti_setting_form" class="form-horizontal cmxform" action="<?php echo base_url().'admin/setting/save_noti_setting'?>" method="post" enctype="multipart/form-data">
            
                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">
                            <span class="error">*</span> Android API Key
                    </label>
                    <div class="col-md-4">
                        <input id="api_key" name="api_key" placeholder="Enter title" class="form-control input-md"  type="text" value="<?php echo (isset($noti_setting_data))?$noti_setting_data['api_key']:"";?>">
                        <span class="error" id="errorhost"></span> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">APNS Server</label>  
                        <div class="col-md-4">
                            <select class="form-control" name="apns_server_mode" id="apns_server_mode">
                                <option value="">Select APNS Server Type</option>
                                <option value="<?php echo SANDBOX_URL; ?>" <?php if($noti_setting_data['apns_server_mode']==SANDBOX_URL) echo "selected"; ?>>Sandbox</option>
                                <option  value="<?php echo LIVE_URL; ?>" <?php if($noti_setting_data['apns_server_mode']==LIVE_URL) echo "selected"; ?>>Live</option>
                            </select>
                       </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">
                        <span class="error">*</span> APNS Password
                    </label>
                    <div class="col-md-4">
                    <input id="apns_password" name="apns_password" placeholder="Enter title" class="form-control input-md"  type="password" value="<?php echo (isset($noti_setting_data))?$noti_setting_data['apns_password']:"";?>">
                        <span class="error" id="errorpassword"></span> 
                        <a href="javascript:void(0); " onClick="showPassword()"><i class="icon-eye-close" style="position:absolute; top:7px; right:25px; font-size:17px; color:red;"></i></a>
                    </div>
                </div>

               <div class="form-group">
                    <label class="col-md-2 control-label" for="image">APNS File Name</label>  
                        <div class="col-md-4">
                                <input id="pem_file_name" name="pem_file_name"  class="input-md"  type="file" value="">
                                <span class="help-block" id="pointemail"></span>
                        <?php
                                  
                        if(file_exists(getcwd()."/assets/upload/pem/".$noti_setting_data['pem_file_name'])){ ?>
                        <div style="text-align: right;">
                                  <a href="<?=base_url()?>assets/upload/pem/<?php echo $noti_setting_data['pem_file_name']; ?>" download>Download File</a>
                        </div>
                        <?php } ?>
                    </div>
             </div>

                
            <div class="form-group">
                <label class="col-md-2 control-label" for="Add"></label>
                <div class="col-md-4">
                    <button type="submit" id="save_noti_setting" name="save_noti_setting" class="btn btn-success"><i class="icon-file-text"></i> Save</button>
                    <button type="button" id="Cancel" name="Cancel" class="btn btn-primary" onclick="javascript:window.location.href='<?php echo base_url()?>admin/dashboard';"><i class="icon-remove"></i> Cancel</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function() {
     $('#noti_setting_form').validate({
            rules:{
                api_key: {
                    required: true,
                },
                apns_server_mode: {
                    required: true,
                },
                apns_password: {
                    required: true,
                }
            },
            messages : {
                api_key: {
                    required:"API key is required field."
                },
                apns_server_mode: {
                    required: "Please select APNS server mode.",
                },
                apns_password: {
                    required: "APNS password is required field.",
                }
            },
            submitHandler: function (form) {
                $("div.loading_image.body_image").show();
                form.submit();
            }
        });            
    });

     function showPassword(){
              if($("#apns_password").attr("type") == "password")
                {
                  $("#apns_password").prop("type","text");
                  $("#apns_password").siblings("a").find("i").prop("class","icon-eye-open");
                  $("#apns_password").siblings("a").find("i").prop("style","position:absolute; top:7px; right:25px; font-size:17px; color:#00ceff;");
                }
                else
                {
                  $("#apns_password").prop("type","password");
                  $("#apns_password").siblings("a").find("i").prop("class","icon-eye-close");
                  $("#apns_password").siblings("a").find("i").prop("style","position:absolute; top:7px; right:25px; font-size:17px; color:#ff0000;");
                }
    }
</script>