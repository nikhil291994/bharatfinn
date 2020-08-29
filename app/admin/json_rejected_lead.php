<?php
session_start();
error_reporting(0);
include('../class/config.php');

$fetch = "SELECT * FROM leads WHERE status IN ('3')  ORDER BY id DESC";
$row = mysqli_query($con, $fetch);
while ($run = mysqli_fetch_array($row))
{
    $result[] = $run;
}
$vasv = json_encode($result);
echo $vasv;
?>