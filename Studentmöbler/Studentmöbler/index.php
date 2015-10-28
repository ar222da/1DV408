<?php
	require_once("controller/Controller.php");
	require_once("view/HTMLView.php");
	
	session_start();
	
	$m = new \model\AdModel();
	$v = new \view\AdView($m);
	$c = new \controller\Controller($m, $v);
	
    $html = new \View\HTMLView();
    $body = $c->main();
    $html->echoHTML($body);
?>