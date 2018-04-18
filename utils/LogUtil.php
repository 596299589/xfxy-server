<?php
// header ( "Content-type: text/html; charset=utf-8" );

// 定义log文件路径
define ( "LOG_PATH", "/root/home/www/XfxyService/mylog.txt" );
class LogUtil {
	private $name; // 声明一个私有的实例变量
	private function __construct() { // 声明私有构造方法为了防止外部代码使用new来创建对象。
	}
	public static $instance; // 声明一个静态变量（保存在类中唯一的一个实例）
	static public function getinstance() { // 声明一个getinstance()静态方法，用于检测是否有实例对象
		if (! self::$instance)
			self::$instance = new self ();
		return self::$instance;
	}
	public function printlnLog($logContent) {
		file_put_contents ( LOG_PATH, $logContent, FILE_APPEND );
	}
}

/**
 * ******************
 * 1、写入内容到文件,追加内容到文件
 * 2、打开并读取文件内容
 * *******************
 */
// $file = 'log.txt'; // 要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
// $content = "第一次写入的内容\n";

// if ($f = file_put_contents ( $file, $content, FILE_APPEND )) { // 这个函数支持版本(PHP 5)
// echo "写入成功。<br />";
// }
// $content = "第二次写入的内容";
// if ($f = file_put_contents ( $file, $content, FILE_APPEND )) { // 这个函数支持版本(PHP 5)
// echo "写入成功。<br />";
// }
// if ($data = file_get_contents ( $file )) { // 这个函数支持版本(PHP 4 >= 4.3.0, PHP 5)
// echo "写入文件的内容是：$data";
// }
?>