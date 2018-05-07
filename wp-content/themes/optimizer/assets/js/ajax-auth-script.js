/*
Version: 0.4.5

*/
var is_user_count = 0;
var change_email_count = 0;
var continue_pass_count = 0;
var continue_signon_count = 0;
var save_address_count = 0;
var save_payment_count = 0;
jQuery(document).ready(function($) {
    // Display form from link inside a popup
    $(window).keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $("html").on('click', '#is_user', function(e) {

        if (is_user_count == 0) {
            action = 'checkemail';
            email = $(".checkout-email-login #billing_email").val();
            security = $('.checkout-email-login #security').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_auth_object.ajaxurl,
                data: {
                    'action': action,
                    'email': email,
                    'security': security
                },
                success: function(data) {
                    is_user_count = 0;
                    if (data.status == false) {
                        $(".checkout-email-login small.error").text(data.message);
                    } else if (data.status == true) {
                        $('#billing_email_field').remove();
                        $("#custom_login").append(data.form);
                    }
                }
            });
        }
        is_user_count = 1;

    })
    $("html").on('click', '#change_email', function(e) {
        e.preventDefault();
        if (change_email_count == 0) {
            action = 'getloginform';
            fromwhere = $('.checkout-email-login #from_where').val();
            security = $('.checkout-email-login #loginsecurity').val();
            if (fromwhere == 'register')
                security = $('.checkout-email-login #signonsecurity').val();
            $.ajax({
                type: 'POST',
                dataType: 'HTML',
                url: ajax_auth_object.ajaxurl,
                data: {
                    'action': action,
                    'security': security,
                    'fromwhere': fromwhere
                }
            }).success(function(data) {
                change_email_count = 0;
                // console.log(data.responseText.status);
                data = data.substr(0, data.length - 1);
                $("#custom_login").find('#billing_login_pass').remove();
                $("#custom_login").find('#billing_login_register').remove();
                $("#custom_login").append(data);
                // data = JSON.parse(data);
                // if(data.status == 'false'){
                //     $(".checkout-email-login small.error").text(data.message);
                // }else if(data.status == 'true'){

                // }				
            });
        }
        change_email_count = 1;
    })
    $("html").on('click', '#continue_pass', function(e) {
        if (continue_pass_count == 0) {
            action = 'ajaxlogin';
            email = $(".checkout-email-login #acc_email").val();
            security = $('.checkout-email-login #loginsecurity').val();
            pass = $(".checkout-email-login #acc_password").val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_auth_object.ajaxurl,
                data: {
                    'action': action,
                    'email': email,
                    'security': security,
                    'pass': pass
                },
                success: function(data) {
                    continue_pass_count = 0;
                    if (data.status == false) {
                        $(".checkout-email-login small.error").text(data.message);
                    } else if (data.status == true) {
                        window.location.reload(true);
                        // $("li.checkout_login_li").find(".accordion_body").remove();
                        // $("li.checkout_login_li").find("div.list-heading").html(data.content);
                        // $("li.checkout_login_li").addClass("completed");
                        // $("li.checkout_billing_li").removeClass("uncompleted");
                        // $("li.checkout_billing_li").find(".accordion_body")
                        // .slideDown( "slow", function() {
                        //     // Animation complete.
                        // });
                    }
                }
            });
            e.preventDefault();
        }
        continue_pass_count = 1;
    })
    $("html").on("click", "#ajax-logout", function(e) {

        console.log("logour clicked");
        action = "ajaxlogout";
        security = $(this).attr("data-nonce");
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_auth_logout_object.ajaxurl,
            data: {
                'action': action,
                'security': security
            },
            success: function(data) {
                console.log(data);
                // change_email_count = 0;
                // window.location.reload(true);
            }
        });
        e.preventDefault();
    })
    $("html").on('click', '#continue_signon', function(e) {
        if (continue_signon_count == 0) {
            continue_signon_count = 1;
            action = 'ajaxregister';
            username = $(".checkout-email-login #signon_fullname").val();
            password = $('.checkout-email-login #signon_pass').val();
            repassword = $('.checkout-email-login #signon_re_pass').val();
            email = $('.checkout-email-login #acc_email').val();
            security = $('#signonsecurity').val();
            if (username.trim() != "" && password.trim() != "" && repassword.trim() != "" && password == repassword) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajax_auth_object.ajaxurl,
                    data: {
                        'action': action,
                        'username': username,
                        'pass': password,
                        'repass': repassword,
                        'email': email,
                        'security': security
                    },
                    success: function(data) {
                        continue_signon_count = 0;
                        if (data.status == false) {
                            $(".checkout-email-login").find(data.field)[0].prev().text(data.message);
                        } else if (data.status == true) {
                            $("li.checkout_login_li").find(".accordion_body").remove();
                            $("li.checkout_login_li").find("div.list-heading").html(data.content);
                            $("li.checkout_login_li").addClass("completed");
                            $("li.checkout_billing_li").removeClass("uncompleted");
                            $("li.checkout_billing_li").find(".accordion_body")
                                .slideDown("slow", function() {
                                    // Animation complete.
                                });
                        }
                    }
                });
            } else {
                if (username.trim() == "") {
                    continue_signon_count = 0;
                    $(".checkout-email-login #signon_fullname").next().text("This field is required");
                }
                if (password.trim() == "") {
                    continue_signon_count = 0;
                    $(".checkout-email-login #signon_pass").next().text("This field is required");
                }
                if (repassword.trim() == "") {
                    continue_signon_count = 0;
                    $(".checkout-email-login #signon_re_pass").next().text("This field is required");
                }
            }
        }

    })
/*
    $("html").on('click', '#save_address', function(e) {
        var validator = $("#checkout_form").validate({
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

        if ($("#ship-to-different-address-checkbox").is(":checked")) {
            $("#shipping_first_name").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            $("#shipping_last_name").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            $("#shipping_phone").rules("add", {
                required: true,
                digits: true,
                minlength: 8,
                maxlength: 12,
                messages: { required: 'field is required.' }
            });
            $("#shipping_address_1").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            $("#shipping_city").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            $("#shipping_state").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            $("#shipping_country").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });
            $("#shipping_postcode").rules("add", {
                required: true,
                messages: { required: 'field is required.' }
            });

        }
        if ($("#checkout_form").valid()) {
            // $( "#checkout_form" ).attr("onsubmit","return false");
            // alert("valid");
            // save_address_count = 0;
            var name = $("#billing_first_name").val() + " " + $("#billing_last_name").val();
            var address = $("#billing_address_1").val();
            var address2 = $("#billing_address_2").val();
            var billingcity = $("#billing_city").val();

            var change_anchor = '<a class="change-text" id="change_completed_address">Change</a>';
            var ret_content = '<span class="" id="delivery-address">DELIVERY ADDRESS:</span>  <span class="address-name">' + address + ' ' + address2 + ' </span><span class="unlbold">' + change_anchor + '</span>';
            $("li.checkout_billing_li").find("div.list-heading").html(ret_content);
            $("li.checkout_billing_li").addClass("completed");
            $("li.checkout_billing_li").find(".accordion_body").slideUp("slow", function() {
                $("li.checkout_payment_li").removeClass("uncompleted");
                $("li.checkout_payment_li").find(".accordion_body").slideDown("slow", function() {

                });
            });
            return false;
        }
    });


    $("html").on("click", '#change_completed_address', function() {
        $("li.checkout_billing_li").find("div.list-heading").html("<span class='' id='delivery-address'>DELIVERY ADDRESS</span>");
        $("li.checkout_billing_li").removeClass("completed");
        if (!$("li.checkout_review_li").hasClass("uncompleted")) {
            $("li.checkout_review_li").addClass("uncompleted");
            $("li.checkout_review_li").find(".accordion_body").slideUp("slow", function() {

            });
        }
        $("li.checkout_payment_li").addClass("completed");
        $("li.checkout_billing_li").find(".accordion_body").slideDown("slow", function() {

        });
        $("li.checkout_payment_li").find(".accordion_body").slideUp("slow", function() {
            var selectedMethod = $("input[name='payment_method']:checked").val();
            var change_anchor = '<a class="change-text" id="change_completed_payment">Change</a>';
            var ret_content = '<span class="" id="payment-method">PAYMENT METHOD:</span>  ' + selectedMethod + ' <span class="unlbold">' + change_anchor + '</span>';
            $("li.checkout_payment_li").find("div.list-heading").html(ret_content);
        });
    })
    $("html").on("click", '#change_completed_payment, #save_address', function() {
        $("li.checkout_payment_li").find("div.list-heading").html("<span class='' id='payment-method'>PAYMENT METHOD</span>");
        $("li.checkout_payment_li").removeClass("completed");
        if (!$("li.checkout_review_li").hasClass("uncompleted")) {
            $("li.checkout_review_li").addClass("uncompleted");
            $("li.checkout_review_li").find(".accordion_body").slideUp("slow", function() {

            });
        }
        if (!$("li.checkout_billing_li").hasClass("completed")) {
            $("li.checkout_billing_li").find("#save_address").trigger("click");

        } else {
            $("li.checkout_payment_li").find(".accordion_body").slideDown("slow", function() {

            });
        }

    })

*/

    $("html").on('click', '#save_payment1', function(e) {
        var $e = $(this);
        $e.off("click");
        //alert($("input[name='payment_method']:checked").val());
        if ($("input[name='payment_method']").is(":checked")) {
            var selectedMethod = $("input[name='payment_method']:checked").val();
            var change_anchor = '<a class="change-text" id="change_completed_payment">Change</a>';
            var ret_content = '<span class="" id="payment-method">PAYMENT METHOD:</span>  <span class="selectedmethod">' + selectedMethod + '</span> <span class="unlbold">' + change_anchor + '</span>';
            $("li.checkout_payment_li").find("div.list-heading").html(ret_content);
            $("li.checkout_payment_li").addClass("completed");
            $("li.checkout_payment_li").find(".accordion_body").slideUp("slow", function() {
                $("li.checkout_review_li").removeClass("uncompleted");
                $("li.checkout_review_li").find(".accordion_body").slideDown("slow", function() {

                });
            });
        } else {
            alert("Please choose a payment method!!!");
        }
        // var validator = $( "#checkout_form" ).validate({
        //                     debug: true,
        //                     errorClass: "invalid",
        //                     submitHandler: function(form) {
        //                         alert("valid");
        //                             var selectedMethod = $("input[name='payment_method']").val();                                    
        //                             var ret_content = 'PAYMENT METHOD:  '+selectedMethod+' '+ '<span class="plusminus">+</span>';
        //                             $("li.checkout_payment_li").find("div.list-heading").html(ret_content);
        //                             $("li.checkout_payment_li").addClass("completed");
        //                             $("li.checkout_payment_li").find(".accordion_body").slideUp( "slow", function() {
        //                                 $("li.checkout_review_li").removeClass("uncompleted");
        //                                 $("li.checkout_review_li").find(".accordion_body").slideDown("slow",function(){

        //                                 });
        //                             });
        //                         return false;
        //                     },
        //                     rules: {
        //                         // simple rule, converted to {required:true}
        //                         payment_method: "required"
        //                     }
        //                 });
        // validator.element( "input[name='payment_method']" );

        // if($("#payment_method_braintree_payment_gateway").is(":checked")){
        //     // var iframeNumber = document.getElementById('braintree-hosted-field-number');
        //     // // Get the document within the <iframe>
        //     // var iframeDocumentNumber = iframeNumber.contentDocument || iframeNumber.contentWindow.document;

        //     // var iframeExpiredate = document.getElementById('braintree-hosted-field-expirationMonth');
        //     // var iframeDocumentExpiredate = iframeExpiredate.contentDocument || iframeExpiredate.contentWindow.document;
        //     // var iframeExpireyear = document.getElementById('braintree-hosted-field-expirationYear');
        //     // var iframeDocumentExpireyear = iframeExpireyear.contentDocument || iframeExpireyear.contentWindow.document;
        //     // var iframeCvv = document.getElementById('braintree-hosted-field-expirationYear');
        //     // var iframeDocumentCvv = iframeCvv.contentDocument || iframeCvv.contentWindow.document;
        //     // var iframePostal = document.getElementById('braintree-hosted-field-expirationYear');
        //     // var iframeDocumentPostal = iframePostal.contentDocument || iframePostal.contentWindow.document;
        // }

    });

});