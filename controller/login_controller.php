<?php

/**

Includes all other controllers and models

**/
require_once 'model/common_service.php';
require_once 'includes.php';

class LoginController
{

	private $CommonService = NULL;
	
	//Invoke model to access all the methods
	public function __construct()
	{
		$this->CommonService = new CommonService();
		$this->help = new HelperController();
	}

	
	
	/**
		
		check user login function to check valid user or not
		Created : 17/09/2016
		Modified : 10/12/2016
	
	**/
	public function check_login($do) {
		
		
		/*
			once user submitted
		*/
		if (!empty($_REQUEST['email']) && !empty($_REQUEST['password'])) {
			
			$email = isset($_REQUEST['email'])?$_REQUEST['email']:NULL;
			$password = isset($_REQUEST['password'])?$_REQUEST['password']:NULL;
			//$password = md5($password);
			
			$login_result = $this->CommonService->do_login($email, $password);
			$user_account_id = $login_result[0];
			$log_data = $login_result[1];
			$login_status = $login_result[2];

			$log_data = "|user login|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$log_data."|";
			($login_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
			$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix,"");
			$this->CommonService->data_logger_db($user_account_id, $log_data, date("Y-m-d H:i:s"));
			
			if(!empty($user_account_id)) {
				$this->help->redirect('index.php?do=home');
				return;
			}
			else if($login_status == 'error') {
				$message = "Oops! There is problem with back end. we will be back soon..";
			}
			else if($login_status == 'failure') {
				$message = "Oops!!! your account was expired";
			}
			else if($login_status == 'expiry') {
				$message = "Oops!!! your license not yet been registered";
			}
			else{
				$message = "Oops! Username or Password wrong";
			}
		}	
		/*
			Include view file also checking if user already logged in or not
		*/
		include	Config::VIEWS_PATH."/login.php";
		exit;
	}

	
	/**
		
		check user logged or not
		Created : 17/09/2016
		Modified : 09/12/2016
	
	**/
	public function is_loggedin($do)
	{
		if(!isset($_COOKIE[Config::COOKIE_NAME])) {
			$this->help->redirect('index.php?do=login');
			exit;
		}
		return true;
		//$this->help->goto_view('home');
	}

	

	
	/**
		
		check user access for each page
		Created : 17/09/2016
		Modified : 16/11/2016
	
	**/
	public function check_access($user_account_id, $user_type_id, $screen_name)
	{
		/*
			Leave condition for "home" page
		*/
		if ($screen_name != 'home' && $screen_name != 'thank' && $screen_name != 'logout') {
			
			$cookies = explode("|",$_COOKIE[Config::COOKIE_NAME]);
			// no access checking if user as super admin (1)
			if($user_type_id == 1){
				$access_result = array(1, null, null, 1);
			} else {
				$access_result = $this->CommonService->acl_project_screen($user_account_id, $user_type_id, $screen_name);
			}
			$screen_count = $access_result[0];
			$screen_status =$access_result[1];
			$log_data = $access_result[2];
			$write_access = $access_result[3];
			$log_data = "|access check|".$screen_name."|".$this->help->get_client_ip()."|".$user_account_id."|".$screen_name."|".$log_data."|";
			($screen_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
			if ($screen_status == 'error') {
				$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix,"");
				$this->CommonService->data_logger_db($user_account_id, $log_data, date("Y-m-d H:i:s"));
				$this->message = "Oops! There is problem with back end. we will be back soon..";
			}
			else {
				if ($screen_count == 1) {
					return array($screen_count, $write_access);
				}
				else {
					$this->help->goto_view('403');
					exit;
				}		
			}	
		}	
	}	
	
	
	
	
	/**
	
		checking profile
		Created : 01/12/2016
		Modified : 01/12/2016
		
	**/
	public function check_profile($do, $user_account_id) {
		
		$user_data_array = $this->CommonService->user_profile($user_account_id);
		$user_status = $user_data_array[1];
		$log_data = $user_data_array[2];
		$user_datas = $user_data_array[3][0];
		$log_data = "|profile query|".$do."|".$this->help->get_client_ip()."|".$user_account_id."|".$log_data."|";
		($user_status == 'error')?$log_prefix = Config::ERROR_LOG : $log_prefix = Config::DAILY_LOG;
		
		// log the data only error case
		if ($user_status == 'error') {
			
			$this->help->data_logger($log_data, Config::LOGS_PATH, $log_prefix,"");
			include Config::VIEWS_PATH."/404.php";
			exit;
			
		}
		include	Config::VIEWS_PATH."/home.php";
		exit;
	}
	
	
	
	
	/**
	
		user logout function to check valid or invalid
		Created : 17/09/2016
		Modified : 11/11/2016
	
	**/
	public function do_logout($user_account_id)
	{
		$log_message = "successfully logged out";
		$log_data = "|user login|".$this->help->get_client_ip()."|".$user_account_id."|".$log_message."|";
		$this->help->data_logger($log_data,Config::LOGS_PATH,Config::DAILY_LOG,"");
		$this->CommonService->data_logger_db($user_account_id, $log_data, date("Y-m-d H:i:s"));
		setcookie(Config::COOKIE_NAME,"",time()-345);
		$this->help->redirect('index.php');
		return;
	}	

		
}

?>