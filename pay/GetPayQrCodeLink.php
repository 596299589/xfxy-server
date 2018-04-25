<?php
/* 支付二维码链接生成 */
include_once '../utils/RandomString.php';

$getPayQrCodeLink = new GetPayQrCodeLink ();
$getPayQrCodeLink->getPayQrCodeLink ();
class GetPayQrCodeLink {
	
	function __construct() {
	}
	
	public function getPayQrCodeLink() {
		$appid = "XXX"; // 公众号appid
		$mch_id = "XXX"; // 微信支付商户号
		$key = "XXX"; //api密钥
		$randomString = new RandomString ();
		$nonce_str = $randomString->createString ( 16 );
		
		$time_stamp = time();
		
		$stringA = "weixin：//wxpay/bizpayurl?appid=$appid&mch_id=$mch_id&nonce_str=$nonce_str&product_id=1&time_stamp=$time_stamp";
		$stringB = $stringA."&key=$key";
		$sign = strtoupper(md5($stringB));
		
		$qrcodeUrl = "weixin：//wxpay/bizpayurl?appid=$appid&mch_id=$mch_id&nonce_str=$nonce_str&product_id=1&time_stamp=$time_stamp&sign=$sign";
		
		echo $qrcodeUrl;
	}
	
}

?>






