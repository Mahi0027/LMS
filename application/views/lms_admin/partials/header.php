<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_PARSE);
?><!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en">
<!--<![endif]-->

<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Remove Tap Highlight on Windows Phone IE -->
<meta name="msapplication-tap-highlight" content="no"/>
<title>Challenging Horizons</title>

<!-- additional styles for plugins -->
<!-- weather icons -->
<link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/bower_components/weather-icons/css/weather-icons.min.css');?>" media="all">
<!-- metrics graphics (charts) -->
<link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/bower_components/metrics-graphics/dist/metricsgraphics.css');?>">
<!-- chartist -->
<link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/bower_components/chartist/dist/chartist.min.css');?>">

<!-- uikit -->
<link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/bower_components/uikit/css/uikit.almost-flat.min.css');?>" media="all">

<!-- flag icons -->
<link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/assets/icons/flags/flags.min.css');?>" media="all">

<!-- style switcher -->
<link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/assets/css/style_switcher.min.css');?>" media="all">

<!-- altair admin -->
<link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/assets/css/main.min.css');?>" media="all">

<!-- themes -->
<link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/assets/css/themes/themes_combined.min.css');?>" media="all">

<!-- matchMedia polyfill for testing media queries in JS -->
<!--[if lte IE 9]>
        <script type="text/javascript" src="<?php echo base_url('assets/lms-admin/bower_components/matchMedia/matchMedia.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/lms-admin/bower_components/matchMedia/matchMedia.addListener.js');?>"></script>
        <link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/assets/css/ie.css');?>" media="all">
    <![endif]-->


 <link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/bower_components/kendo-ui/styles/kendo.common-material.min.css');?>" media="all">
 <link rel="stylesheet" href="<?php echo base_url('assets/lms-admin/bower_components/kendo-ui/styles/kendo.material.min.css');?>" media="all">
</head>
<body class=" sidebar_main_open sidebar_main_swipe">
<!-- main header -->
<header id="header_main">
  <div class="header_main_content">
    <nav class="uk-navbar"> <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left"> <span class="sSwitchIcon"></span> </a> <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check"> <span class="sSwitchIcon"></span> </a>
      <div class="uk-navbar-flip">
        <ul class="uk-navbar-nav user_actions">
          <li><a href="#" id="full_screen_toggle" class="user_action_icon uk-visible-large"><i class="material-icons md-24 md-light">&#xE5D0;</i></a></li>
          <li><a href="#" id="main_search_btn" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE8B6;</i></a></li>
          <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}"> <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE7F4;</i><span class="uk-badge">16</span></a>
            <div class="uk-dropdown uk-dropdown-xlarge">
              <div class="md-card-content">
                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                  <li class="uk-width-1-2 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Messages (12)</a></li>
                  <li class="uk-width-1-2"><a href="#" class="js-uk-prevent uk-text-small">Alerts (4)</a></li>
                </ul>
                <ul id="header_alerts" class="uk-switcher uk-margin">
                  <li>
                    <ul class="md-list md-list-addon">
                      <li>
                        <div class="md-list-addon-element"> <span class="md-user-letters md-bg-cyan">rm</span> </div>
                        <div class="md-list-content"> <span class="md-list-heading"><a href="#">Vel eum.</a></span> <span class="uk-text-small uk-text-muted">Est eum architecto sit repellendus architecto perspiciatis necessitatibus ullam mollitia doloremque.</span> </div>
                      </li>
                      <li>
                        <div class="md-list-addon-element"> <img class="md-user-image md-list-addon-avatar" src="<?php echo base_url('assets/lms-admin/assets/img/avatars/avatar_07_tn.png');?>" alt=""/> </div>
                        <div class="md-list-content"> <span class="md-list-heading"><a href="#">Delectus et exercitationem.</a></span> <span class="uk-text-small uk-text-muted">Excepturi aut consectetur non minima consequuntur nesciunt.</span> </div>
                      </li>
                      <li>
                        <div class="md-list-addon-element"> <span class="md-user-letters md-bg-light-green">hi</span> </div>
                        <div class="md-list-content"> <span class="md-list-heading"><a href="#">Laborum qui eum.</a></span> <span class="uk-text-small uk-text-muted">Cum qui nulla corrupti autem eligendi facilis aut omnis qui.</span> </div>
                      </li>
                      <li>
                        <div class="md-list-addon-element"> <img class="md-user-image md-list-addon-avatar" src="<?php echo base_url('assets/lms-admin/assets/img/avatars/avatar_02_tn.png');?>" alt=""/> </div>
                        <div class="md-list-content"> <span class="md-list-heading"><a href="#">Nostrum ratione.</a></span> <span class="uk-text-small uk-text-muted">Et asperiores et ad odio dolorem.</span> </div>
                      </li>
                      <li>
                        <div class="md-list-addon-element"> <img class="md-user-image md-list-addon-avatar" src="<?php echo base_url('assets/lms-admin/assets/img/avatars/avatar_09_tn.png');?>" alt=""/> </div>
                        <div class="md-list-content"> <span class="md-list-heading"><a href="#">Sint omnis laboriosam.</a></span> <span class="uk-text-small uk-text-muted">Et sapiente sint quo aspernatur culpa magnam.</span> </div>
                      </li>
                    </ul>
                    <div class="uk-text-center uk-margin-top uk-margin-small-bottom"> <a href="#" class="md-btn md-btn-flat md-btn-flat-primary js-uk-prevent">Show All</a> </div>
                  </li>
                  <li>
                    <ul class="md-list md-list-addon">
                      <li>
                        <div class="md-list-addon-element"> <i class="md-list-addon-icon material-icons uk-text-warning">&#xE8B2;</i> </div>
                        <div class="md-list-content"> <span class="md-list-heading">Nesciunt nostrum neque.</span> <span class="uk-text-small uk-text-muted uk-text-truncate">Magni illo est ratione nam sint officia.</span> </div>
                      </li>
                      <li>
                        <div class="md-list-addon-element"> <i class="md-list-addon-icon material-icons uk-text-success">&#xE88F;</i> </div>
                        <div class="md-list-content"> <span class="md-list-heading">Cumque saepe.</span> <span class="uk-text-small uk-text-muted uk-text-truncate">Ut sint sint nihil ut eos dolor harum.</span> </div>
                      </li>
                      <li>
                        <div class="md-list-addon-element"> <i class="md-list-addon-icon material-icons uk-text-danger">&#xE001;</i> </div>
                        <div class="md-list-content"> <span class="md-list-heading">Maxime error.</span> <span class="uk-text-small uk-text-muted uk-text-truncate">Voluptate ipsa aut consectetur qui.</span> </div>
                      </li>
                      <li>
                        <div class="md-list-addon-element"> <i class="md-list-addon-icon material-icons uk-text-primary">&#xE8FD;</i> </div>
                        <div class="md-list-content"> <span class="md-list-heading">Ut nesciunt.</span> <span class="uk-text-small uk-text-muted uk-text-truncate">Nemo est culpa aut ea est delectus et.</span> </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </li>
          <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}"> <a href="#" class="user_action_image"><img class="md-user-image" src="<?php echo base_url('assets/lms-admin/assets/img/avatars/avatar_11_tn.png');?>" alt=""/></a>
            <div class="uk-dropdown uk-dropdown-small">
              <ul class="uk-nav js-uk-prevent">
                <li><a href="page_user_profile.html">My profile</a></li>
                <li><a href="page_settings.html">Settings</a></li>
                <li><a href="<?php echo base_url('auth/logout');?>">Logout</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </div>
  <div class="header_main_search_form"> <i class="md-icon header_main_search_close material-icons">&#xE5CD;</i>
    <form class="uk-form uk-autocomplete" data-uk-autocomplete="{source:'data/search_data.json'}">
      <input type="text" class="header_main_search_input" />
      <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons">&#xE8B6;</i></button>
      <script type="text/autocomplete">
                    <ul class="uk-nav uk-nav-autocomplete uk-autocomplete-results">
                        {{~items}}
                        <li data-value="{{ $item.value }}">
                            <a href="{{ $item.url }}" class="needsclick">
                                {{ $item.value }}<br>
                                <span class="uk-text-muted uk-text-small">{{{ $item.text }}}</span>
                            </a>
                        </li>
                        {{/items}}
                    </ul>
                </script>
    </form>
  </div>
</header>
<aside id="sidebar_main">
  <div class="sidebar_main_header">
    <div class="sidebar_logo"> <a href="<?php echo base_url('auth/');?>" class="sSidebar_hide sidebar_logo_large"> <img class="logo_regular" src="<?php echo base_url('assets/lms-admin/assets/img/images.png');?>" alt="" height="35" width="180"/> </a> </div>
  </div>
  <?php echo $this->lms_sidebar_menu->build_menu('1');?>
</aside>
<!-- main sidebar end -->