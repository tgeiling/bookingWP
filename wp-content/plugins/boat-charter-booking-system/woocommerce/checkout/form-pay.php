<?php
/**
 * Pay for order form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-pay.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if(!defined('ABSPATH')) exit;

$class=array('bcbs-main');

$bookingId=get_post_meta($order->get_id(),'bcbs_booking_id',true);

if($bookingId>0)
{
    $Booking=new BCBSBooking();
    if(($booking=$Booking->getBooking($bookingId))!==false)
        array_push($class,'bcbs-booking-form-id-'.(int)$booking['meta']['booking_form_id']);
}

$paymentEnable=true;

?>
        <div<?php echo BCBSHelper::createCSSClassAttribute($class); ?>>

            <form id="order_review" method="post">
<?php
        if($order->needs_payment())
        {
            if(empty($available_gateways))
            {
                $paymentEnable=false;
				echo '<p class="woocommerce-notice woocommerce-notice--error">';
                echo apply_filters('woocommerce_no_available_payment_methods_message',esc_html__('Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'boat-charter-booking-system'));
				echo '</p>';
			}
        }

        if($paymentEnable)
        {
?>
                <div id="payment">

                    <ul class="wc_payment_methods payment_methods methods">
<?php
            foreach($available_gateways as $gateway)
                wc_get_template('checkout/payment-method.php',array('gateway'=>$gateway));
?>
                    </ul>

                    <div class="form-row">
                        
                        <input type="hidden" name="woocommerce_pay" value="1"/>

                        <?php wc_get_template('checkout/terms.php'); ?>

                        <?php do_action('woocommerce_pay_order_before_submit'); ?>

                        <?php echo apply_filters('woocommerce_pay_order_button_html','<input type="submit" class="bcbs-button bcbs-button-style-1" id="place_order" value="'.esc_attr($order_button_text).'" data-value="'.esc_attr($order_button_text).'"/>'); ?>

                        <?php do_action('woocommerce_pay_order_after_submit'); ?>

                        <?php wp_nonce_field('woocommerce-pay'); ?>
                        
                    </div>

                </div>
<?php
        }
?>
            </form>

        </div>
