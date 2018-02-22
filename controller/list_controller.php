<?php
	class ListController
	{
		
		static function list_functions($do)
		{

			$search_fields = array();
		
			###	Date Format Function
			###	Created : 28/08/2016
			###	Modified : 28/08/2016
			switch ($do) {
				
				case 'list_sample':
				
					$table_name = "test";
					$order_by = "id desc"; // Column name to be order and which order (asc or desc)
					$list_head = "List Sample";
					$edit_column = 'id';
					
					//Search Area
					$search_fields[] = array('date','Date_Name1','Date_Name',date("d/m/Y")." 00:00 - ".date("d/m/Y H:i"),'','','style="width: 260px; height:25px;"');
					$search_fields[] = array('select','Select_Head','Radio_Name','gender_array','','','style="width: auto; height:25px;vertical-align:top;"');	
					$search_fields[] = array('select','Select_Head','Select_Name','user_type','*','','style="width: auto; height:25px;vertical-align:top;"');				

					//List Fields
					//$list_fields[] = array('Textbox_Head','Textbox_Name','','');
					//$list_fields[] = array('Password_Head','Password_Name','','');
					//$list_fields[] = array('Hidden_Head','Hidden_Name','','');
					$list_fields[] = array('Select_Head','Select_Name','user_type','');
					//$list_fields[] = array('Radio_Head','Radio_Name','','');
					//$list_fields[] = array('Checkbox_Head','Checkbox_Name','','');
					//$list_fields[] = array('Textarea_Head','Textarea_Name','','');
					$list_fields[] = array('File_Head','files','file','');
					$list_fields[] = array('File_Head','files1','file','');
					$list_fields[] = array('Date_Head','Date_Name','date','Y-m-d');
				
				break;
				
				case 'list_user': 
					$table_name = "vw_users";
					$order_by = "user_account_id asc"; // Column name to be order and which order (asc or desc)
					$list_head = "Registered Users";
					$edit_column = 'user_account_id';
					
					//Search Area
					//$search_fields[] = array('date','Datestamp','date_stamp',date("d/m/Y")." 00:00 - ".date("d/m/Y H:i"),'','','style="width: 260px; height:25px;"');
					$search_fields[] = array('select','Select_Head','Radio_Name','gender_array','','','style="width: auto; height:25px;vertical-align:top;"');	
					//$search_fields[] = array('select','Select_Head','Select_Name','user_type','*','','style="width: auto; height:25px;vertical-align:top;"');				

					//List Fields
					$list_fields[] = array('Firstname','firstname','','');
					$list_fields[] = array('Lastname','lastname','','');
					//$list_fields[] = array('Gender','gender','','');
					$list_fields[] = array('Mobile','mobile','','');
					$list_fields[] = array('User Type','user_type','','');
					$list_fields[] = array('Email','email','','');
					$list_fields[] = array('Valid From','valid_from','date','d-m-Y');
					$list_fields[] = array('Valid To','valid_to','date','d-m-Y');					
					$list_fields[] = array('Status','account_status','','');
			
				break;
				
				
				case 'list_user_type': 
					$table_name = "user_type";
					$order_by = "id asc"; // Column name to be order and which order (asc or desc)
					$list_head = "User Type";
					$edit_column = 'id';
					
					//Search Area
					//$search_fields[] = array('date','Datestamp','date_stamp',date("d/m/Y")." 00:00 - ".date("d/m/Y H:i"),'','','style="width: 260px; height:25px;"');

					//List Fields
					$list_fields[] = array('User Type','user_type','','');
					$list_fields[] = array('Description','description','','');
					$list_fields[] = array('Status','status','','');
					$list_fields[] = array('Created Date','date_stamp','date','d-m-Y');
			
				break;

				case 'list_screen': 
					$table_name = "screen";
					$order_by = "id asc"; // Column name to be order and which order (asc or desc)
					$list_head = "List Screen";
					$edit_column = 'id';
					
					//Search Area
					//$search_fields[] = array('date','Datestamp','date_stamp',date("d/m/Y")." 00:00 - ".date("d/m/Y H:i"),'','','style="width: 260px; height:25px;"');

					//List Fields
					$list_fields[] = array('Screen Name','screen_name','','');
					$list_fields[] = array('Description','description','','');
					$list_fields[] = array('Status','status','','');
					$list_fields[] = array('Created Date','date_stamp','date','d-m-Y');
			
				break;
				
				case 'list_single': 
					$table_name = "screen";
					$order_by = "id asc"; // Column name to be order and which order (asc or desc)
					$list_head = "List Screen";
					$edit_column = 'id';
					
					//Search Area
					//$search_fields[] = array('date','Date_Stamp','date_stamp',date("d/m/Y")." 00:00 - ".date("d/m/Y H:i"),'','','style="width: 260px; height:25px;"');
					$search_fields[] = array('date','Date_Stamp','date_stamp','','','','style="width: 260px; height:25px;"');
					$search_fields[] = array('select','Select_Head','Status','status_array','','','style="width: auto; height:25px;vertical-align:top;"');	
					//$search_fields[] = array('select','Select_Head','Select_Name','user_type','*','','style="width: auto; height:25px;vertical-align:top;"');				

					//List Fields
					$list_fields[] = array('Screen Name','screen_name','','');
					$list_fields[] = array('Description','description','','');
					$list_fields[] = array('Status','status','','');
					$list_fields[] = array('Created Date','date_stamp','date','d-m-Y');
			
				break;


				case 'list_acl_screen': 
					$table_name = "screen";
					$order_by = "id asc"; // Column name to be order and which order (asc or desc)
					$list_head = "List Screen";
					$edit_column = 'id';
					
					//Search Area
					$search_fields[] = array('select','User','Select User for ACL Screen','users','*','','style="width: auto; height:25px;vertical-align:top;"');	

					//List Fields
					$list_fields[] = array('Screen Name','screen_name','','');
					$list_fields[] = array('Description','description','','');
					$list_fields[] = array('Status','status','','');
					$list_fields[] = array('Created Date','date_stamp','date','d-m-Y');
			
				break;

				
				case 'list_device_type': 
					$table_name = "device_type";
					$order_by = "id asc"; // Column name to be order and which order (asc or desc)
					$list_head = "List Device Type";
					$edit_column = 'id';
					
					//Search Area
					//$search_fields[] = array('select','User','Select User for ACL Screen','users','','','style="width: auto; height:25px;vertical-align:top;"');	

					//List Fields
					$list_fields[] = array('Device Type Name','device_type_name','','');
					$list_fields[] = array('Description','description','','');
					$list_fields[] = array('Status','status','','');
					$list_fields[] = array('Created Date','date_stamp','date','d-m-Y');
			
				break;

				case 'list_logs': 
					$table_name = "logs";
					$order_by = "id desc"; // Column name to be order and which order (asc or desc)
					$list_head = "All Logs";
					$edit_column = 'id';
					
					//Search Area
					//$search_fields[] = array('select','User','Select User for ACL Screen','users','','','style="width: auto; height:25px;vertical-align:top;"');	

					//List Fields
					$list_fields[] = array('Account ID','user_account_id','','');
					$list_fields[] = array('Activity','activity','','');
					$list_fields[] = array('Datestamp','date_stamp','date','d-m-Y');
			
				break;

				
				
				
				default:
				include 'views/screen/404.php';
				exit;
				break;
				
			}
	
		/* Your new page can write it here */
		
		
		
		
		
		
		
		
		
		
		/* Your new page end here  */

		// Final return value - dont touch it
			return array($table_name, $order_by, $list_head, $search_fields, $list_fields, $edit_column);
		}	
	}
?>