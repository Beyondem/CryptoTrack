<?php
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])){ die("<div class='error'>Access Denied.</div>"); }
include("config.php");


function updateGox(){
$result = False;
  $url = "https://data.mtgox.com/api/2/BTCUSD/money/ticker";
  $CH = curl_init();
    curl_setopt($CH, CURLOPT_URL, $url);
    curl_setopt($CH, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($CH, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($CH, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($CH, CURLOPT_TIMEOUT, 5);
    curl_setopt($CH, CURLOPT_USERAGENT, "CryptoTrack.com");
    $output = curl_exec($CH);
 //   echo "result:$output";
        $results = json_decode($output);
        $parsed = get_object_vars($results);
  $dataarray = get_object_vars($parsed['data']);
  //print_r($dataarray);
  $last = get_object_vars($dataarray["last"]);
  $last = $last["value"];
    $low = get_object_vars($dataarray["low"]);
    $low = $low["value"];
      $high = get_object_vars($dataarray["high"]);
      $high = $high["value"];
$data["last"] = $last;
$data["high"] = $high;
$data["low"] = $low;
$time = time();
//echo "Gox: $last - $low - $high";


$last = mysql_real_escape_string($last);
$low = mysql_real_escape_string($low);
$high = mysql_real_escape_string($high);
if ($last != "" && $low != "" && $high != "" && $last != "null" && $low != "null" && $high != "null"){
mysql_query("UPDATE track_exchanges SET last='$last', high='$high', low='$low',updated=$time WHERE name='MtGox' AND currencyid=1");
}else{
 // echo "Error updating MT GOX.";
}
return $data;
}


function getGox(){
$sql="SELECT * FROM price WHERE exchange='mtgox'";
$result = mysql_query($sql);
$exchangeinfo = mysql_fetch_assoc($result);
$last = $exchangeinfo['last'];
$high = $exchangeinfo['high'];
$low = $exchangeinfo['low'];
$lastupdate = $exchangeinfo['lastupdate'];
$currenttime = time();
$difference = $currenttime - $lastupdate;
if ($difference > 4){
	return updateGox();
}
//echo "getgox: $last $high $low";
$data["last"] = $last;
$data["high"] = $high;
$data["low"] = $low;
return $data;
}


function getBTCE(){
$sql="SELECT * FROM price WHERE exchange='btc-e'";
$result = mysql_query($sql);
$exchangeinfo = mysql_fetch_assoc($result);
$last = $exchangeinfo['last'];
$high = $exchangeinfo['high'];
$low = $exchangeinfo['low'];
$lastupdate = $exchangeinfo['lastupdate'];
$currenttime = time();
$difference = $currenttime - $lastupdate;
if ($difference > 4){
	return updateBTCE();
}
//echo "getgox: $last $high $low";
$data["last"] = $last;
$data["high"] = $high;
$data["low"] = $low;
return $data;
}

function updateAllBTCE(){
  $sql="SELECT * FROM track_exchanges WHERE name='BTC-E'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);

$btcusdlast = "";
$btcusdlow = "";
$btcusdhigh = "";
while($exchangedata = mysql_fetch_assoc($result)){
  $name = $exchangedata['name'];
  $id = $exchangedata["id"];
  $pair = $exchangedata['apipair'];
  $data = getBTCEData($pair);
  $last = $data['last'];
  $low = $data['low'];
  $high = $data['high'];
  if ($pair == "btc_usd"){
    $btcusdlast = $last;
    $btcusdlow = $low;
    $btcusdhigh = $high;
  //  echo "<br>BTCUSD: $btcusdlast $btcusdlow $btcusdhigh";
  }
  if (endsWith($pair,"_btc")){
   // echo "<br>Keypair is to BTC!";
    $last = $last * $btcusdlast;
    $low = $low * $btcusdlow;
    $high = $high * $btcusdhigh;
  }
  //echo "<br>Last: $last, Low: $low, High: $high";
  //echo "id->$id";

  if ($last != "" && $low != "" && $high != "" && $last != "null" && $low != "null" && $high != "null"){
    $time = time();
mysql_query("UPDATE track_exchanges SET last='$last', high='$high', low='$low',updated=$time WHERE id='$id'");
}


}
}


function startsWith($haystack, $needle)
{
    return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}


function getBTCEData($pair){

  $result = False;
  $url = "https://btc-e.com/api/2/$pair/ticker";
  $CH = curl_init();
    curl_setopt($CH, CURLOPT_URL, $url);
    curl_setopt($CH, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($CH, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($CH, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($CH, CURLOPT_TIMEOUT, 5);
    curl_setopt($CH, CURLOPT_USERAGENT, "CurrentBitcoinPrice.com");
    $output = curl_exec($CH);
 //   echo "result:$output";
        $results = json_decode($output);
        $parsed = get_object_vars($results);
  $dataarray = get_object_vars($parsed['ticker']);
$last = $dataarray['last'];
$low = $dataarray['low'];
$high = $dataarray['high'];
$data["last"] = $last;
$data["high"] = $high;
$data["low"] = $low;
$time = time();
$last = mysql_real_escape_string($last);
$low = mysql_real_escape_string($low);
$high = mysql_real_escape_string($high);
//echo "<br>pair: $pair -- $last - $low - $high";
return $data;
}



function updateBTCE(){

	$result = False;
  $url = "https://btc-e.com/api/2/btc_usd/ticker";
  $CH = curl_init();
    curl_setopt($CH, CURLOPT_URL, $url);
    curl_setopt($CH, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($CH, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($CH, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($CH, CURLOPT_TIMEOUT, 5);
    curl_setopt($CH, CURLOPT_USERAGENT, "CurrentBitcoinPrice.com");
    $output = curl_exec($CH);
 //   echo "result:$output";
        $results = json_decode($output);
        $parsed = get_object_vars($results);
  $dataarray = get_object_vars($parsed['ticker']);
$last = $dataarray['last'];
$low = $dataarray['low'];
$high = $dataarray['high'];
$data["last"] = $last;
$data["high"] = $high;
$data["low"] = $low;
$time = time();
$last = mysql_real_escape_string($last);
$low = mysql_real_escape_string($low);
$high = mysql_real_escape_string($high);
//echo "<br>Btce: $last - $low - $high";
if ($last != "" && $low != "" && $high != "" && $last != "null" && $low != "null" && $high != "null"){
mysql_query("UPDATE track_exchanges SET last='$last', high='$high', low='$low',updated=$time WHERE name='BTC-E' AND currencyid=1");
}else{
 // echo "Error updating BTC-E";
}
return $data;
}
  ?>

   
