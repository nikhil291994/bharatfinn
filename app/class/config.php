<?php
error_reporting(0);

define ( 'DB_USER', 'root');
define ( 'DB_PASSWORD', '');
define ( 'DB_DB', 'bharau65_crm');
define ( 'DB_HOST','localhost');

$con = new mysqli (DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if (mysqli_connect_error()){
        printf("Connection failed : %s\n", mysqli_connect_error());
        exit();
}

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DB) OR DIE("Impossible to access to DB: " .mysqli_connect_error());

?>

