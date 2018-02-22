<?php

/**

Includes all other controllers and models

**/
require_once 'model/common_service.php';
require_once 'includes.php';

class DynamicController
{

	private $CommonService = NULL;
	
	//Invoke model to access all the methods
	public function __construct()
	{
		$this->CommonService = new CommonService();
		$this->help = new HelperController();
		$this->lists = new ListController();
		$this->login = new LoginController();
		$this->add = new AddController();
		$this->arr = new ArrayController();
	}

	
	
	/**
	
		Add & Edit related function 
		Created : 17/09/2016
		Modified : 11/11/2016
	
	**/
	public function handle_screen($do, $user_account_id, $user_type_id, $read_access, $write_access)
	{
	
		// get query parameters
		$ac = isset($_REQUEST['ac'])?$_REQUEST['ac']:NULL;
		$clm = isset($_REQUEST['clm'])?$_REQUEST['clm']:NULL;
		
		
		/**
			Edit related function 
		**/
		if ($do == 'add_user' && $clm && $ac) {
			$this->form_user_edit_function ($do, $user_account_id, $user_type_id, $read_access, $write_access, $clm, $ac); 
		}
		/**
			Edit related function 
		**/
		else if (substr($do,0,4) == 'add_' && $clm && $ac) {
			$this->form_edit_function ($do, $user_account_id, $user_type_id, $read_access, $write_access, $clm, $ac); 
		}
		/**
			Add related function 
		**/
		else if (substr($do,0,4) == 'add_' && !$clm && !$ac) {
			$this->form_add_function ($do, $user_account_id, $user_type_id, $read_access, $write_access); 
		}
		/**
			List Edit/Delete related function 
		**/
		else if (substr($do,0,5) == 'list_' && $clm && $ac) {
			$this->form_delete_function ($do, $user_account_id, $user_type_id, $read_access, $write_access, $clm, $ac); 
		}
		/**
			List page redirection
		**/
		else if (substr($do,0,5) == 'list_') {
			$this->form_list_function ($do, $user_account_id, $user_type_id, $read_access, $write_access); 
		}
		
		
		
	}



	/**
	
		Search fields form creation function
		Created : 18/09/2016
		Modified : 17/11/2016
	
	**/
	static function func_form_element($field_type, $field_name, $field_value, $manditary, $common_value, $extra) {
		
		$field_type = @strtolower($field_type);
		// Javascript Validation
		($manditary == "*"? $manditary = 'required="required"' : $manditary = null);
		// Calendar Func Checking	
		
		($common_value == 'Cal'? $cal = "date-picker" : $cal = null);
		
		switch ($field_type) {
			case 'textbox':
			case 'password':
			case 'hidden':
			case 'file':
				$form_fields = '<input type="'.$field_type.'" name="'.$field_name.'" id="'.$field_name.'" value="'.$field_value.'" '.$manditary.' class ="'.$cal.' form-control col-md-7 col-xs-12" '.$extra.' />';
			break;

			case 'textarea':
				$form_fields = '<textarea type="'.$field_type.'" name="'.$field_name.'" id="'.$field_name.'" '.$manditary.' class ="form-control" data-parsley-trigger="keyup" data-parsley-minlength="5" data-parsley-minlength-message="Come on! You need to enter at least a 5 characters long comment.."  '.$extra.' >'.$field_value.'</textarea>';
			break;
			
			case 'radio':
			case 'checkbox':
				$Match_final = ($field_value == $common_value ? 'checked="checked"' : '');;
				$form_fields = '<input type="'.$field_type.'" name="'.$field_name.'" id="'.$field_name.'" value="'.$field_value.'" '.$manditary.' class ="flat"  '.$Match_final.' />';
			break;
			
			case 'select':
				if (empty($common_value)) $common_value = 'selected="selected"';
				$form_fields= '
					<select name="'.$field_name.'" id="'.$field_name.'" class ="form-control" '.$manditary.' '.$extra.'  />
						<option value="" '.$common_value.'>------- Select Value Below -------</option>';
						if (count($field_value) >= 1) {
							while (list ($key, $f_value) = each ($field_value)) {
								$form_fields.= '<option value="'.$key.'" '.($key == $common_value ? 'selected="selected"' : "").'>'.$f_value.'</option>';
							}
						}	
				$form_fields.=	'</select>';
			break;
			
			case 'button':
			case 'submit':
				($common_value == ''? $Class = "btn btn-success" : $Class = $common_value);
				$form_fields = '<input type="'.$field_type.'" name="'.$field_name.'" id="'.$field_name.'" value="'.$field_value.'" class ="'.$Class.'" '.$extra.' />';
			break;

			default:
			break;
		}
		return $form_fields;
	}
	

	
	/**
	
		search fields form creation function
		Created : 12/11/2016
		Modified : 17/11/2016
		
	**/
	static function func_search_element($field_type, $field_name, $field_value, $manditary, $common_value, $extra) {
		
		$field_type = @strtolower($field_type);
		$calendar_fields = null;
		// Javascript Validation
		($manditary == "*"? $manditary = 'required="required"' : $manditary = null);
		// Calendar Func Checking	
		
		($common_value == 'Cal'? $cal = "date-picker" : $cal = null);
		
		switch ($field_type) {

			case 'date':
				$search_fields = '<input type="text" placeholder = "Date Search" name="'.$field_name.'" id="'.$field_name.'" value="'.$field_value.'" '.$manditary.' class ="'.$cal.' form-control" '.$extra.' />';
				$calendar_fields = '
			
				<script type="text/javascript">
				$(function() {
					$(\'input[name="'.$field_name.'"]\').daterangepicker({
						timePicker: true,
						timePickerIncrement: 30,
						locale: {
							format: \'DD/MM/YYYY HH:mm\'
						}
					});
				});
				</script>';
				
			break;
			
			case 'select':
				if (empty($common_value)) $common_value = 'selected="selected"';
				$search_fields= '
					<select name="'.$field_name.'" id="'.$field_name.'" class ="form-control_" '.$manditary.' '.$extra.' />
						<option value="" '.$common_value.'>------- '.$field_name.'-------</option>';
						if (count($field_value) >= 1) {
							while (list ($key, $f_value) = each ($field_value)) {
								$search_fields.= '<option value="'.$key.'" '.($key == $common_value ? 'selected="selected"' : "").'>'.$f_value.'</option>';
							}
						}
				$search_fields.=	'</select>';
			break;
			
			case 'button':
			case 'submit':
				($common_value == ''? $Class = "btn btn-success" : $Class = $common_value);
				$search_fields = '<input type="'.$field_type.'" name="'.$field_name.'" id="'.$field_name.'" value="'.$field_value.'" class ="'.$Class.'" '.$extra.' />';
			break;
			
			default:
			break;
		}
		return array($search_fields, $calendar_fields);
	}
		
	
	

	/**
	
		Form List function 
		Created : 17/09/2016
		Modified : 09/12/2016
	
	**/
	public function form_list_function($do, $user_account_id, $user_type_id, $read_access, $write_access)
	{
		//For all list page
		$list_array = $this->lists->list_functions($do);
		$search_submit = "search_".$do;
		
		/**
		
			when SEARCH area get submitted
		**/	
		if ( isset($_REQUEST[$search_submit])) {
			//print_r($do);exit;
			$this->data = $this->CommonService->list_data_db($list_array,$do);
			$lists_status = $this->data[6];
			$log_data = $this->data[7];
			$search_data = $this->data[8];
			$log_data = "|list data|".$do."|".$user_account_id."|".$search_data."|".$log_data."|";
			$this->data_logger_set($user_account_id, $log_data, $lists_status, 'no');
			
		}
		else {
			/*
				when call for list page
			*/	
			$this->data = $this->CommonService->list_data_db($list_array, $do);
			$lists_status = $this->data[6];
			$log_data = $this->data[7];
			$log_data = "|".$do."|".$user_account_id."|".$log_data."|";
		}
		/*
			Log only when error generated
		*/
		if ($lists_status == 'error') {
			$redirect = 'no';
			$this->message = "Oops! There is problem with back end. we will be back soon..";
			$this->data_logger_set($user_account_id, $log_data, $lists_status, $redirect);
		}
		
		include Config::VIEWS_PATH."/home.php";
		exit;
	}

	
	
	/**
	
		Form List USER function 
		Created : 21/12/2016
		Modified : 21/12/2016
	
	**/
	public function form_list_user_function($do, $user_account_id, $user_type_id, $read_access, $write_access)
	{
		//For all list page
		$list_array = $this->lists->list_functions($do);
		$search_submit = "search_".$do;
		
		/**
		
			when SEARCH area get submitted
		**/	
		if ( isset($_REQUEST[$search_submit])) {
			$this->data = $this->CommonService->list_user_data_db($user_account_id, $list_array,$do);
			$lists_status = $this->data[6];
			$log_data = $this->data[7];
			$search_data = $this->data[8];
			$log_data = "|list data|".$do."|".$user_account_id."|".$search_data."|".$log_data."|";
			$this->data_logger_set($user_account_id, $log_data, $lists_status, 'no');
			
		}
		else {
			/*
				when call for list page
			*/	
			$this->data = $this->CommonService->list_user_data_db($user_account_id, $list_array, $do);
			$lists_status = $this->data[6];
			$log_data = $this->data[7];
			$log_data = "|".$do."|".$user_account_id."|".$log_data."|";
		}
		/*
			Log only when error generated
		*/
		if ($lists_status == 'error') {
			$redirect = 'no';
			$this->message = "Oops! There is problem with back end. we will be back soon..";
			$this->data_logger_set($user_account_id, $log_data, $lists_status, $redirect);
		}
		
		include Config::VIEWS_PATH."/home.php";
		exit;
	}

	
	

	
	/**
	
		Form Add function 
		Created : 17/09/2016
		Modified : 11/11/2016
	
	**/
	public function form_add_function($do, $user_account_id, $user_type_id, $read_access, $write_access)
	{
		$this->data = $this->add->add_functions($do);
		$this->insert_data($do, $this->data, $user_account_id);
		$this->help->goto_view($do);
	}

	
	
	/**
	
		Form Edit function 
		Created : 17/09/2016
		Modified : 11/11/2016
	
	**/
	public function form_edit_function($do, $user_account_id, $user_type_id, $read_access, $write_access, $clm, $ac)
	{
		// get query parameters
		$log_data  =  $edit_status  =  null;
		
		
		// Checking write permission 
		if ($write_access == 0) {
			
			$log_message = "trying to access this page without permission";
			$log_data = "|access denied|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$log_message."|";
			$this->data_logger_set($user_account_id, $log_data, $edit_status, 'no');
			$this->help->goto_view('403');
			//include Config::VIEWS_PATH."/403.php";
			exit;
			
		}
		
		$this->data = $this->add->add_functions($do, $ac);
		
		/*
			Adding values to the existing array (usert_type_id ,access)
		*/
		array_push($this->data, $ac, $user_type_id, $read_access, $write_access);
		
		$this->data_db = $this->CommonService->do_select_db($this->data[0], $clm, $ac);
		$log_data = $this->data_db[0];
		$select_status = $this->data_db[1];
		$log_data = "|select query|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$log_data."|";
		($select_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
		// log the data only error case
		if ($select_status == 'error' || $select_status == 'wrong') {
			$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix, "");
			include Config::VIEWS_PATH."/404.php";
			exit;
		}	
		
		//Assigning values for edit based on the $ac
		$i = 0;
		foreach ($this->data[3] as $data) {
			
			if ($data[0] != 'submit' && $data[0] != 'button') {
				// Removing [] symbol from the add list if it's array
				$data[2] = str_replace("[]","",$data[2]);
				
				//Date Validation
				if ($data[5] == 'Cal') {
					$this->data[3][$i][3] = $this->help->date_format_func_ext($select_status[$data[2]], "d/m/Y");
				}
				// For Files
				else if ($data[0] == 'file') {
					$this->data[3][$i][3] = $select_status[$data[2]];
				}
				// For Radio, Checkbox and select 
				else if ($data[0] == 'radio' || $data[0] == 'checkbox' || $data[0] == 'select') {
					$this->data[3][$i][5] = $select_status[$data[2]];
				}	
				else {
					// All other data's
					if ($data[0] != 'head') {
						$this->data[3][$i][3] = $select_status[$data[2]];
					}
				}								
			}
			$i++;	
		}		
		$this->update_data($do, $this->data, $user_account_id);
	}




	/**	
	
		delete data for all the forms (add forms)
		Created : 17/09/2016
		Modified : 14/11/2016
	
	**/
	public function form_delete_function($do, $user_account_id, $user_type_id, $read_access, $write_access, $clm, $ac)
	{
	
		$file_names = null;
		
		// Checking write permission 
		if ($write_access == 0) {
			$log_message = "trying to access this page without permission";
			$log_data = "|access denied|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$log_message."|";
			$this->help->data_logger($log_data, Config::LOGS_PATH, Config::DAILY_LOG, "");
			include Config::VIEWS_PATH."/403.php.";
			exit;
		}
		/*
			get list item from lis controller
		*/
		$list_array = $this->lists->list_functions($do);

		foreach ($list_array[4] as $data) {
			// For Files
			if ($data[2] == 'file') {
				$file_names[] = $data[1];
			}
		}
		$delete_result = $this->CommonService->delete_data_db($list_array[0], $clm, $ac, $file_names);
		$log_data = $delete_result[0];
		$delete_id = $delete_result[1];
		$delete_status = $delete_result[2];
		$log_data = "|delete data|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$delete_id."|".$log_data."|";
		$this->data_logger_set($user_account_id, $log_data, $delete_status, 'no');
		if ($delete_status == 'wrong' || $delete_status == 'error') {
			include Config::VIEWS_PATH."/404.php";
			exit;
		}
		else if ($delete_status == 'success') {
			$this->message = "one record deleted successfully";	
			$mt = 'success';
		}

		$this->help->redirect('index.php?do='.$do.'&msg='.$this->message.'&mt='.$mt.'');
		exit;

	}
	
	

	/**	
	
		insert data for all the forms (add forms)
		Created : 17/09/2016
		Modified : 14/11/2016
	
	**/
	public function insert_data($do, $all_array, $user_account_id)
	{
		// Checking user logged or not
		$errors = array();
		$mt = null;
		
		/*
			Once the submit the data 
		*/
		if ( isset($_REQUEST[$do."_submit"])) {
			
			$list_page = str_replace('add','list',$do);
			$insert_result = $this->CommonService->do_add_db($_REQUEST, $do, $all_array);
			$log_data = $insert_result[0];
			$insert_id = $insert_result[1];
			$insert_status = $insert_result[2];
			$log_data = "|data insert|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$insert_id."|".$log_data."|";
			$this->data_logger_set($user_account_id, $log_data, $insert_status, 'no');

			if($insert_status == 'error') {
				$this->message = "Oops! There is problem with back end. we will be back soon..";
				$mt = 'danger';
			}
			else{
				$this->message = "New record created successfully";	
				$mt = 'success';		
			}
			
			$this->help->redirect('index.php?do=thank&msg='.$this->message.'&mt='.$mt.'');
			return;
		}
		include Config::VIEWS_PATH."/home.php";
		exit;
	}
	
	
	
	/**
	
		update data based on the $ac data once submitted
		Created : 17/09/2016
		Modified : 15/11/2016
	
	**/
	public function update_data($do, $all_array, $user_account_id)
	{
		$errors = array();
		$mt = null;
		if (isset($_REQUEST[$do."_submit"])) {
			$list_page = str_replace('add','list',$do);
			/**

			
			
			**/
			$update_result = $this->CommonService->do_update_db($_REQUEST, $do, $all_array);
			$log_data = $update_result[0];
			$update_id = $update_result[1];
			$update_status = $update_result[2];
			$log_data = "|data update|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$update_id."|".$log_data."|";
			$this->data_logger_set($user_account_id, $log_data, $update_status, 'no');
			
			if ($update_status == 'error') {
				$this->message = "Oops! There is problem with back end. we will be back soon..";
				$mt = 'danger';
			}
			else {
				if (empty($update_result[0])) {
					$this->message = "no update has been made.";
					$mt = 'info';
				}	
				else {	
					$this->message = "one record updated successfully";			
					$mt = 'success';
				}	
			}
			$this->help->redirect('index.php?do='.$list_page.'&msg='.$this->message.'&mt='.$mt.'');
			return;
		}
		include Config::VIEWS_PATH."/home.php";
		exit;
	}
	
	
	
	
	/**	
	
		Data log and log into db function
		Created : 10/12/2016
		Modified : 10/12/2016
	
	**/
	public function data_logger_set($user_account_id, $log_data, $log_status, $redirect)
	{
	
		($log_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
		$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix,"");
		$this->CommonService->data_logger_db($user_account_id, $log_data, date("Y-m-d H:i:s"));
		if ($redirect == 'yes') {
			$this->message = "Oops! There is problem with back end. we will be back soon..";
			$this->help->redirect('index.php?do=home&msg='.$this->message);
			return;
		}
	
	}
			

			
	/*** 
		START ---- NEW USER SECTION - Since its joint tables, we are using the below functions for add * edit
	**/


	/**
	
		Add & Edit related function 
		Created : 17/09/2016
		Modified : 11/11/2016
	
	**/
	public function user_handle_screen($do, $user_account_id, $user_type_id, $read_access, $write_access)
	{
		
		// get query parameters
		$ac = isset($_REQUEST['ac'])?$_REQUEST['ac']:NULL;
		$clm = isset($_REQUEST['clm'])?$_REQUEST['clm']:NULL;
		
		
		/**
			Edit related function 
		**/
		if ($do == 'add_user' && $clm && $ac) {
			echo "------------------------------------------------------------------INSIDE EDIT";
			$this->form_user_edit_function ($do, $user_account_id, $user_type_id, $read_access, $write_access, $clm, $ac); 
		}
		/**
			Add related function 
		**/
		else if (substr($do,0,4) == 'add_' && !$clm && !$ac) {	echo "INSIDE EDIT";
			$this->form_add_user_function ($do, $user_account_id, $user_type_id, $read_access, $write_access); 
		}
		/**
			List Edit/Delete related function 
		**/
		else if (substr($do,0,5) == 'list_' && $clm && $ac) {
			$this->form_delete_function ($do, $user_account_id, $user_type_id, $read_access, $write_access, $clm, $ac); 
		}
		
	}

			
			
	/**
	
		USER ADD function 
		Created : 17/12/2016
		Modified : 17/12/2016
	
	**/
	public function form_add_user_function($do, $user_account_id, $user_type_id, $read_access, $write_access)
	{
		$this->data = $this->add->add_functions($do);
		$this->insert_user_data($do, $this->data, $user_account_id);
		$this->help->goto_view($do);
	}

	
	
	/**	
	
		insert data for all the forms (add forms)
		Created : 17/09/2016
		Modified : 14/11/2016
	
	**/
	public function insert_user_data($do, $all_array, $user_account_id)
	{
		// Checking user logged or not
		$errors = array();
		$mt = $account_count = $amaster_count = null;
		
		/*
			Once the submit the data 
		*/
		if ( isset($_REQUEST[$do."_submit"])) {
			
			$list_page = str_replace('add','list',$do);
			/*
				Check whether mobile and email has been exist already
			*/
			$account_count = $this->CommonService->db_check_exist("user_account", "mobile = '".$_REQUEST['mobile']."'");
			$amaster_count = $this->CommonService->db_check_exist("user_master", "email = '".$_REQUEST['email']."'");
			
			if ($account_count == 0 && $amaster_count == 0) {
					
				$insert_result = $this->CommonService->do_add_user_db($_REQUEST, $do, $all_array);
				$log_data = $insert_result[0];
				$insert_id = $insert_result[1];
				$insert_status = $insert_result[2];
				$log_data = "|data insert|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$insert_id."|".$log_data."|";
				$this->data_logger_set($user_account_id, $log_data, $insert_status, 'no');

				if($insert_status == 'error') {
					$this->message = "Oops! There is problem with back end. we will be back soon..";
					$mt = 'danger';
				}
				else{
					$this->message = "New record created successfully";	
					$mt = 'success';		
				}
			} else {
				if ($account_count == 0)
					$this->message = "Mobile number already exist";
				else if ($amaster_count == 0)
					$this->message = "Email number already exist";
				$mt = 'warning';
			}
			
			
			$this->help->redirect('index.php?do=thank&msg='.$this->message.'&mt='.$mt.'');
			return;
		}
		include Config::VIEWS_PATH."/home.php";
		exit;
	}
	

	/**
	
		Form  USER Edit function 
		Created : 24/12/2016
		Modified : 24/12/2016
	
	**/
	public function form_user_edit_function($do, $user_account_id, $user_type_id, $read_access, $write_access, $clm, $ac)
	{
		// get query parameters
		$log_data  =  $edit_status  =  null;
		
		// Checking write permission 
		if ($write_access == 0) {
			
			$log_message = "trying to access this page without permission";
			$log_data = "|access denied|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$log_message."|";
			$this->data_logger_set($user_account_id, $log_data, $edit_status, 'no');
			$this->help->goto_view('403');
			//include Config::VIEWS_PATH."/403.php";
			exit;
			
		}
		
		$this->data = $this->add->add_functions($do, $ac);
		
		/*
			Adding values to the existing array (usert_type_id ,access)
		*/
		array_push($this->data, $ac, $user_type_id, $read_access, $write_access);
		
		$this->data_db = $this->CommonService->do_select_db($this->data[0], $clm, $ac);
		$log_data = $this->data_db[0];
		$select_status = $this->data_db[1];
		$log_data = "|select query|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$log_data."|";
		($select_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
		// log the data only error case
		if ($select_status == 'error' || $select_status == 'wrong') {
			$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix, "");
			include Config::VIEWS_PATH."/404.php";
			exit;
		}	
		
		//Assigning values for edit based on the $ac
		$i = 0;
		foreach ($this->data[3] as $data) {
			
			if ($data[0] != 'submit' && $data[0] != 'button') {
				// Removing [] symbol from the add list if it's array
				$data[2] = str_replace("[]","",$data[2]);
				
				//Date Validation
				if ($data[5] == 'Cal') {
					$this->data[3][$i][3] = $this->help->date_format_func_ext($select_status[$data[2]], "d/m/Y");
				}
				// For Files
				else if ($data[0] == 'file') {
					$this->data[3][$i][3] = $select_status[$data[2]];
				}
				// For Files
				else if ($data[0] == 'password') {
					$this->data[3][$i][3] = $select_status[$data[2]];
				}
				// For Radio, Checkbox and select 
				else if ($data[0] == 'radio' || $data[0] == 'checkbox' || $data[0] == 'select') {
					$this->data[3][$i][5] = $select_status[$data[2]];
				}	
				else {
					// All other data's
					if ($data[0] != 'head') {
						$this->data[3][$i][3] = $select_status[$data[2]];
					}
				}								
			}
			$i++;	
		}		
		$this->update_user_data($do, $this->data, $user_account_id);
	}
	
	
	/**
	
		update data based on the $ac data once submitted
		Created : 24/12/2016
		Modified : 24/12/2016
	
	**/
	public function update_user_data($do, $all_array, $user_account_id)
	{
		$errors = array();
		$errors = array();
		$mt = null;
		if (isset($_REQUEST[$do."_submit"])) {
			$list_page = str_replace('add','list',$do);
			$update_result = $this->CommonService->do_user_update_db($_REQUEST, $do, $all_array);
			$log_data = $update_result[0];
			$update_id = $update_result[1];
			$update_status = $update_result[2];
			$log_data = "|data update|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$update_id."|".$log_data."|";
			$this->data_logger_set($user_account_id, $log_data, $update_status, 'no');
			
			if ($update_status == 'error') {
				$this->message = "Oops! There is problem with back end. we will be back soon..";
				$mt = 'danger';
			}
			else {
				if (empty($update_result[0])) {
					$this->message = "no update has been made.";
					$mt = 'info';
				}	
				else {	
					$this->message = "one record updated successfully";			
					$mt = 'success';
				}	
			}
			$this->help->redirect('index.php?do='.$list_page.'&msg='.$this->message.'&mt='.$mt.'');
			return;
		}
		include Config::VIEWS_PATH."/home.php";
		exit;
	}	
	
	
	/*** 
		END ---- NEW USER SECTION - Since its joint tables, we are using the below functions for add * edit
	**/	
			
}

?>