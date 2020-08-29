<?php 

//$connection  = mysqli_connect('localhost','root','' , 'test'); 
	

//$userObj  = mysqli_query($connection , 'SELECT * FROM `user`');


session_start();
error_reporting(0);
include('../class/config.php');

if(isset($_POST['leads'])){
	$dataArr = $_POST['leads'];
	/* echo "<pre>";
	print_r($dataArr);
	echo "</pre>";
	die; */
	foreach($dataArr as $id){
		mysqli_query($con , "DELETE FROM leads where id='$id'");
	}
	echo '1';
}

?>