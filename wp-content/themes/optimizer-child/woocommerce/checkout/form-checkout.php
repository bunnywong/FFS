<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// if(is_user_logged_in()){
// echo '';
// }else{
// echo '<ol class="accordian-wrap accordion_container opt-child-theme">';
// }

// wc_print_notices();
global $woocommerce;

$display_login_as_accordion = false;
$display_delivery_as_accordion = false;
$display_payment_as_accordion = false;
$display_review_as_accordion = false;
// If checkout registration is disabled and not logged in, the user cannot checkout
// if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
// 	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
// 	return;
// }

#$yourSession= WP_Session_Tokens::get_instance(get_current_user_id());
#$yourSession->destroy_all(); 


?>
<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
<ol class="accordian-wrap accordion_container opt-child-theme">
	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" id="checkout_form">
<?php 
if ( !is_user_logged_in())
{
	?>
<li class="acordian-content accordion_head checkout_login_li"><div class="list-heading"><?php echo __("PLEASE SIGN UP WITH EMAIL ADDRESS OR LOG IN VIA YOUR FACEBOOK ACCOUNT.", 'optimizer-child')  ?></div>
	<div class="content-in accordion_body">
		<div class="width50per col-border " id="custom_login">
			<div class="clear"></div>
					
			<p class="form-row validate-required validate-required woocommerce-invalid woocommerce-invalid-required-field checkout-email-login" id="billing_email_field">
			<?php 
				$my_nonce = wp_create_nonce('check_email'); 
				echo '<input type="hidden" name="security" id="security"  value="'.$my_nonce.'">';
			?>
			<!-- <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>/customer/"> -->
			<label for="billing_email" class="text-left"><?php echo __("Email address",'optimizer-child')  ?> <abbr class="required" title="required">*</abbr></label>
			
			<input type="text" class="input-text " name="billing_email" id="billing_email" placeholder="" value="" autocomplete="given-name" autofocus="autofocus">
			<small class="error text-left"></small>
			<input type="button" class="btn-checkout" name="woocommerce_checkout_is_user" id="is_user" value="<?php echo __("CONTINUE", 'optimizer-child')  ?>"  />
			<!-- </form> -->
			</p>
			
		</div>
		<div class="width50per fb-login-container">
			<p class="form-row checkout-email-login text-center" id="">
				<label  class="">
					<?php echo __("Log in with your facebook account!", 'optimizer-child')  ?>
				</label>
			   <?php do_action('facebook_login_button');?>
			  </p>
		</div>
	</div>
</li>
<?php } else {
	global $current_user;
    get_currentuserinfo();
	$name = $current_user->user_firstname." ".$current_user->user_lastname; 
	// $logout_nonce = wp_create_nonce("ajax_logout_nonce");
	
?>
<li class="acordian-content accordion_head completed"><div class="list-heading"><span class=""><?php echo __("SIGNED IN AS:", 'optimizer-child')  ?></span> <span class="co-name-wrap"><?php echo $name; ?></span> 
<div class="signinRes">
<a href="<?php echo wp_logout_url( __('/en/checkout/','optimizer-child') ); ?>" class="logout-link"><?php echo __("Not", 'optimizer-child') . " " . $current_user->user_email; ?>? &nbsp;&nbsp;</a><span  class="unlbold"><a class="change-text"><?php echo __("Change", 'optimizer-child')  ?></a></span>
</div>
</div>
</li>
<?php } ?>

	
	
	<?php if ( $checkout->get_checkout_fields() ) : ?>
		<?php
		if ( !is_user_logged_in())
		{
			echo '<li class="acordian-content accordion_head uncompleted checkout_billing_li"><div class="list-heading"><span class="" id="delivery-address">' . __("DELIVERY ADDRESS", 'optimizer-child') . '</span></div>';
			echo '<div class="content-in accordion_body hide">';
		} else{
			echo '<li class="acordian-content accordion_head checkout_billing_li"><div class="list-heading"><span class="" id="delivery-address">' . __("DELIVERY ADDRESS", 'optimizer-child') . '</span></div>';
			echo '<div class="content-in accordion_body">';
		}
		?>
		
			<div class="col2-set" id="customer_details">
				<div class="col-1">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
				</div>

				<div class="col-2">
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>
			</div>
			<p class="text-center">
				<input type="button" class="btn-checkout" name="woocommerce_save_address" id="save_address" value="<?php echo __("CONTINUE", 'optimizer-child')  ?>"/>
			</p>
		</div>
		</li>
		 <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?> 
		
	<?php endif; ?>
	
	<li class="acordian-content accordion_head uncompleted checkout_review_li"><div class="list-heading"><?php _e( 'REVIEW & PLACE ORDER', 'optimizer-child' ); ?> </div>
	
	<div class="content-in accordion_body hide">
		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>
	</div>
	</li>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

</ol>
<script>
jQuery(function(){ 
// jQuery("#save_address").bind("click", function (e) { 
// var allVal='';
	 // jQuery("#customer_details :input").each(function() {
		 // if (jQuery(this).attr('id')  == 'ship-to-different-address-checkbox'){
			 
		 // if (jQuery('#ship-to-different-address-checkbox').is(':checked')) {
				 // jQuery(this).val('1');
			 // }
			 // else{
				// jQuery(this).val('0');
			 // }
	 // }
    // allVal += '&' + jQuery(this).attr('name') + '=' + jQuery(this).val();
  // });
// jQuery.ajax({
					  // url: '<?php echo admin_url('admin-ajax.php'); ?>',
					  // type: 'POST',
					  // data: allVal+'&action=call_save_address_checkout',
					  // success: function(data){
						// console.log(data);
					  // }
					// });
// });
jQuery("#save_payment").on("click", function (e) { 

jQuery('#order_review').css('display','none');
			 if (jQuery('#ship-to-different-address-checkbox').is(':checked')) {
				 console.log(jQuery("#shipping_country").on("select2:select").val());
				 	 select_val = jQuery("#shipping_country").on("select2:select").val();
			 }
			 else{
				 console.log(jQuery("#billing_country").on("select2:select").val());
				 select_val = jQuery("#billing_country").on("select2:select").val();
			 }
var allVal='';
					 jQuery("#customer_details :input").each(function() {
						 if (jQuery(this).attr('id')  == 'ship-to-different-address-checkbox'){
							 
						 if (jQuery('#ship-to-different-address-checkbox').is(':checked')) {
								 jQuery(this).val('1');
							 }
							 else{
								jQuery(this).val('0');
							 }
					 }
					allVal += '&' + jQuery(this).attr('name') + '=' + jQuery(this).val();
				  });
		// var e = jQuery(this);
        // e.off("click");
        //alert($("input[name='payment_method']:checked").val());
        if (jQuery("input[name='payment_method']").is(":checked")) {
            var selectedMethod = jQuery("input[name='payment_method']:checked").val();
            var change_anchor = '<a class="change-text" id="change_completed_payment"><?php _e('Change','optimizer-child'); ?></a>';
            var ret_content = '<span class=""><?php _e('PAYMENT METHOD','optimizer-child'); ?>:</span>  <span class="selectedmethod">' + selectedMethod + '</span> <span class="unlbold">' + change_anchor + '</span>';
            jQuery("li.checkout_payment_li").find("div.list-heading").html(ret_content);
            jQuery("li.checkout_payment_li").addClass("completed");
            jQuery("li.checkout_payment_li").find(".accordion_body").slideUp("slow", function() {
                jQuery("li.checkout_review_li").removeClass("uncompleted");
                jQuery("li.checkout_review_li").find(".accordion_body").slideDown("slow", function() {

                });
            });
			
			jQuery.ajax({
								  url: '<?php echo admin_url('admin-ajax.php'); ?>',
								  type: 'POST',
								  data: allVal+'&action=call_save_address_checkout',
								  success: function(data){
									jQuery.ajax({
			  url: "<?=  get_option( 'siteurl' );?><?php _e('/en/cart/','optimizer-child'); ?>",
			  cache: false,
			  type:'post',
			  data:{
				_wp_http_referer:'/en/cart/',
				_wpnonce:'<?= wp_create_nonce()?>',
				calc_shipping:'x',
				calc_shipping_country:select_val,
				calc_shipping_postcode:'',
				calc_shipping_state:'',
				},
			  success: function(html){
				jQuery.ajax({
					  url: "<?=  get_option( 'siteurl' );?><?php _e('/en/checkout/','optimizer-child'); ?>",
					  cache: false,
					  success: function(data){
						  
						jQuery('#order_review').html(jQuery(data).find("#order_review").html());
						jQuery('#order_review').css('display','block');
					  }
					});
			  }
			});
								  }
								});
        } else {
            alert( __("Please choose a payment method!!!",'optimizer-child') );
        }

			
			
			  
		});	
});


jQuery("html").on('click', '#save_address', function(e) {
        var validator = jQuery("#checkout_form").validate({
            debug: true,
            errorClass: "invalid",
            rules: {
                // simple rule, converted to {required:true}
                billing_first_name: "required",
                billing_last_name: "required",
                billing_address_1: "required",
                billing_city: "required",
                billing_state: "required",
                billing_country: "required",
                // compound rule
                billing_phone: {
                    required: true,
                    digits: true,
                    minlength: 8,
                    maxlength: 12
                },
                billing_postcode: {
                    required: true
                }
            }
        });

        if (jQuery("#ship-to-different-address-checkbox").is(":checked")) {
            jQuery("#shipping_first_name").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            jQuery("#shipping_last_name").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            jQuery("#shipping_phone").rules("add", {
                required: true,
                digits: true,
                minlength: 8,
                maxlength: 12,
                messages: { required: 'field is required.' }
            });
            jQuery("#shipping_address_1").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            jQuery("#shipping_city").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            jQuery("#shipping_state").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            jQuery("#shipping_country").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            jQuery("#shipping_postcode").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });

        }
        if (jQuery("#checkout_form").valid()) {
            // jQuery( "#checkout_form" ).attr("onsubmit","return false");
            // alert("valid");
            // save_address_count = 0;
            var name = jQuery("#billing_first_name").val() + " " + jQuery("#billing_last_name").val();
            var address = jQuery("#billing_address_1").val();
            var address2 = jQuery("#billing_address_2").val();
            var billingcity = jQuery("#billing_city").val();

            var change_anchor = '<a class="change-text" id="change_completed_address"><?php echo __("Change",'optimizer-child'); ?></a>';
            var ret_content = '<span class="" id="delivery-address"><?php echo __("DELIVERY ADDRESS",'optimizer-child'); ?>:</span>  <span class="address-name">' + address + ' ' + address2 + ' </span><span class="unlbold">' + change_anchor + '</span>';
            jQuery("li.checkout_billing_li").find("div.list-heading").html(ret_content);
            jQuery("li.checkout_billing_li").addClass("completed");
            jQuery("li.checkout_billing_li").find(".accordion_body").slideUp("slow", function() {
                jQuery("li.checkout_payment_li").removeClass("uncompleted");
                jQuery("li.checkout_payment_li").find(".accordion_body").slideDown("slow", function() {

                });
            });
            return false;
        }
    });


    jQuery("html").on("click", '#change_completed_address', function() {
        jQuery("li.checkout_billing_li").find("div.list-heading").html("<span class='' id='delivery-address'><?php echo __("DELIVERY ADDRESS",'optimizer-child') ?></span>");
        jQuery("li.checkout_billing_li").removeClass("completed");
        if (!jQuery("li.checkout_review_li").hasClass("uncompleted")) {
            jQuery("li.checkout_review_li").addClass("uncompleted");
            jQuery("li.checkout_review_li").find(".accordion_body").slideUp("slow", function() {

            });
        }
        jQuery("li.checkout_payment_li").addClass("completed");
        jQuery("li.checkout_billing_li").find(".accordion_body").slideDown("slow", function() {

        });
        jQuery("li.checkout_payment_li").find(".accordion_body").slideUp("slow", function() {
            var selectedMethod = jQuery("input[name='payment_method']:checked").val();
            var change_anchor = '<a class="change-text" id="change_completed_payment"><?php echo __("Change",'optimizer-child') ?></a>';
            var ret_content = '<span class="" id="payment-method"><?php echo __("PAYMENT METHOD",'optimizer-child') ?>:</span>  ' + selectedMethod + ' <span class="unlbold">' + change_anchor + '</span>';
            jQuery("li.checkout_payment_li").find("div.list-heading").html(ret_content);
        });
    })		</script>
