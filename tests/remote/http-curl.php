<?php

require_once( PHP_MERCHANT_PATH . '/common/http-curl.php' );

class PHP_Merchant_HTTP_CURL_Remote_Test extends WebTestCase
{
	public function __construct() {
		parent::__construct( 'PHP_Merchant_HTTP_CURL Remote Unit Tests' );
	}
	
	public function test_http_curl_get_request_returns_correct_response() {
		$expected_content = $this->get( 'http://google.com' );
		
		$http = new PHP_Merchant_HTTP_CURL();
		$actual_content = $http->get( 'http://google.com' );
	}
}