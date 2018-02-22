<?php
	//Header File Include
	include("header.php");
?>	

	<!-- page content -->
	<div class="right_col" role="main">
		<?php
			if ($do) {
				require_once(''.$do.'.php');
			}	
		?> 
	</div>&nbsp;
	<!-- /page content -->
	
<?php
	if (substr($do,0,4) == 'add_') {
		//For all add page
		include("footer_form.php");
	}
	else if (substr($do,0,4) == 'list') {
		//For all list page
		include("footer_list.php");
	}
	else if ($do == 'dashboard') {
		//For all list page
		include("footer_home.php");
	}
	else {
		//For all other page
		include("footer.php");
	}
	
?>