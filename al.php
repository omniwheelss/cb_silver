<?php

###	Date Format Function
###	Created : 28/08/2016
###	Modified : 28/08/2016
header('Access-Control-Allow-Origin: *');

	// XML format
	$xml = new SimpleXMLElement('<user_status/>');
	require_once 'controller/config.php';
	require_once 'controller/common_controller.php';

	$Common = new CommonController();
	$status = $Common->check_android_login($_REQUEST['email'] , $_REQUEST['pass']);
	$track = $xml->addChild('status',$status);
	Header('Content-type: text/xml');
	print($xml->asXML());
?>
