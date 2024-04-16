<?php

/******************************************************************************/
/******************************************************************************/

class BCBSPaymentPaypal
{
	/**************************************************************************/
	
	function __construct()
	{

	}
	
	/**************************************************************************/
	
	static function createPaymentForm($postId,$marinaId,$marina)
	{
		$Validation=new BCBSValidation();
		
		$formURL='https://www.paypal.com/cgi-bin/webscr';
		if((int)$marina['meta']['payment_paypal_sandbox_mode_enable']===1)
			$formURL='https://www.sandbox.paypal.com/cgi-bin/webscr';
		
		$successUrl=$marina['meta']['payment_paypal_success_url_address'];
		if($Validation->isEmpty($successUrl)) $successUrl=add_query_arg('action','success',get_the_permalink($postId));
		
		$cancelUrl=$marina['meta']['payment_paypal_cancel_url_address'];
		if($Validation->isEmpty($cancelUrl)) $cancelUrl=add_query_arg('action','cancel',get_the_permalink($postId));	
		
		$html=
		'
			<form action="'.esc_attr($formURL).'" method="post" name="bcbs-form-paypal" data-marina-id="'.(int)$marinaId.'">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="'.esc_attr($marina['meta']['payment_paypal_email_address']).'">				
				<input type="hidden" name="item_name" value="">
				<input type="hidden" name="item_number" value="0">
				<input type="hidden" name="amount" value="0.00">	
				<input type="hidden" name="currency_code" value="'.esc_attr(BCBSOption::getOption('currency')).'">
				<input type="hidden" value="1" name="no_shipping">
				<input type="hidden" value="'.esc_url(get_the_permalink($postId)).'?action=ipn" name="notify_url">				
				<input type="hidden" value="'.esc_url($successUrl).'?action=success" name="return">
				<input type="hidden" value="'.esc_url($cancelUrl).'?action=cancel" name="cancel_return">
			</form>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function handleIPN()
	{
		$Marina=new BCBSMarina();
		$Booking=new BCBSBooking();
		$BookingStatus=new BCBSBookingStatus();
		
		$LogManager=new BCBSLogManager();
		
		$LogManager->add('paypal',2,__('[1] Receiving a payment.','boat-charter-booking-system'));	
		
		$bookingId=(int)$_POST['item_number'];
		
		$booking=$Booking->getBooking($bookingId);
		if((!is_array($booking)) || (!count($booking))) 
		{
			$LogManager->add('paypal',2,sprintf(__('[2] Booking %s is not found.','boat-charter-booking-system'),$bookingId));	
			return;
		}
		
		$marinaDepartureId=$booking['meta']['marina_departure_id'];
		$dictionary=$Marina->getDictionary(array('marina_id'=>$marinaDepartureId));

		if((!is_array($dictionary)) || (count($dictionary)!=1))
		{	
			$LogManager->add('paypal',2,sprintf(__('[3] Marina %s is not found.','boat-charter-booking-system'),$marinaDepartureId));	
			return;
		}
		
		$request='cmd='.urlencode('_notify-validate');
		
		$postData=BCBSHelper::stripslashes($_POST);
		
		foreach($postData as $key=>$value) 
			$request.='&'.$key.'='.urlencode($value);

		$address='https://ipnpb.paypal.com/cgi-bin/webscr';
		if($dictionary[$marinaDepartureId]['meta']['payment_paypal_sandbox_mode_enable']==1)
			$address='https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
		
		$LogManager->add('paypal',2,sprintf(__('[4] Sending a request: %s on address: %s.','boat-charter-booking-system'),$request,$address));
		
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$address);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$request);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('Host: www.paypal.com'));
		$response=curl_exec($ch);
		 
		if(curl_errno($ch)) 
		{	
			$LogManager->add('paypal',2,sprintf(__('[5] Error %s during processing cURL request.','boat-charter-booking-system'),curl_error($ch)));	
			return;
		}
		
		if(!strcmp(trim($response),'VERIFIED')==0)
		{
			$LogManager->add('paypal',2,sprintf(__('[6] Request cannot be verified: %s.','boat-charter-booking-system'),$response));	
			return;
		}
		
		$meta=BCBSPostMeta::getPostMeta($bookingId);
				
		if(!((array_key_exists('payment_paypal_data',$meta)) && (is_array($meta['payment_paypal_data']))))
            $meta['payment_paypal_data']=array();
		
		$meta['payment_paypal_data'][]=$postData;
		
        BCBSPostMeta::updatePostMeta($bookingId,'payment_paypal_data',$meta['payment_paypal_data']);
		
		$LogManager->add('paypal',2,__('[7] Updating a booking about transaction details.','boat-charter-booking-system'));
		
		if($postData['payment_status']=='Completed')
		{
			if(BCBSOption::getOption('booking_status_payment_success')!=-1)
			{
				if($BookingStatus->isBookingStatus(BCBSOption::getOption('booking_status_payment_success')))
				{
					$LogManager->add('paypal',2,__('[11] Updating booking status.','boat-charter-booking-system'));
					
					$bookingOld=$Booking->getBooking($bookingId);

					BCBSPostMeta::updatePostMeta($bookingId,'booking_status_id',BCBSOption::getOption('booking_status_payment_success'));

					$bookingNew=$Booking->getBooking($bookingId);

					$emailSend=false;

					$WooCommerce=new BCBSWooCommerce();
					$WooCommerce->changeStatus(-1,$bookingId,$emailSend);									

					if(!$emailSend)
						$Booking->sendEmailBookingChangeStatus($bookingOld,$bookingNew);
				}
				else
				{
					$LogManager->add('paypal',2,__('[10] Cannot find a valid booking status.','boat-charter-booking-system'));	
				}
			}
			else
			{
				$LogManager->add('paypal',2,__('[9] Changing status of the booking after successful payment is off.','boat-charter-booking-system'));
			}		
		}
		else
		{
			$LogManager->add('paypal',2,sprintf(__('[8] Payment status %s is not supported.','boat-charter-booking-system'),$postData['payment_status']));
		}
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/