<?php

include('crawl.php');

///////////// EMAIL CRAWLER EXAMPLE //////////////
$email = array();
$phone = array();
$facebook = array();
$linkedin = array();

email_crawl("http://boolid.com", $email, $phone, $facebook, $linkedin);

$unique_array = array_unique($email); 
foreach($unique_array as $result) echo $result."<br>";

$unique_array = array_unique($phone); 
foreach($unique_array as $result) echo $result."<br>";

$unique_array = array_unique($facebook); 
foreach($unique_array as $result) echo '<a href="' . $result . '"><img src="https://cdn1.iconfinder.com/data/icons/logotypes/32/square-facebook-512.png" height="42" width="42"></a><br>';

$unique_array = array_unique($linkedin); 
foreach($unique_array as $result) echo '<a href="' . $result . '"><img src="https://cdn1.iconfinder.com/data/icons/logotypes/32/square-linkedin-128.png" height="42" width="42"></a><br>';


////////////// GOOGLE CRAWLER EXAMPLE ////////////
$url = array();
$page = array();
$title = array();
google_crawl("Hello World", 1, 1, $url, $page, $title);
for($i = 0; $i < count($url); $i++) echo "[PAGE #" . $page[$i] . "] URL: ". $url[$i] .  " TITLE: ". $title[$i] . "<br>";

?>
