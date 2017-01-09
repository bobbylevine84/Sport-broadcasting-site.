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
                            <span class="glyphicon glyphicon-list"></span>Fee Settings
                        </div>
                           
                    </div>
                    <div >
                    
                    <div role="tabpanel">
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li>
		<a href="<?php echo base_url('settings/manage_setting/fee_settings'); ?>" >Fee Structure</a>
	</li>
    <li  >
		<a href="<?php echo base_url('settings/manage_setting/SR_settings'); ?>" >Send and Receive Setting</a>
	</li>
	<li class="active" >
		<a href="<?php echo base_url('settings/manage_setting/withdraw'); ?>" >Withdraw Funds Settings</a>
	</li>
    <li  >
		<a href="<?php echo base_url('settings/manage_setting/exchange'); ?>" >Exchange Fee Settings</a>
	</li>
     <li   >
		<a href="<?php echo base_url('settings/manage_setting/sci'); ?>" >SCI Fee Settings</a>
	</li>
	
  </ul>
<?php // echo "<pre>"; print_r($fee_data_indi); exit; ?>
<form action="<?php echo base_url('settings/manage_setting/update_wd');?>" method="post">
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tab1">
		<table class="table table-bordered">
			<thead>
				<th>Accounts</th>
				<th>Individual</th>
				<th>Business</th>
			</thead>
     
			
		<?php foreach($fee_data_all as $data){
					
		?>
        <tr>
		<td><label><?php echo $data['inst_name'];  ?></label></td>  
         
             <td width="45%">
    <div class="row">
    <div class=" col-md-4">         
	<div class="form-group">
	<label class="sr-only">Amount (in Percentage)</label>
	<div class="input-group">
	<div class="input-group-addon">%</div>
<input name="hidden_<?php echo $data['inst_name'];?>" type="hidden" value="<?php echo $data['id']; ?>"/>
	<input name="in_per_w_<?php echo $data['inst_name'];?>" value="<?PHP echo $data['indi_per'];?>" class="form-control" step="0.1" type="number" placeholder="30" />
	</div>
	</div>
    </div>
    <div class=" col-md-4">
    <div class="form-group">
	<label class="sr-only">Amount (fix)</label>
	<div class="input-group">
	<div class="input-group-addon">F</div>
	<input name="in_fix_w_<?php echo $data['inst_name'];?>" value="<?PHP echo $data['indi_fix'];?>" class="form-control" type="number" step="0.1" placeholder="30" />
	</div>
	</div>
    </div>
    </div>
			</td>
        
  				<td width="45%">
    <div class="row">
    <div class=" col-md-4">         
	<div class="form-group">
	<label class="sr-only">Amount (in Percentage)</label>
	<div class="input-group">
	<div class="input-group-addon">%</div>
    <input name="hidden_<?php echo $data['inst_name'];?>" type="hidden" value="<?php echo $data['id']; ?>"/>
	<input name="bu_per_w_<?php echo $data['inst_name'];?>" value="<?PHP echo $data['busi_per'];?>" class="form-control" step="0.1" type="number" placeholder="30" />
	</div>
	</div>
    </div>
    <div class=" col-md-4">
    <div class="form-group">
	<label class="sr-only">Amount (fix)</label>
	<div class="input-group">
	<div class="input-group-addon">F</div>
	<input name="bu_fix_w_<?php echo $data['inst_name'];?>" value="<?PHP echo $data['busi_fix'];?>" class="form-control" step="0.1" type="number" placeholder="30" />
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
