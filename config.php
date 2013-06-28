<?php
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])){ die("<div class='error'>Access Denied.</div>"); }
$host = 'localhost'; 
$dbuser = ''; 
$dbpass = ''; 
$dbname = '';
$connection = mysql_connect("$host", "$dbuser", "$dbpass") or die();
mysql_select_db("$dbname") or die("Database connection error. Try again later.");
?>
