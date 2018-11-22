<div class="table-responsive" id="respose">
    <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%">
        <thead>
            <tr>
                <!--<th><input type="checkbox" name="selectall" id="selectall"></th>-->
                <th>No</th>
                 <th <?php
                    if($sort_by=='cms_name' && $sort_direction == 'desc')
                    {
                    echo 'sort_direction= "asc" class="sorting_link sorting_desc"';
                    }
                    else if($sort_by=='cms_name' && $sort_direction == 'asc')
                    {
                    echo 'sort_direction= "desc" class="sorting_link sorting_asc"';
                    }
                    else
                    {
                    echo 'sort_direction= "asc" class="sorting_link sorting"';
                    }
                ?> sort_by="cms_name">Title</th>
                <th>Publish Status</th>
               
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($cms) > 0)
            {  
                foreach($cms as $data){ ?>
            <tr>
                <td><?php echo $i?></td>
                <td><?php echo $data->cms_name?></td>
               <!--  <td><?php if($data->status == '0'){ echo 'Inactive';}else{ echo "Active";} ?></td>  -->

                <td><a data-userid="<?=$data->cms_id?>" class="df-cursor changestatus <?=($data->status == "1" ? "textred" : "textgreen")?>" id="userchangestatus<?=$i?>" data-url="cms/changestatus"><?=($data->status == "1" ? "Active" : "Inactive")?></a><input type="hidden" name="ustatus" id="ustatus" value="<?=$data->status?>"></td>
                
                <td><?php echo break_str($data->cms_description)?></td>
                <td>
                    <a href="<?php echo base_url().'admin/cms/add_edit_cms/'.$data->cms_id?>" class="df-cursor"><i class="icon-edit new-icon-css pd-right"></i></a>
                    <!-- <a data-redirect="<?php echo base_url().'admin/cms/delete/'.$data->cms_id?>"  class="userdelete df-cursor"><i class="icon-trash new-icon-css"></i></a> -->
                    <a href="javascript:void(0)" onclick="delete_cms('<?php echo $data->cms_id;?>')" class="df-cursor"><i class="icon-trash new-icon-css"></i></a>
                </td>
            </tr>
            <?php
            $i++;
            }
            }
            else
            { ?>
            <tr><td align="center" colspan="100%"><?php echo EMPTY_TABLE; ?></td></tr>
            <?php }
            ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-3 text-left">
            <?php if ($to_records != '0') { ?>
            <b>Showing <?php echo $from_records; ?> to <?php echo $to_records; ?> of <?php echo $total_records; ?></b>
            <?php } else echo '&nbsp'; ?>
        </div>
        <div class="col-sm-9 text-right">
            <nav aria-label="Page navigation">
                <?php if (isset($pagination)) { echo $pagination; } ?>
            </nav>
        </div>
    </div>
</div>
<input type="hidden" id="pagination_url" value="<?php echo $paging_url; ?>" />
<input type="hidden" id="pagination_page" value="<?php echo $page; ?>" />
<input type="hidden" id="pagination_sort_by" value="<?php echo $sort_by; ?>" />
<input type="hidden" id="pagination_sort_direction" value="<?php echo $sort_direction; ?>" />
