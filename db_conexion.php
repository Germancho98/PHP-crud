<?php 
session_start();
$conn = new mysqli('localhost', 'root', '', 'sistema_usuarios');

if ($conn->connect_error) {
	
	echo "Lo sentimos, este ditio web está experimentando problemas.";

	echo "Error". $conn->connect_errno . "\n";
	echo "Error". $conn->connect_error . "\n";

	exit();
}

require_once ('ajax/functions.php');