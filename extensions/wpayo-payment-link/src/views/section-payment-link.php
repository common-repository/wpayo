<?php

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
 
use Pronamic\WordPress\Pay\Plugin;
use Pronamic\WordPress\Pay\Util;

/**
* Input page.
*
* @param array $args Arguments.
* @return void
*/
function select_configuration( $args ) {
   $args['id']   = $args['label_for'];
   $args['name'] = $args['label_for'];

   $configurations    = Plugin::get_config_select_options();
   $configurations[0] = __( '— Default Gateway —', 'wpayo' );

   $configuration_options              = [];
   $configuration_options[]['options'] = $configurations;

   printf(
       '<select %s>%s</select>',
       // @codingStandardsIgnoreStart
       Util::array_to_html_attributes( $args ),
       Util::select_options_grouped( $configuration_options, get_option( 'pronamic_pay_config_id' ) )
       // @codingStandardsIgnoreEnd
   );

   if ( isset( $args['description'] ) ) {
       printf(
           '<p class="pronamic-pay-description description">%s</p>',
           // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
           $args['description']
       );
   }
}

function payment_link_fields() {
    
    // Submit button.
    submit_button( 'Create Payment Link', 'primary', '', true, ['id'=>'payment-link-submit-button'] );
    
    // Create nonce.
    $rand = uniqid( 'wpayo_payment_link_rand_' );
    wp_nonce_field( 'wpayo_create_payment_link|' . $rand, 'wpayo_nonce' );
    echo '<input type="hidden" id="wpayo_payment_link_rand" value="' . $rand . '" />';
    
    // jQuery script.
    ?>
    <script>
    jQuery("#payment-link-submit-button").click(function(event) {
        event.preventDefault();
        var amount = jQuery('[data-depend-id="wpayo_payment_link_amount"]').val();
        if (amount.trim() === '') {
            alert("Please don't leave amount field empty");
            return;
        }
        jQuery("#create-payment-link-notice").remove();
        var submit_button = jQuery("#payment-link-submit-button");
        submit_button.attr("disabled", "");
        submit_button.val('Loading...');
        jQuery.get(ajaxurl, {
                "action": "wpayo_create_payment_link",
                "wpayo_nonce": jQuery("#wpayo_nonce").val(),
                "amount": jQuery('[data-depend-id="wpayo_payment_link_amount"]').val(),
                "payment_description": jQuery('[data-depend-id="wpayo_payment_link_payment_description"]').val(),
                "payment_ref_id": jQuery('[data-depend-id="wpayo_payment_link_payment_ref_id"]').val(),
                "customer_name": jQuery('[data-depend-id="wpayo_payment_link_customer_name"]').val(),
                "customer_email": jQuery('[data-depend-id="wpayo_payment_link_customer_email"]').val(),
                "customer_phone": jQuery('[data-depend-id="wpayo_payment_link_customer_phone"]').val(),
                "config_id": jQuery("#wpayo_payment_link_config_id").val(),
                "rand": jQuery("#wpayo_payment_link_rand").val(),
            },
            function(msg) {
                submit_button.removeAttr("disabled");
                submit_button.val("Create Payment Link");

                msg = JSON.parse(msg);
                if ("success" == msg.status) {
                    alert("Payment Link Generated");
                    jQuery("#payment-link-submit-button").after('<div id="create-payment-link-notice" class="notice notice-success"><p>Payment Link Generated:<br><strong><a href="' + msg.redirect_url + '">' + msg.redirect_url + '</a></strong></p></div>');
                    jQuery('html, body').animate({
                        scrollTop: jQuery("#create-payment-link-notice").offset().top
                    }, 2000);
                } else {
                    alert(msg.error_msg);
                }
            });
        });
    </script>
   <?php
  }
  

  if( ! function_exists( 'csf_validate_url' ) ) {
    function csf_validate_url( $value ) {
      if( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
        return esc_html__( 'Please write a numeric data!', 'csf' );
      }
    }
}

$fields_payment = array(
    
    array(
        'type'    => 'subheading',
        'content' => 'Create A Payment Link',
    ),
    array(
        'type'    => 'submessage',
        'style'   => 'success',
        'content' => 'Payment Link helps you generate branded payment links directly from WordPress Dashboard without using Payment Gateway Dashboard.'
    ),
    array(
        'id'         => 'wpayo_payment_link_amount',
        'type'       => 'text',
        'title'      => 'Amount',
        'attributes' => array(
            'min' => '1',
            'required'  => '',
        ),
        // 'validate' => 'csf_validate_url',
    ),
    array(
        'id'      => 'wpayo_payment_link_payment_description',
        'type'    => 'text',
        'title'   => 'Payment For',
        'desc'    => 'Payment Purpose/Description',
    ),
    array(
        'id'      => 'wpayo_payment_link_payment_ref_id',
        'type'    => 'text',
        'title'   => 'Reference Id',
    ),
    array(
        'id'      => 'wpayo_payment_link_customer_name',
        'type'    => 'text',
        'title'   => 'Customer Name',
        'desc'    => 'For some payment gateways, Customer Name is a required field.',
    ),  
    array(
        'id'      => 'wpayo_payment_link_customer_email',
        'type'    => 'text',
        'title'   => 'Customer Email',
        'desc'    => 'For some payment gateways, Customer Email is also a required field',
    ),  
    array(
        'id'      => 'wpayo_payment_link_customer_phone',
        'type'    => 'text',
        'title'   => 'Customer Phone',
        'desc'    => 'For some payment gateways, Customer Phone is a required field too.',
    ),
    array(
        'type'     => 'callback',
        'function' => 'select_configuration',
        'title'    =>  'Payment Gateway Configuration',
        'args'     => 
        [
            'description' => 'Configurations can be created in Wpayo gateway configurations page at <a href="' . admin_url() . 'edit.php?post_type=wpayo_gateway">"Wpayo >> Configurations"</a>.' . '<br>' . 'Visit the "Wpayo >> Settings" page to set Default Gateway Configuration.',
            'label_for'   => 'wpayo_payment_link_config_id',
            'class'       => 'regular-text',
        ]
    ),
    array(
        'type'     => 'callback',
        'function' => 'payment_link_fields',
    ),
);

    \CSF::createSection(
        'test-id',
        array(
            'title'  => __( 'Payment links', 'wpayo' ),
            'fields' => $fields_payment,
		    'icon'   => 'fas fa-money-bill',
			
        )
    );
?>