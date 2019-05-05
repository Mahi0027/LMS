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

   <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <div class="dt_colVis_buttons"></div>
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo lang('index_coursename_th', 'coursename');?></th>
                                <th><?php echo lang('index_description_th', 'description');?></th>
                                <th><?php echo lang('index_instruction_th', 'instruction');?></th>
                                <th><?php echo lang('index_instructor_th', 'instructor');?></th>
                                <th><?php echo lang('index_status_th', 'status');?></th>
                                <th><?php echo lang('index_cpd_point_th', 'cpd_point');?></th>
                                <th><?php echo lang('index_created_at_th', 'created at');?></th>
                                <th><?php echo lang('index_created_by_th', 'created by');?></th>
                                <th><?php echo lang('index_updated_at_th', 'updated at');?></th>
                                <th><?php echo lang('index_updted_by_th', 'updated by');?></th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th><?php echo lang('index_coursename_th', 'coursename');?></th>
                                <th><?php echo lang('index_description_th', 'description');?></th>
                                <th><?php echo lang('index_instruction_th', 'instruction');?></th>
                                <th><?php echo lang('index_instructor_th', 'instructor');?></th>
                                <th><?php echo lang('index_status_th', 'status');?></th>
                                <th><?php echo lang('index_cpd_point_th', 'cpd_point');?></th>
                                <th><?php echo lang('index_created_at_th', 'created at');?></th>
                                <th><?php echo lang('index_created_by_th', 'created by');?></th>
                                <th><?php echo lang('index_updated_at_th', 'updated at');?></th>
                                <th><?php echo lang('index_updted_by_th', 'updated by');?></th>
                            </tr>
                        </tfoot>

                        <tbody>
							<?php if($detail):
							foreach($detail as $row):
							?>
                            <tr>
                                <td><?php echo $row['feedback_name'];?></td>
                                <td><?php echo $row['description'];?></td>
                                <td><?php echo $row['instruction'];?></td>
                                <td><?php echo $row['instructor'];?></td>
                                <td><?php echo $row['status'];?></td>
                                <td><?php echo $row['cpd_points'];?></td>
                                <td><?php echo $row['created_at'];?></td>
                                <td><?php echo $row['created_by'];?></td>
                                <td><?php echo $row['updated_at'];?></td>
                                <td><?php echo $row['updated_by'];?></td>
                            </tr>
                        <?php endforeach;
												endif;
												?>
                        </tbody>
                    </table>
                </div>
            </div>
  </div>
</div>
<div class="md-fab-wrapper">
    <a class="md-fab md-fab-accent md-fab-wave" href="<?php echo base_url('lmsadmin/classroom/buildsessions/'.$training_id);?>">
       <i class="material-icons">arrow_back</i>
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
</html>