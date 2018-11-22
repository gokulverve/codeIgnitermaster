<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/Mobi-PT-Icon-favicon.png">

        <title><?php echo ucfirst(PROJECT_NAME);?> -<?php echo @$page_title; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo HTTP_CSS_PATH; ?>bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo HTTP_CSS_PATH; ?>bootstrap-reset.css" rel="stylesheet">
        <link href="<?php echo HTTP_CSS_PATH; ?>table-responsive.css" rel="stylesheet" />

        <!--external css-->
        <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>owl.carousel.css" type="text/css">

        <!-- Custom styles for this template -->
        <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
        <link href="<?php echo HTTP_CSS_PATH; ?>style-responsive.css" rel="stylesheet" />
        <link href="<?php echo HTTP_CSS_PATH; ?>custom.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/gritter/css/jquery.gritter.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/star-rating.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/jquery-multi-select/css/jquery.multiselect.css" />
        
         <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets') ?>/bootstrap-colorpicker/css/bootstrap-colorpicker.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets') ?>/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css"/>

        <!-- Datatable css start -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/DataTables/dataTables.bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/DataTables/responsive.bootstrap.min.css"/>

        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datepicker.css">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/jquery-multi-select/css/jquery.multiselect.css" />
        <script src="<?php echo HTTP_JS_PATH; ?>jQuery-2.1.4.min.js"></script>
        <script src="<?php echo HTTP_JS_PATH; ?>jquery.min.js"></script>
        <script type="text/javascript">
            var FIRST_NAME_BLANK_VALIDATION = 'First name is required field.';
            var FIRST_NAME_12_VALIDATION = 'The first name should be not more than 12 char.';
            var FIRST_NAME_SPACE_VALIDATION = 'The space between the first name should not be accepted.';
            var LAST_NAME_BLANK_VALIDATION = 'Last name is required field.';
            var LAST_NAME_12_VALIDATION = 'The last name should be not more than 12 char.';
            var LAST_NAME_SPACE_VALIDATION = 'The space between the last name should not be accepted.';
            var EMAIL_BLANK_VALIDATION = 'Email address is required field.';
            var PHONE_BLANK_VALIDATION = 'Phone number is required field.';
            var EMAIL_VALID_VALIDATION = 'Please enter a valid email address';
            var PROFILE_IMAGE = 'Please select profile picture to upload.';
            var PASSWORD_SPACE_VALIDATION = 'The space between the password should not be accepted.';
            var PASSWORD_MIN = 'Password should be of minimum eight characters.';
            var PASSWORD_MAX = 'Password should be of maximum fifteen characters.';
            var PASSWORD_MATCH = 'Password & confirm password does not match.';
            var PASSWORD_BLANK = "Password is required field";
            var CONFIRM_BLANK = "Confirm password is required field";
            var ADDRESS_BLANK = "Address is required field";

            $(document).ready(function() {
                $.validator.addMethod("alphanumeric", function(value, element) {
                     return this.optional(element) || /^[A-Za-z][A-Za-z0-9]+$/i.test(value);
                }, "Must be Alphanumeric.");

                $.validator.addMethod( "extension", function( value, element, param ) {
                    param = typeof param === "string" ? param.replace( /,/g, "|" ) : "png|jpe?g|gif";
                    return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
                }, $.validator.format( "Please enter a value with a valid extension." ) );

                $.validator.addMethod("noSpace", function(value, element) { 
                  return value.indexOf(" ") < 0 && value != ""; 
                }, "No space please and don't leave it empty");

            });

            function validateQty(event) 
            {
                var key = window.event ? event.keyCode : event.which;
                if (event.keyCode == 8 || event.keyCode == 46
                 || event.keyCode == 37 || event.keyCode == 39) {
                    return true;
                }
                else if ( key < 48 || key > 57 ) {
                    return false;
                }
                else return true;
            }

        </script>
        
    </head>

    <body style="overflow: hidden;">
        <style type="text/css">
            .has-error .errormsg, .error {
                color: #f74747;
                font-family: "Open Sans",sans-serif;
                font-size: 12px;
                font-weight: 400;
                margin: 0;
                padding: 5px 0;
                text-align: left;
            }
        </style>
        <div class="loading_image body_image"> 
            <img src="<?php echo base_url() ?>assets/img/loader.gif"  class="spinner" style="position: absolute;top: 0;bottom: 0;right: 0;left: 0;margin: auto;"/> 
            <!-- loader -->
        </div>
        <script type="text/javascript">
            function success_message(message) 
            {
                $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: 'Success!!!',
                    // (string | mandatory) the text inside the notification
                    text: message,
                    // (string | optional) the image to display on the left
                    // (bool | optional) if you want it to fade out on its own or just sit there
                    sticky: false,
                    // (int | optional) the time you want it to be alive for before fading out
                    time: '3000',
                    class_name: 'success-notification',
                    position: 'center',
                    before_open: function () {
                        if ($('.gritter-item-wrapper').length == 1)
                        {
                            // Returning false prevents a new gritter from opening
                            return false;
                        }
                    }
                });
            }

            function error_message(message)
            {
                $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: 'Error!!!',
                    // (string | mandatory) the text inside the notification
                    text: message,
                    // (string | optional) the image to display on the left
                    // (bool | optional) if you want it to fade out on its own or just sit there
                    sticky: false,
                    // (int | optional) the time you want it to be alive for before fading out
                    time: '3000',
                    class_name: 'failure-notification',
                    position: 'center',
                    before_open: function () {
                        if ($('.gritter-item-wrapper').length == 1)
                        {
                            // Returning false prevents a new gritter from opening
                            return false;
                        }
                    }
                });
            }   
        </script>
        <?php
        if ($this->uri->segment(3) == "changepassword")
            $url = "home";
        else
            $url = $this->uri->segment(2);

        ?>

        <section id="container" >

            <!--header start-->
            <header class="header white-bg">
                <div class="sidebar-toggle-box">
                    <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
                </div>
                <!--logo start--> 
                <a href="<?php echo base_url(); ?>" class="logo"><?php echo ucfirst(PROJECT_NAME)?></span></a> 
                <!--logo end-->

                <div class="top-nav "> 
                    <!--search & user info start-->
                    <ul class="nav pull-right top-menu">
                        <li>
                            <div class="nav notify-row" id="top_menu"> 
                                <!--  notification start -->
                                <ul class="nav top-menu">

                                    

                                </ul>
                            </div>
                        </li>
                        <!-- user login dropdown start-->
                        <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <?php
                                $admin_session = $this->session->userdata('admin_session');
                                if($admin_session['admin_id'] != "")
                                {
                                    $this->db->select("*");
                                    $this->db->from("tbl_admin");
                                    $this->db->where("admin_id",$admin_session['admin_id']);
                                    $current_admin = $this->db->get()->row_array();

                                    if(isset($current_admin['profile_image']) && $current_admin['profile_image'] != "")
                                    {
                                        $file = BASE_PATH."admin-user-profile/".$current_admin['profile_image'];
                                        $filepath = base_url("assets/upload/admin-user-profile/".$current_admin['profile_image']);
                                        if(file_exists($file))
                                        { ?>
                                            <img src="<?php echo $filepath; ?>"   height="35px" width="35px"/>
                                        <?php }
                                    }
                                    else
                                        { ?>
                                            <img src="<?php echo base_url() . 'assets/upload/no-image.png' ?>"   height="35px" width="35px"/>
                                    <?php }
                                }
                                ?>
                                <span class="username">
                                    <?php
                                    echo $current_admin["first_name"] . "  " . $current_admin["last_name"];
                                    ?>
                                </span> <b class="caret"></b> </a>
                            <ul class="dropdown-menu extended logout">
                                <div class="log-arrow-up"></div>
                                <li style="width:50%"><a href="<?php echo base_url(); ?>admin/dashboard/profile"><i class=" icon-suitcase"></i>Profile</a></li>
                                <li><a href="<?php echo base_url(); ?>admin/dashboard/changepassword"><i class="icon-key"></i> Change Password</a></li>
                                <li><a href="javascript:void(0)" onClick="admin_logout()"><i class="icon-signout"></i> Log Out</a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->
                    </ul>
                    <!--search & user info end--> 
                </div>
            </header>
            <!--header end-->