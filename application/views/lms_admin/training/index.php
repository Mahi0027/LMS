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
		<div id="infoMessage"><?php echo $message;?></div>
    <!-- statistics (small charts) -->
    <div class="uk-width-1-1">
     <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo base_url('/lmsadmin/');?>">Home</a></li>
                <li><span><?php echo $title;?></span></li>
            </ul>
        </div>
    </div>
    <?php
        if($training_categories){
            foreach($training_categories as $row){
    ?>
                <div class="md-card uk-margin-medium-bottom">
                    <div class="md-card-content">
                        <div>
                            <div style="float: left;"><h3><?php echo $row['name'];?></h3></div>
                            <div style="float: right;"><a href="<?php echo base_url('lmsadmin/classroom/buildsessions/'.$row['lms_training_id'])?>"><i class="material-icons md-color-black-300 md-24">settings</i></a></div>   
                        </div><br><br><br>
                       &emsp;&emsp;&emsp;<b>Start Date</b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                       <b>End Date</b><br>
                       &emsp;&emsp;&emsp;<i><?php echo $row['start_date'];?></i>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&emsp;&emsp;
                       <i><?php echo $row['end_date'];?></i><br>
                    </div>
                   <!-- <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?php echo lang('training_curriculum_id', 'id');?></th>
                            <th><?php echo lang('Training_curriculum_types', 'course_type');?></th>                            
                            <th><?php echo lang('Training_curriculum_type_name','name');?></th>
                            <th><?php echo lang('Training_curriculum_instructor','instructor');?></th>
                            <th><?php echo lang('Training_curriculum_status','status');?></th>
                            <th><?php echo lang('Training_curriculum_action','action');?></th>
                        </tr>
                        </thead>

                        <tfoot>
                        <tr>
                           <th><?php echo lang('training_curriculum_id', 'id');?></th>
                            <th><?php echo lang('Training_curriculum_types', 'course_type');?></th>                            
                            <th><?php echo lang('Training_curriculum_type_name','name');?></th>
                            <th><?php echo lang('Training_curriculum_instructor','instructor');?></th>
                            <th><?php echo lang('Training_curriculum_status','status');?></th>
                            <th><?php echo lang('Training_curriculum_action','action');?></th>
                        </tr>
                        </tr>
                        </tfoot>

                        <tbody>                        
                        </tbody>
                    </table> -->
                </div>
    <?php
        }
    }
    ?>
  </div>
</div>
 <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent md-fab-wave" href="<?php echo base_url('lmsadmin/classroom/addtraining');?>">
            <i class="material-icons">&#xE145;</i>
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
</body>
</script>
</html>