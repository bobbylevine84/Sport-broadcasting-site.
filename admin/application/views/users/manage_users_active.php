
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
            <section id="content"> <?php echo $INC_breadcrum ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-visible">
                                        <div class="panel-heading">
                                            <div class="panel-title hidden-xs"> 
                                                <span class="glyphicon glyphicon-list"></span>
                                                Manage Users Active
                                            </div>

                                        </div>
                                        <div role="tabpanel">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="active">
                                                    <a href="<?php echo base_url('users/manage_user'); ?>" >Active</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url('users/manage_user/manage_inactive_user'); ?>" >InActive</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url('users/manage_user/manage_banned_user'); ?>" >Banned</a>
                                                </li>
                                                <div class="col-sm-2 pull-right text-right">

                                                </div>
                                            </ul>

                                            <h3></h3> 
                                        </div>
                                        <form class="cmxform" id="change_multiple_publishstatus" method="POST" action="<?php echo SURL ?>users/manage_user/approve_multiple_records">
                                            <input type="hidden" name="page" value="active_page"/>
                                            <div class="form-group col-md-12" style="margin: 5px;">                                    
                                                <input type="submit" class="btn btn-danger" name="reject" value="Delete Selected"/>
                                                <input type="submit" class="btn btn-success" name="inactive" value="InActive Selected"/>
                                                <input type="submit" class="btn btn-warning" name="banned" value="Banned Selected">
                                            </div>


                                            <div class="panel-body padding-bottom-none">
                                                <?php
                                                if ($this->session->flashdata('err_message')) {
                                                    ?>
                                                    <div id="message" class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?>
                                                    </div>
                                                    <?php
                                                }//end if($this->session->flashdata('err_message'))
                                                if ($this->session->flashdata('ok_message')) {
                                                    ?>
                                                    <div id="message" class="alert alert-success alert-dismissable">
                                                        <?php echo $this->session->flashdata('ok_message'); ?>
                                                    </div>
                                                    <?php
                                                }//if($this->session->flashdata('ok_message'))


                                                if (count($active_user) > 0) {
                                                    ?>

                                                    <table class="table table-striped table-bordered table-hover searchable " id="manage_all_menus">
                                                        <thead>
                                                            <tr>
                                                                <th class="no_pointr"><label><input type="checkbox" name="all" class="col-md-6 select_all" id="select_all" style="width: auto; height: auto;" /><span class="col-md-6"></span></label></th>
                                                                <th>User Name</th>
                                                                <th>Email</th>   
                                                                <th>Balance</th>  
                                                                <th>Status</th>
                                                                <th>Action</th>


                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php foreach ($active_user as $c) { ?>
                                                                <tr>
                                                                    <td style="vertical-align: middle;" id="checkbox">
                                                                        <input type="checkbox" class="checkbox1" name="selected[]" value="<?php echo $c['front_user_id']; ?>" style="width: auto; height: auto;" />
                                                                    </td>
                                                                    <td><?php echo $c['user_name']; ?> </td>
                                                                    <td><?php echo $c['email_address']; ?> </td>
                                                                    <td>$<?php echo $c['wallet_amount']; ?> </td>
                                                                    <td>
                                                                        <span class="label btn-success">
        <?php echo $c['front_user_flag']; ?>
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            <a type="button" class="btn btn-info btn-gradient" href="<?php echo base_url(); ?>users/manage_user/edit_user/<?php echo $c['front_user_id']; ?>/active"><span class="glyphicons glyphicons-edit"></span></a>
                                                                            <a type="button" class="btn btn-danger btn-gradient" onclick="return confirm('Are you sure you want to delete?')" href="<?php echo base_url(); ?>users/manage_user/delete_user/<?php echo $c['front_user_id']; ?>/active"><span class="glyphicons glyphicons-remove"></span></a>
                                                                            <a data-id="<?php echo $c['front_user_id']; ?>" class="btn btn-success btn-gradient add_balance" href="javascript:;">Add Balance</a>
                                                                        </div>
                                                                    </td>



                                                                </tr>
    <?php } ?>

                                                        </tbody>
                                                    </table>
                                                            <?php
                                                        } else {
                                                            ?>
                                                    <div class="alert alert-danger alert-dismissable">
                                                        <strong>No User Found</strong> </div>                	
                                                    <?php
                                                }//end if($menu_list_count > 0)
                                                ?>
                                            </div>
                                        </form>
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
        <footer> <?php echo $INC_footer; ?> </footer>
        <!-- End: Footer --> 
<?php echo $INC_header_script_footer; ?>
        <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Balance</h4>
      </div>
      <div class="modal-body">
          <form id="add_amount" method="post" action="<?php echo base_url(); ?>users/manage_user/add_amount">
            <label>Add Amount</label>
            <input type="number" id="new_balance" name="amount" class="form-control" required />
            <input type="hidden" id="balance_id" name="id" value="" class="form-control" />
            <input type="hidden" id="balance_id" name="type" value="active" class="form-control" />
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="submit_amount" type="button" class="btn btn-success btn-gradient">Add Amount</button>
      </div>
    </div>

  </div>
</div>
    </body>
</html>
<script type="application/javascript">
    $('document').ready(function(){
        
        $(".add_balance").click(function() {
            var id = $(this).data("id");
            $("#new_balance").val("");
            $("#balance_id").val(id);
            $("#myModal").modal("show");
        });
        
        $("#submit_amount").click(function() {
            if($("#new_balance").val() == "" || $("#new_balance").val() < 1) {
                alert("Amount must be greater than 0");
                return false;
            }else {
                $("#add_amount").submit();
            }
        });
    $('#message').fadeIn('fast').delay(2000).fadeOut('slow');
    $('#select_all').click(function(event) {  //on click 
    if(this.checked) { // check select status
    $('.checkbox1').each(function() { //loop through each checkbox
    this.checked = true;  //select all checkboxes with class "checkbox1"               
    });
    }else{
    $('.checkbox1').each(function() { //loop through each checkbox
    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
    });         
    }
    });



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
    "sPaginationType": "full_numbers",
    "aoColumnDefs": [
    { "bSortable": false, "aTargets": [ 0 ] }
    ]
    });

    $(".abc").change(function(){

    var data=$(this).val() ;
    var status=1;
    $.post("<?php echo base_url() ?>users/manage_user/get_record/",{'data':data,'status':status}, function(data){

    var obj = jQuery.parseJSON(data);

    otable.fnClearTable();
    $.each( obj, function( key, val ) {
    var type = "";
    var status = "";
    if(val.user_status == 1) {
    status = "<span class='label btn-success'>Active</span>";
    }
    if(val.user_type == 1) {
    type = "<span>Artist</span>";
    }else {
    type = "<span>Buyers</span>";
    }
    var button = '<div class="btn-group"><a type="button" class="btn btn-info btn-gradient" href=""><span class="glyphicons glyphicons-edit"></span></a><a type="button" class="btn btn-danger btn-gradient" href="<?php echo base_url(); ?>users/manage_user/delete_user/'+val.user_id+'/active" onclick="return confirm("Are you sure you want to delete?")"><span class="glyphicons glyphicons-remove"></span></a></div>';
    var checkbox='<input type="checkbox" class="checkbox1" name="selected[]" value='+val.user_id+' style="width: auto; height: auto;" />';

    otable.fnAddData([
    checkbox,
    val.user_firstname +''+val.user_lastname,
    val.user_email,
    type,
    status,
    button						
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
