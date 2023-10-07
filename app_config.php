<?php
	// Configura el path para poder usar direcciónes relativas independientemente del directorio en 
	// el que nos encontremos

	define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']);

	session_start();
	session_regenerate_id();
?>
