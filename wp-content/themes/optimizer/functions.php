<?php
/**
 * The MAIN FUNCTIONS FILE for OPTIMIZER
 *
 * Stores all the Function of the template.
 *
 * @package Optimizer
 * 
 * @since Optimizer 1.0
 */
remove_filter( 'the_content', 'wpautop' ); the_content(); 
//**************Optimizer Golbal******************//
/*CHECK IF optimizer row exist in the wp_options table. Needed for Redux Conversion process*/ 
$optimizerdb = get_option( 'optimizer' );

//**************optimizer SETUP******************//
function optimizer_setup() {
	//add_theme_support( 'custom-header' );
	add_theme_support( 'title-tag' );			//WP 4.1 Site Title
	add_theme_support( 'woocommerce' );			//Woocommerce Support
	add_theme_support('automatic-feed-links');	//RSS FEED LINK
	add_theme_support( 'post-thumbnails' );		//Post Thumbnail
	//Custom Background	
	add_theme_support( 'custom-background', array( 'default-color' => 'f7f7f7') );	
	//Make theme available for translation
	load_theme_textdomain('optimizer', get_template_directory() . '/languages/');
	load_theme_textdomain('optimizer-custom', get_template_directory() . '/languages/');
	load_plugin_textdomain('woo-mail-custom');
	$locale = apply_filters( 'theme_locale', get_locale(), $domain );
	
	//Custom Thumbnail Size	
		add_image_size( 'optimizer_thumb', 400, 270, true ); /*(cropped)*/
   
	//Register Menus
	register_nav_menus( array(
			'primary' => __( 'Header Navigation', 'optimizer' ),
		) );
	}
add_action( 'after_setup_theme', 'optimizer_setup' );

//**************optimizer FUNCTIONS******************//

require(get_template_directory() . '/framework/core-functions.php');			//Include Optimizer Framework Core Functions 
require(get_template_directory() . '/lib/functions/core.php');					//Include Core Functions
require(get_template_directory() . '/lib/functions/enqueue.php');					//Include Enqueue CSS/JS Scripts
require(get_template_directory() . '/lib/functions/admin.php');				//Include Admin Functions (admin)
require(get_template_directory() . '/lib/functions/woocommerce.php');			//Include Woocommerce Functions
require(get_template_directory() . '/lib/functions/defaults.php');
require(get_template_directory() . '/customizer/customizer.php');
require(get_template_directory() . '/lib/functions/converter.php');
require(get_template_directory() . '/lib/includes/google_fonts.php');

//WIDGETS
require(get_template_directory() . '/frontpage/widgets/init.php');
require(get_template_directory() . '/framework/core-posts.php');		
require(get_template_directory() . '/framework/core-pagination.php');

// Display 24 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

// Disable comments in product detail page
add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab($tabs) {
    unset($tabs['reviews']);
    unset($tabs['additional_information']);
    
    return $tabs;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_change_breadcrumb_delimiter' );
function jk_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = ' &gt; ';
	return $defaults;
}

add_filter( 'wpb_wrps_title', 'custom_wpb_wrps_title' );
function custom_wpb_wrps_title( $title ) {
    return __('Discover Other Watches', 'optimizer-custom');
}

add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability( $availability, $_product ) {
    
    if ( $_product->is_in_stock() ) {
        $availability['availability'] = __('', 'woocommerce');
    }

    if ( $_product->get_total_stock() <= get_option( 'woocommerce_notify_low_stock_amount' ) ) {
		$availability['availability'] = __('Low Quantity', 'woocommerce');
	}

	if ( !$_product->is_in_stock() ) {
        $availability['availability'] = __('Coming Soon', 'woocommerce');        
    }

    return $availability;
}

// customize checkout form fields
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
     unset($fields['order']['order_comments']);
     unset($fields['billing']['billing_company']);
     return $fields;
}

// function cancelled_order_email_recipient( $recipient, $order ){
//    if( method_exists ( $order , 'get_billing_email' ) ){
//         $recipient = $order->get_billing_email();
//     } else {
//         $recipient = $order->billing_email;
//     }
//     return $recipient;
// }
// add_filter( 'woocommerce_email_recipient_cancelled_order', 'cancelled_order_email_recipient', 10, 2 );





function slider_bottom() {
	$str = '<div class="info-wrap">
			<div class="container">
				<div class="row">
					<div class="col-4 col-12-sm sm-center left-center">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-35.png" />
						</div>
						<div class="text-wrap"><p>100% SAFE & SECURE CHECKOUT</p></div>
					</div>
					<div class="col-4 col-12-sm all-center">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-36.png" />
						</div>
						<div class="text-wrap"><p>WORLDWIDE SHIPPING AVAILABLE</p></div>
					</div>
					
                    <div class="col-4 col-right-tab">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-37.png" />
						</div>
						<div class="text-wrap"><p>30 DAY FREE RETURN</p></div>
					</div>
				</div>
			</div>
		</div>';
  return $str;
}
add_shortcode( 'sliderBottom', 'slider_bottom' );

function slider_bottom_zn_ch() {
	$str = '<div class="info-wrap">
			<div class="container">
				<div class="row">
					<div class="col-4 col-12-sm sm-center left-center">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-35.png" />
						</div>
						<div class="text-wrap"><p>100％安全结帐</p></div>
					</div>
					<div class="col-4 col-12-sm all-center">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-36.png" />
						</div>
						<div class="text-wrap"><p>全球运送</p></div>
					</div>
					
                    <div class="col-4 col-right-tab">
						<div class="imgsrc-wrap">
                           <img src="/wp-content/uploads/2017/09/Asset-37.png" />
						</div>
						<div class="text-wrap"><p>30天免费退货</p></div>
					</div>
				</div>
			</div>
		</div>';
  return $str;
}
add_shortcode( 'sliderBottom_znch', 'slider_bottom_zn_ch' );








/**
 * Add Cart icon and count to header if WC is active
 */
function my_wc_cart_count() {
 
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
        $count = WC()->cart->get_cart_contains_count();
        ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
        if ( $count > 0 ) {
            ?>
            <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
            <?php
        }
                ?></a><?php
    }
 
}
add_action( 'your_theme_header_top', 'my_wc_cart_count' );



/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->get_cart_contents_count();
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            
    }
        ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );









function wpb_custom_new_mobile_menu() {
  register_nav_menus(
    array(
      'mobile-nav-top' => __( 'Mobile Nav Top', 'optimizer' ),
	  'mobile-nav-bottom' => __( 'Mobile Nav Bottom', 'optimizer' )
    )
  );
}
add_action( 'init', 'wpb_custom_new_mobile_menu' );




/* Home page banner shortcode */
function home_page_banner( $atts ) {
    extract( shortcode_atts( array(
        'width' => '100%',
        'heading' => '',
        'sub-text' => '',
        'image-url' => ''
    ), $atts ) );
	 $output = '<div class="homepagebanner" style="width:'.$atts['width'].'">
                  <div class="Img-wrap"><img src="'.$atts['image-url'].'" width="'.$atts['width'].'"  /></div>
                  <div class="heading">'.$atts['heading'].'</div>
                  <div class="sub-text">'.$atts['sub-text'].'</div>
               </div>';
    
    return $output;
}
add_shortcode( 'HomePageBanner', 'home_page_banner' );

// function return_custom_price($price, $product) {
  	// $value = apply_filters('woocs_exchange_value', $price);
	// return $value;
// }
// add_filter('woocommerce_get_price', 'return_custom_price', 10, 2);




