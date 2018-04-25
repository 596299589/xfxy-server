<?php
include_once 'utils/LogUtil.php';

/**
 * 微信消息推送处理类
 * @author yt
 *
 */
class WxMessageHandle {
	private function __construct() {
	}
	public static $instance; // 声明一个静态变量（保存在类中唯一的一个实例）
	static public function getinstance() { // 声明一个getinstance()静态方法，用于检测是否有实例对象
		if (! self::$instance)
			self::$instance = new self ();
		return self::$instance;
	}
	
	/**
	 * 消息响应
	 */
	public function responseMsg() {
		// get post data, May be due to the different environments
		//$postStr = $GLOBALS ["HTTP_RAW_POST_DATA"]; // 接收post内容
		$postStr = file_get_contents("php://input"); // 接收post内容
		$this->log("msg:\n$postStr");
	
		// extract post data
		if (! empty ( $postStr )) {
			/*
			 * libxml_disable_entity_loader is to prevent XML eXternal Entity Injection, the best way is to check the validity of xml by yourself
			 */
			libxml_disable_entity_loader ( true );
			$postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			// $keyword = trim ( $postObj->Content );
			$msgType = trim ( $postObj->MsgType );
			$time = time ();
				
			$this->log('message by: '.$fromUsername.' to '.$toUsername);
				
			if (! empty ( $msgType )) {
				if ($msgType == 'event') { // 事件
					$event = $postObj->Event;
					if ($event == 'subscribe') { // 关注
						$this->log("subscribe");
						$textTpl = "<xml>
						<ToUserName><![CDATA[$fromUsername]]></ToUserName>
						<FromUserName><![CDATA[$toUsername]]></FromUserName>
						<CreateTime>$time</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[欢迎来到幸福享印智拍馆]]></Content>
						</xml>";
						$msgType = "text";
						$contentStr = "";
						$resultStr = sprintf ( $textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr );
						echo $resultStr;
					} else if ($event == 'unsubscribe') { // 取消关注
						$this->log("unsubscribe");
					}
				} else if ($msgType == 'text') {
					$content = $postObj->Content;
					$this->chat ( $fromUsername, $toUsername, $time, $content );
				}
			} else {
				echo "InputSomething...";
			}
		} else {
			echo "";
			exit ();
		}
	}

	function log($logContent) {
		$logUtil = LogUtil::getinstance ();
		$logUtil->printlnLog($logContent);
	}
	
	/**
	 * 闲聊
	 *
	 * @param unknown $fromUsername
	 * @param unknown $toUsername
	 * @param unknown $time
	 * @param unknown $content
	 */
	function chat($fromUsername, $toUsername, $time, $content) {
		$chatResult = 'hello';
	
		$textTpl = "<xml>
		<ToUserName><![CDATA[$fromUsername]]></ToUserName>
		<FromUserName><![CDATA[$toUsername]]></FromUserName>
		<CreateTime>$time</CreateTime>
		<MsgType><![CDATA[text]]></MsgType>
		<Content><![CDATA[$chatResult]]></Content>
		</xml>";
		$msgType = "text";
		$contentStr = "title";
		$resultStr = sprintf ( $textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr );
		//echo $resultStr;
		print $resultStr;
	}

}