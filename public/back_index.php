<?php
	declare(strict_types=1);

	header("Content-Type:application/json");

	use Controller\IndexController;
	use Controller\LoginController;
	use Controller\RegisterController;
	use model\classes\Loader;		

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");
	
	$loader = new Loader();
	$loader->init($_SERVER['DOCUMENT_ROOT'] . "/../Application");
	
	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "index");	

	$indexController = new IndexController($dbcon);
	$registerController = new RegisterController($dbcon);
	$loginController = new LoginController($dbcon);
	
	match($action) {
		"index"		=>	$indexController->index(),
		"create" 	=> 	$indexController->create(),
		"register"	=>	$registerController->register(),
		'login'		=>	$loginController->login(),
		default		=>	$indexController->index(),
	}	
?>
