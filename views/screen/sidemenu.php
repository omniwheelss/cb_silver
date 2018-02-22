
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
				<?php
				switch ($common->user_type_id) {
					case 1:
				?>
                <h3>Super Admin Section</h3>
				
                <ul class="nav side-menu">

				  <li><a><i class="fa fa-cloud-download"></i>Samples<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					  <li><a href="index.php?do=list_single">List Single Table</a></li>
					  <li><a href="index.php?do=list_multiple">List Multiple Table</a></li>
                    </ul>
                  </li>				
				
                  <li><a><i class="fa fa-anchor"></i>ACL Management<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					  <li><a href="index.php?do=list_screen">List Screens</a></li>
					  <li><a href="index.php?do=list_acl_screen">List ACL Screens</a></li>
                    </ul>
                  </li>
				  
                 <li><a><i class="fa fa-cog"></i>Other Settings<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					  <li><a href="index.php?do=list_logs">List Logs</a></li>
                    </ul>
                  </li>
				  
				  
                </ul>
				<?php
					break;
					case 2:
				?>
                <h3>Administrative Section</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i>User Section<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.php?do=add_sample">Add Sample</a></li>
                      <li><a href="index.php?do=list_sample">List Sample</a></li>
                    </ul>
                  </li>
                </ul>
				<?php
					break;

					case 3:
				?>
                <h3>User Section</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i>User Section<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.php?do=list_device_type">List Devices</a></li>
                    </ul>
                  </li>
                </ul>
				<?php
					break;
					default:
					break;
				}	
				?>	
              </div>
            </div>
			