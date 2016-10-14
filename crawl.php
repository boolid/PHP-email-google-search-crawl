<?php

/*
	This Website Crawler is developed by Changjoo Jeon, Software Engineer from UBC
	Most of the codes were adapted from SubinSB
	Webcrawler function was Developed by SubinSB 
	From:	http://subinsb.com/how-to-create-a-simple-web-crawler-in-php
	Thanks to SubinSB I was able to finish email harvesting code
*/
 
include("simple_html_dom.php");

$crawled_urls=array();
$found_urls=array();

////////////// EMAIL CRAWLER EXAMPLE ////////////
/*
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
*/

/*
////////////// GOOGLE CRAWLER EXAMPLE ////////////
$url = array();
$page = array();
$title = array();
google_crawl("Hello World", 1, 1, $url, $page, $title);
for($i = 0; $i < count($url); $i++) echo "[PAGE #" . $page[$i] . "] URL: ". $url[$i] .  " TITLE: ". $title[$i] . "<br>";
*/

function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

function rel2abs($rel, $base){
	if (parse_url($rel, PHP_URL_SCHEME) != ''){
  		return $rel;
 	}
 	if ($rel[0]=='#' || $rel[0]=='?'){
  		return $base.$rel;
 	}
 	extract(parse_url($base));
 	$path = preg_replace('#/[^/]*$#', '', $path);
	 if ($rel[0] == '/'){
		  $path = '';
	 }
	 $abs = "$host$path/$rel";
	 $re = array('#(/.?/)#', '#/(?!..)[^/]+/../#');
	 for($n=1; $n>0;$abs=preg_replace($re,'/', $abs,-1,$n)){}
	 $abs=str_replace("../","",$abs);
	 return $scheme.'://'.$abs;
}  

function perfect_url($u,$b){
	 $bp=parse_url($b);
	 if(($bp['path']!="/" && $bp['path']!="") || $bp['path']==''){
		 if($bp['scheme']==""){
			$scheme="http";
		 }else{
			$scheme=$bp['scheme'];
	  	}
	  	$b=$scheme."://".$bp['host']."/";
 	}
	if(substr($u,0,2)=="//"){
		$u="http:".$u;
	}
 	if(substr($u,0,4)!="http"){
  		$u=rel2abs($u,$b);
 	}
 	return $u;
}

function find_email($subject, &$e_array = null) {
	$pattern="/(?:[A-Za-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[A-Za-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[A-Za-z0-9](?:[A-Za-z0-9-]*[A-Za-z0-9])?\.)+[A-Za-z0-9](?:[A-Za-z0-9-]*[A-Za-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[A-Za-z0-9-]*[A-Za-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
	$output = "";
	preg_match_all($pattern, $subject, $matches);

	foreach($matches[0] as $email){
		if($email != "" && (in_array($email,$e_array)==0)){
			echo "E-mail " . $email . " has been found! <br>";
			array_push($e_array, $email);
		}
	}
}

function find_phone($subject, &$p_array = null) {
	$pattern="/[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}|[0-9]{3}[\s][0-9]{3}[\-][0-9]{4}|[0-9]{3}[\-][0-9]{3}[\s][0-9]{4}
			  |[\(][0-9]{3}[\)][\-][0-9]{6}|[\(][0-9]{3}[\)][\s][0-9]{6}|[\(][0-9]{3}[\)][\s][0-9]{3}[\s][0-9]{4}|[\(][0-9]{3}[\)][\-][0-9]{3}[\-][0-9]{4}||[\(][0-9]{3}[\)][\s][0-9]{3}[\-][0-9]{4}|[\(][0-9]{3}[\)][\-][0-9]{3}[\s][0-9]{4}/";
	$output = "";
	preg_match_all($pattern, $subject, $matches);
	
	foreach($matches[0] as $phone){
		if( $phone != "" && (in_array($phone,$p_array)==0)){
			echo "Phone Number " . $phone . " has been found! <br>";
			array_push($p_array, $phone);
		}
	}
}

function find_facebook($url, &$f_array = null) {
	if (strpos($url, 'facebook') !== false && (in_array($url,$f_array)==0)) {
		echo "Facebook URL has been found! <br>";
	    array_push($f_array, $url);
	}
}

function find_linkedin($url, &$l_array = null) {
	if (strpos($url, 'linkedin') !== false && (in_array($url,$l_array)==0)) {
		echo "Linkedin URL has been found! <br>";
	    array_push($l_array, $url);
	}
}

function google_crawl($keyword, $start, $end, &$url_array = null, &$page_array = null, &$title_array = null){
 	global $crawled_urls, $found_urls;
 	$search = str_replace(' ', '%20', $keyword);
	echo $search . "<br>";
	for( $i = $start - 1; $i < $end; $i++){
		
		if( $i === 0 )
			$google_url = 'http://www.google.ca/search?hl=en&output=search&q=' . $search;
		else
			$google_url = 'http://www.google.ca/search?hl=en&output=search&q=' . $search . '&start=' . ($i * 10);
		
		echo "Searching Google for... " . $keyword . " IN PAGE " . ($i+1) . "<br>"; 
		echo "Google Search URL: " . $google_url . "<br>";
		if(get_http_response_code($google_url) === "200"){
			$html = file_get_html($google_url);
			foreach($html->find('h3') as $element) {
				$url = $element->find('a',0)->href; 
				$title = $element->plaintext;
				$url = str_replace('/url?q=', '', $url);	
				$pos = stripos($url,"sa=U");
				$url = substr($url, 0, (intval($pos) - 5));
				if(substr($url,0,4)!="http"){
					$url='http://' . $url;
				}
				
				$url = urldecode($url);
				
				if( (strpos($url, '/aclk?') === false) and (strpos($url, 'yelp') === false) and (strpos($url, 'linkedin') === false) and (strpos($url, 'adwords') === false) and (strpos($url, 'indeed') === false) and (strpos($url, 'groupon') === false) and (strpos($url, 'google') === false) and (strpos($url, 'yellowpages') === false)) {			
					//echo "FOUND URL AS:" . $url . "<br>";		
					array_push($url_array, $url);
					array_push($page_array, ($i+1));
					array_push($title_array, $title);
				}
			}
			echo "DONE CRAWLING " . $keyword . " IN PAGE " . ($i+1) . "<br>";
		}
		else
			echo "[ERROR " . get_http_response_code($u) . "]  UNABLE TO ACCESS GOOGLE... <br>";
		sleep(6);
	}
}

//Function to Crawl_Site
function email_crawl($u, &$e_array = null, &$p_array = null, &$f_array = null, &$l_array = null){
 	global $crawled_urls, $found_urls;
 	$uen=urlencode($u);

 	if((array_key_exists($uen,$crawled_urls)==0 || $crawled_urls[$uen] < date("YmdHis",strtotime('-5 seconds', time())))){
  		echo "CRAWLING.... " . $u . "<br>";
		if(get_http_response_code($u) === "200"){
			$html = file_get_html($u);
			$crawled_urls[$uen]=date("YmdHis");
			$counter = 0;
			foreach($html->find("a") as $li){
				$url=perfect_url($li->href,$u);
				$enurl=urlencode($url);
				if( $counter < 30 ){
					if($url!='' && substr($url,0,4)!="mail" && substr($url,0,4)!="java" && array_key_exists($enurl,$found_urls)==0){
							
							find_facebook($url, $f_array);
							find_linkedin($url, $l_array);
							$found_urls[$enurl]=1;
							$bp=parse_url($u);
							
							if (strpos($url, $bp['host']) !== false) {
								echo "[#". $counter . "] URL Found: ".$url."<br/>";
								if(get_http_response_code($url) === "200"){
									$html2 = file_get_html($url);
									find_email($html2->plaintext, $e_array);
									find_phone($html2->plaintext, $p_array);
								}
								else echo "[ERROR " . get_http_response_code($url) . "]  UNABLE TO ACCESS: " . $url . "<br>";
								$counter++;
							}
					}
				} else {
					echo "Crawled Too many URLs in this " . $u . " URL... Exiting this...... <br>";
					break;
				}
			}
			echo "DONE CRAWLING " . $u . "<br>";
		}
		else echo "[ERROR " . get_http_response_code($u) . "]  UNABLE TO ACCESS: " . $u . "<br>";
		sleep(6);
 	}
}
	
?>
