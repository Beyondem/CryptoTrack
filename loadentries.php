<?php
ob_start();
session_start();
if (!isset($_SESSION['username'])){
echo "Not logged in. Please refresh the page.";
die();
}

include("config.php");
$loginusername = $_SESSION['username'];

$sql="SELECT * FROM track_accounts WHERE username='$loginusername'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);

$userdata = mysql_fetch_assoc($result);
$userid = $userdata['id'];



$currencyquery = "SELECT * FROM track_entries WHERE accountid=$userid";
$result = mysql_query($currencyquery);
$count=mysql_num_rows($result);
if ($count > 0){
  echo "<table border=1 width=100%><tr><td>Currency</td><td>Exchange</td><td>Current Market Price</td><td>Amount</td><td>Bought At (Each)</td><td>Market Value</td><td>Change ($)</td><td>Change (%)</td><td>Added</td><td>Remove</td></tr>";
while($trackeddata = mysql_fetch_assoc($result)){
  $id = $trackeddata['id'];
  $currencyid = $trackeddata['currency'];
  $exchangeid = $trackeddata['exchangeid'];

  $sql="SELECT * FROM track_currencies WHERE id='$currencyid'";
$result2 = mysql_query($sql);
$count=mysql_num_rows($result2);

$coindata = mysql_fetch_assoc($result2);
$currencyname= $coindata['name'];
//$currentprice = $coindata['last'];



  $sql="SELECT * FROM track_exchanges WHERE id='$exchangeid'";
$result2 = mysql_query($sql);
$count=mysql_num_rows($result2);

$exdata = mysql_fetch_assoc($result2);
$exchangename = $exdata['name'];
$lastprice = $exdata['last'];


$currentprice = $lastprice;

  $amount = $trackeddata['amount'];
  $boughtat = $trackeddata['boughtat'];
  $added = $trackeddata['added'];
  $dateadded = date("F j, Y, g:i a",$added); 

$totalpaid = $amount * $boughtat;
$todayprice = $amount * $currentprice;

$gain = $todayprice - $totalpaid;
if ($totalpaid > 0){
$gainpercent = ($gain/ $totalpaid) * 100;
}else{
  $gainpercent = ($gain) * 100;
}

//$gainpercent = ($todayprice / $totalpaid) * 100;
$gainsign = "";
if ($gain > 0){
  $color = "green";
      $gainsign = "+";
$gainpercentdisplay = "+$gainpercent";
}else if($gain < 0){
$color = "red";
$gainpercentdisplay = "$gainpercent";
  $gain = $gain + (2 * (-$gain));
  $gainsign = "-";
}else{
  $color = "black";
  $gainpercentdisplay = "$gainpercent";
      $gainsign = "";
}



    $gaindisplay = "<font color='$color'>$gainsign$$gain</font>";
$gainpercentdisplay = "<font color='$color'>$gainpercentdisplay%</font>";

$marketvalue = $currentprice * $amount;


  echo "<tr><td>$currencyname</td><td>$exchangename</td><td>$$currentprice</td><td>$amount</td><td>$boughtat</td><td>$$marketvalue</td><td>$gaindisplay</td><td>$gainpercentdisplay</td><td>$dateadded</td><td><center><a href='javascript:deleteEntry($id)' class='btn btn-danger'><i class='icon-white icon-remove'></i></a></center></td></tr>";
}
echo "</table>";
}else{
  echo "No entries to view. <a href='javascript:toggleAdd()'>Add some</a>";
}
?>