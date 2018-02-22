<?php

require_once 'model/common_service.php';
require_once 'helper_controller.php';
require_once 'list_controller.php';
require_once 'add_controller.php';

class AndroidController extends HelperController {

	private $CommonService = NULL;
	private $Config = NULL;
	
	//Invoke model to access all the methods
	public function __construct()
	{
		$this->CommonService = new CommonService();
		$this->list = new ListController();
		$this->add = new AddController();
	}

	
	###	function to check query string to handle the page direction
	###	Created : 17/09/2016
	###	Modified : 11/11/2016
	public function handle_request()
	{
			// get query parameters
			$do = isset($_REQUEST['do'])?$_REQUEST['do']:NULL;
			$ac = isset($_REQUEST['ac'])?$_REQUEST['ac']:NULL;
			$clm = isset($_REQUEST['clm'])?$_REQUEST['clm']:NULL;
			
			// Cookies to get the user account id for log
			if(isset($_COOKIE[Config::COOKIE_NAME]))
				$cookies = explode("|",$_COOKIE[Config::COOKIE_NAME]);

			try {
				if ( !$do || $do == 'login' ) {
					$this->check_login();
				} 
				else if ($do == 'home' ) {
					$this->home($do);
				}
				else if ($do == 'logout' ) {
					//getting cookie to log user account id
					$this->do_logout($Cookies[1]);
				}
				else{
					//AddForm redirects with parameters (Add & Edit)
					if(substr($do,0,4) == 'add_' && $clm && $ac){
						
						$this->data = $this->add->add_functions($do,$ac);
						$this->data_db = $this->CommonService->do_select_db($this->data[0],$clm, $ac);
						$log_data = $this->data_db[0];
						$select_status = $this->data_db[1];

						$log_data = "|select query exception|".$common->user_account_id."|".$log_data."|";
						($select_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
						$this->help->data_logger($log_data,Config::LOGS_PATH,$log_prefix,"");
						
						//Assigning values for edit based on the $ac
						$i = 0;
						foreach($this->data[3] as $data){
							
							if($data[0] != 'submit' && $data[0] != 'button'){
								// Removing [] symbol from the add list if it's array
								$data[2] = str_replace("[]","",$data[2]);
								
								//Date Validation
								if($data[5] == 'Cal'){
									$this->data[3][$i][3] = $this->date_format_func($select_status[$data[2]], "d/m/Y");
								}
								// For Files
								else if($data[0] == 'file'){
									$this->data[3][$i][3] = $select_status[$data[2]];
								}
								// For Radio, Checkbox and select 
								else if($data[0] == 'radio' || $data[0] == 'checkbox' || $data[0] == 'select'){
									$this->data[3][$i][5] = $select_status[$data[2]];
								}	
								else{
									// All other data's
									$this->data[3][$i][3] = $select_status[$data[2]];
								}								
							}
							$i++;	
						}
						$this->update_data($do, $this->data);
					}
					else if(substr($do,0,4) == 'add_'){
						//For all add page
						$this->data = $this->add->add_functions($do,$ac);
						$this->insert_data($do,$this->data,$common->user_account_id);
					}
					else if(substr($do,0,4) == 'list' && $clm && $ac){
						//For all list page
						$List_Array = $this->list->list_functions($do);

						foreach($List_Array[3] as $data){
							// For Files
							if($data[2] == 'file'){
								$File_Names[] = $data[1];
							}
						}
						$this->message = $this->CommonService->delete_sample($List_Array[0],$clm, $ac, $File_Names);
						$this->redirect('index.php?do='.$do.'&msg='.$this->message);
					}
					else if(substr($do,0,4) == 'list'){
						//For all list page
						$List_Array = $this->list->list_functions($do);
						$Search_Submit = "search_".$do;

						if ( isset($_REQUEST[$Search_Submit]) ) {
							try {
								$this->data = $this->CommonService->list_sample($List_Array,$do);
							} catch (ValidationException $e) {
								$errors = $e->getErrors();
							}
						}
						else{								
							$this->data = $this->CommonService->list_sample($List_Array,$do);
						}
						$this->home($do);
					}
				}
					
			} catch ( Exception $e ) {
				// some unknown Exception got through here, use application error page to display it
				$this->show_error("Application error", $e->getMessage());
			}
	}
	
	
	###	check user login function to check valid user or not
	###	Created : 17/09/2016
	###	Modified : 11/11/2016
	public function check_login() {
		
		if(!empty($_COOKIE[Config::COOKIE_NAME])){
			$this->redirect('index.php?do=home');	
		}
		else if (!empty($_REQUEST['email']) && !empty($_REQUEST['password'])) {
			$email = isset($_REQUEST['email'])?$_REQUEST['email']:NULL;
			$password = isset($_REQUEST['password'])?$_REQUEST['password']:NULL;
			$login_result = $this->CommonService->do_login($email, $password);
			$user_account_id = $login_result[0];
			$log_data = $login_result[1];
			$login_status = $login_result[2];

			$log_data = "|user login|".$user_account_id."|".$log_data."|";
			($login_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
			$this->help->data_logger($log_data,Config::LOGS_PATH,$log_prefix,"");
			$this->CommonService->data_logger_db($user_account_id,$log_data,date("Y-m-d H:i:s"));
			
			if(!empty($user_account_id)) {
				$this->redirect('index.php?do=home');
				return;
			}
			else if($login_status == 'error') {
				$this->message = "Oops! There is problem with back end. we will be back soon..";
			}
			else{
				$this->message = "Oops! Username or Password wrong";
			}
		}	
		include 'views/screen/login.php';
		return;
	}

	
	###	user logout function to check valid or invalid
	###	Created : 17/09/2016
	###	Modified : 11/11/2016
	public function do_logout($user_account_id)
	{	
		$log_data = "successfully logged out";
		$log_data = "|user login|".$user_account_id."|".$log_data."|";
		$this->help->data_logger($log_data,Config::LOGS_PATH,Config::DAILY_LOG,$log_data);
		$this->CommonService->data_logger_db($user_account_id,$log_data,date("Y-m-d H:i:s"));
		setcookie(Config::COOKIE_NAME,"",time()-345);
		$this->redirect('index.php');
		return;
	}

	
	###	insert data for all the forms (add forms)
	###	Created : 17/09/2016
	###	Modified : 14/11/2016
	public function insert_data($do,$all_array,$user_account_id)
	{
		// Checking user logged or not
		$this->is_loggedin();
			
		$errors = array();
		if ( isset($_REQUEST[$do."_submit"]) ) {
			
			$list_page = str_replace('add','list',$do);
			$insert_result = $this->CommonService->do_add_db($_REQUEST, $do, $all_array);
			$log_data = $insert_result[0];
			$insert_id = $insert_result[1];
			$insert_status = $insert_result[2];
			$log_data = "|data insert|".$user_account_id."|".$insert_id."|".$log_data."|";
			$this->dynamic->data_logger_set($user_account_id, $log_data, $insert_status, 'no');

			if($insert_status == 'error') {
				$this->message = "Oops! There is problem with back end. we will be back soon..";
			}
			else{
				$this->message = "New record created successfully";			
				return;
			}
			$this->redirect('index.php?do='.$list_page.'&msg='.$this->message);
		}
		include 'views/screen/home.php';
	}
	
	
	###	update data based on the $ac data once submitted
	###	Created : 17/09/2016
	###	Modified : 11/11/2016
	public function update_data($do,$All_Array)
	{
		// Check log in 
		$this->is_loggedin();
		
		$errors = array();
		if ( isset($_REQUEST[$do."_submit"]) ) {
	
			try {
				$list_page = str_replace('add','list',$do);
				$this->message = $this->CommonService->do_update_db($_REQUEST, $do, $All_Array);
				$this->redirect('index.php?do='.$list_page.'&msg='.$this->message);
				return;
			} catch (ValidationException $e) {
				$errors = $e->getErrors();
			}
		}
		include 'views/screen/home.php';
	}

	public function is_loggedin()
	{
		if(isset($_COOKIE[Config::COOKIE_NAME]))	{
			return true;
		}
		else{		
			$this->redirect('index.php?do=login');
		}
	}

	public function home($do)
	{
		// Check log in 
		$this->is_loggedin();
		include 'views/screen/home.php';
	}
	
	public function show_error($title, $message)
	{
		include 'views/screen/error.php';
	}
	
	public function redirect($url)
	{
		header("Location: ".$url);
	}
	

	public function user_type()
	{	
		return $this->CommonService->user_type();
	}
	
	
	
	public function check_access($user_account_id, $user_type_id, $screen_name)
	{
		$this->acl_data = $this->CommonService->acl_project_screen($user_account_id, $user_type_id, $screen_name);
		if($this->acl_data == 1){
			return true;
		}
		else{
			$this->redirect('index.php?do=home');
			return false;
		}		
	}	
	
	
	###	login authendication checking for android app
	###	Created : 17/09/2016
	###	Modified : 15/11/2016
	public function check_android_login($email, $pass) {
		
		if (!empty($email) && !empty($pass)) {
			$email = isset($email)?$email:NULL;
			$password = isset($pass)?$pass:NULL;
			$Cookies = $this->CommonService->do_login($email, $password);
			
			if($Cookies) {
				return "true";
			}
			else{
				return "false";
			}
		}	
	}
	
	
}

?>