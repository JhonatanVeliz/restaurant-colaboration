<?php
	declare(strict_types=1);

	header("Content-Type:application/json");

	use Controller\IndexController;
	use model\classes\Loader;		

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");
	
	$loader = new Loader();
	$loader->init($_SERVER['DOCUMENT_ROOT'] . "/../Application");
	
	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "index");	

	$indexController = new IndexController($dbcon);
	
	match($action) {
		"index"		=>	$indexController->index(),
		"create" 	=> 	$indexController->create(),
		default		=>	$indexController->index(),
	}	
?>
