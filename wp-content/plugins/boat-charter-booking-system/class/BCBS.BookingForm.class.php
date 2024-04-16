<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBookingForm
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->fieldMandatory=array
		(
			'client_contact_detail_phone_number'=>array
			(
				'label'=>esc_html__('Phone number','boat-charter-booking-system'),
				'mandatory'=>0
			),
			'client_billing_detail_company_name'=>array
			(
				'label'=>esc_html__('Company registered name','boat-charter-booking-system'),
				'mandatory'=>0
			),
			'client_billing_detail_tax_number'=>array
			(
				'label'=>esc_html__('Tax number','boat-charter-booking-system'),
				'mandatory'=>0
			),
			'client_billing_detail_street_name'=>array
			(
				'label'=>esc_html__('Street name','boat-charter-booking-system'),
				'mandatory'=>1
			),
			'client_billing_detail_street_number'=>array
			(
				'label'=>esc_html__('Street number','boat-charter-booking-system'),
				'mandatory'=>0
			),
			'client_billing_detail_city'=>array
			(
				'label'=>esc_html__('City','boat-charter-booking-system'),
				'mandatory'=>1
			),
			'client_billing_detail_state'=>array
			(
				'label'=>esc_html__('State','boat-charter-booking-system'),
				'mandatory'=>0
			),
			'client_billing_detail_postal_code'=>array
			(
				'label'=>esc_html__('Postal code','boat-charter-booking-system'),
				'mandatory'=>1
			),
			'client_billing_detail_country_code'=>array
			(
				'label'=>esc_html__('Country','boat-charter-booking-system'),
				'mandatory'=>1
			)
		);
		
		$this->boatSortingType=array
		(
			1=>array(esc_html__('Price ascending','boat-charter-booking-system')),
			2=>array(esc_html__('Price descending','boat-charter-booking-system')),
			3=>array(esc_html__('Boat number ascending','boat-charter-booking-system')),
			4=>array(esc_html__('Boat number descending','boat-charter-booking-system')),
		);
	}
		
	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_BCBS_CONTEXT.'_booking_form');
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
					'name'=>esc_html__('Booking Forms','boat-charter-booking-system'),
					'singular_name'=>esc_html__('Booking Form','boat-charter-booking-system'),
					'add_new'=>esc_html__('Add New','boat-charter-booking-system'),
					'add_new_item'=>esc_html__('Add New Booking Form','boat-charter-booking-system'),
					'edit_item'=>esc_html__('Edit Booking Form','boat-charter-booking-system'),
					'new_item'=>esc_html__('New Booking Form','boat-charter-booking-system'),
					'all_items'=>esc_html__('Booking Forms','boat-charter-booking-system'),
					'view_item'=>esc_html__('View Booking Form','boat-charter-booking-system'),
					'search_items'=>esc_html__('Search Booking Forms','boat-charter-booking-system'),
					'not_found'=>esc_html__('No Booking Forms Found','boat-charter-booking-system'),
					'not_found_in_trash'=>esc_html__('No Booking Forms Found in Trash','boat-charter-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Booking Forms','boat-charter-booking-system')
				),	
				'public'=>false,
				'show_ui'=>true,
				'show_in_menu'=>'edit.php?post_type='.BCBSBooking::getCPTName(),
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>array('title')
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_bcbs_meta_box_booking_form',array($this,'adminCreateMetaBoxClass'));
		
		add_shortcode(PLUGIN_BCBS_CONTEXT.'_booking_form',array($this,'createBookingForm'));
		
		add_shortcode(PLUGIN_BCBS_CONTEXT.'_list_icon',array('BCBSBookingHelper','createListIcon'));
		add_shortcode(PLUGIN_BCBS_CONTEXT.'_list_icon_item',array('BCBSBookingHelper','createListIconItem'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}
	
	/**************************************************************************/
	
	static function getShortcodeName()
	{
		return(PLUGIN_BCBS_CONTEXT.'_booking_form');
	}
	
	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_booking_form',esc_html__('Main','boat-charter-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$Boat=new BCBSBoat();
		$Coupon=new BCBSCoupon();
		$Country=new BCBSCountry();
		$Marina=new BCBSMarina();
		$Currency=new BCBSCurrency();
		$GoogleMap=new BCBSGoogleMap();
		$BookingStatus=new BCBSBookingStatus();
		$BookingFormStyle=new BCBSBookingFormStyle();
		$BookingFormElement=new BCBSBookingFormElement();
		
		$data=array();
		
		$data['meta']=BCBSPostMeta::getPostMeta($post);
		
		$data['nonce']=BCBSHelper::createNonceField(PLUGIN_BCBS_CONTEXT.'_meta_box_booking_form');
		
		$data['dictionary']['color']=$BookingFormStyle->getColor();
		
		$data['dictionary']['marina']=$Marina->getDictionary();
		
		$data['dictionary']['country']=$Country->getCountry();
		
		$data['dictionary']['coupon']=$Coupon->getDictionary();
		
		$data['dictionary']['currency']=$Currency->getCurrency();
		
		$data['dictionary']['booking_status']=$BookingStatus->getBookingStatus();
		
		$data['dictionary']['form_element_panel']=$BookingFormElement->getPanel($data['meta']);
		
		$data['dictionary']['google_map']['position']=$GoogleMap->getPosition();
		$data['dictionary']['google_map']['map_type_control_id']=$GoogleMap->getMapTypeControlId();
		$data['dictionary']['google_map']['map_type_control_style']=$GoogleMap->getMapTypeControlStyle();
		
		$data['dictionary']['field_type']=$BookingFormElement->getFieldType();
		
		$data['dictionary']['field_mandatory']=$this->fieldMandatory;
		$data['dictionary']['boat_sorting_type']=$this->boatSortingType;
		
		$data['dictionary']['boat_captain_status']=$Boat->getCaptainStatus();
		
		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/meta_box_booking_form.php');			
	}
	
	/**************************************************************************/
	
	function adminCreateMetaBoxClass($class) 
	{
		array_push($class,'to-postbox-1');
		return($class);
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(BCBSHelper::checkSavePost($postId,PLUGIN_BCBS_CONTEXT.'_meta_box_booking_form_noncename','savePost')===false) return(false);
		
		$Boat=new BCBSBoat();
		$Coupon=new BCBSCoupon();
		$Marina=new BCBSMarina();
		$Currency=new BCBSCurrency();
		$GoogleMap=new BCBSGoogleMap();
		$Validation=new BCBSValidation();
		$BookingStatus=new BCBSBookingStatus();
		$BookingFormStyle=new BCBSBookingFormStyle();
		
		/***/
		
		$option=BCBSHelper::getPostOption();
		
		/***/
		
		if(!$BookingStatus->isBookingStatus($option['booking_status_id_default']))
			$option['booking_status_id_default']=1;
		
		if(!array_key_exists('geolocation_enable',$option))
			$option['geolocation_enable']=array();
		foreach($option['geolocation_enable'] as $index=>$value)
		{
			if(!in_array($value,array(1,2)))
				unset($option['geolocation_enable'][$index]);
		}
		if(!is_array($option['geolocation_enable']))
			$option['geolocation_enable']=array();		
		
		if(!$Validation->isBool($option['woocommerce_enable']))
			$option['woocommerce_enable']=0; 
		
		if(!in_array($option['woocommerce_account_enable_type'],array(0,1,2)))
			$option['woocommerce_account_enable_type']=1;	
		
		if(!array_key_exists($option['boat_sorting_type'],$this->boatSortingType))
			$option['boat_sorting_type']=1;		

		/***/
		
		$marinaDictionary=$Marina->getDictionary();
		if(is_array($option['marina_id']))
		{
			foreach($option['marina_id'] as $index=>$value)
			{
				if(!array_key_exists($value,$marinaDictionary))
					unset($option['marina_id'][$index]);
			}
		}
		if(is_array($option['marina_id']))
		{
			if(!count($option['marina_id']))
				$option['marina_id']=array(-1); 
		}
		else $option['marina_id']=array();
		
		if((!array_key_exists($option['marina_departure_default_id'],$marinaDictionary)) && ($option['marina_departure_default_id']!=-1))
			$option['marina_departure_default_id']=0;		
		
		if((!array_key_exists($option['marina_return_default_id'],$marinaDictionary)) && ($option['marina_return_default_id']!=-1))
			$option['marina_return_default_id']=0;		
		
		if(!in_array($option['marina_departure_list_status'],array(1,2)))
			$option['marina_departure_list_status']=1; 
		if(!in_array($option['marina_return_list_status'],array(1,2,3)))
			$option['marina_return_list_status']=3; 	
		
		/***/
		
		if((!is_array($option['marina_selection_mandatory'])) || (!count($option['marina_selection_mandatory'])))
			$option['marina_selection_mandatory']=array(1);
		
		if(in_array(1,$option['marina_selection_mandatory']))
			$option['marina_selection_mandatory']=array(1);
		else
		{
			foreach($option['marina_selection_mandatory'] as $index=>$value)
			{
				if(!in_array($value,array(2,3)))
					unset($option['marina_selection_mandatory'][$index]);
			}
		}
		
		if(!count($option['marina_selection_mandatory']))
			$option['marina_selection_mandatory']=array(1);		
		
		/***/
		
		$option['currency']=(array)$option['currency'];
		if(in_array(-1,$option['currency']))
		{
			$option['currency']=array(-1);
		}
		else
		{
			foreach($Currency->getCurrency() as $index=>$value)
			{
				if(!$Currency->isCurrency($index))
					unset($option['currency'][$index]);
			}
		}
		if(!count($option['currency']))
			$option['currency']=array(-1); 
		
		if(!$Validation->isBool($option['coupon_enable']))
			$option['coupon_enable']=0; 
		
		$couponDictionary=$Coupon->getDictionary();
		if(!array_key_exists($option['coupon_id'],$couponDictionary))
			$option['coupon_id']=-1;
		
		if(!$Validation->isPrice($option['order_value_minimum']))
			$option['order_value_minimum']=0.00;   
		$option['order_value_minimum']=BCBSPrice::formatToSave($option['order_value_minimum']);
	 
		if(!$Validation->isBool($option['booking_summary_hide_fee']))
			$option['booking_summary_hide_fee']=0;		 
		
		if(!$Validation->isBool($option['booking_summary_display_net_price']))
			$option['booking_summary_display_net_price']=0;   		

		/***/
		
	   if(!$Validation->isBool($option['captain_field_enable']))
			$option['captain_field_enable']=1;  
		
	   if(!$Boat->isCaptainStatus($option['captain_field_default_value']))
			$option['captain_field_default_value']=3;  
	   
		if(!$Validation->isBool($option['marina_departure_return_time_field_enable']))
			$option['marina_departure_return_time_field_enable']=0;  		
		
		if(!in_array($option['billing_detail_state'],array(1,2,3,4)))
			$option['billing_detail_state']=1;  
		
		if(!$Validation->isBool($option['thank_you_page_enable']))
			$option['thank_you_page_enable']=0;			
		
		if(!$Validation->isNumber($option['timepicker_step'],1,9999))
			$option['timepicker_step']=30;		   
		
		if(!$Validation->isBool($option['boat_count_enable']))
			$option['boat_count_enable']=0;
		
		if(!$Validation->isBool($option['summary_sidebar_sticky_enable']))
			$option['summary_sidebar_sticky_enable']=0;
		
		if(!$Validation->isBool($option['boat_filter_bar_enable']))
			$option['boat_filter_bar_enable']=0; 		
		
		if(!$Validation->isBool($option['scroll_to_booking_extra_after_select_boat_enable']))
			$option['scroll_to_booking_extra_after_select_boat_enable']=0; 
		
		$option['field_mandatory']=(array)$option['field_mandatory'];
		foreach($option['field_mandatory'] as $index=>$value)
		{
			if(!array_key_exists($value,$this->fieldMandatory))
				unset($option['field_mandatory'][$index]);
		}		
		
		if(!$Validation->isBool($option['form_preloader_enable']))
			$option['form_preloader_enable']=0;
		
		if(!$Validation->isBool($option['navigation_top_enable']))
			$option['navigation_top_enable']=0;
		
		$option['boat_attribute_enable']=(array)$option['boat_attribute_enable'];
		foreach($option['boat_attribute_enable'] as $index=>$value)
		{
			if(!in_array($value,array(1,2,3,4)))
				unset($option['boat_attribute_enable'][$index]);
		}
		if(!is_array($option['boat_attribute_enable']))
			$option['boat_attribute_enable']=array();		
		
		/***/
		
		foreach($option['style_color'] as $index=>$value)
		{
			if(!$BookingFormStyle->isColor($index))
			{
				unset($option['style_color'][$index]);
				continue;
			}
			
			if(!$Validation->isColor($value,true))
				$option['style_color'][$index]='';
		}
		
		/***/

		$FormElement=new BCBSBookingFormElement();
		$FormElement->save($postId);
		
		/***/
		
		if(!$Validation->isBool($option['google_map_enable']))
			$option['google_map_enable']=1;   		
		if(!$Validation->isBool($option['google_map_draggable_enable']))
			$option['google_map_draggable_enable']=1;		
		if(!$Validation->isBool($option['google_map_scrollwheel_enable']))
			$option['google_map_scrollwheel_enable']=1;			 

		if(!$Validation->isBool($option['google_map_map_type_control_enable']))
			$option['google_map_map_type_control_enable']=0;   
		if(!array_key_exists($option['google_map_map_type_control_id'],$GoogleMap->getMapTypeControlId()))
			$option['google_map_map_type_control_id']='SATELLITE';		
		if(!array_key_exists($option['google_map_map_type_control_style'],$GoogleMap->getMapTypeControlStyle()))
			$option['google_map_map_type_control_style']='DEFAULT';		 
		if(!array_key_exists($option['google_map_map_type_control_position'],$GoogleMap->getPosition()))
			$option['google_map_map_type_control_position']='TOP_CENTER';
		
		if(!$Validation->isBool($option['google_map_zoom_control_enable']))
			$option['google_map_zoom_control_enable']=0;   
		if(!array_key_exists($option['google_map_zoom_control_position'],$GoogleMap->getPosition()))
			$option['google_map_zoom_control_position']='TOP_CENTER';		
		if(!$Validation->isNumber($option['google_map_zoom_control_level'],1,21))
			$option['google_map_zoom_control_position']=6;   
		
		/***/
		
		$key=array
		(
			'booking_status_id_default',
			'geolocation_enable',
			'woocommerce_enable',
			'woocommerce_account_enable_type',		
			'boat_sorting_type', 
			'marina_id',
			'marina_departure_default_id',
			'marina_return_default_id',
			'marina_departure_list_status',
			'marina_return_list_status',
			'marina_selection_mandatory',
			'currency',
			'coupon_enable',
			'coupon_id',
			'order_value_minimum',
			'booking_summary_hide_fee',
			'booking_summary_display_net_price',
			'captain_field_enable',
			'captain_field_default_value',
			'marina_departure_return_time_field_enable',
			'billing_detail_state',
			'thank_you_page_enable',
			'thank_you_page_button_back_to_home_label',
			'thank_you_page_button_back_to_home_url_address',		
			'timepicker_step',
			'boat_count_enable',
			'summary_sidebar_sticky_enable',
			'boat_filter_bar_enable',
			'scroll_to_booking_extra_after_select_boat_enable',
			'field_mandatory',
			'form_preloader_enable', 
			'navigation_top_enable',
			'boat_attribute_enable',
			'style_color',
			'google_map_enable',
			'google_map_draggable_enable',
			'google_map_scrollwheel_enable',
			'google_map_map_type_control_enable',
			'google_map_map_type_control_id',
			'google_map_map_type_control_style',
			'google_map_map_type_control_position',
			'google_map_zoom_control_enable',
			'google_map_zoom_control_position',
			'google_map_zoom_control_level',	 
			'google_map_style'
		);

		foreach($key as $value)
			BCBSPostMeta::updatePostMeta($postId,$value,$option[$value]);
		
		$BookingFormStyle->createCSSFile();
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		BCBSHelper::setDefault($meta,'booking_status_id_default',1);
		BCBSHelper::setDefault($meta,'geolocation_enable',array());
		BCBSHelper::setDefault($meta,'woocommerce_enable',0);
		BCBSHelper::setDefault($meta,'woocommerce_account_enable_type',1);		
		BCBSHelper::setDefault($meta,'boat_sorting_type',1); 
		
		BCBSHelper::setDefault($meta,'marina_id',array());
		BCBSHelper::setDefault($meta,'marina_departure_default_id',0);
		BCBSHelper::setDefault($meta,'marina_return_default_id',0);
		BCBSHelper::setDefault($meta,'marina_departure_list_status',1);
		BCBSHelper::setDefault($meta,'marina_return_list_status',3);
		BCBSHelper::setDefault($meta,'marina_selection_mandatory',array(1));
		
		BCBSHelper::setDefault($meta,'currency',array(-1));
		BCBSHelper::setDefault($meta,'coupon_enable',0);
		BCBSHelper::setDefault($meta,'coupon_id',-1);
		BCBSHelper::setDefault($meta,'order_value_minimum',0.00);
		BCBSHelper::setDefault($meta,'booking_summary_hide_fee',0); 
		BCBSHelper::setDefault($meta,'booking_summary_display_net_price',0);		 
		
		BCBSHelper::setDefault($meta,'captain_field_enable',1);
		BCBSHelper::setDefault($meta,'captain_field_default_value',3);
		BCBSHelper::setDefault($meta,'marina_departure_return_time_field_enable',0);
		BCBSHelper::setDefault($meta,'billing_detail_state',1);
		BCBSHelper::setDefault($meta,'thank_you_page_enable',1);
		BCBSHelper::setDefault($meta,'thank_you_page_button_back_to_home_label',esc_html__('Back To Home','boat-charter-booking-system'));
		BCBSHelper::setDefault($meta,'thank_you_page_button_back_to_home_url_address','');		
		BCBSHelper::setDefault($meta,'timepicker_step',30);
		BCBSHelper::setDefault($meta,'boat_count_enable',1);
		BCBSHelper::setDefault($meta,'summary_sidebar_sticky_enable',0);
		BCBSHelper::setDefault($meta,'boat_filter_bar_enable',1);
		BCBSHelper::setDefault($meta,'scroll_to_booking_extra_after_select_boat_enable',0);

		$fieldMandatory=array();
		foreach($this->fieldMandatory as $index=>$value)
		{
			if((int)$value['mandatory']===1)
				$fieldMandatory[]=$index;
		}
		BCBSHelper::setDefault($meta,'field_mandatory',$fieldMandatory);
		
		BCBSHelper::setDefault($meta,'form_preloader_enable',1); 
		BCBSHelper::setDefault($meta,'navigation_top_enable',1);	
		BCBSHelper::setDefault($meta,'boat_attribute_enable',array(1,2,3,4));

		$BookingFormStyle=new BCBSBookingFormStyle();
		BCBSHelper::setDefault($meta,'style_color',array_fill(1,count($BookingFormStyle->getColor()),'')); 
		
		BCBSHelper::setDefault($meta,'google_map_enable',1);
		BCBSHelper::setDefault($meta,'google_map_draggable_enable',1);
		BCBSHelper::setDefault($meta,'google_map_scrollwheel_enable',1);
		BCBSHelper::setDefault($meta,'google_map_map_type_control_enable',0);
		BCBSHelper::setDefault($meta,'google_map_map_type_control_id','SATELLITE');
		BCBSHelper::setDefault($meta,'google_map_map_type_control_style','DEFAULT');
		BCBSHelper::setDefault($meta,'google_map_map_type_control_position','TOP_CENTER');
		BCBSHelper::setDefault($meta,'google_map_zoom_control_enable',0);
		BCBSHelper::setDefault($meta,'google_map_zoom_control_position','TOP_CENTER');
		BCBSHelper::setDefault($meta,'google_map_zoom_control_level',6);
		
		BCBSHelper::setDefault($meta,'google_map_style','');
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'booking_form_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		BCBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc'),
			'suppress_filters'=>true
		);
		
		if($attribute['booking_form_id'])
			$argument['p']=$attribute['booking_form_id'];
		
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
	
	function createBookingForm($attr)
	{
		$Marina=new BCBSMarina();
		$TaxRate=new BCBSTaxRate();
		$Validation=new BCBSValidation();
		$PaymentPaypal=new BCBSPaymentPaypal();
		$BookingFormStyle=new BCBSBookingFormStyle();
		
		$action=BCBSHelper::getGetValue('action',false);
		if($action==='ipn')
		{
			$PaymentPaypal->handleIPN();
			return(null);
		}
		
		$default=array
		(
			'boat_id'=>0,
			'boat_id_only'=>0,
			'booking_form_id'=>0,
			'currency'=>'',
			'widget_mode'=>0,
			'widget_booking_form_url'=>'',
			'widget_booking_form_style_id'=>1
		);
		
		$data=array();
		
		$attribute=shortcode_atts($default,$attr);		
		
		/***/
		
		if(!is_array($data=$this->checkBookingForm($attribute['booking_form_id'],$attribute['currency'],true,$attribute['boat_id'],$attribute['boat_id_only']))) return;
		
		$data['ajax_url']=admin_url('admin-ajax.php');
		
		$data['booking_form_post_id']=$attribute['booking_form_id'];
		$data['booking_form_html_id']=BCBSHelper::createId('bcbs_booking_form');
	   
		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
		
		$data['marina_info']=$Marina->getMarinaInfo();
		
		$color=$BookingFormStyle->getColor();
		
		foreach($color as $index=>$value)
		{
			$data['booking_form_color'][$index]=$data['meta']['style_color'][$index];
			if($Validation->isEmpty($data['booking_form_color'][$index])) $data['booking_form_color'][$index]=$value['color'];
		}
		
		$data['widget_mode']=(int)$attribute['widget_mode'];
		$data['widget_booking_form_url']=$attribute['widget_booking_form_url'];
		$data['widget_booking_form_style_id']=$attribute['widget_booking_form_style_id'];
		
		/***/
		
		$data['google_map_enable']=((int)$data['meta']['google_map_enable']===1) && ($Validation->isNotEmpty(BCBSOption::getOption('google_map_api_key')));
		
		/***/
		
		$data['marina_departure_field_enable']=$data['meta']['marina_departure_list_status'];
		if((int)$data['marina_departure_field_enable']===2)
		{
			if(array_key_exists($data['meta']['marina_departure_default_id'],$data['dictionary']['marina']))
				$data['marina_departure_field_enable']=0;
		}
		
		/***/		
		
		$data['marina_return_field_enable']=$data['meta']['marina_return_list_status'];
		if((int)$data['marina_return_field_enable']===2)
		{
			if(array_key_exists($data['meta']['marina_return_default_id'],$data['dictionary']['marina']))
				$data['marina_return_field_enable']=0;
		}				
		if((int)$data['marina_return_field_enable']===3)
			$data['marina_return_field_enable']=0;
			
		/**/
		
		$data['boat_guest_range']=$this->getFilterBoatGuest();
		
		/***/
		
		if(!array_key_exists($data['boat_id'],$data['dictionary']['boat'])) $data['boat_id']=0;
		
		/***/
		
		$Template=new BCBSTemplate($data,PLUGIN_BCBS_TEMPLATE_PATH.'public/public.php');
		return($Template->output());
	}
	
	/**************************************************************************/ 
	
	function getFilterBoatGuest()
	{
		$range=array();
		
		$Boat=new BCBSBoat();
		$boat=$Boat->getDictionary();
		
		foreach($boat as $value)
		{
			array_push($range,$value['meta']['guest_number']);
		}
		
		return(array('min'=>min($range),'max'=>max($range)));	  
	}
	
	/**************************************************************************/
	
	function bookingFormDisplayError($message,$displayError)
	{
		if(!$displayError) return;
		echo '<div class="bcbs-booking-form-error">'.esc_html($message).'</div>';
	}
	
	/**************************************************************************/
	
	function checkBookingForm($bookingFormId,$currency=null,$displayError=false,$boatId=0,$boatIdOnly=0)
	{
		$data=array();	  
		
		$Boat=new BCBSBoat();
		$Marina=new BCBSMarina();
		$Validation=new BCBSValidation();
		$GeoLocation=new BCBSGeoLocation();
		$WooCommerce=new BCBSWooCommerce();
		
		/***/
		
		if(BCBSHelper::getGetValue('boat_id_only',false)!==null)
			$boatIdOnly=BCBSHelper::getGetValue('boat_id_only',false);
		else if(BCBSHelper::getPostValue('boat_id_only',true)!==null)
			$boatIdOnly=BCBSHelper::getPostValue('boat_id_only',true);	
		
		/***/
		
		if(BCBSHelper::getGetValue('boat_id',false)!==null)
			$boatId=BCBSHelper::getGetValue('boat_id',false);
		else if(BCBSHelper::getPostValue('boat_id',true)!==null)
			$boatId=BCBSHelper::getPostValue('boat_id',true);	
		
		/***/
	   
		$data['boat_id']=(int)$boatId;
		$data['boat_id_only']=(int)$boatIdOnly;
		
		$bookingForm=$this->getDictionary(array('booking_form_id'=>$bookingFormId));
		if(!count($bookingForm)) 
		{
			$this->bookingFormDisplayError(esc_html__('Booking form with provided ID doesn\'t exist.','boat-charter-booking-form'),$displayError);
			return(-1);
		}
		
		$data['post']=$bookingForm[$bookingFormId]['post'];
		$data['meta']=$bookingForm[$bookingFormId]['meta'];
	   
		/****/		
		
		$data['dictionary']['marina']=$this->getBookingFormMarina($data['meta']);
		if(!count($data['dictionary']['marina'])) 
		{
			$this->bookingFormDisplayError(esc_html__('Plugin cannot find marina. Please make sure that you created at least one marina and set coordinates for it.','boat-charter-booking-form'),$displayError);
			return(-2);
		}
					
		list($departureMarinaId)=$this->getBookingFormMarinaDeparture($data);

		/****/
		
		$data['dictionary']['boat_unavailable']=array();
		
		$data['dictionary']['boat']=$this->getBookingFormBoat($data,true,true,$data['dictionary']['boat_unavailable'],$boatId,$boatIdOnly);
		if(!count($data['dictionary']['boat'])) 
		{
			$this->bookingFormDisplayError(esc_html__('Plugin cannot find at least one boat. Please make sure created at least one boat and assigned it to the at least one marina.','boat-charter-booking-form'),$displayError);
			return(-3);
		}
		
		/***/
		
		$data['dictionary']['payment']=array();
		$data['dictionary']['payment_woocommerce']=array();
		
		if($WooCommerce->isEnable($data['meta']))
		{
			if((int)$data['dictionary']['marina'][$departureMarinaId]['meta']['payment_woocommerce_step_3_enable']===1)
				$data['dictionary']['payment_woocommerce']=$WooCommerce->getPaymentDictionary();
		}
		else 
		{
			$data['dictionary']['payment']=$this->getBookingFormPayment($data['dictionary']['marina'][$departureMarinaId]['meta']);
		}
		
		/***/
		
		if($Validation->isEmpty($currency))
			$currency=BCBSHelper::getGetValue('currency',false);
		
		if(in_array($currency,$data['meta']['currency']))
			$data['currency']=$currency;
		else $data['currency']=BCBSOption::getOption('currency');
		
		/***/
		
		$data['dictionary']['booking_extra']=$this->getBookingFormExtra($departureMarinaId);
		$data['dictionary']['boat_category']=$this->getBookingFormBoatCategory();
		
		/***/
				
		if(in_array(2,$data['meta']['geolocation_enable']))
			$data['client_coordinate']=$GeoLocation->getCoordinate();
		else $data['client_coordinate']=array('lat'=>0,'lng'=>0);
		
		/****/
		
		$Date=new BCBSDate();
		$TaxRate=new BCBSTaxRate();
		$Country=new BCBSCountry();
		$PriceRule=new BCBSPriceRule();
		
		$data['dictionary']['country']=$Country->getCountry();
		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
		$data['dictionary']['price_rule']=$PriceRule->getDictionary();
		$data['dictionary']['captain_status']=$Boat->getCaptainStatus();
		 
		$countryCode=$GeoLocation->getCountryCode();
		
		foreach($data['dictionary']['marina'] as $index=>$value)
		{
			foreach($value['meta']['business_hour'] as $businessHourIndex=>$businessHourValue)
			{
				if($Validation->isTime($businessHourValue['default']))
				{
					$date=date_i18n('d-m-Y G:i',strtotime('01-01-1970 '.$businessHourValue['default'].'+'.(int)$data['meta']['timepicker_step'].' minutes'));
					$value['meta']['business_hour'][$businessHourIndex]['default_timepicker']=date_i18n('H:i',strtotime($date));
					
					if($Date->compareDate(date_i18n('d-m-Y',strtotime($date)),date_i18n('d-m-Y',strtotime('01-01-1970')))===1)
						$value['meta']['business_hour'][$businessHourIndex]['default_timepicker']=$businessHourValue['default'];
				}
				
				if((is_array($businessHourValue['break']) && (count($businessHourValue['break']))))
				{
					foreach($businessHourValue['break'] as $breakIndex=>$breakValue)
						$value['meta']['business_hour'][$businessHourIndex]['break'][$breakIndex]['stop']=date_i18n('H:i',strtotime('01-01-1970 '.$breakValue['stop'].' + 1 minutes')); 
				}
			}
			
			$data['marina_boat_id_default'][$index]=$value['meta']['boat_id_default'];
			
			$data['marina_date_exclude'][$index]=$value['meta']['date_exclude'];
			$data['marina_business_hour'][$index]=$value['meta']['business_hour'];
			
			$data['marina_after_business_hour_departure_enable'][$index]=$value['meta']['after_business_hour_departure_enable'];
			$data['marina_after_business_hour_return_enable'][$index]=$value['meta']['after_business_hour_return_enable'];	
			
			$data['marina_date_departure_return_the_same_enable'][$index]=$value['meta']['date_departure_return_the_same_enable'];	

			$data['marina_departure_period'][$index]=$this->getBookingFormMarinaDeparturePeriod($value['meta']);
			
			$data['marina_payment_paypal_redirect_duration'][$index]=$value['meta']['payment_paypal_redirect_duration'];
			
			if(($Validation->isNotEmpty($value['meta']['coordinate_latitude'])) && ($Validation->isNotEmpty($value['meta']['coordinate_longitude'])))
				$data['marina_coordinate'][$index]=array('lat'=>$value['meta']['coordinate_latitude'],'lng'=>$value['meta']['coordinate_longitude']);
			
			if($value['meta']['country_default']=='-1')
			{
				if((int)$data['meta']['geolocation_enable']===1)
					$data['marina_client_country_default'][$index]=$countryCode;
			}
			else $data['marina_client_country_default'][$index]=$value['meta']['country_default'];
		}
		
		/****/
		
		$data['step']=array();
		
		$data['step']['dictionary']=array
		(
			1=>array
			(
				'navigation'=>array
				(
					'number'=>esc_html__('1','boat-charter-booking-system'),
					'label'=>esc_html__('Charter Details','boat-charter-booking-system'),
				),
				'button'=>array
				(
					'next'=>esc_html__('Search for Boat','boat-charter-booking-system')
				)
			),
			2=>array
			(
				'navigation'=>array
				(
					'number'=>esc_html__('2','boat-charter-booking-system'),
					'label'=>esc_html__('Search for Boat','boat-charter-booking-system')
				),
				'button'=>array
				(
					'prev'=>esc_html__('Charter Details','boat-charter-booking-system'),
					'next'=>esc_html__('Customer Details','boat-charter-booking-system')
				)
			),
			3=>array
			(
				'navigation'=>array
				(
					'number'=>esc_html__('3','boat-charter-booking-system'),
					'label'=>esc_html__('Customer Details','boat-charter-booking-system')
				),
				'button'=>array
				(
					'prev'=>esc_html__('Search for Boat','boat-charter-booking-system'),
					'next'=>esc_html__('Booking Summary','boat-charter-booking-system')
				)
			),
			4=>array
			(
				'navigation'=>array
				(
					'number'=>esc_html__('4','boat-charter-booking-system'),
					'label'=>esc_html__('Booking Summary','boat-charter-booking-system')
				),
				'button'=>array
				(
					'prev'=>esc_html__('Customer Details','boat-charter-booking-system'),
					'next'=>esc_html__('Book Now','boat-charter-booking-system')
				)
			)
		);
		
		list($data['marina_departure_id'],,)=$this->getBookingFormMarinaDeparture($data);
		list($data['marina_return_id'],,)=$this->getBookingFormMarinaReturn($data);
		
		/***/
		
		$data['marina_selected_name']=$data['dictionary']['marina'][$data['marina_departure_id']]['post']->post_title;
		$data['marina_selected_address']=$Marina->displayAddress($data['marina_departure_id'],', ',array('name'));
		
		/***/
		
		$data['captain_status_selected']=BCBSRequest::get('captain_status');
		
		if(!$Boat->isCaptainStatus($data['captain_status_selected']))
			$data['captain_status_selected']=$data['meta']['captain_field_default_value'];
		if(!$Boat->isCaptainStatus($data['captain_status_selected']))
			$data['captain_status_selected']=3;
			
		
		/***/
		
		return($data);
	}
	
	/**************************************************************************/
	
   function getBookingFormBoatCategory()
	{
		$Boat=new BCBSBoat();
		$dictionary=$Boat->getCategory();
	 
		return($dictionary);
	}
	
	/**************************************************************************/
	
	function getBookingFormMarina($meta)
	{
		$Marina=new BCBSMarina();
		$Validation=new BCBSValidation();
		
		$dictionary=$Marina->getDictionary();
		
		foreach($dictionary as $index=>$value)
		{
			if(!in_array($index,$meta['marina_id']))
				unset($dictionary[$index]);
			
			if(array_key_exists($index,$dictionary))
			{
				if(($Validation->isEmpty($dictionary[$index]['meta']['coordinate_latitude'])) || ($Validation->isEmpty($dictionary[$index]['meta']['coordinate_longitude'])))
				{
					unset($dictionary[$index]);
				}
			}
		}
		
		return($dictionary);
	}
	   
	/**************************************************************************/
	
	function getBookingFormMarinaDeparture($bookingForm)
	{
		$option=BCBSHelper::getPostOption();
		
		$marinaId=0;

		if((int)$bookingForm['meta']['marina_departure_list_status']===1)
		{
			if(array_key_exists('marina_departure_id',$option))
				$marinaId=(int)$option['marina_departure_id'];	
			else $marinaId=(int)$bookingForm['meta']['marina_departure_default_id'];
		}
		else if((int)$bookingForm['meta']['marina_departure_list_status']===2)
		{
			$marinaId=(int)$bookingForm['meta']['marina_departure_default_id'];
		}
		
		if(!in_array($marinaId,$bookingForm['meta']['marina_id']))
		{
			$marinaId=key($bookingForm['meta']['marina_id']);
		}	
		
		if(!array_key_exists($marinaId,$bookingForm['dictionary']['marina']))
		{
			$marinaId=key($bookingForm['dictionary']['marina']);
		}
		
		return([$marinaId]);
	}
	
	/**************************************************************************/
	
	function getBookingFormMarinaReturn($bookingForm)
	{
		$option=BCBSHelper::getPostOption();
		
		$marinaId=0;

		if((int)$bookingForm['meta']['marina_return_list_status']===1)
		{
			if(array_key_exists('marina_return_id',$option))
				$marinaId=(int)$option['marina_return_id'];	
			else $marinaId=(int)$bookingForm['meta']['marina_return_default_id'];
		}
		else if((int)$bookingForm['meta']['marina_return_list_status']===2)
		{
			$marinaId=(int)$bookingForm['meta']['marina_return_default_id'];
		}
		else if((int)$bookingForm['meta']['marina_return_list_status']===3)
		{
			list($marinaId)=$this->getBookingFormMarinaDeparture($bookingForm);
		}
		
		if(!in_array($marinaId,$bookingForm['meta']['marina_id']))
		{
			$marinaId=key($bookingForm['meta']['marina_id']);
		}		
		
		if(!array_key_exists($marinaId,$bookingForm['dictionary']['marina']))
		{
			$marinaId=key($bookingForm['dictionary']['marina']);
		}
		
		return([$marinaId]);
	}
	
	/**************************************************************************/
	
	function getBookingFormExtra($marinaDepartureId)
	{
		$BookingExtra=new BCBSBookingExtra();
	
		$dictionary=$BookingExtra->getDictionary();
	   	
		foreach($dictionary as $index=>$value)
		{
			if((array_key_exists('marina',$value['meta'])) && (is_array($value['meta']['marina'])))
			{
				if(!array_key_exists($marinaDepartureId,$value['meta']['marina']))
					unset($dictionary[$index]);
			}
		}
   
		return($dictionary);		
	}
	
	/**************************************************************************/
	
	function getBookingFormBoat($bookingForm,$checkMarinaDeparture=true,$checkMarinaReturn=true,&$boatUnavailable=array(),$boatId=-1,$boatIdOnly=0)
	{
		$Date=new BCBSDate();
		$Boat=new BCBSBoat();
		$Validation=new BCBSValidation();
		
		$data=BCBSHelper::getPostOption();
		
		BCBSHelper::removeUIndex($data,'marina_departure_id','marina_return_id','departure_date','departure_time','return_date','return_time');
		
		list($marinaDepartureId)=$this->getBookingFormMarinaDeparture($bookingForm);
		list($marinaReturnId)=$this->getBookingFormMarinaReturn($bookingForm);
		
		$boat=$Boat->getDictionary(array(),$bookingForm['meta']['boat_sorting_type']);
		
		/***/
		
		if((int)$boatIdOnly===1)
		{
			foreach($boat as $index=>$value)
			{
				if((int)$boatId!==(int)$index)
				{
					unset($boat[$index]);
				}
			}
		}
		
		/***/
		
		foreach($boat as $index=>$value)
		{
			if(!is_array($value['meta']['marina_id'])) continue;
			
			if(!BCBSBookingFormHelper::isAllMarinaSelected($bookingForm,'departure'))
			{				
				if($checkMarinaDeparture)
				{
					if(!in_array($marinaDepartureId,$value['meta']['marina_id']))
						unset($boat[$index]);
				}
			}
			
			if(!BCBSBookingFormHelper::isAllMarinaSelected($bookingForm,'return'))
			{				
				if($checkMarinaReturn)
				{
					if(!in_array($marinaReturnId,$value['meta']['marina_id']))
						unset($boat[$index]);
				}
			}
		}	
		
		$boatRemove=array();

		$departureDate=$Date->formatDateToStandard($data['departure_date']);
		$departureTime=$Date->formatTimeToStandard($data['departure_time']);		
		$returnDate=$Date->formatDateToStandard($data['return_date']);
		$returnTime=$Date->formatTimeToStandard($data['return_time']); 
		
		$boat=$Boat->checkAvailability($bookingForm,$boat,$departureDate,$departureTime,$returnDate,$returnTime,$marinaDepartureId,$boatRemove);
		
		if((int)$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['boat_all_unavailable_enable']===1)
		{
			if((isset($boatRemove[3])) && (count($boatRemove[3])))
			{
				$boat=array();
			}
		}
		
		if((int)$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['boat_unavailable_display_enable']===1)
		{
			$boatUnavailable=$boatRemove[4];	
		}
				
		/***/
		
		$groupCode=array();
		
		foreach($boat as $index=>$value)
		{
			$code=$value['meta']['group_code'];
			
			if($Validation->isNotEmpty($code))
			{
				if(!isset($groupCode[$code])) $groupCode[$code]=array();
				else array_push($groupCode[$code],$index); 
			}
		}  
		  
		foreach($groupCode as $index=>$value)
		{
			foreach($value as $valueId)
				unset($boat[$valueId]);
		}
		
		/***/
		
		$Boat->getBoatAttribute($boat);
		
		return($boat);
	}
	   
	/**************************************************************************/
	
	function getBookingFormPayment($meta)
	{
		$Payment=new BCBSPayment();
				
		$payment=$Payment->getPayment();
		
		foreach($payment as $index=>$value)
		{
			if(!in_array($index,$meta['payment_id']))
			   unset($payment[$index]);
		}
		
		return($payment);
	}

	/**************************************************************************/

	function goToStep()
	{		 
		$response=array();
		
		$Date=new BCBSDate();
		$User=new BCBSUser();
		$Payment=new BCBSPayment();
		$Country=new BCBSCountry();
		$Validation=new BCBSValidation();
		$WooCommerce=new BCBSWooCommerce();
		$BookingFormElement=new BCBSBookingFormElement();
	   
		$data=BCBSHelper::getPostOption();
	 
		if(!is_array($bookingForm=$this->checkBookingForm($data['booking_form_id'])))
		{
			if($bookingForm===-3)
			{
				$response['step']=1;
				$this->setErrorGlobal($response,esc_html__('Cannot find at least one boat available in selected time period.','boat-charter-booking-system'));
				BCBSHelper::createJSONResponse($response);
			}
		}
	   
		if((!in_array($data['step_request'],array(2,3,4,5))) || (!in_array($data['step'],array(1,2,3,4))))
		{
			$response['step']=1;
			BCBSHelper::createJSONResponse($response);			
		}
		
		/***/
		/***/
		
		if($data['step_request']>1)
		{
			list($marinaDepartureId)=$this->getBookingFormMarinaDeparture($bookingForm);
			list($marinaReturnId)=$this->getBookingFormMarinaReturn($bookingForm);

			if(!array_key_exists($marinaDepartureId,$bookingForm['dictionary']['marina']))
				$this->setErrorLocal($response,BCBSHelper::getFormName('marina_departure_id',false),esc_html__('Select a valid marina.','boat-charter-booking-system'));				
		   
			if(!array_key_exists($marinaReturnId,$bookingForm['dictionary']['marina']))
				$this->setErrorLocal($response,BCBSHelper::getFormName('marina_return_id',false),esc_html__('Select a valid marina.','boat-charter-booking-system'));
			
			/***/
			
			if(!isset($response['error']))
			{
				$dateTimeError=false;

				$data=BCBSBookingHelper::formatDateTimeToStandard($data);

				if(!$Validation->isDate($data['departure_date']))
				{
					$dateTimeError=true;
					$this->setErrorLocal($response,BCBSHelper::getFormName('departure_date',false),esc_html__('Enter a valid date.','boat-charter-booking-system'));
				}
				if(!$Validation->isDate($data['return_date']))
				{
					$dateTimeError=true;
					$this->setErrorLocal($response,BCBSHelper::getFormName('return_date',false),esc_html__('Enter a valid date.','boat-charter-booking-system'));
				}				
			}
		
			/****/
			
			if($dateTimeError)
			{
				if((int)$bookingForm['meta']['marina_departure_return_time_field_enable']===1)
				{
					if(!$Validation->isTime($data['departure_time']))
					{   
						$dateTimeError=true;
						$this->setErrorLocal($response,BCBSHelper::getFormName('departure_time',false),esc_html__('Enter a valid time.','boat-charter-booking-system'));
					}			
					if(!$Validation->isTime($data['return_time']))
					{   
						$dateTimeError=true;
						$this->setErrorLocal($response,BCBSHelper::getFormName('return_time',false),esc_html__('Enter a valid time.','boat-charter-booking-system'));
					}  					
				}	
			}
			
			/****/
			
			if(!$dateTimeError)
			{
				$currentDate=date_i18n('d-m-Y G:i');
				$departureDate=BCBSBookingFormHelper::getBookingFormDateTime($bookingForm,$data);
				
				if(in_array($Date->compareDate($departureDate,$currentDate),array(2)))
				{
					$dateTimeError=true;
					$this->setErrorLocal($response,BCBSHelper::getFormName('departure_date',false),esc_html__('Departure date/time has to be later than current date.','boat-charter-booking-system'));					
				}
			}
			
			/****/

			if(!$dateTimeError)
			{
				$departureDate=BCBSBookingFormHelper::getBookingFormDateTime($bookingForm,$data,'departure','00:00');
				$returnDate=BCBSBookingFormHelper::getBookingFormDateTime($bookingForm,$data,'return');
				
				$compare=array(0,1);
				
				if((int)$bookingForm['meta']['marina_departure_return_time_field_enable']!==1) $compare=array(1);
				
				if(in_array($Date->compareDate($departureDate,$returnDate),$compare))
				{
					$dateTimeError=true;
					$this->setErrorLocal($response,BCBSHelper::getFormName('return_date',false),esc_html__('Return date/time has to be later than departure date.','boat-charter-booking-system'));					
				}
			}

			/***/

			if(!$dateTimeError)
			{
				if(is_array($bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['date_exclude']))
				{
					foreach($bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['date_exclude'] as $index=>$value)
					{
						if($Date->dateInRange($data['departure_date'],$value['start'],$value['stop']))
						{
							$this->setErrorLocal($response,BCBSHelper::getFormName('departure_date',false),esc_html__('Enter a valid date.','boat-charter-booking-system'));
							$dateTimeError=true;
							break;
						}
					}
				}
			}
			
			/***/

			if(!$dateTimeError)
			{
				$bookingPeriodFrom=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['departure_period_from'];
				if(!$Validation->isNumber($bookingPeriodFrom,0,9999))
					$bookingPeriodFrom=0;

				list($date1,$date2)=$this->getDatePickupPeriod($data,$bookingForm['dictionary']['marina'][$marinaDepartureId],'departure',$bookingPeriodFrom);
				if($Date->compareDate($date1,$date2)===2)
				{
					$this->setErrorLocal($response,BCBSHelper::getFormName('departure_date',false),esc_html__('Enter a valid date.','boat-charter-booking-system'));
					$dateTimeError=true;					
				}	   

				if(!$dateTimeError)
				{
					$bookingPeriodTo=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['departure_period_to'];
					if($Validation->isNumber($bookingPeriodTo,0,9999))
					{
						$bookingPeriodTo+=$bookingPeriodFrom;

						list($date1,$date2)=$this->getDatePickupPeriod($data,$bookingForm['dictionary']['marina'][$marinaDepartureId],'departure',$bookingPeriodTo);	
						if($Date->compareDate($date1,$date2)===1)
						{
							$this->setErrorLocal($response,BCBSHelper::getFormName('departure_date',false),esc_html__('Enter a valid date.','boat-charter-booking-system'));
							$dateTimeError=true;					
						}							   
					}
				}
			}
			
			if((int)$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['date_departure_return_the_same_enable']===1)
			{
				if($data['departure_date']!=$data['return_date'])
					$this->setErrorLocal($response,BCBSHelper::getFormName('return_date',false),esc_html__('Return date has to be the same as departure date.','boat-charter-booking-system'));
			}
			
			if((int)$bookingForm['meta']['marina_departure_return_time_field_enable']===1)
			{
				if(!$dateTimeError)
				{
					$number=$Date->getDayNumberOfWeek($data['departure_date']);
					if(isset($bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['business_hour'][$number]))
					{
						$start=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['business_hour'][$number]['start'];
						$stop=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['business_hour'][$number]['stop'];

						if($bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['after_business_hour_departure_enable']==1)
						{
							if($number!=$Date->getDayNumberOfWeek(date_i18n('d-m-Y'))) $start='00:00';
							$stop='23:59';
						}

						if(($Validation->isNotEmpty($start)) && ($Validation->isNotEmpty($stop)))
						{
							if(!$Date->timeInRange($data['departure_time'],$start,$stop))
							{
								$this->setErrorLocal($response,BCBSHelper::getFormName('departure_time',false),esc_html__('Enter a valid time.','boat-charter-booking-system'));
								$dateTimeError=true;
							}
						}
						else
						{
							$this->setErrorLocal($response,BCBSHelper::getFormName('departure_date',false),esc_html__('Enter a valid date.','boat-charter-booking-system'));
							$dateTimeError=true;						
						}

						if(!$dateTimeError)
						{
							$breakHour=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['business_hour'][$number]['break'];
							if((is_array($breakHour)) && (count($breakHour)))
							{
								foreach($breakHour as $breakHourValue)
								{
									if($Date->timeInRange($data['departure_time'],$breakHourValue['start'],$breakHourValue['stop']))
									{
										$this->setErrorLocal($response,BCBSHelper::getFormName('departure_time',false),esc_html__('Enter a valid time.','boat-charter-booking-system'));
										$dateTimeError=true;										
										break;
									}
								}
							}
						}
					}

					$number=$Date->getDayNumberOfWeek($data['return_date']);
					if(isset($bookingForm['dictionary']['marina'][$marinaReturnId]['meta']['business_hour'][$number]))
					{
						$start=$bookingForm['dictionary']['marina'][$marinaReturnId]['meta']['business_hour'][$number]['start'];
						$stop=$bookingForm['dictionary']['marina'][$marinaReturnId]['meta']['business_hour'][$number]['stop'];

						if($bookingForm['dictionary']['marina'][$marinaReturnId]['meta']['after_business_hour_return_enable']==1)
						{
							$start='00:00';
							$stop='23:59';
						}

						if(($Validation->isNotEmpty($start)) && ($Validation->isNotEmpty($stop)))
						{
							if(!$Date->timeInRange($data['return_time'],$start,$stop))
							{
								$this->setErrorLocal($response,BCBSHelper::getFormName('return_time',false),esc_html__('Enter a valid time.','boat-charter-booking-system'));
								$dateTimeError=true;
							}
						}
						else
						{
							$this->setErrorLocal($response,BCBSHelper::getFormName('return_date',false),esc_html__('Enter a valid date.','boat-charter-booking-system'));
							$dateTimeError=true;						
						}

						if(!$dateTimeError)
						{
							$breakHour=$bookingForm['dictionary']['marina'][$marinaReturnId]['meta']['business_hour'][$number]['break'];
							if((is_array($breakHour)) && (count($breakHour)))
							{
								foreach($breakHour as $breakHourValue)
								{
									if($Date->timeInRange($data['return_time'],$breakHourValue['start'],$breakHourValue['stop']))
									{
										$this->setErrorLocal($response,BCBSHelper::getFormName('return_time',false),esc_html__('Enter a valid time.','boat-charter-booking-system'));
										$dateTimeError=true;										
										break;
									}
								}
							}
						}
					}
				}
			}
				
			if(!$dateTimeError)
			{
				if((int)BCBSOption::getOption('billing_type')===2)
				{
					$meta=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta'];

					$period=BCBSBookingHelper::calculateRentalPeriod($data['departure_date'],$data['departure_time'],$data['return_date'],$data['return_time']);

					if(isset($meta['boat_charter_date']))
					{
						if(count($meta['boat_charter_date']))
						{
							foreach($meta['boat_charter_date'] as $index=>$value)
							{
								if($Date->dateInRange($data['departure_date'],$value['start'],$value['stop']))
								{
									if($Validation->isNotEmpty($value['day_count_min']))
									{
										if($value['day_count_min']>$period['day'])
										{
											$this->setErrorLocal($response,BCBSHelper::getFormName('return_date',false),sprintf(esc_html__('Minimum number of days to rent a boat is %s.','boat-charter-booking-system'),$value['day_count_min']));
											$dateTimeError=true;
										}
									}

									if(!$dateTimeError)
									{
										if($Validation->isNotEmpty($value['day_count_max']))
										{
											if($value['day_count_max']<$period['day'])
											{
												$this->setErrorLocal($response,BCBSHelper::getFormName('return_date',false),sprintf(esc_html__('Maximum number of days to rent a boat is %s.','boat-charter-booking-system'),$value['day_count_max']));
												$dateTimeError=true;
											}
										}											
									}
								}
							}
						}
					}

					if(!$dateTimeError)
					{
						if(($Validation->isNotEmpty($meta['boat_charter_day_count_min'])) || ($Validation->isNotEmpty($meta['boat_charter_day_count_max'])))
						{
							if($Validation->isNotEmpty($meta['boat_charter_day_count_min']))
							{
								if($meta['boat_charter_day_count_min']>$period['day'])
									$this->setErrorLocal($response,BCBSHelper::getFormName('return_date',false),sprintf(esc_html__('Minimum number of days to rent a boat is %s.','boat-charter-booking-system'),$meta['boat_charter_day_count_min']));
							}
							if($Validation->isNotEmpty($meta['boat_charter_day_count_max']))
							{
								if($meta['boat_charter_day_count_max']<$period['day'])
									$this->setErrorLocal($response,BCBSHelper::getFormName('return_date',false),sprintf(esc_html__('Maximum number of days to rent a boat is %s.','boat-charter-booking-system'),$meta['boat_charter_day_count_max']));							
							}
						}
					}
				}
			}
			
			/***/
					
			if(isset($response['error']))
			{
				$response['step']=1;
				BCBSHelper::createJSONResponse($response);
			}
		}  
		
		/***/
			   
		if($data['step_request']>2)
		{
			$error=false;
			
			if(!array_key_exists($data['boat_id'],$bookingForm['dictionary']['boat']))
			{
				$error=true;
				$data['step']=2;
				$data['step_request']=2;
				$this->setErrorGlobal($response,esc_html__('Select a boat.','boat-charter-booking-system'));
			}
			
			if(!$error)
			{
				if($bookingForm['meta']['order_value_minimum']>0)
				{
					$Booking=new BCBSBooking();

					$data['booking_form']=$bookingForm;

					if(($price=$Booking->calculatePrice($data))!==false)	  
					{
						$orderValueMinimum=number_format($bookingForm['meta']['order_value_minimum']*BCBSCurrency::getExchangeRate(),2,'.','');
						
						if($orderValueMinimum>$price['total']['sum']['gross']['value'])
						{
							$this->setErrorGlobal($response,sprintf(esc_html__('Minimum value of order is %s.','boat-charter-booking-system'),BCBSPrice::format($orderValueMinimum,BCBSCurrency::getFormCurrency())));
						}
					}
				}
			}
			
			if(isset($response['error'])) $response['step']=2;
		}
		 
		/***/
		 
		if(!isset($response['error']))
		{
			if($data['step_request']>3)
			{
				$error=false;
				
				if($WooCommerce->isEnable($bookingForm['meta']))
				{
					if(!$User->isSignIn())
					{
						if(((int)$data['client_account']===0) && ((int)$bookingForm['meta']['woocommerce_account_enable_type']===2))
						{
							$this->setErrorGlobal($response,esc_html__('Login to your account or provide all needed details.','boat-charter-booking-system'));   
						}
					}
				}				
				
				if(!$error)
				{				
					if($Validation->isEmpty($data['client_contact_detail_first_name']))
						$this->setErrorLocal($response,BCBSHelper::getFormName('client_contact_detail_first_name',false),esc_html__('Enter your first name','boat-charter-booking-system'));
					if($Validation->isEmpty($data['client_contact_detail_last_name']))
						$this->setErrorLocal($response,BCBSHelper::getFormName('client_contact_detail_last_name',false),esc_html__('Enter your last name','boat-charter-booking-system'));
					if(!$Validation->isEmailAddress($data['client_contact_detail_email_address']))
						$this->setErrorLocal($response,BCBSHelper::getFormName('client_contact_detail_email_address',false),esc_html__('Enter valid e-mail address','boat-charter-booking-system'));
					if(in_array('client_contact_detail_phone_number',$bookingForm['meta']['field_mandatory']))
					{
						if($Validation->isEmpty($data['client_contact_detail_phone_number']))
							$this->setErrorLocal($response,BCBSHelper::getFormName('client_contact_detail_phone_number',false),esc_html__('Please enter valid phone number.','boat-charter-booking-system'));
					}
					
					if((int)$bookingForm['meta']['billing_detail_state']!==4)
					{
						if(((int)$data['client_billing_detail_enable']===1) || ((int)$bookingForm['meta']['billing_detail_state']===3))
						{
							if(in_array('client_billing_detail_company_name',$bookingForm['meta']['field_mandatory']))
							{							
								if($Validation->isEmpty($data['client_billing_detail_company_name']))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_billing_detail_company_name',false),esc_html__('Enter valid company name.','boat-charter-booking-system'));			   
							}
							if(in_array('client_billing_detail_tax_number',$bookingForm['meta']['field_mandatory']))
							{							
								if($Validation->isEmpty($data['client_billing_detail_tax_number']))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_billing_detail_tax_number',false),esc_html__('Enter valid tax number.','boat-charter-booking-system'));			   
							}						
							if(in_array('client_billing_detail_street_name',$bookingForm['meta']['field_mandatory']))
							{
								if($Validation->isEmpty($data['client_billing_detail_street_name']))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_billing_detail_street_name',false),esc_html__('Enter valid street name.','boat-charter-booking-system'));			   
							}
							if(in_array('client_billing_detail_street_number',$bookingForm['meta']['field_mandatory']))
							{
								if($Validation->isEmpty($data['client_billing_detail_street_number']))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_billing_detail_street_number',false),esc_html__('Enter valid street number.','boat-charter-booking-system'));			   
							}						
							if(in_array('client_billing_detail_city',$bookingForm['meta']['field_mandatory']))
							{
								if($Validation->isEmpty($data['client_billing_detail_city']))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_billing_detail_city',false),esc_html__('Enter valid city name.','boat-charter-booking-system'));				 
							}
							if(in_array('client_billing_detail_state',$bookingForm['meta']['field_mandatory']))
							{
								if($Validation->isEmpty($data['client_billing_detail_state']))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_billing_detail_state',false),esc_html__('Enter valid state name.','boat-charter-booking-system'));				
							}
							if(in_array('client_billing_detail_postal_code',$bookingForm['meta']['field_mandatory']))	
							{
								if($Validation->isEmpty($data['client_billing_detail_postal_code']))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_billing_detail_postal_code',false),esc_html__('Enter valid postal code.','boat-charter-booking-system'));				  
							}
							if(in_array('client_billing_detail_country_code',$bookingForm['meta']['field_mandatory']))
							{
								if(!$Country->isCountry($data['client_billing_detail_country_code']))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_billing_detail_country_code',false),esc_html__('Enter valid country name.','boat-charter-booking-system')); 
							}
						}
					}
					
					if($WooCommerce->isEnable($bookingForm['meta']))
					{
						if(!$User->isSignIn())
						{
							if(((int)$data['client_sign_up_enable']===1) || ((int)$bookingForm['meta']['woocommerce_account_enable_type']===2))
							{
								$validationResult=$User->validateCreateUser($data['client_contact_detail_email_address'],$data['client_sign_up_login'],$data['client_sign_up_password'],$data['client_sign_up_password_retype']);

								if(in_array('EMAIL_INVALID',$validationResult))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_contact_detail_email_address',false),esc_html__('E-mail address is invalid.','boat-charter-booking-system')); 
								if(in_array('EMAIL_EXISTS',$validationResult))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_contact_detail_email_address',false),esc_html__('E-mail address already exists','boat-charter-booking-system'));							 

								if(in_array('LOGIN_INVALID',$validationResult))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_sign_up_login',false),esc_html__('Login cannot be empty.','boat-charter-booking-system'));							 
								if(in_array('LOGIN_EXISTS',$validationResult))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_sign_up_login',false),esc_html__('Login already exists.','boat-charter-booking-system'));							   

								if(in_array('PASSWORD1_INVALID',$validationResult))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_sign_up_password',false),esc_html__('Password cannot be empty.','boat-charter-booking-system'));							   
								if(in_array('PASSWORD2_INVALID',$validationResult))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_sign_up_password_retype',false),esc_html__('Password cannot be empty.','boat-charter-booking-system'));							 
								if(in_array('PASSWORD_MISMATCH',$validationResult))
									$this->setErrorLocal($response,BCBSHelper::getFormName('client_sign_up_password_retype',false),esc_html__('Passwords are not the same.','boat-charter-booking-system'));							  
							}
						}
					}
				
					$error=$BookingFormElement->validateField($bookingForm['meta'],$data);
					foreach($error as $errorValue)
						$this->setErrorLocal($response,$errorValue['name'],$errorValue['message_error']); 

					if(!BCBSBookingHelper::isPayment($data['payment_id'],$bookingForm['meta'],$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']))
						$this->setErrorGlobal($response,esc_html__('Select a payment method.','boat-charter-booking-system'));

					$error=$BookingFormElement->validateAgreement($bookingForm['meta'],$data);
					if($error)
						$this->setErrorGlobal($response,esc_html__('Approve all agreements.','boat-charter-booking-system'));			  
				}
				
				if(isset($response['error']))
				{
					$data['step']=3;
					$data['step_request']=3;
					$response['step']=3;
				} 
			}
		}
		
		/***/
		
		if(!isset($response['error']))
		{
			if($data['step_request']>4)
			{
				$Booking=new BCBSBooking();
				$WooCommerce=new BCBSWooCommerce();
				
				$bookingId=$Booking->sendBooking($data,$bookingForm);
			   
				if((int)$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['payment_processing_enable']===1)
				{
					$response['step']=5;
					
					if(!$WooCommerce->isEnable($bookingForm['meta']))
					{
						if(!$Payment->isPayment($data['payment_id']))
							$data['payment_id']=0;
						
						if($data['payment_id']!=0)
						{
							$payment=$Payment->getPayment($data['payment_id']);

							$response['payment_info']=esc_html($bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['payment_'.$payment[1].'_info']);

							$response['button_back_to_home_label']=esc_html($bookingForm['meta']['thank_you_page_button_back_to_home_label']);
							$response['button_back_to_home_url_address']=esc_url($bookingForm['meta']['thank_you_page_button_back_to_home_url_address']);

							$response['payment_prefix']=$payment[1];
						}
							
						$response['payment_id']=$data['payment_id'];  

						if(in_array($data['payment_id'],array(2,3)))
						{
							$booking=$Booking->getBooking($bookingId);
							$bookingBilling=$Booking->createBilling($bookingId);			  
						}

						if($data['payment_id']==3)
						{
							$response['form']['item_name']=$booking['post']->post_title;
							$response['form']['item_number']=$booking['post']->ID;
							
							$response['form']['currency_code']=$booking['meta']['currency_id'];

							$response['form']['amount']=$bookingBilling['summary']['pay'];
						}
						elseif($data['payment_id']==2)
						{
							$PaymentStripe=new BCBSPaymentStripe();
							
							$sessionId=$PaymentStripe->createSession($booking,$bookingBilling,$bookingForm);
							
							$response['stripe_session_id']=$sessionId;
							$response['stripe_redirect_duration']=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['payment_stripe_redirect_duration'];
							$response['stripe_publishable_key']=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['payment_stripe_api_key_publishable'];
						
							if($sessionId===false)
							{
								$this->setErrorGlobal($response,__('An error occurs during processing this payment. Plugin cannot continue the work.','boat-charter-booking-system'));
							}
						}
					}
					else
					{
						$response['payment_url']=$WooCommerce->sendBooking($bookingId,$bookingForm,$data);

						if($Validation->isNotEmpty($response['payment_url']))
							$response['thank_you_page_enable']=$bookingForm['meta']['thank_you_page_enable'];
						else $response['thank_you_page_enable']=1;
						
						$response['payment_id']=-1;
					}
				}
				else
				{
					$response['step']=5;
					$response['payment_id']=-2;	   
					
					$response['button_back_to_home_label']=$bookingForm['meta']['thank_you_page_button_back_to_home_label'];
					$response['button_back_to_home_url_address']=$bookingForm['meta']['thank_you_page_button_back_to_home_url_address'];
				}
			}
		}
				  
		/***/
		/***/		

		if($data['step_request']==2)
		{
			if(($boatHtml=$this->boatFilter(false,$bookingForm))!==false);
				$response['boat']=$boatHtml;
			
			$response['booking_extra']=$this->createBookingExtra($data,$bookingForm,$marinaDepartureId);
			
			$response['marina_selected_name']=BCBSBookingFormHelper::isAllMarinaSelected($bookingForm,'departure') ? null : $bookingForm['marina_selected_name'];
			$response['marina_selected_address']=BCBSBookingFormHelper::isAllMarinaSelected($bookingForm,'departure') ? null : $bookingForm['marina_selected_address'];
		}   
		
		/***/
		
		if($data['step_request']==3)
		{
			$userData=array();
			
			$User=new BCBSUser();
			$WooCommerce=new BCBSWooCommerce();
			
			if(($WooCommerce->isEnable($bookingForm['meta'])) && ($User->isSignIn()))
			{
				if(!array_key_exists('client_contact_detail_first_name',$data))
					$userData=$WooCommerce->getUserData();
			}
			
			if(!array_key_exists('client_contact_detail_first_name',$data))
			{
				$userData['client_billing_detail_country_code']=$bookingForm['marina_client_country_default'][$marinaDepartureId];
			}
			
			$response['client_form_sign_id']=$this->createClientFormSignIn($bookingForm);
			$response['client_form_sign_up']=$this->createClientFormSignUp($bookingForm,$userData,$marinaDepartureId);
		}
		
		/***/

		if(!isset($response['error']))
		{
			$response['step']=$data['step_request'];
			$data['step']=$response['step'];
		}
		else 
		{
			$data['step_request']=$data['step'];
		}	
		
		$response['summary']=$this->createSummary($data,$bookingForm);

		$response['payment']=$this->createPayment($bookingForm['dictionary']['payment'],$bookingForm['dictionary']['payment_woocommerce'],$data['payment_id'],$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']);
		
		BCBSHelper::createJSONResponse($response);
		
		/***/
	}

	/**************************************************************************/
	
	function setErrorLocal(&$response,$field,$message)
	{
		if(!isset($response['error']))
		{
			$response['error']['local']=array();
			$response['error']['global']=array();
		}
		
		array_push($response['error']['local'],array('field'=>$field,'message'=>$message));
	}
	
	/**************************************************************************/
	
	function setErrorGlobal(&$response,$message)
	{
		if(!isset($response['error']))
		{
			$response['error']['local']=array();
			$response['error']['global']=array();
		}
		
		array_push($response['error']['global'],array('message'=>$message));
	}
	
	/**************************************************************************/
	
	function createSummaryPriceElementAjax()
	{
		$response=array();
		
		$data=BCBSHelper::getPostOption();
		$data=BCBSBookingHelper::formatDateTimeToStandard($data);
		
		if(!is_array($bookingForm=$this->checkBookingForm($data['booking_form_id'])))
		{
			$response['html']=null;
			BCBSHelper::createJSONResponse($response);
		}
		
		$response['html']=$this->createSummaryPriceElement($data,$bookingForm);
		
		BCBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function createSummaryPriceElement($data,$bookingForm)
	{
		$html=null;
		
		$Booking=new BCBSBooking();
		
		$data['booking_form']=$bookingForm;
		
		if(($price=$Booking->calculatePrice($data,null,$bookingForm['meta']['booking_summary_hide_fee']))===false) return(null);

		$netGross=(int)$bookingForm['meta']['booking_summary_display_net_price']===1 ? 'net' : 'gross';
		
		if(BCBSOption::getOption('billing_type')==2)
			$rentalPeriod=BCBSBookingHelper::calculateRentalPeriod($data['departure_date'],$data['departure_time'],$data['return_date'],$data['return_time']);

		if($price['boat']['sum'][$netGross]['value']!=0)
		{
			$html.=
			'
				<div>
					<span>'.esc_html__('Selected boat','boat-charter-booking-system').'</span>
					<span>'.esc_html($price['boat']['sum'][$netGross]['format']).'</span>
				</div>
			';
		}
 
		if((int)$data['booking_form']['meta']['booking_summary_hide_fee']===0)
		{		
			if($price['deposit']['sum'][$netGross]['value']!=0)
			{
				$html.=
				'
					<div>
						<span>'.esc_html__('Deposit','boat-charter-booking-system').'</span>
						<span>'.esc_html($price['deposit']['sum'][$netGross]['format']).'</span>
					</div>
				';
			}

			if($price['initial']['sum'][$netGross]['value']!=0)
			{
				$html.=
				'
					<div>
						<span>'.esc_html__('Initial fee','boat-charter-booking-system').'</span>
						<span>'.esc_html($price['initial']['sum'][$netGross]['format']).'</span>
					</div>
				';
			}
			
			if($price['one_way']['sum'][$netGross]['value']!=0)
			{
				$html.=
				'
					<div>
						<span>'.esc_html__('One way fee','boat-charter-booking-system').'</span>
						<span>'.esc_html($price['one_way']['sum'][$netGross]['format']).'</span>
					</div>
				';
			}
			
			if($price['after_business_hour_departure']['sum'][$netGross]['value']!=0)
			{
				$html.=
				'
					<div>
						<span>'.esc_html__('After hours departure fee','boat-charter-booking-system').'</span>
						<span>'.esc_html($price['after_business_hour_departure']['sum'][$netGross]['format']).'</span>
					</div>
				';
			}

			if($price['after_business_hour_return']['sum'][$netGross]['value']!=0)
			{
				$html.=
				'
					<div>
						<span>'.esc_html__('After hours return fee','boat-charter-booking-system').'</span>
						<span>'.esc_html($price['after_business_hour_return']['sum'][$netGross]['format']).'</span>
					</div>
				';
			}
		}
		
		if($price['booking_extra']['sum'][$netGross]['value']!=0)
		{		
			$BookingExtra=new BCBSBookingExtra();

			$bookingExtra=$BookingExtra->validate($data,$bookingForm,$taxRateDictionary);

			foreach($bookingExtra as $value)
			{
				$html.=
				'
					<div>
						<span>'.esc_html($value['name']).'</span>
						<span>'.esc_html(BCBSPrice::format($value['sum_'.$netGross],BCBSOption::getOption('currency'))).'</span>
					</div>
				';					   
			}
		}
		
		if(($price['total']['tax']['value']!=0) && ((int)$bookingForm['meta']['booking_summary_display_net_price']===1))
		{
			$html.=
			'
				<div>
					<span>'.esc_html__('Tax','boat-charter-booking-system').'</span>
					<span>'.esc_html($price['total']['tax']['format']).'</span>
				</div>
			';			  
		}
		
		$html.=
		'
			<div class="bcbs-summary-price-element-total bcbs-clear-fix">
				<h4>'.esc_html__('Total','boat-charter-booking-system').'</h4>
				<h4>'.esc_html($price['total']['sum']['gross']['format']).'</h4>
			</div>
		';

		if(BCBSBookingFormHelper::isPaymentDepositEnable($bookingForm))
		{
			$html.=
			'
				<div class="bcbs-summary-price-element-to-pay bcbs-clear-fix">
					<h4>'.sprintf(__('To pay','boat-charter-booking-system')).'</h4>
					<h4>'.$price['pay']['sum']['gross']['format'].'</h4>
				</div>
				<div class="bcbs-summary-price-element-balance bcbs-clear-fix">
					<h4>'.sprintf(__('Balance','boat-charter-booking-system')).'</h4>
					<h4>'.$price['balance']['sum']['gross']['format'].'</h4>
				</div>
			';
		}
		
		$html=
		'
			<div class="bcbs-summary-price-element bcbs-box-shadow bcbs-clear-fix">
				<h4>'.esc_html__('Order Totals','boat-charter-booking-system').'</h4>
				'.$html.'
			</div>
		';
		


		return($html);
	}
	
	/**************************************************************************/
	
	function createSummary($data,$bookingForm)
	{
		$response=array(null,null,null);
		
		$Date=new BCBSDate();
		$User=new BCBSUser();
		$Boat=new BCBSBoat();
		$Marina=new BCBSMarina();
		$Validation=new BCBSValidation();
		$WooCommerce=new BCBSWooCommerce();
		
		/***/
		
		$priceHtml=$this->createSummaryPriceElement($data,$bookingForm);
   
		/***/
		
		$userHtml=null;
		if($WooCommerce->isEnable($bookingForm['meta']))
		{
			if($User->isSignIn())
			{
				$userData=$User->getCurrentUserData();
				$userHtml=$userData->data->display_name;
			}
		}
		
		/***/
		
		$departureDate=$Date->formatDateToDisplay($data['departure_date']);
		$departureTime=$Date->formatTimeToDisplay($data['departure_time']);

		$returnDate=$Date->formatDateToDisplay($data['return_date']);
		$returnTime=$Date->formatTimeToDisplay($data['return_time']);
		
		$fromToHtml=esc_html($departureDate);
		if($Validation->isNotEmpty($departureTime)) $fromToHtml.=', '.esc_html($departureTime);
		
		$fromToHtml.=' &ndash; '.esc_html($returnDate);
		if($Validation->isNotEmpty($returnTime)) $fromToHtml.=', '.esc_html($returnTime);
		
		/***/
		
		$rentalPeriod=BCBSBookingHelper::calculateRentalPeriod($data['departure_date'],$data['departure_time'],$data['return_date'],$data['return_time']);
		$rentalPeriodHtml=BCBSBookingHelper::getRentalPeriodLabel($rentalPeriod);

		/***/
		
		list($marinaDepartureId)=$this->getBookingFormMarinaDeparture($bookingForm);
		list($marinaReturnId)=$this->getBookingFormMarinaReturn($bookingForm);
				
		$marinaDepartureHtml=$Marina->displayAddress($marinaDepartureId);
		$marinaReturnHtml=$Marina->displayAddress($marinaReturnId);
		
		/***/
		
		switch($data['step_request'])
		{
			case 2:
			case 3:
			case 4:
				
				$marinaHtml=null;
				
				if(!BCBSBookingFormHelper::isAllMarinaSelected($bookingForm,'departure'))
				{
					$marinaHtml.=
					'
						<div class="bcbs-summary-field">
							<span class="bcbs-meta-icon-24-location"></span>
							<div class="bcbs-summary-field-name">'.esc_html__('Departure','boat-charter-booking-system').'</div>
							<div class="bcbs-summary-field-value">'.$marinaDepartureHtml.'</div>					
						</div>						
					';
				}
				
				if(!BCBSBookingFormHelper::isAllMarinaSelected($bookingForm,'return'))
				{
					$marinaHtml.=
					'
						<div class="bcbs-summary-field">
							<span class="bcbs-meta-icon-24-location"></span>
							<div class="bcbs-summary-field-name">'.esc_html__('Return','boat-charter-booking-system').'</div>
							<div class="bcbs-summary-field-value">'.$marinaReturnHtml.'</div>					
						</div>					
					';
				}
				
				$response[0]=
				'
					<div class="bcbs-summary bcbs-summary-style-1">
						<div class="bcbs-summary-header">
							<h4>'.esc_html__('Charter Details','boat-charter-booking-system').'</h4>
						</div>				 
						'.$marinaHtml.'
						<div class="bcbs-summary-field">
							<span class="bcbs-meta-icon-24-date"></span>
							<div class="bcbs-summary-field-name">'.esc_html__('From &ndash; To','boat-charter-booking-system').'</div>
							<div class="bcbs-summary-field-value">'.$fromToHtml.'</div>					
						</div>
						<div class="bcbs-summary-field">
							<span class="bcbs-meta-icon-24-duration"></span>
							<div class="bcbs-summary-field-name">'.esc_html__('Duration','boat-charter-booking-system').'</div>
							<div class="bcbs-summary-field-value">'.$rentalPeriodHtml.'</div>					
						</div>
					</div>
				';
				
				if((int)$data['step_request']===4) $response[1]=$response[0];
				else 
				{
					$response[0].=$priceHtml;
					break;
				}
				
			case 4:
				
				$response[0]=
				'
					<div class="bcbs-summary bcbs-summary-style-2 bcbs-box-shadow">
						<div class="bcbs-summary-header">
							<h4>'.esc_html__('Client Details','boat-charter-booking-system').'</h4>
						</div>   
						<div class="bcbs-summary-field">
							<div class="bcbs-layout-50x50 bcbs-clear-fix">
								<div class="bcbs-layout-column-left">						
									<div class="bcbs-summary-field-name">'.esc_html__('First name','boat-charter-booking-system').'</div>
									<div class="bcbs-summary-field-value">'.esc_html($data['client_contact_detail_first_name']).'</div>	
								</div>
								<div class="bcbs-layout-column-right">
									<div class="bcbs-summary-field-name">'.esc_html__('Second name','boat-charter-booking-system').'</div>
									<div class="bcbs-summary-field-value">'.esc_html($data['client_contact_detail_last_name']).'</div>	
								</div>
							</div>
						</div>
						<div class="bcbs-summary-field">
							<div class="bcbs-summary-field-name">'.esc_html__('E-mail address','boat-charter-booking-system').'</div>
							<div class="bcbs-summary-field-value">'.esc_html($data['client_contact_detail_email_address']).'</div>					
						</div>		
				';
				
				if($Validation->isNotEmpty($data['client_contact_detail_phone_number']))
				{
					$response[0].=
					'
						<div class="bcbs-summary-field">
							<div class="bcbs-summary-field-name">'.esc_html__('Phone number','boat-charter-booking-system').'</div>
							<div class="bcbs-summary-field-value">'.esc_html($data['client_contact_detail_phone_number']).'</div>					
						</div>			

					';
				}	
				
				if($Validation->isNotEmpty($data['comment']))
				{
					$response[0].=
					'
						<div class="bcbs-summary-field">
							<div class="bcbs-summary-field-name">'.esc_html__('Comments','boat-charter-booking-system').'</div>
							<div class="bcbs-summary-field-value">'.esc_html($data['comment']).'</div>					
						</div>			

					';
				}						
					
				$response[0].=
				'
					</div>
				';
				
				/***/
				
				if(($data['client_billing_detail_enable']==1) && ((int)$bookingForm['meta']['billing_detail_enable']!==4))
				{
					$response[0].=
					'
						<div class="bcbs-summary bcbs-summary-style-2 bcbs-box-shadow">
							<div class="bcbs-summary-header">
								<h4>'.esc_html__('Billing Address','boat-charter-booking-system').'</h4>
							</div>   						
					';
					
					if($Validation->isNotEmpty($data['client_billing_detail_company_name']))
					{
						$response[0].=
						'
							<div class="bcbs-summary-field">
								<div class="bcbs-summary-field-name">'.esc_html__('Company registered name','boat-charter-booking-system').'</div>
								<div class="bcbs-summary-field-value">'.esc_html($data['client_billing_detail_company_name']).'</div>					
							</div>			

						';						
					}
					
					if($Validation->isNotEmpty($data['client_billing_detail_tax_number']))
					{
						$response[0].=
						'
							<div class="bcbs-summary-field">
								<div class="bcbs-summary-field-name">'.esc_html__('Tax number','boat-charter-booking-system').'</div>
								<div class="bcbs-summary-field-value">'.esc_html($data['client_billing_detail_tax_number']).'</div>					
							</div>			

						';						
					}
					
					$dataAddress=array
					(
						'street'=>$data['client_billing_detail_street_name'],
						'street_number'=>$data['client_billing_detail_street_number'],
						'postcode'=>$data['client_billing_detail_postal_code'],
						'city'=>$data['client_billing_detail_city'],
						'state'=>$data['client_billing_detail_state'],
						'country'=>$data['client_billing_detail_country_code']
					);
					
					$addressHtml=BCBSHelper::displayAddress($dataAddress);
					
					if($Validation->isNotEmpty($addressHtml))
					{
						$response[0].=
						'
							<div class="bcbs-summary-field">
								<div class="bcbs-summary-field-name">'.esc_html__('Address','boat-charter-booking-system').'</div>
								<div class="bcbs-summary-field-value">'.$addressHtml.'</div>					
							</div>			
						';						
					}	
					
					$response[0].=
					'
						</div>
					';
				}
				
				/***/
				
				$marinaDeparture=$bookingForm['dictionary']['marina'][$marinaDepartureId];
				
				if(BCBSBookingHelper::isPayment($data['payment_id'],$bookingForm['meta'],$marinaDeparture['meta']))
				{
					$paymentImage=BCBSBookingHelper::getPaymentImage($data['payment_id'],$bookingForm);
					$paymentName=BCBSBookingHelper::getPaymentName($data['payment_id'],$bookingForm['meta']);
					
					if($Validation->isNotEmpty($paymentImage))
					{
						$response[0].=
						'
							<div class="bcbs-summary bcbs-summary-style-2 bcbs-box-shadow">
								<div class="bcbs-summary-header">
									<h4>'.esc_html__('Payment method','boat-charter-booking-system').'</h4>
								</div>   
								<img src="'.esc_url($paymentImage).'"/>
							</div>
						';						
						
					}
					elseif($Validation->isNotEmpty($paymentName))
					{
						$response[0].=
						'
							<div class="bcbs-summary bcbs-summary-style-2 bcbs-box-shadow">
								<div class="bcbs-summary-header">
									<h4>'.esc_html__('Payment method','boat-charter-booking-system').'</h4>
								</div>   
								<div class="bcbs-summary-field">
									<div class="bcbs-summary-field-name">'.esc_html__('Name','boat-charter-booking-system').'</div>
									<div class="bcbs-summary-field-value">'.esc_html($paymentName).'</div>					
								</div>	
							</div>
						';
					}
				}
				
				/***/
				
				$response[1]='<div class="bcbs-google-map-summary"></div>'.$response[1];

				/***/
				
				$boatId=$data['boat_id'];
				
				$boat=$Boat->getDictionary(array('boat_id'=>$boatId));
				
				if(array_key_exists($boatId,$boat))
				{
					$argument=array
					(
						'booking_form_id'=>$bookingForm['post']->ID,
						'boat'=>$boat[$boatId],
						'boat_id'=>$boat[$boatId]['post']->ID,
						'boat_selected_id'=>$boatId,
						'marina_departure_id'=>$data['marina_departure_id'],
						'departure_date'=>$data['departure_date'],
						'departure_time'=>$data['departure_time'],
						'marina_return_id'=>$data['marina_return_id'],
						'return_date'=>$data['return_date'],
						'return_time'=>$data['return_time']
					);
			
					$price=0;
			
					$boatHtml=$this->createBoat($argument,$bookingForm,$price,2);
				}
				
				/***/
	  
				$couponHtml=null;
				if((int)$bookingForm['meta']['coupon_enable']===1)
				{
					$couponHtml=
					'
						<div class="bcbs-clear-fix bcbs-coupon-code-section">
							<div class="bcbs-form-field">
								<label>'.esc_html__('Coupon code','boat-charter-booking-system').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('coupon_code',false).'"/>
								<a href="#" class="bcbs-button bcbs-button-style-1">
									'.esc_html__('Apply','boat-charter-booking-system').'
								</a>							
							</div>						
						</div>
					';
				}
				
				/***/
				
				$response[2]=$boatHtml.$couponHtml.$priceHtml;
				
			break;
		}
		
		return($response);
	}
	
	/**************************************************************************/ 
	
	function createBoat($data,$bookingForm,&$priceToSort,$style=1)
	{
		$html=array(null);
		
		$metaHtml=null;
		$attributeHtml=null;
		$thumbnailHtml=null;
		$descriptionHtml=null;
		$buttonSelectHtml=null;
		$buttonLessMoreHtml=null;
		
		$Boat=new BCBSBoat();
		$Validation=new BCBSValidation();
		
		$argument=array
		(
			'booking_form_id'=>$data['booking_form_id'],
			'boat_id'=>$data['boat_id'],
			'marina_departure_id'=>$data['marina_departure_id'],
			'departure_date'=>$data['departure_date'],
			'departure_time'=>$data['departure_time'],
			'marina_return_id'=>$data['marina_return_id'],
			'return_date'=>$data['return_date'],
			'return_time'=>$data['return_time']
		);
			   
		$price=$Boat->calculatePrice($argument,$bookingForm);
		
		/***/
		
		$rentalPeriod=BCBSBookingHelper::calculateRentalPeriod($data['departure_date'],$data['departure_time'],$data['return_date'],$data['return_time']);
		$rentalPeriodLabel=BCBSBookingHelper::getRentalPeriodLabel($rentalPeriod);

		/***/
		
		$thumbnail=get_the_post_thumbnail_url($data['boat_id'],PLUGIN_BCBS_CONTEXT.'_boat');
		if($thumbnail!==false)
		{
			$htmlGallery=null;
			
			$galleryImageUrl=array();
			
			foreach($data['boat']['meta']['gallery_image_id'] as $value)
			{
				$url=wp_get_attachment_image_src($value,'full');
				if($url!==false) array_push($galleryImageUrl,$url[0]);
			}
			
			if(count($galleryImageUrl))
			{
				foreach($galleryImageUrl as $galleryImageUrlValue)
					$htmlGallery.='<li><img src="'.esc_url($galleryImageUrlValue).'"></li>';
				
				$htmlGallery='<div class="bcbs-boat-gallery"><ul>'.$htmlGallery.'</ul></div>';
			}
			
			/***/
			
			$alt=null;
			$class=array('bcbs-layout-r1_c1','bcbs-boat-image');
			
			if($Validation->isNotEmpty($htmlGallery))
			{
				$alt=__('Click to open boat gallery.','boat-charter-booking-system');
				array_push($class,'bcbs-boat-image-has-gallery');
			}
			
			$html[0]=$thumbnailHtml='<div'.BCBSHelper::createCSSClassAttribute($class).' title="'.esc_attr($alt).'"><img src="'.esc_url($thumbnail).'" alt="'.esc_attr($alt).'"/></div>'.$htmlGallery;
		}
			
		/***/;
		
		if(($Validation->isNotEmpty($data['boat']['meta']['guest_number'])) && (in_array(1,$bookingForm['meta']['boat_attribute_enable'])))
		{
			$metaHtml.=
			'
				<div class="bcbs-layout-r1_c2_r2_c1">
					<span class="bcbs-meta-icon-16-guests"></span>
					<span>'.esc_html(sprintf(esc_html__('%s Guests','boat-charter-booking-system'),$data['boat']['meta']['guest_number'])).'</span>
				</div>
			';
		}
		if(($Validation->isNotEmpty($data['boat']['meta']['cabin_number'])) && (in_array(2,$bookingForm['meta']['boat_attribute_enable'])))
		{
			$metaHtml.=
			'
				<div class="bcbs-layout-r1_c2_r2_c2">
					<span class="bcbs-meta-icon-16-cabin"></span>
					<span>'.esc_html(sprintf(esc_html__('%s Cabins','boat-charter-booking-system'),$data['boat']['meta']['cabin_number'])).'</span>
				</div>
			';
		}
		if(((int)$data['boat']['meta']['dimension_length']!=0) && (in_array(3,$bookingForm['meta']['boat_attribute_enable'])))
		{
			$metaHtml.=
			'
				<div class="bcbs-layout-r1_c2_r2_c3">
					<span class="bcbs-meta-icon-16-width"></span>
					<span>'.esc_html(sprintf(esc_html__('%s m','boat-charter-booking-system'),$data['boat']['meta']['dimension_length'])).'</span>
				</div>
			';
		}
		
		if($style===1)
		{
			if($Validation->isNotEmpty($data['boat']['post']->post_content))
			{
				$descriptionHtml.=
				'
					<div class="bcbs-layout-r2-c1-r1">
						<div class="bcbs-layout-r2-c1-r1-c1"><h4>'.esc_html__('Description','boat-charter-booking-system').'</h4></div>
						<div class="bcbs-layout-r2-c1-r1-c2">'.do_shortcode($data['boat']['post']->post_content).'</div>
					</div>
				';
			}

			if((array_key_exists('attribute',$data['boat'])) && (is_array($data['boat']['attribute'])))
			{
				foreach($data['boat']['attribute'] as $value)
				{
					$attributeHtml.=
					'
						<li>
							<div>'.esc_html($value['name']).'</div>
							<div>'.esc_html($value['value']).'</div>
						</li>
					';
				}

				$attributeHtml=
				'
					<div class="bcbs-layout-r2-c1-r2">
						<div class="bcbs-layout-r2-c1-r2-c1"><h4>'.esc_html__('Specification','boat-charter-booking-system').'</h4></div>
						<div class="bcbs-layout-r2-c1-r2-c2"><ul class="bcbs-boat-attribute">'.$attributeHtml.'</ul></div>
					</div>
				';
			}

			if(($Validation->isNotEmpty($descriptionHtml)) || ($Validation->isNotEmpty($attributeHtml)))
			{
				$descriptionHtml=
				'
					<div class="bcbs-layout-r2">
						<div class="bcbs-layout-r2-c1">
							'.$descriptionHtml.'
							'.$attributeHtml.'
						</div>
					</div>
				';

				$buttonLessMoreHtml=
				'
					<div class="bcbs-layout-r1_c2_r3_c2 bcbs-boat-less-more-button">
						<span class="bcbs-meta-icon-16-details"></span>
						<a href="#">
							<span>'.esc_html__('More details','boat-charter-booking-system').'</span>
							<span>'.esc_html__('Less details','boat-charter-booking-system').'</span>
						</a>
					</div>	
				';
			}
			
			$categoryHtml=$Boat->getBoatCategory($data['boat_id']);
			
			if($Validation->isNotEmpty($categoryHtml))
			{
				$categoryHtml=
				'
					<div class="bcbs-boat-category">
						'.esc_html($categoryHtml).'
					</div>
				';
			}
			
			$marinaHtml=null;
			
			if(BCBSBookingFormHelper::isAllMarinaSelected($bookingForm,'departure'))
			{
				if((is_array($data['boat']['meta']['marina_id'])) && (count($data['boat']['meta']['marina_id'])))
				{
					$boatMarina=$data['boat']['meta']['marina_id'];
					
					foreach($boatMarina as $boatMarinaId)
					{
						if(array_key_exists($boatMarinaId,$bookingForm['dictionary']['marina']))
						{
							if($Validation->isNotEmpty($marinaHtml)) $marinaHtml.=', ';
							$marinaHtml.=$bookingForm['dictionary']['marina'][$boatMarinaId]['post']->post_title;
						}
					}
					
					if($Validation->isNotEmpty($marinaHtml)) $marinaHtml=sprintf(esc_html__(' Marinas: %s','boat-charter-booking-system'),$marinaHtml);
				}
			}
		}
		
		/***/
		
		if($style===1)
		{
			$class=array('bcbs-button','bcbs-button-style-3');
			
			if($data['boat_selected_id']==$data['boat_id'])
				array_push($class,'bcbs-state-selected');
								
			if((int)$data['boat']['meta']['boat_unavailable']===0)
				$buttonSelectHtml='<a href="#" '.BCBSHelper::createCSSClassAttribute($class).'>'.esc_html__('Select','boat-charter-booking-system').'</a>';
			else $buttonSelectHtml='<span>'.esc_html__('Boat unavailable','boat-charter-booking-system').'</span>';	
			
			$buttonSelectHtml=
			'
				<div class="bcbs-layout-r1_c2_r2_c4">
					'.$buttonSelectHtml.'
				</div>		
			';
		}
		
		/***/
		
		$priceHtml=$price['price']['sum']['gross']['format'];
		
		/***/
		
		$layout=array(null,null);
		
		if(($Validation->isNotEmpty($metaHtml)) || ($Validation->isNotEmpty($buttonSelectHtml)))
		{
			$layout[0]=
			'
				<div class="bcbs-layout-r1_c2_r2 bcbs-boat-meta">
					'.$metaHtml.'	
					'.$buttonSelectHtml.'
				</div>		
			';			
		}
		
		/***/
		
		$class=array('bcbs-boat','bcbs-boat-style-'.$style,'bcbs-clear-fix');
		
		if((int)$data['boat']['meta']['boat_unavailable']===1)
			array_push($class,'bcbs-boat-available-0');
			
		$html=
		'
			<div '.BCBSHelper::createCSSClassAttribute($class).' data-boat-id="'.esc_attr($data['boat_id']).'">
				
				<div class="bcbs-layout-r1">
				
					'.$thumbnailHtml.'
					
					<div class="bcbs-layout-r1_c2">
				
						<div class="bcbs-layout-r1_c2_r1">
						
							<div class="bcbs-layout-r1_c2_r1_c1">
								<h3 class="bcbs-boat-name">'.esc_html($data['boat']['post']->post_title).'</h3>
								'.$categoryHtml.$marinaHtml.'
							</div>
							
							<div class="bcbs-layout-r1_c2_r1_c2">
								<h3 class="bcbs-boat-price">'.esc_html($priceHtml).'</h3>
								<span>'.sprintf(esc_html__('Per %s','boat-charter-booking-system'),$rentalPeriodLabel).'</span>
							</div>							
							
						</div>
						
						'.$layout[0].'
						
						<div class="bcbs-layout-r1_c2_r3">
							<div class="bcbs-layout-r1_c2_r3_c1 bcbs-boat-captain-status">
								<span class="bcbs-meta-icon-16-anchor-small"></span>
								'.$Boat->getCaptainStatusName($data['boat']['meta']['captain_status']).'
							</div>
							'.$buttonLessMoreHtml.'
						</div>	

					</div>

				</div>
				
				'.$descriptionHtml.'

			</div>
		';
		
		$priceToSort=$price['price']['sum']['gross']['value'];
		
		return($html);
	}
	
	/**************************************************************************/
	
	function createBookingExtra($data,$bookingForm,$marinaDepartureId)
	{
		$html=null;
		
		$Validation=new BCBSValidation();
		$BookingExtra=new BCBSBookingExtra();
	
		$bookingExtraId=preg_split('/,/',$data['booking_extra_id']);
		
		if(count($bookingForm['dictionary']['booking_extra']))
		{
			foreach($bookingForm['dictionary']['booking_extra'] as $index=>$value)
			{
				$quantityFieldName=BCBSHelper::getFormName('booking_extra_'.$index.'_quantity',false);
				
				$quantityFieldValue=$BookingExtra->validateQuantity($data,$index,$value);
				
				$quantityFieldClass=array('bcbs-quantity');
				
				if((int)$value['meta']['quantity_readonly_enable']===1)
					array_push($quantityFieldClass,'bcbs-state-readonly');
				
				/***/
				
				$price=$BookingExtra->calculatePrice($value,$bookingForm);

				$priceBoat=array();
				
				foreach($price[$marinaDepartureId] as $priceIndex=>$priceValue)
				{
					$priceBoat[$priceIndex]=array
					(
						'enable'												=>	$priceValue['enable'],
						'price_gross_format'									=>	$priceValue['price']['gross']['format'].' '.$priceValue['suffix'],
					);
				}
				
				/***/
	
				$priceHTML=null;
				
				if($price[$marinaDepartureId][-1]['price_gross_format']!='-1')
					$priceHTML=$price[$marinaDepartureId][-1]['price_gross_format'].' '.$price[$marinaDepartureId][-1]['suffix'];
				else 
				{
					if((int)$data['boat_id']>0)
					{						
						if(array_key_exists($data['boat_id'],$price[$marinaDepartureId]))
						{
							$priceHTML=$price[$marinaDepartureId][$data['boat_id']]['price']['gross']['format'].' '.$price[$marinaDepartureId][$data['boat_id']]['suffix'];
						}
					}
				}
				
				/***/
				
				$buttonClass=array('bcbs-button','bcbs-button-style-3');
				
				if((int)$value['meta']['button_select_default_state']==1)
					array_push($buttonClass,'bcbs-state-selected');
				if((int)$value['meta']['button_select_default_state']==2)
					array_push($buttonClass,'bcbs-state-selected','bcbs-state-selected-mandatory');				
				if(in_array($index,$bookingExtraId))
					array_push($buttonClass,'bcbs-state-selected');
				
				array_unique($buttonClass);
				
				/***/
				
				$enable=true;
				
				$bookingExtraClass=array();
				
				if((int)$price[$marinaDepartureId][-1]['enable']===-1)
				{
					if($data['boat_id']>0)
					{
						if((int)$price[$marinaDepartureId][$data['boat_id']]['enable']===0) $enable=false;
					}
					else $enable=false;
				}
				else
				{
					if((int)$price[$marinaDepartureId][-1]['enable']===0) $enable=false;
				}
				
				if(!$enable) array_push($bookingExtraClass,'bcbs-hidden');
				
				/***/

				$quantityHTML=
				'
					<div '.BCBSHelper::createCSSClassAttribute($quantityFieldClass).' data-default="'.esc_attr($value['meta']['quantity_default']).'" data-min="'.esc_attr($value['meta']['quantity_minimum']).'" data-max="'.esc_attr($value['meta']['quantity_maximum']).'">
						<a href="#" class="bcbs-quantity-minus"></a>
						<input type="text" maxlength="4" name="'.esc_attr($quantityFieldName).'" value="'.esc_attr($quantityFieldValue).'">
						<a href="#" class="bcbs-quantity-plus"></a>
						<span></span>
					</div>
				';
				
				/***/
				
				$descriptionHTML=null;
				
				if($Validation->isNotEmpty($value['meta']['description']))
					$descriptionHTML='<p class="bcbs-booking-extra-description">'.esc_html($value['meta']['description']).'</p>';
				
				/***/
				
				$html.=
				'
					<li'.BCBSHelper::createCSSClassAttribute($bookingExtraClass).' data-boat="'.esc_attr(json_encode($priceBoat)).'" data-booking-extra-id="'.esc_attr($index).'">
						<div>
							<h4 class="bcbs-booking-extra-name">'.get_the_title($index).'</h4>
							<h4 class="bcbs-booking-extra-price">'.esc_html($priceHTML).'</h4>
							'.$descriptionHTML.'
						</div>
						<div class="bcbs-booking-extra-quantity">
							'.$quantityHTML.'
						</div>
						<div class="bcbs-booking-extra-select-button">
							<a href="#"'.BCBSHelper::createCSSClassAttribute($buttonClass).'>'.esc_html('Select','boat-charter-booking-system').'</a>
						</div>
					</li>
				';
			}
		}
		
		if(!is_null($html))
		{
			$html=
			'
				<h3>'.esc_html__('Add-on options','boat-charter-booking-system').'</h3>
				<ul class="bcbs-list-reset">
					'.$html.'
				</ul>
			';
		}
		
		return($html);
	}
	
	/**************************************************************************/
	
	function createPayment($payment,$paymentWooCommerce,$paymentIdSelected,$marinaDepartureMeta)
	{
		$html=null;
		
		$Payment=new BCBSPayment();
		$Validation=new BCBSValidation();
		
		if(count($paymentWooCommerce))
		{
			foreach($paymentWooCommerce as $index=>$value)
			{
				$buttonClass=array('bcbs-button bcbs-button-style-3');
				
				if($paymentIdSelected==$index)
					array_push($buttonClass,'bcbs-state-selected');

				$title='<h4>'.esc_html($value->title).'</h4>';
				
				if((isset($value->image_url) && ($Validation->isNotEmpty($value->image_url))))
					$title='<img src="'.esc_url($value->image_url).'" alt="'.esc_attr($value->description).'"/>';
				
				$html.=
				'
					<li data-payment-id="'.esc_attr($index).'">
						'.$title.'
						<a '.BCBSHelper::createCSSClassAttribute($buttonClass).' href="#">'.esc_html__('Select','boat-charter-booking-system').'</a>
					</li>					   
				';
			}
		}
		else if(count($payment))
		{
			if(!$Payment->isPayment($paymentIdSelected))
				$paymentIdSelected=$marinaDepartureMeta['payment_default_id'];
			
			foreach($payment as $index=>$value)
			{
				$buttonClass=array('bcbs-button bcbs-button-style-3');

				if($paymentIdSelected==$index)
					array_push($buttonClass,'bcbs-state-selected');
				
				$title='<h4>'.esc_html($value[0]).'</h4>';
				
				if($Validation->isNotEmpty($marinaDepartureMeta['payment_'.$value[1].'_logo_src']))
					$title='<img src="'.esc_url($marinaDepartureMeta['payment_'.$value[1].'_logo_src']).'" alt="'.esc_attr($value->description).'"/>';
				
				$html.=
				'
					<li data-payment-id="'.esc_attr($index).'">
						'.$title.'
						<a '.BCBSHelper::createCSSClassAttribute($buttonClass).' href="#">'.esc_html__('Select','boat-charter-booking-system').'</a>
					</li>					   
				';
			}
		}
		else return($html);
		
		$html=
		'
			<h3>'.esc_html__('Payment Method','boat-charter-booking-system').'</h3>
			<ul class="bcbs-payment bcbs-list-reset">
				'.$html.'
			</ul>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function boatFilter($ajax=true,$bookingForm=null)
	{		   
		if(!is_bool($ajax)) $ajax=true;
		
		$html=null;
		$response=array();
				
		$Validation=new BCBSValidation();
		
		$data=BCBSHelper::getPostOption();
		$data=BCBSBookingHelper::formatDateTimeToStandard($data);
		
		if(is_null($bookingForm))
		{
			if(!is_array($bookingForm=$this->checkBookingForm($data['booking_form_id'])))
			{
				if(!$ajax) return(false);

				$this->setErrorGlobal($response,esc_html__('There are no boats which match your filter criteria.','boat-charter-booking-system'));
				BCBSHelper::createJSONResponse($response);
			}
		}
		
		list($data['marina_departure_id'])=$this->getBookingFormMarinaDeparture($bookingForm);
		list($data['marina_return_id'])=$this->getBookingFormMarinaReturn($bookingForm);
		
		if(!$Validation->isNumber($data['guest_number'],1,999)) $data['guest_number']=1;	  
		
		/***/
		
		$boatHtml=array();
		$boatPrice=array();
			
		$categoryId=(int)$data['filter_boat_category'];
		
		foreach($bookingForm['dictionary']['boat_unavailable'] as $index=>$value)
		{
			$value['meta']['boat_unavailable']=1;
			$bookingForm['dictionary']['boat'][$index]=$value;
		}
		
		foreach($bookingForm['dictionary']['boat'] as $index=>$value)
		{
			if($categoryId>0)
			{
				if(!has_term($categoryId,BCBSBoat::getCPTCategoryName(),$index)) continue;
			}
			
			if(!($value['meta']['guest_number']>=$data['filter_boat_guest'])) continue;
			
			if((int)$data['filter_boat_marina_id']>0)
			{
				if(!in_array((int)$data['filter_boat_marina_id'],$value['meta']['marina_id'])) continue;
			}
			
			if((int)$bookingForm['meta']['captain_field_enable']===1)
			{
				if((int)$data['captain_status']===1)
				{
					if(!in_array($value['meta']['captain_status'],array(1,3))) continue;
				}
				if((int)$data['captain_status']===2)
				{
					if(!in_array($value['meta']['captain_status'],array(2,3))) continue;
				}				
			}
			
			$argument=array
			(
				'booking_form_id'=>$bookingForm['post']->ID,
				'boat'=>$value,
				'boat_id'=>$value['post']->ID,
				'boat_selected_id'=>$data['boat_id'],
				'marina_departure_id'=>$data['marina_departure_id'],
				'departure_date'=>$data['departure_date'],
				'departure_time'=>$data['departure_time'],
				'marina_return_id'=>$data['marina_return_id'],
				'return_date'=>$data['return_date'],
				'return_time'=>$data['return_time']
			);
			
			$price=0;
			
			$boatHtml[$index]=$this->createBoat($argument,$bookingForm,$price);
			$boatPrice[$index]=$price;
		}
		
		if(in_array((int)$bookingForm['meta']['boat_sorting_type'],array(1,2)))
		{
			asort($boatPrice);		 
			if((int)$bookingForm['meta']['boat_sorting_type']===2)
				$boatPrice=array_reverse($boatPrice,true);
		}
		
		foreach($boatPrice as $index=>$value)
		{
			if((int)$bookingForm['dictionary']['boat'][$index]['meta']['boat_unavailable']===0)
				$html.='<li>'.$boatHtml[$index].'</li>';
		}
		
		foreach($boatPrice as $index=>$value)
		{
			if((int)$bookingForm['dictionary']['boat'][$index]['meta']['boat_unavailable']===1)
				$html.='<li>'.$boatHtml[$index].'</li>';
		}		
		
		$response['html']=$html;
		
		if($Validation->isEmpty($html))
		{
			if($ajax)
			{
				$this->setErrorGlobal($response,esc_html__('There are no boats which match your filter criteria.','boat-charter-booking-system'));
				BCBSHelper::createJSONResponse($response);
			}
		}
		
		if(!$ajax) return($html);
		
		BCBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function checkCouponCode()
	{		
		$response=array();
		
		$data=BCBSHelper::getPostOption();
		$data=BCBSBookingHelper::formatDateTimeToStandard($data);
		
		if(!is_array($bookingForm=$this->checkBookingForm($data['booking_form_id'])))
		{
			$response['html']=null;
			BCBSHelper::createJSONResponse($response);
		}
		
		$response['html']=$this->createSummaryPriceElement($data,$bookingForm);
		
		$couponCodeSourceType=0;
		
		$Coupon=new BCBSCoupon();
		$coupon=$Coupon->checkCode($bookingForm,$couponCodeSourceType);
		
		$response['error']=$coupon===false ? 1 : 0;
		
		if($response['error']===1)
		   $response['message']=esc_html__('Provided coupon is invalid.','boat-charter-booking-system'); 
		else 
			$response['message']=esc_html__('Provided coupon is valid. Discount has been granted.','boat-charter-booking-system');
		
		BCBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/   
   
	function createClientFormSignIn($bookingForm)
	{
		$User=new BCBSUser();
		$WooCommerce=new BCBSWooCommerce();
		
		if(!$WooCommerce->isEnable($bookingForm['meta'])) return;
		if($User->isSignIn()) return;
		
		if((int)$bookingForm['meta']['woocommerce_account_enable_type']===0) return;
		
		$data=BCBSHelper::getPostOption();
		
		$html=
		'
			<div class="bcbs-client-form-sign-in">

				<div class="bcbs-form-panel">

					<h3>'.esc_html__('Sign In','boat-charter-booking-system').'</h3>

					<div class="bcbs-form-panel-content bcbs-clear-fix">					

						<div class="bcbs-clear-fix">
							<div class="bcbs-form-field bcbs-form-field-width-50">
								<label>'.esc_html__('Login *','boat-charter-booking-system').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_sign_in_login',false).'" value=""/>
							</div>
							<div class="bcbs-form-field bcbs-form-field-width-50">
								<label>'.esc_html__('Password *','boat-charter-booking-system').'</label>
								<input type="password" name="'.BCBSHelper::getFormName('client_sign_in_password',false).'" value=""/>
							</div>
						</div>

					</div>
				</div>
			
				<div class="bcbs-clear-fix bcbs-float-right">
				   <a href="#" class="bcbs-button bcbs-button-style-2 bcbs-button-sign-up">
						'.esc_html__('Don\'t Have an Account?','boat-charter-booking-system').'
				   </a> 
				   <a href="#" class="bcbs-button bcbs-button-style-1 bcbs-button-sign-in">
					   '.esc_html__('Sign In','boat-charter-booking-system').'
				   </a> 
				   <input type="hidden" name="'.BCBSHelper::getFormName('client_account',false).'" value="'.(int)$data['client_account'].'"/> 
				</div>

			</div>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function createClientFormSignUp($bookingForm,$userData=array(),$marinaDepartureId=-1)
	{
		$User=new BCBSUser();
		$WooCommerce=new BCBSWooCommerce();
		$BookingFormElement=new BCBSBookingFormElement();
		
		/***/
		
		$data=BCBSHelper::getPostOption();
		if(count($userData)) $data=$userData;

		/***/
		
		$html=null;
		$htmlElement=array(null,null,null,null,null,null);
		
		$htmlElementCountry=null;
		
		$countryAvailable=array(-1);
		if(array_key_exists($marinaDepartureId,$bookingForm['dictionary']['marina']))
			$countryAvailable=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['country_available'];
		
		foreach($bookingForm['dictionary']['country'] as $index=>$value)
		{	
			if((in_array(-1,$countryAvailable)) || (in_array($index,$countryAvailable)))
				$htmlElementCountry.='<option value="'.esc_attr($index).'" '.($data['client_billing_detail_country_code']==$index ? 'selected' : null).'>'.esc_html($value[0]).'</option>';
		}
		
		$htmlElement[1]=$BookingFormElement->createField(1,$bookingForm['meta']);
		
		$htmlElement[2]=$BookingFormElement->createField(2,$bookingForm['meta']);
		
		$panel=$BookingFormElement->getPanel($bookingForm['meta']);
		foreach($panel as $index=>$value)
		{
			if(in_array($value['id'],array(1,2))) continue;
			$htmlElement[3].=$BookingFormElement->createField($value['id'],$bookingForm['meta']);
		}
		
		if($WooCommerce->isEnable($bookingForm['meta']))
		{
			if(!$User->isSignIn())
			{
				if(in_array((int)$bookingForm['meta']['woocommerce_account_enable_type'],array(1,2)))
				{
					$class=array(array('bcbs-form-checkbox'),array('bcbs-disable-section'));
					
					if(in_array((int)$bookingForm['meta']['woocommerce_account_enable_type'],array(2)))
					{
						
					}
					else
					{
						if((int)$data['client_sign_up_enable']===0)
						{
							array_push($class[1],'bcbs-hidden');
						}
						else
						{
							array_push($class[0],'bcbs-state-selected');
						}
					}			
					
					$htmlElement[4].=
					'
						<div class="bcbs-form-panel">
							
					';
					
					if(in_array((int)$bookingForm['meta']['woocommerce_account_enable_type'],array(2)))
					{
						unset($class[1][0]);
						$htmlElement[4].='<h3>'.esc_html__('New account','boat-charter-booking-system').'</h3>';
					}
					else
					{
						$htmlElement[4].=
						'
							<div>
								<span'.BCBSHelper::createCSSClassAttribute($class[0]).'>
									<span class="bcbs-meta-icon-24-tick"></span>
								</span>
								<input type="hidden" name="'.BCBSHelper::getFormName('client_sign_up_enable',false).'" value="'.esc_attr($data['client_sign_up_enable']).'"/> 
							</div>	 
							<h3>'.esc_html__('Create an account?','boat-charter-booking-system').'</h3>
						';						
					}					
	
					$htmlElement[4].=
					'
							<div class="bcbs-form-panel-content bcbs-clear-fix">			   

								<div>

									<div class="bcbs-clear-fix">
										<div class="bcbs-form-field bcbs-form-field-width-33">
											<label>'.esc_html__('Login','boat-charter-booking-system').'</label>
											<input type="text" name="'.BCBSHelper::getFormName('client_sign_up_login',false).'"/>
										</div>
										<div class="bcbs-form-field bcbs-form-field-width-33">
											<label>
												'.esc_html__('Password','boat-charter-booking-system').'
												&nbsp;
												<a href="#" class="bcbs-sign-up-password-generate">'.esc_html__('Generate','boat-charter-booking-system').'</a>
												<a href="#" class="bcbs-sign-up-password-show">'.esc_html__('Show','boat-charter-booking-system').'</a>
											</label>
											<input type="password" name="'.BCBSHelper::getFormName('client_sign_up_password',false).'"/>
										</div>
										<div class="bcbs-form-field bcbs-form-field-width-33">
											<label>'.esc_html__('Re-type password','boat-charter-booking-system').'</label>
											<input type="password" name="'.BCBSHelper::getFormName('client_sign_up_password_retype',false).'"/>
										</div>
									</div>

								</div>

								<div'.BCBSHelper::createCSSClassAttribute($class[1]).'></div>

							</div>

						</div>
					';
				}
			}
		}
				
		/***/
		
		$class=array(array('bcbs-client-form-sign-up','bcbs-hidden'),array('bcbs-form-checkbox'),array('bcbs-disable-section'));
		
		if($WooCommerce->isEnable($bookingForm['meta']))
		{
			if(($User->isSignIn()) || ((int)$data['client_account']===1) || ((int)$bookingForm['meta']['woocommerce_account_enable_type']===0)) unset($class[0][1]);
		}  
		else unset($class[0][1]);
		
		if((int)$bookingForm['meta']['billing_detail_state']===3)
		{
			$data['client_billing_detail_enable']=1;
			array_push($class[1],'bcbs-state-selected-mandatory');
		}
		elseif((int)$bookingForm['meta']['billing_detail_state']===2)
		{
			if(!array_key_exists('client_billing_detail_enable',$data))
				$data['client_billing_detail_enable']=1;
		}
		
		if((int)$data['client_billing_detail_enable']===1)
		{
			array_push($class[1],'bcbs-state-selected');
			array_push($class[2],'bcbs-hidden');
		}
		
		$html=
		'
			<div'.BCBSHelper::createCSSClassAttribute($class[0]).'>

				<div class="bcbs-form-panel">
 
					<h3>'.esc_html__('Customer details','boat-charter-booking-system').'</h3>

					<div class="bcbs-form-panel-content bcbs-clear-fix">

						<div class="bcbs-clear-fix">
							<div class="bcbs-form-field bcbs-form-field-width-50">
								<label>'.esc_html__('First name *','boat-charter-booking-system').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_contact_detail_first_name',false).'" value="'.esc_attr($data['client_contact_detail_first_name']).'"/>
							</div>
							<div class="bcbs-form-field bcbs-form-field-width-50">
								<label>'.esc_html__('Last name *','boat-charter-booking-system').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_contact_detail_last_name',false).'" value="'.esc_attr($data['client_contact_detail_last_name']).'"/>
							</div>
						</div>

						<div class="bcbs-clear-fix">
							<div class="bcbs-form-field bcbs-form-field-width-50">
								<label>'.esc_html__('E-mail address *','boat-charter-booking-system').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_contact_detail_email_address',false).'"  value="'.esc_attr($data['client_contact_detail_email_address']).'"/>
							</div>
							<div class="bcbs-form-field bcbs-form-field-width-50">
								<label>'.esc_html__('Phone number','boat-charter-booking-system').(in_array('client_contact_detail_phone_number',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_contact_detail_phone_number',false).'"  value="'.esc_attr($data['client_contact_detail_phone_number']).'"/>
							</div>
						</div>

						'.$htmlElement[5].'

						<div class="bcbs-clear-fix">
							<div class="bcbs-form-field">
								<label>'.esc_html__('Comments','boat-charter-booking-system').'</label>
								<textarea name="'.BCBSHelper::getFormName('comment',false).'">'.esc_html($data['comment']).'</textarea>
							</div>
						</div>

						'.$htmlElement[1].'
													  
					</div>
					
				</div>
				
				'.$htmlElement[4].'
		';
		
		/***/
		
		if((int)$bookingForm['meta']['billing_detail_state']===4) return($html.$htmlElement[3].'</div>');
		
		/***/
		
		$html.=
		'	   
				<div class="bcbs-form-panel">
 
					<div>
						<span'.BCBSHelper::createCSSClassAttribute($class[1]).'>
							<span class="bcbs-meta-icon-24-tick"></span>
						</span>
						<input type="hidden" name="'.BCBSHelper::getFormName('client_billing_detail_enable',false).'" value="'.esc_attr($data['client_billing_detail_enable']).'"/> 
					</div>
					
					<h3>'.esc_html__('Billing address','boat-charter-booking-system').'</h3>
					
					<div class="bcbs-form-panel-content bcbs-clear-fix">

						<div class="bcbs-clear-fix">
							<div class="bcbs-form-field bcbs-form-field-width-50">
								<label>'.esc_html__('Company registered name','boat-charter-booking-system').(in_array('client_billing_detail_company_name',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_billing_detail_company_name',false).'" value="'.esc_attr($data['client_billing_detail_company_name']).'"/>
							</div>
							<div class="bcbs-form-field bcbs-form-field-width-50">
								<label>'.esc_html__('Tax number','boat-charter-booking-system').(in_array('client_billing_detail_tax_number',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_billing_detail_tax_number',false).'" value="'.esc_attr($data['client_billing_detail_tax_number']).'"/>
							</div>
						</div>

						<div class="bcbs-clear-fix">
							<div class="bcbs-form-field bcbs-form-field-width-33">
								<label>'.esc_html__('Street','boat-charter-booking-system').(in_array('client_billing_detail_street_name',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_billing_detail_street_name',false).'" value="'.esc_attr($data['client_billing_detail_street_name']).'"/>
							</div>
							<div class="bcbs-form-field bcbs-form-field-width-33">
								<label>'.esc_html__('Street number','boat-charter-booking-system').(in_array('client_billing_detail_street_number',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_billing_detail_street_number',false).'" value="'.esc_attr($data['client_billing_detail_street_number']).'"/>
							</div>
							<div class="bcbs-form-field bcbs-form-field-width-33">
								<label>'.esc_html__('City','boat-charter-booking-system').(in_array('client_billing_detail_city',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_billing_detail_city',false).'" value="'.esc_attr($data['client_billing_detail_city']).'"/>
							</div>					
						</div>

						<div class="bcbs-clear-fix">
							<div class="bcbs-form-field bcbs-form-field-width-33">
								<label>'.esc_html__('State','boat-charter-booking-system').(in_array('client_billing_detail_state',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_billing_detail_state',false).'" value="'.esc_attr($data['client_billing_detail_state']).'"/>
							</div>
							<div class="bcbs-form-field bcbs-form-field-width-33">
								<label>'.esc_html__('Postal code','boat-charter-booking-system').(in_array('client_billing_detail_postal_code',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.BCBSHelper::getFormName('client_billing_detail_postal_code',false).'" value="'.esc_attr($data['client_billing_detail_postal_code']).'"/>
							</div>
							<div class="bcbs-form-field bcbs-form-field-width-33">
								<label>'.esc_html__('Country','boat-charter-booking-system').(in_array('client_billing_detail_country_code',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<select name="'.BCBSHelper::getFormName('client_billing_detail_country_code',false).'" value="'.esc_attr($data['client_billing_detail_country_code']).'">
								'.$htmlElementCountry.'
								</select>
							</div>					
						</div>  

						'.$htmlElement[2].'
							
						<div'.BCBSHelper::createCSSClassAttribute($class[2]).'></div>
					
					</div>
					
				</div>
				
				'.$htmlElement[3].'
				
			</div>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function userSignIn()
	{
		$data=BCBSHelper::getPostOption();
		$data=BCBSBookingHelper::formatDateTimeToStandard($data);
		
		$response=array('user_sign_in'=>0);
		
		if(!is_array($bookingForm=$this->checkBookingForm($data['booking_form_id'])))
		{
			$this->setErrorGlobal($response,esc_html__('Login error.','boat-charter-booking-system'));
			BCBSHelper::createJSONResponse($response);
		}
		
		$User=new BCBSUser();
		$WooCommerce=new BCBSWooCommerce();
		
		if(!$User->signIn($data['client_sign_in_login'],$data['client_sign_in_password']))
			$this->setErrorGlobal($response,esc_html__('Login error.','boat-charter-booking-system'));
		else 
		{
			$userData=$WooCommerce->getUserData();
			
			$response['user_sign_in']=1;  
			
			$response['summary']=$this->createSummary($data,$bookingForm);
			$response['client_form_sign_up']=$this->createClientFormSignUp($bookingForm,$userData);
		}
		
		BCBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function fileUpload()
	{			
		$response=array();
		
		if(!is_array($_FILES))
			BCBSHelper::createJSONResponse($response);
   
		$name=key($_FILES);
		
		if(!is_array($_FILES[$name]))
			BCBSHelper::createJSONResponse($response);
	  
		$fileName=BCBSHelper::createId();
		
		move_uploaded_file($_FILES[$name]['tmp_name'],dirname($_FILES[$name]['tmp_name']).'/'.$fileName);
		
		$response['name']=$_FILES[$name]['name'];
		$response['type']=$_FILES[$name]['type'];
		
		$response['tmp_name']=$fileName;
		
		BCBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function getBookingFormMarinaDeparturePeriod($meta)
	{
		$date=array();
		
		$Date=new BCBSDate();
		$Validation=new BCBSValidation();
		
		$type=array(1=>'days',2=>'hours',3=>'minutes');
		
		/***/
		
		$timeStart=date_i18n('G:i');
		$dateStart=date_i18n('d-m-Y');
		
		$dateTimeStart=$dateStart.' '.$timeStart;
		
		$dayNumber=$Date->getDayNumberOfWeek($dateTimeStart);
		
		for($i=1;$i<=7;$i++)
		{		
			$businessHourStart=$meta['business_hour'][$dayNumber]['start'];
			$businessHourStop=$meta['business_hour'][$dayNumber]['stop'];
		
			if(($Validation->isNotEmpty($businessHourStart)) && ($Validation->isNotEmpty($businessHourStop)))
			{
				if($i===1)
				{
					if($Date->timeInRange($timeStart,$businessHourStart,$businessHourStop))
					{
						break;
					}
				}
				else
				{					
					$dateTimeStart=date('d-m-Y',strtotime($dateStart.' +'.($i-1).' day')).' '.$businessHourStart;
					break;
				}
			}
			
			$dayNumber++;
			if($dayNumber===7) $dayNumber=1;
		}
		
		$dateStart=$dateTimeStart;
		
		/***/
			  
		$dateStart=strtotime('+ '.(int)$meta['departure_period_type'].' '.$type[(int)$meta['departure_period_type']],strtotime($dateStart));
				
		$offset=(int)$meta['departure_period_from'];
		
		if((int)$meta['departure_period_type']===1)
		   $offset*=24;
		if((int)$meta['departure_period_type']===3)
			$offset*=3600;	   
		
		/***/
		
		if($Validation->isEmpty($meta['departure_period_to'])) $dateStop=null;
		else $dateStop=strtotime('+ '.(int)$meta['departure_period_to'].' '.$type[(int)$meta['departure_period_type']],$dateStart);
	 
		/***/
		
		$date['min']=date_i18n('d-m-Y H:i:s',$dateStart);
		$date['max']=is_null($dateStop) ? null : date_i18n('d-m-Y H:i:s',$dateStop);

		return($date);
	}
	
	/**************************************************************************/
	
	function getDatePickupPeriod($data,$marina,$type,$delta)
	{
		$date=array();
		
		if((int)$marina['meta']['departure_period_type']===1)
		{
			$date[0]=$data[$type.'_date'];
			$date[1]=date_i18n('d-m-Y',BCBSDate::strtotime('+'.$delta.' days'));
		}
		elseif((int)$marina['meta']['departure_period_type']===2)
		{
			$date[0]=$data[$type.'_date'].' '.$data[$type.'_time'];
			$date[1]=date_i18n('d-m-Y H:i',BCBSDate::strtotime('+'.$delta.' hours'));							
		}
		elseif((int)$marina['meta']['departure_period_type']===3)
		{
			$date[0]=$data[$type.'_date'].' '.$data[$type.'_time'];
			$date[1]=date_i18n('d-m-Y H:i',BCBSDate::strtotime('+'.$delta.' minutes'));							
		} 
	 
		return($date);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/