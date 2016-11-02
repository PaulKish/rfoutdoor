<?php
//~ http://api.worldweatheronline.com/free/v1/tz.ashx?key=xxxxxxxxxxxxxxxxx&q=London&format=xml
//This cURL example requires php_curl. To verify installion,  phpinfo();
//Failure to support cURL results in:   PHP Fatal error:  Call to undefined function curl_init() 

//Minimum request
//Can be city,state,country, zip/postal code, IP address, longtitude/latitude. If long/lat are 2 elements, they will be assembled. IP address is one element.
$loc_array= Array("London","uk");			//data validated in foreach. 
$api_key="xkq544hkar4m69qujdgujn7w";		//should be embedded in your code, so no data validation necessary, otherwise if(strlen($api_key)!=24)

$loc_safe=Array();
foreach($loc_array as $loc){
	$loc_safe[]= urlencode($loc);
}
$loc_string=implode(",", $loc_safe);

//To add more conditions to the query, just lengthen the url string
$basicurl=sprintf('http://api.worldweatheronline.com/free/v1/tz.ashx?key=%s&q=%s&format=xml', 
	$api_key, $loc_string);

print $basicurl . "<br />";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $basicurl);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1); 
$xml_response =curl_exec($ch);
curl_close($ch);

$xml = simplexml_load_string($xml_response);
printf("<p>The time zone at %s is %s and the local time is %s</p>", 
	$xml->request->query, $xml->time_zone->utcOffset, $xml->time_zone->localtime );

print "<pre>";
print_r($xml);
print "</pre>";
?>
