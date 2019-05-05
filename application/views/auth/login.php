<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
    <meta name="msapplication-tap-highlight" content="no"/>
    <title>Challenging Horizons</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/bower_components/uikit/css/uikit.almost-flat.min.css');?>"/>  
    <link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/assets/css/login_page.min.css');?>" />
</head>
<body class="login_page">

    <div class="login_page_wrapper">
        <div class="md-card" id="login_card">
            <div class="md-card-content large-padding" id="login_form">
                <div class="login_heading">
                    <div class="user_avatar"></div>
                </div>
								<div id="infoMessage"><?php echo $message;?></div>
                <?php echo form_open("auth/login");?>
                    <div class="uk-form-row">
                       <?php echo lang('login_identity_label', 'identity');?>
                        <?php echo form_input($identity);?>
                    </div>
                    <div class="uk-form-row">
                       <?php echo lang('login_password_label', 'password');?>
                       <?php echo form_input($password);?>
                    </div>
                    <div class="uk-margin-medium-top">
											<?php echo form_submit('submit', lang('login_submit_btn'),array('class'=>'md-btn md-btn-primary md-btn-block md-btn-large'));?>
                        
                    </div>
                  
                    <div class="uk-margin-top">
                        <span class="icheck-inline">
													 <?php echo lang('login_remember_label', 'remember');?>
                          <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
                           
                        </span>
                    </div>
               <?php echo form_close();?>
            </div>
        </div>
    </div>
   
</body>
</html>