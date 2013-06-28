<?php
ob_start();
session_start();
if (!isset($_SESSION['username'])){
header("location:login.php");
die();
}

include_once("config.php");

$loginusername = $_SESSION['username'];

$sql="SELECT * FROM track_accounts WHERE username='$loginusername'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);

$userdata = mysql_fetch_assoc($result);
$userid = $userdata['id'];





?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <?php include ("title.php"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

  
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 60px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 80px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 100px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }


      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
      }
      .navbar .nav {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav li a {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
      }



    </style>
      <link href="chardin/chardinjs.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="switch/bootstrapSwitch.css">
<style>
/*.chardinjs-show-element a {
  color: #FFFFFF;
}*/
.charwhite p.chardinjs-show-element, .chardinjs-show-element {
  color: #cccccc;
}
</style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="bootstrap/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="bootstrap/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="bootstrap/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="bootstrap/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="bootstrap/ico/favicon.png">
  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <h3 class="muted">Crypto Track</h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li class="active"> <a href="account.php">Account</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>

      <!-- Jumbotron -->
      <div class="jumbotronn">
    <!--    <h1>Crypto Track</h1>-->
    <div id="prices" class="row-fluid" width="100%" data-intro="Current market prices, updating live" data-position="top">
  <?php
$currencyquery = "SELECT * FROM track_currencies";
$result = mysql_query($currencyquery);
while($currencydata = mysql_fetch_assoc($result)){
  $id = $currencydata['id'];
  $name = $currencydata['name'];
  $resultexchange = mysql_query("select * from track_exchanges WHERE currencyid=$id");
  $countexchange=mysql_num_rows($resultexchange);
  if ($countexchange > 0){
    echo "<div class='span4'>$name";
    echo "<table border=1><tr><td>Exchange</td><td>Low</td><td>Last</td><td>High</td></tr>";
    while($exchangedata = mysql_fetch_assoc($resultexchange)){
      $exchangename = $exchangedata['name'];
      $exchangeid = $exchangedata['id'];
      $last = $exchangedata['last'];
      $low = $exchangedata['low'];
      $high = $exchangedata['high'];
      echo "<tr><td>$exchangename</td><td><span id='$exchangeid-low' class='label label-info'>$$low</span></td><td><span id='$exchangeid-last' class='label label-info'>$$last</span></td><td><span id='$exchangeid-high' class='label label-info'>$$high</span></td></tr>";
      //echo "<span class='label label-success'>$exchangename</span></p>";
    }
    echo "</table></div>";
  }

}

  ?>

</div>
<font size="1">-Yeah, I know the charts above are displayed horribly. That will be corrected.-</font>
<!--<a href="javascript:updatePrices()">Updateprices</a>-->

        <h2 class="form-signin-heading"></h2>
       <a href="javascript:toggleAdd()" class="btn btn-primary btn-large" id="addbutton"><i class="icon-white icon-plus"></i> Add Entry</a>
       <div id="canceldiv" style="display:none">
        <a href="javascript:cancelAdd()" class="btn btn-danger btn-large"><i class="icon-white icon-remove-sign"></i> Cancel</a>
       </div>
       <a href="javascript:showHelp()" class="btn btn-danger btn-small" id="helpbutton" data-intro="Close help" data-position="right"><i class="icon-white icon-question-sign"></i> Help</a>


<div id="add" style="display:none">
<!--<a href="javascript:cancelAdd()" class="btn btn-danger btn-large"><i class="icon-white icon-remove-sign"></i> Cancel</a>-->
<center>
<table border="1" width="100%">
<tr><td>Coin</td><td>Exchange</td><td>Amount</td><td>Bought At </td></tr>  <form id="addentry">
<tr><td>

<select id="coin" data-intro="Which coin type?" data-position="bottom">
  <option>Coin...</option>
  <?php
$currencyquery = "SELECT * FROM track_currencies";
$result = mysql_query($currencyquery);
while($currencydata = mysql_fetch_assoc($result)){
  $id = $currencydata['id'];
  $name = $currencydata['name'];
  echo "<option>$name</option>";
}

  ?>

</select>
</td>
<td>
<select id="exchange" data-intro="Which exchange rates to use?" data-position="bottom">
  <option>Select coin type first</option>
</select>
</td>
<td><input type="text" id="coinamount" size="3" data-intro="How many coins?" data-position="bottom"></td>

<!--<td><input type="text" id="boughtat" placeholder="$"></td>-->
<td>
  <div class="input-append">
  <input class="span2" id="boughtat" size="3" type="text" data-intro="Price bought at" data-position="bottom">
  <div class="btn-group">
    <button id = "buttoncurrency" class="btn dropdown-toggle" data-toggle="dropdown" data-intro="Currency to track it in" data-position="top">
      USD
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
            <li><a href="javascript:setCurrency('USD')">USD</a></li>

            <?php
            $currencyquery = "SELECT * FROM track_usdrates";
$result = mysql_query($currencyquery);
while($currencydata = mysql_fetch_assoc($result)){
  $name = $currencydata['name'];
  echo "<li><a href=\"javascript:setCurrency('$name')\">$name</a></li>";
}
            ?>
    <!--  <li><a href="javascript:setCurrency('BTC')">BTC</a></li>
            <li><a href="javascript:setCurrency('LTC')">LTC</a></li>-->
    </ul>
  </div>
<div class="switch" data-on="info" data-off="success" data-on-label="Each" data-off-label="Total" data-intro="Input prices based on amount paid for each, or total paid for the amount entered. If total paid for amount entered, the total paid each is calculated by dividing." data-position="bottom">
    <input type="checkbox" id ="eachtotal" checked />
</div>
</div>



</td>

</tr>
</table>

<div id="statusmessage"></div>
<a href="javascript:doAdd()" class="btn btn-success" data-intro="Save it!" data-position="right"><i class="icon-white icon-plus"></i> Add</a>
</form>
</center>

  </div>

      </div>

      <hr>
<a href="javascript:reloadEntries()" class="btn btn-info" data-intro="Recalculate based on current rates" data-position="right"><i class="icon-white icon-refresh"></i></a>
<div id="entries">
</div>


<!--buttons-->


<span class='st_twitter' displayText='Tweet'></span>
<span class='st_facebook' displayText='Facebook'></span>
<span class='st_googleplus' displayText='Google +'></span>
<span class='st_email' displayText='Email'></span>
<span class='st_twitterfollow' displayText='Twitter Follow' st_username='BeyondemInc'></span>
<!--endsharebuttons-->

      <hr>

      <div class="footer">
        <?php include("footer.php"); ?>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   <script src="bootstrap/js/jquery.js"></script>
 <script src="bootstrap/js/bootstrap-dropdown.js"></script>
 <script src="bootstrap/js/bootstrap-button.js"></script>
<script src="chardin/chardinjs.min.js"></script>
<script src="switch/bootstrapSwitch.js"></script>
<!--    <script src="bootstrap/js/bootstrap-transition.js"></script>
  <script src="bootstrap/js/bootstrap-alert.js"></script>
    <script src="bootstrap/js/bootstrap-modal.js"></script>
    <script src="bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/js/bootstrap-tab.js"></script>
    <script src="bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
    <script src="bootstrap/js/bootstrap-button.js"></script>
    <script src="bootstrap/js/bootstrap-collapse.js"></script>
    <script src="bootstrap/js/bootstrap-carousel.js"></script>
    <script src="bootstrap/js/bootstrap-typeahead.js"></script>
  -->



    <Script>

    function type(){
      var type = document.getElementById("eachtotal");
      console.log("type:" + type.checked);
    }
function toggleAdd(){
          document.getElementById("statusmessage").innerHTML = "";
  $('#add').show();
  $('#canceldiv').show();
    $('#addbutton').hide();
}

function cancelAdd(){
$('#add').hide();
$('#canceldiv').hide();
 $('#addbutton').show();
document.getElementById("coinamount").value = "";
document.getElementById("boughtat").value = "";
}

String.prototype.startsWith = function(needle)
{
    return(this.indexOf(needle) == 0);
};


function reloadEntries(){
  $('#entries').load('loadentries2.php');
}


function deleteEntry(id){
if (confirm('Are you sure you want to delete this entry?')) {
$.post("delete.php", { entry:id},
   function(data) {
//console.log("doPost Data:" + data);
if (data.startsWith("Error:")){
  alert(data);
  }else{
  reloadEntries();   

  }


   });
} 
}
var selectedCurrency = "USD";
function getCurrency(){
  alert("Cur:" + selectedCurrency);
}
function setCurrency(currency){
  selectedCurrency = currency;
  document.getElementById("buttoncurrency").innerHTML = currency + "<span class='caret'></span>";
}
reloadEntries();
function doAdd(){
var coin = document.getElementById("coin").value;
var amount = document.getElementById("coinamount").value;
var boughtat = document.getElementById("boughtat").value;
var exchange = document.getElementById("exchange").value;
var type = document.getElementById("eachtotal");

if (!type.checked){
  boughtat = boughtat / amount;
}
if (!$.isNumeric(amount) || !$.isNumeric(boughtat)){
  document.getElementById("statusmessage").innerHTML = "<b><font color='red'>Both Amount and the Bought At Price must be Numeric!</font></b>"
}else{
  if (coin == "Coin..."){
      document.getElementById("statusmessage").innerHTML = "<b><font color='red'>You must choose a coin type.</font></b>"
      return;
  }
document.getElementById("statusmessage").innerHTML = "";
//Add it:
$.post("save2.php", { type:"Add",coin:coin,amount:amount,boughtat:boughtat,exchange:exchange,currency:selectedCurrency},
   function(data) {
console.log("doPost Data:" + data);
if (data.startsWith("Error:")){
    document.getElementById("statusmessage").innerHTML = "<b><font color='red'>" + data + "</font></b>"
  }else{
    //success?
    console.log("Success->" + data);
        document.getElementById("statusmessage").innerHTML = "<b><font color='green'>Added</font></b>"
  reloadEntries();
  setTimeout('cancelAdd()',1000);
    //Close + Refresh bottom table:

  }

   });

}



}

  $("#coin").change(function() {

  var $dropdown = $(this);
var key = $dropdown.val();
    var $ex= $("#exchange");
if (key != "Coin..."){
     $ex.empty();
    $ex.html("<option>Loading...</option>");
$.post("getexchanges.php", { coin:key},
   function(data) {
//console.log("getexchanges Data:" + data);
 if (data != "Error"){
    $ex.empty();
    $ex.html(data);
}else{
  alert("Error choosing this coin. There may not be an exchange associated with it yet. Try again later");
     $ex.empty();
    $ex.html("<option>Select coin type first</option>");
}

   });
}else{
    $ex.empty();
    $ex.html("<option>Select coin type first</option>");
}

});


function updatePrices(){
  $.post("get.php", { },
   function(data) {
//console.log("updateprices Data:" + data);
var json = JSON.parse(data);
//console.log("Size:" + json.count);
for (var key in json) {
  if (json.hasOwnProperty(key)) {
   // console.log("--> " + key + ":" + json[key]);
var exchangedata = json[key];
 //   for (var key2 in exchangedata) {
//  if (exchangedata.hasOwnProperty(key2)) {
 //   console.log("--> " + key2 + ":" + exchangedata[key2]);
    var lastElement = document.getElementById(key + "-last");
    var lowElement = document.getElementById(key + "-low");
    var highElement = document.getElementById(key + "-high");

    var curLast = lastElement.innerHTML;
    var curLow = lowElement.innerHTML;
    var curHigh = highElement.innerHTML;
curLast = curLast.replace("$","");
curLow = curLow.replace("$","");
curHigh = curHigh.replace("$","");
    var last = exchangedata["last"];
    var low= exchangedata["low"];
    var high = exchangedata["high"];

if (last != curLast){
 //console.log("Last not equal - last:" + last + ", curlast: " + curLast);
    lastElement.innerHTML = "$" + last;
    if (last > curLast){
      lastElement.className = "label label-success";
    }else if (last < curLast){
      lastElement.className = "label label-important";
    }
}

if (low != curLow){
    lowElement.innerHTML = "$" + low;
    if (low > curLow){
      lowElement.className = "label label-success";
    }else if (low < curLow){
      lowElement.className = "label label-important";
    }
}

if (high != curHigh){
    highElement.innerHTML = "$" + high;
    if (high > curHigh){
      highElement.className = "label label-success";
    }else if (high < curHigh){
      highElement.className = "label label-important";
    }
}
 //   document.getElementById(key + "-last").innerHTML = "-last:" + exchangedata["last"] + "-";
  //  document.getElementById(key + "-low").innerHTML = "-low-";
  //  document.getElementById(key + "-high").innerHTML = "-high-";
//document.getElementById(key + "-high").className = "label label-important";
  //}
//}



  }
}

   });

//console.log("Done Updating");

}
setInterval("updatePrices()",3000);

function showHelp(){
  toggleAdd();
  $('body').chardinJs('toggle')
}

    </script>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "ur-772be8b5-fc83-a737-9ef5-951249d7aee4", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
  </body>
</html>

