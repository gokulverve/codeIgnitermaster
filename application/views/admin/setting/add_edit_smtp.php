<script src="<?php echo HTTP_JS_PATH; ?>dist/jquery.validate.js"></script>
<section class="panel">
    <header class="panel-heading">
       <?php echo $page_title;?>
    </header>
    <div class="panel-body">
        <form id="smtp_form" name="smtp_form" class="form-horizontal cmxform" action="<?php echo base_url().'admin/setting/save_smtp'?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="smtp_id" value="<?php echo (isset($smtp_data))?$smtp_data['smtp_id']:"";?>">
            
                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">
                            <span class="error">*</span> SMTP Host
                    </label>
                    <div class="col-md-4">
                        <input id="host" name="host" placeholder="Enter SMTP Host" class="form-control input-md"  type="text" value="<?php echo (isset($smtp_data))?$smtp_data['host']:"";?>">
                        <span class="error" id="errorhost"></span> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">
                        <span class="error">*</span> Username
                    </label>
                    <div class="col-md-4">
                    <input id="username" name="username" placeholder="Enter Username" class="form-control input-md"  type="text" value="<?php echo (isset($smtp_data))?$smtp_data['username']:"";?>">
                        <span class="error" id="errorusername"></span> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">
                        <span class="error">*</span> SMTP Port Id
                    </label>
                    <div class="col-md-4">
                     <input id="port_id" name="port_id" placeholder="Enter Port Id" class="form-control input-md"  type="text" value="<?php echo (isset($smtp_data))?$smtp_data['port_id']:"";?>">
                        <span class="error" id="errorport_id"></span> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">
                        <span class="error">*</span> Password
                    </label>
                    <div class="col-md-4">
                    <input id="password" name="password" placeholder="Enter Password" class="form-control input-md"  type="text" value="<?php echo (isset($smtp_data))?$smtp_data['password']:"";?>">
                        <span class="error" id="errorpassword"></span> 
                        <a href="javascript:void(0); " onClick="showPassword()"><i class="icon-eye-close" style="position:absolute; top:7px; right:25px; font-size:17px; color:red;"></i></a>
                    </div>
                </div>

                
            <div class="form-group">
                <label class="col-md-2 control-label" for="Add"></label>
                <div class="col-md-4">
                    <button type="submit" id="save_smtp" name="save_smtp" class="btn btn-success"><i class="icon-file-text"></i> Save</button>
                    <button type="button" id="Cancel" name="Cancel" class="btn btn-primary" onclick="javascript:window.location.href='<?php echo base_url()?>admin/dashboard';"><i class="icon-remove"></i> Cancel</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function() {
     $('#smtp_form').validate({
            rules:{
                host: {
                    required: true,
                },
                username: {
                    required: true,
                },
                password: {
                    required: true,
                },
                port_id: {
                    required: true,
                }
            },
            messages : {
                host: {
                    required:"SMTP host is required field."
                },
                username: {
                    required: "Username is required field.",
                },
                password: {
                    required: "Password is required field.",
                },
                port_id: {
                    required: "SMTP port Id is required field.",
                }
            },
            submitHandler: function (form) {
                $("div.loading_image.body_image").show();
                form.submit();
            }
        });            
    });

     function showPassword(){
              if($("#password").attr("type") == "password")
                {
                  $("#password").prop("type","text");
                  $("#password").siblings("a").find("i").prop("class","icon-eye-open");
                  $("#password").siblings("a").find("i").prop("style","position:absolute; top:7px; right:25px; font-size:17px; color:#00ceff;");
                }
                else
                {
                  $("#password").prop("type","password");
                  $("#password").siblings("a").find("i").prop("class","icon-eye-close");
                  $("#password").siblings("a").find("i").prop("style","position:absolute; top:7px; right:25px; font-size:17px; color:#ff0000;");
                }
    }
</script>