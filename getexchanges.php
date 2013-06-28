<?php
ob_start();
session_start();

include_once("config.php");



if (ISSET($_POST['coin'])){
$coin= mysql_real_escape_string($_POST['coin']);


$sql="SELECT * FROM track_currencies WHERE name='$coin'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);
if ($count == 0){
	echo "Error";
	die();
}
$coindata = mysql_fetch_assoc($result);
$coinid = $coindata['id'];

$sql="SELECT * FROM track_exchanges WHERE currencyid='$coinid'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);
if ($count == 0){
	echo "Error";
	die();
}
while($exchangedata = mysql_fetch_assoc($result)){
	$name = $exchangedata['name'];
	$id = $exchangedata["id"];
	echo "<option value='$id'>$name</option>";
}

}else{
	echo "0";
}

?>