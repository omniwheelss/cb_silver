<?php

	/**
	
		Gateway to redirect the page based on the input
		Created : 28/08/2016
		Modified : 28/08/2016
	
	**/
	require_once 'controller/config.php';
	require_once 'controller/gateway_controller.php';

	$gateway = new GatewayController();
	
	$gateway->handle_request();
?>
