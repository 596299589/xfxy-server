<?php
class AccessTokenUtil {
	
	function __construct() {
	}
	
	public function getBaseAccessToken() {
// 		$result = $this->selectBaseAccessToken ();
		
// 		if ($result == null) {
			return $token = $this->get_access_token ();
// 		} else {
// 			return $result;
// 		}
	}
	
	private function get_access_token() {
		// $request_access_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx98e0c35e7e056459&secret=7120e90481b3668a267b22684ccbdfd2';
		// $request_result = file_get_contents ( $request_access_token_url );
// 		include_once '../weuipage/jssdk.php';
// 		$jssdk = new JSSDK ();
// 		$appId=$jssdk->getAppId();
// 		$appSecret=$jssdk->getAppSecret();
		$appId='wxaea0cd3bfddc4647';
		$appSecret='5749b19362e7e94cbfeeb84b273b3651';
		
		
// 		return $appId.'  '.$appSecret;
		
		$request_access_token_url = 'https://api.weixin.qq.com/cgi-bin/token';
		
		$opts = array (
				'http' => 

				array (
						
						'method' => 'POST',
						
						'header' => 'Content-type: application/x-www-form-urlencoded',
						
						'content' => 'grant_type=client_credential&appid='.$appId.'&secret='.$appSecret 
						//'content' => 'grant_type=client_credential&appid=wx98e0c35e7e056459&secret=7120e90481b3668a267b22684ccbdfd2'
				) 
		);
		$context = stream_context_create ( $opts );
		$request_result = file_get_contents ( $request_access_token_url, false, $context );
		
		$token_info = json_decode ( $request_result );
		$access_token = $token_info->access_token;
		$expires_in = $token_info->expires_in;
		
		$expires_in = $expires_in + time ();
		// echo $access_token . '</br>' . $expires_in;
// 		$this->saveBaseAccessToken ( $access_token, $expires_in );
		return $access_token;
	}
	private function selectBaseAccessToken() {
		$mysql_server_name = 'localhost';
		$mysql_username = 'root';
		$mysql_password = '4tech.mysql.root';
		$mysql_database = 'jdy_service';
		$table_name = 'global_variable';
		$bat = "base_access_token";
		
		$conn = mysql_connect ( $mysql_server_name, $mysql_username, $mysql_password ) or die ( "error connecting" );
		mysql_query ( "set names utf8" );
		mysql_query ( "set character_set_client=utf8" );
		mysql_query ( "set character_set_results=utf8" );
		mysql_select_db ( $mysql_database );
		
		$sql = "SELECT * FROM `global_variable` WHERE `global_variable_name`='$bat';";
		$result = mysql_query ( $sql, $conn );
		
		$token = null;
		$expir = 0;
		if (mysql_num_rows ( $result )) {
			$rs = mysql_fetch_array ( $result );
			$token = $rs ['global_variable_value'];
			$expir = $rs ['expires_in'];
		}
		
		mysql_close ( $conn );
		
		if ($expir != 0 && $expir > time () && ! empty ( $token )) {
			return $token;
		} else {
			return null;
		}
	}
	private function saveBaseAccessToken($token, $expir) {
		$mysql_server_name = 'localhost';
		$mysql_username = 'root';
		$mysql_password = '4tech.mysql.root';
		$mysql_database = 'jdy_service';
		$table_name = 'global_variable';
		$bat = "base_access_token";
		
		$conn = mysql_connect ( $mysql_server_name, $mysql_username, $mysql_password ) or die ( "error connecting" );
		mysql_query ( "set names utf8" );
		mysql_query ( "set character_set_client=utf8" );
		mysql_query ( "set character_set_results=utf8" );
		mysql_select_db ( $mysql_database );
		
		$sql = "SELECT COUNT(*) FROM `global_variable` WHERE `global_variable_name`='$bat';";
		$result = mysql_query ( $sql, $conn );
		$count = 0;
		
		if (mysql_num_rows ( $result )) {
			$rs = mysql_fetch_array ( $result );
			$count = $rs [0];
		}
		
		if ($count > 0) {
			$sql = "UPDATE `global_variable` SET `global_variable_value`='$token',`expires_in`='$expir' WHERE `global_variable_name`='$bat';";
			$result = mysql_query ( $sql, $conn );
		} else {
			$sql = "INSERT INTO $table_name(`global_variable_name`,`global_variable_value`,`expires_in`) VALUES ('$bat','$token','$expir');";
			$result = mysql_query ( $sql, $conn );
		}
		
		mysql_close ( $conn );
		// return true;
	}
}
