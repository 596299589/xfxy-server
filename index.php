<?php
include_once 'message/WxMessageHandle.php';

$wechatObj = new XfxyServiceCallback ();
$wechatObj->valid ();
class XfxyServiceCallback {
	public function valid() {
		$echoStr = $_GET ['echostr'];
		// $echoStr = $_GET["echostr"];
		if (isset ( $echoStr )) {
			include_once 'message/CheckSignature.php';
			$checkSignature = new CheckSignature ();
			if ($checkSignature->checkSignature ()) {
				echo $echoStr;
				exit ();
			}
		} else {
			$wxMessageHandle = WxMessageHandle::getinstance ();
			$wxMessageHandle->responseMsg ();
		}
	}
}

?>

