<?php
	declare(strict_types=1);

	use Controller\IndexController;
	use model\classes\Loader;		

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");

	//model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/../Application");
	$loader = new Loader();
	$loader->init($_SERVER['DOCUMENT_ROOT'] . "/../Application");
	
	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "index");	

	$indexController = new IndexController($dbcon);
	
	match($action) {
		"index"	=>	$indexController->index(),
		default	=>	$indexController->index(),
	}	
?>
