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


        <style type="text/css">
            .mb-st {
                margin-bottom:15px;
            }	
            .mb-st .b-r {
                padding-bottom:10px;
            }
        </style>

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
                    <h1>Welcome To WiziWig Admin Panel</h1>
<!--                    <div class="row">
                        <div class="col-md-12">
                            <div id="console-btns">
                                <section class="row m-l-none m-r-none m-b text-center box-shadow">
                                    <div class="col-xs-4 bg-info dk lter r-l">
                                        <div class="wrapper">
                                            <i class="fa fa-user fa fa-3x m-t m-b-sm text-white"></i>
                                            <p class="text-muted font-bold">Individual Accounts</p>
                                            <div class="h4 font-bold"><?= $get_individual_accounts ?></div>
                                            <div class="col-xs-12 mb-st" style='background-color:#fff;'>
                                                <div class="col-xs-4 b-r text-success">
                                                    <div class="h3 font-bold"><?= $get_verified_individual_accounts ?></div>
                                                    <small class="text-muted-">Verfied</small> </div>
                                                <div class="col-xs-4 text-warning">
                                                    <div class="h3 font-bold "><?= $get_pending_individual_accounts ?></div>
                                                    <small class="text-muted-">Pending</small> </div>
                                                <div class="col-xs-4 text-danger">
                                                    <div class="h3 font-bold "><?= $get_unverified_individual_accounts ?></div>
                                                    <small class="text-muted-">Unverified</small> </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-4 bg-danger lt">
                                        <div class="wrapper">
                                            <i class="fa fa-user fa fa-3x m-t m-b-sm text-white"></i>
                                            <p class="text-muted font-bold">Business Accounts</p>
                                            <div class="h4 font-bold"><?= $get_business_accounts ?></div>
                                            <div class="col-xs-12 mb-st" style='background-color:#fff;'>
                                                <div class="col-xs-4 b-r text-success">
                                                    <div class="h3 font-bold"><?= $get_verified_business_accounts ?></div>
                                                    <small class="text-muted-">Verfied</small> </div>
                                                <div class="col-xs-4 text-warning">
                                                    <div class="h3 font-bold"><?= $get_pending_business_accounts ?></div>
                                                    <small class="text-muted-">Pending</small> </div>
                                                <div class="col-xs-4 text-danger">
                                                    <div class="h3 font-bold"><?= $get_unverified_business_accounts ?></div>
                                                    <small class="text-muted-">Unverified</small> </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 bg-info lt">
                                        <div class="wrapper">
                                            <i class="fa fa-user fa fa-3x m-t m-b-sm text-white"></i>
                                            <p class="text-muted font-bold"> Accounts</p>
                                            <div class="h4 font-bold"><?= $get_exchanger_accounts ?></div>
                                            <div class="col-xs-12  mb-st" style='background-color:#fff;'>
                                                <div class="col-xs-4 b-r text-success">
                                                    <div class="h3 font-bold"><?= $get_verified_exchanger_accounts ?></div>
                                                    <small class="text-muted-">Verfied</small> </div>
                                                <div class="col-xs-4 text-warning">
                                                    <div class="h3 font-bold"><?= $get_pending_exchanger_accounts ?></div>
                                                    <small class="text-muted-">Pending</small> </div>
                                                <div class="col-xs-4 text-danger">
                                                    <div class="h3 font-bold"><?= $get_unverified_exchanger_accounts ?></div>
                                                    <small class="text-muted-">Unverified</small> </div>

                                            </div>
                                        </div>
                                    </div>

                                </section>

                                <br>

                                <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <a href="<?php echo SURL ?>cms/manage-pages">
                                            <div class="console-btn">
                                                <div class="console-icon divider-right"> 
                                                    <span class="glyphicons glyphicons-font"></span> 
                                                </div>

                                                <div class="console-text">
                                                    <div class="console-title">CMS Management</div>
                                                    <div class="console-subtitle">View More <i class="fa fa-caret-right"></i> </div>
                                                </div>
                                            </div></a>

                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="console-btn">
                                            <div class="console-icon divider-right"> <span class="glyphicons glyphicons glyphicons-hdd"></span> </div>
                                            <div class="console-text">
                                                <div class="console-title">Database</div>
                                                <div class="console-subtitle">View More <i class="fa fa-caret-right"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="console-btn">
                                            <div class="console-icon divider-right"> <span class="glyphicons glyphicons-print"></span> </div>
                                            <div class="console-text">
                                                <div class="console-title">Reports</div>
                                                <div class="console-subtitle">View More <i class="fa fa-caret-right"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="console-btn">
                                            <div class="console-icon divider-right"> <span class="glyphicons glyphicons-security_camera"></span> </div>
                                            <div class="console-text">
                                                <div class="console-title">Utilities</div>
                                                <div class="console-subtitle">View More <i class="fa fa-caret-right"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <a href="<?php echo SURL ?>admin/manage-user/edit-profile">
                                            <div class="console-btn">
                                                <div class="console-icon divider-right"> <span class="glyphicons glyphicons-user"></span> </div>
                                                <div class="console-text">
                                                    <div class="console-title">Profile</div>
                                                    <div class="console-subtitle">View More <i class="fa fa-caret-right"></i> </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="console-btn">
                                            <div class="console-icon divider-right"> <span class="glyphicons glyphicons-music"></span> </div>
                                            <div class="console-text">
                                                <div class="console-title">Music</div>
                                                <div class="console-subtitle">View More <i class="fa fa-caret-right"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                    <!--
                        <hr class="short margin-top-none">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-12"> </div>
                  
                          <div class="col-md-12">
                          <div class="row">
                              <div class="col-md-2">
                                          <div class="input-group"> <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                            <input type="text" id="datepicker" class="form-control datepicker margin-top-none" placeholder="23/9/2013">
                                          </div>
                                </div>
                          </div>
                          <div class="clearfix"> &nbsp; </div>
                            <div class="panel panel-visible">
                              <div class="panel-heading">
                              
                                <div class="panel-title hidden-xs"> <span class="glyphicon glyphicon-tasks"></span> Editable Data Table</div> 
                              </div>
                              <div class="panel-body padding-bottom-none">
                                <table class="table table-striped table-bordered table-hover" id="datatable">
                                  <thead>
                                    <tr>
                                      <th>Editable</th>
                                      <th class="hidden-xs">Creator</th>
                                      <th>Labels</th>
                                      <th class="visible-lg">Software license</th>
                                      <th class="hidden-xs hidden-sm">Current layout engine</th>
                                      <th>Cost (USD)</th>
                                      <th class="text-center hidden-xs">Actions</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">Henry Ford</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label label-info">CSS</span></td>
                                      <td class="visible-lg">GNU GPLv3</td>
                                      <td>FSkit</td>
                                      <td>Free</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">Roger Rights</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-orange2 margin-right-sm">HTML</span><span class="label btn-dark">Java</span></td>
                                      <td class="visible-lg">GNU GPLv3</td>
                                      <td>Webkit</td>
                                      <td>License</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">Goblin Jones</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-green">PHP</span></td>
                                      <td class="visible-lg">CF2</td>
                                      <td>FSkit</td>
                                      <td>Contract</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">David Fleece</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-red">Python</span></td>
                                      <td class="visible-lg">CC V2</td>
                                      <td>Webkit</td>
                                      <td>Free</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">Mary Shark</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-blue2 margin-right-sm">Javascript</span><span class="label btn-green">PHP</span></td>
                                      <td class="visible-lg">GNU GPLv3</td>
                                      <td>FSkit</td>
                                      <td>License</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">Alexander Right</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-alert"> A Warm Heart</span></td>
                                      <td class="visible-lg">GNU GPLv3</td>
                                      <td>Webkit</td>
                                      <td>Contract</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">Peter Parker</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-blue6">NewEgg</span></td>
                                      <td class="visible-lg">CC V2</td>
                                      <td>FSkit</td>
                                      <td>Free</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">Florida Toss</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-dark">Skills</span></td>
                                      <td class="visible-lg">CF2</td>
                                      <td>Webkit</td>
                                      <td>License</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">Cynthia Rodes</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-orange margin-right-sm">HTML</span><span class="label btn-green">PHP</span></td>
                                      <td class="visible-lg">CF2</td>
                                      <td>FSkit</td>
                                      <td>Free</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">James Harvy</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-alert margin-right-sm">Patience</span><span class="label label-info">CSS</span></td>
                                      <td class="visible-lg">CC V2</td>
                                      <td>Webkit</td>
                                      <td>License</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Uzbl</span></td>
                                      <td class="hidden-xs"><span class="xedit">Hue Fontain</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-red2">Ice Cream</span></td>
                                      <td class="visible-lg">GNU GPLv3</td>
                                      <td>FSkit</td>
                                      <td>License</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td><span class="xedit">Try Me!</span></td>
                                      <td class="hidden-xs"><span class="xedit">George Michaels</span></td>
                                      <td class="hidden-xs hidden-sm"><span class="label btn-brown">Dedication</span></td>
                                      <td class="visible-lg">GNU GPLv3</td>
                                      <td>Webkit</td>
                                      <td>Contract</td>
                                      <td class="hidden-xs text-center"><div class="btn-group">
                                          <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                                          <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                                          <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a><i class="fa fa-user"></i> View Profile </a></li>
                                            <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                                          </ul>
                                        </div></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                  
                            </div>
                          </div>
                  
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="panel">
                              <div class="panel-heading">
                                <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Responsive Table </div>
                              </div>
                              <div class="panel-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Table heading</th>
                                        <th>Table heading</th>
                                        <th>Table heading</th>
                                        <th>Table heading</th>
                                        <th>Table heading</th>
                                        <th>Table heading</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>1</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                      </tr>
                                      <tr>
                                        <td>2</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                      </tr>
                                      <tr>
                                        <td>3</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                        <td>Table cell</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="clearfix"></div>
                        </div>
                    -->
                    <div class="row" style="min-height:400px;">&nbsp;</div>
                </div>
            </section>
            <!-- End: Content --> 

        </div>

        <!-- End: Main --> 
        <!-- Start: Footer -->
        <footer> <?php echo $INC_footer; ?> </footer>
        <!-- End: Footer --> 

        <?php echo $INC_header_script_footer; ?>

    </body>
</html>

<script>

    chart1 = new Highcharts.Chart({
        chart: {
            type: 'spline',
            renderTo: 'container'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
                name: 'Tokyo',
                data: [0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0]
            }, {
                name: 'New York',
                data: [1, 1, 1, 1, 1, 1, 1, 6, 0, 0, 0, 0]
            }, {
                name: 'Berlin',
                data: [0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0]
            }, {
                name: 'London',
                data: [0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0]
            }]
    });


    $(function () {
        $.getJSON('<?php echo base_url(); ?>dashboard/dashboard/get_user_accountdata', function (data) {
            //console.log(data);
//alert(data.length);
            $('#container1').highcharts({
                chart: {
                    zoomType: 'x'
                },
                title: {
                    text: 'User accounts'
                },
                subtitle: {
                    // text: document.ontouchstart === undefined ?
                    //  'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
                },
                xAxis: {
                    type: 'datetime',
                    //maxZoom:  60 ,
                },
                yAxis: {
                    title: {
                        text: 'Number of Accounts'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null
                    }
                },
                series: [{
                        type: 'area',
                        name: 'Accounts',
                        data: data
                    }]
            });
        });
    });

    $(function () {
        $('#container2').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'xyz'
            },
            subtitle: {
                text: 'Irregular time data in Highcharts JS'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {// don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
                title: {
                    text: 'Date'
                }
            },
            yAxis: {
                title: {
                    text: 'Snow depth (m)'
                },
                min: 0
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
            },
            plotOptions: {
                spline: {
                    marker: {
                        enabled: true
                    }
                }
            },
            series: [{
                    name: "Deposites",
                    // Define the data points. All series have a dummy year
                    // of 1970/71 in order to be compared on the same x axis. Note
                    // that in JavaScript, months start at 0 for January, 1 for February etc.
                    data: [
                        /*[Date.UTC(1970, 9, 21), 0],
                         [Date.UTC(1970, 10, 4), 0.28],
                         [Date.UTC(1970, 10, 9), 0.25],
                         [Date.UTC(1970, 10, 27), 0.2],
                         [Date.UTC(1970, 11, 2), 0.28],
                         [Date.UTC(1970, 11, 26), 0.28],
                         [Date.UTC(1970, 11, 29), 0.47],
                         [Date.UTC(1971, 0, 11), 0.79],
                         [Date.UTC(1971, 0, 26), 0.72],
                         [Date.UTC(1971, 1, 3), 1.02],
                         [Date.UTC(1971, 1, 11), 1.12],
                         [Date.UTC(1971, 1, 25), 1.2],
                         [Date.UTC(1971, 2, 11), 1.18],
                         [Date.UTC(1971, 3, 11), 1.19],
                         [Date.UTC(1971, 4, 1), 1.85],
                         [Date.UTC(1971, 4, 5), 2.22],
                         [Date.UTC(1971, 4, 19), 1.15],
                         [Date.UTC(1971, 5, 3), 3] */
<?= $get_monthwise_deposite ?>

                    ]
                }, {
                    name: "Withdraw",
                    data: [
<?= $get_monthwise_withdraw ?>
                    ]
                }, {
                    name: "Transfer",
                    data: [
                        /*[Date.UTC(1970, 10, 25), 0],
                         [Date.UTC(1970, 11, 6), 0.25],
                         [Date.UTC(1970, 11, 20), 1.41],
                         [Date.UTC(1970, 11, 25), 1.64],
                         [Date.UTC(1971, 0, 4), 1.6],
                         [Date.UTC(1971, 0, 17), 2.55],
                         [Date.UTC(1971, 0, 24), 2.62],
                         [Date.UTC(1971, 1, 4), 2.5],
                         [Date.UTC(1971, 1, 14), 2.42],
                         [Date.UTC(1971, 2, 6), 2.74],
                         [Date.UTC(1971, 2, 14), 2.62],
                         [Date.UTC(1971, 2, 24), 2.6],
                         [Date.UTC(1971, 3, 2), 2.81],
                         [Date.UTC(1971, 3, 12), 2.63],
                         [Date.UTC(1971, 3, 28), 2.77],
                         [Date.UTC(1971, 4, 5), 2.68],
                         [Date.UTC(1971, 4, 10), 2.56],
                         [Date.UTC(1971, 4, 15), 2.39],
                         [Date.UTC(1971, 4, 20), 2.3],
                         [Date.UTC(1971, 5, 5), 2],
                         [Date.UTC(1971, 5, 10), 1.85],
                         [Date.UTC(1971, 5, 15), 1.49],
                         [Date.UTC(1971, 5, 23), 1.08]*/
<?= $get_monthwise_transfer ?>
                    ]
                }]
        });
    });
</script>
