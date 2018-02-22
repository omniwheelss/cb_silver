<?php

/**

Includes all other controllers and models

**/
require_once 'includes.php';


class SEOController
{
	
	/**
		__construct function
		Created : 05/12/2016
		Modified : 05/12/2016
	
	**/
	public function __construct()
	{
		$this->help = new HelperController();
	}
	

	###	SEO array have text for search engine
	###	Created : 19/11/2016
	###	Modified : 19/11/2016
	public function seo_array_func($do) {
		
		$seo_array_result = null;
		
		$seo_array = array( 
		
			// Other Pages
			'failure' => array('failure', 'SEO not yet set properly for "'.$do.'"'),
			'home' => array('home page', 'home page'),
			'profile' => array('profile page', 'profile page'),
			'thank' => array('thank you page', 'thank you page for the data insertion'),

			// Add forms related 		
			'add_single' => array('add new  Single page', 'Add Single sample page for add new record in the screen'),
			'add_sample' => array('add new page', 'Add sample page for add new record in the screen'),
			'add_user' => array('Add New user page', 'Add new user to this application to access other links'),
			'add_login' => array('Registered Users Login Creation', 'Create the login for already registered users'),
			'add_license' => array('Add License', 'Update license for the registered users'),
			'add_user_type' => array('Add User Type', 'Add New User Type '),
			'add_screen' => array('Add Screen', 'Add Screen'),
			'add_device_type' => array('Add Device Type', 'Add Device Type'),

			// List form related 
			'list_single' => array('list single new page', 'list single sample page listing the sample record'),
			'list_sample' => array('list new page', 'list sample page listing the sample record'),
			'list_user' => array('Registered Users list', 'New registered user list to this application to access other links'),
			'list_login' => array('Login Users ', 'List the login details for already registered users'),
			'list_license' => array('List License', 'List license for the registered users'),
			'list_user_type' => array('List User Type', 'List user type'),
			'list_screen' => array('List Screen', 'List Screen'),
			'list_acl_screen' => array('List Screen', 'List ACL Screen'),
			'list_device_type' => array('List Device Type', 'List Device Type'),
			'list_logs' => array('List Logs', 'List Logs')
			
		
		
		
		
		
		
		
		
		
		
		);
		
		// chekcing if $do not available
		if (isset($seo_array[$do])) {
			$seo_array_result = $seo_array[$do];
		}	
		else {
			$seo_array_result = $seo_array['failure'];
			
			/*if ($seo_array_result[0] == 'failure') {
				$seo_array = $this->help->message_display($seo_array_result[0],'info');
			}*/
		}
		
		return $seo_array_result; 
	}

	/**** below functions are not using currently and we can use it later when required end *****/


}

?>