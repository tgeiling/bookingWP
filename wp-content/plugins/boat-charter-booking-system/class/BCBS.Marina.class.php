<?php

/******************************************************************************/
/******************************************************************************/

class BCBSMarina
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
		return(PLUGIN_BCBS_CONTEXT.'_marina');
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
					'name'=>esc_html__('Marinas','boat-charter-booking-system'),
					'singular_name'=>esc_html__('Marinas','boat-charter-booking-system'),
					'add_new'=>esc_html__('Add New','boat-charter-booking-system'),
					'add_new_item'=>esc_html__('Add New Marina','boat-charter-booking-system'),
					'edit_item'=>esc_html__('Edit Marina','boat-charter-booking-system'),
					'new_item'=>esc_html__('New Marina','boat-charter-booking-system'),
					'all_items'=>esc_html__('Marinas','boat-charter-booking-system'),
					'view_item'=>esc_html__('View Marina','boat-charter-booking-system'),
					'search_items'=>esc_html__('Search Marinas','boat-charter-booking-system'),
					'not_found'=>esc_html__('No Marinas Found','boat-charter-booking-system'),
					'not_found_in_trash'=>esc_html__('No Marinas in Trash','boat-charter-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Marinas','boat-charter-booking-system')
				),	
				'public'=>false,
				'show_ui'=>true,
				'show_in_menu'=>'edit.php?post_type='.BCBSBooking::getCPTName(),
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>array('title','thumbnail')
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_bcbs_meta_box_marina',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_marina',esc_html__('Main','boat-charter-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		wp_enqueue_media();
		
		global $post;
		
		$Country=new BCBSCountry();
		$Payment=new BCBSPayment();
		$Boat=new BCBSBoat();
		$EmailAccount=new BCBSEmailAccount();
		$PaymentStripe=new BCBSPaymentStripe();
		
		$data=array();
		
		$data['meta']=BCBSPostMeta::getPostMeta($post);
		
		$data['nonce']=BCBSHelper::createNonceField(PLUGIN_BCBS_CONTEXT.'_meta_box_marina');
		
		$data['dictionary']['country']=$Country->getCountry();
		$data['dictionary']['payment']=$Payment->getPayment();
		$data['dictionary']['boat']=$Boat->getDictionary();
		
		$data['dictionary']['email_account']=$EmailAccount->getDictionary();
		
		$data['dictionary']['payment_stripe_method']=$PaymentStripe->getPaymentMethod();
		
		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/meta_box_marina.php');			
	}
	
	 /**************************************************************************/
	
	function adminCreateMetaBoxClass($class) 
	{
		array_push($class,'to-postbox-1');
		return($class);
	}

	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		$GeoLocation=new BCBSGeoLocation();		 
		
		BCBSHelper::setDefault($meta,'berth_number','');
		BCBSHelper::setDefault($meta,'boat_max_length','');
		BCBSHelper::setDefault($meta,'boat_max_draught','');
		
		BCBSHelper::setDefault($meta,'departure_period_from','0');
		BCBSHelper::setDefault($meta,'departure_period_to','');
		BCBSHelper::setDefault($meta,'departure_period_type',1);
		
		BCBSHelper::setDefault($meta,'boat_charter_day_count_min','');
		BCBSHelper::setDefault($meta,'boat_charter_day_count_max','');

		if(!array_key_exists('boat_charter_date',$meta))
			$meta['boat_charter_date']=array();		
		
		BCBSHelper::setDefault($meta,'booking_interval',0);

		BCBSHelper::setDefault($meta,'country_available',array(-1));
		BCBSHelper::setDefault($meta,'country_default',-1);
		
		BCBSHelper::setDefault($meta,'boat_id_default',-1);
		
		BCBSHelper::setDefault($meta,'boat_availability_check_type',array(2,3));
		
		BCBSHelper::setDefault($meta,'boat_unavailable_display_enable',0);
		BCBSHelper::setDefault($meta,'boat_all_unavailable_enable',0);
		
		BCBSHelper::setDefault($meta,'after_business_hour_departure_enable',0);
		BCBSHelper::setDefault($meta,'after_business_hour_return_enable',0);
		
		BCBSHelper::setDefault($meta,'date_departure_return_the_same_enable',0);
		
		/***/
		
		BCBSHelper::setDefault($meta,'address_street','');
		BCBSHelper::setDefault($meta,'address_street_number','');
		BCBSHelper::setDefault($meta,'address_postcode','');
		BCBSHelper::setDefault($meta,'address_city','');
		BCBSHelper::setDefault($meta,'address_state','');
		BCBSHelper::setDefault($meta,'address_country',$GeoLocation->getCountryCode());
	  
		BCBSHelper::setDefault($meta,'contact_detail_phone_number','');
		BCBSHelper::setDefault($meta,'contact_detail_fax_number','');
		BCBSHelper::setDefault($meta,'contact_detail_email_address','');
		
		BCBSHelper::setDefault($meta,'coordinate_latitude','');
		BCBSHelper::setDefault($meta,'coordinate_longitude','');
		
		/***/
		
		for($i=1;$i<8;$i++)
		{
			if(!isset($meta['business_hour'][$i]))
				$meta['business_hour'][$i]=array('start'=>null,'stop'=>null,'default'=>null,'break'=>null);
			
			if(!isset($meta['business_hour'][$i]['start']))
				$meta['business_hour'][$i]['start']=null;
			if(!isset($meta['business_hour'][$i]['stop']))
				$meta['business_hour'][$i]['stop']=null;
			if(!isset($meta['business_hour'][$i]['default']))
				$meta['business_hour'][$i]['default']=null;		
			if(!isset($meta['business_hour'][$i]['break']))
				$meta['business_hour'][$i]['break']=null;
		}	
		
		if(!array_key_exists('date_exclude',$meta))
			$meta['date_exclude']=array();
		
		/***/
		
		BCBSHelper::setDefault($meta,'payment_deposit_type',0);
		BCBSHelper::setDefault($meta,'payment_deposit_type_fixed_value',0.00);	
		BCBSHelper::setDefault($meta,'payment_deposit_type_percentage_value',0.00);		
		BCBSHelper::setDefault($meta,'payment_deposit_day_number_before_departure_date',0);
		
		BCBSHelper::setDefault($meta,'payment_mandatory_enable',0);
		BCBSHelper::setDefault($meta,'payment_processing_enable',1);
		BCBSHelper::setDefault($meta,'payment_woocommerce_step_3_enable',1);

		BCBSHelper::setDefault($meta,'payment_id',array(1));
		BCBSHelper::setDefault($meta,'payment_default_id',-1);
		
		BCBSHelper::setDefault($meta,'payment_cash_logo_src','');
		BCBSHelper::setDefault($meta,'payment_cash_info','');

		BCBSHelper::setDefault($meta,'payment_stripe_api_key_secret','');
		BCBSHelper::setDefault($meta,'payment_stripe_api_key_publishable','');
		BCBSHelper::setDefault($meta,'payment_stripe_method',array('card'));
		BCBSHelper::setDefault($meta,'payment_stripe_product_id','');
		BCBSHelper::setDefault($meta,'payment_stripe_redirect_duration','5');
		BCBSHelper::setDefault($meta,'payment_stripe_success_url_address','');
		BCBSHelper::setDefault($meta,'payment_stripe_cancel_url_address','');
		BCBSHelper::setDefault($meta,'payment_stripe_logo_src','');
		BCBSHelper::setDefault($meta,'payment_stripe_info','');
		
		BCBSHelper::setDefault($meta,'payment_paypal_email_address','');
		BCBSHelper::setDefault($meta,'payment_paypal_sandbox_mode_enable',0);
		BCBSHelper::setDefault($meta,'payment_paypal_redirect_duration','5');
		BCBSHelper::setDefault($meta,'payment_paypal_success_url_address','');
		BCBSHelper::setDefault($meta,'payment_paypal_cancel_url_address','');
		BCBSHelper::setDefault($meta,'payment_paypal_logo_src','');		
		BCBSHelper::setDefault($meta,'payment_paypal_info','');

		BCBSHelper::setDefault($meta,'payment_wire_transfer_logo_src','');
		BCBSHelper::setDefault($meta,'payment_wire_transfer_info','');
		
		/***/
		
		BCBSHelper::setDefault($meta,'booking_new_sender_email_account_id',-1);
		BCBSHelper::setDefault($meta,'booking_new_recipient_email_address','');
		BCBSHelper::setDefault($meta,'booking_new_customer_email_notification',1);
		BCBSHelper::setDefault($meta,'booking_new_customer_email_notification_after_payment',0);
		BCBSHelper::setDefault($meta,'booking_new_woocommerce_email_notification',0);
		
		BCBSHelper::setDefault($meta,'nexmo_sms_enable',0);
		BCBSHelper::setDefault($meta,'nexmo_sms_api_key','');
		BCBSHelper::setDefault($meta,'nexmo_sms_api_key_secret','');
		BCBSHelper::setDefault($meta,'nexmo_sms_sender_name','');
		BCBSHelper::setDefault($meta,'nexmo_sms_recipient_phone_number','');
		BCBSHelper::setDefault($meta,'nexmo_sms_message',esc_html__('New booking is received.','boat-charter-booking-system'));
		
		BCBSHelper::setDefault($meta,'twilio_sms_enable',0);
		BCBSHelper::setDefault($meta,'twilio_sms_api_sid','');
		BCBSHelper::setDefault($meta,'twilio_sms_api_token','');
		BCBSHelper::setDefault($meta,'twilio_sms_sender_phone_number','');
		BCBSHelper::setDefault($meta,'twilio_sms_recipient_phone_number','');
		BCBSHelper::setDefault($meta,'twilio_sms_message',esc_html__('New booking is received.','boat-charter-booking-system'));
		
		BCBSHelper::setDefault($meta,'telegram_enable',0);
		BCBSHelper::setDefault($meta,'telegram_token','');
		BCBSHelper::setDefault($meta,'telegram_group_id','');
		BCBSHelper::setDefault($meta,'telegram_message','');
		
		/***/
		
		BCBSHelper::setDefault($meta,'google_calendar_enable',0);
		BCBSHelper::setDefault($meta,'google_calendar_id','');
		BCBSHelper::setDefault($meta,'google_calendar_settings','');
		BCBSHelper::setDefault($meta,'google_calendar_server_reply_1','');
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(BCBSHelper::checkSavePost($postId,PLUGIN_BCBS_CONTEXT.'_meta_box_marina_noncename','savePost')===false) return(false);
				
		$Date=new BCBSDate();
		$Boat=new BCBSBoat();
		$Payment=new BCBSPayment();
		$Country=new BCBSCountry();
		$Validation=new BCBSValidation();
		$EmailAccount=new BCBSEmailAccount();
		$PaymentStripe=new BCBSPaymentStripe();
		
		$data=BCBSHelper::getPostOption();
		
		$dataIndex=array
		(
			'berth_number',
			'boat_max_length',
			'boat_max_draught',
			'departure_period_from',
			'departure_period_to',
			'departure_period_type',
			'boat_charter_day_count_min',
			'boat_charter_day_count_max',
			'boat_charter_date',			
			'booking_interval',
			'country_available',
			'country_default',
			'boat_id_default',
			'boat_availability_check_type',
			'boat_unavailable_display_enable',
			'boat_all_unavailable_enable',
			'after_business_hour_departure_enable',
			'after_business_hour_return_enable',
			'date_departure_return_the_same_enable',
			'address_street',
			'address_street_number',
			'address_postcode',
			'address_city',
			'address_state',
			'address_country',
			'contact_detail_phone_number',
			'contact_detail_fax_number',
			'contact_detail_email_address',
			'coordinate_latitude',
			'coordinate_longitude',
			'business_hour',
			'date_exclude',
			'payment_deposit_type',
			'payment_deposit_type_fixed_value',
			'payment_deposit_type_percentage_value',
			'payment_deposit_day_number_before_departure_date',			
			'payment_mandatory_enable',
			'payment_processing_enable',
			'payment_woocommerce_step_3_enable',
			'payment_default_id',
			'payment_id',
			'payment_cash_logo_src',
			'payment_cash_info',
			'payment_stripe_api_key_secret',
			'payment_stripe_api_key_publishable',
			'payment_stripe_method',
			'payment_stripe_product_id',
			'payment_stripe_redirect_duration',
			'payment_stripe_success_url_address',
			'payment_stripe_cancel_url_address',
			'payment_stripe_logo_src',
			'payment_stripe_info',
			'payment_paypal_email_address',
			'payment_paypal_redirect_duration',
			'payment_paypal_success_url_address',
			'payment_paypal_cancel_url_address',			
			'payment_paypal_sandbox_mode_enable',
			'payment_paypal_logo_src',
			'payment_paypal_info',	
			'payment_wire_transfer_logo_src',
			'payment_wire_transfer_info',
			'nexmo_sms_enable',
			'nexmo_sms_api_key',
			'nexmo_sms_api_key_secret',
			'nexmo_sms_sender_name',
			'nexmo_sms_recipient_phone_number',
			'nexmo_sms_message',
			'twilio_sms_enable',
			'twilio_sms_api_sid',
			'twilio_sms_api_token',
			'twilio_sms_sender_phone_number',
			'twilio_sms_recipient_phone_number',
			'twilio_sms_message',	
			'telegram_enable',
			'telegram_token',
			'telegram_group_id',
			'telegram_message',
			'booking_new_sender_email_account_id',
			'booking_new_recipient_email_address',
			'booking_new_woocommerce_email_notification',
			'booking_new_customer_email_notification',
			'booking_new_customer_email_notification_after_payment',
			'google_calendar_enable',
			'google_calendar_id',
			'google_calendar_settings'
		);
		
		if(!$Validation->isNumber($data['berth_number'],1,9999,true))
			$data['berth_number']='';
		if(!$Validation->isNumber($data['boat_max_length'],1,999,true))
			$data['boat_max_length']='';
		if(!$Validation->isNumber($data['boat_max_draught'],1,999,true))
			$data['boat_max_draught']='';		
					   
		if(!$Validation->isNumber($data['departure_period_from'],0,9999))
			$data['departure_period_from']='';		  
		if(!$Validation->isNumber($data['departure_period_to'],0,9999))
			$data['departure_period_to']='';
		if(!in_array($data['departure_period_type'],array(1,2,3)))
			$data['departure_period_type']=1;	
	  		
		if(!$Validation->isNumber($data['boat_charter_day_count_min'],1,9999))
			$data['boat_charter_day_count_min']='';		  
		if(!$Validation->isNumber($data['boat_charter_day_count_max'],1,9999))
			$data['boat_charter_day_count_max']='';		  
		
		if(($Validation->isNotEmpty($data['boat_charter_day_count_min'])) && ($Validation->isNotEmpty($data['boat_charter_day_count_max'])))
		{
			if($data['boat_charter_day_count_min']>$data['boat_charter_day_count_max'])
			{
				$data['boat_charter_day_count_min']='';
				$data['boat_charter_day_count_max']='';
			}
		}
			
		$boatCharterDate=array();
		$boatCharterDatePost=BCBSHelper::getPostValue('boat_charter_date');
	  
		$count=count($boatCharterDatePost['start']);
		
		for($i=0;$i<$count;$i++)
		{
			if(!$Validation->isDate($boatCharterDatePost['start'][$i])) continue;
			if(!$Validation->isDate($boatCharterDatePost['stop'][$i])) continue;

			if($Date->compareDate($boatCharterDatePost['start'][$i],$boatCharterDatePost['stop'][$i])==1) continue;
			if($Date->compareDate(date_i18n('d-m-Y'),$boatCharterDatePost['stop'][$i])==1) continue;
			
			if(!$Validation->isNumber($boatCharterDatePost['day_count_min'][$i],1,9999,true)) continue;
			if(!$Validation->isNumber($boatCharterDatePost['day_count_max'][$i],1,9999,true)) continue;
			
			if(($Validation->isEmpty($boatCharterDatePost['day_count_min'][$i])) && ($Validation->isEmpty($boatCharterDatePost['day_count_max'][$i]))) continue;
			
			if(($Validation->isNotEmpty($boatCharterDatePost['day_count_min'][$i])) && ($Validation->isNotEmpty($boatCharterDatePost['day_count_max'][$i])))
			{
				if($boatCharterDatePost['day_count_min'][$i]>$boatCharterDatePost['day_count_max'][$i]) continue;
			}
			
			$boatCharterDate[]=array
			(
				'start'=>$boatCharterDatePost['start'][$i],
				'stop'=>$boatCharterDatePost['stop'][$i],
				'day_count_min'=>$boatCharterDatePost['day_count_min'][$i],
				'day_count_max'=>$boatCharterDatePost['day_count_max'][$i]
			);
		}
		
		$data['boat_charter_date']=$boatCharterDate;
		
		if(!$Validation->isNumber($data['booking_interval'],0,9999))
			$data['booking_interval']=0;   	
		
		/***/
			
		if(is_array($data['country_available']))
		{
			if(in_array(-1,$data['country_available']))
				$data['country_available']=array(-1);
			else
			{
				foreach($data['country_available'] as $index=>$value)
				{
					if(!$Country->isCountry($value))
						unset($data['country_available'][$index]);
				}
			}
		}
			
		if((!is_array($data['country_available'])) || (!count($data['country_available'])))
			$data['country_available'][$index]=-1;		
	
		if(!$Country->isCountry($data['country_default']))
			$data['country_default']=-1;
		
		/***/
		
		$boat=$Boat->getDictionary();
		if(!array_key_exists($data['boat_id_default'],$boat))
			$data['boat_id_default']=-1;
		
		if(in_array(1,$data['boat_availability_check_type']))
			$data['boat_availability_check_type']=array(1);
		if(!$Validation->isBool($data['boat_unavailable_display_enable']))
			$data['boat_unavailable_display_enable']=0;  		
		if(!$Validation->isBool($data['boat_all_unavailable_enable']))
			$data['boat_all_unavailable_enable']=0;   
		
		if(!$Validation->isBool($data['after_business_hour_departure_enable']))
			$data['after_business_hour_departure_enable']=0;   
		if(!$Validation->isBool($data['after_business_hour_return_enable']))
			$data['after_business_hour_return_enable']=0;	
		if(!$Validation->isBool($data['date_departure_return_the_same_enable']))
			$data['date_departure_return_the_same_enable']=0;	
				
		/***/
		
		if(!$Country->isCountry($data['address_country']))
			$data['address_country']='US';	   
		if(!$Validation->isEmailAddress($data['contact_detail_email_address']))
			$data['contact_detail_email_address']='';
		
		/***/
		
		$businessHour=array();
		$businessHourPost=BCBSHelper::getPostValue('business_hour');
  
		foreach(array_keys($Date->day) as $index)
		{
			$businessHour[$index]=array('start'=>null,'stop'=>null,'default'=>null,'break'=>null);
			
			if((isset($businessHourPost[$index][0])) && (isset($businessHourPost[$index][1])))
			{
				if(($Validation->isTime($businessHourPost[$index][0],false)) && ($Validation->isTime($businessHourPost[$index][1],false)))
				{
					$result=$Date->compareTime($businessHourPost[$index][0],$businessHourPost[$index][1]);

					if($result==2)
					{
						$businessHour[$index]=array('start'=>$businessHourPost[$index][0],'stop'=>$businessHourPost[$index][1]);
					
						if(($Validation->isTime($businessHourPost[$index][2],false)))
						{
							$result=$Date->timeInRange($businessHourPost[$index][2],$businessHourPost[$index][0],$businessHourPost[$index][1]);
							if($result) $businessHour[$index]['default']=$businessHourPost[$index][2];
						}
						
						if($Validation->isNotEmpty($businessHourPost[$index][3]))
						{
							$breakHour=preg_split('/;/',$businessHourPost[$index][3]);
							
							foreach($breakHour as $breakHourValue)
							{
								list($start,$stop)=preg_split('/-/',$breakHourValue);
								
								if(($Validation->isTime($start)) && ($Validation->isTime($stop)))
								{
									$result=$Date->compareTime($start,$stop);
									if($result===2)
									{
										$businessHour[$index]['break'][]=array('start'=>$start,'stop'=>$stop);
									}
								}
							}
						}
					}
				}
			}
		}
				
		$data['business_hour']=$businessHour;
		
		/***/
		
		$dateExclude=array();
		$dateExcludePost=array();
		
		$dateExcludePostStart=BCBSHelper::getPostValue('date_exclude_start');
		$dateExcludePostStop=BCBSHelper::getPostValue('date_exclude_stop');
		
		foreach($dateExcludePostStart as $index=>$value)
		{
			if(isset($dateExcludePostStop[$index]))
				$dateExcludePost[]=array($dateExcludePostStart[$index],$dateExcludePostStop[$index]);
		}
	  
		foreach($dateExcludePost as $index=>$value)
		{
			if(!$Validation->isDate($value[0],true)) continue;
			if(!$Validation->isDate($value[1],true)) continue;

			if($Date->compareDate($value[0],$value[1])==1) continue;
			if($Date->compareDate(date_i18n('d-m-Y'),$value[1])==1) continue;
			
			$dateExclude[]=array('start'=>$value[0],'stop'=>$value[1]);
		}
		
		$data['date_exclude']=$dateExclude;
		
		/***/
		
		if(!in_array($data['payment_deposit_type'],array(0,1,2)))
			$data['payment_deposit_type']=0; 		
		if(!$Validation->isPrice($data['payment_deposit_type_fixed_value']))
			$data['payment_deposit_type_fixed_value']=0.00;			
		if(!$Validation->isFloat($data['payment_deposit_type_fixed_value'],0,100))
			$data['payment_deposit_type_percentage_value']=0; 	
		if(!$Validation->isNumber($data['payment_deposit_day_number_before_departure_date'],0,9999))
			$data['payment_deposit_day_number_before_departure_date']=0;		
		
		if(!$Validation->isBool($data['payment_mandatory_enable']))
			$data['payment_mandatory_enable']=0;	 
		if(!$Validation->isBool($data['payment_processing_enable']))
			$data['payment_processing_enable']=1; 
		if(!$Validation->isBool($data['payment_woocommerce_step_3_enable']))
			$data['payment_woocommerce_step_3_enable']=1; 		
		if(!$Payment->isPayment($data['payment_default_id']))
			$data['payment_default_id']=-1;
		
		if(!$Validation->isNumber($data['payment_paypal_redirect_duration'],-1,99))
			$data['payment_paypal_redirect_duration']=5;
		
		if(!$Validation->isNumber($data['payment_stripe_redirect_duration'],-1,99))
			$data['payment_stripe_redirect_duration']=5;	

		if(is_array($data['payment_stripe_method']))
		{
			foreach($data['payment_stripe_method'] as $index=>$value)
			{
				if(!$PaymentStripe->isPaymentMethod($value))
					unset($data['payment_stripe_method'][$index]);
			}
		}
			
		if((!is_array($data['payment_stripe_method'])) || (!count($data['payment_stripe_method'])))
			$data['payment_stripe_method']=array('card');
			
		foreach($data['payment_id'] as $index=>$value)
		{
			if($Payment->isPayment($value)) continue;
			unset($data['payment_id'][$value]);
		}
			 
		if(!$Validation->isBool($data['nexmo_sms_enable']))
			$data['nexmo_sms_enable']=0;
			   
		/***/
		
		if(!$Validation->isBool($data['twilio_sms_enable']))
			$data['twilio_sms_enable']=0;
				
		/***/
		
		if(!$Validation->isBool($data['telegram_enable']))
			$data['telegram_enable']=0;		
		
		/***/
		
		$dictionary=$EmailAccount->getDictionary();
		
		if(!array_key_exists($data['booking_new_sender_email_account_id'],$dictionary))
			$data['booking_new_sender_email_account_id']=-1;
		
		$recipient=preg_split('/;/',$data['booking_new_recipient_email_address']);
		
		$data['booking_new_recipient_email_address']='';
		
		foreach($recipient as $index=>$value)
		{
			if($Validation->isEmailAddress($value))
			{
				if($Validation->isNotEmpty($data['booking_new_recipient_email_address'])) $data['booking_new_recipient_email_address'].=';';
				$data['booking_new_recipient_email_address'].=$value;
			}
		} 
		
		if(!$Validation->isBool($data['booking_new_woocommerce_email_notification']))
			$data['booking_new_woocommerce_email_notification']=0;   
		if(!$Validation->isBool($data['booking_new_customer_email_notification']))
			$data['booking_new_customer_email_notification']=0;  
		if(!$Validation->isBool($data['booking_new_customer_email_notification_after_payment']))
			$data['booking_new_customer_email_notification_after_payment']=0;  		
		
		/***/
		
		$data['google_calendar_settings']=BCBSHelper::getPostValue('google_calendar_settings');
		
		if(!$Validation->isBool($data['google_calendar_enable']))
			$data['google_calendar_enable']=0;  
		
		/***/
		
		foreach($dataIndex as $index)
			BCBSPostMeta::updatePostMeta($postId,$index,$data[$index]); 
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'marina_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		BCBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('title'=>'asc')
		);
		
		if($attribute['marina_id'])
			$argument['p']=$attribute['marina_id'];

		$query=new WP_Query($argument);
		if($query===false) return($dictionary);
		
		while($query->have_posts())
		{
			$query->the_post();
			$dictionary[$post->ID]['post']=$post;
			$dictionary[$post->ID]['meta']=BCBSPostMeta::getPostMeta($post);
		}
		
		BCBSHelper::preservePost($post,$bPost,0);	
		
		return($dictionary);		
	}
	
	/**************************************************************************/
	
	function manageEditColumns($column)
	{
		$column=array
		(
			'cb'=>$column['cb'],
			'title'=>esc_html__('Title','boat-charter-booking-system')
		);
   
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{

	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function displayAddress($marinaId,$separator='<br>',$excludeColumn=array())
	{
		$html=null;
		
		$dictionary=$this->getDictionary(array('marina_id'=>$marinaId));
		if(!count($dictionary)) return($html);
		
		$marina=$dictionary[$marinaId];
		
		$data=array
		(
			'name'=>$marina['post']->post_title,
			'street'=>$marina['meta']['address_street'],
			'street_number'=>$marina['meta']['address_street_number'],
			'postcode'=>$marina['meta']['address_postcode'],
			'city'=>$marina['meta']['address_city'],
			'state'=>$marina['meta']['address_state'],
			'country'=>$marina['meta']['address_country']
		);
		
		foreach($excludeColumn as $value) unset($data[$value]);

		$html=BCBSHelper::displayAddress($data,$separator);
		
		return($html);
	}
	
	/**************************************************************************/
	
	function displayBusinessHour($marinaId)
	{
		$html=null;
		
		$Date=new BCBSDate();
		$Validation=new BCBSValidation();
		
		$dictionary=$this->getDictionary(array('marina_id'=>$marinaId));
		if(!count($dictionary)) return($html);
		
		$marina=$dictionary[$marinaId];		
		
		foreach($marina['meta']['business_hour'] as $index=>$value)
		{
			if(($Validation->isEmpty($value['start'])) || ($Validation->isEmpty($value['stop']))) continue;
			
			if($Validation->isNotEmpty($html)) $html.='<br>';
			
			$html.=esc_html($Date->getDayName($index).': '.$value['start'].' - '.$value['stop']);
		}
		
		return($html);
	}		
		
	/**************************************************************************/
	
	function getMarinaInfo()
	{		
		$marina=$this->getDictionary();
		if($marina===false) return(false);
		
		$Boat=new BCBSBoat();
		$boat=$Boat->getDictionary();
		
		$data=array();
		
		foreach($marina as $marinaIndex=>$marinaData)
		{
			$data[$marinaIndex]=array
			(
				'boat_count'=>0
			);
			
			foreach($boat as $boatData)
			{
				if(is_array($boatData['meta']['marina_id']))
				{
					if(in_array($marinaIndex,$boatData['meta']['marina_id']))
					{
						$data[$marinaIndex]['boat_count']++;
					}
				}
			}
		}
		
		return($data);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/