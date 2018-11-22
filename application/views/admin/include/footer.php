</section>
</section>
<!--main content end-->
<footer class="site-footer" style="position: fixed;width: 100%;bottom: 0;z-index: 1000;">
    <div class="text-center">
        <?php echo date('Y')?> &copy; <?php echo ucfirst(PROJECT_NAME);?>
        <a href="#" class="go-top">
            <i class="icon-angle-up"></i>
        </a>
    </div>
</footer>
<!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->

<script src="<?php echo HTTP_JS_PATH; ?>script.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>bootstrap.min.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>bootbox/bootbox.min.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-ui-1.9.2.custom.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery.dcjqaccordion.2.7.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-multi-select/js/jquery.multiselect.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery.scrollTo.min.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo HTTP_JS_PATH; ?>owl.carousel.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-multi-select/js/jquery.multiselect.js"></script>

<!--script for this page-->
<script src="<?php echo HTTP_JS_PATH; ?>bootstrap-switch.js"></script>

<!--common script for all pages-->
<script>
    var base_url = "<?php echo base_url(); ?>admin/";
    function admin_logout()
    {
        var message = "Do you want to log out?";    
        bootbox.confirm(message, function(result) {
            if(result == true)
            {
                window.location = base_url+"home/logout";
            }
        });
    }

    
    // var LAST_NAME_SPACE_VALIDATION = '';

</script>

<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo HTTP_JS_PATH; ?>common-scripts.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>advanced-form-components.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>form-component.js"></script>

<!-- Datatable js start --> 
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>../DataTables/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>../DataTables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>../DataTables/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>../DataTables/responsive.bootstrap.min.js"></script>

<!-- Datatable js end -->


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script>

<script type="text/javascript" src="<?php echo  base_url('assets') ?>/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo  base_url('assets') ?>/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

<script src="<?php echo base_url(); ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script type="text/javascript">

/*$(document).ready(function () {
$('#datatable').DataTable();
});*/
/* Function For all success/fail message
==============================================================  */
<?php
if($this->session->userdata("success_notification") == "1")
{
    ?>
    $.gritter.add({
// (string | mandatory) the heading of the notification
title: '<?php echo $this->session->userdata("notification_title")?>',
// (string | mandatory) the text inside the notification
text: '<?php echo $this->session->userdata("notification_body")?>',
// (string | optional) the image to display on the left
// (bool | optional) if you want it to fade out on its own or just sit there
sticky: false,
// (int | optional) the time you want it to be alive for before fading out
time: '3000',

class_name: '<?php echo $this->session->userdata("notification_class")?>',
position: 'center',
before_open: function(){
    if($('.gritter-item-wrapper').length == 1)
    {
// Returning false prevents a new gritter from opening
return false;
}
}
});
    <?php
    $this->session->unset_userdata("success_notification");
    $this->session->unset_userdata("notification_title");
    $this->session->unset_userdata("notification_body");
    $this->session->unset_userdata("notification_class");
}

?>

if (window.location.href.indexOf("admin/dashboard") != "-1")
{ 	
    function countUp(count, class_name)
    {
        var div_by = count,
            speed = Math.round(count / div_by),
            $display = $('.' + class_name),
            run_count = 1,
            int_speed = 24;

        var int = setInterval(function() {
            if(run_count < div_by){
                $display.text(speed * run_count);
                run_count++;
            } else if(parseInt($display.text()) < count) {
                var curr_count = parseInt($display.text()) + 1;
                $display.text(curr_count);
            } else {
                clearInterval(int);
            }
        }, int_speed);
    }
    countUp('<?php echo @$total_users?>','total_users');
}


jQuery(document).ready(function($) {
    jQuery('#nav-accordion').dcAccordion();
});
</script>
<!-- Ckeditor js start --> 
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.replace("editor1");
    CKEDITOR.replace("editor2");

    $(function () {
    CKEDITOR.replace('txt_Description');
    
    });
</script>
<!-- Ckeditor js end --> 

<div class="modal fade" id="mydeleteModal" role="dialog">
    <div class="modal-dialog modal-sm modal-sm-new">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body text-center">
                <p class="delete-conform-p">Do you want to delete this record?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="redirection" id="redirection" value="">
                <button type="button" class="btn btn-default delete-conform">Ok</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>