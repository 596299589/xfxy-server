<?php
/* 扫码后微信服务器回调监听 */
include_once '../utils/LogUtil.php';


$scavengingCallbackMonitor = new ScavengingCallbackMonitor();
$scavengingCallbackMonitor->callback();

class ScavengingCallbackMonitor {
	function __construct() {
	}
	
	public function callback() {
		$this->log("callback");
	}
	
	function log($logContent) {
		$logUtil = LogUtil::getinstance ();
		$logUtil->printlnLog($logContent);
	}
	
	
}
