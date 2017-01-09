<?php 
	$_url = $this->uri->segment(1);
 	
?>

<aside id="sidebar">
  <div id="sidebar-search">
    <div class="sidebar-toggle"> 
    	<span class="glyphicon glyphicon-resize-horizontal"></span> 
    </div>
  </div>
  <div id="sidebar-menu">
    <ul class="nav sidebar-nav">
<a target="_blank" href="<?php echo base_url()."../";?>" class="btn btn-info form-control"><i class="fa fa-eye hidden-md" title="Preview"></i><span class="hidden-sm hidden-md hidden-xs">Preview Website</span></a>
	 	
        <?php
		 
			$c = 0;
//print_r(		$this->session->userdata('permissions_arr'));exit;
			foreach($nav_panel_arr as $main_menu_index => $main_menu){

				if(in_array($main_menu['menu_id'], $this->session->userdata('permissions_arr')))
				{
					
				if($main_menu['status']  == 1 )
				
				{
					if (($_url=='dashboard' || $_url=='settings' || $_url=='templates' || $_url=='admin') &&  $main_menu['menu_title']=='Administration') { 
						$addClass = 'menu-open';
					} else if (($_url=='home' || $_url=='cms' || $_url=='menu') &&  $main_menu['menu_title']=='CMS') { 
						$addClass = 'menu-open';
					/*} else if($_url=='slider' && $_url2=='manage-slider') { 
						$addClass = 'menu-open';*/
						
					}else {
						$addClass = '';
					}
					
					echo ($c == 0) ? '<li class="active">' : '<li>';
	?>
				<a class="accordion-toggle menu-close <?php echo $addClass; ?>" href="<?php echo ($main_menu['url_link'] == '#') ? '#main_menu_'.$main_menu_index  : SURL.$main_menu['url_link']?>">
					<span class="glyphicons <?php echo $main_menu['menu_icon_class']?>">
					</span><span class="sidebar-title">
					<?php echo $main_menu['menu_title']; ?>
					</span><span class="caret"></span>
				</a>
	<?php		
				if(count($main_menu['sub_menu']) > 0){
					
					echo '<ul id="main_menu_'.$main_menu_index.'" class="nav sub-nav">';
					
					for($j=0; $j<count($main_menu['sub_menu']); $j++)
					{
						
					//	if(in_array($main_menu['sub_menu'][$j]['id'], $this->session->userdata('permissions_arr'))){
							
	?>						<li>
	
							<a href="<?php echo SURL.$main_menu['sub_menu'][$j]['url_link'] ?>" title="<?php echo $main_menu['sub_menu'][$j]['menu_title']?>">
							<span class="glyphicons <?php echo $main_menu['sub_menu'][$j]['icon_class_name']?>">
							</span>
							<?php echo $main_menu['sub_menu'][$j]['menu_title']?>
							</a>
							
							</li>
	
	<?php						
				 	//	}//end if(in_array($main_menu['sub_menu'][$j]['id'],$this->session->userdata('permissions_arr')))
					
					
					
					
					}//end for
					
					echo '</ul>';
					
				}//end if(count($sub_menu['sub_menu']) > 0)
					
					echo '</li>';
					$c++;
				}//end if($main_menu['status']  == 1)
				
				}//end if(in_array($main_menu_index,$this->session->userdata('permissions_arr')))
				
			}//end foreach
			
		?>
    </ul>

  </div>
</aside>
