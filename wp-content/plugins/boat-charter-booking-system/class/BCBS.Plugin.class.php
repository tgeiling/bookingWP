<?php

/******************************************************************************/
/******************************************************************************/

class BCBSPlugin
{
	/**************************************************************************/
	
	private $optionDefault;
	private $libraryDefault;

	/**************************************************************************/	
	
	function __construct()
	{
		/***/
		
		$this->libraryDefault=array
		(
			'script'=>array
			(
				'use'=>1,
				'inc'=>true,
				'path'=>PLUGIN_BCBS_SCRIPT_URL,
				'file'=>'',
				'in_footer'=>true,
				'dependencies'=>array('jquery'),
			),
			'style'=>array
			(
				'use'=>1,
				'inc'=>true,
				'path'=>PLUGIN_BCBS_STYLE_URL,
				'file'=>'',
				'dependencies'=>array()
			)
		);
		
		/***/
		
		$this->optionDefault=array
		(
			'billing_type'=>2,
			'logo'=>'',
			'google_map_api_key'=>'',
			'google_map_duplicate_script_remove'=>'0',
			'currency'=>'USD',
			'date_format'=>'d-m-Y',
			'time_format'=>'G:i',
			'sender_default_email_account_id'=>'-1',
			'coupon_generate_count'=>'1',
			'coupon_generate_usage_limit'=>'1',
			'coupon_generate_discount_percentage'=>'0',
			'coupon_generate_discount_fixed'=>'0',
			'coupon_generate_active_date_start'=>'',
			'coupon_generate_active_date_stop'=>'',
			'attachment_woocommerce_email'=>'',
			'geolocation_server_id'=>'1',
			'geolocation_server_id_3_api_key'=>'',
			'email_report_status'=>'0',
			'email_report_sender_email_account_id'=>'-1',
			'email_report_recipient_email_address'=>'',
			'currency_exchange_rate'=>array(),
			'fixer_io_api_key'=>'',
			'run_code'=>BCBSHelper::createRandomString(),
			'booking_status_payment_success'=>'-1',
			'booking_status_synchronization'=>'1',
			'booking_status_nonblocking'=>array(3,6),
			'booking_status_sum_zero'=>'0'
		);
		
		/***/
	}
	
	/**************************************************************************/
	
	private function prepareLibrary()
	{
		$this->library=array
		(
			'script'=>array
				(
				'jquery-ui-core'=>array
				(
					'path'=>''
				),
				'jquery-ui-tabs'=>array
				(
					'use'=>3,
					'path'=>''
				),
				'jquery-ui-button'=>array
				(
					'path'=>''
				),
				'jquery-ui-slider'=>array
				(
					'path'=>''
				),
				'jquery-ui-selectmenu'=>array
				(
					'use'=>2,
					'path'=>''
				),
				'jquery-ui-sortable'=>array
				(
					'path'=>''
				),
				'jquery-ui-widget'=>array
				(
					'use'=>2,
					'path'=>''
				),
				'jquery-ui-datepicker'=>array
				(
					'use'=>3,
					'path'=>''
				),
				'jquery-colorpicker'=>array
				(
					'file'=>'jquery.colorpicker.js'
				),
				'jquery-actual'=>array
				(
					'use'=>2,
					'file'=>'jquery.actual.min.js'
				),
				'jquery-fileupload'=>array
				(
					'use'=>2,
					'file'=>'jquery.fileupload.js'
				),
				'jquery-timepicker'=>array
				(
					'use'=>3,
					'file'=>'jquery.timepicker.min.js'
				),
				'jquery-dropkick'=>array
				(
					'file'=>'jquery.dropkick.min.js'
				),
				'jquery-qtip'=>array
				(
					'use'=>3,
					'file'=>'jquery.qtip.min.js'
				),
				'jquery-blockUI'=>array
				(
					'file'=>'jquery.blockUI.js'
				),
				'resizesensor'=>array
				(
					'use'=>2,
					'file'=>'ResizeSensor.min.js'
				),				
				'jquery-theia-sticky-sidebar'=>array
				(
					'use'=>2,
					'file'=>'jquery.theia-sticky-sidebar.min.js'
				),
				'jquery-fancybox'=>array
				(
					'use'=>3,
					'file'=>'jquery.fancybox.js'
				),
				'jquery-fancybox-media' =>array
				(
					'use'=>3,
					'file'=>'jquery.fancybox-media.js'
				),
				'jquery-fancybox-buttons'=>array
				(
					'use'=>3,
					'file'=>'jquery.fancybox-buttons.js'
				),
				'jquery-table'=>array
				(
					'file'=>'jquery.table.js'
				),
				'jquery-infieldlabel'=>array
				(
					'file'=>'jquery.infieldlabel.min.js'
				),
				'jquery-scrollTo'=>array
				(
					'use'=>3,
					'file'=>'jquery.scrollTo.min.js'
				),
				'clipboard'=>array
				(
					'file'=>'clipboard.min.js'
				),
				'jquery-themeOption'=>array
				(
					'file'=>'jquery.themeOption.js'
				),
				'jquery-themeOptionElement'=>array
				(
					'file'=>'jquery.themeOptionElement.js'
				),
				'bcbs-helper'=>array
				(
					'use'=>3,
					'file'=>'BCBS.Helper.class.js'
				),
				'bcbs-admin'=>array
				(
					'file'=>'admin.js'
				),
				'bcbs-booking-form-admin'=>array
				(
					'use'=>1,
					'file'=>'jquery.BCBSBookingFormAdmin.js'
				),
				'bcbs-boat-availability-calendar'=>array
				(
					'use'=>2,
					'file'=>'jquery.BCBSBoatAvailabilityCalendar.js'
				),
				'bcbs-booking-form'=>array
				(
					'use'=>2,
					'file'=>'jquery.BCBSBookingForm.js'
				),				
				'google-map'=>array
				(
					'use'=>3,
					'path'=>'',
					'file'=>add_query_arg(array('key'=>urlencode(BCBSOption::getOption('google_map_api_key')),'callback'=>'Function.prototype','loading'=>'async','libraries'=>'places,drawing'),'//maps.google.com/maps/api/js'),
				)
			),
			'style'=>array
			(
				'google-font-admin'=>array
				(
					'use'=>1,
					'path'=>'',
					'file'=>add_query_arg(array('family'=>urlencode('Open Sans:300,300i,400,400i,600,600i,700,700i,800,800i'),'subset'=>urlencode('cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese')),'//fonts.googleapis.com/css')
				),
				'google-font-public'=>array
				(
					'use'=>2,
					'path'=>'',
					'file'=>add_query_arg(array('family'=>urlencode('Jost:600|Source Sans Pro:400,600|Lato:400'),'subset'=>urlencode('cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese')),'//fonts.googleapis.com/css'),
				),
				'jquery-ui'=>array
				(
					'use'=>3,
					'file'=>'jquery.ui.min.css',
				),
				'jquery-qtip'=>array
				(
					'use'=>3,
					'file'=>'jquery.qtip.min.css',
				),
				'jquery-dropkick'=>array
				(
					'file'=>'jquery.dropkick.css',
				),
				'jquery-dropkick-rtl'=>array
				(
					'inc'=>false,
					'file'=>'jquery.dropkick.rtl.css',
				),
				'jquery-colorpicker'=>array
				(
					'file'=>'jquery.colorpicker.css',
				),
				'jquery-timepicker'=>array
				(
					'use'=>3,
					'file'=>'jquery.timepicker.min.css',
				),
				'jquery-fancybox'=>array
				(
					'use'=>3,
					'file'=>'fancybox/jquery.fancybox.css'
				),
				'jquery-themeOption'=>array
				(
					'file'=>'jquery.themeOption.css'
				),
				'jquery-themeOption-rtl'=>array
				(
					'inc'=>false,
					'file'=>'jquery.themeOption.rtl.css',
				),
				'mfds-jquery-themeOption-overwrite'=>array
				(
					'file'=>'jquery.themeOption.overwrite.css'
				),
				'bcbs-public'=>array
				(
					'use'=>2,
					'file'=>'public.css'
				),
				'bcbs-public-rtl'=>array
				(
					'use'=>2,
					'inc'=>false,
					'file'=>'public.rtl.css'
				)
			)
		);		
	}	
	
	/**************************************************************************/
	
	private function addLibrary($type,$use)
	{
		$Validation=new BCBSValidation();
		
		if(BCBSFile::fileExist(BCBSFile::getMultisiteBlogCSS()))
		{
			$this->library['style']['bcbs-public-booking-form-']=array
			(
				'use'=>2,
				'path'=>'',
				'file'=>BCBSFile::getMultisiteBlogCSS('url')
			);
		}
		
		if($type==='script')
		{
			if($Validation->isEmpty(BCBSOption::getOption('google_map_api_key')))
			{
				unset($this->library['script']['google-map']);
			}
		}
		
		foreach($this->library[$type] as $index=>$value)
			$this->library[$type][$index]=array_merge($this->libraryDefault[$type],$value);
		
		foreach($this->library[$type] as $index=>$data)
		{
			if(!$data['inc']) continue;
			
			if($data['use']!=3)
			{
				if($data['use']!=$use) continue;
			}			
			
			if($type=='script')
			{
				wp_enqueue_script($index,$data['path'].$data['file'],$data['dependencies'],rand(1,10000),$data['in_footer']);
			}
			else 
			{
				wp_enqueue_style($index,$data['path'].$data['file'],$data['dependencies'],rand(1,10000));
			}
		}
	}
	
	/**************************************************************************/
	
	public function pluginActivation()
	{	
		BCBSOption::createOption();
		
		$optionSave=array();
		$optionCurrent=BCBSOption::getOptionObject();
			 
		foreach($this->optionDefault as $index=>$value)
		{
			if(!array_key_exists($index,$optionCurrent))
				$optionSave[$index]=$value;
		}
		
		$optionSave=array_merge((array)$optionSave,$optionCurrent);
		foreach($optionSave as $index=>$value)
		{
			if(!array_key_exists($index,$this->optionDefault))
				unset($optionSave[$index]);
		}
		
		BCBSOption::resetOption();
		BCBSOption::updateOption($optionSave);
		
		$BookingFormStyle=new BCBSBookingFormStyle();
		$BookingFormStyle->createCSSFile();
		
		$Validation=new BCBSValidation();
		
		$argument=array
		(
			'post_type'=>BCBSBoat::getCPTName(),
			'post_status'=>'any',
			'posts_per_page'=>-1
		);
		
		$query=new WP_Query($argument);
		if($query!==false)
		{
			while($query->have_posts())
			{
				$query->the_post();

				$price=get_post_meta(get_the_ID(),PLUGIN_BCBS_CONTEXT.'_price_rental_hour_value',true);
				
				if($Validation->isPrice($price)) continue;
				
				$meta=BCBSPostMeta::getPostMeta(get_the_ID());
				
				$data=array
				(
					'price_rental_hour_value'=>0.00,
					'price_rental_day_value'=>$meta['price_rental_value']
				);
				
				foreach($data as $index=>$value)
					BCBSPostMeta::updatePostMeta(get_the_ID(),$index,$value);
				
				BCBSPostMeta::removePostMeta(get_the_ID(),'price_rental_value');
			}
		} 
		
		$argument=array
		(
			'post_type'=>BCBSPriceRule::getCPTName(),
			'post_status'=>'any',
			'posts_per_page'=>-1
		);
		
		$query=new WP_Query($argument);
		if($query!==false)
		{
			while($query->have_posts())
			{
				$query->the_post();

				$price=get_post_meta(get_the_ID(),PLUGIN_BCBS_CONTEXT.'_price_rental_hour_value',true);
				
				if($Validation->isPrice($price)) continue;
				
				$meta=BCBSPostMeta::getPostMeta(get_the_ID());
				
				$data=array
				(
					'price_rental_hour_value'=>0.00,
					'price_rental_day_value'=>$meta['price_rental_value']
				);
				
				foreach($data as $index=>$value)
					BCBSPostMeta::updatePostMeta(get_the_ID(),$index,$value);
				
				BCBSPostMeta::removePostMeta(get_the_ID(),'price_rental_value');
			}
		} 
		
		$argument=array
		(
			'post_type'=>BCBSBooking::getCPTName(),
			'post_status'=>'any',
			'posts_per_page'=>-1
		);
		
		$query=new WP_Query($argument);
		if($query!==false)
		{
			while($query->have_posts())
			{
				$query->the_post();

				$price=get_post_meta(get_the_ID(),PLUGIN_BCBS_CONTEXT.'_price_rental_hour_value',true);
				
				if($Validation->isPrice($price)) continue;
				
				$meta=BCBSPostMeta::getPostMeta(get_the_ID());
				
				$data=array
				(
					'billing_type'=>2,
					'price_rental_hour_value'=>0.00,
					'price_rental_day_value'=>$meta['price_rental_value']
				);
				
				foreach($data as $index=>$value)
					BCBSPostMeta::updatePostMeta(get_the_ID(),$index,$value);
				
				BCBSPostMeta::removePostMeta(get_the_ID(),'price_rental_value');
			}
		} 
	}
	
	/**************************************************************************/
	
	public function pluginDeactivation()
	{

	}
	
	/**************************************************************************/
	
	public function init()
	{  
		$Booking=new BCBSBooking();
		$BookingForm=new BCBSBookingForm();
		$BookingExtra=new BCBSBookingExtra();
		
		$Boat=new BCBSBoat();
		$BoatAttribute=new BCBSBoatAttribute();
		$BoatAvailabilityCalendar=new BCBSBoatAvailabilityCalendar();
		
		$PriceRule=new BCBSPriceRule();
		$Marina=new BCBSMarina();
		
		$Coupon=new BCBSCoupon();
		
		$TaxRate=new BCBSTaxRate();
		$EmailAccount=new BCBSEmailAccount();
		
		$ExchangeRateProvider=new BCBSExchangeRateProvider();
		
		$LogManager=new BCBSLogManager();
		
		$PaymentStripe=new BCBSPaymentStripe();
		
		$Booking->init();
		$BookingForm->init();
		$BookingExtra->init();
		
		$Boat->init();
		$BoatAttribute->init();
		
		$PriceRule->init();
		
		$Marina->init();
		
		$Coupon->init();
		
		$TaxRate->init();
		$EmailAccount->init();
		
		add_filter('custom_menu_order',array($this,'adminCustomMenuOrder'));
		
		add_action('admin_init',array($this,'adminInit'));
		add_action('admin_menu',array($this,'adminMenu'));
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_option_page_save',array($this,'adminOptionPanelSave'));
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_go_to_step',array($BookingForm,'goToStep'));
		add_action('wp_ajax_nopriv_'.PLUGIN_BCBS_CONTEXT.'_go_to_step',array($BookingForm,'goToStep'));
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_file_upload',array($BookingForm,'fileUpload'));
		add_action('wp_ajax_nopriv_'.PLUGIN_BCBS_CONTEXT.'_file_upload',array($BookingForm,'fileUpload'));
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_boat_filter',array($BookingForm,'boatFilter'));
		add_action('wp_ajax_nopriv_'.PLUGIN_BCBS_CONTEXT.'_boat_filter',array($BookingForm,'boatFilter'));		
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_coupon_code_check',array($BookingForm,'checkCouponCode'));
		add_action('wp_ajax_nopriv_'.PLUGIN_BCBS_CONTEXT.'_coupon_code_check',array($BookingForm,'checkCouponCode'));  
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_option_page_import_demo',array($this,'importDemo'));
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_create_summary_price_element',array($BookingForm,'createSummaryPriceElementAjax'));
		add_action('wp_ajax_nopriv_'.PLUGIN_BCBS_CONTEXT.'_create_summary_price_element',array($BookingForm,'createSummaryPriceElementAjax'));
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_option_page_create_coupon_code',array($Coupon,'create'));
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_user_sign_in',array($BookingForm,'userSignIn'));
		add_action('wp_ajax_nopriv_'.PLUGIN_BCBS_CONTEXT.'_user_sign_in',array($BookingForm,'userSignIn'));  
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_option_page_import_exchange_rate',array($ExchangeRateProvider,'importExchangeRate'));
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_test_email_send',array($EmailAccount,'sendTestEmail'));
		
		add_action('wp_ajax_'.PLUGIN_BCBS_CONTEXT.'_boat_availability_calendar_ajax',array($BoatAvailabilityCalendar,'ajax'));
		add_action('wp_ajax_nopriv_'.PLUGIN_BCBS_CONTEXT.'_boat_availability_calendar_ajax',array($BoatAvailabilityCalendar,'ajax'));	
		
		add_action('admin_notices',array($this,'adminNotice'));
		
		add_action('wp_mail_failed',array($LogManager,'logWPMailError'));
		
		if((int)BCBSOption::getOption('google_map_duplicate_script_remove')===1)
			add_action('wp_print_scripts',array($this,'removeMultipleGoogleMap'),100);		
		
		add_theme_support('post-thumbnails');
		
		add_image_size(PLUGIN_BCBS_CONTEXT.'_boat',460,306); 
		
		if(!is_admin())
		{
			add_action('wp_enqueue_scripts',array($this,'publicInit'));
			add_action('wp_loaded',array($PaymentStripe,'receivePayment'));
		}
		
		add_shortcode(PLUGIN_BCBS_CONTEXT.'_boat_availability_calendar',array($BoatAvailabilityCalendar,'createBoatAvailabilityCalendarShortcode'));
		
		$WooCommerce=new BCBSWooCommerce();
		$WooCommerce->addAction();
	}
	
	/**************************************************************************/

	public function publicInit()
	{
		$this->prepareLibrary();
		
		if(is_rtl())
			$this->library['style']['bcbs-public-rtl']['inc']=true;
		
		$this->addLibrary('style',2);
		$this->addLibrary('script',2);
	}
	
	/**************************************************************************/
	
	public function adminInit()
	{
		$this->prepareLibrary();
		
		if(is_rtl())
		{
			$this->library['style']['jquery-themeOption-rtl']['inc']=true;
			$this->library['style']['jquery-dropkick-rtl']['inc']=true;
		}
		
		$this->addLibrary('style',1);
		$this->addLibrary('script',1);
		
		$data=array();
		
		$data['jqueryui_buttonset_enable']=(int)PLUGIN_BCBS_JQUERYUI_BUTTONSET_ENABLE;
		
		wp_localize_script('jquery-themeOption','bcbsData',array('l10n_print_after'=>'bcbsData='.json_encode($data).';'));
	}
	
	/**************************************************************************/
	
	public function adminMenu()
	{
		global $submenu;

		add_options_page(esc_html__('Boat Charter Booking System','boat-charter-booking-system'),__('Boat Charter<br>Booking System','boat-charter-booking-system'),'edit_theme_options',PLUGIN_BCBS_CONTEXT,array($this,'adminCreateOptionPage'));
		add_submenu_page('edit.php?post_type=bcbs_booking',esc_html__('Boat Types','boat-charter-booking-system'),esc_html__('Boat Types','boat-charter-booking-system'),'edit_themes', 'edit-tags.php?taxonomy='.BCBSBoat::getCPTCategoryName());
	}
	
	/**************************************************************************/
	
	public function adminCreateOptionPage()
	{
		$data=array();
		
		$Currency=new BCBSCurrency();
		$GeoLocation=new BCBSGeoLocation();
		$BillingType=new BCBSBillingType();
		$EmailAccount=new BCBSEmailAccount();
		$BookingStatus=new BCBSBookingStatus();
		$ExchangeRateProvider=new BCBSExchangeRateProvider();
		
		$data['option']=BCBSOption::getOptionObject();
		
		$data['dictionary']['currency']=$Currency->getCurrency();
		
		$data['dictionary']['billing_type']=$BillingType->getDictionary();
		$data['dictionary']['email_account']=$EmailAccount->getDictionary();
		
		$data['dictionary']['geolocation_server']=$GeoLocation->getServer();
		
		$data['dictionary']['exchange_rate_provider']=$ExchangeRateProvider->getProvider();
		
		$data['dictionary']['booking_status']=$BookingStatus->getBookingStatus();
		$data['dictionary']['booking_status_synchronization']=$BookingStatus->getBookingStatusSynchronization();
		
		wp_enqueue_media();
		
		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/option.php');	
	}
	
	/**************************************************************************/
	
	public function adminOptionPanelSave()
	{		
		$option=BCBSHelper::getPostOption();

		$response=array('global'=>array('error'=>1));

		$Notice=new BCBSNotice();
		$Currency=new BCBSCurrency();
		$Validation=new BCBSValidation();
		$BillingType=new BCBSBillingType();
		$BookingStatus=new BCBSBookingStatus();
		
		$invalidValue=esc_html__('This field includes invalid value.','boat-charter-booking-system');
		
		/* General */
		if(!$BillingType->isBillingType($option['billing_type']))
			$Notice->addError(BCBSHelper::getFormName('billing_type',false),$invalidValue);	
		if(!$Validation->isBool($option['google_map_duplicate_script_remove']))
			$Notice->addError(BCBSHelper::getFormName('google_map_duplicate_script_remove',false),$invalidValue);	
		if(!$Currency->isCurrency($option['currency']))
			$Notice->addError(BCBSHelper::getFormName('currency',false),$invalidValue);	
		if($Validation->isEmpty($option['date_format']))
			$Notice->addError(BCBSHelper::getFormName('date_format',false),$invalidValue);
		if($Validation->isEmpty($option['time_format']))
			$Notice->addError(BCBSHelper::getFormName('time_format',false),$invalidValue);		
		if(!$Validation->isBool($option['email_report_status']))
			$Notice->addError(BCBSHelper::getFormName('email_report_status',false),$invalidValue);
		
		if(is_array($option['booking_status_nonblocking']))
		{
			foreach($option['booking_status_nonblocking'] as $value)
			{
				if(!$BookingStatus->isBookingStatus($value))
				{
					$Notice->addError(BCBSHelper::getFormName('booking_status_nonblocking',false),$invalidValue);	
					break;
				}
			}
		}
		else $option['booking_status_nonblocking']=array();
		
		/* Payment */
		if((int)$option['booking_status_payment_success']!==-1)
		{
			if(!$BookingStatus->isBookingStatus($option['booking_status_payment_success']))
				$Notice->addError(BCBSHelper::getFormName('booking_status_payment_success',false),$invalidValue);	
		}
		if(!$Validation->isBool($option['booking_status_sum_zero']))
			$Notice->addError(BCBSHelper::getFormName('booking_status_sum_zero',false),$invalidValue);	
		if(!$BookingStatus->isBookingStatusSynchronization($option['booking_status_synchronization']))
			$Notice->addError(BCBSHelper::getFormName('booking_status_synchronization',false),$invalidValue);	
		
		/* Currency */
		foreach($option['currency_exchange_rate'] as $index=>$value)
		{
			if(!$Currency->isCurrency($index))
			{
				unset($option['currency_exchange_rate'][$index]);
				continue;
			}
			
			if(!$Validation->isFloat($option['currency_exchange_rate'][$index],0,999999999.99,false,5))
			{
				unset($option['currency_exchange_rate'][$index]);
				continue;				
			}
			
			$option['currency_exchange_rate'][$index]=preg_replace('/,/','.',$value);
		}
		
		if($Notice->isError())
		{
			$response['local']=$Notice->getError();
		}
		else
		{
			$response['global']['error']=0;
			BCBSOption::updateOption($option);
		}

		$response['global']['notice']=$Notice->createHTML(PLUGIN_BCBS_TEMPLATE_PATH.'notice.php');

		echo json_encode($response);
		exit;
	}
	
	/**************************************************************************/
	
	function importDemo()
	{
		$Demo=new BCBSDemo();
		$Notice=new BCBSNotice();
		$Validation=new BCBSValidation();
		
		$response=array('global'=>array('error'=>1));
		
		$buffer=$Demo->import();
		
		if($buffer!==false)
		{
			$response['global']['error']=0;
			$subtitle=esc_html__('Seems, that demo data has been imported. To make sure if this process has been successfully completed,please check below content of buffer returned by external applications.','boat-charter-booking-system');
		}
		else
		{
			$response['global']['error']=1;
			$subtitle=esc_html__('Dummy data cannot be imported.','boat-charter-booking-system');
		}
			
		$response['global']['notice']=$Notice->createHTML(PLUGIN_BCBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
		
		if($Validation->isNotEmpty($buffer))
		{
			$response['global']['notice'].=
			'
				<div class="to-buffer-output">
					'.$buffer.'
				</div>
			';
		}
		
		echo json_encode($response);
		exit;					
	}
	
	/**************************************************************************/
	
	function adminCustomMenuOrder()
	{
		global $submenu;

		$key='edit.php?post_type=bcbs_booking';
		
		if(array_key_exists($key,$submenu))
		{
			$menu=array();
			
			$menu[5]=$submenu[$key][5];
			$menu[11]=$submenu[$key][11];
			$menu[12]=$submenu[$key][12];
			$menu[13]=$submenu[$key][13];
			$menu[14]=$submenu[$key][20];
			$menu[15]=$submenu[$key][14];
			$menu[16]=$submenu[$key][15];
			$menu[17]=$submenu[$key][16];
			$menu[18]=$submenu[$key][17];
			$menu[19]=$submenu[$key][18];
			$menu[20]=$submenu[$key][19];
			
			$menu[14][2].='&post_type=bcbs_booking';
			
			$submenu[$key]=$menu;
		}
	}
	
	/**************************************************************************/
	
	function afterSetupTheme()
	{
		$Validation=new BCBSValidation();
		$VisualComposer=new BCBSVisualComposer();
		
		$VisualComposer->init();
		
		$runCode=BCBSOption::getOption('run_code');
		
		if($Validation->isNotEmpty($runCode))
		{
			if(BCBSHelper::getGetValue('run_code')==$runCode)
			{
				$ReportEmail=new BCBSReportEmail();
				$ReportEmail->send();
				die();
			}
		}
	}
	
	/**************************************************************************/
	
	function adminNotice()
	{
		$Validation=new BCBSValidation();
		
		if($Validation->isEmpty(BCBSOption::getOption('google_map_api_key')))
		{
			echo 
			'
				<div class="notice notice-error">
					<p>
						<b>'.esc_html__('Boat Charter Booking System','boat-charter-booking-system').'</b> '.sprintf(esc_html__('Please enter your Google Maps API key in %s.','boat-charter-booking-system'),'<a href="'.esc_url(admin_url('options-general.php?page=bcbs',false)).'">'.esc_html__('Plugin Options','boat-charter-booking-system').'</a>').'
					</p>
				</div>
			';
		}
	}
	
	/**************************************************************************/
	
	function removeMultipleGoogleMap()
	{
		global $wp_scripts;
		   
		foreach($wp_scripts->queue as $handle) 
		{
			if($handle=='bcbs-google-map') continue;
			
			$src=$wp_scripts->registered[$handle]->src;
			
			if(preg_match('/maps.google.com\/maps\/api\//',$src))
			{
				wp_dequeue_script($handle);
				wp_deregister_script($handle);	
			}
		}
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/