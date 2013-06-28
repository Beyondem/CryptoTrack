<?php
ob_start();
session_start();


include("config.php");



$currencyquery = "SELECT * FROM track_usdrates";
$result = mysql_query($currencyquery);
$count=mysql_num_rows($result);

while($trackeddata = mysql_fetch_assoc($result)){
  $id = $trackeddata['id'];
  $currencyname = $trackeddata['name'];
  $ratedata = file_get_contents("http://rate-exchange.appspot.com/currency?from=USD&to=$currencyname");
$ratejson = json_decode($ratedata);
$rate = $ratejson->{'rate'};
echo "-$currencyname==>$ratedata --> $rate<br>";
if ($rate != ""){
  $time = time();
  mysql_query("UPDATE track_usdrates SET rate='$rate', updated='$time' WHERE id='$id'");
}

}

?>