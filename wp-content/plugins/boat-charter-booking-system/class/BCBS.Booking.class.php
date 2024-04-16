<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBooking
{
	/**************************************************************************/
	
	function __construct()
	{
		
	}
		
	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_BCBS_CONTEXT.'_booking');
	}
	
	/**************************************************************************/
	
	private function registerCPT()
	{
		register_post_type
		(
			self::getCPTName(),
			array
			(
				'labels'=>array
				(
					'name'=>esc_html__('Bookings','boat-charter-booking-system'),
					'singular_name'=>esc_html__('Booking','boat-charter-booking-system'),
					'edit_item'=>esc_html__('Edit Booking','boat-charter-booking-system'),
					'all_items'=>esc_html__('Bookings','boat-charter-booking-system'),
					'view_item'=>esc_html__('View Booking','boat-charter-booking-system'),
					'search_items'=>esc_html__('Search Bookings','boat-charter-booking-system'),
					'not_found'=>esc_html__('No Bookings Found','boat-charter-booking-system'),
					'not_found_in_trash'=>esc_html__('No Bookings Found in Trash','boat-charter-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Boat Charter Booking System','boat-charter-booking-system')
				),	
				'public'=>false,
				'menu_icon'=>'dashicons-calendar-alt',
				'show_ui'=>true,
				'capability_type'=>'post',
				'capabilities'=>array
				(
					 'create_posts'=>'do_not_allow',
				),
				'map_meta_cap'=>true,
				'menu_position'=>100,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>array('title')
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_bcbs_meta_box_booking_form',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
		
		add_action('restrict_manage_posts',array($this,'restrictManagePosts'));
		add_filter('parse_query',array($this,'parseQuery'));
	}
	
	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_booking_form',esc_html__('Main','boat-charter-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_booking_form_woocommerce',esc_html__('WooCommerce','boat-charter-booking-system'),array($this,'addMetaBoxWooCommerce'),self::getCPTName(),'side','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
				
		$data=$this->getBooking($post->ID);
			
		$data['nonce']=BCBSHelper::createNonceField(PLUGIN_BCBS_CONTEXT.'_meta_box_booking');
		
		$data['billing']=$this->createBilling($post->ID);
		
		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/meta_box_booking.php');			
	}
	
	/**************************************************************************/
	
	function addMetaBoxWooCommerce()
	{
		global $post;
		
		$booking=$this->getBooking($post->ID);
		
		if((int)$booking['meta']['woocommerce_booking_id']>0)
		{
			echo 
			'
				<div>
					<div>'.esc_html__('This booking has corresponding wooCommerce order. Click on button below to see its details in new window.','boat-charter-booking-system').'</div>
					<br/>
					<a class="button button-primary" href="'.get_edit_post_link($booking['meta']['woocommerce_booking_id']).'" target="_blank">'.esc_html__('Open booking','boat-charter-booking-system').'</a>
				</div>
			';
		}
		else
		{
			echo 
			'
				<div>
					<div>'.esc_html__('This booking hasn\'t corresponding wooCommerce order.','boat-charter-booking-system').'</div>
				</div>
			';			
		}
	}
	
	/**************************************************************************/
	
	function getBooking($bookingId)
	{
		$post=get_post($bookingId);
		if(is_null($post)) return(false);
		
		$booking=array();
		
		$Payment=new BCBSPayment();
		$Country=new BCBSCountry();
		$BookingStatus=new BCBSBookingStatus();
		
		$booking['post']=$post;
		$booking['meta']=BCBSPostMeta::getPostMeta($post);		
  
		if($booking['meta']['client_billing_detail_enable']==1)
		{
			$country=$Country->getCountry($booking['meta']['client_billing_detail_country_code']);
			$booking['client_billing_detail_country_name']=$country[0];
		}
		
		if($Payment->isPayment($booking['meta']['payment_id']))
		{
			$payment=$Payment->getPayment($booking['meta']['payment_id']);
			$booking['payment_name']=$payment[0];
		}
		
		if($BookingStatus->isBookingStatus($booking['meta']['booking_status_id']))
		{
			$bookingStatus=$BookingStatus->getBookingStatus($booking['meta']['booking_status_id']);
			$booking['booking_status_name']=$bookingStatus[0];
		}
		  
		/***/
		
		$booking['dictionary']['booking_status']=$BookingStatus->getBookingStatus();

		/***/
		
		$period=BCBSBookingHelper::calculateRentalPeriod($booking['meta']['departure_date'],$booking['meta']['departure_time'],$booking['meta']['return_date'],$booking['meta']['return_time'],$booking['meta']['billing_type']);
		
		$booking['rental_period_label']=BCBSBookingHelper::getRentalPeriodLabel($period,$booking['meta']['billing_type']);
		
		/***/
		
		return($booking);
	}
	
	/**************************************************************************/
	
	function adminCreateMetaBoxClass($class) 
	{
		array_push($class,'to-postbox-1');
		return($class);
	}
	
	/**************************************************************************/
	
	function sendBooking($data,$bookingForm)
	{	  
		$bookingId=wp_insert_post(array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish'
		));
		
		if($bookingId===0) return(false);
		
		wp_update_post(array
		(
 			'ID'=>$bookingId,
			'post_title'=>$this->getBookingTitle($bookingId)
		));
		
		/***/
		
		$WPML=new BCBSWPML();
		$Boat=new BCBSBoat();
		$TaxRate=new BCBSTaxRate();
		$PriceRule=new BCBSPriceRule();
		$WooCommerce=new BCBSWooCommerce();
		$BookingStatus=new BCBSBookingStatus();
		$BookingFormElement=new BCBSBookingFormElement();
		
		$taxRateDictionary=$TaxRate->getDictionary();
		
		$marinaDepartureId=$bookingForm['marina_departure_id'];
		$marinaReturnId=$bookingForm['marina_return_id'];

		$marinaDictionary=$bookingForm['dictionary']['marina'];
		
		/***/
		
		BCBSPostMeta::updatePostMeta($bookingId,'woocommerce_enable',$WooCommerce->isEnable($bookingForm['meta']));
		
		BCBSPostMeta::updatePostMeta($bookingId,'billing_type',BCBSOption::getOption('billing_type'));
		
		BCBSPostMeta::updatePostMeta($bookingId,'booking_status_id',$bookingForm['meta']['booking_status_id_default']);
		
		BCBSPostMeta::updatePostMeta($bookingId,'booking_form_id',$data['booking_form_id']);
		
		BCBSPostMeta::updatePostMeta($bookingId,'currency_id',BCBSCurrency::getFormCurrency());
		
		/***/
		
		BCBSPostMeta::updatePostMeta($bookingId,'departure_time',$data['departure_time']);
		BCBSPostMeta::updatePostMeta($bookingId,'departure_date',$data['departure_date']);
		
		BCBSPostMeta::updatePostMeta($bookingId,'return_time',$data['return_time']);
		BCBSPostMeta::updatePostMeta($bookingId,'return_date',$data['return_date']);
		
		BCBSPostMeta::updatePostMeta($bookingId,'departure_datetime',$data['departure_date'].' '.$data['departure_time']);
		BCBSPostMeta::updatePostMeta($bookingId,'return_datetime',$data['return_date'].' '.$data['return_time']);
		
		/***/
		
		BCBSPostMeta::updatePostMeta($bookingId,'marina_departure_id',$marinaDepartureId);
		BCBSPostMeta::updatePostMeta($bookingId,'marina_return_id',$marinaReturnId);
		
		BCBSPostMeta::updatePostMeta($bookingId,'marina_departure_name',$bookingForm['dictionary']['marina'][$marinaDepartureId]['post']->post_title);
		BCBSPostMeta::updatePostMeta($bookingId,'marina_return_name',$bookingForm['dictionary']['marina'][$marinaReturnId]['post']->post_title);
		
		BCBSPostMeta::updatePostMeta($bookingId,'all_marina_departure_selected',(int)BCBSBookingFormHelper::isAllMarinaSelected($bookingForm,'departure'));
		BCBSPostMeta::updatePostMeta($bookingId,'all_marina_return_selected',(int)BCBSBookingFormHelper::isAllMarinaSelected($bookingForm,'return'));
		
		/***/
		
		$boat=$bookingForm['dictionary']['boat'][$data['boat_id']];
				
		$argument=array
		(
			'booking_form_id'=>$data['booking_form_id'],
			'boat_id'=>$data['boat_id'],
			'marina_departure_id'=>$marinaDepartureId,
			'departure_date'=>$data['departure_date'],
			'departure_time'=>$data['departure_time'],
			'marina_return_id'=>$marinaReturnId,
			'return_date'=>$data['return_date'],
			'return_time'=>$data['return_time']
		);
		
		$discountPercentage=0;
		$boatPrice=$Boat->calculatePrice($argument,$bookingForm,$discountPercentage);	
		
		BCBSPostMeta::updatePostMeta($bookingId,'boat_id',$WPML->translateID($data['boat_id']));
		BCBSPostMeta::updatePostMeta($bookingId,'boat_name',$boat['post']->post_title);
		
		$boatPriceBooking=array();
		
		foreach($PriceRule->getPriceUseType() as $index=>$value)
		{
			$boatPriceBooking['price_'.$index.'_value']=BCBSPrice::formatToSave($boatPrice['price']['base']['price_'.$index.'_value']);
			$boatPriceBooking['price_'.$index.'_tax_rate_value']=$TaxRate->getTaxRateValue($boatPrice['price']['base']['price_'.$index.'_tax_rate_id'],$bookingForm['dictionary']['tax_rate']);
		}
		
		foreach($boatPriceBooking as $index=>$value)
			BCBSPostMeta::updatePostMeta($bookingId,$index,$value);
		
		/***/

		$paymentDepositType=BCBSBookingFormHelper::isPaymentDepositEnable($bookingForm);
		
		BCBSPostMeta::updatePostMeta($bookingId,'payment_deposit_type',$paymentDepositType);
		BCBSPostMeta::updatePostMeta($bookingId,'payment_deposit_type_fixed_value',$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['payment_deposit_type_fixed_value']);
		BCBSPostMeta::updatePostMeta($bookingId,'payment_deposit_type_percentage_value',$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['payment_deposit_type_percentage_value']);
		
		/***/
		
		if(((int)BCBSOption::getOption('booking_status_sum_zero')===1) && ($boatPrice['price']['sum']['net']['value']==0.00) && ($BookingStatus->isBookingStatus(BCBSOption::getOption('booking_status_payment_success'))))
		{
			BCBSPostMeta::updatePostMeta($bookingId,'booking_status_id',BCBSOption::getOption('booking_status_payment_success'));
		}		
		
		/***/
		
		$BookingFormElement->sendBookingField($bookingId,$bookingForm['meta'],$data);
		
		/***/
		
		$BookingExtra=new BCBSBookingExtra();
		$bookingExtra=$BookingExtra->validate($data,$bookingForm,$taxRateDictionary);
		
		BCBSPostMeta::updatePostMeta($bookingId,'booking_extra',$bookingExtra);
		
		/***/
		
		$data['client_contact_detail_email_address']=trim($data['client_contact_detail_email_address']);
		
		$field=array('first_name','last_name','email_address','phone_number');
		foreach($field as $value)
			BCBSPostMeta::updatePostMeta($bookingId,'client_contact_detail_'.$value,$data['client_contact_detail_'.$value]);
		
		BCBSPostMeta::updatePostMeta($bookingId,'client_billing_detail_enable',(int)$data['client_billing_detail_enable']);   
		
		if((int)$data['client_billing_detail_enable']===1)
		{
			$field=array('company_name','tax_number','street_name','street_number','city','state','postal_code','country_code');
			foreach($field as $value)
				BCBSPostMeta::updatePostMeta($bookingId,'client_billing_detail_'.$value,$data['client_billing_detail_'.$value]);			
		}
		
		/***/
		
		BCBSPostMeta::updatePostMeta($bookingId,'comment',$data['comment']);
		
		/***/
		
		BCBSPostMeta::updatePostMeta($bookingId,'payment_id',$data['payment_id']);
		BCBSPostMeta::updatePostMeta($bookingId,'payment_name',BCBSBookingHelper::getPaymentName($data['payment_id'],$bookingForm['meta']));
		
		/***/
		
		$couponCodeSourceType=0;
		
		$Coupon=new BCBSCoupon();
		$code=$Coupon->checkCode($bookingForm,$couponCodeSourceType);
		
		if($code===false)
		{
			BCBSPostMeta::updatePostMeta($bookingId,'coupon_code','');
			BCBSPostMeta::updatePostMeta($bookingId,'coupon_discount_percentage',0);
		}
		else
		{
			BCBSPostMeta::updatePostMeta($bookingId,'coupon_code',$code['meta']['code']);
			BCBSPostMeta::updatePostMeta($bookingId,'coupon_discount_percentage',$discountPercentage);			
		}
		
		/***/
		
		$this->sendEmailBooking($bookingId,'AFTER_BOOKING');
	  
		if($marinaDictionary[$marinaDepartureId]['meta']['nexmo_sms_enable']==1)
		{
			$Nexmo=new BCBSNexmo();
			$Nexmo->sendSMS($marinaDictionary[$marinaDepartureId]['meta']['nexmo_sms_api_key'],$marinaDictionary[$marinaDepartureId]['meta']['nexmo_sms_api_key_secret'],$marinaDictionary[$marinaDepartureId]['meta']['nexmo_sms_sender_name'],$marinaDictionary[$marinaDepartureId]['meta']['nexmo_sms_recipient_phone_number'],$marinaDictionary[$marinaDepartureId]['meta']['nexmo_sms_message']);
		}
		
		if($marinaDictionary[$marinaDepartureId]['meta']['twilio_sms_enable']==1)
		{
			$Twilio=new BCBSTwilio();
			$Twilio->sendSMS($marinaDictionary[$marinaDepartureId]['meta']['twilio_sms_api_sid'],$marinaDictionary[$marinaDepartureId]['meta']['twilio_sms_api_token'],$marinaDictionary[$marinaDepartureId]['meta']['twilio_sms_sender_phone_number'],$marinaDictionary[$marinaDepartureId]['meta']['twilio_sms_recipient_phone_number'],$marinaDictionary[$marinaDepartureId]['meta']['twilio_sms_message']);
		}
		
 		if($marinaDictionary[$marinaDepartureId]['meta']['telegram_enable']==1)
		{
			$Telegram=new BCBSTelegram();
			$Telegram->sendMessage($marinaDictionary[$marinaDepartureId]['meta']['telegram_token'],$marinaDictionary[$marinaDepartureId]['meta']['telegram_group_id'],$marinaDictionary[$marinaDepartureId]['meta']['telegram_message']);
		}
		
		/***/
		
		$GoogleCalendar=new BCBSGoogleCalendar();
		$GoogleCalendar->sendBooking($bookingId);
		
		/***/
		
		return($bookingId);
	}
	
	/**************************************************************************/
	
	function sendEmailBooking($bookingId,$state='AFTER_BOOKING')
	{
		$Marina=new BCBSMarina();
		
		if(($booking=$this->getBooking($bookingId))===false) return(false);

		$marinaDictionary=$Marina->getDictionary();
		
		$marinaDepartureId=$booking['meta']['marina_departure_id'];
		
		if(!array_key_exists($marinaDepartureId,$marinaDictionary)) return(false);
		
		$subject=sprintf(__('New booking "%s" is received','boat-charter-booking-system'),$this->getBookingTitle($bookingId));
		
		$recipient=array();
		$recipient[0]=array($booking['meta']['client_contact_detail_email_address']);
		$recipient[1]=preg_split('/;/',$marinaDictionary[$marinaDepartureId]['meta']['booking_new_recipient_email_address']);
		
		global $bcbs_logEvent;
		
		if((int)$booking['meta']['booking_new_customer_email_notification_sent']!==1)
		{
			if((int)$marinaDictionary[$marinaDepartureId]['meta']['booking_new_customer_email_notification']===1)
			{
				if((($state=='AFTER_PAYMENT') && ((int)$marinaDictionary[$marinaDepartureId]['meta']['booking_new_customer_email_notification_after_payment']===1) && (in_array($booking['meta']['payment_id'],array(2,3)))) || (!in_array($booking['meta']['payment_id'],array(2,3))))
				{	
					$bcbs_logEvent=1;
					$this->sendEmail($bookingId,$marinaDictionary[$marinaDepartureId]['meta']['booking_new_sender_email_account_id'],'booking_new_client',$recipient[0],$subject);
				
					BCBSPostMeta::updatePostMeta($bookingId,'booking_new_customer_email_notification_sent',1);
				}
			}
		}
		
		if((int)$booking['meta']['booking_new_defined_email_notification_sent']!==1)
		{
			$bcbs_logEvent=2;
			$this->sendEmail($bookingId,$marinaDictionary[$marinaDepartureId]['meta']['booking_new_sender_email_account_id'],'booking_new_admin',$recipient[1],$subject);
			BCBSPostMeta::updatePostMeta($bookingId,'booking_new_defined_email_notification_sent',1);
		}
	}
	
	/**************************************************************************/
	
	function getBookingTitle($bookingId)
	{
		return(sprintf(esc_html__('Booking #%s','boat-charter-booking-system'),$bookingId));
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		BCBSHelper::setDefault($meta,'booking_new_defined_email_notification_sent',0);
		BCBSHelper::setDefault($meta,'booking_new_customer_email_notification_sent',0);
		
		BCBSHelper::setDefault($meta,'all_marina_departure_selected',0);
		BCBSHelper::setDefault($meta,'all_marina_return_selected',0);

		BCBSHelper::setDefault($meta,'woocommerce_enable',0);
		BCBSHelper::setDefault($meta,'woocommerce_booking_id',0);
		
		BCBSHelper::setDefault($meta,'billing_type',2);
		BCBSHelper::setDefault($meta,'booking_status_id',1);
		
		BCBSHelper::setDefault($meta,'coupon_code','');
		BCBSHelper::setDefault($meta,'coupon_discount_percentage',0);
				
		BCBSHelper::setDefault($meta,'delivery_distance',0);
		BCBSHelper::setDefault($meta,'delivery_return_distance',0);
		
		BCBSHelper::setDefault($meta,'payment_deposit_type',0);
		BCBSHelper::setDefault($meta,'payment_deposit_type_fixed_value',0.00);
		BCBSHelper::setDefault($meta,'payment_deposit_type_percentage_value',0);
		
		$PriceRule=new BCBSPriceRule();
		
		foreach($PriceRule->getPriceUseType() as $priceUseTypeIndex=>$priceUseTypeValue)
		{
			BCBSHelper::setDefault($meta,'price_'.$priceUseTypeIndex.'_value',0);
			BCBSHelper::setDefault($meta,'price_'.$priceUseTypeIndex.'_tax_rate_value',0);			
		}
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{		
        if(!$_POST) return(false);
        
        if(BCBSHelper::checkSavePost($postId,PLUGIN_BCBS_CONTEXT.'_meta_box_booking_noncename','savePost')===false) return(false);
	
		$bookingOld=$this->getBooking($postId);
		
		$BookingStatus=new BCBSBookingStatus();
        if($BookingStatus->isBookingStatus(BCBSHelper::getPostValue('booking_status_id')))
           BCBSPostMeta::updatePostMeta($postId,'booking_status_id',BCBSHelper::getPostValue('booking_status_id')); 
          
		$bookingNew=$this->getBooking($postId);
		
		$emailSend=false;
		
		$WooCommerce=new BCBSWooCommerce();
		$WooCommerce->changeStatus(-1,$postId,$emailSend);
		
		if(!$emailSend)
			$this->sendEmailBookingChangeStatus($bookingOld,$bookingNew);
	}

	/**************************************************************************/
	
	function manageEditColumns($column)
	{
		$addColumn=array
		(
			'status'=>esc_html__('Booking status','boat-charter-booking-system'),
			'marina'=>esc_html__('Departure and return marina','boat-charter-booking-system'),
			'rental_period'=>esc_html__('Rental period','boat-charter-booking-system'),
			'boat'=>esc_html__('Boat','boat-charter-booking-system'),
			'client'=>esc_html__('Client','boat-charter-booking-system'),
			'price'=>esc_html__('Price','boat-charter-booking-system'),
			'date'=>$column['date']
		);
   
		unset($column['date']);
		
		foreach($addColumn as $index=>$value)
			$column[$index]=$value;
		
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$Date=new BCBSDate();
		$BookingStatus=new BCBSBookingStatus();
		
		$meta=BCBSPostMeta::getPostMeta($post);
		
		$billing=$this->createBilling($post->ID);
		
		switch($column) 
		{
			case 'status':
				
				$bookingStatus=$BookingStatus->getBookingStatus($meta['booking_status_id']);
				echo '<div class="to-booking-status to-booking-status-'.(int)$meta['booking_status_id'].'">'.esc_html($bookingStatus[0]).'</div>';
				
			break;
		
			case 'marina':
				
				if((int)$meta['all_marina_departure_selected']===0)
					echo esc_html($meta['marina_departure_name']);
					
				echo ' - ';
				
				if((int)$meta['all_marina_return_selected']===0)
					echo esc_html($meta['marina_return_name']);
				
			break;
		
			case 'rental_period':
				
				echo esc_html__('From: ','boat-charter-booking-system').esc_html($Date->formatDateToDisplay($meta['departure_date']).' '.esc_html($Date->formatTimeToDisplay($meta['departure_time'])));
				echo '<br>';
				echo esc_html__('To: ','boat-charter-booking-system').esc_html($Date->formatDateToDisplay($meta['return_date']).' '.esc_html($Date->formatTimeToDisplay($meta['return_time'])));
				
			break;
		
			case 'boat':
				
				echo esc_html($meta['boat_name']);
				
			break;
		  
			case 'client':
				
				echo esc_html($meta['client_contact_detail_first_name'].' '.$meta['client_contact_detail_last_name']);
				
			break;
   
			case 'price':
				
				echo esc_html($billing['summary']['value_gross_format_2']);
				
			break;
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function restrictManagePosts()
	{
 		if(!is_admin()) return;
		if(BCBSHelper::getGetValue('post_type',false)!==self::getCPTName()) return;	   
		
		$html=null;
		
		/***/
		
		$BookingStatus=new BCBSBookingStatus();
		$bookingStatusDirectory=$BookingStatus->getBookingStatus();
		
		$directory=array();
		foreach($bookingStatusDirectory as $index=>$value)
			$directory[$index]=$value[0];
		
		$directory[-2]=__('New & accepted','boat-charter-booking-system');
		
		asort($directory,SORT_STRING);
        
		if(!array_key_exists('booking_status_id',$_GET))
			$_GET['booking_status_id']=-2;
        
 		foreach($directory as $index=>$value)
			$html.=(int)BCBSHelper::getGetValue('booking_status_id',false).'  '.$index.'<option value="'.(int)$index.'" '.(BCBSHelper::selectedIf((int)BCBSHelper::getGetValue('booking_status_id',false),$index,false)).'>'.esc_html($value).'</option>';

		$html=
		'
			<select name="booking_status_id">
				<option value="0">'.esc_html__('All statuses','boat-charter-booking-system').'</option>
				'.$html.'
			</select>
		';
		
		/***/
		
		echo $html;
	}
	
	/**************************************************************************/
	
	function parseQuery($query)
	{
		if(!is_admin()) return;
		if(BCBSHelper::getGetValue('post_type',false)!==self::getCPTName()) return;
		if($query->query['post_type']!==self::getCPTName()) return;	   
		
		$metaQuery=array();
		$Validation=new BCBSValidation();
		
		$bookingStatusId=BCBSHelper::getGetValue('booking_status_id',false);
		if($Validation->isEmpty($bookingStatusId)) $bookingStatusId=-2;

		if($bookingStatusId!=0)
		{
			array_push($metaQuery,array
			(
				'key'=>PLUGIN_BCBS_CONTEXT.'_booking_status_id',
				'value'=>$bookingStatusId== -2 ? array(1,2) : array($bookingStatusId),
				'compare'=>'IN'
			));
		}  
		
		$order=BCBSHelper::getGetValue('order',false);
		$orderby=BCBSHelper::getGetValue('orderby',false);
		
		if($orderby=='title')
		{
			$query->set('orderby','title');
		}
		elseif($orderby=='date')
		{
			$query->set('orderby','date');
		}
		else
		{
			switch($orderby)
			{
				default:
					
					$query->set('meta_key',PLUGIN_BCBS_CONTEXT.'_departure_datetime');
					$query->set('meta_value','STR_TO_DATE("'.PLUGIN_BCBS_CONTEXT.'_departure_datetime","%Y-%m-%d")');	
					$query->set('meta_type','DATETIME');

					if($Validation->isEmpty($order)) $order='asc';
			}

			$query->set('orderby','meta_value');
		}

		$query->set('order',$order);

		if(count($metaQuery)) $query->set('meta_query',$metaQuery);
	}
	
	/**************************************************************************/
	
	function calculatePrice($data=null,$boatPrice=null,$hideFee=false)
	{		
		$TaxRate=new BCBSTaxRate();
		$Boat=new BCBSBoat();
		$BookingForm=new BCBSBookingForm();
		$BookingExtra=new BCBSBookingExtra();
		
		$taxRateDictionary=$TaxRate->getDictionary();
		
		/***/
		
		$component=array('boat','deposit','initial','one_way','after_business_hour_return','after_business_hour_departure','booking_extra','total');
		
		foreach($component as $value)
		{
			$price[$value]=array
			(
				'sum'=>array
				(
					'net'=>array
					(
						'value'=>0.00
					),
					'gross'=>array
					(
						'value'=>0.00,
						'format'=>0.00
					)
				)				
			);
		}
		
		/***/
	
		list($marinaDepartureId)=$BookingForm->getBookingFormMarinaDeparture($data['booking_form']);
		list($marinaReturnId)=$BookingForm->getBookingFormMarinaReturn($data['booking_form']);
		
		if(array_key_exists($data['boat_id'],$data['booking_form']['dictionary']['boat']))
		{
			$argument=array
			(
				'booking_form_id'=>(int)$data['booking_form_id'],
				'boat_id'=>(int)$data['boat_id'],
				'marina_departure_id'=>$marinaDepartureId,
				'departure_date'=>$data['departure_date'],
				'departure_time'=>$data['departure_time'],
				'marina_return_id'=>$marinaReturnId,
				'return_date'=>$data['return_date'],
				'return_time'=>$data['return_time']
			);
		 
			if(is_null($boatPrice))
			{
				$discountPercentage=0;
				$boatPrice=$Boat->calculatePrice($argument,$data['booking_form'],$discountPercentage,false);
			}
			
			$price['boat']['sum']['gross']['value']=$boatPrice['price']['sum']['gross']['value'];		
			$price['boat']['sum']['gross']['format']=$boatPrice['price']['sum']['gross']['format'];  
			$price['boat']['sum']['net']['value']=$boatPrice['price']['sum']['net']['value'];		
			$price['boat']['sum']['net']['format']=$boatPrice['price']['sum']['net']['format'];		   
					
			$price['deposit']['sum']['gross']['value']=$boatPrice['price']['deposit']['gross']['value'];   
			$price['deposit']['sum']['gross']['format']=$boatPrice['price']['deposit']['gross']['format'];
			$price['deposit']['sum']['net']['value']=$boatPrice['price']['deposit']['net']['value'];   
			$price['deposit']['sum']['net']['format']=$boatPrice['price']['deposit']['net']['format'];			
 
			$price['initial']['sum']['gross']['value']=$boatPrice['price']['initial']['gross']['value']; 
			$price['initial']['sum']['gross']['format']=$boatPrice['price']['initial']['gross']['format'];		  
			$price['initial']['sum']['net']['value']=$boatPrice['price']['initial']['net']['value']; 
			$price['initial']['sum']['net']['format']=$boatPrice['price']['initial']['net']['format'];   
			
			$price['one_way']['sum']['gross']['value']=$boatPrice['price']['one_way']['gross']['value']; 
			$price['one_way']['sum']['gross']['format']=$boatPrice['price']['one_way']['gross']['format'];		  
			$price['one_way']['sum']['net']['value']=$boatPrice['price']['one_way']['net']['value']; 
			$price['one_way']['sum']['net']['format']=$boatPrice['price']['one_way']['net']['format'];   
			
			$price['after_business_hour_departure']['sum']['gross']['value']=$boatPrice['price']['after_business_hour_departure']['gross']['value'];
			$price['after_business_hour_departure']['sum']['gross']['format']=$boatPrice['price']['after_business_hour_departure']['gross']['format']; 
			$price['after_business_hour_departure']['sum']['net']['value']=$boatPrice['price']['after_business_hour_departure']['net']['value'];
			$price['after_business_hour_departure']['sum']['net']['format']=$boatPrice['price']['after_business_hour_departure']['net']['format']; 
			
			$price['after_business_hour_return']['sum']['gross']['value']=$boatPrice['price']['after_business_hour_return']['gross']['value'];
			$price['after_business_hour_return']['sum']['gross']['format']=$boatPrice['price']['after_business_hour_return']['gross']['format']; 
			$price['after_business_hour_return']['sum']['net']['value']=$boatPrice['price']['after_business_hour_return']['net']['value'];
			$price['after_business_hour_return']['sum']['net']['format']=$boatPrice['price']['after_business_hour_return']['net']['format']; 
		
			if($hideFee)
			{
				$price['boat']['sum']['gross']['value']+=$price['deposit']['sum']['gross']['value']+$price['initial']['sum']['gross']['value']+$price['one_way']['sum']['gross']['value']+$price['after_business_hour_departure']['sum']['gross']['value']+$price['after_business_hour_return']['sum']['gross']['value'];
				$price['boat']['sum']['gross']['format']=BCBSPrice::format($price['boat']['sum']['gross']['value'],BCBSCurrency::getFormCurrency());
				
				$price['boat']['sum']['net']['value']+=$price['deposit']['sum']['net']['value']+$price['initial']['sum']['net']['value']+$price['one_way']['sum']['net']['value']+$price['after_business_hour_departure']['sum']['net']['value']+$price['after_business_hour_return']['sum']['net']['value'];
				$price['boat']['sum']['net']['format']=BCBSPrice::format($price['boat']['sum']['net']['value'],BCBSCurrency::getFormCurrency());
			}
		}
		
		/***/

		$bookingExtra=$BookingExtra->validate($data,$data['booking_form'],$taxRateDictionary);	  
		foreach($bookingExtra as $value)
		{
			$price['booking_extra']['sum']['gross']['value']+=$value['sum_gross'];
			$price['booking_extra']['sum']['net']['value']+=$value['sum_net'];
		}
		
		$price['booking_extra']['sum']['gross']['format']=BCBSPrice::format($price['booking_extra']['sum']['gross']['value'],BCBSCurrency::getFormCurrency());
		$price['booking_extra']['sum']['net']['format']=BCBSPrice::format($price['booking_extra']['sum']['net']['value'],BCBSCurrency::getFormCurrency());
		
		/***/
	  
		if($hideFee)
		{
			$price['total']['sum']['gross']['value']=$price['boat']['sum']['gross']['value']+$price['booking_extra']['sum']['gross']['value'];
			$price['total']['sum']['net']['value']=$price['boat']['sum']['net']['value']+$price['booking_extra']['sum']['net']['value'];
		}
		else 
		{
			$price['total']['sum']['gross']['value']=$price['boat']['sum']['gross']['value']+$price['deposit']['sum']['gross']['value']+$price['initial']['sum']['gross']['value']+$price['one_way']['sum']['gross']['value']+$price['after_business_hour_departure']['sum']['gross']['value']+$price['after_business_hour_return']['sum']['gross']['value']+$price['booking_extra']['sum']['gross']['value'];
			$price['total']['sum']['net']['value']=$price['boat']['sum']['net']['value']+$price['deposit']['sum']['net']['value']+$price['initial']['sum']['net']['value']+$price['one_way']['sum']['net']['value']+$price['after_business_hour_departure']['sum']['net']['value']+$price['after_business_hour_return']['sum']['net']['value']+$price['booking_extra']['sum']['net']['value'];
		}
			
		$price['total']['tax']['value']=$price['total']['sum']['gross']['value']-$price['total']['sum']['net']['value'];
		$price['total']['tax']['format']=BCBSPrice::format($price['total']['tax']['value'],BCBSCurrency::getFormCurrency());
		
		$price['total']['sum']['gross']['format']=BCBSPrice::format($price['total']['sum']['gross']['value'],BCBSCurrency::getFormCurrency());
		$price['total']['sum']['net']['format']=BCBSPrice::format($price['total']['sum']['net']['value'],BCBSCurrency::getFormCurrency());

		$price['pay']=$price['total'];
		
		if(BCBSBookingFormHelper::isPaymentDepositEnable($data['booking_form']))
		{
			if((int)$data['booking_form']['dictionary']['marina'][$marinaDepartureId]['meta']['payment_deposit_type']===1)
				$value=$data['booking_form']['dictionary']['marina'][$marinaDepartureId]['meta']['payment_deposit_type_fixed_value'];
			else $value=$price['pay']['sum']['gross']['value']*($data['booking_form']['dictionary']['marina'][$marinaDepartureId]['meta']['payment_deposit_type_percentage_value']/100);
			
			$price['pay']['sum']['gross']['value']=$value;
			$price['pay']['sum']['gross']['format']=BCBSPrice::format($price['pay']['sum']['gross']['value'],BCBSCurrency::getFormCurrency());
		}
		
		$balance=$price['total']['sum']['gross']['value']-$price['pay']['sum']['gross']['value'];
		if($balance<0) $balance=0;
		
		$price['balance']['sum']['gross']['value']=$balance;
		$price['balance']['sum']['gross']['format']=BCBSPrice::format($price['balance']['sum']['gross']['value'],BCBSCurrency::getFormCurrency());	
		
		return($price);
	}
		
	/**************************************************************************/
	
	function createResponse($response)
	{
		echo json_encode($response);
		exit;			 
	}
	
	/**************************************************************************/
	
	function createBilling($bookingId)
	{
		$billing=array();

		$billing['detail']=array();
		
		if(($booking=$this->getBooking($bookingId))===false) return($billing);

		/***/
		
		$period=BCBSBookingHelper::calculateRentalPeriod($booking['meta']['departure_date'],$booking['meta']['departure_time'],$booking['meta']['return_date'],$booking['meta']['return_time'],$booking['meta']['billing_type']);
		
		if($booking['meta']['price_initial_value']>0)
		{
			$billing['detail'][]=array
			(
				'type'=>'initial',
				'name'=>esc_html__('Initial fee','boat-charter-booking-system'),
				'unit'=>esc_html__('Item','boat-charter-booking-system'),
				'quantity'=>1,
				'price_net'=>$booking['meta']['price_initial_value'],
				'value_net'=>$booking['meta']['price_initial_value'],
				'tax_value'=>$booking['meta']['price_initial_tax_rate_value'],
				'value_gross'=>BCBSPrice::formatToCalc(BCBSPrice::calculateGross($booking['meta']['price_initial_value'],0,$booking['meta']['price_initial_tax_rate_value']))
			);
		}	 
		
		if(in_array($booking['meta']['billing_type'],array(2,3)))
		{	  
			$valueNet=$booking['meta']['price_rental_day_value']*$period['day'];
			if($valueNet>0.00)
			{
				$billing['detail'][]=array
				(
					'type'=>'rental_per_day',
					'name'=>esc_html__('Rental fee per day','boat-charter-booking-system'),
					'unit'=>esc_html__('No. of days','boat-charter-booking-system'),
					'quantity'=>$period['day'],
					'price_net'=>$booking['meta']['price_rental_day_value'],
					'value_net'=>$valueNet,
					'tax_value'=>$booking['meta']['price_rental_day_tax_rate_value'],
					'value_gross'=>BCBSPrice::formatToCalc(BCBSPrice::calculateGross($valueNet,0,$booking['meta']['price_rental_day_tax_rate_value']))
				);
			}			
		} 
		
		if(in_array($booking['meta']['billing_type'],array(1,3)))
		{
			$valueNet=$booking['meta']['price_rental_hour_value']*$period['hour'];
			if($valueNet>0.00)
			{
				$billing['detail'][]=array
				(
					'type'=>'rental_per_hour',
					'name'=>esc_html__('Rental fee per hour','boat-charter-booking-system'),
					'unit'=>esc_html__('No. of hours','boat-charter-booking-system'),
					'quantity'=>$period['hour'],
					'price_net'=>$booking['meta']['price_rental_hour_value'],
					'value_net'=>$valueNet,
					'tax_value'=>$booking['meta']['price_rental_hour_tax_rate_value'],
					'value_gross'=>BCBSPrice::formatToCalc(BCBSPrice::calculateGross($valueNet,0,$booking['meta']['price_rental_hour_tax_rate_value']))
				);
			}
		}
		
		if($booking['meta']['price_deposit_value']>0)
		{
			$billing['detail'][]=array
			(
				'type'=>'deposit',
				'name'=>esc_html__('Deposit fee','boat-charter-booking-system'),
				'unit'=>esc_html__('Item','boat-charter-booking-system'),
				'quantity'=>1,
				'price_net'=>$booking['meta']['price_deposit_value'],
				'value_net'=>$booking['meta']['price_deposit_value'],
				'tax_value'=>$booking['meta']['price_deposit_tax_rate_value'],
				'value_gross'=>BCBSPrice::formatToCalc(BCBSPrice::calculateGross($booking['meta']['price_deposit_value'],0,$booking['meta']['price_deposit_tax_rate_value']))
			);
		}
		
		if($booking['meta']['price_one_way_value']>0)
		{
			$billing['detail'][]=array
			(
				'type'=>'one_way',
				'name'=>esc_html__('One way fee','boat-charter-booking-system'),
				'unit'=>esc_html__('Item','boat-charter-booking-system'),
				'quantity'=>1,
				'price_net'=>$booking['meta']['price_one_way_value'],
				'value_net'=>$booking['meta']['price_one_way_value'],
				'tax_value'=>$booking['meta']['price_one_way_tax_rate_value'],
				'value_gross'=>BCBSPrice::formatToCalc(BCBSPrice::calculateGross($booking['meta']['price_one_way_value'],0,$booking['meta']['price_one_way_tax_rate_value']))
			);
		}  
		
		if($booking['meta']['price_after_business_hour_departure_value']>0)
		{
			$billing['detail'][]=array
			(
				'type'=>'after_business_hour_departure',
				'name'=>esc_html__('After hours departure fee','boat-charter-booking-system'),
				'unit'=>esc_html__('Item','boat-charter-booking-system'),
				'quantity'=>1,
				'price_net'=>$booking['meta']['price_after_business_hour_departure_value'],
				'value_net'=>$booking['meta']['price_after_business_hour_departure_value'],
				'tax_value'=>$booking['meta']['price_after_business_hour_departure_tax_rate_value'],
				'value_gross'=>BCBSPrice::formatToCalc(BCBSPrice::calculateGross($booking['meta']['price_after_business_hour_departure_value'],0,$booking['meta']['price_after_business_hour_departure_tax_rate_value']))
			);
		}  

		if($booking['meta']['price_after_business_hour_return_value']>0)
		{
			$billing['detail'][]=array
			(
				'type'=>'after_business_hour_return',
				'name'=>esc_html__('After hours return fee','boat-charter-booking-system'),
				'unit'=>esc_html__('Item','boat-charter-booking-system'),
				'quantity'=>1,
				'price_net'=>$booking['meta']['price_after_business_hour_return_value'],
				'value_net'=>$booking['meta']['price_after_business_hour_return_value'],
				'tax_value'=>$booking['meta']['price_after_business_hour_return_tax_rate_value'],
				'value_gross'=>BCBSPrice::formatToCalc(BCBSPrice::calculateGross($booking['meta']['price_after_business_hour_return_value'],0,$booking['meta']['price_after_business_hour_return_tax_rate_value']))
			);
		}	 
		
		/***/
		
		if(is_array($booking['meta']['booking_extra']))
		{
			foreach($booking['meta']['booking_extra'] as $value)
			{
				$priceNet=$value['price'];
				$quantity=$value['quantity'];
				
				if($value['price_type']==2)
					$priceNet*=$period['day'];
						
				$valueNet=$priceNet*$quantity;

				$billing['detail'][]=array
				(
					'type'=>'booking_extra',
					'id'=>$value['id'],
					'name'=>$value['name'],
					'unit'=>esc_html__('Item','boat-charter-booking-system'),
					'quantity'=>$quantity,
					'price_net'=>$priceNet,
					'value_net'=>$valueNet,
					'tax_value'=>$value['tax_rate_value'],
					'value_gross'=>BCBSPrice::formatToCalc(BCBSPrice::calculateGross($valueNet,0,$value['tax_rate_value']))
				);				   
			}
		}
		
		/***/
		
		$billing['summary']['duration']=0;
		$billing['summary']['distance']=0;
		$billing['summary']['value_net']=0;
		$billing['summary']['value_gross']=0;
		
		foreach($billing['detail'] as $value)
		{
			$billing['summary']['value_net']+=$value['value_net'];
			$billing['summary']['value_gross']+=$value['value_gross'];
		}
		
		/***/
		
		if((int)$booking['meta']['payment_deposit_type']!==0)
		{
			if((int)$booking['meta']['payment_deposit_type']===1)
				$value=$booking['meta']['payment_deposit_type_fixed_value'];
			else $value=BCBSPrice::formatToCalc($billing['summary']['value_gross']*($booking['meta']['payment_deposit_type_percentage_value']/100));
				
			$billing['summary']['pay']=$value;
		}
		else $billing['summary']['pay']=$billing['summary']['value_gross'];
		
		/***/
		
		foreach($billing['summary'] as $aIndex=>$aValue)
		{
			if(in_array($aIndex,array('value_net','value_gross')))
			{
				$billing['summary'][$aIndex.'_format_1']=BCBSPrice::numberFormat($aValue,$booking['meta']['currency_id']);
				$billing['summary'][$aIndex.'_format_2']=BCBSPrice::format($aValue,$booking['meta']['currency_id']);
				
			}
		}	  
		
		/***/
		
		foreach($billing['detail'] as $aIndex=>$aValue)
		{
			foreach($aValue as $bIndex=>$bValue)
			{
				if(in_array($bIndex,array('price_net','value_net','value_gross','tax_value')))
				{
					$billing['detail'][$aIndex][$bIndex.'_format_1']=BCBSPrice::numberFormat($bValue,$booking['meta']['currency_id']);
					$billing['detail'][$aIndex][$bIndex.'_format_2']=BCBSPrice::format($bValue,$booking['meta']['currency_id']);
				}
			}
		}

		/***/
		
		return($billing);
	}
	
	/**************************************************************************/
	
	function sendEmail($bookingId,$emailAccountId,$template,$recipient,$subject)
	{
		$Email=new BCBSEmail();
		$EmailAccount=new BCBSEmailAccount();
		
		if(($booking=$this->getBooking($bookingId))===false) return(false);
		
		if(($emailAccount=$EmailAccount->getDictionary(array('email_account_id'=>$emailAccountId)))===false) return(false);
		
		if(!isset($emailAccount[$emailAccountId])) return(false);
		
		$data=array();
		
		$emailAccount=$emailAccount[$emailAccountId];
		
		/***/
		
		global $bcbs_phpmailer;
		
		$bcbs_phpmailer['sender_name']=$emailAccount['meta']['sender_name'];
		$bcbs_phpmailer['sender_email_address']=$emailAccount['meta']['sender_email_address'];
		
		$bcbs_phpmailer['smtp_auth_enable']=$emailAccount['meta']['smtp_auth_enable'];
		$bcbs_phpmailer['smtp_auth_debug_enable']=$emailAccount['meta']['smtp_auth_debug_enable'];
		
		$bcbs_phpmailer['smtp_auth_username']=$emailAccount['meta']['smtp_auth_username'];
		$bcbs_phpmailer['smtp_auth_password']=$emailAccount['meta']['smtp_auth_password'];
		
		$bcbs_phpmailer['smtp_auth_host']=$emailAccount['meta']['smtp_auth_host'];
		$bcbs_phpmailer['smtp_auth_port']=$emailAccount['meta']['smtp_auth_port'];
		
		$bcbs_phpmailer['smtp_auth_secure_connection_type']=$emailAccount['meta']['smtp_auth_secure_connection_type'];
		
		/***/
		
		if(in_array($template,array('booking_new_admin','booking_new_client','booking_change_status')))
		{
			$templateFile='email_booking.php';
			
			$booking['booking_title']=$booking['post']->post_title;
			if($template==='booking_new_admin')
				$booking['booking_title']='<a href="'.esc_url(admin_url('post.php?post='.(int)$booking['post']->ID.'&action=edit')).'">'.esc_html($booking['booking_title']).'</a>';		
		}
		
		/***/
		
		$data['style']=$Email->getEmailStyle();
		
		$data['booking']=$booking;
		$data['booking']['billing']=$this->createBilling($bookingId);
		
		/***/
				
		$Template=new BCBSTemplate($data,PLUGIN_BCBS_TEMPLATE_PATH.$templateFile);
		$body=$Template->output();
		
		/***/
		
		$Email->send($recipient,$subject,$body);
	}
	
	/**************************************************************************/
	
	function sendEmailBookingChangeStatus($bookingOld,$bookingNew)
	{
		if($bookingOld['meta']['booking_status_id']==$bookingNew['meta']['booking_status_id']) return;
		
		$BookingStatus=new BCBSBookingStatus();
        $bookingStatus=$BookingStatus->getBookingStatus($bookingNew['meta']['booking_status_id']);
            
        $recipient=array();
        $recipient[0]=array($bookingNew['meta']['client_contact_detail_email_address']);
       
        $subject=sprintf(__('Booking "%s" has changed status to "%s"','boat-charter-booking-system'),$bookingNew['post']->post_title,$bookingStatus[0]);
		
		global $bcbs_logEvent;
        
		$BCBS_logEvent=3;
        $this->sendEmail($bookingNew['post']->ID,BCBSOption::getOption('sender_default_email_account_id'),'booking_change_status',$recipient[0],$subject);           
	}
	
	/**************************************************************************/
	
	function getCouponCodeUsageCount($couponCode)
	{
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'meta_key'=>PLUGIN_BCBS_CONTEXT.'_coupon_code',
			'meta_value'=>$couponCode,
			'meta_compare'=>'='
		);
		
		$query=new WP_Query($argument);
		if($query===false) return(false); 
		
		return($query->found_posts);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/