<div class="table-responsive" id="respose">
    <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%">
        <thead>
            <tr>
                <!--<th><input type="checkbox" name="selectall" id="selectall"></th>-->
                <th>No</th>
                <th>Profile Image</th>
                <th <?php
                    if($sort_by=='first_name' && $sort_direction == 'desc')
                    {
                    echo 'sort_direction= "asc" class="sorting_link sorting_desc"';
                    }
                    else if($sort_by=='first_name' && $sort_direction == 'asc')
                    {
                    echo 'sort_direction= "desc" class="sorting_link sorting_asc"';
                    }
                    else
                    {
                    echo 'sort_direction= "asc" class="sorting_link sorting"';
                    }
                ?> sort_by="first_name">Name</th>
                <th <?php
                    if($sort_by=='email_address' && $sort_direction == 'desc')
                    {
                    echo 'sort_direction= "asc" class="sorting_link sorting_desc"';
                    }
                    else if($sort_by=='email_address' && $sort_direction == 'asc')
                    {
                    echo 'sort_direction= "desc" class="sorting_link sorting_asc"';
                    }
                    else
                    {
                    echo 'sort_direction= "asc" class="sorting_link sorting"';
                    }
                ?> sort_by="email_address">Email</th>
                <th <?php
                    if($sort_by=='status' && $sort_direction == 'desc')
                    {
                    echo 'sort_direction= "asc" class="sorting_link sorting_desc"';
                    }
                    else if($sort_by=='status' && $sort_direction == 'asc')
                    {
                    echo 'sort_direction= "desc" class="sorting_link sorting_asc"';
                    }
                    else
                    {
                    echo 'sort_direction= "asc" class="sorting_link sorting"';
                    }
                ?> sort_by="status">Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($users) > 0)
            {
            foreach($users as $data)
            {
            if($data['profile_image'] != "" && @getimagesize('./assets/upload/user_image/'.$data['profile_image']) > 0)
            {
            $img = '<img src="'.base_url("assets/upload/user_image/".$data['profile_image']).'" name="profile" class="userprofilepic" height="100px" width="100px">';
            }
            else
            {
            $img = '<img src="'.base_url().'assets/upload/no-image.jpg" name="profile" class="userprofilepic">';
            }
            ?>
            <tr>
                <td><?php echo $i?></td>
                <td><?php echo $img?></td>
                <td><?php echo $data['first_name']." ".$data['last_name']?></td>
                <td><?php echo $data['email_address']?></td>
                <!-- <td><?php echo ucfirst($data['status'])?></td> -->
                <td><a data-userid="<?=$data['user_id']?>" class="df-cursor changestatus <?=($data['status'] == "1" ? "textred" : "textgreen")?>" id="userchangestatus<?=$i?>" data-url="users/changestatus"><?=($data['status'] == "1" ? "Active" : "Inactive")?></a><input type="hidden" name="ustatus" id="ustatus" value="<?=$data['status']?>"></td>
                <td>
                    <a title="view detail" href="javascript:void(0)" class="df-cursor" onclick="view_detail('<?php echo $data['user_id'];?>')"><i class="icon-file-text new-icon-css pd-right"></i></a>
                    <a title="Edit" href="<?php echo base_url().'admin/users/add_edit_user/'.base_id($data['user_id'])?>" class="df-cursor"><i class="icon-edit new-icon-css pd-right"></i></a>
                    <a title="Delete" href="javascript:void(0)" onclick="delete_record('<?php echo $data['user_id'];?>')" class="df-cursor"><i class="icon-trash new-icon-css"></i></a>
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
<script> $("body").on("click", ".changestatus", function (event) {

            var uId = $(this).attr('id');



            var type = $(this).data('url').split('/');

            var typeName = type[0].charAt(0).toUpperCase() + type[0].slice(1);



            $.ajax({

                type: "POST",

                url: base_url + $(this).data('url'),

                data: {"id": $(this).data('userid'), "status": $("#" + uId).next().val()},

                success: function (data) {

                    var response = JSON.parse(data);

                    $("#" + uId).next().val(response.statusval); 

                    $("#" + uId).text(response.statustext);

                    if(response.statusval == 1)

                    {

                        $("#" + uId).removeClass("textgreen").addClass("textred");

                    }

                    else

                    {

                        $("#" + uId).removeClass("textred").addClass("textgreen"); 

                    }

                    

                    $.gritter.add({

                        // (string | mandatory) the heading of the notification

                        title: 'Success!!!',

                        // (string | mandatory) the text inside the notification

                        text: typeName + ' ' + response.statustext + ' Successfully.',

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

                },

            });

        });</script>