<?php
/**
 * 
 *
 * @author yuhari
 * @version $Id$
 * @copyright , 22 December, 2017
 * @package default
 */

/**
 * 支付流程中通用的一些方法，比如签名生成，随机字符串之类
 */
namespace payment\util ;

use payment\exception\UnknownException ;

class Common {
	
	/**
	 * url signature generate
	 *
	 * @return string
	 */
	public static function generateSign($params, $sign_method = 'MD5',$sign_word = 'sign', $salt_word = 'key') {
		$t = $params ;
		ksort($t) ;
		$a = array() ;
		array_walk($t , function($v, $k) use(&$a, $sign_word, $salt_word){
			if ($v && $k != $sign_word && $k != $salt_word) {
				$a[] = sprintf("%s=%s", $k , $v) ;
			}
		}) ;
		
		$s = implode('&', $a) ;
		if ($salt_word) {
			$s .= sprintf("&%s=%s", $salt_word, $t[$salt_word]) ;
		}

		if ($sign_method == 'HMAC-SHA256') {
			$s = hash_hmac('sha256', $s, $t[$salt_word]) ;
		}elseif ($sign_method == 'MD5') {
			$s = md5($s) ;
		}else{
			throw UnknownException::factory("sign method $sign_method not support.") ;
		}
		
		return $s ;
	}
	
	/**
	 * 生成一个随机字符串
	 *
	 * @return string
	 */
	public static function generateNonceString($salt = 'nonce_str'){
		return md5(rand(0, 9999) . $salt) ;
	}
	
	/**
	 * 获取客户端ip
	 *
	 * @return string
	 */
	public static function getRealIp() {
		$ip = '' ;
		if (!empty($_SERVER['REMOTE_ADDR'])){
			$ip = $_SERVER['REMOTE_ADDR'] ;
		}elseif(@getenv('REMOTE_ADDR')){
			$ip = getenv('REMOTE_ADDR') ;
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ;
		}
		
		return $ip ;
	}
}
