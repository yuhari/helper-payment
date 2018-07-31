<?php

include "../vendor/autoload.php" ;

function pay() {
	$order = new \payment\order\wechat\WebCode() ;
	$order->product_id = 1 ;
	$order->nonce_str = \payment\util\Common::generateNonceString() ;
	$order->body = '测试用例' ;
	$order->attach = '这是yuhari的一个测试请求' ;
	$order->out_trade_no = '1234567890' ;
	$order->total_fee = 10 ;
	$order->spbill_create_ip = \payment\util\Common::getRealIp() ;
	#$order->openid = 'user openid' ;

	$flow = new \payment\flow\wechat\WebCode('../config') ;
	$response = $flow->loadOrder($order)->pay() ;
	if ($response->check_response && $response->content) {
		echo '请求成功' ;
		var_dump($response->content) ;
		$content = $response->content ;
	}
}

function close() {
	$order = new \payment\order\wechat\WebCode('close') ;
	$order->out_trade_no = '1234567890' ;
	$order->nonce_str = \payment\util\Common::generateNonceString() ;
	$flow = new \payment\flow\wechat\WebCode('../config') ;
	$response = $flow->loadOrder($order)->close() ;
	if ($response->check_response && $response->content) {
		var_dump($response->content) ;
	}
}

close() ;
