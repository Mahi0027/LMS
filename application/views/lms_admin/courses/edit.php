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
					<?php echo form_open(uri_string(),array('class'=>'uk-form-stacked'));?>
							<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-2">
											<div class="parsley-row">
													<label for="fullname"><?php echo lang('index_coursename_th', 'course_name');?><span class="req">*</span></label>
													 <?php echo form_input($course_name);?>
													
											</div>
									</div>
									<div class="uk-width-medium-1-2">
											<div class="parsley-row">
													<label for="email"><?php echo lang('create_ref_title', 'ref_title');?></label>
													<?php echo form_input($ref_title);?>
											</div>
									</div>
							</div>
								 <div class="uk-grid">
									<div class="uk-width-1-1">
											<div class="parsley-row">
													<label for="message"><?php echo lang('create_learning_objectives', 'ref_title');?></label>
													<?php echo form_textarea($learning_objectives);?>
											</div>
									</div>
							</div>
								 
							<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-2">
										 <div class="parsley-row">
													<label for="val_select" class="uk-form-label">Compliance Standard<span class="req">*</span></label>
													<?php echo form_dropdown($compliance_standard); ?>
											</div>
									</div>
									<div class="uk-width-medium-1-2">
											<div class="uk-form-row parsley-row">
													<label for="gender" class="uk-form-label">Seat Time</label>
													 <?php echo form_input($seat_time);?>
											</div>
									</div>
							</div>
								<div class="uk-grid">
									<div class="uk-width-1-1">
											<div class="parsley-row">
													<label for="message"><?php echo lang('about_course', 'about_course');?></label>
													<?php echo form_textarea($about_course);?>
											</div>
									</div>
							</div>
								
							<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-2">
											<div class="parsley-row">
													<label for="hobbies" class="uk-form-label">Rights:</label>
													<span class="icheck-inline">
															<input type="checkbox" name="val_check_hobbies" id="val_check_ski" data-md-icheck data-parsley-mincheck="2" />
															<label for="val_check_ski" class="inline-label">Read</label>
													</span>
													<span class="icheck-inline">
															<input type="checkbox" name="val_check_hobbies" id="val_check_run" data-md-icheck />
															<label for="val_check_run" class="inline-label">Edit</label>
													</span>
													<span class="icheck-inline">
															<input type="checkbox" name="val_check_hobbies" id="val_check_eat" data-md-icheck />
															<label for="val_check_eat" class="inline-label">Delete</label>
													</span>
													<span class="icheck-inline">
															<input type="checkbox" name="val_check_hobbies" id="val_check_sleep" data-md-icheck />
															<label for="val_check_sleep" class="inline-label">Upload</label>
													</span>
												
											</div>
									</div>
									<div class="uk-width-medium-1-2">
											<div class="parsley-row">
													<label for="val_select" class="uk-form-label">Instructor</label>
													<select id="val_select" required data-md-selectize>
															<option value="">Choose..</option>
															<option value="press">Press</option>
															<option value="net">Internet</option>
															<option value="mouth">Word of mouth</option>
															<option value="other">Other..</option>
													</select>
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
									<div class="uk-width-1-1">
											 <?php echo form_submit('submit',"Edit Course",array('class'=>'md-btn md-btn-primary'));?>
									</div>
							</div>
							<?php echo form_hidden('id', $lms_course_id);?>
							<?php echo form_hidden($csrf); ?>
					<?php echo form_close();?>
			</div>
	</div>
   
  </div>
</div>
 <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent md-fab-wave" href="<?php echo base_url('lmsadmin/elearning/courses');?>">
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
			$('#kUI_timepicker').kendoTimePicker();
		</script>
</body>
</html>