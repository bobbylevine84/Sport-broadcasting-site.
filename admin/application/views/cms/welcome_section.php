<?php 
$session_post_data = $this->session->userdata('add-page-data');
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
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Note </div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_cms_page_frm" method="POST" action="<?php echo SURL?>cms/manage_pages/add_new_note_process">
                <div class="tab-content border-none padding-none">
                  <div id="cms_main_contents" class="tab-pane active">
					<?php
                        if($this->session->flashdata('err_message')){
                    ?>
                            <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
                    <?php
                        }//end if($this->session->flashdata('err_message'))
                        
                        if($this->session->flashdata('ok_message')){
                    ?>
                            <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
                    <?php 
                        }//if($this->session->flashdata('ok_message'))
                    ?>
                      <div class="form-group">
                        <label for="note">Welcome Note</label>
                      </div>
					  
					  <?php $rule = $this->db->get('kt_welcome_section')->result_array();?>
                      <div class="form-group">
                        <textarea class="ckeditor editor1"  id="note" name="note" rows="14"><?php echo $rule[0]['note'] ?></textarea>
                      </div>
                    <div class="row form-group">
                        <div class="col-md-5">
							<label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
								<option value="1" <?php echo ($rule[0]['status'] == '1') ? 'selected' : ''?>  >Active</option>
								<option value="0" <?php echo ($rule[0]['status'] == '0') ? 'selected' : '' ?>>InActive </option>
							</select>
                        </div>
                    </div>                      
                  </div>
				<div class="form-group" align="right" style="margin-right:17px">
					<input class="submit btn btn-blue" type="submit" name="add_note_sbt" id="add_note_sbt" value="Add Note" />
				</div>
                </div>
				
              </form>
            </div>
          </div>
        </div>
      </div>
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
