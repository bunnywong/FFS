<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Load colours
$bg              = get_option( 'woocommerce_email_background_color' );
$body            = get_option( 'woocommerce_email_body_background_color' );
$base            = get_option( 'woocommerce_email_base_color' );
$base_text       = wc_light_or_dark( $base, '#202020', '#ffffff' );
$text            = get_option( 'woocommerce_email_text_color' );

$bg_darker_10    = wc_hex_darker( $bg, 10 );
$body_darker_10  = wc_hex_darker( $body, 10 );
$base_lighter_20 = wc_hex_lighter( $base, 20 );
$base_lighter_40 = wc_hex_lighter( $base, 40 );
$text_lighter_20 = wc_hex_lighter( $text, 20 );

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
?>
#wrapper {
	background-color: <?php echo esc_attr( $bg ); ?>;
	margin: 0;
	padding: 70px 0 70px 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
}

#template_container {
	box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important;
	border: 1px solid <?php echo esc_attr( $bg_darker_10 ); ?>;
	border-radius: 3px !important;
}

#template_header {
	border-radius: 3px 3px 0 0 !important;
	color: <?php echo esc_attr( $base_text ); ?>;
	border-bottom: 0;
	font-weight: bold;
	line-height: 100%;
	vertical-align: middle;
	font-family: Verdana, Geneva, sans-serif;
}

#template_header h1 {
	color: <?php echo esc_attr( $base_text ); ?>;
}

#template_footer td {
	padding: 0;
	-webkit-border-radius: 6px;
}

#template_footer #credit {
	border:0;
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	font-family: Verdana, Geneva, sans-serif;
	font-size:12px;
	line-height:125%;
	text-align:center;
	padding: 12px 0;
}

#body_content {
	
}

#body_content table td {
	padding: 18px 48px;
}

#body_content table td td {
	padding: 12px;
	background-color : #fff;
}

#body_content table td th {
	padding: 12px 0;
	background-color : #fff;
}

#body_content p {
	margin: 0 0 16px;
}

#body_content_inner {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	line-height: 150%;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

#body_content_inner p {
	text-align: center;
}

#body_content_inner #addresses {margin-top:15px;}

#body_content_inner #addresses p {
	text-align: left;
}

#order-table {background:#fff;}
#order-table td {background:#fff;}
#order-table th {background:#fff;}

.td {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;	
}
.td-border-top {border-top:1px solid #d0d0d0; color: <?php echo esc_attr( $text_lighter_20 ); ?>;}
.td-border-bottom {border-bottom:1px solid #d0d0d0; color: <?php echo esc_attr( $text_lighter_20 ); ?>;}

.text {
	color: <?php echo esc_attr( $text ); ?>;
	font-family: Verdana, Geneva, sans-serif;
}

.link {
	color: <?php echo esc_attr( $base ); ?>;
}

.mail-bg 
{
    background:url('http://ec2-52-77-225-190.ap-southeast-1.compute.amazonaws.com/wp-content/themes/optimizer/assets/images/email/mail-bg.jpg') <?php echo esc_attr( $base ); ?> center center repeat-y;
    background-color : transparent;
}
.mail-gold-bar 
{
    background:url('http://ec2-52-77-225-190.ap-southeast-1.compute.amazonaws.com/wp-content/themes/optimizer/assets/images/email/mail-gold-bar.png') <?php echo esc_attr( $base ); ?> center center no-repeat; 
    height : 5px;
    width : 100%;
    background-color : <?php echo esc_attr( $base ); ?>
}

#header_wrapper {
	padding: 18px 48px;
	display: block;
}

h1 {
	color: <?php echo esc_attr( $text ); ?>;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 30px;
	font-weight: 300;
	line-height: 150%;
	margin: 0;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
	text-shadow: 0 1px 0 <?php echo esc_attr( $base_lighter_20 ); ?>;
	-webkit-font-smoothing: antialiased;
}

h2 {
	color: <?php echo esc_attr( $text ); ?>;
	display: block;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 18px;
	font-weight: bold;
	line-height: 130%;
	margin: 16px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h3 {
	color: <?php echo esc_attr( $text ); ?>;
	display: block;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 16px;
	font-weight: bold;
	line-height: 130%;
	margin: 16px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

a {
	color: <?php echo esc_attr( $text_lighter_20); ?>;
	font-weight: normal;
	text-decoration: underline;
}

img {
	border: none;
	display: inline;
	font-size: 14px;
	font-weight: bold;
	height: auto;
	line-height: 100%;
	outline: none;
	text-decoration: none;
	text-transform: capitalize;
}
<?php
