<?php

/******************************************************************************/
/******************************************************************************/

class BCBSCoupon
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
		return(PLUGIN_BCBS_CONTEXT.'_coupon');
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
					'name'=>esc_html__('Coupons','boat-charter-booking-system'),
					'singular_name'=>esc_html__('Coupons','boat-charter-booking-system'),
					'add_new'=>esc_html__('Add New','boat-charter-booking-system'),
					'add_new_item'=>esc_html__('Add New Coupon','boat-charter-booking-system'),
					'edit_item'=>esc_html__('Edit Coupon','boat-charter-booking-system'),
					'new_item'=>esc_html__('New Coupon','boat-charter-booking-system'),
					'all_items'=>esc_html__('Coupons','boat-charter-booking-system'),
					'view_item'=>esc_html__('View Coupon','boat-charter-booking-system'),
					'search_items'=>esc_html__('Search Coupons','boat-charter-booking-system'),
					'not_found'=>esc_html__('No Coupons Found','boat-charter-booking-system'),
					'not_found_in_trash'=>esc_html__('No Coupons in Trash','boat-charter-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Coupons','boat-charter-booking-system')
				),	
				'public'=>false,
				'show_ui'=>true,
				'show_in_menu'=>'edit.php?post_type='.BCBSBooking::getCPTName(),
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>false
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_bcbs_meta_box_coupon',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_coupon',esc_html__('Main','boat-charter-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$Booking=new BCBSBooking();
		$Boat=new BCBSBoat();
		
		$data=array();
			   
		$data['meta']=BCBSPostMeta::getPostMeta($post);
		
		$data['nonce']=BCBSHelper::createNonceField(PLUGIN_BCBS_CONTEXT.'_meta_box_coupon');
		
		if(!isset($data['meta']['code']))
		{
			$code=$this->generateCode();
			
			wp_update_post(array('ID'=>$post->ID,'post_title'=>$code));
			
			BCBSPostMeta::updatePostMeta($post->ID,'code',$code);
			BCBSPostMeta::updatePostMeta($post->ID,'usage_count',0);
			
			$data['meta']=BCBSPostMeta::getPostMeta($post);
		}
		
		$data['meta']['usage_count']=$Booking->getCouponCodeUsageCount($data['meta']['code']);
		
		$data['dictionary']['boat']=$Boat->getDictionary();
		$data['dictionary']['boat_category']=$Boat->getCategory();
		
		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/meta_box_coupon.php');			
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
		BCBSHelper::setDefault($meta,'usage_limit','');
		
		BCBSHelper::setDefault($meta,'boat_id',array(-1));
		BCBSHelper::setDefault($meta,'boat_category_id',array(-1));
		
		BCBSHelper::setDefault($meta,'discount_percentage',0);
		BCBSHelper::setDefault($meta,'discount_fixed',0);
		
		BCBSHelper::setDefault($meta,'active_date_start','');
		BCBSHelper::setDefault($meta,'active_date_stop','');
	
		BCBSHelper::setDefault($meta,'discount_rental_day_count',array());
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(BCBSHelper::checkSavePost($postId,PLUGIN_BCBS_CONTEXT.'_meta_box_coupon_noncename','savePost')===false) return(false);
		
		$Date=new BCBSDate();
		$Boat=new BCBSBoat();
		$Validation=new BCBSValidation();
		
		$option=BCBSHelper::getPostOption();
			 
		/**/

		if(($this->existCode($option['code'],$postId)) || (!$this->validCode($option['code'])))
			$option['code']=$this->generateCode();
		
		if(!$Validation->isNumber($option['usage_limit'],1,9999))
			$option['usage_limit']='';
		 
		/***/
		
		if(!$Validation->isDate($option['active_date_start']))
			$option['active_date_start']='';
		if(!$Validation->isDate($option['active_date_stop']))
			$option['active_date_stop']='';
		if(($Validation->isDate($option['active_date_start'])) && ($Validation->isDate($option['active_date_stop'])))
		{
			if($Date->compareDate($option['active_date_start'],$option['active_date_stop'])==1)
			{
				$option['active_date_start']='';
				$option['active_date_stop']='';
			}
		}	
		
		$option['active_date_start']=$Date->formatDateToStandard($option['active_date_start']);
		$option['active_date_stop']=$Date->formatDateToStandard($option['active_date_stop']);
		
		/***/
		
		$boat=$Boat->getDictionary();
		$option['boat_id']=(array)$option['boat_id'];
		
		foreach($option['boat_id'] as $index=>$value)
		{
			if(!array_key_exists($value,$boat))
				unset($option['boat_id'][$index]);
		}
		
		if(!count($option['boat_id'])) $option['boat_id']=array(-1);
		
		/***/
		
		$boatCategory=$Boat->getCategory();
		$option['boat_category_id']=(array)$option['boat_category_id'];
		
		foreach($option['boat_category_id'] as $index=>$value)
		{
			if(!array_key_exists($value,$boatCategory))
				unset($option['boat_category_id'][$index]);
		}

		if(!count($option['boat_category_id'])) $option['boat_category_id']=array(-1);		
		
		/***/
		
		$option['discount_percentage']=BCBSPrice::formatToSave($option['discount_percentage']);
		if($Validation->isFloat($option['discount_percentage'],0.01,99.99,false))
		{
			$option['discount_fixed']=0;
		}
		else $option['discount_percentage']=0;
		
		if(($Validation->isPrice($option['discount_fixed'])) && ($option['discount_fixed']>0))
		{
			$option['discount_percentage']=0;
		}
		else $option['discount_fixed']=0;		
		
		/***/		

		$number=array();
	   
		foreach($option['discount_rental_day_count']['start'] as $index=>$value)
		{
			$d=array
			(
				$value,
				$option['discount_rental_day_count']['stop'][$index],
				$option['discount_rental_day_count']['discount_percentage'][$index],
				$option['discount_rental_day_count']['discount_fixed'][$index]
			);
			
			if(!$Validation->isNumber($d[0],0,99999)) continue;
			if(!$Validation->isNumber($d[1],0,99999)) continue;
  
			$d[2]=BCBSPrice::formatToSave($d[2]);
			if($Validation->isFloat($d[2],0.01,99.99,false)) $d[3]=0;
			
			if(($Validation->isPrice($d[3])) && ($d[3]>0)) $d[2]=0;
			else $d[3]=0;
			
			if($d[0]>$d[1]) continue;
			
			array_push($number,array('start'=>$d[0],'stop'=>$d[1],'discount_percentage'=>$d[2],'discount_fixed'=>BCBSPrice::formatToSave($d[3])));
		}
		
		$option['discount_rental_day_count']=$number;
				
		/***/
		
		$option['discount_fixed']=BCBSPrice::formatToSave($option['discount_fixed']);
		
		$key=array
		(
			'code',
			'usage_limit',
			'active_date_start',
			'active_date_stop',
			'boat_id',
			'boat_category_id',
			'discount_percentage',
			'discount_fixed',
			'discount_rental_day_count'
		);
		
		foreach($key as $index)
			BCBSPostMeta::updatePostMeta($postId,$index,$option[$index]);
		
		wp_update_post(array('ID'=>$postId,'post_title'=>$option['code']));
	}
	
	/**************************************************************************/
	
	function manageEditColumns($column)
	{
		$column=array
		(
			'cb'=>$column['cb'],
			'title'=>esc_html__('Code','boat-charter-booking-system'),
			'usage_limit'=>esc_html__('Usage limit','boat-charter-booking-system'),
			'discount_percentage'=>esc_html__('Percentage discount','boat-charter-booking-system'),
			'discount_fixed'=>esc_html__('Fixed discount','boat-charter-booking-system'),
			'active_date_start'=>esc_html__('Active from','boat-charter-booking-system'),
			'active_date_stop'=>esc_html__('Active to','boat-charter-booking-system')
		);
   
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$Date=new BCBSDate();
		
		$meta=BCBSPostMeta::getPostMeta($post);
		
		switch($column) 
		{
			case 'usage_limit':
				
				echo esc_html($meta['usage_limit']);
				
			break;
		
			case 'discount_percentage':
				
				echo esc_html($meta['discount_percentage']);
				
			break;
		
			case 'discount_fixed':
				
				echo esc_html($meta['discount_fixed']);
				
			break;
		
			case 'active_date_start':

				echo esc_html($Date->formatDateToDisplay($meta['active_date_start']));
				
			break;

			case 'active_date_stop':
				
				echo esc_html($Date->formatDateToDisplay($meta['active_date_stop']));
				
			break;			
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function create()
	{
		$option=BCBSHelper::getPostOption();

		$response=array('global'=>array('error'=>1));

		$Date=new BCBSDate();
		$Coupon=new BCBSCoupon();
		$Notice=new BCBSNotice();
		$Validation=new BCBSValidation();
		
		$invalidValue=esc_html__('This field includes invalid value.','boat-charter-booking-system');
		
		if(!$Validation->isNumber($option['coupon_generate_count'],1,999))
			$Notice->addError(BCBSHelper::getFormName('coupon_generate_count',false),$invalidValue);			
		if(!$Validation->isNumber($option['coupon_generate_usage_limit'],1,9999,true))
			$Notice->addError(BCBSHelper::getFormName('coupon_generate_usage_limit',false),$invalidValue);			
		
		$option['coupon_generate_active_date_start']=$Date->formatDateToStandard($option['coupon_generate_active_date_start']);
		$option['coupon_generate_active_date_stop']=$Date->formatDateToStandard($option['coupon_generate_active_date_stop']);
		
		if(!$Validation->isDate($option['coupon_generate_active_date_start'],true))
			$Notice->addError(BCBSHelper::getFormName('coupon_generate_active_date_start',false),$invalidValue);	  
		else if(!$Validation->isDate($option['coupon_generate_active_date_stop'],true))
			$Notice->addError(BCBSHelper::getFormName('coupon_generate_active_date_stop',false),$invalidValue);			  
		else
		{
			if($Date->compareDate($option['coupon_generate_active_date_start'],$option['coupon_generate_active_date_stop'])==1)
			{
				$Notice->addError(BCBSHelper::getFormName('coupon_generate_active_date_start',false),esc_html__('Invalid dates range.','boat-charter-booking-system'));
				$Notice->addError(BCBSHelper::getFormName('coupon_generate_active_date_stop',false),esc_html__('Invalid dates range.','boat-charter-booking-system')); 
			}			
		}
		
		if($Notice->isError())
		{
			$response['local']=$Notice->getError();
		}
		else
		{
			$Coupon->generate($option);
			$response['global']['error']=0;
		}

		$response['global']['notice']=$Notice->createHTML(PLUGIN_BCBS_TEMPLATE_PATH.'notice.php');

		echo json_encode($response);
		exit;
	}
	
    /**************************************************************************/
    
	function validCode($code)
	{
		$Validation=new BCBSValidation();

		if($Validation->isEmpty($code)) return(false);

		if(strlen($code)>32) return(false);

		return(true);
	}
	
	/**************************************************************************/
	
	function existCode($code,$postId)
	{
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'any',
			'post__not_in'=>array($postId),
			'posts_per_page'=>-1,
			'meta_key'=>PLUGIN_BCBS_CONTEXT.'_code',
			'meta_value'=>$code,
			'meta_compare'=>'='
		);

		$query=new WP_Query($argument);
		if($query===false) return(false);

		/***/

		if($query->found_posts!=1) return(false);        

		return(true);
	}
	
	/**************************************************************************/
	
	function generate($data)
	{
		$Validation=new BCBSValidation();
		
		for($i=0;$i<$data['coupon_generate_count'];$i++)
		{
			$couponCode=$this->generateCode();
			
			$couponId=wp_insert_post
			(
				array
				(
					'comment_status'=>'closed',
					'ping_status'=>'closed',
					'post_author'=>get_current_user_id(),
					'post_title'=>$couponCode,
					'post_status'=>'publish',
					'post_type'=>self::getCPTName()
				)
			);
			
			if($couponId>0)
			{
				$discountPercentage=$data['coupon_generate_discount_percentage'];
				$discountFixed=$data['coupon_generate_discount_fixed'];
				
				if($Validation->isNumber($discountPercentage,1,99,true))
				{
					$discountFixed=0;
				}
				else 
				{
					$discountPercentage=0;
					if($Validation->isPrice($discountFixed))
					{
						$discountPercentage=0;
					}
					else $discountFixed=0;					 
				}
				
				BCBSPostMeta::updatePostMeta($couponId,'code',$couponCode);
				
				BCBSPostMeta::updatePostMeta($couponId,'usage_count',0);
				BCBSPostMeta::updatePostMeta($couponId,'usage_limit',$data['coupon_generate_usage_limit']);
				
				BCBSPostMeta::updatePostMeta($couponId,'discount_percentage',$discountPercentage);
				BCBSPostMeta::updatePostMeta($couponId,'discount_fixed',$discountFixed);
				
				BCBSPostMeta::updatePostMeta($couponId,'active_date_start',$data['coupon_generate_active_date_start']);
				BCBSPostMeta::updatePostMeta($couponId,'active_date_stop',$data['coupon_generate_active_date_stop']);
			}
		}
	}
	
	/**************************************************************************/
	
	function generateCode($length=12)
	{
		$code=null;
		
		$char='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charLength=strlen($char);
		
		for($i=0;$i<$length;$i++)
			$code.=$char[rand(0,$charLength-1)];
		return($code);
	}
	
	/**************************************************************************/
	
	function checkCode($bookingForm,&$couponCodeSourceType)
	{
		global $post;
		
		$Date=new BCBSDate();
		$Booking=new BCBSBooking();
		$Validation=new BCBSValidation();
		
		$couponCode=null;
		
		$data=BCBSHelper::getPostOption();
		
		if($bookingForm['meta']['coupon_id']!=-1)
		{
			$couponCodeSourceType=1;
			
			$dictionary=$this->getDictionary();
			if(array_key_exists($bookingForm['meta']['coupon_id'],$dictionary))
				$couponCode=$dictionary[$bookingForm['meta']['coupon_id']]['meta']['code'];
		}
		
		if(array_key_exists('coupon_code',$data))
		{
			$couponCodeSourceType=2;
			$couponCode=$data['coupon_code'];
		}
		
		if($Validation->isEmpty($couponCode)) return(false);
		
		/***/
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'meta_key'=>PLUGIN_BCBS_CONTEXT.'_code',
			'meta_value'=>$couponCode,
			'meta_compare'=>'='
		);
		
		$query=new WP_Query($argument);
		if($query===false) return(false);
		
		/***/
		
		if($query->found_posts!=1) return(false);
		
		$query->the_post();
		
		$meta=BCBSPostMeta::getPostMeta($post);
		
		/***/
		
		if($Validation->isNotEmpty($meta['usage_limit']))
		{	
		   $count=$Booking->getCouponCodeUsageCount($couponCode);
	  
		   if($count===false) return(false);
		   if($count>=$meta['usage_limit']) return(false);
		}
		
		/***/
		
		if($Validation->isNotEmpty($meta['active_date_start']))
		{
			if($Date->compareDate(date_i18n('Y-m-d'),$meta['active_date_start'])===2) return(false);
		}
		
		if($Validation->isNotEmpty($meta['active_date_stop']))
		{
			if($Date->compareDate($meta['active_date_stop'],date_i18n('Y-m-d'))===2) return(false);
		}  
		
		/***/

		if(array_key_exists($data['boat_id'],$bookingForm['dictionary']['boat']))
		{
			if((is_array($meta['boat_id'])) && (count($meta['boat_id'])) && (!in_array(-1,$meta['boat_id'])))
			{
				if(!in_array($data['boat_id'],$meta['boat_id'])) return(false);
			}
			if((is_array($meta['boat_category_id'])) && (count($meta['boat_category_id'])) && (!in_array(-1,$meta['boat_category_id'])))
			{
				$categoryFound=false;
				
				foreach($meta['boat_category_id'] as $value)
				{
					if(has_term($value,BCBSBoat::getCPTCategoryName(),$data['boat_id']))
					{
						$categoryFound=true;
						break;
					}
				}
				
				if(!$categoryFound) return(false);
			}
		}
		
		/***/

		return(array('post'=>$post,'meta'=>$meta));
	}
	
	/**************************************************************************/
	
	function calculateDiscountPercentage($discountFixed,$countDay,$countHour,$priceDay,$priceHour)
	{
		if($discountFixed==0) return(0);
		
		$sum=$countDay*$priceDay+$countHour*$priceHour;
		
		if($sum<=$discountFixed) return(0);
		
		$discountPercentage=($discountFixed/$sum)*100;

		return($discountPercentage);
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'coupon_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		BCBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1
		);
		
		if($attribute['coupon_id'])
			$argument['p']=$attribute['coupon_id'];

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