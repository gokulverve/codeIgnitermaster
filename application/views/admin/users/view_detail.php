<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal cmxform">

                <div class="form-group">
                    <label class="col-md-4 control-label">
                            <span class="error"></span> First Name
                    </label>
                    <div class="col-md-6">
                        <input class="form-control input-md"  type="text" value="<?php echo (isset($user_data))?$user_data['first_name']:"";?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">
                            <span class="error"></span> Last Name
                    </label>
                    <div class="col-md-6">
                        <input name="last_name" placeholder="Enter last name" class="form-control input-md"  type="text" value="<?php echo (isset($user_data))?$user_data['last_name']:"";?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">
                            <span class="error"></span> Email Address
                    </label>
                    <div class="col-md-6">
                        <input class="form-control input-md"  type="text" value="<?php echo (isset($user_data))?$user_data['email_address']:"";?>" <?php if(isset($user_data)){ echo "readonly"; } ?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">
                            <span class="error"></span> Status
                    </label>
                    <div class="col-md-6">
                        <input class="form-control input-md"  type="text" value="<?php echo (isset($user_data))?ucfirst($user_data['status']):"";?>" <?php if(isset($user_data)){ echo "readonly"; } ?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="profile_image">
                        <span class="error"></span> Profile Image
                    </label>
                    <div class="col-md-6">
                        <?php
                        $display = "block";
                        if(isset($user_data['profile_image']) && $user_data['profile_image'] != "")
                        {
                            $file = BASE_PATH."user_image/".$user_data['profile_image'];
                            $filepath = base_url("assets/upload/user_image/".$user_data['profile_image']);
                            if(file_exists($file))
                            { 
                                $display = "none"; 
                            ?>
                            <div id="image_id">
                            <img src="<?php echo base_url("assets/upload/user_image/".$user_data['profile_image']); ?>" class="userprofilepic" Height="100px" width="100px">
                            </div>
                           <?php }
                        } ?>
                    </div>
                </div>

                

                <div class="form-group">
                    <label class="col-md-4 control-label">
                            <span class="error"></span> Birthdate
                    </label>
                    <div class="col-md-6">
                        <input class="form-control input-md"  type="text" value="<?php echo (isset($user_data))?get_formatted_date($user_data['birthdate']):"";?>" <?php if(isset($user_data)){ echo "readonly"; } ?>>
                    </div>
                </div>

                
            <div class="form-group">
                <div class="col-md-6">
                    <!-- <button type="button" class="btn btn-primary"><i class="icon-remove"></i> Close</button> -->
                </div>
            </div>
        </form>
    </div>
</section>