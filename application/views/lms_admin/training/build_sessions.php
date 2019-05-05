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
                <?php
                    if($training_name){
                ?>
                <li><span><?php echo $training_name;?></span></li>
                <?php  
                  }
                ?>
            </ul>
        </div>
    </div>

   <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <div style="float:right;">
                        <a href="<?php echo base_url('lmsadmin/elearning/build_session_course/'.$url)?>"><i class="material-icons md-color-green-300 md-24">add</i>Courses&emsp;</a>
                        <a href="<?php echo base_url('lmsadmin/elearning/build_session_session/'.$url)?>"><i class="material-icons md-color-green-300 md-24">add</i>Sessions&emsp;</a>
                        <a href="<?php echo base_url('lmsadmin/elearning/build_session_video/'.$url)?>"><i class="material-icons md-color-green-300 md-24">add</i>Videos&emsp;</a>
                        <a href="<?php echo base_url('lmsadmin/elearning/build_session_assignment/'.$url)?>"><i class="material-icons md-color-green-300 md-24">add</i>Assignments&emsp;</a>
                        <a href="<?php echo base_url('lmsadmin/elearning/build_session_feedback/'.$url)?>"><i class="material-icons md-color-green-300 md-24">add</i>Feedback&emsp;</a>   
                    </div><br><br>
                    <div class="dt_colVis_buttons"></div>
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?php echo lang('build_sessions_name', 'name');?></th>
                            <th><?php echo lang('build_sessions_type', 'desc');?></th>
                            <th><?php echo lang('build_session_status', 'status');?></th>
                            <th><?php echo lang('build_session_instructor', 'instructor');?></th>
                            <th><?php echo lang('build_session_action','action');?></th>
                        </tr>
                        </thead>

                        <tfoot>
                        <tr>
                            <th><?php echo lang('build_sessions_name', 'name');?></th>
                            <th><?php echo lang('build_sessions_type', 'desc');?></th>
                            <th><?php echo lang('build_session_status', 'status');?></th>
                            <th><?php echo lang('build_session_instructor', 'instructor');?></th>
                            <th><?php echo lang('build_session_action','action');?></th>
                        </tr>
                        </tr>
                        </tfoot>

                        <tbody>
							<?php 
                                if($courses){
                                    foreach($courses as $row){
                            ?>
                                        <tr>
                                            <td><?php echo $row['name'];?></td>
                                            <td><?php echo lang('build_session_course','course')?></td>
                                            
                                            <td>
                                                <?php if($row['status_id']==1){
                                                    echo '&ensp;<i class="material-icons md-color-light-blue-600 md-24"></i>';
                                                    }else{
                                                       echo '&ensp;<i class="material-icons md-color-red-300 md-24">remove_circle</i>'; 
                                                    }
                                                ?>
                                            </td>
                                            <td></td>
                                            <td><a href="javascript:void(0)"  onclick="UIkit.modal.confirm('Are you sure?', function(){ UIkit.modal.alert('Confirmed!'); });"><i class="md-icon material-icons">&#xE872;</i></a>
                                                <?php
                                                    if($training_id){
                                                ?>
                                                <a href="<?php echo base_url('lmsadmin/classroom/show_course/'.$training_id.'/'.$row['lms_course_id']);?>"><?php echo '&ensp;<i class="md-icon material-icons md-color-light-grey-600 md-24">visibility</i>'?></a></td>
                                                <?php
                                                    }
                                                ?>
                                        </tr>
                            <?php        
                                    }
                                }
                                if($video){
                                    foreach($video as $row){
                            ?>
                                        <tr>
                                            <td><?php echo $row['name'];?></td>
                                            <td><?php echo lang('build_session_video','video')?></td>
                                            
                                            <td>
                                                <?php if($row['status_id']==1){
                                                    echo '&ensp;<i class="material-icons md-color-light-blue-600 md-24"></i>';
                                                    }else{
                                                       echo '&ensp;<i class="material-icons md-color-red-300 md-24">remove_circle</i>'; 
                                                    }
                                                ?>
                                            </td>
                                            <td></td>
                                            <td><a href="javascript:void(0)"  onclick="UIkit.modal.confirm('Are you sure?', function(){ UIkit.modal.alert('Confirmed!'); });"><i class="md-icon material-icons">&#xE872;</i></a> <a href="<?php echo base_url('lmsadmin/classroom/show_video/'.$training_id.'/'.$row['lms_video_id']);?>"><?php echo '&ensp;<i class="md-icon material-icons md-color-light-grey-600 md-24">visibility</i>'?></a></td>
                                        </tr>
                            <?php        
                                    }
                                }
                                if($assignment){
                                    foreach($assignment as $row){
                            ?>
                                        <tr>
                                            <td><?php echo $row['name'];?></td>
                                            <td><?php echo lang('build_session_assignment','assignment')?></td>
                                            
                                            <td>
                                                <?php if($row['status_id']==1){
                                                    echo '&ensp;<i class="material-icons md-color-light-blue-600 md-24"></i>';
                                                    }else{
                                                       echo '&ensp;<i class="material-icons md-color-red-300 md-24">remove_circle</i>'; 
                                                    }
                                                ?>
                                            </td>
                                            <td></td>
                                            <td><a href="javascript:void(0)"  onclick="UIkit.modal.confirm('Are you sure?', function(){ UIkit.modal.alert('Confirmed!'); });"><i class="md-icon material-icons">&#xE872;</i></a> <a href="<?php echo base_url('lmsadmin/classroom/show_assignment/'.$training_id.'/'.$row['lms_assignment_id']);?>"><?php echo '&ensp;<i class="md-icon material-icons md-color-light-grey-600 md-24">visibility</i>'?></a></td>
                                        </tr>
                            <?php        
                                    }
                                }
                                if($session){
                                    foreach($session as $row){
                            ?>
                                        <tr>
                                            <td><?php echo $row['name'];?></td>
                                            <td><?php echo lang('build_session_session','session')?></td>
                                            
                                            <td>
                                                <?php if($row['status_id']==1){
                                                    echo '&ensp;<i class="material-icons md-color-light-blue-600 md-24"></i>';
                                                    }else{
                                                       echo '&ensp;<i class="material-icons md-color-red-300 md-24">remove_circle</i>'; 
                                                    }
                                                ?>
                                            </td>
                                            <td></td>
                                            <td><a href="javascript:void(0)"  onclick="UIkit.modal.confirm('Are you sure?', function(){ UIkit.modal.alert('Confirmed!'); });"><i class="md-icon material-icons">&#xE872;    </i></a>
                                                <a href="<?php echo base_url('lmsadmin/classroom/show_session/'.$training_id.'/'.$row['lms_sessions_id']);?>"><?php echo '&ensp;<i class="md-icon material-icons md-color-light-grey-600 md-24">visibility</i>'?></a>
                            <?php
                                            if($url){
                            ?>
                                                <a href="<?php echo base_url('lmsadmin/classroom/show_batch/'.$url.'/'.$row['lms_sessions_id'])?>">&ensp;<i class="md-icon material-icons md-color-black-300 md-24">settings</i></a>
                            <?php
                                            }
                            ?>
                                                
                                            </td>
                                        </tr>
                            <?php        
                                    }
                                }
                                if($feedback){
                                    foreach($feedback as $row){
                            ?>
                                        <tr>
                                            <td><?php echo $row['feedback_name'];?></td>
                                            <td><?php echo lang('build_session_feedback','feedback')?></td>
                                            
                                            <td>
                                                <?php if($row['status']==1){
                                                    echo '&ensp;<i class="material-icons md-color-light-blue-600 md-24"></i>';
                                                    }else{
                                                       echo '&ensp;<i class="material-icons md-color-red-300 md-24">remove_circle</i>'; 
                                                    }
                                                ?>
                                            </td>
                                            <td></td>
                                            <td><a href="javascript:void(0)"  onclick="UIkit.modal.confirm('Are you sure?', function(){ UIkit.modal.alert('Confirmed!'); });"><i class="md-icon material-icons">&#xE872;</i></a>
                                                <a href="<?php echo base_url('lmsadmin/classroom/show_feedback/'.$training_id.'/'.$row['lms_feedback_id']);?>"><?php echo '&ensp;<i class="md-icon material-icons md-color-light-grey-600 md-24">visibility</i>'?></a></td>
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
<div class="md-fab-wrapper">
    <a class="md-fab md-fab-accent md-fab-wave" href="<?php echo base_url('lmsadmin/training');?>">
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