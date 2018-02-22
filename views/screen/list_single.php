<?php

	// error Message print from request method	
	if (isset($_REQUEST['msg']) || isset($this->message)) {
	
		if(isset($this->message)) {
			$this->message = $this->message;
			$mt = 'danger';
		} else {
			$this->message = $_REQUEST['msg'];
			$mt = $_REQUEST['mt'];
		}	
		
		if (isset($this->message) && !empty($this->message) ) {
	  ?>
		<div class="alert alert-<?=$mt?> alert-dismissible fade in" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		  </button>
		  <?=$this->message?>
		</div>		
		<?php
		}
	}
	
	// Getting values from controller
	$order_by = $this->data[0];
	$list_head = $this->data[1];
	$search_fields = $this->data[2];
	$list_fields = $this->data[3];
	$list_values = $this->data[4];
	$edit_column = $this->data[5];
	$list_page = str_replace('list','add',$do);
	
	// Edit, Delete option parameter 
	$options = null;
	if(isset($_REQUEST['opt']))
		$options = $_REQUEST['opt'];	
?>

	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2><?=(empty($list_head)?$do : $list_head)?></h2>
		<ul class="nav navbar-right panel_toolbox">
		  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
		  <!--
		  <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
			<ul class="dropdown-menu" role="menu">
			  <li><a href="#">Settings 1</a>
			  </li>
			  <li><a href="#">Settings 2</a>
			  </li>
			</ul>
		  </li>
		  -->
		  <li><a class="close-link"><i class="fa fa-close"></i></a>
		  </li>
		</ul>
		<div class="clearfix"></div>
	  </div>
	  
	  <div class="x_content">
		<!--<p class="text-muted font-13 m-b-30">
		  The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
		</p>-->
		<form id="search-form" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="">
		<table id="datatable-buttons" class="table table-striped table-bordered" style='color:#2A3F54'>
		<div class="control-group">
		  <div class="controls">
			<div class="input-prepend input-group">
			<div class="form-group">
			<?php
			$calendar_fields = null;
			if (count($search_fields) >= 1) {
				foreach ($search_fields as $forms) {
					
					switch ($forms[0]) {
						
						case 'date':			
						(empty($_REQUEST[$forms[2]])? $Date_Val = $forms[3] : $Date_Val = $_REQUEST[$forms[2]]);
						$search_values = $this->func_search_element($forms[0], $forms[2], $Date_Val, $forms[4], $forms[5], $forms[6]);
						echo $search_values[0];
						$calendar_fields.= $search_values[1];
						break;
						
						case 'select':					
						(empty($_REQUEST[$forms[2]])? $Select_Val = $forms[2] : $Select_Val = $_REQUEST[$forms[2]]);
						$search_values = $this->func_search_element($forms[0], $forms[2], $this->arr->array_func($forms[3]), $forms[4], $Select_Val, $forms[6]);
						echo "&nbsp;".$search_values[0];
						break;
					}		
			?>			
			<?php	
				}
			?>
				&nbsp;&nbsp;
				<?php
				// Add cancel button if submit button as default
				$search_values = $this->func_search_element('submit', 'search_'.$do, 'Search','*', 'btn btn-primary btn-sm', "");
				echo $search_values[0];
				echo $this->func_form_element('button',$forms[2],'Cancel',$forms[4],'btn btn-warning btn-sm',"onclick=goto_url('".$do."')");
				?>
				</div>
			<?php
			}
			?>		
			</div>
		  </div>
		</div>
		</form>
		<div class="ln_solid"></div>
		  <thead>
			<tr>
				<th class='list_header'>Sno</th>
			<?php
			### Heading of the List page
			foreach ($list_fields as $fields) {
			?>
			  <th class='list_header'><?=$fields[0]?></th>
			<?php
			}
			?>
			<?php
				// Delete option only for admin
				if ($user_type_id == 1 && $write_access == 1) {
			?>
				<th class='list_header'>Options</th>
			<?php
				}
			?>	
			</tr>
		  </thead>
		  
		  <tbody class='list_body'>

		  <form id="list-form" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="">
		  
			<?php
			$i = 0;
			$sno = 1;
			if (count($list_values) >= 1) {
				foreach ($list_values as $fields) {
					$editval = $fields[$edit_column];
			?>
			<tr>
				
				<?php
					// Delete option only for admin
					if (($user_type_id == 1 && $options == 'edit') || ($write_access == 1 && $options == 'edit')) {
				?>
					<td>
						<a href="index.php?do=<?=$list_page?>&ac=<?=$fields[$edit_column]?>&clm=<?=$edit_column?>">
							<img src='./images/edit.png' width='15px' height='15px' title="edit"></a>&nbsp; &nbsp;
					</td>		
				<?php
					}
					if (($user_type_id == 1 && $options == 'delete') || ($read_access == 1 && $options == 'delete')) {
				?>	
					<td>
						<a href="index.php?do=<?=$do?>&ac=<?=$fields[$edit_column]?>&clm=<?=$edit_column?>" onclick="return delete_alert_func('You are about to delete the Record',this.form,'list-form')">
							<img src="./images/delete.jpg" width="12px" height="12px" title="delete">
						</a>
					</td>
				<?php
					}
				?>	
					<td><?=$sno?></td>
				<?php
					$j = 0;
					$class = null;
					foreach ($list_fields as $fields) {

						## Validation for other text fields 
						if (strlen($list_values[$i][$fields[1]]) > 150) {
							$list_values[$i][$fields[1]] = substr($list_values[$i][$fields[1]],0,150)."...";
						}

						## Validation for other text fields 
						if (empty($fields[2]) && @unserialize($list_values[$i][$fields[1]]) !== false) {
							$list_values[$i][$fields[1]] = join(",",@unserialize($list_values[$i][$fields[1]]));
						}
							
						## Validation for other Date Field
						if ($fields[2] == 'date') {
							$list_values[$i][$fields[1]] = $this->help->date_format_func_ext($list_values[$i][$fields[1]],$fields[3]);	
							$class = null;
						}
						## Validation for Array Field
						if ($fields[2] == 'array') {
							$list_values[$i][$fields[1]] = $this->help->date_format_func_ext($list_values[$i][$fields[1]],$fields[3]);	
						}
						
						## Validation for Status Field
						if ($fields[0] == 'Status') {
							//<button type="button" class="btn btn-danger">Danger</button
							$status = $this->arr->status_lable_array($list_values[$i][$fields[1]]);
							$list_values[$i][$fields[1]] = "<span class='label label-".$status." pull-left'>".$list_values[$i][$fields[1]]."</span>";
						}
						## Files Type
						else if ($fields[2] == 'file') {

							if (file_exists('./'.CONFIG::UPLOADS_PATH."/".$editval."_".$list_values[$i][$fields[1]])) {
								if (!preg_match("/\.(png|jpg|JPG|gif)$/",$list_values[$i][$fields[1]],$ext)) {
									$list_values[$i][$fields[1]] = "<a href='./".CONFIG::UPLOADS_PATH."/".$editval."_".$list_values[$i][$fields[1]]."'>".$list_values[$i][$fields[1]]."</a>";
									$class = '<i class="fa fa-paperclip"></i> ';
								}	
								else {
									$list_values[$i][$fields[1]] = "<a href='./".CONFIG::UPLOADS_PATH."/".$editval."_".$list_values[$i][$fields[1]]."'><img src='./".CONFIG::UPLOADS_PATH."/".$editval."_".$list_values[$i][$fields[1]]."' width='25px' height='25px'></a>";
								}	
							}
							else {
								$list_values[$i][$fields[1]] = "NA";
								$class = null;
							}						
						}
						## Validation for Dropdown
						else if (!empty($fields[2]) && $fields[2] != 'date' && $fields[2] != 'array') {
							$Append_Array = $this->arr->array_func($fields[2]);
							//assign the value when array doesn't have any value
							if (empty($Append_Array[$list_values[$i][$fields[1]]])){
								$Append_Array[$list_values[$i][$fields[1]]] = '-na-';
							}		
							$list_values[$i][$fields[1]] = $Append_Array[$list_values[$i][$fields[1]]];
						}
				?>
						<td><?=$class?><?=$list_values[$i][$fields[1]]?></td>
				 <?php
						$j++;
					}
				 ?> 
				 
					<?php
						// Delete option only for admin
						if ($user_type_id == 1 && $write_access == 1) {
					?>
						<td>
							<a href="index.php?do=<?=$list_page?>&ac=<?=$editval?>&clm=<?=$edit_column?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a>
							<a href="index.php?do=<?=$do?>&ac=<?=$editval?>&clm=<?=$edit_column?>" onclick="return delete_alert_func('You are about to delete the Record',this.form,'list-form')"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
						</td>
					<?php
						}
					?>	
					
				</tr>   
			<?php
					$i++;
					$sno++;
				}
			}	
			?>
		  </tbody>
		  </form>
		</table>
	  </div>
	</div>
	</div>
	