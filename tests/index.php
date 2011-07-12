<?php

require_once( 'simpletest/autorun.php' );
require_once( 'simpletest/web_tester.php' );

define( 'PHP_MERCHANT_PATH', realpath( '../' ) );
define( 'PHP_MERCHANT_TEST_PATH', dirname( __FILE__ ) );

class PHP_Merchant_Test_Suite extends TestSuite
{
	function __construct() {
		parent::__construct( 'PHP Merchant Test Suite' );
		$tests = array(
			'common/php-merchant',
			'common/http-curl',
			'gateways/paypal',
			'gateways/paypal-express-checkout',
		);

		if ( ! empty( $_GET['remote'] ) ) {
			$tests[] = 'remote/http-curl';
		}
		
		$dir = dirname( __FILE__ );
		
		foreach ( $tests as $test ) {
			$this->addFile( $dir . '/' . $test . '.php' );
		}
	}
}