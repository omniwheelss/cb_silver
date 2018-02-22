<?php

/**

For add & edit form class

**/
class AddController
{

	static function add_functions($do) 
	{
		/**
			function to check query string to handle the page direction
			Created : 28/08/2016
			Modified : 28/08/2016
		**/	
		switch ($do) {
			
			// Sample one
			case 'add_sample':
			
				$table_name = "test";
				$list_head = "Add Sample";
				$list_head_desc = "Utilize this page to add sample information!!!!!";
				
				//Text boxes
				$form_fields[] = array('file','File_Head','files','File_Value','','','');
				$form_fields[] = array('password','Password_Head','Password_Name','Password_Value-1111','*','','');
				$form_fields[] = array('hidden','Hidden_Head','Hidden_Name','Hidden_Value-111','*','','');
				$form_fields[] = array('file','File_Head','files1','File_Value','','','');

				//Select
				$form_fields[] = array('head','Select boxes','Account login to access the application','','','','');
				$form_fields[] = array('select','Select_Head','Select_Name','user_type','*','','Select Data');	

				//Checkbox and Radio		
				$form_fields[] = array('radio','Radio_Head','Radio_Name','gender_array','*','Female','');
				$form_fields[] = array('checkbox','Checkbox_Head','Checkbox_Name[]','users','*','','');

				$form_fields[] = array('textarea','Textarea_Head','Textarea_Name','Textarea_Value','*','','');
				$form_fields[] = array('textbox','Date_Head','Date_Name',date("d/m/Y"),'*','Cal','');
				$form_fields[] = array('textbox','Textbox_Head','Textbox_Name','Textbox_Value','*','','');
				$form_fields[] = array('submit','','add_sample_submit','Submit Value','','','');
				//$form_fields[] = array('button','','Button_Name','Button Value','','','');
			break;
			
			/**
				for new user form
				Created : 27/11/2016
				Modified : 27/11/2016
			**/	
			case 'add_user': 
			
				$table_name = "vw_users";
				$list_head = "Add new user account";
				$list_head_desc = "Utilize this page to add user account information for the new user!!!!!";
				
				$form_fields[] = array('textbox','Firstname','firstname','','*','','');
				$form_fields[] = array('textbox','Lastname','lastname','','*','','');
				//$form_fields[] = array('radio','Gender','gender','gender_array','*','Male','');
				$form_fields[] = array('textbox','Mobile','mobile','','*','','');
				$form_fields[] = array('textarea','Address','address','','*','','');
				
				$form_fields[] = array('head','Add User Login','Account login to access the application','','','','');
				$form_fields[] = array('select','Type of Users','user_type_id','user_type','*','','');	
				$form_fields[] = array('textbox','Email','email','','*','','');
				
				$form_fields[] = array('head','Add License','License to access the application for particular time','','','','');
				$form_fields[] = array('textbox','License Starts From','valid_from','','*','Cal','');
				$form_fields[] = array('textbox','License End On','valid_to','','*','Cal','');
			
				
				$form_fields[] = array('hidden','date_stamp','date_stamp',date("Y-m-d H:i:s"),'*','','');
				$form_fields[] = array('submit','','add_user_submit','Register User','','','');
			
			break;
			
			
			/**
				USER TYPE form
				Created : 24/12/2016
				Modified : 24/12/2016
			**/	
			case 'add_user_type': 
			
				$table_name = "user_type";
				$list_head = "Add User Type";
				$list_head_desc = "Utilize this page to add user type for the users!!!!!";
				
				$form_fields[] = array('textbox','User Type','user_type','','*','','');
				$form_fields[] = array('textarea','Description','description','','*','','');
				
				$form_fields[] = array('hidden','date_stamp','date_stamp',date("Y-m-d H:i:s"),'*','','');
				$form_fields[] = array('submit','','add_user_type_submit','Add User Type','','','');
			
			break;			
			
			/**
				SCREEN form
				Created : 24/12/2016
				Modified : 24/12/2016
			**/	
			case 'add_screen': 
			
				$table_name = "screen";
				$list_head = "Add Screen";
				$list_head_desc = "Utilize this page to add new screen name!!!!!";
				
				$form_fields[] = array('select','Project','project_id','user_type','*','','Select Data');	
				$form_fields[] = array('textbox','Screen Name','screen_name','','*','','');
				$form_fields[] = array('textarea','Description','description','','*','','');
				
				$form_fields[] = array('hidden','date_stamp','date_stamp',date("Y-m-d H:i:s"),'*','','');
				$form_fields[] = array('submit','','add_screen_submit','Add New Screen','','','');
			
			break;		
			
			/**
				Sample Single Page form
				Created : 24/12/2016
				Modified : 24/12/2016
			**/	
			case 'add_single': 
			
				$table_name = "screen";
				$list_head = "Add Single Page";
				$list_head_desc = "Utilize this page to add new screen name!!!!!";
				
				$form_fields[] = array('select','Project','project_id','user_type','*','','Select Data');	
				$form_fields[] = array('select','Status','status','status_array','*','','');
				$form_fields[] = array('textbox','Screen Name','screen_name','','*','','');
				$form_fields[] = array('textarea','Description','description','','*','','');
				
				
				$form_fields[] = array('hidden','date_stamp','date_stamp',date("Y-m-d H:i:s"),'*','','');
				$form_fields[] = array('submit','','add_single_submit','Add New Screen','','','');
			
			break;			
			
			/**
				DEVICE TYPE form
				Created : 25/12/2016
				Modified : 25/12/2016
			**/	
			case 'add_device_type': 
			
				$table_name = "device_type";
				$list_head = "Add Device Type";
				$list_head_desc = "Utilize this page to add new device type!!!!!";
				
				$form_fields[] = array('textbox','Device Type Name','device_type_name','','*','','');
				$form_fields[] = array('textarea','Description','description','','*','','');
				
				$form_fields[] = array('hidden','date_stamp','date_stamp',date("Y-m-d H:i:s"),'*','','');
				$form_fields[] = array('submit','','add_device_type_submit','Add New Device Type','','','');
			
			break;			
			


			
			
			
			
			default:
			include 'views/screen/404.php';
			exit;
			break;
		}
		
		/* Your new page can write it here */
		
		
		
		
		/* Your new page end here  */

		// Final return value - dont touch it
		return array($table_name,$list_head,$list_head_desc,$form_fields);
	}	
}
?>