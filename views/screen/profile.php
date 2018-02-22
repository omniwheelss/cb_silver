<?php
	// Getting values from controller
	$user_data = $user_datas;
	$firstname = $user_data['firstname'];
	$lastname = $user_data['lastname'];
	$fullname =  $firstname. " ".$lastname;
	$gender = $user_data['gender']; 
	$account_status = $user_data['account_status'];
	$mobile = $user_data['mobile']; 
	$address = $user_data['address'];
	$email = $user_data['email']; 
	$user_type_id = $user_data['user_type_id']; 
	$user_type = $user_data['user_type']; 
?>	
        <!-- page content -->
          <div class="">
            <div class="page-title"></div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Profile<small>settings</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
						  <?php
						  ($gender == 'male'? $gender_pre = 'm' : ($gender == 'female'? $gender_pre = 'f' : $gender_pre = 'g')) ;
						  ?>
                          <img class="img-responsive avatar-view" src="images/profile_<?=$gender_pre?>.jpg" alt="<?=$firstname?>" title="<?=$firstname?>">
                        </div>
                      </div>
                      <h3><?=$fullname?></h3>

                      <ul class="list-unstyled user_data">
					  <?php
					  if ($account_status == 'active') {
							$account_status = '<button type="button" class="btn btn-success btn-xs">&nbsp;ACTIVE&nbsp</button>';
					  }	else {
							$account_status = '<button type="button" class="btn btn-danger btn-xs">INACTIVE</button>';
					  }
					  
					  ?>
						<li><i class="fa fa-map-marker user-profile-icon"></i> Account Status: <?=$account_status?></li>
                        <li><i class="fa fa-building user-profile-icon"></i> <?=$address?></li>

                        <li><i class="fa fa-mobile user-mobile-icon"></i> <?=$mobile?></li>

                        <li class="m-top-xs">
                          <i class="fa fa-external-link user-profile-icon"></i>
                          <a href="http://www.kimlabs.com/profile/" target="_blank">NA</a>
                        </li>
                      </ul>

                      <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                      <br />

                      <!-- start skills -->
                      <!--<h4>Skills</h4>
                      <ul class="list-unstyled user_data">
                        <li>
                          <p>Web Applications</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                          </div>
                        </li>
                        <li>
                          <p>Website Design</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                          </div>
                        </li>
                        <li>
                          <p>Automation & Testing</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                          </div>
                        </li>
                        <li>
                          <p>UI / UX</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                          </div>
                        </li>
                      </ul>-->
                      <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                     <!-- <div class="profile_title">
                        <div class="col-md-6">
                          <h2>User Activity Report</h2>
                        </div>
                        <div class="col-md-6">
                          <div id="reportrange" class="pull-right" style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                          </div>
                        </div>
                      </div>
                      <!-- start of user-activity-graph --
                      <div id="graph_bar" style="width:100%; height:280px;"></div>
                      <!-- end of user-activity-graph -->

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Other Details</a>
                          </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                            <!-- start recent activity -->
                            <ul class="messages">
                              <li>
                                <img src="images/profile_m.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-info"><?=date('d')?></h3>
                                  <p class="month"><?=date('F')?></p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading"><?=$fullname?></h4>
                                  <blockquote class="message" style="font-size:13px;">coming soon... </blockquote>
                                  <br />
                                </div>
                              </li>
                            </ul>
                            <!-- end recent activity -->

                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

							coming soon...
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- /page content -->
