<?php

/******************************************************************************/
/******************************************************************************/

class BCBSPriceRule
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->priceSourceType=array
		(
			1=>array(esc_html__('Set directly in rule','boat-charter-booking-system')),
			2=>array(esc_html__('Calculation based on rental dates (all ranges)','boat-charter-booking-system')),
			3=>array(esc_html__('Calculation based on rental dates (exact date)','boat-charter-booking-system')),
			4=>array(esc_html__('Calculation based on rental days number (all ranges)','boat-charter-booking-system')),
			5=>array(esc_html__('Calculation based on rental days number (exact range)','boat-charter-booking-system')),
			6=>array(esc_html__('Calculation based on rental hours number (all ranges)','boat-charter-booking-system')),
			7=>array(esc_html__('Calculation based on rental hours number (exact range)','boat-charter-booking-system'))
		);
		
		$this->priceAlterType=array
		(
			1=>array(esc_html__('- Inherited -','boat-charter-booking-system')),
			2=>array(esc_html__('Set value','boat-charter-booking-system')),
			3=>array(esc_html__('Increase by value','boat-charter-booking-system')),
			4=>array(esc_html__('Decrease by value','boat-charter-booking-system')),
			5=>array(esc_html__('Increase by percentage','boat-charter-booking-system')),
			6=>array(esc_html__('Decrease by percentage','boat-charter-booking-system'))
		);
		
		$this->priceUseType=array
		(
			'initial'=>array(esc_html__('Initial','boat-charter-booking-system')),
			'rental_day'=>array(esc_html__('Rental per day','boat-charter-booking-system')),
			'rental_hour'=>array(esc_html__('Rental per hour','boat-charter-booking-system')),
			'deposit'=>array(esc_html__('Deposit','boat-charter-booking-system')),
			'one_way'=>array(esc_html__('One way','boat-charter-booking-system')),
			'after_business_hour_departure'=>array(esc_html__('Departure after business hours','boat-charter-booking-system')),
			'after_business_hour_return'=>array(esc_html__('Return after business hours','boat-charter-booking-system'))
		);
	}
	
	/**************************************************************************/
	
	function getPriceIndexName($index,$type='value')
	{
		return('price_'.$index.'_'.$type);
	}
	
	/**************************************************************************/
	
	function getPriceAlterType()
	{
		return($this->priceAlterType);
	}
	
	/**************************************************************************/
	
	function isPriceAlterType($priceAlterType)
	{
		return(array_key_exists($priceAlterType,$this->priceAlterType));
	}
	
	/**************************************************************************/
	
	function getPriceUseType()
	{
		return($this->priceUseType);
	}
	
	/**************************************************************************/
	
	function isPriceUseType($priceUseType)
	{
		return(array_key_exists($priceUseType,$this->priceUseType));
	}
	
	/**************************************************************************/
	
	function getPriceSourceType()
	{
		return($this->priceSourceType);
	}
	
	/**************************************************************************/
	
	function isPriceSourceType($type)
	{
		return(array_key_exists($type,$this->getPriceSourceType()));
	}
	
	/**************************************************************************/
	
	function getPriceSourceTypeName($type)
	{
		if(!$this->isPriceSourceType($type)) return('');
		return($this->priceSourceType[$type][0]);
	}
	
	/**************************************************************************/
	
	function extractPriceFromData($price,$data)
	{
		$priceComponent=array('value','alter_type_id','tax_rate_id');
		
		foreach($this->getPriceUseType() as $priceUseTypeIndex=>$priceUseTypeValue)
		{
			foreach($priceComponent as $priceComponentIndex=>$priceComponentValue)
			{
				$key=$this->getPriceIndexName($priceUseTypeIndex,$priceComponentValue);
				if(isset($data[$key])) $price[$key]=$data[$key];
				else
				{
					if($priceComponentValue==='alter_type_id') $price[$key]=2;
				}
			}
		}
		
		$price['price_type']=$data['price_type'];

		return($price);
	}

	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_BCBS_CONTEXT.'_price_rule');
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
					'name'=>esc_html__('Pricing Rules','boat-charter-booking-system'),
					'singular_name'=>esc_html__('Pricing Rule','boat-charter-booking-system'),
					'add_new'=>esc_html__('Add New','boat-charter-booking-system'),
					'add_new_item'=>esc_html__('Add New Pricing Rule','boat-charter-booking-system'),
					'edit_item'=>esc_html__('Edit Pricing Rule','boat-charter-booking-system'),
					'new_item'=>esc_html__('New Pricing Rule','boat-charter-booking-system'),
					'all_items'=>esc_html__('Pricing Rules','boat-charter-booking-system'),
					'view_item'=>esc_html__('View Pricing Rule','boat-charter-booking-system'),
					'search_items'=>esc_html__('Search Pricing Rules','boat-charter-booking-system'),
					'not_found'=>esc_html__('No Pricing Rules Found','boat-charter-booking-system'),
					'not_found_in_trash'=>esc_html__('No Pricing Rules in Trash','boat-charter-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Pricing Rules','boat-charter-booking-system')
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
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_bcbs_meta_box_price_rule',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_price_rule',esc_html__('Main','boat-charter-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$data=array();
		
		$Boat=new BCBSBoat();
		$TaxRate=new BCBSTaxRate();
		$Marina=new BCBSMarina();
		$BookingForm=new BCBSBookingForm();
		
		$data['meta']=BCBSPostMeta::getPostMeta($post);
		
		$data['nonce']=BCBSHelper::createNonceField(PLUGIN_BCBS_CONTEXT.'_meta_box_price_rule');

		$data['dictionary']['boat']=$Boat->getDictionary();
		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
		$data['dictionary']['booking_form']=$BookingForm->getDictionary();

		$data['dictionary']['price_alter_type']=$this->getPriceAlterType();
		$data['dictionary']['price_source_type']=$this->getPriceSourceType();
		
		$data['dictionary']['marina']=$Marina->getDictionary();
		
		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/meta_box_price_rule.php');			
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
		$TaxRate=new BCBSTaxRate();
		
		BCBSHelper::setDefault($meta,'booking_form_id',array(-1));
		
		BCBSHelper::setDefault($meta,'marina_departure_id',array(-1));
		BCBSHelper::setDefault($meta,'marina_return_id',array(-1));
		
		BCBSHelper::setDefault($meta,'boat_id',array(-1));
		
		BCBSHelper::setDefault($meta,'departure_day_number',array(-1));
		BCBSHelper::setDefault($meta,'departure_date',array());
		
		BCBSHelper::setDefault($meta,'rental_day_count',array());
		BCBSHelper::setDefault($meta,'rental_hour_count',array());
		
		BCBSHelper::setDefault($meta,'price_source_type',1);
		
		BCBSHelper::setDefault($meta,'process_next_rule_enable',0);
		
		foreach($this->getPriceUseType() as $index=>$value)
		{
			BCBSHelper::setDefault($meta,'price_'.$index.'_value','0.00');
			BCBSHelper::setDefault($meta,'price_'.$index.'_alter_type_id',2);
			BCBSHelper::setDefault($meta,'price_'.$index.'_tax_rate_id',$TaxRate->getDefaultTaxPostId());   
		}
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(BCBSHelper::checkSavePost($postId,PLUGIN_BCBS_CONTEXT.'_meta_box_price_rule_noncename','savePost')===false) return(false);
		
		$Date=new BCBSDate();
		$Boat=new BCBSBoat();
		$TaxRate=new BCBSTaxRate();
		$Marina=new BCBSMarina();
		$BookingForm=new BCBSBookingForm();
		
		$Validation=new BCBSValidation();
		
		$option=BCBSHelper::getPostOption();
		
		/***/
		
		$dictionary=array
		(
			'booking_form_id'=>array
			(
				'dictionary'=>$BookingForm->getDictionary()
			),
			'marina_departure_id'=>array
			(
				'dictionary'=>$Marina->getDictionary()
			),
			'marina_return_id'=>array
			(
				'dictionary'=>$Marina->getDictionary()
			),
			'boat_id'=>array
			(
				'dictionary'=>$Boat->getDictionary()
			),
			'pickup_day_number'=>array
			(
				'dictionary'=>array(1,2,3,4,5,6,7)
			),
		);
		
		foreach($dictionary as $dIndex=>$dValue)
		{
			$option[$dIndex]=(array)BCBSHelper::getPostValue($dIndex);
			if(in_array(-1,$option[$dIndex]))
			{
				$option[$dIndex]=array(-1);
			}
			else
			{
				foreach($option[$dIndex] as $oIndex=>$oValue)
				{
					if(!isset($dValue['dictionary']))
						unset($option[$dIndex][$oIndex]);				
				}
			}			 
		}
		
		/***/
		
		$date=array();
	   
		foreach($option['departure_date']['start'] as $index=>$value)
		{
			$d=array($value,$option['departure_date']['stop'][$index],$option['departure_date']['price'][$index]);
			
			$d[0]=$Date->formatDateToStandard($d[0]);
			$d[1]=$Date->formatDateToStandard($d[1]);
			
			if(!$Validation->isDate($d[0])) continue;
			if(!$Validation->isDate($d[1])) continue;
			
			if($Date->compareDate($d[0],$d[1])==1) continue;
			
			if(!$Validation->isPrice($d[2],true)) $d[2]=0.00;
			
			array_push($date,array('start'=>$d[0],'stop'=>$d[1],'price'=>BCBSPrice::formatToSave($d[2],true)));
		}

		$option['departure_date']=$date;

		/***/
		
		$number=array();
	   
		foreach($option['rental_day_count']['start'] as $index=>$value)
		{
			$d=array($value,$option['rental_day_count']['stop'][$index],$option['rental_day_count']['price'][$index]);
			
			if(!$Validation->isNumber($d[0],0,99999)) continue;
			if(!$Validation->isNumber($d[1],0,99999)) continue;
  
			if(!$Validation->isPrice($d[2],true)) $d[2]=0.00;
			
			if($d[0]>$d[1]) continue;
			
			array_push($number,array('start'=>$d[0],'stop'=>$d[1],'price'=>BCBSPrice::formatToSave($d[2],true)));
		}
		
		$option['rental_day_count']=$number;
		
		/***/
		
		$number=array();
	   
		foreach($option['rental_hour_count']['start'] as $index=>$value)
		{
			$d=array($value,$option['rental_hour_count']['stop'][$index],$option['rental_hour_count']['price'][$index]);
			
			if(!$Validation->isNumber($d[0],0,99999)) continue;
			if(!$Validation->isNumber($d[1],0,99999)) continue;
  
			if(!$Validation->isPrice($d[2],true)) $d[2]=0.00;
			
			if($d[0]>$d[1]) continue;
			
			array_push($number,array('start'=>$d[0],'stop'=>$d[1],'price'=>BCBSPrice::formatToSave($d[2],true)));
		}
		
		$option['rental_hour_count']=$number;
		
		/***/
		
		if(!$this->isPriceSourceType($option['price_source_type']))
			$option['price_source_type']=1;
		if(!$Validation->isBool($option['process_next_rule_enable']))
			$option['process_next_rule_enable']=0;
		
		/***/
		
		foreach($this->getPriceUseType() as $index=>$value)
		{
			if(!$Validation->isPrice($option['price_'.$index.'_value'],false))
				$option['price_'.$index.'_value']=0.00;
			
			$option['price_'.$index.'_value']=BCBSPrice::formatToSave($option['price_'.$index.'_value']);
			
			if(!$this->isPriceAlterType($option['price_'.$index.'_alter_type_id']))
				$option['price_'.$index.'_alter_type_id']=1;
			
			if(in_array($option['price_'.$index.'_alter_type_id'],array(5,6)))
			{
				if(!$Validation->isNumber($option['price_'.$index.'_alter_type_id'],0,100))
					$option['price_'.$index.'_alter_type_id']=0;
			}
		 
			if((int)$option['price_'.$index.'_tax_rate_id']===-1)
				$option['price_'.$index.'_tax_rate_id']=-1;
			else
			{
				if(!$TaxRate->isTaxRate($option['price_'.$index.'_tax_rate_id']))
					$option['price_'.$index.'_tax_rate_id']=0; 
			}
		}
		
		/***/

		$key=array
		(
			'booking_form_id',
			'marina_departure_id',
			'marina_return_id',
			'boat_id',
			'departure_day_number',
			'departure_date',
			'rental_day_count',
			'rental_hour_count',
			'price_source_type',
			'process_next_rule_enable'
		);
		
		foreach($this->getPriceUseType() as $index=>$value)
			array_push($key,'price_'.$index.'_value','price_'.$index.'_alter_type_id','price_'.$index.'_tax_rate_id');
		
		array_unique($key);
		
		foreach($key as $value)
			BCBSPostMeta::updatePostMeta($postId,$value,$option[$value]);
	}
	
	/**************************************************************************/

	function manageEditColumns($column)
	{
		$column=array
		(
			'cb'=>$column['cb'],
			'title'=>$column['title'],
			'rule'=>esc_html__('Rules','boat-charter-booking-system'),
			'price'=>esc_html__('Prices','boat-charter-booking-system')
		);
   
		return($column);		   
	}
	
	/**************************************************************************/
	
	function getPricingRuleAdminListDictionary()
	{
		$dictionary=array();
	
		$Date=new BCBSDate();
		$Boat=new BCBSBoat();
		$Marina=new BCBSMarina();
		$BookingForm=new BCBSBookingForm();
		
		$dictionary['boat']=$Boat->getDictionary();
		$dictionary['marina']=$Marina->getDictionary();
		$dictionary['booking_form']=$BookingForm->getDictionary();

		$dictionary['day']=$Date->day;
		
		return($dictionary);
	}
	
	/**************************************************************************/
	
	function displayPricingRuleAdminListValue($data,$dictionary,$link=false,$sort=false)
	{
		if(in_array(-1,$data)) return(esc_html__(' - ','boat-charter-booking-system'));
		
		$html=null;
		
		$dataSort=array();

		foreach($data as $value)
		{
			if(!array_key_exists($value,$dictionary)) continue;

			if(array_key_exists('post',$dictionary[$value]))
				$label=$dictionary[$value]['post']->post_title;
			else $label=$dictionary[$value][0];			

			$dataSort[$value]=$label;
		}

		if($sort) asort($dataSort);

		$data=$dataSort;
		
		foreach($data as $index=>$value)
		{
			$label=$value;
			
			if($link) $label='<a href="'.esc_url(get_edit_post_link($index)).'">'.$value.'</a>';
			$html.='<div>'.$label.'</div>';
		}
		
		return($html);
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$Date=new BCBSDate();
		$Validation=new BCBSValidation();
		
		$meta=BCBSPostMeta::getPostMeta($post);
		
		$dictionary=BCBSGlobalData::setGlobalData('pricing_rule_admin_list_dictionary',array($this,'getPricingRuleAdminListDictionary'));
		
		switch($column) 
		{
			case 'rule':
				
				$html=array
				(
					'departure_date'=>'',
					'rental_day_count'=>'',
					'rental_hour_count'=>''
				);
				
				if((isset($meta['departure_date'])) && (count($meta['departure_date'])))
				{
					foreach($meta['departure_date'] as $value)
					{
						if(!$Validation->isEmpty($html['departure_date'])) $html['departure_date'].='<br>';
						$html['departure_date'].=esc_html($Date->formatDateToDisplay($value['start'])).' - '.esc_html($Date->formatDateToDisplay($value['stop']));	  
						
						if((int)$meta['price_source_type']===2)
							$html['departure_date'].=esc_html(' ('.BCBSPrice::format($value['price'],BCBSOption::getOption('currency')).')');
					}
				}   
				
				if((isset($meta['rental_day_count'])) && (count($meta['rental_day_count'])))
				{
					foreach($meta['rental_day_count'] as $value)
					{
						if(!$Validation->isEmpty($html['rental_day_count'])) $html['rental_day_count'].='<br>';
						$html['rental_day_count'].=esc_html($value['start']).' - '.esc_html($value['stop']);	  
						
						if(in_array((int)$meta['price_source_type'],array(3,4)))
							$html['rental_day_count'].=sc_html(' ('.BCBSPrice::format($value['price'],BCBSOption::getOption('currency')).')');
					}
				}				
				
				if((isset($meta['rental_hour_count'])) && (count($meta['rental_hour_count'])))
				{
					foreach($meta['rental_hour_count'] as $value)
					{
						if(!$Validation->isEmpty($html['rental_hour_count'])) $html['rental_hour_count'].='<br>';
						$html['rental_hour_count'].=esc_html($value['start']).' - '.esc_html($value['stop']);	  
					}
				}	   	
				
				foreach($html as $index=>$value)
				{
					if($Validation->isEmpty($value)) $html[$index]=esc_html__(' - ','boat-charter-booking-system');				
				}
				
				/***/
				
				echo 
				'
					<table class="to-table-post-list">
						<tr>
							<td>'.esc_html__('Booking form','boat-charter-booking-system').'</td>
							<td>'.$this->displayPricingRuleAdminListValue($meta['booking_form_id'],$dictionary['booking_form'],true,true).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Departure marina','boat-charter-booking-system').'</td>
							<td>'.$this->displayPricingRuleAdminListValue($meta['marina_departure_id'],$dictionary['marina'],true,true).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Return marina','boat-charter-booking-system').'</td>
							<td>'.$this->displayPricingRuleAdminListValue($meta['marina_return_id'],$dictionary['marina'],true,true).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Boats','boat-charter-booking-system').'</td>
							<td>'.$this->displayPricingRuleAdminListValue($meta['boat_id'],$dictionary['boat'],true,true).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Departure day numbers','boat-charter-booking-system').'</td>
							<td>'.$this->displayPricingRuleAdminListValue($meta['departure_day_number'],$dictionary['day'],true,true).'</td>
						</tr>						
						<tr>
							<td>'.esc_html__('Rental/departure dates','boat-charter-booking-system').'</td>
							<td>'.$html['departure_date'].'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Rental days count','boat-charter-booking-system').'</td>
							<td>'.$html['rental_day_count'].'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Rental hours count','boat-charter-booking-system').'</td>
							<td>'.$html['rental_hour_count'].'</td>
						</tr>
					</table>
				';

			break;
		
			case 'price':
				
				echo 
				'
					<table class="to-table-post-list">
						<tr>
							<td>'.esc_html__('Price source type','boat-charter-booking-system').'</td>
							<td>'.$this->getPriceSourceTypeName($meta['price_source_type']).'</td>
						</tr>  
						<tr>
							<td>'.esc_html__('Priority','boat-charter-booking-system').'</td>
							<td>'.(int)$post->menu_order.'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Next rule processing','boat-charter-booking-system').'</td>
							<td>'.((int)$meta['process_next_rule_enable']===1 ? esc_html__('Enable','boat-charter-booking-system') : esc_html__('Disable','boat-charter-booking-system')).'</td>
						</tr>
				';
				
				foreach($this->getPriceUseType() as $index=>$value)
				{
					echo 
					'
						<tr>
							<td>'.esc_html($value[0]).'</td>
							<td>'.self::displayPriceAlter($meta,$index).'</td>
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
	
	static function displayPriceAlter($meta,$priceUseType)
	{
		$charBefore=null;
		
		if(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(3,5)))
			$charBefore='+ ';
		if(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(4,6)))
			$charBefore='- ';		
		
		if(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(1)))
		{
			return(esc_html__('Inherited','boat-charter-booking-system'));
		}
		elseif(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(2)))
		{
			return(BCBSPrice::format($meta['price_'.$priceUseType.'_value'],BCBSOption::getOption('currency')));
		}
		elseif(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(3,4)))
		{
			return($charBefore.BCBSPrice::format($meta['price_'.$priceUseType.'_value'],BCBSOption::getOption('currency')));
		}
		elseif(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(5,6)))
		{
			return($charBefore.$meta['price_'.$priceUseType.'_value'].'%');
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function getPriceFromRule($bookingData,$bookingForm,$priceRule)
	{
		$Date=new BCBSDate();
		
		$pricePerUnit=-1;
		
		$rule=$bookingForm['dictionary']['price_rule'];
		if($rule===false) return($priceRule);

		foreach($rule as $ruleData)
		{
			if(!in_array(-1,$ruleData['meta']['booking_form_id']))
			{
				if(!in_array($bookingData['booking_form_id'],$ruleData['meta']['booking_form_id'])) continue;
			}
			
			if(!in_array(-1,$ruleData['meta']['marina_departure_id']))
			{
				if(!in_array($bookingData['marina_departure_id'],$ruleData['meta']['marina_departure_id'])) continue;
			}

			if(!in_array(-1,$ruleData['meta']['marina_return_id']))
			{
				if(!in_array($bookingData['marina_return_id'],$ruleData['meta']['marina_return_id'])) continue;
			}
			
			if(!in_array(-1,$ruleData['meta']['boat_id']))
			{
				if(!in_array($bookingData['boat_id'],$ruleData['meta']['boat_id'])) continue;
			} 

			if(!in_array(-1,$ruleData['meta']['departure_day_number']))
			{
				if(!in_array(date_i18n('N',strtotime($bookingData['departure_date'])),$ruleData['meta']['departure_day_number'])) continue;
			}
			
			if(is_array($ruleData['meta']['departure_date']))
			{
				if(count($ruleData['meta']['departure_date']))
				{
					$match=!count($ruleData['meta']['departure_date']);
				
					if((in_array($ruleData['meta']['price_source_type'],array(2,3))) && ((int)BCBSOption::getOption('billing_type')===2))
					{
						$sum=0;
						$match=true;
						
						if((int)$ruleData['meta']['price_source_type']===2)
						{
							$dateStart=$bookingData['departure_date'];

							$period=BCBSBookingHelper::calculateRentalPeriod($bookingData['departure_date'],$bookingData['departure_time'],$bookingData['return_date'],$bookingData['return_time']);

							for($i=0;$i<$period['day'];$i++)
							{
								$date=date_i18n('d-m-Y',strtotime('+'.$i.' day', strtotime($dateStart)));

								$dateIndex=-1;

								foreach($ruleData['meta']['departure_date'] as $index=>$value)
								{
									if($Date->dateInRange($date,$value['start'],$value['stop']))
									{
										$dateIndex=$index;
										break;
									}
								}

								if($dateIndex!=-1)
								{
									$sum+=$ruleData['meta']['departure_date'][$dateIndex]['price'];
								}
								else
								{
									$match=false;
									break;
								}
							}

							if($match)
							{
								if($period['day']>0)
									$pricePerUnit=$sum/$period['day'];
							}
						}
						else if((int)$ruleData['meta']['price_source_type']===3)
						{
							foreach($ruleData['meta']['departure_date'] as $value)
							{
								if($Date->dateInRange($bookingData['departure_date'],$value['start'],$value['stop']))
								{
									$pricePerUnit=$value['price'];									
									break;
								}
							}							
						}
					}
					else
					{
						foreach($ruleData['meta']['departure_date'] as $value)
						{
							if($Date->dateInRange($bookingData['departure_date'],$value['start'],$value['stop']))
							{
								$match=true;
								break;
							}
						}
					}

					if(!$match) continue;
				}
			}
			
			if((int)BCBSOption::getOption('billing_type')===2)
			{
				if(is_array($ruleData['meta']['rental_day_count']))
				{
					if(count($ruleData['meta']['rental_day_count']))
					{
						$match=false;

						$period=BCBSBookingHelper::calculateRentalPeriod($bookingData['departure_date'],$bookingData['departure_time'],$bookingData['return_date'],$bookingData['return_time'],BCBSOption::getOption('billing_type'));

						if((int)$ruleData['meta']['price_source_type']===4)
						{
							$match=true;
							
							for($i=1;$i<=$period['day'];$i++)
							{
								foreach($ruleData['meta']['rental_day_count'] as $value)
								{
									if(($value['start']<=$i) && ($value['stop']>=$i))
									{
										$sum+=$value['price'];
										break;
									}
								}		
							}
							
							$pricePerUnit=$sum/$period['day'];
						}
						if((int)$ruleData['meta']['price_source_type']===5)
						{
							foreach($ruleData['meta']['rental_day_count'] as $value)
							{
								if(($value['start']<=$period['day']) && ($value['stop']>=$period['day']))
								{
									$match=true;
									$pricePerUnit=$value['price'];
									break;
								}
							}		
						}
						else
						{
							foreach($ruleData['meta']['rental_day_count'] as $value)
							{
								if(($value['start']<=$period['day']) && ($period['day']<=$value['stop']))
								{
									$match=true;
									break;						
								}
							}
						}
						
						if(!$match) continue;
					}
				}  
			}
			
			if((int)BCBSOption::getOption('billing_type')===1)
			{
				if(is_array($ruleData['meta']['rental_hour_count']))
				{
					if(count($ruleData['meta']['rental_hour_count']))
					{
						$match=false;

						$period=BCBSBookingHelper::calculateRentalPeriod($bookingData['departure_date'],$bookingData['departure_time'],$bookingData['return_date'],$bookingData['return_time'],BCBSOption::getOption('billing_type'));

						if((int)$ruleData['meta']['price_source_type']===6)
						{
							$match=true;
							
							for($i=1;$i<=$period['hour'];$i++)
							{
								foreach($ruleData['meta']['rental_hour_count'] as $value)
								{
									if(($value['start']<=$i) && ($value['stop']>=$i))
									{
										$sum+=$value['price'];
										break;
									}
								}		
							}
							
							$pricePerUnit=$sum/$period['hour'];
						}
						if((int)$ruleData['meta']['price_source_type']===7)
						{
							foreach($ruleData['meta']['rental_hour_count'] as $value)
							{
								if(($value['start']<=$period['hour']) && ($value['stop']>=$period['hour']))
								{
									$match=true;
									$pricePerUnit=$value['price'];
									break;
								}
							}		
						}
						else
						{
							foreach($ruleData['meta']['rental_hour_count'] as $value)
							{
								if(($value['start']<=$period['hour']) && ($period['hour']<=$value['stop']))
								{
									$match=true;
									break;						
								}
							}
						}
						
						if(!$match) continue;
					}
				}				   
			}
			
			if($pricePerUnit!=-1)
			{
				if((int)BCBSOption::getOption('billing_type')===1) $key='hour';
				if((int)BCBSOption::getOption('billing_type')===2) $key='day';
				
				$priceRule['price_rental_'.$key.'_value']=$pricePerUnit;
				$pricePerUnit=-1;
			}
			else
			{
				foreach($this->getPriceUseType() as $index=>$value)
				{
					if((int)$ruleData['meta']['price_'.$index.'_alter_type_id']===2)
					{
						$priceRule['price_'.$index.'_value']=$ruleData['meta']['price_'.$index.'_value'];
					}
					elseif(in_array((int)$ruleData['meta']['price_'.$index.'_alter_type_id'],array(3,4))) 
					{
						if((int)$ruleData['meta']['price_'.$index.'_alter_type_id']===3)
							$priceRule['price_'.$index.'_value']+=$ruleData['meta']['price_'.$index.'_value'];
						if((int)$ruleData['meta']['price_'.$index.'_alter_type_id']===4)
							$priceRule['price_'.$index.'_value']-=$ruleData['meta']['price_'.$index.'_value'];
					}
					elseif(in_array((int)$ruleData['meta']['price_'.$index.'_alter_type_id'],array(5,6)))
					{
						if((int)$ruleData['meta']['price_'.$index.'_alter_type_id']===5)
						{
							$priceRule['price_'.$index.'_value']=$priceRule['price_'.$index.'_value']*(1+$ruleData['meta']['price_'.$index.'_value']/100); 
						}
						elseif((int)$ruleData['meta']['price_'.$index.'_alter_type_id']===6)
							$priceRule['price_'.$index.'_value']=$priceRule['price_'.$index.'_value']*(1-$ruleData['meta']['price_'.$index.'_value']/100); 
					}

					if($priceRule['price_'.$index.'_value']<0)
						$priceRule['price_'.$index.'_value']=0;
				}
			}
			
			foreach($this->getPriceUseType() as $index=>$value)
			{
				if((int)$ruleData['meta']['price_'.$index.'_tax_rate_id']!==0)
					$priceRule['price_'.$index.'_tax_rate_id']=$ruleData['meta']['price_'.$index.'_tax_rate_id'];			
			}

			if((int)$ruleData['meta']['process_next_rule_enable']!==1) return($priceRule);
		}
		
		return($priceRule);
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'price_rule_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		BCBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'desc')
		);
		
		if($attribute['price_rule_id'])
			$argument['p']=$attribute['price_rule_id'];
			   
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
}

/******************************************************************************/
/******************************************************************************/