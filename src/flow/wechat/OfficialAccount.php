<?php
/**
 * 
 *
 * @author yuhari
 * @version $Id$
 * @copyright , 21 December, 2017
 * @package default
 */

/**
 * 微信公众号支付
 */
namespace payment\flow\wechat ;

class OfficialAccount extends Base {
	
	//默认mode为 wap_official,继承wechat配置
	protected $mode = 'wap_official' ;
		
}