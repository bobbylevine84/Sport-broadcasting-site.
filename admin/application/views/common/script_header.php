<!-- Core CSS  -->
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>bootstrap/3.1.0/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>font-awesome/4.0.3/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo FONTS ?>glyphicons_pro/glyphicons.min.css">




<!-- Theme CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>theme.css">
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>pages.css">
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>plugins.css">
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>responsive.css">

<!-- Boxed-Layout CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>boxed.css">

<!-- Demonstration CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>demo.css">

<!-- Your Custom CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>custom.css">

<!-- Favicon -->
<link rel="shortcut icon" href="<?php echo IMG?>favicon.ico">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<!-- ANIMATE CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>animate.css">

<?php 
if($PLUGIN_datepicker == 1){
?>
    <!-- DATE PICKER  -->
    <link rel="stylesheet" type="text/css" href="<?php echo VENDOR ?>plugins/datepicker/datepicker.css">

<?php 
}//end if($PLUGIN_datagrid == 1)

if($PLUGIN_datagrid == 1){
?>
    <!-- DATA GRID -->
    <link rel="stylesheet" type="text/css" href="<?php echo VENDOR ?>plugins/datatables/css/datatables.min.css">

<?php	
}//end if($PLUGIN_datagrid == 1)

if($PLUGIN_gcal == 1){
?>
    <!--GAL, Full Calender -->
    <link rel="stylesheet" type="text/css" href="<?php echo VENDOR ?>plugins/calendar/fullcalendar.css">

<?php	
}//end if($PLUGIN_datagrid == 1)

if($PLUGIN_gallery == 1){
?>
    <!-- GALLERY -->
    <link rel="stylesheet" type="text/css" href="<?php echo VENDOR ?>plugins/mfpopup/dist/magnific-popup.css" media="screen" />

<?php	
}//end if($PLUGIN_gallery == 1)

if($PLUGIN_ckeditor == 1){
?>
    <!-- CKEDITOR -->
    <script type="text/javascript" src="<?php echo VENDOR ?>editors/ckeditor/ckeditor.js"></script> 
	


<?php	
}//end if($PLUGIN_ckeditor == 1)
	
?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>jquery-ui.css">
   <script src="<?php echo JS?>/jquery-1.10.2.js"></script>
	 <script src="<?php echo JS?>/transaction_modal.js"></script>
  <script src="<?php echo JS?>jquery-ui.js"></script>