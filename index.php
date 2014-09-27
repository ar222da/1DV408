<?php

require_once("LoginController.php");
require_once("HTMLView.php");


session_start();

$c = new LoginController();
$htmlBody = $c->DoLogin();

$view = new HTMLView();
$view->echoHTML($htmlBody);

