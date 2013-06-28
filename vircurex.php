<?php


  $result = False;
  $url = "https://vircurex.com/api/get_info_for_currency.json";
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

//echo "<br>pair: $pair -- $last - $low - $high";
echo "Num Results: ". count($results);
echo "<br>$output";

?>