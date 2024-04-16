<?php

/******************************************************************************/
/******************************************************************************/

class BCBSPaymentStripe
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->apiVersion='2020-08-27';
		
		$this->paymentMethod=array
		(
			'alipay'=>array(__('Alipay','boat-charter-booking-system')),
			'card'=>array(__('Cards','boat-charter-booking-system')),			
			'ideal'=>array(__('iDEAL','boat-charter-booking-system')),
			'fpx'=>array(__('FPX','boat-charter-booking-system')),
			'bacs_debit'=>array(__('Bacs Direct Debit','boat-charter-booking-system')),
			'bancontact'=>array(__('Bancontact','boat-charter-booking-system')),
			'giropay'=>array(__('Giropay','boat-charter-booking-system')),
			'p24'=>array(__('Przelewy24','boat-charter-booking-system')),
			'eps'=>array(__('EPS','boat-charter-booking-system')),
			'sofort'=>array(__('Sofort','boat-charter-booking-system')),
			'sepa_debit'=>array(__('SEPA Direct Debit','boat-charter-booking-system'))
		);
		
		$this->event=array
		(
			'payment_intent.canceled',
			'payment_intent.created',
			'payment_intent.payment_failed',
			'payment_intent.processing',
			'payment_intent.requires_action',
			'payment_intent.succeeded',
			'payment_method.attached'
		);
		
		asort($this->paymentMethod);
	}
	
	/**************************************************************************/
	
	function getPaymentMethod()
	{
		return($this->paymentMethod);
	}
	
	/**************************************************************************/
	
	function isPaymentMethod($paymentMethod)
	{
		return(array_key_exists($paymentMethod,$this->paymentMethod) ? true : false);
	}
	
	/**************************************************************************/
	
	function getWebhookEndpointUrlAdress()
	{
		$address=add_query_arg('action','payment_stripe',home_url().'/');
		return($address);
	}
	
	/**************************************************************************/
	
	function createWebhookEndpoint($marina)
	{
		$StripeClient=new \Stripe\StripeClient(['api_key'=>$marina['meta']['payment_stripe_api_key_secret'],'stripe_version'=>$this->apiVersion]);
		
		$webhookEndpoint=$StripeClient->webhookEndpoints->create(['url'=>$this->getWebhookEndpointUrlAdress(),'enabled_events'=>$this->event]);		
		
		BCBSOption::updateOption(array('payment_stripe_webhook_endpoint_id'=>$webhookEndpoint->id));
	}
	
	/**************************************************************************/
	
	function updateWebhookEndpoint($marina,$webhookEndpointId)
	{
		$StripeClient=new \Stripe\StripeClient(['api_key'=>$marina['meta']['payment_stripe_api_key_secret'],'stripe_version'=>$this->apiVersion]);
		
		$StripeClient->webhookEndpoints->update($webhookEndpointId,['url'=>$this->getWebhookEndpointUrlAdress()]);
	}
	
	/**************************************************************************/
	
	function createSession($booking,$bookingBilling,$bookingForm)
	{
        try
		{
			\Stripe\Stripe::setApiVersion($this->apiVersion);
			
			$Validation=new BCBSValidation();

			$marinaDepartureId=$booking['meta']['marina_departure_id'];

			$marina=$bookingForm['dictionary']['marina'][$marinaDepartureId];

			/***/

			Stripe\Stripe::setApiKey($marina['meta']['payment_stripe_api_key_secret']);

			/***/

			$webhookEndpointId=BCBSOption::getOption('payment_stripe_webhook_endpoint_id');

			if($Validation->isEmpty($webhookEndpointId)) $this->createWebhookEndpoint($marina);
			else
			{
				try
				{
					$this->updateWebhookEndpoint($marina,$webhookEndpointId);
				} 
				catch (Exception $ex) 
				{
					$this->createWebhookEndpoint($marina);
				}
			}

			/***/

			$productId=$marina['meta']['payment_stripe_product_id'];

			if($Validation->isEmpty($productId))
			{
				$product=\Stripe\Product::create(
				[
					'name'=>__('Boat Charter Service','boat-charter-booking-system')
				]);		

				$productId=$product->id;

				BCBSPostMeta::updatePostMeta($marinaDepartureId,'payment_stripe_product_id',$productId);
			}

			/***/

			$price=\Stripe\Price::create(
			[
				'product'=>$productId,
				'unit_amount'=>$bookingBilling['summary']['pay']*100,
				'currency'=>$booking['meta']['currency_id'],
			]);

			/***/

			$currentURLAddress=home_url();
			if($Validation->isEmpty($marina['meta']['payment_stripe_success_url_address']))
				$marina['meta']['payment_stripe_success_url_address']=$currentURLAddress;
			if($Validation->isEmpty($marina['meta']['payment_stripe_cancel_url_address']))
				$marina['meta']['payment_stripe_cancel_url_address']=$currentURLAddress;

			$session=\Stripe\Checkout\Session::create
			(
				[
					'payment_method_types'=>$marina['meta']['payment_stripe_method'],
					'mode'=>'payment',
					'line_items'=>
					[
						[
							'price'=>$price->id,
							'quantity'=>1
						]
					],
					'success_url'=>$marina['meta']['payment_stripe_success_url_address'],
					'cancel_url'=>$marina['meta']['payment_stripe_cancel_url_address']
				]		
			);

			BCBSPostMeta::updatePostMeta($booking['post']->ID,'payment_stripe_intent_id',$session->payment_intent);

			return($session->id);
        }
  		catch(Exception $ex) 
		{
			$LogManager=new BCBSLogManager();
			$LogManager->add('stripe',1,$ex->__toString());
			return(false);
		}
	}
	
	/**************************************************************************/
	
	function receivePayment()
	{
		$LogManager=new BCBSLogManager();
		
		if(!array_key_exists('action',$_REQUEST)) return(false);
		
		if($_REQUEST['action']=='payment_stripe')
		{
			$LogManager->add('stripe',2,__('[1] Receiving a payment.','boat-charter-booking-system'));
			
			global $post;
			
			$event=null;
			$content=@file_get_contents('php://input');
	
			try 
			{
				$event=\Stripe\Event::constructFrom(json_decode($content,true));
			} 
			catch(\UnexpectedValueException $e) 
			{
				$LogManager->add('stripe',2,__('[2] Error during parsing data in JSON format.','boat-charter-booking-system'));	
				http_response_code(400);
				exit();
			}	
			
			if(in_array($event->type,$this->event))
			{
				$LogManager->add('stripe',2,__('[4] Checking a booking.','boat-charter-booking-system'));
				
				$Booking=new BCBSBooking();
				$BookingStatus=new BCBSBookingStatus();
				
				$argument=array
				(
                    'post_type'=>BCBSBooking::getCPTName(),
                    'posts_per_page'=>-1,
                    'meta_query'=>array
                    (
                        array
                        (
                            'key'=>PLUGIN_BCBS_CONTEXT.'_payment_stripe_intent_id',
                            'value'=>$event->data->object->id
                        )                      
                    )
				);
				
                BCBSHelper::preservePost($post,$bPost);
				
	            $query=new WP_Query($argument);
                if($query!==false) 
                {
					if($query->found_posts)
					{
						$LogManager->add('stripe',2,sprintf(__('[6] Booking %s is found.','boat-charter-booking-system'),$event->data->object->id));	
					
						while($query->have_posts())
						{
							$query->the_post();

							$meta=BCBSPostMeta::getPostMeta($post);

							if(!array_key_exists('payment_stripe_data',$meta)) $meta['payment_stripe_data']=array();

							$meta['payment_stripe_data'][]=$event;

							BCBSPostMeta::updatePostMeta($post->ID,'payment_stripe_data',$meta['payment_stripe_data']);

							$LogManager->add('stripe',2,__('[7] Updating a booking about transaction details.','boat-charter-booking-system'));
							
							if($event->type=='payment_intent.succeeded')
							{
								if(BCBSOption::getOption('booking_status_payment_success')!=-1)
								{
									if($BookingStatus->isBookingStatus(BCBSOption::getOption('booking_status_payment_success')))
									{
										$LogManager->add('stripe',2,__('[11] Updating booking status.','boat-charter-booking-system'));
										
										$bookingOld=$Booking->getBooking($post->ID);

										BCBSPostMeta::updatePostMeta($post->ID,'booking_status_id',BCBSOption::getOption('booking_status_payment_success'));

										$bookingNew=$Booking->getBooking($post->ID);

										$emailSend=false;

										$WooCommerce=new BCBSWooCommerce();
										$WooCommerce->changeStatus(-1,$post->ID,$emailSend);									

										if(!$emailSend)
											$Booking->sendEmailBookingChangeStatus($bookingOld,$bookingNew);
									}
									else
									{
										$LogManager->add('stripe',2,__('[10] Cannot find a valid booking status.','boat-charter-booking-system'));	
									}
								}
								else
								{
									$LogManager->add('stripe',2,__('[9] Changing status of the booking after successful payment is off.','boat-charter-booking-system'));	
								}
							}
							else
							{
								$LogManager->add('stripe',2,sprintf(__('[8] Event %s is not supported.','boat-charter-booking-system'),$event->type));	
							}

							break;
						}
					}
					else
					{
						$LogManager->add('stripe',2,sprintf(__('[5] Booking %s is not found.','boat-charter-booking-system'),$event->data->object->id));	
					}
				}
			
				BCBSHelper::preservePost($post,$bPost,0);
			}
			else 
			{
				$LogManager->add('stripe',2,sprintf(__('[3] Event %s is not supported.','boat-charter-booking-system'),$event->type));	
			}
			
			http_response_code(200);
			exit();
		}
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/