<!-- Core Javascript - via CDN -->
<script src="<?php echo AJAX ?>libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo AJAX ?>libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="<?php echo CSS ?>/bootstrap/3.1.0/js/bootstrap.min.js"></script> 
  <!-- <script src="http://192.168.1.200/ecurrency/resources/js/charts/flot/highcharts.js"></script>
   <script src="http://192.168.1.200/ecurrency/resources/js/charts/flot/exporting.js"></script>
<!-- Theme Javascript -->
<script type="text/javascript" src="<?php echo JS ?>uniform.min.js"></script>
<script type="text/javascript" src="<?php echo JS ?>main.js"></script>
<!--<script type="text/javascript" src="assets/js/plugins.js"></script>-->
<script type="text/javascript" src="<?php echo JS ?>custom.js"></script>

<!-- Init Theme Core 	 -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		// Init Theme Core 	  
		Core.init();
});
</script>

<?php 
if($PLUGIN_floatchart == 1){
?>
    <!-- FLOAT CHART Addon -->
    <script type="text/javascript" src="<?php echo AJAX ?>libs/flot/0.8.1/jquery.flot.min.js"></script>
    <script type="text/javascript" src="<?php echo AJAX ?>libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/jqueryflot/jquery.flot.resize.min.js"></script><!-- Flot Charts Addon -->

<?php 
}//end if($PLUGIN_floatchart == 1)

if($PLUGIN_gcal == 1){
?>
    <!--GCAL Plugins -->
    <script type="text/javascript" src="<?php echo AJAX ?>libs/fullcalendar/1.6.4/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/calendar/gcal.js"></script>

<?php	
}//end if($PLUGIN_gcal == 1)

if($PLUGIN_datepicker == 1){
?>
    <!--START: DATE Picker Files -->
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/datepicker/bootstrap-datepicker.js"></script> 
    <script type="text/javascript">
        jQuery(document).ready(function() {
            // Date Picker 
            $('.datepicker').datepicker();
    });
    </script>
    <!--END: DATE Picker Files -->

<?php	
}//end if($PLUGIN_datepicker == 1)

if($PLUGIN_datagrid == 1){
	
?>

    <!--START: DATA GRID Files-->
    <script type="text/javascript" src="<?php echo AJAX ?>jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo AJAX ?>jquery.dataTables/1.9.4/jquery.dataTables.delay.min.js"></script>
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/datatables/js/datatables.js"></script><!-- Datatable Bootstrap Addon -->

<?php
}//end if($PLUGIN_datagrid == 1)

if($PLUGIN_form_validation == 1){
?>
	<script type="text/javascript" src="<?php echo VENDOR ?>plugins/validate/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/validate/additional-methods.js"></script>

<?php	
}//end if($PLUGIN_form_validation == 1)

if($PLUGIN_gallery == 1){
?>
	<script type="text/javascript" src="<?php echo VENDOR ?>plugins/mfpopup/dist/jquery.magnific-popup.min.js"></script> 
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/mixitup/jquery.mixitup.min.js"></script> 
    <script type="text/javascript">
     jQuery(document).ready(function() {
    
        
        // Shared mixitup variables
        var liveEffects = ['fade'];
        var clickEv = 'click';
        
        // Init mixitup 
        $('#Grid').mixitup({
            sortOnLoad: ['data-cat', 'asc'],
            buttonEvent: clickEv,
            onMixStart: function(config){
                // update effects array
                config.effects = liveEffects;
                config.transitionSpeed = 800;
                return config;
            }
        });
    
    
        
        // Add each image item to a gallery popup
        $('#Grid').magnificPopup({
          delegate: 'a', 
          type: 'image',
          disableOn: function() {
              if ($('#Grid li').hasClass('dragging')) {
                 return false;
              }
              return true;
          },
          gallery: {
            enabled: true
          }
        });
                
        
    });
    </script>

<?php 
}//end if($PLUGIN_gallery == 1)
?>


