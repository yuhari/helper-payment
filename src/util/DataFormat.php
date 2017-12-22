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
 * 数据格式处理的相关方法
 */
namespace payment\util ;

use payment\exception\UnknownException ;

class DataFormat {
	
	/**
	 * hash数组转为xml文档
	 *
	 * @return xmlDocment
	 */
	public static function array2xml($array) {
		$xml = "<xml>" ;
		foreach($array as $key => $val) {
			if (is_numeric($val)) {
				$xml .= sprintf("<%s>%s</%s>" , $key, $val, $key) ;
			} else {
				$xml .= sprintf("<%s><![CDATA[%s]]></%s>", $key, $val, $key) ;
			}
		}
		
		$xml .= "</xml>" ;
		return $xml ;
	}
	
	/**
	 * xml转hash数组
	 *
	 * @return array
	 */
	public static function xml2array($xml, $encode='gbk') {
        if (preg_match("/(^<\?xml[^\?]+\?>)/", $xml, $matches)){
	        $xml_head = $matches[1];
	        $xml_head = preg_replace("/(?:GB2312|utf-8)/", "GBK", $xml_head);
	        $xml = preg_replace("/(^<\?xml[^\?]+\?>)/", $xml_head, $xml);
        }
		
		if (strtolower($encode) != 'gbk') {
            $xml = iconv($encode, $encode . '//IGNORE', $xml);
		}
		
        //过滤W3C XML规范外的字符
        $xml = str_replace(
            array("\x00", "\x01", "\x02", "\x03", "\x04", "\x05", "\x06", "\x07", "\x08", "\x0b", "\x0c", "\x0e", "\x0f", "\x10", "\x11", "\x12", "\x13", "\x14", "\x15", "\x16", "\x17", "\x18", "\x19", "\x1a", "\x1b", "\x1c", "\x1d", "\x1e", "\x1f" ),
			 "", $xml);
		
		if (($xmlobj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)) === false) {
			//throw UnknownException::factory("xml cant't parse.") ;
			return false ;
		}
		
		$r = json_encode($xmlobj) ;
		$r = json_decode($r, true) ; //to array
		
		return $r ;
	}
	
	/**
	 * array to json
	 *
	 * @return json string
	 */
	public static function array2json($array, $encode = 'utf-8') {
		if (strtolower($encode) != 'utf-8') {
			$array = static::iconv($encode, 'utf-8//IGNORE', $array) ;
		}
		return json_encode($array) ;
	}
	
	/**
	 * json to array
	 *
	 * @return array
	 */
	public static function json2array($json) {
		return @(array)json_decode($json, true) ;
	}
	
	/**
	 * 递归iconv
	 *
	 * @return mixed
	 */
	public static function iconv($in_charset, $out_charset , $data) {
		if (is_array($data)) {
			foreach($data as $k => $v) {
				$data[self::iconv($in_charset, $out_charset, $k)] = self::iconv($in_charset, $out_charset, $v) ;
			}
		}else {
			if (is_string($data)) {
				$data = iconv($in_charset , $out_charset, $data) ;
			}
		}
		return $data ;
	} 
}
