<?php
function http_post_json($url, $jsonStr) {
	$ch = curl_init ( $url );
	curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $jsonStr );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
			'Content-Type: application/json',
			'Content-Length: ' . strlen ( $jsonStr ) 
	) );
	
	$result = curl_exec ( $ch );
	echo $result;
}

$jsonStr = '{
    "button": [
        {
            "name": "幸福一",
            "sub_button": [
                {
                    "type": "view",
                    "name": "幸福1",
                    "url": "http://www.xingfuxiangyin.com"
                },
			 	{
                    "type": "view",
                    "name": "幸福2",
                    "url": "http://www.xingfuxiangyin.com/XfxyService/filemanager/qrcode_for_gh_3df911c478ff_258.jpg"
	        	},
                {
                    "type": "view",
                    "name": "幸福3",
                    "url": "http://www.xingfuxiangyin.com"
                }
            ]
        },

        {
            "name": "幸福二",
            "sub_button": [
                {
                    "type": "view",
                    "name": "幸福4",
                    "url": "http://www.xingfuxiangyin.com"
                },
			 	{
                    "type": "view",
                    "name": "幸福5",
                    "url": "http://www.xingfuxiangyin.com/XfxyService/filemanager/qrcode_for_gh_3df911c478ff_258.jpg"
	        	},
                {
                    "type": "view",
                    "name": "幸福6",
                    "url": "http://www.xingfuxiangyin.com"
                }
            ]
        },

        {
            "name": "我的照片",
            "sub_button": [
                {
                    "type": "view",
                    "name": "照片1",
                    "url": "http://www.xingfuxiangyin.com/XfxyService/filemanager/qrcode_for_gh_3df911c478ff_258.jpg"
                },
			 	{
                    "type": "view",
                    "name": "照片2",
                    "url": "http://www.xingfuxiangyin.com/XfxyService/filemanager/f461ff1a96.jpg"
	        	},
                {
                    "type": "scancode_waitmsg",
                    "name": "扫码下单",
                    "key": "bind_device",
                    "sub_button": [ ]
                }
            ]
        }
    ]
}';

// $jsonStr = '{
//     "button": [
//         {
//             "name": "行车服务", 
//             "sub_button": [
//                 {
//                     "type": "view", 
//                     "name": "车辆位置", 
//                     "url": "http://auto.fourtech.me/jdy_service/weuipage/guideGrantAuthorization.php?type=vehicleLocation"
//                 }, 
//                 {
// 		 			"name": "快速导航", 
//             		"type": "location_select", 
//            			"key": "fast_navi"
//                 }, 
//                 {
//                     "type": "view", 
//                     "name": "我要接人", 
//                     "url": "http://auto.fourtech.me/jdy_service/weuipage/guideGrantAuthorization.php?type=shareMap"
//                 }
//             ]
//         },
    
//         {
//                    "type": "view", 
//                    "name": "周边服务", 
//                    "url": "http://auto.fourtech.me/jdy_service/weuipage/guideGrantAuthorization.php?type=aroundPoint"
//         },
        
//         {
//             "name": "我的", 
//             "sub_button": [
// 				{
//                     "type": "scancode_waitmsg", 
//                     "name": "绑定设备", 
//                     "key": "bind_device", 
//                     "sub_button": [ ]
//                 }, 
// 		        {
//                     "type": "view", 
//                     "name": "违章查询", 
//                     "url": "http://m.weizhang8.cn/"
//                 },
// 		 		{
//                     "type": "click", 
//                     "name": "帮助", 
//                     "key": "menu_help"
//                 }
//             ]
//         }
//     ]
// }';

include_once 'utils/AccessTokenUtil.php';
// $accessTokenUtil=new AccessTokenUtil();

//$access_token = file_get_contents ( "http://auto.fourtech.me/jdy_service/getAccessToken.php", false );
// $access_token = $accessTokenUtil->getBaseAccessToken();
$access_token = '10_poeCHaO6fYXRMOm6Nb5VH5fHsg9xqsT9nPcW-FpkN_ld-TvzZpP_-XPOrPMJ9xeToOpu1lu_-k5Rw2Z5dyaJTmZQ42_ZQpnt18cjoBrZrGAGQnRA5cqWJBlf3RuhZ2JV3T1IYXFsZeLV0eqBHBYhAGAVPM';
echo $access_token . "<br>";

$request_create_menu_url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;

http_post_json ( $request_create_menu_url, $jsonStr );

?>