<?php 

//$connection  = mysqli_connect('localhost','root','' , 'test'); 
	

//$userObj  = mysqli_query($connection , 'SELECT * FROM `user`');


session_start();
error_reporting(0);
include('../class/config.php');

if(isset($_POST['id'])){
	$id = $_POST['id'];
	mysqli_query($con , "DELETE FROM leads where id='$id'");
	echo '1';
}

?>