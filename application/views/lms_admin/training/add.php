<!DOCTYPE html>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('lms_admin/partials/header'); ?>
<div id="page_content">
  <div id="page_content_inner">
    <div class="uk-width-1-1">
      <h2><?php echo $title;?></h2>
    </div>
    <!-- statistics (small charts) -->
    <div class="uk-width-1-1">
     <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo base_url('/lmsadmin/');?>">Home</a></li>
                <li><span><?php echo $title;?></span></li>
            </ul>
        </div>
    </div>
    
    	<?php echo form_open(uri_string(),array('class'=>'uk-form-stacked'));?>
    		<div class="md-card">
				<div class="md-card-content large-padding">
					<div id="infoMessage"><?php echo $message;?></div>
						<?php echo form_open(uri_string(),array('class'=>'uk-form-stacked'));?>
						<div class="uk-grid" data-uk-grid-margin>
										<div class="uk-width-medium-1-1">
												<div class="parsley-row">
														<label for="val_select" class="uk-form-label"><?php echo lang('training_add_name', 'trainingname');?><span class="req">*</span></label>
														<?php echo form_input($name); ?>
												</div>
										</div>
										<div class="uk-width-medium-1-1">
												<div class="parsley-row">
														<label for="val_select" class="uk-form-label"><?php echo lang('training_reference_name', 'Reference Name');?></label>
														<?php echo form_input($reference_name); ?>
												</div>
										</div>
										<div class="uk-width-medium-1-1">
												<div class="parsley-row">
														<label for="val_select" class="uk-form-label"><?php echo lang('training_description', 'description');?></label>
														<?php echo form_textarea($description); ?>
												</div>
										</div>
								</div>
								<div class="uk-grid" data-uk-grid-margin>
										<div class="uk-width-medium-1-2">
												<div class="parsley-row">
														<label for="fullname"><?php echo lang('training_starting_on', 'stating date');?></label>
														 <?php echo form_input($starting_date);?>
														
												</div>
										</div>
										<div class="uk-width-medium-1-2">
												<div class="parsley-row">
														<label for="email"><?php echo lang('training_ending_on', 'ending date');?></label>
														<?php echo form_input($ending_date);?>
												</div>
										</div>
								</div>	
								<div class="uk-grid" data-uk-grid-margin>
										<div class="uk-width-medium-1-2">
												<div class="parsley-row">
														<label for="fullname"><?php echo lang('Seat_time', 'seat time');?></label>
														 <?php echo form_input($seat_time);?>
														
												</div>
										</div>
										<div class="uk-width-medium-1-2">
												<div class="parsley-row">
														<label for="email"><?php echo lang('training_duration', 'duration');?></label>
														<?php echo form_input($duration);?>
												</div>
										</div>
								</div>	
								<div class="uk-grid" data-uk-grid-margin>
										<div class="uk-width-medium-1-3">
												<div class="parsley-row">
														<label for="fullname"><?php echo lang('training_chat', 'chat');?></label>
														 <?php echo form_dropdown($chat);?>
														
												</div>
										</div>
								</div>		
								<div class="uk-grid" data-uk-grid-margin>
										<div class="uk-width-medium-1-2">
												<div class="parsley-row">
														<label for="fullname"><?php echo lang('training_cost', 'cost');?></label>
														 <?php echo form_input($cost);?>
														
												</div>
										</div>
										<div class="uk-width-medium-1-2">
											<div class="parsley-row">
												<label for="fullname"><?php echo lang('training_currency', 'currency');?></label>
												 <?php echo form_dropdown($currency);?>
											</div>
										</div>
								</div>
								<div class="uk-grid" data-uk-grid-margin>
										<div class="uk-width-medium-1-1">
												<div class="parsley-row">
														<label for="fullname"><?php echo lang('training_trainer', 'trainer');?></label>
														 <?php echo form_dropdown($trainer);?>	
												</div>
										</div>
								</div>
								<div class="uk-grid" data-uk-grid-margin>
										<div class="uk-width-medium-1-2">
												<div class="parsley-row">
														<label for="fullname"><?php echo lang('training_certification', 'certification');?></label>
														 <?php echo form_dropdown($certification);?>
														
												</div>
										</div>
										<div class="uk-width-medium-1-2">
												<div class="parsley-row">
														<label for="fullname"><?php echo lang('training_rights', 'rights');?></label>
														 <?php echo form_multiselect($rights);?>
														
												</div>
										</div>
								</div>

								<div class="uk-grid" data-uk-grid-margin>
										<div class="uk-width-medium-1-1">
												<div class="parsley-row">
														<label for="fullname"><?php echo lang('training_status_id', 'status_id');?></label>
														 <?php echo form_dropdown($status_id);?>
														
												</div>
										</div>
								</div>

				</div>
			</div>
			<div class="md-card">
				<div class="md-card-content large-padding">
					<div class="uk-grid" data-uk-grid-margin>									
						<div class="uk-width-medium-1-1" id="val_select">
							<div class="parsley-row">
								<label for="val_select" class="uk-form-label"><?php echo lang('training_type', 'type');?><span class="req">*</span></label>
								<?php echo form_dropdown($type); ?>
							</div>
						</div>
						<div class="uk-width-medium-1-1" id="image">
							<div class="parsley-row">
								<label for="val_select" class="uk-form-label"><?php echo lang('training_image', 'image');?></label>
								<?php echo form_input($image); ?>
							</div>
						</div>
						<div class="uk-width-medium-1-1" id="video">
							<div class="parsley-row">
								<label for="val_select" class="uk-form-label"><?php echo lang('training_video', 'video');?></label>
								<?php echo form_input($video); ?>
							</div>
						</div>
					</div>							
					<div class="uk-grid" data-uk-grid-margin>	
						<div class="uk-width-medium-1-1">
							<div class="parsley-row">
								<label for="fullname"><?php echo lang('training_url', 'url');?></label>
						 		<?php echo form_input($url);?>	
							</div>
						</div>		
					</div><br>
					<div class="uk-width-medium-1-1">
						<div class="parsley-row">
							<label for="fullname"><?php echo lang('training_document', 'document');?></label>
					 		<?php echo form_upload($document);?>	
						</div>
					</div><br><br><br>
					<div class="uk-grid">
						<div class="uk-width-1-1">
					    	<?php echo form_submit('submit',"Submit",array('class'=>'md-btn md-btn-primary'));?>
						</div>
					</div>
				</div>
			</div>
				<?php
				if(isset($lms_video_id)){
					echo form_hidden('id', $lms_video_id);
				}
				?>
				<?php echo form_hidden($csrf); ?>
		<?php echo form_close();?>
    
		
   
  </div>
</div>
 <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent md-fab-wave" href="<?php echo base_url('lmsadmin/training');?>">
           <i class="material-icons">
arrow_back
</i>
        </a>
    </div>
<!-- common functions -->
<script src="<?php echo base_url('assets/lms-admin/assets/js/common.min.js');?>"></script>
<!-- uikit functions -->
<script src="<?php echo base_url('assets/lms-admin/assets/js/uikit_custom.min.js');?>"></script>
<!-- altair common functions/helpers -->
<script src="<?php echo base_url('assets/lms-admin/assets/js/altair_admin_common.min.js');?>"></script>

<!-- page specific plugins -->
    <!-- datatables -->
    <script src="<?php echo base_url('assets/lms-admin/bower_components/datatables/media/js/jquery.dataTables.min.js');?>"></script>
    <!-- datatables buttons-->
    <script src="<?php echo base_url('assets/lms-admin/bower_components/datatables-buttons/js/dataTables.buttons.js');?>"></script>
    <script src="<?php echo base_url('assets/lms-admin/assets/js/custom/datatables/buttons.uikit.js');?>"></script>
    <script src="<?php echo base_url('assets/lms-admin/bower_components/jszip/dist/jszip.min.js');?>"></script>
    <script src="<?php echo base_url('assets/lms-admin/bower_components/pdfmake/build/pdfmake.min.js');?>"></script>
    <script src="<?php echo base_url('assets/lms-admin/bower_components/pdfmake/build/vfs_fonts.js');?>"></script>
    <script src="<?php echo base_url('assets/lms-admin/bower_components/datatables-buttons/js/buttons.colVis.js');?>"></script>
    <script src="<?php echo base_url('assets/lms-admin/bower_components/datatables-buttons/js/buttons.html5.js');?>"></script>
    <script src="<?php echo base_url('assets/lms-admin/bower_components/datatables-buttons/js/buttons.print.js');?>"></script>

    <!-- datatables custom integration -->
    <script src="<?php echo base_url('assets/lms-admin/assets/js/custom/datatables/datatables.uikit.min.js');?>"></script>

    <!--  datatables functions -->
    <script src="<?php echo base_url('assets/lms-admin/assets/js/pages/plugins_datatables.min.js');?>"></script>
		
		
		  <!-- kendo UI -->
    <script src="<?php echo base_url('assets/lms-admin/assets/js/kendoui_custom.min.js');?>"></script>

    <!--  kendoui functions -->
    <script src="<?php echo base_url('assets/lms-admin/assets/js/pages/kendoui.min.js');?>"></script>
		
		<script>
			$(#kUI_datetimepicker_basic).kendoDateTimePicker();
		</script>
</body>

<script>
	//$(#kUI_datetimepicker_basic).kendoDateTimePicker();
	$("#image").hide();
	$("#video").hide();
	$("#val_select").change(
		function(){
			
			var type=$(this).val();
			if(type=='1'){
				$("#image").show();
				$("#video").hide();
			}
			else{
				$("#image").hide();
				$("#video").show();
			}

		}

		);

    $("#starting_date").kendoDatePicker({
        format: "dd-MM-yyyy"
    });

    $("#ending_date").kendoDatePicker({
        format: "dd-MM-yyyy"
    });

    $("#seat_time").kendoTimePicker({
        format: "hh:mm:ss"
    });


</script>
</html>