<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<!-- <link rel="shortcut icon" href="<?php echo base_url()?>assets/img/Mobi-PT-Icon-favicon.png"> -->
<title><?php echo PROJECT_NAME; ?></title>

<style>
.error
{
	text-align: center;
	background: none;
	color: red;
	font-size: small;
	font-weight: 700;
	margin:0;
}
.form-control
{
	color: black !important; 
}
</style>
<!-- Bootstrap core CSS -->
<link href="<?php echo HTTP_CSS_PATH; ?>bootstrap.min.css" rel="stylesheet">
<link href="<?php echo HTTP_CSS_PATH; ?>bootstrap-reset.css" rel="stylesheet">
<!--external css-->
<link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<!-- Custom styles for this template -->
<link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
<link href="<?php echo HTTP_CSS_PATH; ?>style-responsive.css" rel="stylesheet" />

<link href="<?php echo HTTP_CSS_PATH; ?>animate.css" rel="stylesheet">

<script defer="defer" src="<?php echo HTTP_JS_PATH; ?>jquery.js"></script>
<script defer="defer" src="<?php echo HTTP_JS_PATH; ?>jquery-1.8.3.min.js"></script>
<script defer="defer" src="<?php echo HTTP_JS_PATH; ?>bootstrap.min.js"></script>
 

<script type="text/javascript">
/* Function For admin login validation
==============================================================  */
function validatelogin()
{
	var flag = false;
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

	if($("#var_Email").val() == "")
	{
		$("#email_error").show();
		$("#email_error").html("Email address is required field");
		flag = true;
	}
	else if(!emailReg.test($("#var_Email").val()))
	{
		$("#email_error").show();
		$("#email_error").html("Please enter valid email address");
		flag = true;
	}
	else
	{
		$("#email_error").hide();
		$("#email_error").html("");
	}

	if($("#var_Password").val() == "")
	{
		$("#password_error").show();
		$("#password_error").html("Password is required field");
		flag = true;
	}
	else
	{
		$("#password_error").hide();
		$("#password_error").html("");
	}

	if($("#var_Type").val() == "")
	{
		$("#type_error").show();
		$("#type_error").html("Please select user type");
		flag = true;
	}
	else
	{
		$("#type_error").hide();
		$("#type_error").html("");
	}

	if(flag == true)
	{
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<style>
.help-block
{
	color: #f00;
}

#time {
    width: 100%;
    color: #333333;
    font-size: 65px;
    margin-bottom: 35px;
    display: inline-block;
    text-align: center;
    font-family: 'Open Sans', sans-serif;
    font-weight: 900;
}
.p_success
{
	    color: #468847;
    
    padding-top: 5px;
	    margin: 0;
}
.p_error
{
	color: #B94A48;
    
    padding-top: 5px;
	    margin: 0;
}
.p_hidden
{
	display:none;
}
.loading_image
{
	border: 1px solid;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    z-index: 1;
}
</style>
</head>
<body class="lock-screen">
    <div class="lock-wrapper">
        <div id="time"><span style="color: rgb(149, 214, 0);font-weight: 400;"><?php echo PROJECT_NAME;?></div>
        <div class="lock-box text-center">   
        <?php 
    	$file = getcwd().'/assets/upload/new-default-75.png' ;
		$photo = 'admin-default-75';
		if(file_exists($file)){
		?>
            <img src="<?php echo base_url().'assets/upload/new-default-75.png?'.rand() ?>" height="75px" width="75px"/>
        <?php } else { ?>
        	<img src="<?php echo base_url().'assets/upload/'.$photo.'.png?'.rand() ?>" height="75px" width="75px"/> 
        <?php } ?>       
            <h1></h1>
            <span class="locked">Login</span>
            <form class="form-inline" method="post" name="formAdd" role="form" action="<?php echo base_url(); ?>admin/home/login">
                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                

                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <input type="text" placeholder="Email" class="form-control" id="var_Email" name="var_Email" style="margin-bottom:10px;">
                        <span class="error" id="email_error" style="display:none;"></span>
                    </div>

                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <input type="password" placeholder="Password" class="form-control" id="var_Password" name="var_Password" maxlength="15" style="margin-bottom:10px;">
                        <span class="error" id="password_error" style="display:none;"></span>
                    </div>                    
                    
                    <button class="btn btn-lock" type="submit" onclick="return validatelogin();" id="loginsubmit"> 
                        Login &nbsp;
                        <i class="icon-arrow-right"></i>
                    </button>
                </div>
            </form>
            <div class="text-center" style="color: #ffffff;    padding-top: 10px;">
                <a data-toggle="modal" href="#myModal" style="color: #fff;"> Forgot Password?</a>
            </div>
            <span class="error"><?php echo @$error; ?></span>
        </div>
    </div>
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
          		<div class="loading_image" style="display:none;">
                	<img src="<?php echo base_url()?>assets/img/219.gif" style="position: absolute;top: 0;bottom: 0;right: 0;left: 0;margin: auto;width: 30px;"/>
                    <div style="color: #fff;font-size: 18px;position: absolute;top: 0;bottom: 0;left: 0;right: 0;margin: auto;display: inherit;width: 100%;height: 20px;clear: both;text-align: center;padding-top: 35px;padding-left: 10px;">Please Wait...</div>
                </div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Forgot Password ?</h4>
                </div>
                <div class="modal-body">
                    <p>Enter your e-mail address below to reset your password.</p>
                    <input type="text" required="" name="email" id="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
                    <p class="p_error p_hidden"></p>
                    <p class="p_success p_hidden"></p>
				</div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-danger" type="button"><i class="icon-remove-sign"></i> Cancel</button>
                    <button class="btn btn-success" type="button" onClick="checkvalidationlogin();"><i class="icon-ok-sign"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
		function checkvalidationlogin()
		{
			var re_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var pass_element = document.getElementById("email").value;
			
			if(!re_email.test(pass_element))
			{
				$("p.p_error").show();
				$("p.p_success").hide();
				$("p.p_error").html("Please enter valid email address.");
				$("#email").css("border-color","#B94A48");
				return false;
			}
			else
			{
				$("p.p_error").hide();
				$("p.p_success").hide();
				$("p.p_error").html("");
				$(".loading_image").show();
				$("#email").css("border-color","#e2e2e4");
				$.ajax({
				  url: "<?php echo base_url()?>admin/home/forgot",
				  
				  data: {
					"email_address" :  pass_element
				  },
				  success:function(data)
				  {
					  var response = JSON.parse(data);
					  if(response.hasOwnProperty('redirect')){
					  	window.location = response.redirect;
						return;
					  }
					  else
					  {
						  $(".loading_image").hide();
						  if(response.success == "0")
						  {
							  $("p.p_error").show();
							  $("p.p_success").hide();
							  $("p.p_error").html(response.message);
							  $("#email").css("border-color","#B94A48");
							  return false;
						  }
						  else
						  {
							  $("p.p_error").hide();
							  $("p.p_success").show();
							  $("p.p_error").html("");
							  $("p.p_success").html(response.message);
							  $(".modal-content button.btn-success").remove();
							  $(".modal-content button.btn-danger").html("<i class='icon-remove-sign'></i> Close");
							  $("#email").prev("p").remove();
							  $("#email").remove();
							  return true;
						  }
					  }
				  }
				});
				  
			}
		}
		setTimeout(function(){
			if($("#email").length > 0)
			{
				$("#email").keypress(function(e){
					var regex = /^[0-9a-zA-Z._@]+$/
					if(!regex.test(e.key))
					{
						return false;
					}
				});
			}
		},1000);
	</script>
</body> 
</html>

