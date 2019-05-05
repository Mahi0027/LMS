<!DOCTYPE html>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('lms_admin/partials/header'); ?>
    <div id="page_content">
        <div id="page_content_inner">

            <!-- statistics (small charts) -->
            <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">5,3,9,6,5,9,7</span></div>
                            <span class="uk-text-muted uk-text-small">Visitors (last 7d)</span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript>12456</noscript></span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                            <span class="uk-text-muted uk-text-small">Sale</span>
                            <h2 class="uk-margin-remove">$<span class="countUpMe">0<noscript>142384</noscript></span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                            <span class="uk-text-muted uk-text-small">Orders Completed</span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript>64</noscript></span>%</h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span></div>
                            <span class="uk-text-muted uk-text-small">Visitors (live)</span>
                            <h2 class="uk-margin-remove" id="peity_live_text">46</h2>
                        </div>
                    </div>
                </div>
            </div>

     

            

       </div>
    </div>

<!-- common functions --> 
<script src="<?php echo base_url('assets/lms-admin/assets/js/common.min.js');?>"></script> 
<!-- uikit functions --> 
<script src="<?php echo base_url('assets/lms-admin/assets/js/uikit_custom.min.js');?>"></script> 
<!-- altair common functions/helpers --> 
<script src="<?php echo base_url('assets/lms-admin/assets/js/altair_admin_common.min.js');?>"></script> 

<!-- page specific plugins --> 
<!-- d3 --> 
<script src="<?php echo base_url('assets/lms-admin/assets/bower_components/d3/d3.min.js');?>"></script> 
<!-- metrics graphics (charts) --> 
<script src="<?php echo base_url('assets/lms-admin/assets/bower_components/metrics-graphics/dist/metricsgraphics.min.js');?>"></script> 
<!-- chartist (charts) --> 
<script src="<?php echo base_url('assets/lms-admin/assets/bower_components/chartist/dist/chartist.min.js');?>"></script> 
<!-- maplace (google maps) --> 
<script src="http://maps.google.com/maps/api/js"></script> 
<script src="<?php echo base_url('assets/lms-admin/assets/bower_components/maplace-js/dist/maplace.min.js');?>"></script> 
<!-- peity (small charts) --> 
<script src="<?php echo base_url('assets/lms-admin/assets/bower_components/peity/jquery.peity.min.js');?>"></script> 
<!-- easy-pie-chart (circular statistics) --> 
<script src="<?php echo base_url('assets/lms-admin/assets/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js');?>"></script> 
<!-- countUp --> 
<script src="<?php echo base_url('assets/lms-admin/assets/bower_components/countUp.js/dist/countUp.min.js');?>"></script> 
<!-- handlebars.js --> 
<script src="<?php echo base_url('assets/lms-admin/bower_components/handlebars/handlebars.min.js');?>"></script> 
<script src="<?php echo base_url('assets/lms-admin//assets/js/custom/handlebars_helpers.min.js');?>"></script> 
<!-- CLNDR --> 
<script src="<?php echo base_url('assets/lms-admin/assets/bower_components/clndr/clndr.min.js');?>"></script> 

<!--  dashbord functions --> 
<script src="<?php echo base_url('assets/lms-admin/assets/js/pages/dashboard.min.js');?>"></script> 
<script>
        $(function() {
            if(isHighDensity()) {
                $.getScript( "<?php echo base_url('assets/lms-admin/bower_components/dense/src/dense.js');?>", function() {
                    // enable hires images
                    altair_helpers.retina_images();
                })
            }
            if(Modernizr.touch) {
                // fastClick (touch devices)
                FastClick.attach(document.body);
            }
        });
        $window.load(function() {
            // ie fixes
            altair_helpers.ie_fix();
        });
    </script>
<div id="style_switcher">
  <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
  <div class="uk-margin-medium-bottom">
    <h4 class="heading_c uk-margin-bottom">Colors</h4>
    <ul class="switcher_app_themes" id="theme_switcher">
      <li class="app_style_default active_theme" data-app-theme=""> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
      <li class="switcher_theme_a" data-app-theme="app_theme_a"> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
      <li class="switcher_theme_b" data-app-theme="app_theme_b"> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
      <li class="switcher_theme_c" data-app-theme="app_theme_c"> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
      <li class="switcher_theme_d" data-app-theme="app_theme_d"> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
      <li class="switcher_theme_e" data-app-theme="app_theme_e"> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
      <li class="switcher_theme_f" data-app-theme="app_theme_f"> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
      <li class="switcher_theme_g" data-app-theme="app_theme_g"> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
      <li class="switcher_theme_h" data-app-theme="app_theme_h"> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
      <li class="switcher_theme_i" data-app-theme="app_theme_i"> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
      <li class="switcher_theme_dark" data-app-theme="app_theme_dark"> <span class="app_color_main"></span> <span class="app_color_accent"></span> </li>
    </ul>
  </div>
  <div class="uk-visible-large uk-margin-medium-bottom">
    <h4 class="heading_c">Sidebar</h4>
    <p>
      <input type="checkbox" name="style_sidebar_mini" id="style_sidebar_mini" data-md-icheck />
      <label for="style_sidebar_mini" class="inline-label">Mini Sidebar</label>
    </p>
    <p>
      <input type="checkbox" name="style_sidebar_slim" id="style_sidebar_slim" data-md-icheck />
      <label for="style_sidebar_slim" class="inline-label">Slim Sidebar</label>
    </p>
  </div>
  <div class="uk-visible-large uk-margin-medium-bottom">
    <h4 class="heading_c">Layout</h4>
    <p>
      <input type="checkbox" name="style_layout_boxed" id="style_layout_boxed" data-md-icheck />
      <label for="style_layout_boxed" class="inline-label">Boxed layout</label>
    </p>
  </div>
  <div class="uk-visible-large">
    <h4 class="heading_c">Main menu accordion</h4>
    <p>
      <input type="checkbox" name="accordion_mode_main_menu" id="accordion_mode_main_menu" data-md-icheck />
      <label for="accordion_mode_main_menu" class="inline-label">Accordion mode</label>
    </p>
  </div>
</div>
<script>
        $(function() {
            var $switcher = $('#style_switcher'),
                $switcher_toggle = $('#style_switcher_toggle'),
                $theme_switcher = $('#theme_switcher'),
                $mini_sidebar_toggle = $('#style_sidebar_mini'),
                $slim_sidebar_toggle = $('#style_sidebar_slim'),
                $boxed_layout_toggle = $('#style_layout_boxed'),
                $accordion_mode_toggle = $('#accordion_mode_main_menu'),
                $html = $('html'),
                $body = $('body');


            $switcher_toggle.click(function(e) {
                e.preventDefault();
                $switcher.toggleClass('switcher_active');
            });

            $theme_switcher.children('li').click(function(e) {
                e.preventDefault();
                var $this = $(this),
                    this_theme = $this.attr('data-app-theme');

                $theme_switcher.children('li').removeClass('active_theme');
                $(this).addClass('active_theme');
                $html
                    .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g app_theme_h app_theme_i app_theme_dark')
                    .addClass(this_theme);

                if(this_theme == '') {
                    localStorage.removeItem('altair_theme');
                    $('#kendoCSS').attr('href','bower_components/kendo-ui/styles/kendo.material.min.css');
                } else {
                    localStorage.setItem("altair_theme", this_theme);
                    if(this_theme == 'app_theme_dark') {
                        $('#kendoCSS').attr('href','bower_components/kendo-ui/styles/kendo.materialblack.min.css')
                    } else {
                        $('#kendoCSS').attr('href','bower_components/kendo-ui/styles/kendo.material.min.css');
                    }
                }

            });

            // hide style switcher
            $document.on('click keyup', function(e) {
                if( $switcher.hasClass('switcher_active') ) {
                    if (
                        ( !$(e.target).closest($switcher).length )
                        || ( e.keyCode == 27 )
                    ) {
                        $switcher.removeClass('switcher_active');
                    }
                }
            });

            // get theme from local storage
            if(localStorage.getItem("altair_theme") !== null) {
                $theme_switcher.children('li[data-app-theme='+localStorage.getItem("altair_theme")+']').click();
            }


        // toggle mini sidebar

            // change input's state to checked if mini sidebar is active
            if((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
                $mini_sidebar_toggle.iCheck('check');
            }

            $mini_sidebar_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_sidebar_mini", '1');
                    localStorage.removeItem('altair_sidebar_slim');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_sidebar_mini');
                    location.reload(true);
                });

        // toggle slim sidebar

            // change input's state to checked if mini sidebar is active
            if((localStorage.getItem("altair_sidebar_slim") !== null && localStorage.getItem("altair_sidebar_slim") == '1') || $body.hasClass('sidebar_slim')) {
                $slim_sidebar_toggle.iCheck('check');
            }

            $slim_sidebar_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_sidebar_slim", '1');
                    localStorage.removeItem('altair_sidebar_mini');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_sidebar_slim');
                    location.reload(true);
                });

        // toggle boxed layout

            if((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
                $boxed_layout_toggle.iCheck('check');
                $body.addClass('boxed_layout');
                $(window).resize();
            }

            $boxed_layout_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_layout", 'boxed');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_layout');
                    location.reload(true);
                });

        // main menu accordion mode
            if($sidebar_main.hasClass('accordion_mode')) {
                $accordion_mode_toggle.iCheck('check');
            }

            $accordion_mode_toggle
                .on('ifChecked', function(){
                    $sidebar_main.addClass('accordion_mode');
                })
                .on('ifUnchecked', function(){
                    $sidebar_main.removeClass('accordion_mode');
                });


        });
    </script>
</body>
</html>