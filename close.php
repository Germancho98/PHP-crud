<?php 
require_once 'db_conexion.php';

$_SESSION['id'] = null;
$_SESSION['user_name'] = null;
$_SESSION['picture'] = null;

session_destroy();

header('Location:'.URL);
exit();