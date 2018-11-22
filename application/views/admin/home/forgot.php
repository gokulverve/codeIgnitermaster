<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo HTTP_CSS_PATH; ?>favicon.png">
    <title><?php echo SITE_ADMIN_NAME; ?></title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo HTTP_CSS_PATH; ?>bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo HTTP_CSS_PATH; ?>signin.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo HTTP_JS_PATH; ?>html5shiv.js"></script>
      <script src="<?php echo HTTP_JS_PATH; ?>respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <?php 
      $addact=array('class'=>'form-signin panel');
      echo form_open('admin/home/forgot',$addact);
      ?>
        <h2 class="form-signin-heading">Forgot Password?</h2>
        <input type="text" class="form-control" placeholder="Email" required="" name="email" autofocus title="Please enter email.">
        <span class="help-block"><?php echo form_error('email'); ?></span>
        <div class="row">
            <div class="col-md-6 top-margin">
	            <button class="btn btn-lg btn-primary btn-block" type="submit" >Submit</button>
			</div>
            <div class="col-md-6 top-margin">
            	<a href="javascript:window.location='<?php echo site_url("admin/home/login"); ?>'" class="btn btn-lg btn-primary btn-block">Cancle</a>
			</div>
        </div>
      <?php echo form_close(); ?>
    </div> <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
<script>
$(window).load(function () {
		if($("#email").length > 0)
		{
			$("#email").keypress(function(e){
				var fn = $("#folderName").val();
				
				var regex = /^[0-9a-zA-Z&'*+-.=?^_{}~@]+$/
				if(!regex.test(e.key))
				{
					return false;
				}
				});
		}
	});
</script>