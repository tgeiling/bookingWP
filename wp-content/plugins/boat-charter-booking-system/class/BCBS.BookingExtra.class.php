<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBookingExtra
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->priceType=array
		(
			1=>array(esc_html__('Price per entire rental period x quantity','boat-charter-booking-system')),
			2=>array(esc_html__('Price per single day x quantity','boat-charter-booking-system'))
		);
	}
	
	/**************************************************************************/
	
	public function getPriceType()
	{
		return($this->priceType);
	}
	
	/**************************************************************************/
	
	public function isPriceType($piceTypeId)
	{
		return(array_key_exists($piceTypeId,$this->priceType) ? true : false);
	}
		
	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_BCBS_CONTEXT.'_booking_extra');
	}
	
	/**************************************************************************/
	
	public static function getCPTCategoryName()
	{
		return(self::getCPTName().'_c');
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
					'name'=>esc_html__('Booking Extras','boat-charter-booking-system'),
					'singular_name'=>esc_html__('Booking Extra','boat-charter-booking-system'),
					'add_new'=>esc_html__('Add New','boat-charter-booking-system'),
					'add_new_item'=>esc_html__('Add New Booking Add-on','boat-charter-booking-system'),
					'edit_item'=>esc_html__('Edit Booking Extra','boat-charter-booking-system'),
					'new_item'=>esc_html__('New Booking Extra','boat-charter-booking-system'),
					'all_items'=>esc_html__('Booking Extras','boat-charter-booking-system'),
					'view_item'=>esc_html__('View Booking Extra','boat-charter-booking-system'),
					'search_items'=>esc_html__('Search Booking Extras','boat-charter-booking-system'),
					'not_found'=>esc_html__('No Booking Extras Found','boat-charter-booking-system'),
					'not_found_in_trash'=>esc_html__('No Booking Extras Found in Trash','boat-charter-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Booking Extras','boat-charter-booking-system')
				),
				'public'=>false,
				'show_ui'=>true,
				'show_in_menu'=>'edit.php?post_type='.BCBSBooking::getCPTName(),
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>array('title','page-attributes')
			)
		);
		
		register_taxonomy
		(
			self::getCPTCategoryName(),
			self::getCPTName(),
			array
			(
				'label'=>esc_html__('Booking Extra Categories','boat-charter-booking-system'),
				'hierarchical'=>false
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_bcbs_meta_box_booking_extra',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_booking_extra',esc_html__('Main','boat-charter-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$data=array();
		
		$Boat=new BCBSBoat();
		$Marina=new BCBSMarina();
		$TaxRate=new BCBSTaxRate();
		
		$data['meta']=BCBSPostMeta::getPostMeta($post);
		
		$data['nonce']=BCBSHelper::createNonceField(PLUGIN_BCBS_CONTEXT.'_meta_box_booking_extra');
		
		$data['dictionary']['boat']=$Boat->getDictionary();
		$data['dictionary']['marina']=$Marina->getDictionary();
		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
		$data['dictionary']['price_type']=$this->getPriceType();
		
		$data['dictionary']['boat']=$Boat->getDictionary();
		
		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/meta_box_booking_extra.php');			
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
		$Boat=new BCBSBoat();
		$Marina=new BCBSMarina();
		$TaxRate=new BCBSTaxRate();
		
		BCBSHelper::setDefault($meta,'marina_id',array());
		
		BCBSHelper::setDefault($meta,'description','');
		
		BCBSHelper::setDefault($meta,'quantity_minimum','1');
		BCBSHelper::setDefault($meta,'quantity_default','1');
		BCBSHelper::setDefault($meta,'quantity_maximum','9999');
		BCBSHelper::setDefault($meta,'quantity_equal_rental_day_number',0);
		BCBSHelper::setDefault($meta,'quantity_readonly_enable',0);
		
		BCBSHelper::setDefault($meta,'button_select_default_state',0);
		
		BCBSHelper::setDefault($meta,'price','0.00');
		BCBSHelper::setDefault($meta,'tax_rate_id',$TaxRate->getDefaultTaxPostId());
		BCBSHelper::setDefault($meta,'price_type',1);
		
		$dictionaryBoat=BCBSGlobalData::setGlobalData('dictionary_boat',array($Boat,'getDictionary'));
		$dictionaryMarina=BCBSGlobalData::setGlobalData('dictionary_marina',array($Marina,'getDictionary'));

		foreach($dictionaryMarina as $marinaIndex=>$marinaValue)
		{
			foreach($dictionaryBoat as $boatIndex=>$boatValue)
			{
				if(isset($meta['boat'][$marinaIndex][$boatIndex])) continue;
				
				$meta['boat'][$marinaIndex][$boatIndex]['enable']=1;
				$meta['boat'][$marinaIndex][$boatIndex]['price']='';
				$meta['boat'][$marinaIndex][$boatIndex]['tax_rate_id']=-1;
			}
		}
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(BCBSHelper::checkSavePost($postId,PLUGIN_BCBS_CONTEXT.'_meta_box_booking_extra_noncename','savePost')===false) return(false);
		
		$Boat=new BCBSBoat();
		$Marina=new BCBSMarina();
		$TaxRate=new BCBSTaxRate();
		$Validation=new BCBSValidation();
		
		$option=BCBSHelper::getPostOption();
	  
		/***/
   
		if(!$Validation->isNumber($option['quantity_minimum'],1,9999))
			$option['quantity_minimum']=1;
		if(!$Validation->isNumber($option['quantity_default'],1,9999))
			$option['quantity_default']=1;	
		if(!$Validation->isNumber($option['quantity_maximum'],1,9999))
			$option['quantity_maximum']=9999;			
		
		if($option['quantity_minimum']>$option['quantity_maximum'])
			$option['quantity_minimum']=1;
		if(!(($option['quantity_default']>$option['quantity_minimum']) && ($option['quantity_default']<$option['quantity_maximum'])))
			$option['quantity_default']=$option['quantity_minimum'];
		
		if(!$Validation->isBool($option['quantity_equal_rental_day_number']))
			$option['quantity_equal_rental_day_number']=0;		
		if(!$Validation->isBool($option['quantity_readonly_enable']))
			$option['quantity_readonly_enable']=0;		
		
		/***/
		
		if(!in_array($option['button_select_default_state'],array(0,1,2)))
			$option['button_select_default_state']=0;
		
		/***/

		if(!$Validation->isPrice($option['price'],false))
		   $option['price']=0.00;  
		if(!$TaxRate->isTaxRate($option['tax_rate_id']))
			$option['tax_rate_id']=0;
		if(!$this->isPriceType($option['price_type']))
			$option['price_type']=1;		
		
		/***/
		
		$key=array
		(
			'description',
			'quantity_minimum',
			'quantity_default',
			'quantity_maximum',
			'quantity_equal_rental_day_number',
			'quantity_readonly_enable',
			'button_select_default_state',
			'price',
			'tax_rate_id',
			'price_type'
		);
		
		foreach($key as $value)
			BCBSPostMeta::updatePostMeta($postId,$value,$option[$value]);
		
		/***/
		
		$boat=array();
		
		$boatDictionary=$Boat->getDictionary();
		$marinaDictionary=$Marina->getDictionary();
		
		foreach($marinaDictionary as $marinaIndex=>$marinaValue)
		{
			foreach($boatDictionary as $boatIndex=>$boatValue)
			{
				if(!isset($option['boat'][$marinaIndex])) continue;
				if(!isset($option['boat'][$marinaIndex][$boatIndex])) continue;
				
				if(!$Validation->isBool($option['boat'][$marinaIndex][$boatIndex]['enable']))
					$option['boat'][$marinaIndex][$boatIndex]['enable']=0;

				if(!$Validation->isPrice($option['boat'][$marinaIndex][$boatIndex]['price'],false))
					$option['boat'][$marinaIndex][$boatIndex]['price']='';

				if(!$TaxRate->isTaxRate($option['boat'][$marinaIndex][$boatIndex]['tax_rate_id']))
					$option['boat'][$marinaIndex][$boatIndex]['tax_rate_id']=0;

				$boat[$marinaIndex][$boatIndex]=array
				(
					'enable'=>$option['boat'][$marinaIndex][$boatIndex]['enable'],
					'price'=>$option['boat'][$marinaIndex][$boatIndex]['price'],
					'tax_rate_id'=>$option['boat'][$marinaIndex][$boatIndex]['tax_rate_id']
				);
			}
		}
		
		BCBSPostMeta::updatePostMeta($postId,'boat',$boat);
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'booking_extra_id'=>0,
			'category_id'=>array()
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		BCBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc')
		);
		
		if($attribute['booking_extra_id'])
			$argument['p']=$attribute['booking_extra_id'];

		if(!is_array($attribute['category_id']))
			$attribute['category_id']=array($attribute['category_id']);

		if(array_sum($attribute['category_id']))
		{
			$argument['tax_query']=array
			(
				array
				(
					'taxonomy'=>self::getCPTCategoryName(),
					'field'=>'term_id',
					'terms'=>$attribute['category_id'],
					'operator'=>'IN'
				)
			);
		}

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
	
	function getCategory()
	{
		$category=array();
		
		$result=get_terms(self::getCPTCategoryName());
		if(is_wp_error($result)) return($category);
		
		foreach($result as $value)
			$category[$value->{'term_id'}]=array('name'=>$value->{'name'});
		
		return($category);
	}
	
	/**************************************************************************/
	
	function manageEditColumns($column)
	{
		$column=array
		(
			'cb'=>$column['cb'],
			'title'=>esc_html__('Title','boat-charter-booking-system'),
			'price'=>esc_html__('Price','boat-charter-booking-system')
		);
   
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$meta=BCBSPostMeta::getPostMeta($post);
		
		switch($column) 
		{
			case 'price':
				
				echo BCBSPrice::format($meta['price'],BCBSOption::getOption('currency'));
				
			break;
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
		
	/**************************************************************************/
	
	function calculatePrice($bookingExtra,$bookingForm)
	{
		$Currency=new BCBSCurrency();
		$Validation=new BCBSValidation();
		
		/***/
	
		$price=array();
		$currency=$Currency->getCurrency(BCBSCurrency::getFormCurrency());
		
		/***/
		
		foreach($bookingForm['dictionary']['marina'] as $marinaIndex=>$marinaValue)
		{
			foreach($bookingForm['dictionary']['boat'] as $boatIndex=>$boatValue)
			{			
				$priceNetValue=$bookingExtra['meta']['price'];
				$taxRateId=$bookingExtra['meta']['tax_rate_id'];
				
				if((array_key_exists($marinaIndex,$bookingExtra['meta']['boat'])) && (array_key_exists($boatIndex,$bookingExtra['meta']['boat'][$marinaIndex])))
				{
					if($Validation->isPrice($bookingExtra['meta']['boat'][$marinaIndex][$boatIndex]['price']))
						$priceNetValue=$bookingExtra['meta']['boat'][$marinaIndex][$boatIndex]['price'];
					if(array_key_exists($bookingExtra['meta']['boat'][$marinaIndex][$boatIndex]['tax_rate_id'],$bookingForm['dictionary']['tax_rate']))
						$taxRateId=$bookingExtra['meta']['boat'][$marinaIndex][$boatIndex]['tax_rate_id'];
				}
			
				$taxRateValue=0;
				if(isset($bookingForm['dictionary']['tax_rate'][$taxRateId]))
					$taxRateValue=$bookingForm['dictionary']['tax_rate'][$taxRateId]['meta']['tax_rate_value'];		
			
				/***/
			
				$priceNetValue=number_format($priceNetValue*BCBSCurrency::getExchangeRate(),2,'.',''); 
				$priceGrossValue=BCBSPrice::calculateGross($priceNetValue,$taxRateId);
				
				$sumNetValue=$priceNetValue*$bookingExtra['quantity'];
				$sumGrossValue=$priceGrossValue*$bookingExtra['quantity'];

				$priceGrossFormat=BCBSPrice::format($priceGrossValue,BCBSCurrency::getFormCurrency());
				$sumGrossFormat=BCBSPrice::format($sumGrossValue,BCBSCurrency::getFormCurrency());

				$priceNetValue=number_format($priceNetValue,2,'.','');
				$priceGrossValue=number_format($priceGrossValue,2,'.','');	   
				
				/***/

				$suffix=null;

				if((int)$bookingExtra['meta']['price_type']==1)
				{
					$suffix=esc_html__(' per entire period x quantity','boat-charter-booking-system');
				}
				else 
				{
					$suffix=esc_html__(' per day x quantity','boat-charter-booking-system'); 
				}

				/***/
		
				$price[$marinaIndex][$boatIndex]=array
				(
					'price'=>array
					(
						'net'=>array
						(
							'value'=>$priceNetValue,
						),
						'gross'=>array
						(
							'value'=>$priceGrossValue,
							'format'=>$priceGrossFormat
						)
					),
					'sum'=>array
					(
						'net'=>array
						(
							'value'=>$sumNetValue,
						),
						'gross'=>array
						(
							'value'=>$sumGrossValue,
							'format'=>$sumGrossFormat
						)
					),
					'tax_rate_id'=>$taxRateId,
					'enable'=>$bookingExtra['meta']['boat'][$marinaIndex][$boatIndex]['enable'],
					'suffix'=>$suffix,
					'currency'=>$currency
				);
			}
		}
		
		/***/
		
		foreach($price as $priceMarinaIndex=>$priceMarinaValue)
		{
			foreach($priceMarinaValue as $priceBoatIndex=>$priceBoatValue)
			{
				if(!array_key_exists(-1,$price[$priceMarinaIndex]))
				{
					$price[$priceMarinaIndex][-1]=array
					(
						'enable'=>$priceBoatValue['enable'],
						'suffix'=>$priceBoatValue['suffix'],
						'tax_rate_id'=>$priceBoatValue['tax_rate_id'],
						'price_net_value'=>$priceBoatValue['price']['net']['value'],
						'price_gross_value'=>$priceBoatValue['price']['gross']['value'],
						'price_gross_format'=>$priceBoatValue['price']['gross']['format'],
					);
				}
				else
				{
					if($price[$priceMarinaIndex][-1]['enable']!=$priceBoatValue['enable'])
					{
						$price[$priceMarinaIndex][-1]['enable']=-1;
					}
					
					if(($price[$priceMarinaIndex][-1]['tax_rate_id']!=$priceBoatValue['tax_rate_id']) || ($price[$priceMarinaIndex][-1]['suffix']!=$priceBoatValue['suffix']) || ($price[$priceMarinaIndex][-1]['price_net_value']!=$priceBoatValue['price']['net']['value']) || ($price[$priceMarinaIndex][-1]['price_gross_value']!=$priceBoatValue['price']['gross']['value']) || ($price[$priceMarinaIndex][-1]['price_gross_format']!=$priceBoatValue['price']['gross']['format']))
					{
						$price[$priceMarinaIndex][-1]['suffix']=-1;
						$price[$priceMarinaIndex][-1]['tax_rate_id']=-1;
						$price[$priceMarinaIndex][-1]['price_net_value']=-1;
						$price[$priceMarinaIndex][-1]['price_gross_value']=-1;
						$price[$priceMarinaIndex][-1]['price_gross_format']=-1;
					}
				}
			}
		}

		/***/
	
		return($price);
	}
	
	/**************************************************************************/
	
	function validate($data,$bookingForm)
	{	
		$bookingExtraDictionary=$bookingForm['dictionary']['booking_extra'];
		
		$bookingExtra=array();
		$bookingExtraId=preg_split('/,/',$data['booking_extra_id']);
		
		foreach($bookingExtraDictionary as $index=>$value)
		{
			if((int)$value['meta']['button_select_default_state']===2)
				array_push($bookingExtraId,$index);
		}
		
		$bookingExtraId=array_unique($bookingExtraId,SORT_NUMERIC);
		
		$marinaDepartureId=$bookingForm['marina_departure_id'];
		
		foreach($bookingExtraId as $value)
		{
			if(array_key_exists($value,$bookingExtraDictionary))
			{
				if(!array_key_exists('booking_extra_'.$value.'_quantity',$data)) continue;
				
				$quantity=$this->validateQuantity($data,$value,$bookingExtraDictionary[$value]);
		
				/***/
				
				$priceBookingExtra=$this->calculatePrice($bookingExtraDictionary[$value],$bookingForm);
				
				/***/
				
				$enable=true;
				
				if((int)$priceBookingExtra[$marinaDepartureId][-1]['enable']===-1)
				{
					if($data['boat_id']>0)
					{
						if((int)$priceBookingExtra[$marinaDepartureId][$data['boat_id']]['enable']===0) $enable=false;
					}
				}
				else
				{
					if((int)$priceBookingExtra[$marinaDepartureId][-1]['enable']===0) $enable=false;
				}
				
				if(!$enable) continue;
				
				/***/
				
				$priceNet=0.00;
				$taxRateId=0;

				if($data['boat_id']>0)
				{
					$priceNet=$priceBookingExtra[$marinaDepartureId][$data['boat_id']]['price']['net']['value'];
					$taxRateId=$priceBookingExtra[$marinaDepartureId][$data['boat_id']]['tax_rate_id'];				
				}
				else
				{
					if((int)$priceBookingExtra[$marinaDepartureId][-1]['price_net_value']!==-1)
					{
						$priceNet=$priceBookingExtra[$marinaDepartureId][-1]['price_net_value'];
						$taxRateId=$priceBookingExtra[$marinaDepartureId][-1]['tax_rate_id'];									
					}
				}
				
				/***/
				
				if(BCBSCurrency::getBaseCurrency()!=BCBSCurrency::getFormCurrency())
				{				
					$rate=0;
					$dictionary=BCBSOption::getOption('currency_exchange_rate');
					
					if(array_key_exists(BCBSCurrency::getFormCurrency(),$dictionary))
						$rate=$dictionary[BCBSCurrency::getFormCurrency()];

					$priceNet*=$rate;
				}
				
				/***/
				
				$priceNet=BCBSPrice::numberFormat($priceNet);
				$priceGross=BCBSPrice::numberFormat(BCBSPrice::calculateGross($priceNet,$taxRateId));
				
				$sumNet=$priceNet*$quantity;
				$sumGross=$priceGross*$quantity;
				
				if($bookingExtraDictionary[$value]['meta']['price_type']==2)
				{
					$period=BCBSBookingHelper::calculateRentalPeriod($data['departure_date'],$data['departure_time'],$data['return_date'],$data['return_time']);
					$sumNet*=$period['day'];
					$sumGross*=$period['day'];
				}
				
				$taxValue=0;
				if(isset($bookingForm['dictionary']['tax_rate'][$taxRateId]))
					$taxValue=$bookingForm['dictionary']['tax_rate'][$taxRateId]['meta']['tax_rate_value'];

				/***/	
				
				array_push($bookingExtra,array
				(
					'id'=>$value,
					'name'=>$bookingExtraDictionary[$value]['post']->post_title,
					'price'=>$priceNet,
					'price_gross'=>$priceGross,
					'price_type'=>$bookingExtraDictionary[$value]['meta']['price_type'],
					'quantity'=>$quantity,
					'tax_rate_value'=>$taxValue,
					'sum_net'=>$sumNet,
					'sum_gross'=>$sumGross
				));
			}
		}

		return($bookingExtra);
	}
	
	/**************************************************************************/
	
	function validateQuantity($data,$bookingExtraId,$bookingExtra)
	{
		$Validation=new BCBSValidation();
		
		$name='booking_extra_'.$bookingExtraId.'_quantity';
		
		$quantity=0;
		
		if((int)BCBSOption::getOption('billing_type')===2)
		{
			if((int)$bookingExtra['meta']['quantity_equal_rental_day_number']===1)
			{
				$period=BCBSBookingHelper::calculateRentalPeriod($data['departure_date'],$data['departure_time'],$data['return_date'],$data['return_time']);
				
				$quantity=$period['day'];
				
				if((int)$bookingExtra['meta']['quantity_readonly_enable']===1) return($quantity);
			}
		}
		
		if(array_key_exists($name,$data)) $quantity=(int)$data[$name];
		
		if(!$Validation->isNumber($quantity,1,9999)) $quantity=(int)$bookingExtra['meta']['quantity_default'];
		
		if(!(($quantity>=$bookingExtra['meta']['quantity_minimum']) && ($quantity<=$bookingExtra['meta']['quantity_maximum'])))
			$quantity=(int)$bookingExtra['meta']['quantity_default'];
		
		return($quantity);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/