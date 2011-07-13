<?php

require_once( PHP_MERCHANT_PATH . '/gateways/paypal-express-checkout.php' );

class PHP_Merchant_Paypal_Express_Checkout_Remote_Test extends WebTestCase
{
	public function __construct() {
		parent::__construct( 'PHP_Merchant_Paypal_Express_Checkout Remote Unit Tests' );
	}
	
	public function test_successful_set_express_checkout_request() {
		global $test_accounts;
		$gateway = new PHP_Merchant_Paypal_Express_Checkout( $test_accounts['paypal-express-checkout'] );
		
		$purchase_options = array(
			// API info
			'return_url'        => 'http://example.com/return',
			'cancel_url'        => 'http://example.com/cancel',
			'address_override'  => true,

			// Shipping details
			'shipping_address' => array(
				'name'    => 'Gary Cao',
				'street'  => '1 Infinite Loop',
				'street2' => 'Apple Headquarter',
				'city'    => 'Cupertino',
				'state'   => 'CA',
				'country' => 'US',
				'zip'     => '95014',
				'phone'   => '(877) 412-7753',
			),

			// Payment info
			'currency'    => 'JPY',
			'subtotal'    => 13700,
			'shipping'    => 1500,
			'tax'         => 137,
			'description' => 'Order for example.com',
			'invoice'     => 'E84A90G94',
			'notify_url'  => 'http://example.com/ipn',

			// Items
			'items' => array(
				array(
					'name'        => 'Gold Cart Plugin',
					'description' => 'Gold Cart extends your WP e-Commerce store by enabling additional features and functionality.',
					'amount'      => 4000,
					'quantity'    => 1,
					'tax'         => 40,
					'url'         => 'http://getshopped.org/extend/premium-upgrades/premium-upgrades/gold-cart-plugin/',
				),
				array(
					'name'        => 'Member Access Plugin',
					'description' => 'Create pay to view subscription sites',
					'amount'      => 5000,
					'quantity'    => 1,
					'tax'         => 50,
					'url'         => 'http://getshopped.org/extend/premium-upgrades/premium-upgrades/member-access-plugin/',
				),
				array(
					'name'        => 'Amazon S3',
					'description' => 'This Plugin allows downloadable products on your WP e-Commerce site to be hosted on Amazon S3.',
					'amount'      => 4700,
					'quantity'    => 1,
					'tax'         => 47,
					'url'         => 'http://getshopped.org/extend/premium-upgrades/premium-upgrades/amazon-s3-plugin/',
				),
			),
		);
		
		$response = $gateway->setup_purchase( 15337, $purchase_options );
		
		$this->assertTrue( $response->is_successful() );
		$this->assertFalse( $response->has_errors() );
	}
}