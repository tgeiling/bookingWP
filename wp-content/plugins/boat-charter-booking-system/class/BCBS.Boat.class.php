<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBoat
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->captainStatus=array
		(
			1=>array(esc_html__('With Captain','boat-charter-booking-system')),
			2=>array(esc_html__('Without Captain','boat-charter-booking-system')),
			3=>array(esc_html__('With or Without Captain','boat-charter-booking-system'))
		);
	}
	
	/**************************************************************************/
	
	function getCaptainStatus()
	{
		return($this->captainStatus);
	}
	
	/**************************************************************************/
	
	function getCaptainStatusName($index)
	{
		if(!array_key_exists($index,$this->getCaptainStatus())) return(null);
		return($this->captainStatus[$index][0]);
	}
	
	/**************************************************************************/
	
	function isCaptainStatus($index)
	{
		if(!array_key_exists($index,$this->getCaptainStatus())) return(false);
		return(true);
	}
		
	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_BCBS_CONTEXT.'_boat');
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
					'name'=>esc_html__('Boats','boat-charter-booking-system'),
					'singular_name'=>esc_html__('Boat','boat-charter-booking-system'),
					'add_new'=>esc_html__('Add New','boat-charter-booking-system'),
					'add_new_item'=>esc_html__('Add New Boat','boat-charter-booking-system'),
					'edit_item'=>esc_html__('Edit Boat','boat-charter-booking-system'),
					'new_item'=>esc_html__('New Boat','boat-charter-booking-system'),
					'all_items'=>esc_html__('Boats','boat-charter-booking-system'),
					'view_item'=>esc_html__('View Boat','boat-charter-booking-system'),
					'search_items'=>esc_html__('Search Boats','boat-charter-booking-system'),
					'not_found'=>esc_html__('No Boats Found','boat-charter-booking-system'),
					'not_found_in_trash'=>esc_html__('No Boats Found in Trash','boat-charter-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Boats','boat-charter-booking-system')
				),
				'public'=>false,
				'show_ui'=>true,
				'show_in_menu'=>'edit.php?post_type='.BCBSBooking::getCPTName(),
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>array('title','editor','page-attributes','thumbnail')
			)
		);
		
		register_taxonomy
		(
			self::getCPTCategoryName(),
			self::getCPTName(),
			array
			(
				'label'=>esc_html__('Boat Types','boat-charter-booking-system'),
				'hierarchical'=>false
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_bcbs_meta_box_boat',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_boat',esc_html__('Main','boat-charter-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$data=array();
		
		$TaxRate=new BCBSTaxRate();
		$Marina=new BCBSMarina();
		$BoatAttribute=new BCBSBoatAttribute();
		
		$data['meta']=BCBSPostMeta::getPostMeta($post);
		
		$data['nonce']=BCBSHelper::createNonceField(PLUGIN_BCBS_CONTEXT.'_meta_box_boat');
	   
		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
		$data['dictionary']['boat_attribute']=$BoatAttribute->getDictionary();
		
		$data['dictionary']['marina']=$Marina->getDictionary();
	   
		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/meta_box_boat.php');			
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
		
		if(BCBSHelper::checkSavePost($postId,PLUGIN_BCBS_CONTEXT.'_meta_box_boat_noncename','savePost')===false) return(false);
		
		$Date=new BCBSDate();
		$TaxRate=new BCBSTaxRate();
		$Marina=new BCBSMarina();
		$PriceRule=new BCBSPriceRule();
		$Validation=new BCBSValidation();
		
		$option=BCBSHelper::getPostOption();
		
		/***/
		
		$dictionary=$Marina->getDictionary();
		foreach($option['marina_id'] as $index=>$value)
		{
			if(!array_key_exists($value,$dictionary))
				unset($option['marina_id'][$index]);
		}
		
		if((!is_array($option['marina_id'])))
			$option['marina_id']=array();
		
		if(!$Validation->isFloat($option['dimension_width'],0,999999999.99)) 
			$option['dimension_width']=0;		
		if(!$Validation->isFloat($option['dimension_length'],0,999999999.99)) 
			$option['dimension_length']=0;			
		
		if(!$Validation->isNumber($option['guest_number'],1,999)) 
			$option['guest_number']=0;
		if(!$Validation->isNumber($option['cabin_number'],1,999)) 
			$option['cabin_number']=0;	

		if(!in_array($option['captain_status'],array(1,2,3)))
			$option['captain_status']=1;  	
		
		$option['gallery_image_id']=array_map('intval',preg_split('/\./',$option['gallery_image_id']));
		foreach($option['gallery_image_id'] as $index=>$value)
		{
			if($value<=0) unset($option['gallery_image_id'][$index]);
		}		
		
		/***/
		
		foreach($PriceRule->getPriceUseType() as $index=>$value)
		{
			if(!$Validation->isPrice($option['price_'.$index.'_value'],false))
				$option['price_'.$index.'_value']=0.00;
		 
			$option['price_'.$index.'_value']=BCBSPrice::formatToSave($option['price_'.$index.'_value']);
			
			if(!$TaxRate->isTaxRate($option['price_'.$index.'_tax_rate_id']))
				$option['price_'.$index.'_tax_rate_id']=0; 
		}
		
		/***/
		
		$attribute=array();
		
		$attributePost=$option['attribute'];
		
		$BoatAttribute=new BCBSBoatAttribute();
		$attributeDictionary=$BoatAttribute->getDictionary();

		foreach($attributeDictionary as $attributeDictionaryIndex=>$attributeDictionaryValue)
		{
			if(!isset($attributePost[$attributeDictionaryIndex])) continue;
			
			switch($attributeDictionaryValue['meta']['attribute_type'])
			{
				case 1:
					
					$attribute[$attributeDictionaryIndex]=$attributePost[$attributeDictionaryIndex];
					
				break;
				
				case 2:
				case 3:
					
					if(!is_array($attributePost[$attributeDictionaryIndex])) break;
					
					foreach($attributeDictionaryValue['meta']['attribute_value'] as $value)
					{
						if(in_array($value['id'],$attributePost[$attributeDictionaryIndex]))
						{
							if($attributeDictionaryValue['meta']['attribute_type']===2)
							{
								$attribute[$attributeDictionaryIndex]=(int)$value['id'];
								break;
							}
							else $attribute[$attributeDictionaryIndex][]=(int)$value['id'];
						}
					}
	
				break;
			}
		}
		
		/***/
		
		$dateExclude=array();
		$dateExcludePost=BCBSHelper::getPostValue('date_exclude');
		
		$count=count($dateExcludePost);
		
		for($i=0;$i<$count;$i+=4)
		{
			$dateExcludePost[$i]=$Date->formatDateToStandard($dateExcludePost[$i]);
			$dateExcludePost[$i+1]=$Date->formatTimeToStandard($dateExcludePost[$i+1]);
			$dateExcludePost[$i+2]=$Date->formatDateToStandard($dateExcludePost[$i+2]);
			$dateExcludePost[$i+3]=$Date->formatTimeToStandard($dateExcludePost[$i+3]);
			
			if($Validation->isEmpty($dateExcludePost[$i+1])) $dateExcludePost[$i+1]='00:00';
			if($Validation->isEmpty($dateExcludePost[$i+3])) $dateExcludePost[$i+3]='23:59';
			
			if(!$Validation->isDate($dateExcludePost[$i],true)) continue;
			if(!$Validation->isDate($dateExcludePost[$i+2],true)) continue;

			if(!$Validation->isTime($dateExcludePost[$i+1],true)) continue;
			if(!$Validation->isTime($dateExcludePost[$i+3],true)) continue;
			
			if($Date->compareDate($dateExcludePost[$i],$dateExcludePost[$i+2])==1) continue;
			if(($Date->compareDate(date_i18n('d-m-Y'),$dateExcludePost[$i])==1) && ($Date->compareDate(date_i18n('d-m-Y'),$dateExcludePost[$i+2])==1)) continue;
			
			if($Date->compareDate($dateExcludePost[$i],$dateExcludePost[$i+2])===0)
			{
				if($Date->compareTime($dateExcludePost[$i+1],$dateExcludePost[$i+3])===1) continue;
			}
			
			$dateExclude[]=array('start_date'=>$dateExcludePost[$i],'start_time'=>$dateExcludePost[$i+1],'stop_date'=>$dateExcludePost[$i+2],'stop_time'=>$dateExcludePost[$i+3]);
		}
		
		/***/
		
		$key=array
		(
			'marina_id',
			'dimension_width',
			'dimension_length',
			'guest_number',
			'cabin_number',
			'group_code',
			'captain_status',
			'gallery_image_id'
		);
		
		foreach($PriceRule->getPriceUseType() as $index=>$value)
			array_push($key,'price_'.$index.'_value','price_'.$index.'_tax_rate_id');
		
		array_unique($key);
		
		foreach($key as $value)
			BCBSPostMeta::updatePostMeta($postId,$value,$option[$value]);
		
		BCBSPostMeta::updatePostMeta($postId,'attribute',$attribute);
		BCBSPostMeta::updatePostMeta($postId,'date_exclude',$dateExclude);
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		$TaxRate=new BCBSTaxRate();
		$PriceRule=new BCBSPriceRule();
		$BoatAttribute=new BCBSBoatAttribute();
		
		BCBSHelper::setDefault($meta,'marina_id',array());
		
		BCBSHelper::setDefault($meta,'dimension_width','');
		BCBSHelper::setDefault($meta,'dimension_length','');
		
		BCBSHelper::setDefault($meta,'guest_number','4');
		BCBSHelper::setDefault($meta,'cabin_number','4');
		
		BCBSHelper::setDefault($meta,'group_code',''); 
		BCBSHelper::setDefault($meta,'captain_status','1'); 
		
		BCBSHelper::setDefault($meta,'gallery_image_id',array());
		
		foreach($PriceRule->getPriceUseType() as $index=>$value)
		{
			BCBSHelper::setDefault($meta,'price_'.$index.'_value','0.00');
			BCBSHelper::setDefault($meta,'price_'.$index.'_tax_rate_id',$TaxRate->getDefaultTaxPostId());   
		}
		
		$attribute=$BoatAttribute->getDictionary();
		foreach($attribute as $attributeIndex=>$attributeData)
		{
			if(isset($meta['attribute'][$attributeIndex])) continue;
			
			if($attributeData['meta']['attribute_type']==1)
				$meta['attribute'][$attributeIndex]='';
			else $meta['attribute'][$attributeIndex]=array(-1);
		}
		
		if(!array_key_exists('date_exclude',$meta))
			$meta['date_exclude']=array();
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array(),$sortingType=1)
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'boat_id'=>0,
			'category_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		$Validation=new BCBSValidation();
		
		BCBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>((int)$sortingType=== 4?'desc':'asc'))
		);
		
		if($attribute['boat_id'])
			$argument['p']=$attribute['boat_id'];
 
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
			'thumbnail'=>esc_html__('Thumbnail','boat-charter-booking-system'),
			'title'=>esc_html__('Title','boat-charter-booking-system'),
			'guest_cabin_number'=>esc_html__('Number of guests and cabins','boat-charter-booking-system'),
			'price'=>esc_html__('Net prices','boat-charter-booking-system')
		);
   
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$PriceRule=new BCBSPriceRule();
		
		$meta=BCBSPostMeta::getPostMeta($post);
		
		switch($column) 
		{
			case 'thumbnail':
				
				echo get_the_post_thumbnail($post,PLUGIN_BCBS_CONTEXT.'_marina');
				
			break;
		
			case 'guest_cabin_number':
				
				echo 
				'
					<table class="to-table-post-list">
						<tr>
							<td>'.esc_html__('Guests','boat-charter-booking-system').'</td>
							<td>'.esc_html($meta['guest_number']).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Cabins','boat-charter-booking-system').'</td>
							<td>'.esc_html($meta['cabin_number']).'</td>
						</tr>
					</table>
				';
	
			break;
		
			case 'price':
				
				echo 
				'
					<table class="to-table-post-list">
				';
				
				foreach($PriceRule->getPriceUseType() as $index=>$value)
				{
					echo 
					'
						<tr>
							<td>'.esc_html($value[0]).'</td>
							<td>'.BCBSPrice::format($meta['price_'.$index.'_value'],BCBSOption::getOption('currency')).'</td>
						</tr>	
					';
				}
				
				echo
				'
					</table>
				';

			break;
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function getBoatAttribute(&$boat)
	{
		$Validation=new BCBSValidation();
		$BoatAttribute=new BCBSBoatAttribute();
		
		$dictionary=$BoatAttribute->getDictionary();
 
		foreach($boat as $boatIndex=>$boatValue)
		{
			foreach($boatValue['meta']['attribute'] as $boatAttributeIndex=>$boatAttributeValue)
			{
				if(!isset($dictionary[$boatAttributeIndex])) continue;
				
				switch($dictionary[$boatAttributeIndex]['meta']['attribute_type'])
				{
					case 1:
						
						if($Validation->isNotEmpty($boatAttributeValue))
							$boat[$boatIndex]['attribute'][$boatAttributeIndex]=array('name'=>get_the_title($boatAttributeIndex),'value'=>$boatAttributeValue);
						
					break;
				
					case 2:
					case 3:
						
						$value=null;
						
						foreach($boatAttributeValue as $boatAttributeValueValue)
						{
							foreach($dictionary[$boatAttributeIndex]['meta']['attribute_value'] as $dictionaryAttributeValue)
							{
								if($dictionaryAttributeValue['id']===$boatAttributeValueValue)
								{
									if(!$Validation->isEmpty($value)) $value.=', ';
									$value.=$dictionaryAttributeValue['value'];
								}
							}
						}
						
						if($Validation->isNotEmpty($value))
							$boat[$boatIndex]['attribute'][$boatAttributeIndex]=array('name'=>get_the_title($boatAttributeIndex),'value'=>$value);
		  
					break;
				}
			}
			
			if(array_key_exists('attribute',$boat[$boatIndex]))
			{
				$attribute=$boat[$boatIndex]['attribute'];

				$boat[$boatIndex]['attribute']=array();

				foreach($dictionary as $index=>$value)
				{
					if(array_key_exists($index,$attribute))
						$boat[$boatIndex]['attribute'][$index]=$attribute[$index];
				}
			}
		}
	}
	
	/**************************************************************************/
	
	function getBoatCategory($boatId)
	{
		$result=null;
		
		$Validation=new BCBSValidation();
		
		$category=get_the_terms($boatId,self::getCPTCategoryName());
		
		if(($category===false) || (is_wp_error($category))) return($result);
		
		foreach($category as $value)
		{
			if($Validation->isNotEmpty($result)) $result.=', ';
			$result.=$value->name;
		}
		
		return($result);
	}
	
	/**************************************************************************/
	
	function checkAvailability($bookingForm,$dictionary,$departureDate,$departureTime,$returnDate,$returnTime,$marinaDepartureId,&$boatRemove)
	{	
		$Marina=new BCBSMarina();
		$Validation=new BCBSValidation();
		
		/***/
		
		$boatRemove=array(2=>array(),3=>array(),4=>array());
		
		/***/
		
		$marina=$Marina->getDictionary(array('marina_id'=>$marinaDepartureId));
		if(!isset($marina[$marinaDepartureId])) return($dictionary);
		
		$checkType=$marina[$marinaDepartureId]['meta']['boat_availability_check_type'];
		
		/***/
		
		if(!is_array($checkType)) return($dictionary);
        if(in_array(1,$checkType)) return($dictionary); 
        
		$timeValid=true;
		if((int)$bookingForm['meta']['marina_departure_return_time_field_enable']===1)
			$timeValid=($Validation->isTime($departureTime)) && ($Validation->isTime($returnTime));
		
		if(($Validation->isDate($departureDate)) && ($Validation->isDate($returnDate)) && ($timeValid))
		{
			if(in_array(2,$checkType))
			{
				foreach($dictionary as $dictionaryIndex=>$dictionaryValue)
				{
					$meta=$dictionaryValue['meta'];

					if(!array_key_exists('date_exclude',$meta)) continue;

					foreach($meta['date_exclude'] as $value)
					{
						$dateStart=strtotime($value['start_date'].' '.$value['start_time']);
						$dateStop=strtotime($value['stop_date'].' '.$value['stop_time']);

						if(($Validation->isTime($departureTime)) && ($Validation->isTime($returnTime)))
						{
							$dateRentalStart=strtotime($departureDate.' '.$departureTime);
							$dateRentalStop=strtotime($returnDate.' '.$returnTime);
						}
						else
						{
							$dateRentalStart=strtotime($departureDate);
							$dateRentalStop=strtotime($returnDate);
						}
						
						$b=array_fill(0,4,false);

						$b[0]=BCBSHelper::valueInRange($dateRentalStart,$dateStart,$dateStop);
						$b[1]=BCBSHelper::valueInRange($dateRentalStop,$dateStart,$dateStop);
						$b[2]=BCBSHelper::valueInRange($dateStart,$dateRentalStart,$dateRentalStop);
						$b[3]=BCBSHelper::valueInRange($dateStop,$dateRentalStart,$dateRentalStop);

						if(in_array(true,$b,true))
						{
							$boatRemove[2][]=$dictionaryIndex;
							$boatRemove[4][$dictionaryIndex]=$dictionary[$dictionaryIndex];
							
							unset($dictionary[$dictionaryIndex]);
							
							break;					
						}
					}
				}
			}
		
			/***/
		
			if(in_array(3,$checkType))
			{
				if(count($dictionary))
				{
					$WPML=new BCBSWPML();
					$Booking=new BCBSBooking();

					$argument=array
					(
						'post_type'=>$Booking::getCPTName(),
						'post_status'=>'publish',
						'posts_per_page'=>-1,
						'meta_query'=>array
						(
							array
							(
								'key'=>PLUGIN_BCBS_CONTEXT.'_boat_id',
								'value'=>array_keys($WPML->translateDictionary($dictionary)),
								'compare'=>'IN'
							)
						)
					);
					
					/***/
					
					$status=BCBSOption::getOption('booking_status_nonblocking');
					if(is_array($status))
					{
						$argument['meta_query'][]=array
						(
							'key'=>PLUGIN_BCBS_CONTEXT.'_booking_status_id',
							'value'=>$status,
							'compare'=>'NOT IN'
						);
					}
					
					/***/

					global $post;

					BCBSHelper::preservePost($post,$bPost);

					$query=new WP_Query($argument);
					if($query===false) 
					{
						BCBSHelper::preservePost($post,$bPost,0);
						return($dictionary); 
					}

					while($query->have_posts())
					{
						$query->the_post();

						$meta=BCBSPostMeta::getPostMeta($post);

						$bookingStart=strtotime($meta['departure_date'].' '.$meta['departure_time'].' - '.(int)$marina[$marinaDepartureId]['meta']['booking_interval'].' minute');
						$bookingStop=strtotime($meta['return_date'].' '.$meta['return_time'].' + '.(int)$marina[$marinaDepartureId]['meta']['booking_interval'].' minute');

						if(($Validation->isTime($departureTime)) && ($Validation->isTime($returnTime)))
						{
							$bookingCurrentStart=strtotime($departureDate.' '.$departureTime);
							$bookingCurrentStop=strtotime($returnDate.' '.$returnTime);
						}
						else
						{
							$bookingCurrentStart=strtotime($departureDate);
							$bookingCurrentStop=strtotime($returnDate);
						}	
						
						$b=array_fill(0,4,false);

						$b[0]=BCBSHelper::valueInRange($bookingCurrentStart,$bookingStart,$bookingStop);
						$b[1]=BCBSHelper::valueInRange($bookingCurrentStop,$bookingStart,$bookingStop);
						$b[2]=BCBSHelper::valueInRange($bookingStart,$bookingCurrentStart,$bookingCurrentStop);
						$b[3]=BCBSHelper::valueInRange($bookingStop,$bookingCurrentStart,$bookingCurrentStop);
						
						if(in_array(true,$b,true))
						{
							foreach($dictionary as $index=>$value)
							{
								$tIndex=$WPML->translateID($index);
								if($tIndex==$meta['boat_id'])
								{
									$boatRemove[3][]=$index;
									$boatRemove[4][$index]=$dictionary[$index];
									
									unset($dictionary[$index]);
								}
							}
			
							continue;					
						}
					}			

					BCBSHelper::preservePost($post,$bPost,0);
				}
			}
		}
			
		/***/
		
		return($dictionary);
	}
	
	/**************************************************************************/
	
	function calculatePrice($data,$bookingForm,&$discountPercentage=0,$calculateHiddenFee=true,$useCouponEnable=true)
	{	
		$Date=new BCBSDate();
		$Currency=new BCBSCurrency();
		$PriceRule=new BCBSPriceRule();
		$BookingForm=new BCBSBookingForm();
		
		/***/
		
		$price=array();
		
		/***/
		
		list($marinaDepartureId)=$BookingForm->getBookingFormMarinaDeparture($bookingForm);
		list($marinaReturnId)=$BookingForm->getBookingFormMarinaReturn($bookingForm);
		
		$priceBase=$PriceRule->extractPriceFromData($priceBase,$bookingForm['dictionary']['boat'][$data['boat_id']]['meta']);
				
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
			
		$priceBase=$PriceRule->getPriceFromRule($argument,$bookingForm,$priceBase);
		
		/***/
		
		$currency=$Currency->getCurrency(BCBSCurrency::getFormCurrency());
		
		$rate=BCBSCurrency::getExchangeRate(); 
		foreach($priceBase as $index=>$value)
		{
			if(preg_match('/\_value$/',$index,$result))
				$priceBase[$index]=$priceBase[$index]*$rate;
		} 
				
		/***/
		
		$boat=$bookingForm['dictionary']['boat'][$data['boat_id']];
		
		/***/
		
		$period=BCBSBookingHelper::calculateRentalPeriod($data['departure_date'],$data['departure_time'],$data['return_date'],$data['return_time'],BCBSOption::getOption('billing_type'));
		
		/***/
		
		$coupon=false;
		$couponCodeSourceType=0;
		
		if($useCouponEnable)
		{
			$Coupon=new BCBSCoupon();
			$coupon=$Coupon->checkCode($bookingForm,$couponCodeSourceType);

			if($coupon!==false)
			{
				$discountPercentage=$coupon['meta']['discount_percentage'];
				$discountFixed=$coupon['meta']['discount_fixed'];

				if((int)BCBSOption::getOption('billing_type')===2)
				{
					if(array_key_exists('discount_rental_day_count',$coupon['meta']))
					{
						if(is_array($coupon['meta']['discount_rental_day_count']))
						{
							foreach($coupon['meta']['discount_rental_day_count'] as $index=>$value)
							{
								if((($value['start']<=$period['day']) && ($value['stop']>=$period['day'])))
								{
									if($value['discount_percentage']>0)
									{
										$discountPercentage=$value['discount_percentage'];
									}
									elseif($value['discount_fixed']>0)
									{
										$discountPercentage=0;
										$discountFixed=$value['discount_fixed'];
									}

									break;
								}
							}
						}
					}
				}

				if($discountPercentage==0)
				{
					if($discountFixed>0)
					{
						$discountPercentage=$Coupon->calculateDiscountPercentage($discountFixed,$period['day'],$period['hour'],$priceBase['price_rental_day_value'],$priceBase['price_rental_hour_value']);
					}
				}

				$priceBase['price_rental_day_value']=round($priceBase['price_rental_day_value']*(1-$discountPercentage/100),2);
				$priceBase['price_rental_hour_value']=round($priceBase['price_rental_hour_value']*(1-$discountPercentage/100),2);
			}
		}
		
		$price['price']['sum']['net']['value']=$priceBase['price_rental_day_value']*$period['day']+$priceBase['price_rental_hour_value']*$period['hour'];
		$price['price']['sum']['net']['format']=BCBSPrice::format($priceBase['price_rental_day_value']*$period['day']+$priceBase['price_rental_hour_value']*$period['hour'],BCBSCurrency::getFormCurrency());
		$price['price']['sum']['gross']['value']=BCBSPrice::calculateGross($priceBase['price_rental_day_value']*$period['day'],$priceBase['price_rental_day_tax_rate_id'])+BCBSPrice::calculateGross($priceBase['price_rental_hour_value']*$period['hour'],$priceBase['price_rental_hour_tax_rate_id']);  
		$price['price']['sum']['gross']['format']=BCBSPrice::format($price['price']['sum']['gross']['value'],BCBSCurrency::getFormCurrency());
		
		/***/
		
		if((int)BCBSOption::getOption('billing_type')===2)
		{
			$price['price']['price_per_day']['gross']['value']=$price['price']['sum']['gross']['value']/$period['day'];
		}
		else
		{
		   $price['price']['price_per_day']['gross']['value']=0.00;
		}
		
		$price['price']['price_per_day']['gross']['format']=BCBSPrice::format($price['price']['price_per_day']['gross']['value'],BCBSCurrency::getFormCurrency());
			
		/***/
				
		$price['price']['deposit']['net']['value']=$priceBase['price_deposit_value'];
		$price['price']['deposit']['net']['format']=BCBSPrice::format($price['price']['deposit']['net']['value'],BCBSCurrency::getFormCurrency());
		$price['price']['deposit']['gross']['value']=BCBSPrice::calculateGross($price['price']['deposit']['net']['value'],$priceBase['price_deposit_tax_rate_id']);  
		$price['price']['deposit']['gross']['format']=BCBSPrice::format($price['price']['deposit']['gross']['value'],BCBSCurrency::getFormCurrency());
		
		/***/
		
		$price['price']['initial']['net']['value']=$priceBase['price_initial_value'];
		$price['price']['initial']['net']['format']=BCBSPrice::format($price['price']['initial']['net']['value'],BCBSCurrency::getFormCurrency());
		$price['price']['initial']['gross']['value']=BCBSPrice::calculateGross($price['price']['initial']['net']['value'],$priceBase['price_initial_tax_rate_id']);  
		$price['price']['initial']['gross']['format']=BCBSPrice::format($price['price']['initial']['gross']['value'],BCBSCurrency::getFormCurrency());
		
		/***/
		
		if($marinaDepartureId==$marinaReturnId) $priceBase['price_one_way_value']=0;
		
		$price['price']['one_way']['net']['value']=$priceBase['price_one_way_value'];
		$price['price']['one_way']['net']['format']=BCBSPrice::format($price['price']['one_way']['net']['value'],BCBSCurrency::getFormCurrency());
		$price['price']['one_way']['gross']['value']=BCBSPrice::calculateGross($price['price']['one_way']['net']['value'],$priceBase['price_one_way_tax_rate_id']);
		$price['price']['one_way']['gross']['format']=BCBSPrice::format($price['price']['one_way']['gross']['value'],BCBSCurrency::getFormCurrency());
			
		/***/
		
		$dayNumber=$Date->getDayNumberOfWeek($data['departure_date']);
		
		$date1=strtotime($data['departure_date'].' '.$data['departure_time']);
		$date2=strtotime($data['departure_date'].' '.$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['business_hour'][$dayNumber]['start']);
		$date3=strtotime($data['departure_date'].' '.$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['business_hour'][$dayNumber]['stop']);

		if(($date1>=$date2) && ($date1<=$date3))
			$priceBase['price_after_business_hour_departure_value']=0;
		
		$price['price']['after_business_hour_departure']['net']['value']=$priceBase['price_after_business_hour_departure_value'];
		$price['price']['after_business_hour_departure']['net']['format']=BCBSPrice::format($price['price']['after_business_hour_departure']['net']['value'],BCBSCurrency::getFormCurrency());
		$price['price']['after_business_hour_departure']['gross']['value']=BCBSPrice::calculateGross($price['price']['after_business_hour_departure']['net']['value'],$priceBase['price_after_business_hour_departure_tax_rate_id']);
		$price['price']['after_business_hour_departure']['gross']['format']=BCBSPrice::format($price['price']['after_business_hour_departure']['gross']['value'],BCBSCurrency::getFormCurrency());
		
		/***/
		
		$dayNumber=$Date->getDayNumberOfWeek($data['return_date']);
		
		$date1=strtotime($data['return_date'].' '.$data['return_time']);
		$date2=strtotime($data['return_date'].' '.$bookingForm['dictionary']['marina'][$marinaReturnId]['meta']['business_hour'][$dayNumber]['start']);
		$date3=strtotime($data['return_date'].' '.$bookingForm['dictionary']['marina'][$marinaReturnId]['meta']['business_hour'][$dayNumber]['stop']);

		if(($date1>=$date2) && ($date1<=$date3))
			$priceBase['price_after_business_hour_return_value']=0;
		
		$price['price']['after_business_hour_return']['net']['value']=$priceBase['price_after_business_hour_return_value'];
		$price['price']['after_business_hour_return']['net']['format']=BCBSPrice::format($price['price']['after_business_hour_return']['net']['value'],BCBSCurrency::getFormCurrency());
		$price['price']['after_business_hour_return']['gross']['value']=BCBSPrice::calculateGross($price['price']['after_business_hour_return']['net']['value'],$priceBase['price_after_business_hour_return_tax_rate_id']);
		$price['price']['after_business_hour_return']['gross']['format']=BCBSPrice::format($price['price']['after_business_hour_return']['gross']['value'],BCBSCurrency::getFormCurrency());
		
		/***/
		
		$price['currency']=$currency;

		/***/
	   
		if(((int)$bookingForm['meta']['booking_summary_hide_fee']===1) && ($calculateHiddenFee))
		{
			$data['booking_form']=$bookingForm;
		   
			$Booking=new BCBSBooking();
			$priceBooking=$Booking->calculatePrice($data,$price,true);
			
			$price['price']['sum']['gross']['value']=number_format($priceBooking['boat']['sum']['gross']['value'],2,'.','');
			$price['price']['sum']['net']['value']=number_format($priceBooking['boat']['sum']['net']['value'],2,'.','');
			
			$price['price']['sum']['gross']['format']=BCBSPrice::format($price['price']['sum']['gross']['value'],BCBSCurrency::getFormCurrency());
			$price['price']['sum']['net']['format']=BCBSPrice::format($price['price']['sum']['net']['value'],BCBSCurrency::getFormCurrency());
		}
		
		/***/
		
		$price['price']['base']=$priceBase;
		
		if($coupon!==false)
		{
			if($couponCodeSourceType===1)
			{
				$price['price_before_coupon']=$this->calculatePrice($data,$bookingForm,$discountPercentage,$calculateHiddenFee,false);
			}
		}
		
		return($price);
	}
  
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/