<?php
		
	// Getting values from controller
	$list_head = $this->data[1];
	$list_head_desc = $this->data[2];
	$form_fields = $this->data[3];
	if (isset($this->data[4]))
		$ac = $this->data[4];
	
	// Changing heading when the page in edit mode
	if (isset($ac)) {
		$list_head = str_replace("Add","Update",$list_head);
		$list_head_desc = str_replace("add","update",$list_head_desc);
	}
?>
	<div class="">
		<div class="row">
			<div class="col-md-8 col-sm-8 col-xs-12">
				<div class="x_panel">
				<div class="x_title">
				  <h2><?=$list_head?><small><?=$list_head_desc?></small></h2>
				  <ul class="nav navbar-right panel_toolbox">
					 <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					 </li>
					 <li><a class="close-link"><i class="fa fa-close"></i></a></li>
				  </ul>
				  <div class="clearfix"></div>
				</div>
			<div class="x_content">
			  <br />
			  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="" enctype="multipart/form-data" >
			  
				<?php
				foreach ($form_fields as $forms) {
					switch ($forms[0]) {
						case 'textbox':					
						case 'password':
						case 'file':
				?>						
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="<?=$forms[1]?>"><?=$forms[1]?><span class="required"><?=$forms[4]?></span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?=$this->func_form_element($forms[0],$forms[2],$forms[3],$forms[4],$forms[5],$forms[6]);?>
						</div>
					</div>
				<?php
				if (isset($ac) && $forms[0] == 'file') {
				?>	
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="<?=$forms[1]?>"></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
						<?php
						$file_display = null;
						## Files Type
						if (file_exists('./'.CONFIG::UPLOADS_PATH."/".$ac."_".$forms[3])) {
							if (!preg_match("/\.(png|jpg|JPG|gif)$/",$forms[3],$ext))
								$file_display = "<a href='./".CONFIG::UPLOADS_PATH."/".$ac."_".$forms[3]."'>".$forms[3]."</a>";
							else
								$file_display = "<a href='./".CONFIG::UPLOADS_PATH."/".$ac."_".$forms[3]."'><img src='./".CONFIG::UPLOADS_PATH."/".$ac."_".$forms[3]."' width='25px' height='25px'></a>";
						}
						else {
							$file_display = "NA";
						}		
						echo $file_display;						
						?>
						</div>
					</div>
				<?php
				}
				?>	
					
				<?php	
						break;						
						case 'head':					
				?>						
					<div class="ln_solid"></div>
						  <h2><small><b><?=$forms[1]?></b> --- <?=$forms[2]?></small></h2>
					<div class="ln_solid"></div>
					
				<?php	
						break;						
						case 'textarea':					
				?>						
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="<?=$forms[1]?>"><?=$forms[1]?><span class="required"><?=$forms[4]?></span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
						<label for="message">Message (20 chars min, 100 max) :</label>
							<?=$this->func_form_element($forms[0],$forms[2],$forms[3],$forms[4],$forms[5],$forms[6]);?>
						</div>
					</div>
					
				<?php	
						break;
						case 'hidden':
							echo $this->func_form_element($forms[0],$forms[2],$forms[3],$forms[4],$forms[5],$forms[6]);
						break;
						
						case 'select':					
				?>						
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="<?=$forms[1]?>"><?=$forms[1]?><span class="required"><?=$forms[4]?></span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
						<?=$this->func_form_element($forms[0],$forms[2],$this->arr->array_func($forms[3]),$forms[4],$forms[5],$forms[6]);?>
						</div>
					</div>
					
				<?php	
						break;
						case 'radio':					
				?>						
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="<?=$forms[1]?>"><?=$forms[1]?><span class="required"><?=$forms[4]?></span></label>
						<div class="col-md-9 col-sm-9 col-xs-12" style="padding-top:10px;">
							<?php
							$Radio_Array = $this->arr->array_func($forms[3]);
							foreach ($Radio_Array as $Radios) {
							?>
								<?=$Radios?> <?=$this->func_form_element($forms[0],$forms[2],$Radios,$forms[4],$forms[5],$forms[6]);?>
							<?    
							}
							?>				
						</div>
					</div>
					
				<?php	
						break;
						case 'checkbox':					
				?>						
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="<?=$forms[1]?>"><?=$forms[1]?><span class="required"><?=$forms[4]?></span></label>
						<div class="col-md-9 col-sm-9 col-xs-12" style="padding-top:10px;">
							<?php
							$Checkbox_Array = $this->arr->array_func($forms[3]);
							if (isset($ac))
								$Checkbox_Values = array_flip(unserialize($forms[5]));
							$i = 0;
							foreach ($Checkbox_Array as $Checkbox) {
								if(isset($Checkbox_Values[$Checkbox], $Checkbox_Values))
									$forms[5] = $Checkbox;
							?>
								<?=$this->func_form_element($forms[0],$forms[2],$Checkbox,$forms[4],$forms[5],$forms[6]);?> <?=$Checkbox?><br />
							<?    
								$i++;
							}
							?>				
						</div>
					</div>
					
				<?php	
						break;
						case 'button':					
						case 'submit':					
				?>						
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<?php
							// update the submit value for edit page
							if (isset($ac))
								$forms[3] = str_replace("Add","Update",$forms[3]);
							?>
							<?php
							// Add cancel button if submit button as default
							if ($forms[0] == 'submit')
								echo $this->func_form_element('button',$forms[2],'Cancel',$forms[4],'btn btn-primary','onclick="goto_url()"');
							?>
							<?=$this->func_form_element($forms[0],$forms[2],$forms[3],$forms[4],$forms[5],$forms[6]);?>
						</div>
					</div>
					
				<?php	
						break;
					}		
				?>			
				<?php	
				}					
				?>

			  </form>
			</div>
			</div>
		</div>

			<div class="col-md-4 col-xs-12">
			 <div class="x_panel">
				<div class="x_title">
				  <h2>Form Basic Elements <small>different form elements</small></h2>
				  <ul class="nav navbar-right panel_toolbox">
					 <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					 </li>
					 <li><a class="close-link"><i class="fa fa-close"></i></a>
					 </li>
				  </ul>
				  <div class="clearfix"></div>
				</div>
				<div class="x_content">
				    
				</div>
			 </div>
			</div>
				
		</div>
		<form id="demo-form" data-parsley-validate></form>
          </div>
