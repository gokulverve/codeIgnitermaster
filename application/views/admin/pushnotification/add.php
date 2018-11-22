<script src="<?php echo HTTP_JS_PATH; ?>dist/jquery.validate.js"></script>
<section class="panel">
    <header class="panel-heading">
        Push Notification
    </header>
    
    <div class="panel-body">
        <form id="notification_frm" name="notification_frm" class="form-horizontal cmxform" action="<?php echo $form_url;?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-md-2 control-label" for="first_name">
                    <span class="error">*</span> User Type
                </label>
                <div class="col-md-4">
                    <select class="form-control" id="usertype" name="usertype">
                        <option value="all">All Users</option>
                        <option value="active">All Active Users</option>
                        <option value="inactive">All Inactive Users</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="first_name">
                    <span class="error">*</span> Message
                </label>
                <div class="col-md-4">
                    <textarea id="message" name="message" class="form-control" cols="7" rows="9"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="Add"></label>
                <div class="col-md-4">
                    <button type="submit" id="Add" name="Add" class="btn btn-success"><i class="fa fa-bell"></i> Send</button>
                </div>
            </div>
        </form> 
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        // validate form on keyup and submit
        $("#notification_frm").validate({
            rules: {
                usertype: "required",
                message: "required"
            },
            messages: {
                usertype: "Please enter user type",
                message: "Please enter message"
            },
            submitHandler: function (form) {
                $("div.loading_image.body_image").show();
                form.submit();
            }
        });
    });
</script>