<?php
session_start();

if (isset($_SESSION['email']))
{
	unset($_SESSION['email']);	
}

if (isset($_SESSION['username']))
{
	unset($_SESSION['username']);	
}

if (isset($_SESSION['subadmin_id']))
{
	unset($_SESSION['subadmin_id']);	
}
session_destroy();
header('location: ../index.php');
?>