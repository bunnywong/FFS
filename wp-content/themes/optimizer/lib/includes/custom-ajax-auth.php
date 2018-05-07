<?php
function add_checkout_init_files(){
    wp_register_script('validate-script', get_template_directory_uri() . '/assets/js/jquery.validate.js', array('jquery') ); 
    wp_enqueue_script('validate-script');
    wp_register_script('ajax-auth-script', get_template_directory_uri() . '/assets/js/ajax-auth-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-auth-script');
}
add_action('init', 'add_checkout_init_files');
function ajax_auth_init(){	
	wp_localize_script( 'ajax-auth-script', 'ajax_auth_object', array( 
        'ajaxurl' =>  home_url() . '/wp-admin/admin-ajax.php' ,
        'loadingmessage' => __('Sending user info, please wait...')
    ));
    add_action( 'wp_ajax_nopriv_checkemail', 'check_email' );
    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
    
	// Enable the user with no privileges to run ajax_register() in AJAX
	add_action( 'wp_ajax_nopriv_ajaxregister', 'ajax_register' );
    add_action( 'wp_ajax_nopriv_getloginform', 'get_login_form' );
    add_action( 'wp_ajax_nopriv_ajaxlogout', 'ajax_logout' );
}
 function ajax_auth_logout_override(){
    
    wp_localize_script( 'ajax-auth-script', 'ajax_auth_logout_object', array( 
        'ajaxurl' => home_url() . '/wp-admin/admin-ajax.php',
        'loadingmessage' => __('Sending user info, please wait...')
    ));
    // echo "reaching here after local"; 
    add_action( 'wp_ajax_nopriv_ajaxlogout', 'ajax_logout' );
 }

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_auth_init');
}else{
    //echo "reaching else here"; 
    add_action('init', 'ajax_auth_logout_override');
}
function ajax_logout(){
    // First check the nonce, if it fails the function will break
    // check_ajax_referer( 'ajax-login-nonce', 'security' );
    $retrieved_nonce = $_REQUEST['security'];
    echo $retrieved_nonce;
    if (!wp_verify_nonce($retrieved_nonce, 'ajax_logout_nonce' ) ) die( 'Failed security check' );
    // Nonce is checked, get the POST data and sign user on
  	// Call auth_user_login
    //echo $_POST['email'];
	wp_logout();
    
}

function get_login_form(){
    $retrieved_nonce = $_REQUEST['security'];
    if($_REQUEST['fromwhere'] == 'login'){
        if (!wp_verify_nonce($retrieved_nonce, 'email_ajax_login' ) ) die( 'Failed security check' );
    }
    else if($_REQUEST['fromwhere'] == 'register'){
        if (!wp_verify_nonce($retrieved_nonce, 'email_ajax_register' ) ) die( 'Failed security check' );
    }
    $form_email = '<p class="form-row validate-required validate-required woocommerce-invalid woocommerce-invalid-required-field checkout-email-login" id="billing_email_field">';
        
    $my_nonce = wp_create_nonce('check_email'); 
    $form_email .= '<input type="hidden" name="security" id="security"  value="'.$my_nonce.'"/>';
    
    $form_email .= '<label for="billing_email" class="text-left">Email address</label><small class="error"></small><input type="text" class="input-text" name="billing_email" id="billing_email" autocomplete="given-name" autofocus="autofocus"><input type="button" class="btn-checkout" name="woocommerce_checkout_is_user" id="is_user" value="CONTINUE"/></p>';
    echo $form_email;
}
function check_email(){
    // First check the nonce, if it fails the function will break
    // check_ajax_referer( 'check-email-nonce', 'security' );
    // Nonce is checked, get the POST data and sign user on
  	// Call auth_user_login
	//auth_user_login($_POST['email'], $_POST['password'], 'Login'); 
    $email = $_POST['email'];
    $retrieved_nonce = $_REQUEST['security'];
    if (!wp_verify_nonce($retrieved_nonce, 'check_email' ) ) die( 'Failed security check' );
    //echo $email ;
    if ( empty( $email ) || ! is_email( $email ) ) {
        echo json_encode(array('status'=>false, 'message'=>__('Invalid email address')));
        die();
    }
    if ( email_exists( $email ) ) {
        $my_nonce = wp_create_nonce('email_ajax_login');
        $form_password = '<p class="form-row  validate-required validate-required woocommerce-invalid woocommerce-invalid-required-field checkout-email-login" id="billing_login_pass">';
        $form_password .= '<label>Welcome to Laurine Watches! <strong>%1$s</strong></label>';
        $form_password .= '<label>Not you? <a id="change_email" > <strong>Change email</strong></a></label>';
        $form_password .= '<label for="acc_password" class="text-left mt20">Password</label>';
       
        $form_password .= '<input type="hidden" name="acc_email" id="acc_email"  value="%1$s">';
        $form_password .= '<input type="password" class="input-text " name="acc_password" id="acc_password" placeholder="" value="" autofocus="autofocus">';
        $form_password .= '<input type="hidden" name="loginsecurity" id="loginsecurity"  value="'.$my_nonce.'">';
        $form_register .= '<input type="hidden" name="from_where" id="from_where"  value="login">';
		 $form_password .= '<small class="error"></small>';
        $form_password .= '<input type="button" class="btn-checkout" name="continue_pass" id="continue_pass" value="CONTINUE"  />';
        $ret_form = sprintf($form_password,$email);
        echo json_encode(array('status'=>true, 'message'=>__('Already registered.'),'form'=>$ret_form));
        //$form_password
        //return new WP_Error( 'registration-error-email-exists', __( 'An account is already registered with your email address. Please login.', 'woocommerce' ) );
    }else{
        $my_nonce = wp_create_nonce('email_ajax_register');
        // $my_nonce = wp_create_nonce('email_ajax_login');
        $form_register = '<p class="form-row  validate-required validate-required woocommerce-invalid woocommerce-invalid-required-field checkout-email-login" id="billing_login_register">';
        $form_register .= '<label class="msg-mt">WELCOME TO LAURINE WATCHES! <strong>%1$s</strong></label>';
        $form_register .= '<label class="msg-mt">Not you? <a id="change_email"> <strong>Change email</strong></a></label>';
        $form_register .= '<label for="signon_fullname" class="text-left msg-mot">Full name</label>';        
        $form_register .= '<input type="hidden" name="acc_email" id="acc_email"  value="%1$s">';
        $form_register .= '<input type="hidden" name="from_where" id="from_where"  value="register">';
        $form_register .= '<input type="hidden" name="loginsecurity" id="signonsecurity"  value="'.$my_nonce.'">';
        // $form_register .= '<input type="hidden" name="loginsecurity" id="loginsecurity"  value="'.$my_nonce.'">';
        $form_register .= '<input type="text" class="input-text " name="signon_fullname" id="signon_fullname" placeholder="" value="" autofocus="autofocus">';
        $form_register .= '<small class="error"></small>';
        $form_register .= '<label for="signon_pass" class="text-left msg-mot">Create new password</label>';
        
        $form_register .= '<input type="password" class="input-text " name="signon_pass" id="signon_pass" placeholder="" value="" >';
        $form_register .= '<small class="error"></small>';
        $form_register .= '<label for="signon_pass" class="text-left msg-mot">Re-enter password</label>';
        
        $form_register .= '<input type="password" class="input-text " name="signon_re_pass" id="signon_re_pass" placeholder="" value="" >';
        $form_register .= '<small class="error"></small>';
        // $form_password .= wp_nonce_field('ajax-login-nonce', 'loginsecurity');
        $form_register .= '<input type="button" class="btn-checkout" name="continue_signon" id="continue_signon" value="CONTINUE"  />';
        $ret_form = sprintf($form_register,$email);
        echo json_encode(array('status'=>true, 'message'=>__('Already registered.'),'form'=>$ret_form));
    }
    //echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    die();
} 

function ajax_login(){
    // First check the nonce, if it fails the function will break
    // check_ajax_referer( 'ajax-login-nonce', 'security' );
    $retrieved_nonce = $_REQUEST['security'];
    if (!wp_verify_nonce($retrieved_nonce, 'email_ajax_login' ) ) die( 'Failed security check' );
    // Nonce is checked, get the POST data and sign user on
  	// Call auth_user_login
    //echo $_POST['email'];
	auth_user_login(sanitize_email($_POST['email']), sanitize_text_field($_POST['pass']), 'Login'); 
    die();
}

function ajax_register(){
    // First check the nonce, if it fails the function will break
    // email_ajax_register
     $retrieved_nonce = $_REQUEST['security'];
    if (!wp_verify_nonce($retrieved_nonce, 'email_ajax_register' ) ) die( 'Failed security check' );
    // Nonce is checked, get the POST data and sign user on
    $info = array();
  	$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']) ;
    $info['user_pass'] = sanitize_text_field($_POST['pass']);
	$info['user_email'] = sanitize_email( $_POST['email']);
    if($_POST['pass'] != $_POST['repass']){
        echo json_encode(array('status'=>false, 'message'=>__('Password do not match'),'field'=>'#signon_re_pass'));
        die();
    }
	// Register the user
    $user_register = wp_insert_user( $info );
 	if ( is_wp_error($user_register) ){	
		$error  = $user_register->get_error_codes()	;
		if(in_array('empty_user_login', $error))
			echo json_encode(array('status'=>false, 'message'=>__($user_register->get_error_message('empty_user_login'))));
		elseif(in_array('existing_user_login',$error))
			echo json_encode(array('status'=>false, 'message'=>__('This username is already registered.')));
		elseif(in_array('existing_user_email',$error))
            echo json_encode(array('status'=>false, 'message'=>__('This email address is already registered.')));
    } else {
	  auth_user_login($info['user_email'], $info['user_pass'], 'Registration');       
    }

    die();
}

function auth_user_login($user_login, $password, $login)
{
	$info = array();
    $user = get_user_by('email', $user_login);
    $info['user_login'] = $user->data->user_login;
    $info['user_password'] = $password;
    $info['remember'] = true;
	//print_r($info);
	$user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
		echo json_encode(array('status'=>false, 'message'=>__('Invalid email and/or password.')));
    } else {
		wp_set_current_user($user_signon->ID); 
        $ret_content = 'SIGNED IN AS:  '.$user_signon->data->display_name.' '.$user_signon->data->user_email;
       $ret_content .= '<a href="'.wp_logout_url( wc_get_checkout_url() ).'" class="logout-link">Not '. $user_signon->user_email.' Change</a>';
       //$ret_content .= '<a href="'.wp_logout_url('/en/checkout/').'" class="logout-link">Not '. $user_signon->user_email.' Change</a>';
       // $ret_content .= '<a href="/en/checkout/" class="logout-link">Not '. $user_signon->user_email.' Change</a>';
        echo json_encode(array('status'=>true, 'message'=>__($login.' successful, redirecting...'),'content'=>$ret_content));
    }
	die();
}

