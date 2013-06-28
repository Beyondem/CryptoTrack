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


if (ISSET($_POST['type'])){
$coin= mysql_real_escape_string($_POST['coin']);
$coinamount = mysql_real_escape_string($_POST['amount']);
$boughtat = mysql_real_escape_string($_POST['boughtat']);
$exchange = mysql_real_escape_string($_POST['exchange']);
$currency = mysql_real_escape_string($_POST['currency']);

if ($currency == "USD"){
	$currency = "0";
}else{
$sql="SELECT * FROM track_usdrates WHERE name='$currency'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);
if ($count > 0){
$currdata = mysql_fetch_assoc($result);
$currency = $currdata['id'];
}else{
die("Error:Invalid currency type!");
}
}


//die("Cur: $currency");
$sql="SELECT * FROM track_currencies WHERE name='$coin'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);

$coindata = mysql_fetch_assoc($result);
$coinid = $coindata['id'];


if (is_numeric($coinamount) && is_numeric($boughtat)){
$time = time();
mysql_query("INSERT INTO  `currentbitcoin`.`track_entries` (`accountid` ,`currency`,`exchangeid` ,`amount` ,`boughtat`,`added`,`rateid`) VALUES ('$userid',  '$coinid', '$exchange',  '$coinamount',  '$boughtat', '$time', '$currency');");
echo "1";
}else{
	echo "Error:Both Amount and the Bought At Price must be Numeric!";
	die();
}

}else{
	echo "0";
}

?>