<?php
ob_start();
session_start();
if (!isset($_SESSION['username'])){
echo "Error: Not logged in";
die();
}
include_once("config.php");

$loginusername = $_SESSION['username'];

$sql="SELECT * FROM track_accounts WHERE username='$loginusername'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);

$userdata = mysql_fetch_assoc($result);
$userid = $userdata['id'];


if (ISSET($_POST["entry"])){
$entry= mysql_real_escape_string($_POST['entry']);


$sql="SELECT * FROM track_entries WHERE id='$entry' AND accountid='$userid'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);
if ($count > 0){
	mysql_query("DELETE FROM track_entries WHERE id='$entry' AND accountid='$userid'");
}else{
	die("Error:Could not delete. It dosen't exist, or dosen't belong to you.");
}


}else{
	echo "0";
}

?>