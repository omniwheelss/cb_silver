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
		/*$this->help = new HelperController();
		$this->list = new ListController();
		$this->add = new AddController();
		$this->arr = new ArrayController();*/
	}

	
	
	/**
	
		Function to check query string to handle the page direction
		Created : 17/09/2016
		Modified : 11/11/2016
	
	**/
	public function handle_screen()
	{
		// get query parameters
		$do = isset($_REQUEST['do'])?$_REQUEST['do']:NULL;
		$ac = isset($_REQUEST['ac'])?$_REQUEST['ac']:NULL;
		$clm = isset($_REQUEST['clm'])?$_REQUEST['clm']:NULL;
		$file_names = $mt = $log_data = $user_data_array = $user_status = $url_file = null;
		
		if (substr($do,0,4) == 'add_' && $clm && $ac) {
			// Checking write permission 
			$acl_data = $this->login->check_access($common->user_account_id,$common->user_type_id, $_REQUEST['do']);
			if ($acl_data[1] == 0) {
				$log_message = "trying to access this page without permission";
				$log_data = "|access denied|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$log_message."|";
				$this->help->data_logger($log_data, Config::LOGS_PATH, Config::DAILY_LOG,"");
				$this->CommonService->data_logger_db($user_account_id, $log_data, date("Y-m-d H:i:s"));
				include 'views/screen/403.php';
				exit;
			}
			
			$this->data = $this->add->add_functions($do, $ac);
			
			$this->data_db = $this->CommonService->do_select_db($this->data[0], $clm, $ac);
			$log_data = $this->data_db[0];
			$select_status = $this->data_db[1];
			$log_data = "|select query|".$this->help->get_client_ip()."|".$user_account_id."|".$log_data."|";
			($select_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
			// log the data only error case
			if ($select_status == 'error' || $select_status == 'wrong') {
				$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix,"");
				include 'views/screen/404.php';
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
						$this->data[3][$i][3] = $select_status[$data[2]];
					}								
				}
				$i++;	
			}
			$this->update_data($do, $this->data, $user_account_id);
		}
		//Only add form insert here
		else if (substr($do,0,4) == 'add_') {
			//For all add page
			$this->data = $this->add->add_functions($do, $ac);
			$this->insert_data($do, $this->data, $user_account_id);
		}
		// All delete page redirects here
		else if (substr($do,0,4) == 'list' && $clm && $ac) {
				
			// Checking write permission 
			$acl_data = $this->login->check_access($common->user_account_id,$common->user_type_id, $do);
			if ($acl_data[1] == 0) {
				$log_message = "trying to access this page without permission";
				$log_data = "|access denied|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$log_message."|";
				$this->help->data_logger($log_data, Config::LOGS_PATH, Config::DAILY_LOG,"");
				include 'views/screen/403.php';
				exit;
			}
		
			$list_array = $this->list->list_functions($do);

			foreach ($list_array[3] as $data) {
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
			($delete_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
			$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix,"");
			$this->CommonService->data_logger_db($user_account_id, $log_data, date("Y-m-d H:i:s"));
			if ($delete_status == 'wrong' || $delete_status == 'error') {
				include 'views/screen/404.php';
				exit;
			}
			else if ($delete_status == 'success') {
				$this->message = "one record deleted successfully";	
				$mt = 'success';
			}

			$this->redirect('index.php?do='.$do.'&msg='.$this->message.'&mt='.$mt.'');
			exit;
		}
		//All list page will be redirected here
		else if (substr($do,0,4) == 'list') {
			//For all list page
			$list_array = $this->list->list_functions($do);
			$search_submit = "search_".$do;
			
			// when Search area get submitted
			if ( isset($_REQUEST[$search_submit])) {
				$this->data = $this->CommonService->list_data_db($list_array,$do);
				$lists_status = $this->data[6];
				$log_data = $this->data[7];
				$search_data = $this->data[8];
				$log_data = "|list data|".$do."|".$user_account_id."|".$search_data."|".$log_data."|";
				($lists_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
				$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix,"");
				$this->CommonService->data_logger_db($user_account_id, $log_data, date("Y-m-d H:i:s"));
			}
			else {
				// when call for list page
				$this->data = $this->CommonService->list_data_db($list_array, $do);
				$lists_status = $this->data[6];
				$log_data = $this->data[7];
				$log_data = "|".$do."|".$user_account_id."|".$log_data."|";
				($lists_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
				if ($lists_status == 'error') {
					$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix,"");
					$this->CommonService->data_logger_db($user_account_id, $log_data, date("Y-m-d H:i:s"));
					$this->message = "Oops! There is problem with back end. we will be back soon..";
					$this->redirect('index.php?do=home&msg='.$this->message);
					return;
				}
				else{
					$this->message = "Oops! Username or Password wrong";
				}
			}
			$this->home($do);
		}
		else {
			include 'views/screen/404.php';
			exit;
		}
	}



	
	###	insert data for all the forms (add forms)
	###	Created : 17/09/2016
	###	Modified : 14/11/2016
	public function insert_data($do,$all_array,$user_account_id)
	{
		// Checking user logged or not
			
		$errors = array();
		$mt = null;
		if ( isset($_REQUEST[$do."_submit"])) {
			
			$list_page = str_replace('add','list',$do);
			$insert_result = $this->CommonService->do_add_db($_REQUEST, $do, $all_array);
			$log_data = $insert_result[0];
			$insert_id = $insert_result[1];
			$insert_status = $insert_result[2];
			$log_data = "|data insert|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$insert_id."|".$log_data."|";
			($insert_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
			$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix,"");
			$this->CommonService->data_logger_db($user_account_id, $log_data, date("Y-m-d H:i:s"));
			if($insert_status == 'error') {
				$this->message = "Oops! There is problem with back end. we will be back soon..";
				$mt = 'danger';
			}
			else{
				$this->message = "New record created successfully";	
				$mt = 'success';		
			}
			$this->redirect('index.php?do='.$list_page.'&msg='.$this->message.'&mt='.$mt.'');
			return;
		}
		include 'views/screen/home.php';
		exit;
	}
	
	
	###	update data based on the $ac data once submitted
	###	Created : 17/09/2016
	###	Modified : 15/11/2016
	public function update_data($do, $all_array, $user_account_id)
	{
		$errors = array();
		$mt = null;
		if (isset($_REQUEST[$do."_submit"])) {
			$list_page = str_replace('add','list',$do);
			$update_result = $this->CommonService->do_update_db($_REQUEST, $do, $all_array);
			$log_data = $update_result[0];
			$update_id = $update_result[1];
			$update_status = $update_result[2];
			$log_data = "|data update|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$update_id."|".$log_data."|";
			($update_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
			$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix,"");
			$this->CommonService->data_logger_db($user_account_id, $log_data, date("Y-m-d H:i:s"));
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
			$this->redirect('index.php?do='.$list_page.'&msg='.$this->message.'&mt='.$mt.'');
			return;
		}
		include 'views/screen/home.php';
		exit;
	}
	
			
}

?>