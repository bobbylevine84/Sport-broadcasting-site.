<!DOCTYPE html>
<html>
<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $INC_header_script_top; ?>
</head>

<body>
<!-- Start: Header -->
<header class="navbar navbar-fixed-top"> <?php echo $INC_top_header; ?> </header>
<!-- End: Header --> 
<!-- Start: Main -->
<div id="main"> 
  <!-- Start: Sidebar --> 
  <?php echo $INC_left_nav_panel; ?> 
  <!-- End: Sidebar --> 
  <!-- Start: Content -->
  <section id="content"> <?php echo $INC_breadcrum?>
  
  
    <div class="container">
		<div class="row">
			<div class=" col-md-12">
				<?php 
             if (validation_errors()) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                        <button type='button' class='close' data-dismiss='alert'>
                            <span aria-hidden='true'>&times;</span>
                            <span class='sr-only'>Close</span>
                        </button>" .validation_errors(). "</div>"; 
              }
			  if ( isset($success) && $success != '' ) { 
					echo "<div class='alert alert-success alert-dismissible' role='alert'>
							<button type='button' class='close' data-dismiss='alert'>
								<span aria-hidden='true'>&times;</span>
								<span class='sr-only'>Close</span>
							</button>". $success ."</div>";
			  }
              ?>
           
                <div class="panel panel-visible">
               
                    <div class="panel-heading">
                    
                        <div class="panel-title hidden-xs"> 
                            <span class="glyphicon glyphicon-list"></span>Group Fee Settings
                        </div>
                           
                    </div>
                    <div >
                    
                    <div role="tabpanel">
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li>
		<a href="<?php echo base_url('settings/manage_setting/group_fee_settings'); ?>" >Fee Structure</a>
	</li>
    <li  >
		<a href="<?php echo base_url('settings/manage_setting/group_SR_settings'); ?>" >Send and Receive Setting</a>
	</li>
	<li class="active" >
		<a href="<?php echo base_url('settings/manage_setting/group_withdraw'); ?>" >Withdraw Funds Settings</a>
	</li>
    <li  >
		<a href="<?php echo base_url('settings/manage_setting/group_exchange'); ?>" >Exchange Fee Settings</a>
	</li>
     <li   >
		<a href="<?php echo base_url('settings/manage_setting/group_sci'); ?>" >SCI Fee Settings</a>
	</li>
	
  </ul>
	<select id="select_group" class="input-sm form-control" style="width:200px; margin-left: 946px; z-index: 500;">
		<?php foreach($groups as $g){?>
        <option  value="<?php echo $g['id'];?>"><?php echo $g['group_name']; if($g['is_verify']==0){echo ' -- (unverified)';}else {echo ' -- (verified)';} ?></option>
		<?php }?>                          
    </select>
<?php // echo "<pre>"; print_r($fee_data_indi); exit; ?>
<form action="<?php echo base_url('settings/manage_setting/update_grp_wd');?>" method="post">
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tab1">
		<table class="table table-bordered">
			<thead>
				<th>Accounts</th>
				<th>Exchanger</th>
			</thead>
     
			
		<?php foreach($grp_withdraw_settings as $data){
					
		?>
        <tr>
		<td><label><?php echo $data['inst_name'];  ?></label></td>  
         
             <td width="75%">
    <div class="row">
    <div class=" col-md-4">         
	<div class="form-group">
	<label class="sr-only">Amount (in Percentage)</label>
	<div class="input-group">
	<div class="input-group-addon">%</div>
<input id="hidden_<?php echo $data['inst_name'];?>" name="hidden_<?php echo $data['inst_name'];?>" type="hidden" value="<?php echo $data['id']; ?>"/>
	<input id="ex_per_<?php echo $data['inst_name'];?>" name="ex_per_<?php echo $data['inst_name'];?>" value="<?PHP echo $data['ex_per'];?>" class="form-control" step="0.1" type="number" placeholder="30" />
	</div>
	</div>
    </div>
    <div class=" col-md-4">
    <div class="form-group">
	<label class="sr-only">Amount (fix)</label>
	<div class="input-group">
	<div class="input-group-addon">F</div>
	<input id="ex_fix_<?php echo $data['inst_name'];?>" name="ex_fix_<?php echo $data['inst_name'];?>" value="<?PHP echo $data['ex_fix'];?>" class="form-control" type="number" step="0.1" placeholder="30" />
	</div>
	</div>
    </div>
    </div>
	</td>
        
</tr>
  
<?php }?>
			
		</table>
		
		<input type="submit" class="btn btn-success" value="Update"/>
	
	</div>
    <div role="tabpanel" class="tab-pane" id="tab2">Setting</div>    
  </div>
  
</div>
                    
                    
                    
                    
                    </div>
                </div>
			</div>
		</div>
			
    	<div class="clearfix"></div>
    	<div class="row" style="min-height:250px;">&nbsp;</div>
    </div>
  </section>
  <!-- End: Content --> 
  
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
</body>
</html>


<script type="application/javascript">
$('document').ready(function(){
	
    $("#select_group").change(function(){
		var data = $(this).val();
		//alert(data);
		$.post('<?php echo base_url() ?>settings/manage_setting/group_withdraw', {'data': data}, function(data){
			
			var obj = jQuery.parseJSON(data);
			
			$.each( obj, function( key, val ) {
				//console.log(val);

				var field1 = '#ex_per_' + val.inst_name;
				var field2 = '#ex_fix_' + val.inst_name;
				
				var hidden = '#hidden_' + val.inst_name;
				
				$(field1).val(val.ex_per);
				$(field2).val(val.ex_fix);
				$(hidden).val(val.id);

			});
		});
	});

});
</script>
