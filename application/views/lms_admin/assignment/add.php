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
		<div class="md-card">
			<div class="md-card-content large-padding">
				<div id="infoMessage"><?php echo $message;?></div>
					<?php echo form_open(uri_string(),array('class'=>'uk-form-stacked','enctype'=>"multipart/form-data"));?>
							<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-1">
											<div class="parsley-row">
													<label for="fullname"><?php echo lang('index_assign_name_th', 'name');?><span class="req">*</span></label>
													 <?php echo form_input($name);?>
													
											</div>
									</div>
							</div>
							<div class="uk-grid">
									<div class="uk-width-1-1">
											<div class="parsley-row">
													<label for="message"><?php echo lang('index_desc_th', 'desc');?></label>
													<?php echo form_textarea($description);?>
											</div>
									</div>
							</div>
								 <div class="uk-grid">
									<div class="uk-width-1-1">
											<div class="parsley-row">
													<label for="message"><?php echo lang('assign_duration_th', 'duration');?></label>
													<?php echo form_input($duration);?>
											</div>
									</div>
							</div>
								 
							<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-2">
										 <div class="parsley-row">
													<label for="val_select" class="uk-form-label"><?php echo lang('index_max_score', 'max');?><span class="req">*</span></label>
													<?php echo form_input($score_max); ?>
											</div>
									</div>
									<div class="uk-width-medium-1-2">
											<div class="parsley-row">
													<label for="val_select" class="uk-form-label"><?php echo lang('assign_passing_th', 'type');?></label>
													<?php echo form_input($passing); ?>
											</div>
									</div>
							</div>
								
								
						
							<div class="uk-grid">
									<div class="uk-width-1-1">
											<div class="parsley-row">
													<label for="message"><?php echo lang('assign_instructions_th', 'desc');?></label>
													<?php echo form_textarea($instructions);?>
											</div>
									</div>
							</div>

							<div class="uk-grid">
									<div class="uk-width-1-1">
											<div class="parsley-row">
													<label for="message"><?php echo lang('document');?></label>
													 <?php  echo form_upload($document);?>
											</div>
									</div>
							</div>

							<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-2">
											 <div class="parsley-row">
												<label for="fullname"><?php echo lang('create_cpd_points', 'cpd_points');?></label>
													 <?php echo form_input($cpd_points);?>
													
											</div>
										</div>		
									<div class="uk-width-medium-1-2">
											<div class="parsley-row">
													<label for="val_select" class="uk-form-label"><?php echo lang('def_status', 'status');?><span class="req">*</span></label>
													 <?php echo form_dropdown($status); ?>
											</div>
									</div>
							</div>
						
							<div class="uk-grid">
									
								<?php
									if($iddd){
								?>
									<div class="uk-width-1-1">
											 <?php echo form_submit('submit',"Edit Assignment",array('class'=>'md-btn md-btn-primary'));?>
									</div>
								<?php		
									}else{
								?>
									<div class="uk-width-1-1">
											 <?php echo form_submit('submit',"Add Assignment",array('class'=>'md-btn md-btn-primary'));?>
									</div>
								<?php
									}
								?>

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
   
  </div>
</div>
 <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent md-fab-wave" href="<?php echo base_url('lmsadmin/elearning/assignments');?>">
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
		
			//$("#score_max").kendoNumericTextBox({format: "3",});
			//$("#passing").kendoNumericTextBox();
			$("#duration").kendoNumericTextBox({
				format: "# Day"
			});
		</script>
</body>
</html>