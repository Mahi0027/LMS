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
													<label for="fullname"><?php echo lang('index_name', 'name');?><span class="req">*</span></label>
													 <?php echo form_input($name);?>
													
											</div>
									</div>
							</div>
								 <div class="uk-grid">
									<div class="uk-width-1-1">
											<div class="parsley-row">
													<label for="message"><?php echo lang('index_description', 'index_description');?></label>
													<?php echo form_textarea($description);?>
											</div>
									</div>
							</div>


							<div class="uk-grid">
								<div class="uk-width-medium-1-1">
											<div class="uk-width-medium-1-2">
											 	<div class="parsley-row">
													<label for="val_select" class="uk-form-label">Type<span class="req">*</span></label>
													<?php echo form_dropdown($type); ?>
												</div>
									</div>
								</div>
							</div>

							

							<div class="uk-grid" id="urltype">
								<div class="uk-width-medium-1-1">
											<div class="uk-width-medium-1-2">
											 	<div class="parsley-row">
													<label for="fullname"><?php echo lang('index_url', 'url');?><span class="req">*</span></label>
														<?php echo form_input($url);?>
												</div>
									</div>
								</div>
							</div>

							<div class="uk-grid" id="doc_type">
								<div class="uk-width-medium-1-1">
											<div class="uk-width-medium-1-2">
											 	<div class="parsley-row">
													<label for="fullname"><span class="req">*</span></label>
													 	<?php echo form_input($document);?>
												</div>
									</div>
								</div>
							</div>

							<div class="uk-grid">
								<div class="uk-width-medium-1-1">
											<div class="uk-width-medium-1-2">
											 	<div class="parsley-row">
													<label for="val_select" class="uk-form-label">Instructor<span class="req">*</span></label>
													<?php echo form_dropdown($instructor); ?>
												</div>
									</div>
								</div>
							</div>

							<div class="uk-grid">
									<div class="uk-width-1-1">
											<div class="parsley-row">
													<label for="message"><?php echo lang('index_cpd_points', 'cpd_points');?></label>
													<?php echo form_input($cpd_points);?>
											</div>
									</div>
							</div>


							<div class="uk-grid" data-uk-grid-margin>									
									<div class="uk-width-medium-1-1">
											<div class="parsley-row">
													<label for="val_select" class="uk-form-label"><?php echo lang('index_status', 'status');?><span class="req">*</span></label>
													 <?php echo form_dropdown($status); ?>
											</div>
									</div>
							</div>	

							<div class="uk-grid">
									<div class="uk-width-1-1">
											 <?php echo form_submit('submit',"Submit",array('class'=>'md-btn md-btn-primary'));?>
									</div>
							</div>
							<?php
							if(isset($reference_id)){
								echo form_hidden('id', $reference_id);
							}
							?>
							<?php echo form_hidden($csrf); ?>
					<?php echo form_close();?>
			</div>
	</div>
   
  </div>
</div>
 <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent md-fab-wave" href="<?php echo base_url('lmsadmin/elearning/reference_material');?>">
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
			//$(#kUI_datetimepicker_basic).kendoDateTimePicker();
			$("#doc_type").hide();
			$("#urltype").hide();
			$("#val_select").change(
				function(){
					
					var type=$(this).val();
					if(type=='u'){
						$("#urltype").show();
						$("#doc_type").hide();
					}
					else{
						$("#urltype").hide();
						$("#doc_type").show();
					}

				}

				);


		</script>
</body>
</html>