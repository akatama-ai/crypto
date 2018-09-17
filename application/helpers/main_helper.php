<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function checkRedirect() {
	$CI =& get_instance();
	$settings = $CI->DefaultModel->getData("general-settings","single",["cache" => ["name" => "crc_general_settings"]]);
	$redirectLocation = 0;
	if(($settings['www'] != 1 && substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') || ($settings['www'] == 1 && substr($_SERVER['HTTP_HOST'], 0, 4) !== 'www.')) {
		$redirectLocation = 1;
	}
	else if(($settings['https'] == 1 && !httpsStatus()) || ($settings['https'] != 1 && httpsStatus())) {
		$redirectLocation = 1;
	}

	if($redirectLocation == 1) {
		$queryString  = $CI->input->server('QUERY_STRING');
		$url = base_url(uri_string()).(!empty($queryString) ? "?".$queryString : "");
		header("HTTP/1.1 301 Moved Permanently");
		redirect($url,"location",301);
		exit();
	}
}
function metaDisc($description)
{
	return htmlentities(removeExtraSpaces(strip_tags($description)));
}

function removeExtraSpaces($cleanStr)
{
	$cleanStr = trim(preg_replace('/\s\s+/',' ',$cleanStr));
	return $cleanStr;
}
function isAlphaSpaces($val) {
	return (bool) preg_match("/^([a-zA-Z ])+$/i", $val);
}

function isAlphaNum($val) {
	return (bool) preg_match("/^([a-zA-Z0-9])+$/i", $val);
}

function validEmail($email) {
	return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? true : false;	
}

function getIpAddress() {
	switch(true) {
		case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
		case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
		case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
		default : return $_SERVER['REMOTE_ADDR'];
    }
}

function intlCurFmtr($number,$c=false)
{
	if($number==0)
	{
		return $number;
	}
	
	if($number >999999 && !$c)
	return parseNumberPriceBase($number);

	$number=rtrim(sprintf("%.10f",$number), "0");
	list($whole, $decimal) = explode('.', $number);
	
	if($whole<=0)
	{
		return $number;
	}
	$decimal=round(".".$decimal,3); 
	$finalNumber=number_format($whole+$decimal,3);
	return $finalNumber;
}
	
function clearString($data) {
    $data = stripslashes(trim($data));
	$data = strip_tags($data);
	$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	return $data;
}

function getRemoteContents($url) {
	$USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	$result = false;
	if(extension_loaded('curl') === true) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_USERAGENT, $USER_AGENT);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		unset($ch);	
		if($httpcode != 200) {
			$result = false;
		}
	}
	return $result;
}

function getDomain($url) {
	if(preg_match("#https?://#", $url) === 0) {
		$url = 'http://' . $url;
	}
	return strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST)));
}
function parseNumberPriceBase($n) {
	// first strip any formatting;
	$n = (0+str_replace(",", "", $n));

	// is this a number?
	if (!is_numeric($n)) return false;

	// now filter it;
	if ($n > 1000000000000) return round(($n/1000000000000), 2).' T';
	elseif ($n > 1000000000) return round(($n/1000000000), 2).' B';
	elseif ($n > 1000000) return round(($n/1000000), 2).' M';
	elseif ($n > 1000) return round(($n/1000), 2).' K';

	return number_format($n);
}
function httpsStatus() {
	if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on') {
		return true;
	}
	else if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
		return true;
	}
	else if(isset($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on') {
		return true;
	}
	else if(isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https') {
		return true;
	}
	return false;
}

function generatePermalink($entry)  {
	$permalink = strtolower(strip_tags($entry));
	if (!mb_check_encoding($permalink, "UTF-8")) {
		$permalink = preg_replace('/[^a-z0-9]/i', ' ', $permalink);
		$permalink = trim(preg_replace("/[[:blank:]]+/", " ", $permalink));
		$permalink = strtolower(str_replace(" ", "-", $permalink));	
	}
	else {
		$permalink = trim($entry);
		$permalink = str_replace(" ", "-", $permalink);
	}
	$permalink = cleanPermalink($permalink);
	return strtolower($permalink);
}
function readFileLanguage($fileId)
{
	$languageValues = file_get_contents("lang-files/".$fileId.".json");
	return json_decode($languageValues,true);
}
function getSetPreviuosLoginedUserInfoHash($state='get',$data=[])
{
	$cookie_name='uCryp';
	if($state == 'get')
	{
		if(isset($_COOKIE[$cookie_name]))
		{
		   $cookieData=json_decode($_COOKIE[$cookie_name],true);
		   if(isset($cookieData)) 
			{
				if(is_array($cookieData)) 
				{
					if(count($cookieData)==2)
					{
						$hash=$cookieData[0];
						if(strlen($hash)==8)
						{
							return $cookieData;
						}
						else
						{
							 setcookie($cookie_name,"", time() - (86400 * 20), "/");
						}
					}
				}
			}
		  
		}
		return [];
	}
	else
	{
	   $cookieData=json_encode($data);
	   setcookie($cookie_name, $cookieData, time() + (86400 * 20), "/");
	}
}
function getSetUserLanguage($activeLanguages){

	$overRide=false;
	if(isset($_GET['language']))
	{
		$language=trim(stripcslashes(strip_tags($_GET['language'])));
		$overRide=true;
		$key=array_search($language,array_column($activeLanguages,'code'));
		if(is_numeric($key))
		{
			$def=$activeLanguages[$key];
			$overRide=true;
		}
	}
	else
	{
		$def=$activeLanguages[0];
	}
	
   $cookie_name = "defLang";
   $defaultId=$def['id'];
   if(!isset($_COOKIE[$cookie_name]))
   {
	   $cookieData=json_encode([$defaultId]);
		setcookie($cookie_name, $cookieData, time() + (86400 * 20), "/");
	}
	else 
	{
		$cookieData=json_decode($_COOKIE[$cookie_name],true);
		if(isset($cookieData)) {
			if(is_array($cookieData)) {
				if(count($cookieData)==1){
					if($overRide)
					{
						if(!in_array($defaultId,$cookieData)) 
						{
							$cookieDataN=json_encode([$defaultId]);
							setcookie($cookie_name, $cookieDataN, time() + (86400 * 20), "/");
						}
					}
					else
					{
						$key=array_search($cookieData[0],array_column($activeLanguages,'id'));
						if(is_numeric($key))
						{
							$def=$activeLanguages[$key];
						}
					}
				}
			}
		}
	}

	return $def; 
}

function getSetUserTheme($lights="on"){
	$defaultThemes=['on','off'];
	$overRide=false;
	if(isset($_GET['lights']))
	{
		$theme=trim(stripcslashes(strip_tags($_GET['lights'])));
		if(in_array($theme,$defaultThemes))
		{
			$lights=$theme;
			$overRide=true;
		}
	}
	
   $cookie_name = "lights";
   $def=$lights;
   if(!isset($_COOKIE[$cookie_name]))
   {
	   $cookieData=json_encode([$lights]);
		setcookie($cookie_name, $cookieData, time() + (86400 * 20), "/");
	}
	else 
	{
		$cookieData=json_decode($_COOKIE[$cookie_name],true);
		if(isset($cookieData)) {
			if(is_array($cookieData)) {
				if(count($cookieData)==1){
					if($overRide)
					{
						if(!in_array($lights,$cookieData)) 
						{
							$cookieDataN=json_encode([$lights]);
							setcookie($cookie_name, $cookieDataN, time() + (86400 * 20), "/");
							$def=$lights;
						}
					}
					else
					{
						$def=$cookieData[0];
					}
				}
			}
		}
	}

	return $def=='on'?true:false; 
}
function cleanPermalink($permalink)  {
	$to_clean  = array("#","%","&","$","*","{","}","(",")","@","^","|","/",";",".",",","`","!","\\",":","<",">","?","/","+",'"',"'");
	$permalink = str_replace(" ", "-", $permalink);
	foreach ($to_clean as $symbol) {
		$permalink = str_replace($symbol, "", $permalink);
	}
	while (strpos($permalink, '--') != false) {
		$permalink = str_replace("--", "-", $permalink);
	}
	$permalink = rtrim($permalink, "-");
	$permalink = ltrim($permalink, "-");
	if ($permalink != "-") {
		return $permalink;
	}
	else {
		return "";
	}
}

function showLangVal($language,$index) {
	if(isset($language[$index])) { return $language[$index]; }
	else { return NULL; }
}
?>