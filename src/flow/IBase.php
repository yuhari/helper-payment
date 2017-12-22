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
 * 支付流程 
 */
namespace payment\flow ;

interface IBase {
	
	//一个实际的行为执行准备
	public function prepare() ;

}
