<section class="panel">
    <header class="panel-heading topTitleHeader">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6 topTitle padd-left">Cms List</div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-right">
            <button type="button" class="btn btn-info btn btn-shadow " onclick="window.location.href = '<?php echo base_url('admin/cms/add_edit_cms') ?>'"><i class=" icon-plus-sign"></i> Create Cms</button>
        </div>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <!-- <label>Show</label> -->
                <select class="form-control" id="show_per_page" style="width: 64px;">
                    <?php
                    foreach ($show_per_page as $value) 
                    { ?>
                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php }
                    ?>
                </select> 
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="search_text" id="search_field_value" class="form-control" placeholder="Enter cms name">
                </div>                                 
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-success" id="search"><i class="fa fa-search"></i>&nbsp;Search</button>
                <button type="button" class="btn default" id="clear">View All</button>
            </div>
        </div>
        <div id="ajax_data">
            <?php $this->load->view('admin/cms/ajax_list', $data);?>
        </div>
    </div>
</section>
<script type="text/javascript">
$(document).ready(function() {

    $(document).on('keypress', '#search_field_value', function(e) {
        var key = e.which;
        if(key == 13)
        {
          do_search();
          return false;
        }
    });
    
    $(document).on('click', '#search', function(event) {
        do_search();
        return false;          
    });
    $(document).on('change', '#show_per_page', function(event) {
        do_search();
        return false;          
    });

    $(document).on('click', '#clear', function(event) {
        $("#search_field_value").val("");
        $('#pagination_page').val('');
        page_update();
        return false;          
    });

    $(document).on('click', '.pagination_link', function(event) {
        if($(this).attr('href')){
            $('#pagination_url').val($(this).attr('href'));
            $('#pagination_page').val('');
        }
        page_update();
        return false;
    });

    $(document).on('click', '.sorting_link', function(event) {
        if($(this).attr('sort_by') && $(this).attr('sort_direction'))
        {
            $('#pagination_sort_by').val($(this).attr('sort_by'));
            $('#pagination_sort_direction').val($(this).attr('sort_direction'));
        }
        do_search();
        return false;
    });
});

function do_search()
{
    $('#pagination_page').val('');
    page_update();    
}

function page_update()
{
    $.ajax({
        url: $('#pagination_url').val() + $('#pagination_page').val(),
        type: 'POST',
        data: { 
                'request'       :'ajax', 
                'sort_by'       : $('#pagination_sort_by').val(), 
                'sort_direction': $('#pagination_sort_direction').val(), 
                'per_page'      : $('#show_per_page').val(),
                'search'        : $.trim($('#search_field_value').val())
            },
            beforeSend: function()
            {            
               // $("div.loading_image.body_image").show();
            },      
            complete:function()
            {
               // $("div.loading_image.body_image").hide();
            },
            success: function( data ) {
                $('#ajax_data').html(data);
            },
        });
    return false;
}

function delete_cms(cms_id)
{
    if (cms_id != "") 
    {
        var message = "Are you sure want to delete this record?";    
        bootbox.confirm(message, function(result) {
        if(result == true)
        {
            $.ajax({
                url: "<?php echo base_url('admin/cms/delete') ?>",
                data:{'cms_id':cms_id},
                type: 'post',
                dataType: 'json',
                async: true,
                success : function(data) {
                    //$("div.loading_image.body_image").hide();
                    if(data.status == 'success')
                    {
                        success_message(data.msg);
                        page_update();
                        return false;
                    }
                    else if(data.status == 'error')
                    {
                        error_message(data.msg);
                    }
                }
            });
        }
        });
    }
}
</script>