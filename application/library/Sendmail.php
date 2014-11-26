<?php
/*
 * 邮件发送类
 * Sendmail::send($html, $email,$subject)
 */
final class Sendmail {
		/*private static $smtp = 'smtp.163.com'; //smtp服务器,如smtp.163.com
		private static $port = '25'; //端口,一般为25
		private static $user = ''; //你的邮件账号,如admin@163.com
		private static $pwd = ''; //账号对应的密码*/
		private static $user = '';
		private static $connection;
		
		private function __construct(){}

		// 连接smtp服务器并验证账号信息
		private static function connect(){
			$config = new Yaf_Config_Ini(APP_PATH . '/conf/application.ini');
			$mailConfig = $config->get('app')->mail;
			self::$user = $mailConfig->user;
			self::$connection = $connection = fsockopen($mailConfig->smtp, $mailConfig->port);
			if($connection){
				fgets($connection); //必须要获取一次，否则下次读取的是上一次的值
				self::write('HELO ' . $mailConfig->smtp . "\r\n", 250);
				self::write("auth login \r\n", 334);
				self::write(base64_encode($mailConfig->user) . "\r\n", 334);
				self::write(base64_encode($mailConfig->pwd) . "\r\n", 235);
			}else{
				exit('请检查邮件类成员属性是否正确');
			}

		}

		/*
		 * 发送邮件
		 * @param $html string 发送的内容
		 * @param $email string 对方邮箱地址
		 * @param $subject string 邮件主题
		 */
		public static function send($html, $email, $subject=''){
			if($html==null || $email==null) return null;
			self::connect();
			self::write('MAIL FROM: <' . self::$user . '>' . "\r\n", 250);
			self::write('RCPT TO: <' . $email . '>' . "\r\n", 250);
			self::write("DATA\r\n");
			self::write("From: " . self::$user . "\r\n");
			self::write("To: " . $email . "\r\n");
			if($subject) self::write("Subject: " . $subject . "\r\n");
			self::write("Content-type:text/html; charset=utf-8\r\n");
			self::write("\r\n" . $html . "\r\n.\r\n", 354);
			self::write("QUIT\r\n");
			unset($html);
			fclose(self::$connection);
		}

		/*
		 * 判断每一次发送的命令是否执行成功
		 * @param $msg string 具体发送的命令
		 * @param $responseCode int 判断命令是否执行成功的返回值
		 * @return string 出错的命令以及命令返回的值,命令执行成功没有返回值
		 */
		private static function write($msg, $responseCode=null){
			fputs(self::$connection, $msg);
			if($responseCode){
				$getResponse = fgets(self::$connection);
				if($responseCode!=intval($getResponse)){
					echo $msg;
					exit($getResponse);
				}
			}
		}

}