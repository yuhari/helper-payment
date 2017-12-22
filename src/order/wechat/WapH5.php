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
 * wap H5订单
 */
namespace payment\order\wechat ;

class WapH5 extends Base {
	
	//h5, MWeb
	protected static $trade_type = 'MWEB' ;
	
	protected $constrains = array() ;
	
	protected function getConstrains() {
		return array_merge_recursive(parent::getConstrains(), $this->constrains) ;
	}
}
