<div class="page-header container">
  <h1><small>Application Configuration</small></h1>
</div>
    <div class="container">
       <?php 
		$addact=array('class'=>'form-horizontal');
		echo form_open_multipart('admin/home/settings',$addact);
		?>
        <!-- Text input-->
        <?php if($this->session->flashdata('message') != "") { ?>
        <div class="alert alert-success col-md-5 col-md-offset-4">
          <?php echo $this->session->flashdata('message'); ?>
        </div>
        <?php } ?>
        <?php foreach($data as $record) { ?>
        <div class="form-group">
          <label class="col-md-4 control-label" for="setting_name"><?php echo $record->setting_name?></label>  
          <div class="col-md-5">
          <input id="setting_value" name="<?php echo $record->setting_id?>" placeholder="Enter Service Name" class="form-control input-md" type="text" required="" value="<?php echo $record->setting_value?>">
          <span class="help-block"><?php echo form_error('setting_value'); ?></span>
          </div>
        </div>
        <?php } ?>
        <!-- Button (Double) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="Add"></label>
          <div class="col-md-8">
            <button type="submit" id="Edit" name="Edit" class="btn btn-success">Save</button>
            <button type="button" id="Cancle" name="Cancle" class="btn btn-danger" onclick='javascript:window.location.assign("settings");'>Reset</button>
          </div>
        </div>
        <?php echo form_close(); ?>
        
        
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body form" id="userview"></div>
            </div>
          </div>
        </div>
    </div><!-- /.container -->
     <hr>