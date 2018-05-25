<?php
header("Content-Type: text/html; charset=utf-8");

require_once "jssdk.php";
$jssdk = new JSSDK ();
$appId = $jssdk->getAppId ();
$appSecret = $jssdk->getAppSecret ();
$signPackage = $jssdk->getSignPackage ();

require_once '../utils/OpenidUtil.php';
$openidUtil = new OpenidUtil ();

$code = $_REQUEST ['code'];
$request_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $appSecret . "&code=" . $code . "&grant_type=authorization_code";
$result = file_get_contents ( $request_url, false );
// echo "resutlt:".$result."<br>";
$token_info = json_decode ( $result, true );
$access_token = $token_info ['access_token'];
$expires_in = $token_info ['expires_in'];
$openid = $token_info ['openid'];
$scope = $token_info ['scope'];

$isSuccess = - 1;
if (! empty ( $openid )) {
	
	$cname = $openidUtil->getDeviceInfoByOpenid ( $openid );
	
	if ($cname != null) {
		// echo '请求结果:成功';
		
		$linkInfo = json_decode ( file_get_contents ( "http://auto.fourtech.me/jdy_service/datapush/check.php?cname=$cname", false ), true );
		$isLink = $linkInfo [$cname];
		if ($isLink) { // 成功
			$isSuccess = 0;
		} else { // 设备未连接
			$isSuccess = 1;
		}
	} else { // 未绑定设备
	         // echo '您还未绑定任何设备，请先绑定设备';
		$isSuccess = 2;
	}
} else {
	echo "<script>alert('请求失败');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
	content="width=device-width,initial-scale=1,user-scalable=0">
<title></title>
<link rel="stylesheet" href="weui/dist/style/weui.min.css" />
</head>
<body>
	<img id="divshare" align="middle" alt="引导"
		style="display: none; height: 100%; width: 100%;"
		src="../image/guide_share.png">

	<div id="divbind" align="left" style="display: none; font-size: 22px">
		<h4>您还未绑定设备，请绑定设备后重试</h4>
	</div>
	<div id="divunlink" align="left" style="display: none; font-size: 22px">
		<h4>设备未连接,请连接后重试</h4>
	</div>
	<div id="sharesuccess" style="display: none;">
		<div class="weui_mask_transparent"></div>
		<div class="weui_toast">
			<i class="weui_icon_toast"></i>
			<p class="weui_toast_content">您已分享成功</p>
		</div>
	</div>
	<div id="sharecancle" style="display: none;">
		<div class="weui_mask_transparent"></div>
		<div class="weui_toast">
			<i class="weui_icon_toast"></i>
			<p class="weui_toast_content">您已取消分享</p>
		</div>
	</div>


	<div id="loadingToast" class="weui_loading_toast"
		style="display: block;">
		<div class="weui_mask_transparent"></div>
		<div class="weui_toast">
			<div class="weui_loading">
				<!-- :) -->
				<div class="weui_loading_leaf weui_loading_leaf_0"></div>
				<div class="weui_loading_leaf weui_loading_leaf_1"></div>
				<div class="weui_loading_leaf weui_loading_leaf_2"></div>
				<div class="weui_loading_leaf weui_loading_leaf_3"></div>
				<div class="weui_loading_leaf weui_loading_leaf_4"></div>
				<div class="weui_loading_leaf weui_loading_leaf_5"></div>
				<div class="weui_loading_leaf weui_loading_leaf_6"></div>
				<div class="weui_loading_leaf weui_loading_leaf_7"></div>
				<div class="weui_loading_leaf weui_loading_leaf_8"></div>
				<div class="weui_loading_leaf weui_loading_leaf_9"></div>
				<div class="weui_loading_leaf weui_loading_leaf_10"></div>
				<div class="weui_loading_leaf weui_loading_leaf_11"></div>
			</div>
			<p class="weui_toast_content">数据加载中</p>
		</div>
	</div>

</body>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      "getLocation",
      "hideOptionMenu",
      "showOptionMenu",
      "onMenuShareAppMessage",
      "showMenuItems",
      "hideMenuItems",
      "hideAllNonBaseMenuItem",
      "closeWindow"
    ]
  });
  wx.ready(function () {
	  var isSuccess='<?php echo $isSuccess;?>';
	  var loadingToast=document.getElementById("loadingToast");
	  loadingToast.style.display='none';
	  
	  if(isSuccess == 0){
			 var divshare=document.getElementById("divshare");
			 divshare.style.display='block';
			 wx.showOptionMenu();
		} else if(isSuccess == 1){
			 var divunlink=document.getElementById("divunlink");
			 divunlink.style.display='block';
			 wx.hideOptionMenu();
		} else {
			var divbind=document.getElementById("divbind");
			 divbind.style.display='block';
			 wx.hideOptionMenu();
		}


	  // 在这里调用 API
	  //wx.hideOptionMenu();
	  //wx.showOptionMenu();

	  wx.hideAllNonBaseMenuItem();//隐藏所有非基础菜单
	  wx.showMenuItems({
		    menuList: ["menuItem:share:appMessage"] // 要显示的菜单项
		});
	  
	  wx.onMenuShareAppMessage({
		    title: '我来接你啦', // 分享标题
		    desc: '点击这里，选择好你当前所在的位置并通知我去接你哦(页面5分钟后过期)', // 分享描述
		    link: 'http://auto.fourtech.me/jdy_service/location/selectPlace.php?fromUser='+'<?php echo $openid; ?>&time=<?php echo time();?>', // 分享链接
		    imgUrl: 'http://auto.fourtech.me/img/qrcode.jpg', // 分享图标
		    type: 'link', // 分享类型,music、video或link，不填默认为link
		    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		    success: function () {
		        // 用户确认分享后执行的回调函数
		    	wx.closeWindow();
		    },
		    cancel: function () {
		        // 用户取消分享后执行的回调函数
		    	//alert("您已取消分享");
		    	 var sharecancle=document.getElementById("sharecancle");
		    	 sharecancle.style.display='block';

		    	 function hide(){
		    		sharecancle.style.display='none';
		    		wx.closeWindow();
		    	}
			    	
		    	window.setTimeout(hide,1000);
		    }
		});
		
	  wx.error(function(res){
		    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
		    alert('request fail');
		});
	    
  });
</script>
</html>
