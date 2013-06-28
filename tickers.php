<?php
ob_start();
session_start();
include_once("config.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <div id="prices" class="ro-w-fluid" width="100%" data-intro="Current market prices, updating live" data-position="top">
  <?php
$currencyquery = "SELECT * FROM track_currencies";
$result = mysql_query($currencyquery);
while($currencydata = mysql_fetch_assoc($result)){
  $id = $currencydata['id'];
  $name = $currencydata['name'];
  $resultexchange = mysql_query("select * from track_exchanges WHERE currencyid=$id");
  $countexchange=mysql_num_rows($resultexchange);
  if ($countexchange > 0){
    echo "<div class='span-4'>$name";
    echo "<table border=1><tr><td>Exchange</td><td>Low</td><td>Last</td><td>High</td></tr>";
    while($exchangedata = mysql_fetch_assoc($resultexchange)){
      $exchangename = $exchangedata['name'];
      $exchangeid = $exchangedata['id'];
      $last = $exchangedata['last'];
      $low = $exchangedata['low'];
      $high = $exchangedata['high'];
      echo "<tr><td>$exchangename</td><td><span id='$exchangeid-low' class='label label-info'>$$low</span></td><td><span id='$exchangeid-last' class='label label-info'>$$last</span></td><td><span id='$exchangeid-high' class='label label-info'>$$high</span></td></tr>";
    }
    echo "</table></div>";
  }

}

  ?>

</div>


   <script src="bootstrap/js/jquery.js"></script>


    <Script>
function updatePrices(){$.post("get.php",{},function(b){b=JSON.parse(b);for(var c in b)if(b.hasOwnProperty(c)){var a=b[c],g=document.getElementById(c+"-last"),h=document.getElementById(c+"-low"),j=document.getElementById(c+"-high"),d=g.innerHTML,e=h.innerHTML,f=j.innerHTML,d=d.replace("$",""),e=e.replace("$",""),f=f.replace("$",""),k=a.last,l=a.low,a=a.high;k!=d&&(g.innerHTML="$"+k,k>d?g.className="label label-success":k<d&&(g.className="label label-important"));l!=e&&(h.innerHTML="$"+l,l>e?h.className=
"label label-success":l<e&&(h.className="label label-important"));a!=f&&(j.innerHTML="$"+a,a>f?j.className="label label-success":a<f&&(j.className="label label-important"))}})}setInterval("updatePrices()",3E3);
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-4515844-88']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

 </body>
</html>

