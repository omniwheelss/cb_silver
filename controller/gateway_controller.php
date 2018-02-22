<?php

/**

Includes all other controllers and models

**/
require_once 'model/common_service.php';
require_once 'includes.php';


class GatewayController
{
	
	private $CommonService = NULL;
	private $cookies = null;
	private static $common;
	public $do;
	public $user_name;
	public $user_account_id;
	public $user_type_id;
	public $page_title;
	public $seo_keyword;
	public $seo_description;
	public $read_access;
	public $write_access;
	public $seo_message = null;
	

		
	/**
		__construct function
		Created : 05/12/2016
		Modified : 05/12/2016
	
	**/
	public function __construct()
	{
		$this->CommonService = new CommonService();
		$this->login = new LoginController();
		$this->help = new HelperController();
		$this->seo = new SEOController();
		$this->dynamic = new DynamicController();
		
		$this->do = isset($_REQUEST['do'])?$_REQUEST['do']:NULL;
		
	}
	
	
	
	/**
	
		function to initialize login variables to have the cookie
		Created : 05/12/2016
		Modified : 05/12/2016
	
	**/
	private function initialize() 
	{
		/*
			Extract data if user is logged in
		*/
		if (isset($_COOKIE[Config::COOKIE_NAME])) {

			$cookies = explode("|",$_COOKIE[Config::COOKIE_NAME]);
			$this->user_name = $cookies[0];
			$this->user_account_id = $cookies[1];
			$this->user_type_id = $cookies[3];
			
			/*
				Check permissions
			*/
			$acl_data = $this->login->check_access($this->user_account_id, $this->user_type_id, $this->do);
			$this->read_access = $acl_data[0];
			$this->write_access = $acl_data[1];

			/*
				Redirects when there is no query parameter
			*/
			if (empty($this->do)) {
				$this->help->redirect('index.php?do=home');
			}
		}
		
		//Get title for all the pages
		$this->page_title = $this->help->get_title($this->do);
		

		/*
			Get SEO values for keyword and description
		*/
		$seo_data = $this->seo->seo_array_func($this->do);
		$this->seo_keyword = $seo_data[0];
		$this->seo_description = $seo_data[1];
		if ($this->seo_keyword == 'failure') {
			$this->seo_message = $this->help->message_display($seo_data[1],'info');
		}
		
	}

	
	
	/**
	
		function to get the login & SEO values after setting it
		Created : 05/12/2016
		Modified : 05/12/2016
	
	**/	
	public function getInstance()
	{
		if (!isset(self::$common))
		{
			$class = __CLASS__;
			self::$common = new $class();
			self::$common->initialize();
		}
		return self::$common;
	}

	
		
	/**
	
		function to check query string to handle the page direction
		Created : 17/09/2016
		Modified : 11/11/2016
	
	**/
	public function handle_request()
	{
		
		/*
			Checking the cookie available or not
		*/
		if (($this->do != 'login' && $this->do != 'logout') || empty($this->do)) {
			$this->login->is_loggedin($this->do);
		}		
		
		/*
			Getting the values from getInstance
		*/
		$common = GatewayController::getInstance();

		/*
			check where file exist for not 	
		*/
		$this->help->check_file($common->do);
		
		
		
		/*
			Redirection for all the pages
		*/
		switch ($common->do) {
			
			case 'login':
				$this->login->check_login($common->do);
			break;

			case 'home':
				$common->do = 'dashboard';
				$this->help->goto_view($common->do);
			break;
			
			case 'logout':
				$this->login->do_logout($common->user_account_id);
			break;
			
			case 'profile':
				$this->login->check_profile($common->do, $common->user_account_id, $common->user_type_id, $common->read_access, $common->write_access);
			break;
			
			case 'add_user':
				$this->dynamic->user_handle_screen($common->do, $common->user_account_id, $common->user_type_id, $common->read_access, $common->write_access);
			break;			
			
			
			
			/**
				Dont change anything below
			**/			
			case (substr($common->do,0,4) == 'add_'):
				$this->dynamic->handle_screen($common->do, $common->user_account_id, $common->user_type_id, $common->read_access, $common->write_access);
			break;
			
			case substr($common->do,0,4) == 'list':
				$this->dynamic->handle_screen($common->do, $common->user_account_id, $common->user_type_id, $common->read_access, $common->write_access);
			break;
			
			case 'thank':
				$this->help->goto_view($common->do);
			break;
			
			default:
			$this->help->goto_view($common->do);
			break;
		}



	}
		
}

?>