<?php
// application should check user login here

// $cname = urlencode($_GET['cname']);
$cname = urlencode ( $_POST ['cname'] );
if (! empty ( $cname )) {
	$url = "http://172.18.254.161:8000/sign?cname=$cname";
	$resp = http_get ( $url );
	echo $resp;
} else {
	echo 'cname is null';
}

/**
 * http get request
 * @param $url        	
 */
function http_get($url) {
	$res = file_get_contents ( $url );
	echo $res;
}
