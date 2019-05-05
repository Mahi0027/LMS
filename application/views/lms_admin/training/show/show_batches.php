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
            <?php
                    if($training_id){
                        if($session_id){
                ?>
                            <div style="float:right;margin: 2% 5%  5% 0%;">
                                <a href="<?php echo base_url('lmsadmin/classroom/addbatch/'.$training_id[0]['lms_training_id'].'/'.$session_id[0]['lms_sessions_id']);?>"><i class="material-icons md-color-green-300 md-24">add</i>Batch</a>   
                            </div><br><br>
                <?php
                        }
                    }    
                ?>    
                <div class="md-card-content">
                    <div class="dt_colVis_buttons"></div>
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo lang('build_session_action','action');?></th>
                                <th><?php echo lang('batch_training_name', 'training name');?></th>
                                <th><?php echo lang('batch_session_name', 'session name');?></th>
                                <th><?php echo lang('batch_name', 'batch_name');?></th>
                                <th><?php echo lang('batch_start_date', 'starting date');?></th>
                                <th><?php echo lang('batch_end_date', 'ending date');?></th>
                                <th><?php echo lang('batch_vanue', 'vanue');?></th>
                                <th><?php echo lang('batch_vandor', 'vandor');?></th>
                                <th><?php echo lang('batch_instructor', 'instructor');?></th>
                                <th><?php echo lang('batch_seat_limit', 'seat limit');?></th>
                                <th><?php echo lang('batch_seat_occupied', 'seat occupied');?></th>
                                <th><?php echo lang('batch_waiting_list', 'waiting list');?></th>
                                <th><?php echo lang('batch_created_at', 'created at');?></th>
                                <th><?php echo lang('batch_created_by', 'created by');?></th>
                                <th><?php echo lang('batch_updated_at', 'updated at');?></th>
                                <th><?php echo lang('batch_updated_by', 'updated by');?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?php echo lang('build_session_action','action');?></th>
                                <th><?php echo lang('batch_training_name', 'training name');?></th>
                                <th><?php echo lang('batch_session_name', 'session name');?></th>
                                <th><?php echo lang('batch_name', 'batch_name');?></th>
                                <th><?php echo lang('batch_start_date', 'starting date');?></th>
                                <th><?php echo lang('batch_end_date', 'ending date');?></th>
                                <th><?php echo lang('batch_vanue', 'vanue');?></th>
                                <th><?php echo lang('batch_vandor', 'vandor');?></th>
                                <th><?php echo lang('batch_instructor', 'instructor');?></th>
                                <th><?php echo lang('batch_seat_limit', 'seat limit');?></th>
                                <th><?php echo lang('batch_seat_occupied', 'seat occupied');?></th>
                                <th><?php echo lang('batch_waiting_list', 'waiting list');?></th>
                                <th><?php echo lang('batch_created_at', 'created at');?></th>
                                <th><?php echo lang('batch_created_by', 'created by');?></th>
                                <th><?php echo lang('batch_updated_at', 'updated at');?></th>
                                <th><?php echo lang('batch_updated_by', 'updated by');?></th>
                            </tr>
                        </tfoot>
                        <tbody>  
                            <?php
                                if($batch){
                                    foreach($batch as $row){
                            ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url('#')?>"><i class="md-icon material-icons md-color-black-300 md-24">&#xE872;</i>Delete</a><br>
                                            <a href="<?php echo base_url('lmsadmin/classroom/show_users/'.$training_id[0]['lms_training_id'].'/'.$session_id[0]['lms_sessions_id'].'/'.$row['lms_batch_id'])?>"><i class="md-icon material-icons md-color-black-300 md-24">person_pin</i>Add Users</a>
                                        </td>
                                        <?php
                                            if($training_id){
                                        ?>
                                                <td>&emsp;&emsp;<?php echo $training_id[0]['name'];?></td>
                                        <?php
                                            }
                                        ?>
                                        <?php
                                            if($session_id){
                                        ?>
                                                <td>&emsp;&emsp;<?php echo $session_id[0]['name'];?></td>
                                        <?php
                                            }
                                        ?>
                                        <td><?php echo $row['lms_batch_name'];?></td>
                                        <td><?php echo $row['lms_batch_start_date'];?></td>
                                        <td><?php echo $row['lms_batch_end_date'];?></td>
                                        <td><?php echo $row['lms_batch_vanue'];?></td>
                                        <td><?php echo $row['lms_batch_vandor'];?></td>
                                        <td><?php echo $row['lms_batch_instructor'];?></td>
                                        <td><?php echo $row['lms_batch_seat_limit'];?></td>
                                        <td><?php echo $row['lms_batch_seat_occupied'];?></td>
                                        <td><?php echo $row['lms_batch_waiting_list'];?></td>
                                        <td><?php echo $row['created_at'];?></td>
                                        <td><?php echo $row['created_by'];?></td>
                                        <td><?php echo $row['updated_at'];?></td>
                                        <td><?php echo $row['updated_by'];?></td>
                                    </tr>
                            <?php
                                    }
                                }
                            ?>                            
                        </tbody>
                    </table>
                </div>
            </div>


<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo lang('batch_user_name', 'user name');?></th>
                    <th><?php echo lang('batch_email', 'email id');?></th>
                    <th><?php echo lang('batch_status', 'status');?></th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    
                    <th><?php echo lang('batch_user_name', 'user name');?></th>
                    <th><?php echo lang('batch_email', 'email id');?></th>
                    <th><?php echo lang('batch_status', 'status');?></th>
                </tr>
            </tfoot>

            <tbody>
        <?php       if($user){
                        foreach($user as $row){
        ?>
                            <tr>
                                
                                <td><?php echo $row['username'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td>
                                    <?php 
                                        if($row['active']==1){
                                            echo '<i class="material-icons md-color-light-green-300 md-24"></i>';
                                            }else{
                                               echo '<i class="material-icons md-color-red-300 md-24">remove_circle</i>'; 
                                            }
                                        ?></td>
                            </tr>                
        <?php                    
                        }
                    }
        ?>      
            </tbody>
        </table>
    </div>
    
</div>
</div>
</div>

<?php
    if($training_id){
?>
    <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent md-fab-wave" href="<?php echo base_url('lmsadmin/classroom/buildsessions/'.$training_id);?>">
           <i class="material-icons">arrow_back</i>
        </a>
    </div>
<?php
    }
?>

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