<?php 
/**
	calling common information
**/	
$common = GatewayController::getInstance();

?>

<?php
	if (isset($seo_message)) {
		echo $seo_message;
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?=$common->seo_description?>">
	<meta name="keywords" content="<?=$common->seo_keyword?>">
	<meta name="copyright" content="<?=date('Y')?> <?=CONFIG::WEBSITE_NAME?>">
	<meta name="author" content="<?=CONFIG::WEBSITE_NAME?>">
	<meta name="email" content="webmaster@<?=CONFIG::WEBSITE_NAME?>">
	<meta name="Charset" content="ISO-8859-1">
	<meta name="Distribution" content="Global">
	<meta name="Rating" content="General">
	<meta name="Robots" content="INDEX,FOLLOW">
	<meta name="Revisit-after" content="1 Day">	
    <title><?=$common->page_title?></title>
	
	<!-- Bootstrap -->
	<link href="./follow/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="./follow/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="./follow/iCheck/skins/flat/green.css" rel="stylesheet">
	
	<!-- bootstrap-progressbar -->
	<link href="./follow/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
	<!-- jVectorMap -->
	<!--<link href="./css/maps/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>-->

	<!-- Custom Theme Style -->
	<link href="./build/css/custom.min.css" rel="stylesheet">

	<!-- jQuery custom content scroller -->
	<link href="./follow/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>		
	
	
	<?php
	/**
	
	For List pages
	
	**/
	if (substr($do,0,4) == 'list') {
		
	?>
		<!-- Datatables -->
		<link href="./follow/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
		<link href="./follow/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
		<link href="./follow/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
		<link href="./follow/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
		<link href="./follow/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
		
	<?php
	} 
	?>
	   <!-- bootstrap-wysiwyg -->
	<link href="./follow/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="./follow/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="./follow/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="./follow/starrr/dist/starrr.css" rel="stylesheet">
	
	<!-- Extra javascript -->
	<script src="./js/jscript.js"></script>
	
	<script>
	// placing the edit/ delete link for administration
	function options_link(){
		var link_option_renewal = '';
		var link_option_user = '';
		var link_default = "&nbsp;&nbsp;<a href='index.php?do="+gup('do')+"&opt=edit' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i>Edit</a><a href='index.php?do="+gup('do')+"&opt=delete' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i>Delete</a>";
		
		<?php
		/*
			All user type 
		*/
		if ($common->user_type_id == 1 || $common->write_access == 1) {
			
			switch ($do) {
				case 'list_login':
			?>	
					link_option_renewal = "<a href='index.php?do="+gup('do')+"&opt=license' class='btn btn-success btn-xs'><i class='fa fa-laptop'></i> User Renewal</a>";
			<?php		 
				break;
				case 'list_user':
			?>	
					link_option_user = "<a href='index.php?do=add_login' class='btn btn-warning btn-xs'><i class='fa fa-circle-o'></i> Add User Login</a>";
			<?php		 
			break;
				default:
				break;
			}
		?>
			var options = link_default+''+link_option_user+''+link_option_renewal;
			return options;
		<?php
		} else {
		?>
			return null;
		<?php 
		}
		?>
	}
	</script>
	
  </head>

  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php?do=home" class="site_title"><i class="fa fa-cab"></i> <span><?=CONFIG::APP_NAME?></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <!--<div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
              </div>-->
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
		
			<?php
				include("sidemenu.php");
			?>			
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
			
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <!--<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> -->
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <!--<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span> -->
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <!--<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> -->
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <!--<span class="glyphicon glyphicon-off" aria-hidden="true"></span> -->
              </a>
            </div>
			
            <!-- /menu footer buttons -->
          </div>
        </div>
		
		
        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/profile_m.jpg" alt=""><?=$common->user_name?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="index.php?do=profile"> Profile</a></li>
                   <!--   <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>-->
                    <li><a href="index.php?do=logout"><i class="fa fa-sign-out pull-right"></i>Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->