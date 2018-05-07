<?php

require_once( get_template_directory() . '/lib/includes/custom-ajax-auth.php' );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 25 );
// add_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 30 );
function wc_register_guests( $order_id ) {
  // get all the order data
  $order = new WC_Order($order_id);
  
  //get the user email from the order
  $order_email = $order->billing_email;
    
  // check if there are any users with the billing email as user or email
  $email = email_exists( $order_email );  
  $user = username_exists( $order_email );
  
  // if the UID is null, then it's a guest checkout
  if( $user == false && $email == false ){
    
    // random password with 12 chars
    $random_password = wp_generate_password();
    
    // create new user with email as username & newly created pw
    $user_id = wp_create_user( $order_email, $random_password, $order_email );
    
    //WC guest customer identification
    update_user_meta( $user_id, 'guest', 'yes' );
 
    //user's billing data
    update_user_meta( $user_id, 'billing_address_1', $order->billing_address_1 );
    update_user_meta( $user_id, 'billing_address_2', $order->billing_address_2 );
    update_user_meta( $user_id, 'billing_city', $order->billing_city );
    update_user_meta( $user_id, 'billing_company', $order->billing_company );
    update_user_meta( $user_id, 'billing_country', $order->billing_country );
    update_user_meta( $user_id, 'billing_email', $order->billing_email );
    update_user_meta( $user_id, 'billing_first_name', $order->billing_first_name );
    update_user_meta( $user_id, 'billing_last_name', $order->billing_last_name );
    update_user_meta( $user_id, 'billing_phone', $order->billing_phone );
    update_user_meta( $user_id, 'billing_postcode', $order->billing_postcode );
    update_user_meta( $user_id, 'billing_state', $order->billing_state );
 
    // user's shipping data
    update_user_meta( $user_id, 'shipping_address_1', $order->shipping_address_1 );
    update_user_meta( $user_id, 'shipping_address_2', $order->shipping_address_2 );
    update_user_meta( $user_id, 'shipping_city', $order->shipping_city );
    update_user_meta( $user_id, 'shipping_company', $order->shipping_company );
    update_user_meta( $user_id, 'shipping_country', $order->shipping_country );
    update_user_meta( $user_id, 'shipping_first_name', $order->shipping_first_name );
    update_user_meta( $user_id, 'shipping_last_name', $order->shipping_last_name );
    update_user_meta( $user_id, 'shipping_method', $order->shipping_method );
    update_user_meta( $user_id, 'shipping_postcode', $order->shipping_postcode );
    update_user_meta( $user_id, 'shipping_state', $order->shipping_state );
    
    // link past orders to this newly created customer
    wc_update_new_customer_past_orders( $user_id );
  }
  
}
 
//add this newly created function to the thank you page
// add_action( 'woocommerce_thankyou', 'wc_register_guests', 10, 1 );
// // define the woocommerce_login_form callback 
// function action_woocommerce_login_form(  ) { 
//     // make action magic happen here... 
// }; 
         
// // add the action 
// add_action( 'woocommerce_login_form', 'action_woocommerce_login_form', 10, 0 ); 
add_filter("woocommerce_checkout_fields", "custom_order_fields");

function custom_order_fields($fields) {
	$order = array(
		"billing_first_name",
    "billing_last_name",
    "billing_phone",
    "billing_address_1",
    "billing_address_2",
    "billing_city",
    "billing_state",
    "billing_country",
    "billing_postcode",
    "billing_email",
    "billing_company"    
	);
 
  // unset($fields['billing']['billing_email']);
	foreach($order as $field)
	{
		$ordered_fields[$field] = $fields["billing"][$field];
	}

	$fields["billing"] = $ordered_fields;
  unset($fields['billing']['billing_company']);
  unset($fields['billing']['billing_email']);
   $fields['billing']['billing_first_name'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => true
                                                );
  $fields['billing']['billing_last_name'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => true
                                                );
  $fields['billing']['billing_phone'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => true
                                                );
  $fields['billing']['billing_address_1'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => true
                                                );
  $fields['billing']['billing_address_2'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => false
                                                );
  $fields['billing']['billing_country']['class'] = array('form-row-wide');
  
  $fields['billing']['billing_state'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => false,
                                                'required' => true
                                                );
  $fields['billing']['billing_city'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => true
                                                );
  // $fields['billing']['billing_country'] = array(
  //                                               'class'     => array('form-row-first'),
  //                                               'clear'     => true,
  //                                               'required' => true
  //                                               );
  
  $fields['billing']['billing_postcode'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => false
                                                );
	$fields['billing']['billing_first_name']['priority'] = 10;
  $fields['billing']['billing_last_name']['priority'] = 20;
  $fields['billing']['billing_phone']['priority'] = 30;
  $fields['billing']['billing_address_1']['priority'] = 40;
  $fields['billing']['billing_address_2']['priority'] = 50;
  $fields['billing']['billing_country']['priority'] = 60;
  $fields['billing']['billing_state']['priority'] = 70;
  $fields['billing']['billing_city']['priority'] = 80;
  $fields['billing']['billing_postcode']['priority'] = 90;
  $fields['billing']['billing_first_name']['label'] = __('First Name', 'optimizer-child');
  $fields['billing']['billing_last_name']['label'] = __("Last name", 'optimizer-child');
  $fields['billing']['billing_phone']['label'] = __("Contact number", 'optimizer-child');
  $fields['billing']['billing_address_1']['label'] = __("Address", 'optimizer-child');
  $fields['billing']['billing_address_2']['label'] = "";
  $fields['billing']['billing_country']['label'] = __("Country", 'optimizer-child');
  $fields['billing']['billing_state']['label'] = __("State / Country", 'optimizer-child');
  $fields['billing']['billing_city']['label'] = __("City", 'optimizer-child');
  $fields['billing']['billing_postcode']['label'] = __("Postcode / Zip", 'optimizer-child');

  // array(
  //       'label' => __('First Name', 'woocommerce'),
  //   'class'     => array('form-row-wide'),
  //   'clear'     => true,
  //   'required' => true
  //    );
	// $fields['billing']['billing_address_2']['placeholder'] = '';
	// $fields['billing']['billing_phone']['placeholder'] = '';

  // $fields['order']['order_comments']['label'] = 'My new label';
  // unset($fields['order']['order_comments']);
	return $fields;
}
add_filter("woocommerce_checkout_fields", "custom_shipping_fields");

function custom_shipping_fields($fields) {
	$order = array(
		"shipping_first_name",
    "shipping_last_name",
    "shipping_phone",
    "shipping_address_1",
    "shipping_address_2",
    "shipping_city",
    "shipping_state",
    "shipping_country",
    "shipping_postcode",
    "shipping_email",
    "shipping_company"    
	);
 
  // unset($fields['shipping']['shipping_email']);
	foreach($order as $field)
	{
		$ordered_fields[$field] = $fields["shipping"][$field];
	}

	$fields["shipping"] = $ordered_fields;
  unset($fields['shipping']['shipping_company']);
  unset($fields['shipping']['shipping_email']);
   $fields['shipping']['shipping_first_name'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => true
                                                );
  $fields['shipping']['shipping_last_name'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => true
                                                );
  $fields['shipping']['shipping_phone'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => true
                                                );
  $fields['shipping']['shipping_address_1'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => true
                                                );
  $fields['shipping']['shipping_address_2'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => false
                                                );
  $fields['shipping']['shipping_country']['class'] = array('form-row-wide');
  $fields['shipping']['shipping_state'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => false,
                                                'required' => true
                                                );
  $fields['shipping']['shipping_city'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => true
                                                );
  
  // $fields['shipping']['shipping_country'] = array(
  //                                               'class'     => array('form-row-first'),
  //                                               'clear'     => true,
  //                                               'required' => true
  //                                               );
  
  $fields['shipping']['shipping_postcode'] = array(
                                                'class'     => array('form-row-wide'),
                                                'clear'     => true,
                                                'required' => false
                                                );
	$fields['shipping']['shipping_first_name']['priority'] = 10;
  $fields['shipping']['shipping_last_name']['priority'] = 20;
  $fields['shipping']['shipping_phone']['priority'] = 30;
  $fields['shipping']['shipping_address_1']['priority'] = 40;
  $fields['shipping']['shipping_address_2']['priority'] = 50;
  $fields['shipping']['shipping_country']['priority'] = 60;
  $fields['shipping']['shipping_state']['priority'] = 70;
  $fields['shipping']['shipping_city']['priority'] = 80;
  $fields['shipping']['shipping_postcode']['priority'] = 90;
  $fields['shipping']['shipping_first_name']['label'] = __("First name", 'optimizer-child');
  $fields['shipping']['shipping_last_name']['label'] = __("Last name", 'optimizer-child');
  $fields['shipping']['shipping_phone']['label'] = __("Contact number", 'optimizer-child');
  $fields['shipping']['shipping_address_1']['label'] = __("Address", 'optimizer-child');
  $fields['shipping']['shipping_address_2']['label'] = "";
  
  $fields['shipping']['shipping_country']['label'] = __("Country", 'optimizer-child');
  $fields['shipping']['shipping_state']['label'] = __("State / Country", 'optimizer-child');
  $fields['shipping']['shipping_city']['label'] = __("City", 'optimizer-child');
  $fields['shipping']['shipping_postcode']['label'] = __("Postcode / Zip", 'optimizer-child');

  // array(
  //       'label' => __('First Name', 'woocommerce'),
  //   'class'     => array('form-row-wide'),
  //   'clear'     => true,
  //   'required' => true
  //    );
	// $fields['billing']['billing_address_2']['placeholder'] = '';
	// $fields['billing']['billing_phone']['placeholder'] = '';

  // $fields['order']['order_comments']['label'] = 'My new label';
  // unset($fields['order']['order_comments']);
	return $fields;
}
// Save the cart for the current user, empty cart and redirect user to home page
function logout_redirect(){
  global $woocommerce;
	if( function_exists('WC') ){
		
  		// get user details
		// global $current_user;
		// get_currentuserinfo();
		// $user_id = $current_user->ID;
		$cart_contents = $woocommerce->cart->get_cart();
		$meta_key = 'cart';
		$meta_value = $cart_contents;
		//update_user_meta( $user_id, $meta_key, $meta_value);
		update_option( $meta_key, $meta_value );
    // WC()->cart->empty_cart();
  }
  if(WC()->cart->get_cart_contents_count()<=0)
    wp_safe_redirect( home_url() );
  else
    wp_safe_redirect(  wc_get_checkout_url() );
  exit();
}
add_action('wp_logout','logout_redirect');


add_action ('wp_ajax_call_save_address_checkout', 'save_address_checkout') ;
// if the ajax call will be made from JS executed when no user is logged into WP,
// then use this version
add_action ('wp_ajax_nopriv_call_save_address_checkout', 'save_address_checkout') ;

function save_address_checkout ()
{
	global $woocommerce;
	
	$values = $_REQUEST;
	$woocommerce->customer->set_billing_first_name($values['billing_first_name']);
    $woocommerce->customer->set_billing_last_name($values['billing_last_name']);
    $woocommerce->customer->set_billing_phone($values['billing_phone']);
    $woocommerce->customer->set_billing_address_1($values['billing_address_1']);
    $woocommerce->customer->set_billing_address_2($values['billing_address_2']);
    $woocommerce->customer->set_billing_country($values['billing_country']);
    $woocommerce->customer->set_billing_city($values['billing_city']);
    $woocommerce->customer->set_billing_state($values['billing_state']);
    $woocommerce->customer->set_billing_postcode($values['billing_postcode']);
	if($values['ship_to_different_address'] == 1){
		$woocommerce->customer->set_shipping_first_name($values['shipping_first_name']);
		$woocommerce->customer->set_shipping_last_name($values['shipping_last_name']);
		$woocommerce->customer->set_shipping_address_1($values['shipping_address_1']);
		$woocommerce->customer->set_shipping_address_2($values['shipping_address_2']);
		$woocommerce->customer->set_shipping_country($values['shipping_country']);
		$woocommerce->customer->set_shipping_city($values['shipping_city']);
		$woocommerce->customer->set_shipping_state($values['shipping_state']);
		$woocommerce->customer->set_shipping_postcode($values['shipping_postcode']);
	}
	else{
		$woocommerce->customer->set_shipping_first_name($values['billing_first_name']);
		$woocommerce->customer->set_shipping_last_name($values['billing_last_name']);
		$woocommerce->customer->set_shipping_address_1($values['billing_address_1']);
		$woocommerce->customer->set_shipping_address_2($values['billing_address_2']);
		$woocommerce->customer->set_shipping_country($values['billing_country']);
		$woocommerce->customer->set_shipping_city($values['billing_city']);
		$woocommerce->customer->set_shipping_state($values['billing_state']);
		$woocommerce->customer->set_shipping_postcode($values['billing_postcode']);
	}
   
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_postcode_checkout_fields', 99 );

function custom_override_postcode_checkout_fields( $fields ) {

    unset($fields['billing']['billing_postcode']['validate']);
    unset($fields['shipping']['shipping_postcode']['validate']);

    return $fields;
}

function enqueue_migrated_styles() {
	
	// enqueue parent styles
	//wp_enqueue_style('parent-theme', get_template_directory_uri() .'/style.css');
	
	// enqueue child styles
//	wp_enqueue_style('optimizer-child-customized', get_stylesheet_directory_uri() .'/customized.css', array('optimizer-style'));
//	wp_dequeue_style('optimizer-style');
//        wp_enqueue_style('optimizer-style-child', get_stylesheet_uri(),array('optimizer-parent-style'));
	
}
add_action('wp_enqueue_scripts', 'enqueue_migrated_styles');


function slider_bottom_id_id() {
	$str = '<div class="info-wrap">
			<div class="container">
				<div class="row">
					<div class="col-4 col-12-sm sm-center left-center">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-35.png" />
						</div>
						<div class="text-wrap"><p>Pemeriksaan yang 100% aman dan terjamin</p></div>
					</div>
					<div class="col-4 col-12-sm all-center">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-36.png" />
						</div>
						<div class="text-wrap"><p>Pengiriman ke Seluruh Dunia Tersedia</p></div>
					</div>
					
                    <div class="col-4 col-right-tab">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-37.png" />
						</div>
						<div class="text-wrap"><p>Pengembalian gratis 30 hari</p></div>
					</div>
				</div>
			</div>
		</div>';
  return $str;
}
add_shortcode( 'sliderBottom_idid', 'slider_bottom_id_id' );



function slider_bottom_ph_tl() {
	$str = '<div class="info-wrap">
			<div class="container">
				<div class="row">
					<div class="col-4 col-12-sm sm-center left-center">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-35.png" />
						</div>
						<div class="text-wrap"><p>100% Ligtas at siguradong pag-checkout</p></div>
					</div>
					<div class="col-4 col-12-sm all-center">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-36.png" />
						</div>
						<div class="text-wrap"><p>Available ang Pagpapadala sa Buong Mundo</p></div>
					</div>
					
                    <div class="col-4 col-right-tab">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-37.png" />
						</div>
						<div class="text-wrap"><p>30 araw na libreng pagbalik</p></div>
					</div>
				</div>
			</div>
		</div>';
  return $str;
}
add_shortcode( 'sliderBottom_phtl', 'slider_bottom_ph_tl' );

