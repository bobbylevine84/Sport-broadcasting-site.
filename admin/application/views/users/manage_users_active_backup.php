<?php
//echo 'i am consumer/manage view file';
?>
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
<script src="<?php echo JS ?>moment.js"></script>
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
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
                    <div class="panel panel-visible">
					<div class="panel-heading">
                    			<div class="panel-title hidden-xs"> 
                    				<span class="glyphicon glyphicon-list"></span>
                                    Manage Users
                    			</div>
                                
                    		</div>
                       <div role="tabpanel">
				<!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li class="active">
                                <a href="#" >Active</a>
                            </li>
                            <li>
                                <a href="#" >InActive</a>
                            </li>
                            <li>
                                <a href="#" >Banned</a>
                            </li>
                               <div class="col-sm-2 pull-right text-right">
                           <select class="input-sm form-control input-s-sm inline v-middle 5678">
						    <option  value="0">All</option>
                             <option  value="1">Artist</option>  
                             <option  value="2">Regular User</option>  							 
                            </select>
                </div>
                          </ul>
                          
                             <h3></h3> 
                        </div>
						
                    		
							<div class="panel-body padding-bottom-none">
							<?php
                            if($this->session->flashdata('err_message')){
                            ?>
                            <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?>
                            </div>
							<?php
                            }//end if($this->session->flashdata('err_message'))
                            if($this->session->flashdata('ok_message'))
							{
                            ?>
                            <div class="alert alert-success alert-dismissable">
								<?php echo $this->session->flashdata('ok_message'); ?>
                         	</div>
                            <?php 
                            }//if($this->session->flashdata('ok_message'))
							
							
							if(count($all_withdraw)> 0)
							{?>

								<table class="table table-striped table-bordered table-hover searchable " id="manage_all_menus">
                                    <thead>
                                        <tr>
                        <th>User Name</th>
                        <th>Account ID</th>
                        <th>Country</th>
                        <th>Transaction Date</th>
						<th>Account Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                        
                                            
                                    	</tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php 
							

									
									foreach($all_withdraw as $c) {?>
                                  <tr>
                                    	 <td><?php echo $c->user_name;?></td>
                                        <td><?php echo $c->sender_id;?></td>
                                        <td><?php echo $c->user_country;?></td>
                                        <td><?php echo $c->withdraw_date;?></td>
										<td><?php echo $c->gateway_id;?></td>
                                        <td><?php echo $c->withdraw_amount .' '.$c->currency ;?>
                                        <td><?php if($c->wd_status==1){?>
                                                    <?php echo 'Approved'; ;?>

										<?php }else{?>
													<?php echo 'Pending'; ;?>

											<?php }?>
                                       </td>
                                        <td><?php if($c->wd_status==1){?> 
                                        	
                                                <span class="label btn-success">
                                                   <?php echo 'Complete'; ;?>
                                                </span>
                                          
											<?php }else{?>
                                            <a href="<?php echo base_url('withdraw/manage/status_approved').'/'.$c->id ;?>">
                                            	<span class="label btn-danger">
													 <?php echo 'Approved'; ;?>
                                             	</span>
                                          	</a>
											<?php }?></td>
                                       
                                    
                                        
                                    </tr>
                                    <?php }?>
                                   
                                    </tbody>
                            	</table>
							<?php 
                            }
							else
							{
                            ?>
                                <div class="alert alert-danger alert-dismissable">
                                <strong>No User Found</strong> </div>                	
							<?php		
                            }//end if($menu_list_count > 0)
                            ?>
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

    

   /* var otable =  $('#manage_all_menus').dataTable({
            "bFilter": false,
            "sPaginationType": "full_numbers",
            "aoColumnDefs" : [ {
                'bSortable' : false,
                'aTargets' : [ 0 ]
            } ]
        }); */
		
		var otable = $('#manage_all_menus').DataTable({
		"oLanguage": {
			"sSearch": "Search: "
			},
			"sPaginationType": "full_numbers"
		});
		
		$(".5678").change(function(){
		
		var data=$(this).val() ;
	$.post("<?php echo base_url() ?>withdraw/withdraw/get_record/",{'data':data}, function(data){
		
		var obj = jQuery.parseJSON(data);
		
		otable.fnClearTable();
			$.each( obj, function( key, val ) {
				console.log(val);
				var check = "";
				var check1 = "";
				if(val.wd_status == 1) {
					check1 = "<span>Approved</span>";
				}else {
					check1 = "<span>Pending</span>";
				}
				if(val.wd_status == 1) {
					check = "<span class='label btn-success'>Complete</span>";
				}else {
					check = "<a href='<?php echo base_url('withdraw/manage/status_approved').'/'.$c->id ;?>'><span class='label btn-danger'>Approved</span></a>";
				}
				var date = val.withdraw_date;
                var dat = moment(date).format('MM/DD  - h:m A');
				otable.fnAddData([
						val.user_name,
						val.withdraw_id,
						val.user_country,
						val.withdraw_date,
						val.gateway_id,
						val.withdraw_amount,
						check1,
						check						
					]);
				
          //console.log( key + ": " + value.withdraw_id );
});
//$('#myTable').fnDraw(false);
	});
	});
		$('#filter').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                    return rex.test($(this).text());
            }).show();
	});
});
</script>
