<script src="<?php echo HTTP_JS_PATH; ?>dist/jquery.validate.js"></script>
<section class="panel">
    <header class="panel-heading">
       <?php echo $page_title;?>
    </header>
    <div class="panel-body">
        <form id="cms_form" name="cms_form" class="form-horizontal cmxform" action="<?php echo base_url().'admin/cms/save_cms'?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="cms_id" value="<?php echo (isset($cms_data))?$cms_data['cms_id']:"";?>">
            
                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">
                            <span class="error">*</span> Title
                    </label>
                    <div class="col-md-4">
                        <input  id="cms_name" name="cms_name" placeholder="Enter title" class="form-control input-md"  type="text" value="<?php echo (isset($cms_data))?$cms_data['cms_name']:"";?>">
                        <span class="error" id="errortitle"></span> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="first_name">
                        <span class="error">*</span> Description
                    </label>
                    <div class="col-md-4">
                    <textarea id="editor1" name="editor1" class="form-control"><?php echo (isset($cms_data))?$cms_data['cms_description']:"";?></textarea>
                        <span class="error" id="errorDescription"></span> 
                    </div>
                </div>

                 <div class="form-group">
                    <label class="col-md-2 control-label">
                            <span class="error">*</span> Publish Status
                    </label>
                    <div class="col-md-4">
                        <select id="status" name="status" class="form-control input-md">
                            <option  value="">Select Publish Status</option>
                            <option  value="1" <?php if(isset($cms_data) && $cms_data['status'] == '1'){ echo "selected"; }?> >Active</option>
                            <option  value="0" <?php if(isset($cms_data) && $cms_data['status'] == '0'){ echo "selected"; }?> >Inactive</option>
                        </select>
                    </div>
                </div>
                
            <div class="form-group">
                <label class="col-md-2 control-label" for="Add"></label>
                <div class="col-md-4">
                    <button type="submit" id="save_cms" name="save_cms" class="btn btn-success"><i class="icon-file-text"></i> Save</button>
                    <button type="button" id="Cancel" name="Cancel" class="btn btn-primary" onclick="javascript:window.location.href='<?php echo base_url()?>admin/cms';"><i class="icon-remove"></i> Cancel</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script type="text/javascript">
       $(document).ready(function() {

        $('#cms_name').on('blur', function() {
            var cms_name = $.trim($(this).val());
            var cms_id = $.trim($("#cms_id").val());
           // $("div.loading_image.body_image").show();
            $.ajax({
                url: "<?php echo base_url('admin/cms/check_cms_exist') ?>",
                data:{'cms_id':cms_id,'cms_name':cms_name},
                type: 'post',
                dataType: 'json',
                async: true,
                success : function(data) {
                  //  $("div.loading_image.body_image").hide();
                    if(data.status == 'success')
                    {
                        
                    }
                    else if(data.status == 'error')
                    {
                        $("#cms_name").val("");
                        error_message(data.msg);
                    }
                }
            });
        });

        /*Remove Profile image*/
        $('.profile-remove-span').on('click', function () {
            //$("div.loading_image.body_image").show();
            var field = $(this).attr('data-field');
            $.ajax({
                url: base_url + "cms/delete_image",
                data: {"image":$(this).attr('data-image'),"id":$(this).attr('data-id'),"field":field},
                type: 'post',
                dataType: 'json',
                async: true,
                success: function (data) {
                  //  $("div.loading_image.body_image").hide();
                        if(data.status == 'success')
                        {
                            success_message(data.msg);
                            $("#cms_image").show();
                            $("#image_id_"+field).hide();
                        }
                        else if(data.status == 'error')
                        {
                            error_message(data.msg);
                        }
                },
            });
        });        

    $('#cms_form').validate({
    ignore: [],         
         rules: {
                editor1: {
                    required: function() 
                    {
                    CKEDITOR.instances.editor1.updateElement();
                    }
                    },
                cms_name: { required: true },
                status: { required: true }
            },

          messages: {
                 editor1: {
                    required:"Description is required field."
                },
                 status: {
                    required:"Please select publish status."
                },
                 cms_name: {
                    required:"SMTP host is required field."
                }
            },
                /* use below section if required to place the error*/
                errorPlacement: function(error, element) 
                {
                    if (element.attr("name") == "editor1") 
                   {
                    error.insertBefore("textarea#editor1");
                    } else {
                    error.insertBefore(element);
                    }
                }
            });    
    });

       

</script>