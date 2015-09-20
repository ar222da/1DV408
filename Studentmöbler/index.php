<?php
	require_once("Controller.php");
	require_once("HTMLView.php");
	
	$controller = new controller();
    $html = new HTMLView();
    $body = $controller->main();
    $html->echoHTML($body);
?>