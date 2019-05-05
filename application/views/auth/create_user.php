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
                          <label for="firstname"> <?php echo lang('create_user_fname_label', 'first_name');?></label>
                            <?php echo form_input($first_name);?>
                      </div>
                  </div>
                  <div class="uk-width-medium-1-2">
                      <div class="parsley-row">
                          <label for="lastname"><?php echo lang('create_user_lname_label', 'last_name');?><span class="req">*</span></label>
                           <?php echo form_input($last_name);?>
                          
                      </div>
                  </div>
                  
              </div>

              <?php
                    if($identity_column!=='email') {
                        echo '<p>';
                        echo lang('create_user_identity_label', 'identity');
                        echo '<br />';
                        echo form_error('identity');
                        echo form_input($identity);
                        echo '</p>';
                    }
                 ?>

                 <div class="uk-grid">
                  <div class="uk-width-1-1">
                      <div class="parsley-row">
                          <label for="company"><?php echo lang('create_user_company_label', 'company');?></label>
                         <?php echo form_input($company);?>
                      </div>
                  </div>
              </div>

              <div class="uk-grid" data-uk-grid-margin>
                  <div class="uk-width-medium-1-1">
                      <div class="parsley-row">
                          <label for="role"> <?php echo lang('lms_role', 'role');?>
                            <span class="req">*</span></label>
                           <?php echo form_dropdown($lms_role_id);?>
                          
                      </div>
                  </div>
                </div>


                <div class="uk-grid" data-uk-grid-margin>
                  <div class="uk-width-medium-1-1">
                      <div class="parsley-row">
                          <label for="email"> <?php echo lang('create_user_email_label', 'email');?>
                            <span class="req">*</span></label>
                           <?php echo form_input($email);?>
                          
                      </div>
                  </div>
                </div>
                 <div class="uk-grid" data-uk-grid-margin>
                  <div class="uk-width-medium-1-1">
                      <div class="parsley-row">
                          <label for="phone"><?php echo lang('create_user_phone_label', 'phone');?>
                           <span class="req">*</span></label>
                           <?php echo form_input($phone);?>
                          
                      </div>
                  </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                  <div class="uk-width-medium-1-2">
                      <div class="parsley-row">
                          <label for="password"><?php echo lang('create_user_password_label', 'password');?>
                          </label>
                          <?php echo form_input($password);?>
                      </div>
                  </div>
                   <div class="uk-width-medium-1-2">
                      <div class="parsley-row">
                          <label for="password"><?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
                          </label>
                          <?php echo form_input($password_confirm);?>
                      </div>
                  </div>
                </div>
              

              <div class="uk-grid">
                  <div class="uk-width-1-1">
                       <?php echo form_submit('submit',"submit",array('class'=>'md-btn md-btn-primary'));?>
                  </div>
              </div>

            </div>
              <?php
              if(isset($id)){
                echo form_hidden('id', $id);
              }
              ?>
              <?php //echo form_hidden($csrf); ?>
          <?php echo form_close();?>
      </div>
  </div>

  </div>
</div>
 <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent md-fab-wave" href="<?php echo base_url('lmsadmin/users');?>">
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
</html>



