<?php

/**

Includes all other controllers and models

**/
require_once 'model/common_service.php';
require_once 'includes.php';


class HelperController
{

	private $CommonService = NULL;	
	
	/**
		__construct function
		Created : 05/12/2016
		Modified : 05/12/2016
	
	**/
	public function __construct()
	{
		$this->CommonService = new CommonService();
	}
	
		

	/**
	
		Changing the title for add / edit
		Created : 18/09/2016
		Modified : 17/11/2016
	
	**/
	static function get_title($do) {
 
		$page_title = strtoupper(str_replace("_"," ",$do));
		
		if (substr($do,0,3) == 'add' && isset($_REQUEST['clm']) && isset($_REQUEST['ac'])) {
			$page_title = strtoupper(str_ireplace("add","edit",$page_title));
		}
		return $page_title;
		return $page_title;
	}
	


	/**
		
		logger to store log information for all the store
		Created : 20/10/2016
		Modified : 17/11/2016
		
	**/	
	static function data_logger($data, $path, $log_prefix, $extra_data) {
	
		if (empty($log_prefix))
			$log_prefix = "";
		else
			$log_prefix = $log_prefix."_";
			
		$filepath = $path."/".$log_prefix."".@date("dmY").".log";
		$handle = fopen($filepath, 'a+');
		chmod($filepath, 0777);
		shell_exec("sudo chmod 777 ".$filepath."");
		$log_file_read = @file($filepath);
		$log_file_read_count = count($log_file_read);
		if (($log_file_read_count%2) == 0)
				$log_file_count = ($log_file_read_count/2)+1;

		$final_data = "".@date("d-m-Y H:i:s")." ".$data."".$extra_data."#";
		if(!fwrite($handle, "".$final_data."".CONFIG::NEWLINE."")) die("couldn't write to file. : Check the Folder permisson for (".$filepath.")");
		else
			return "<div id='error_text'><div class='Db_Error'>".$log_prefix." written done.</div></div>";
	}
	

	/**
	
		Date Format Function
		Created : 18/06/2016
		Modified : 18/11/2016
		
	**/	
	static function  date_format_func_ext($date, $format)
	{
		if (strtotime($date) < 1000){
			$date_output = null;
		}
		else {
			$date_output = @date($format,strtotime($date));
		}
		return $date_output;
	}
	
	
		
	/**
	
		get ip address for the user
		Created : 19/11/2016
		Modified : 18/11/2016
		
	**/	
	public function get_client_ip()
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
		   $ipaddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
			
		return $ipaddress;
	}

	
	
	/**
	
		Message Display function 
		Created : 01/12/2016
		Modified : 01/12/2016
		
	**/	
	static function  message_display($message, $mt)
	{
		$message_output = '<div class="alert alert-'.$mt.' alert-dismissible fade in" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		  </button>
		  '.$message.'
		</div>';
		
		return $message_output;
	}

	
	/**
	
		checking whether file is exist or not
		Created : 01/12/2016
		Modified : 01/12/2016
		
	**/
	static function check_file($do)	{
		
		if (!empty($do)) {
			$url_file = "views/screen/".$do.".php";
			// fine the full path from the url
			$base_path = str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']);
			$url_file = $base_path."".$url_file;
			if (!file_exists($url_file) && $do != 'login' && $do != 'logout' && $do != 'home' && $do != 'profile' ) {
				include 'views/screen/404.php';
				exit;
			}
		}	
	}	




	/**
	
		redirection of the page
		Created : 17/09/2016
		Modified : 16/11/2016
		
	**/	
	public function redirect($url)
	{
		header("Location: ".$url);
		exit;
	}
		
		
		
	/**	
	
		Redirects to views as per the input parameter
		Created : 17/09/2016
		Modified : 16/11/2016
		
	**/
	
	public function goto_view($do)
	{
		include Config::VIEWS_PATH."/home.php";
		exit;
	}
			
			
			
	/**	
	
		Redirects to page as per the input parameter
		Created : 17/09/2016
		Modified : 16/11/2016
		
	**/
	
	public function goto_page($do, $message)
	{
		$filename = "/".$do.".php";
		include Config::VIEWS_PATH."".$filename;
		exit;
	}
			
			
			
	
}

?>