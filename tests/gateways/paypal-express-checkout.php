<?php

require_once( PHP_MERCHANT_PATH . '/gateways/paypal-express-checkout.php' );

class PHP_Merchant_Paypal_Express_Checkout_Test extends UnitTestCase
{
	private $bogus;
	private $options;
	private $amount;
	private $token;
	
	public function __construct() {
		parent::__construct( 'PHP_Merchant_Paypal_Express_Checkout test cases' );
		$this->amount = 15337;
		$this->token = 'EC-6L77249383950130E';
		// options to pass to the merchant class
		$this->setup_purchase_options = array(
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
				'country' => 'USA',
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
					'description' => 'Gold Cart extends your WP e-Commerce store by enabling additional features and functionality, including views, galleries, store search and payment gateways.',
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
					'description' => 'This Plugin allows downloadable products that you have for sale on your WP e-Commerce site to be hosted within Amazon S3.',
					'amount'      => 4700,
					'quantity'    => 1,
					'tax'         => 47,
					'url'         => 'http://getshopped.org/extend/premium-upgrades/premium-upgrades/amazon-s3-plugin/',
				),
			),
		);
	}
	
	public function setUp() {
		$this->bogus = new PHP_Merchant_Paypal_Express_Checkout_Bogus( array(
			'api_username'      => 'sdk-three_api1.sdk.com',
			'api_password'      => 'QFZCWN5HZM8VBG7Q',
			'api_signature'     => 'A-IzJhZZjhg29XQ2qnhapuwxIDzyAZQ92FRP5dqBzVesOkzbdUONzmOU',
		) );
	}
	
	public function tearDown() {
		
	}
	
	public function test_correct_parameters_are_sent_to_paypal_when_set_express_checkout() {		
		// set up expectations for mock objects
		$url = 'https://api-3t.paypal.com/nvp';
		
		// how the request parameters should look like
		$args = array(
			// API info
			'USER'         => 'sdk-three_api1.sdk.com',
			'PWD'          => 'QFZCWN5HZM8VBG7Q',
			'VERSION'      => '74.0',
			'SIGNATURE'    => 'A-IzJhZZjhg29XQ2qnhapuwxIDzyAZQ92FRP5dqBzVesOkzbdUONzmOU',
			'METHOD'       => 'SetExpressCheckout',
 			'RETURNURL'    => 'http://example.com/return',
			'CANCELURL'    => 'http://example.com/cancel',
			'ADDROVERRIDE' => 1,
			
			// Shipping details
			'PAYMENTREQUEST_0_SHIPTONAME'        => 'Gary Cao',
			'PAYMENTREQUEST_0_SHIPTOSTREET'      => '1 Infinite Loop',
			'PAYMENTREQUEST_0_SHIPTOSTREET2'     => 'Apple Headquarter',
			'PAYMENTREQUEST_0_SHIPTOCITY'        => 'Cupertino',
			'PAYMENTREQUEST_0_SHIPTOSTATE'       => 'CA',
			'PAYMENTREQUEST_0_SHIPTOZIP'         => '95014',
			'PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE' => 'USA',
			'PAYMENTREQUEST_0_SHIPTOPHONENUM'    => '(877) 412-7753',
			
			// Payment info
			'PAYMENTREQUEST_0_AMT'           => '15,337',
			'PAYMENTREQUEST_0_CURRENCYCODE'  => 'JPY',
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
			'PAYMENTREQUEST_0_ITEMAMT'       => '13,700',
			'PAYMENTREQUEST_0_SHIPPINGAMT'   => '1,500',
			'PAYMENTREQUEST_0_TAXAMT'        => '137',
			'PAYMENTREQUEST_0_DESC'          => 'Order for example.com',
			'PAYMENTREQUEST_0_INVNUM'        => 'E84A90G94',
			'PAYMENTREQUEST_0_NOTIFYURL'     => 'http://example.com/ipn',
			
			// Items
			'L_PAYMENTREQUEST_0_NAME0'    => 'Gold Cart Plugin',
			'L_PAYMENTREQUEST_0_AMT0'     => '4,000',
			'L_PAYMENTREQUEST_0_QTY0'     => 1,
			'L_PAYMENTREQUEST_0_DESC0'    => 'Gold Cart extends your WP e-Commerce store by enabling additional features and functionality, including views, galleries, store search and payment gateways.',
			'L_PAYMENTREQUEST_0_TAXAMT0'  => '40',
			'L_PAYMENTREQUEST_0_ITEMURL0' => 'http://getshopped.org/extend/premium-upgrades/premium-upgrades/gold-cart-plugin/',
			
			'L_PAYMENTREQUEST_0_NAME1'    => 'Member Access Plugin',
			'L_PAYMENTREQUEST_0_AMT1'     => '5,000',
			'L_PAYMENTREQUEST_0_QTY1'     => 1,
			'L_PAYMENTREQUEST_0_DESC1'    => 'Create pay to view subscription sites',
			'L_PAYMENTREQUEST_0_TAXAMT1'  => '50',
			'L_PAYMENTREQUEST_0_ITEMURL1' => 'http://getshopped.org/extend/premium-upgrades/premium-upgrades/member-access-plugin/',
			
			'L_PAYMENTREQUEST_0_NAME2'    => 'Amazon S3',
			'L_PAYMENTREQUEST_0_AMT2'     => '4,700',
			'L_PAYMENTREQUEST_0_QTY2'     => 1,
			'L_PAYMENTREQUEST_0_DESC2'    => 'This Plugin allows downloadable products that you have for sale on your WP e-Commerce site to be hosted within Amazon S3.',
			'L_PAYMENTREQUEST_0_TAXAMT2'  => '47',
			'L_PAYMENTREQUEST_0_ITEMURL2' => 'http://getshopped.org/extend/premium-upgrades/premium-upgrades/amazon-s3-plugin/',
		);
		
		$this->bogus->http->expectOnce( 'post', array( $url, $args ) );
		$this->bogus->setup_purchase( $this->amount, $this->setup_purchase_options );
	}
	
	public function test_correct_parameters_are_sent_when_get_express_checkout_details() {
		$url = 'https://api-3t.paypal.com/nvp';
		$args = array(
			// API info
			'USER'      => 'sdk-three_api1.sdk.com',
			'PWD'       => 'QFZCWN5HZM8VBG7Q',
			'VERSION'   => '74.0',
			'SIGNATURE' => 'A-IzJhZZjhg29XQ2qnhapuwxIDzyAZQ92FRP5dqBzVesOkzbdUONzmOU',
			'METHOD'    => 'GetExpressCheckoutDetails',
			'TOKEN'     => $this->token,
		);
		
		$this->bogus->http->expectOnce( 'post', array( $url, $args ) );
		$this->bogus->get_details_for( $this->token );
	}
	
	public function test_correct_response_is_returned_when_set_express_checkout_is_successful() {
		$mock_response = 'ACK=Success&CORRELATIONID=224f0e4a32d14&TIMESTAMP=2011%2d07%2d05T13%253A23%253A52Z&VERSION=2%2e30000&BUILD=1%2e0006&TOKEN=EC%2d1OIN4UJGFOK54YFV';
		$this->bogus->http->returnsByValue( 'post', $mock_response );
		$response = $this->bogus->setup_purchase( $this->amount, $this->setup_purchase_options );
		
		$this->assertTrue( $response->is_successful() );
		$this->assertFalse( $response->has_errors() );
		$this->assertEqual( $response->get( 'token'          ), 'EC-1OIN4UJGFOK54YFV'  );
		$this->assertEqual( $response->get( 'timestamp'      ), 1309872232             );
		$this->assertEqual( $response->get( 'datetime'       ), '2011-07-05T13:23:52Z' );
		$this->assertEqual( $response->get( 'correlation_id' ), '224f0e4a32d14'        );
		$this->assertEqual( $response->get( 'version'        ), '2.30000'              );
		$this->assertEqual( $response->get( 'build'          ), '1.0006'               );
	}
	
	public function test_correct_response_is_returned_when_get_express_checkout_details_is_successful() {
		$mock_response = 'ACK=Success&CORRELATIONID=224f0e4a32d14&TIMESTAMP=2011%2d07%2d05T13%253A23%253A52Z&VERSION=2%2e30000&BUILD=1%2e0006&TOKEN=EC%2d1OIN4UJGFOK54YFV'.
		                 '&PAYERID=U6ES54SO380WI'.
		
		                 // Shipping details
		                 '&PAYMENTREQUEST_0_SHIPTONAME=Gary%20Cao'.
		                 '&PAYMENTREQUEST_0_SHIPTOSTREET=1%20Infinite%20Loop'.
		                 '&PAYMENTREQUEST_0_SHIPTOSTREET2=Apple%20Headquarter'.
		                 '&PAYMENTREQUEST_0_SHIPTOCITY=Cupertino'.
		                 '&PAYMENTREQUEST_0_SHIPTOSTATE=CA'.
		                 '&PAYMENTREQUEST_0_SHIPTOZIP=95014'.
		                 '&PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE=USA'.
		                 '&PAYMENTREQUEST_0_SHIPTOPHONENUM=%28877%29%20412-7753'.
		                 '&PAYMENTREQUEST_0_ADDRESSSTATUS=Confirmed'.
						
		                 // Payment info
		                 '&PAYMENTREQUEST_0_AMT=15%2C337'.
		                 '&PAYMENTREQUEST_0_CURRENCYCODE=JPY'.
		                 '&PAYMENTREQUEST_0_PAYMENTACTION=Sale'.
		                 '&PAYMENTREQUEST_0_ITEMAMT=13%2C700'.
		                 '&PAYMENTREQUEST_0_SHIPPINGAMT=1%2C500'.
		                 '&PAYMENTREQUEST_0_TAXAMT=137'.
		                 '&PAYMENTREQUEST_0_DESC=Order%20for%20example.com'.
		                 '&PAYMENTREQUEST_0_INVNUM=E84A90G94'.
		                 '&PAYMENTREQUEST_0_NOTIFYURL=http%3A%2F%2Fexample.com%2Fipn'.

		                 // Items
		                 '&L_PAYMENTREQUEST_0_NAME0=Gold%20Cart%20Plugin'.
		                 '&L_PAYMENTREQUEST_0_AMT0=4%2C000'.
		                 '&L_PAYMENTREQUEST_0_QTY0=1'.
		                 '&L_PAYMENTREQUEST_0_DESC0=Gold%20Cart%20extends%20your%20WP%20e-Commerce%20store%20by%20enabling%20additional%20features%20and%20functionality%2C%20including%20views%2C%20galleries%2C%20store%20search%20and%20payment%20gateways.'.
		                 '&L_PAYMENTREQUEST_0_TAXAMT0=40'.
		                 '&L_PAYMENTREQUEST_0_ITEMURL0=http%3A%2F%2Fgetshopped.org%2Fextend%2Fpremium-upgrades%2Fpremium-upgrades%2Fgold-cart-plugin%2F'.

		                 '&L_PAYMENTREQUEST_0_NAME1=Member%20Access%20Plugin'.
		                 '&L_PAYMENTREQUEST_0_AMT1=5%2C000'.
		                 '&L_PAYMENTREQUEST_0_QTY1=1'.
		                 '&L_PAYMENTREQUEST_0_DESC1=Create%20pay%20to%20view%20subscription%20sites'.
		                 '&L_PAYMENTREQUEST_0_TAXAMT1=50'.
		                 '&L_PAYMENTREQUEST_0_ITEMURL1=http%3A%2F%2Fgetshopped.org%2Fextend%2Fpremium-upgrades%2Fpremium-upgrades%2Fmember-access-plugin%2F'.

		                 '&L_PAYMENTREQUEST_0_NAME2=Amazon%20S3'.
		                 '&L_PAYMENTREQUEST_0_AMT2=4%2C700'.
		                 '&L_PAYMENTREQUEST_0_QTY2=1'.
		                 '&L_PAYMENTREQUEST_0_DESC2=This%20Plugin%20allows%20downloadable%20products%20that%20you%20have%20for%20sale%20on%20your%20WP%20e-Commerce%20site%20to%20be%20hosted%20within%20Amazon%20S3.'.
		                 '&L_PAYMENTREQUEST_0_TAXAMT2=47'.
		                 '&L_PAYMENTREQUEST_0_ITEMURL2=http%3A%2F%2Fgetshopped.org%2Fextend%2Fpremium-upgrades%2Fpremium-upgrades%2Famazon-s3-plugin%2F';
		
		$this->bogus->http->returnsByValue( 'post', $mock_response );
		$response = $this->bogus->get_details_for( $this->token );
		
		$this->assertTrue( $response->is_successful() );
		$this->assertFalse( $response->has_errors() );
		$this->assertEqual( $response->get( 'token'          ), 'EC-1OIN4UJGFOK54YFV'  );
		$this->assertEqual( $response->get( 'timestamp'      ), 1309872232             );
		$this->assertEqual( $response->get( 'datetime'       ), '2011-07-05T13:23:52Z' );
		$this->assertEqual( $response->get( 'correlation_id' ), '224f0e4a32d14'        );
		$this->assertEqual( $response->get( 'version'        ), '2.30000'              );
		$this->assertEqual( $response->get( 'build'          ), '1.0006'               );
	}
	
	public function test_correct_response_is_returned_when_set_express_checkout_fails() {
		$mock_response = 'ACK=Failure&CORRELATIONID=224f0e4a32d14&TIMESTAMP=2011%2d07%2d05T13%253A23%253A52Z&VERSION=2%2e30000&BUILD=1%2e0006&L_ERRORCODE0=10412&L_SHORTMESSAGE0=Duplicate%20invoice&L_LONGMESSAGE0=Payment%20has%20already%20been%20made%20for%20this%20InvoiceID.&L_SEVERITYCODE0=3&L_ERRORCODE1=10010&L_SHORTMESSAGE1=Invalid%20Invoice&L_LONGMESSAGE1=Non-ASCII%20invoice%20id%20is%20not%20supported.&L_SEVERITYCODE1=3';
		$this->bogus->http->returnsByValue( 'post', $mock_response );
		$response = $this->bogus->setup_purchase( $this->amount, $this->setup_purchase_options );
		
		$this->assertFalse( $response->is_successful() );
		$this->assertTrue( $response->has_errors() );
		$this->assertEqual( $response->get( 'timestamp'      ), 1309872232             );
		$this->assertEqual( $response->get( 'datetime'       ), '2011-07-05T13:23:52Z' );
		$this->assertEqual( $response->get( 'correlation_id' ), '224f0e4a32d14'        );
		$this->assertEqual( $response->get( 'version'        ), '2.30000'              );
		$this->assertEqual( $response->get( 'build'          ), '1.0006'               );
		
		$expected_errors = array(
			array(
				'code'    => 10412,
				'message' => 'Duplicate invoice',
				'details' => 'Payment has already been made for this InvoiceID.',
			),
			
			array(
				'code'    => 10010,
				'message' => 'Invalid Invoice',
				'details' => 'Non-ASCII invoice id is not supported.',
			),
		);
		$actual_errors = $response->get_errors();
		$this->assertEqual( $actual_errors, $expected_errors );
	}
	
	public function test_correct_response_is_returned_when_set_express_checkout_is_successful_with_warning() {
		$mock_response = 'ACK=SuccessWithWarning&CORRELATIONID=224f0e4a32d14&TIMESTAMP=2011%2d07%2d05T13%253A23%253A52Z&VERSION=2%2e30000&BUILD=1%2e0006&TOKEN=EC%2d1OIN4UJGFOK54YFV&L_ERRORCODE0=10412&L_SHORTMESSAGE0=Duplicate%20invoice&L_LONGMESSAGE0=Payment%20has%20already%20been%20made%20for%20this%20InvoiceID.&L_SEVERITYCODE0=3&L_ERRORCODE1=10010&L_SHORTMESSAGE1=Invalid%20Invoice&L_LONGMESSAGE1=Non-ASCII%20invoice%20id%20is%20not%20supported.&L_SEVERITYCODE1=3';
		
		$this->bogus->http->returnsByValue( 'post', $mock_response );
		$response = $this->bogus->setup_purchase( $this->amount, $this->setup_purchase_options );
		
		$this->assertTrue( $response->is_successful() );
		$this->assertTrue( $response->has_errors() );
		$this->assertEqual( $response->get( 'token'          ), 'EC-1OIN4UJGFOK54YFV'  );
		$this->assertEqual( $response->get( 'timestamp'      ), 1309872232             );
		$this->assertEqual( $response->get( 'datetime'       ), '2011-07-05T13:23:52Z' );
		$this->assertEqual( $response->get( 'correlation_id' ), '224f0e4a32d14'        );
		$this->assertEqual( $response->get( 'version'        ), '2.30000'              );
		$this->assertEqual( $response->get( 'build'          ), '1.0006'               );
		
		$expected_errors = array(
			array(
				'code'    => 10412,
				'message' => 'Duplicate invoice',
				'details' => 'Payment has already been made for this InvoiceID.',
			),
			
			array(
				'code'    => 10010,
				'message' => 'Invalid Invoice',
				'details' => 'Non-ASCII invoice id is not supported.',
			),
		);
		$actual_errors = $response->get_errors();
		$this->assertEqual( $actual_errors, $expected_errors );
		
	}
}

require_once( PHP_MERCHANT_PATH . '/common/http-curl.php' );
Mock::generate( 'PHP_Merchant_HTTP_CURL' );

class PHP_Merchant_Paypal_Express_Checkout_Bogus extends PHP_Merchant_Paypal_Express_Checkout
{
	public $http;
	
	public function __construct( $options = array() ) {
		$options['http_client'] = new MockPHP_Merchant_HTTP_CURL();
		parent::__construct( $options );
	}
}