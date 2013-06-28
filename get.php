<?php
include("config.php");
include("functions.php");

$updated = "SELECT * FROM track_stats WHERE statkey='updated'";
$result = mysql_query($updated);
$updatedetails = mysql_fetch_assoc($result);
$updatetime = $updatedetails['value'];
$time = time();
if (($time - $updatetime) > 3){
updateGOX();
updateALLBTCE();
mysql_query("UPDATE track_stats SET value='$time' WHERE statkey='updated'");
}

$currencyquery = "SELECT * FROM track_currencies";
$result = mysql_query($currencyquery);
$data = array();
while($currencydata = mysql_fetch_assoc($result)){
  $id = $currencydata['id'];
  $name = $currencydata['name'];
  $resultexchange = mysql_query("select * from track_exchanges WHERE currencyid=$id");
  $countexchange=mysql_num_rows($resultexchange);
  if ($countexchange > 0){
   // echo "<div class='span3'>$name";
   // echo "<table border=1><tr><td>Exchange</td><td>Low</td><td>Last</td><td>High</td></tr>";
    while($exchangedata = mysql_fetch_assoc($resultexchange)){
    	$exchangeid = $exchangedata['id'];
      $exchangename = $exchangedata['name'];
      $last = $exchangedata['last'];
      $low = $exchangedata['low'];
      $high = $exchangedata['high'];
      $data[$exchangeid] = array("name"=>$exchangename,"last"=>$last,"low"=>$low,"high"=>$high);

   //   echo "<tr><td>$exchangename</td><td><span class='label label-success'>$$low</span></td><td><span class='label label-success'>$$last</span></td><td><span class='label label-success'>$$high</span></td></tr>";
      //echo "<span class='label label-success'>$exchangename</span></p>";
    }
}
    //echo "</table></div>";
  }


/*  $data = array();
  $exchange1 = array("low"=>"1","high"=>10);
  $data["Bitcoin"] = array($exchange1,'btce');
  $data["Litecoin"] = array('vircurex','test');
  */

echo json_encode($data);

//$jsondata = json_encode(array('last'=>$data['last'],'high'=>$data['high'],'low'=>$data['low']));
//echo $jsondata;
  ?>

   
