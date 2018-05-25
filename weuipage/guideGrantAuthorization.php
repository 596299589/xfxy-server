<?php
header("Content-Type: text/html; charset=utf-8");

require_once 'jssdk.php';
$jssdk = new JSSDK ();
$appId=$jssdk->getAppId();

$type = $_GET ['type'];
$redirect_uri = null;
if ($type == 'shareMap') {
	$redirect_uri = urlencode("http://auto.fourtech.me/jdy_service/weuipage/shareMap.php");
} else if($type == 'vehicleLocation'){
	$redirect_uri = urlencode("http://auto.fourtech.me/jdy_service/location/vehicleLocation.php");
} else if($type == 'aroundPoint'){
	$redirect_uri = urlencode("http://auto.fourtech.me/jdy_service/location/aroundPoint.php");
}

if ($redirect_uri) {
	$uri = "Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appId&redirect_uri=" . $redirect_uri . "&response_type=code&scope=snsapi_base&state=2064#wechat_redirect";
	// 重定向浏览器
	header ( $uri );
	// 确保重定向后，后续代码不会被执行
	exit ();
} else {
	echo "<script>alert('请求有误，请稍后重试');</script>";
}

?>