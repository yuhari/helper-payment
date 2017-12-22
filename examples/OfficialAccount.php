<?php

include "../vendor/autoload.php" ;

$order = new \payment\order\wechat\OfficialAccount() ;
$order->nonce_str = \payment\util\Common::generateNonceString() ;
$order->body = '测试用例' ;
$order->attach = '这是yuhari的一个测试请求' ;
$order->out_trade_no = '1234567890' ;
$order->total_fee = 10 ;
$order->spbill_create_ip = \payment\util\Common::getRealIp() ;
$order->openid = 'user openid' ;

$flow = new \payment\flow\wechat\OfficialAccount('../config') ;
$response = $flow->loadOrder($order)->pay() ;
if ($response->check_response && $response->content) {
	echo '请求成功' ;
	$content = $response->content ;
}