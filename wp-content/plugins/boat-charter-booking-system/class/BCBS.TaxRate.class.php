<?php

/******************************************************************************/
/******************************************************************************/

class BCBSTaxRate
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
		return(PLUGIN_BCBS_CONTEXT.'_tax_rate');
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
					'name'=>esc_html__('Tax Rates','boat-charter-booking-system'),
					'singular_name'=>esc_html__('Tax Rates','boat-charter-booking-system'),
					'add_new'=>esc_html__('Add New','boat-charter-booking-system'),
					'add_new_item'=>esc_html__('Add New Tax Rate','boat-charter-booking-system'),
					'edit_item'=>esc_html__('Edit Tax Rate','boat-charter-booking-system'),
					'new_item'=>esc_html__('New Tax Rate','boat-charter-booking-system'),
					'all_items'=>esc_html__('Tax Rates','boat-charter-booking-system'),
					'view_item'=>esc_html__('View Tax Rate','boat-charter-booking-system'),
					'search_items'=>esc_html__('Search Tax Rates','boat-charter-booking-system'),
					'not_found'=>esc_html__('No Tax Rates Found','boat-charter-booking-system'),
					'not_found_in_trash'=>esc_html__('No Tax Rates in Trash','boat-charter-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Tax Rates','boat-charter-booking-system')
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
		add_filter('postbox_classes_'.self::getCPTName().'_bcbs_meta_box_tax_rate',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_tax_rate',esc_html__('Main','boat-charter-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$data=array();
		
		$data['meta']=BCBSPostMeta::getPostMeta($post);
		
		$data['nonce']=BCBSHelper::createNonceField(PLUGIN_BCBS_CONTEXT.'_meta_box_tax_rate');
		
		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/meta_box_tax_rate.php');			
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
		BCBSHelper::setDefault($meta,'tax_rate_value','23.00');
		BCBSHelper::setDefault($meta,'tax_rate_default','0');
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(BCBSHelper::checkSavePost($postId,PLUGIN_BCBS_CONTEXT.'_meta_box_tax_rate_noncename','savePost')===false) return(false);
		
		$meta=array();

		$Validation=new BCBSValidation();
		
		$this->setPostMetaDefault($meta);
		
		$meta['tax_rate_value']=BCBSHelper::getPostValue('tax_rate_value');
		if(!$Validation->isFloat($meta['tax_rate_value'],0,100))
			$meta['tax_rate_value']=23.00;
		
		$meta['tax_rate_value']=BCBSPrice::formatToSave($meta['tax_rate_value']);
		
		$meta['tax_rate_default']=BCBSHelper::getPostValue('tax_rate_default');
		if(!$Validation->isBool($meta['tax_rate_default']))
			$meta['tax_rate_default']=0;
		
		/***/
		
		if($meta['tax_rate_default']==1)
		{
			$id=$this->getDefaultTaxPostId();
			if($id!=0) BCBSPostMeta::updatePostMeta($id,'tax_rate_default',0);
		}
		
		/***/
		
		foreach($meta as $index=>$value)
			BCBSPostMeta::updatePostMeta($postId,$index,$value);
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'tax_rate_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		BCBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'meta_key'=>PLUGIN_BCBS_CONTEXT.'_tax_rate_value',
			'orderby'=>'meta_value_num',
			'order'=>'asc'
		);
		
		if($attribute['tax_rate_id'])
			$argument['p']=$attribute['tax_rate_id'];

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
	
	function getDefaultTaxPostId($taxRate=null)
	{
		if(is_null($taxRate))
			$taxRate=BCBSGlobalData::setGlobalData('tax_rate_dictionary',array(new BCBSTaxRate(),'getDictionary'));
		
		foreach($taxRate as $index=>$value)
		{
			if($value['meta']['tax_rate_default']==1)
				return($index);
		}
		
		return(0);
	}
	
	/**************************************************************************/
	
	function getTaxRateValue($taxRateId,$taxRate)
	{
		if(!isset($taxRate[$taxRateId])) return(0);
		return($taxRate[$taxRateId]['meta']['tax_rate_value']);
	}
	
	/**************************************************************************/
	
	function isTaxRate($taxRateId)
	{
		$dictionary=$this->getDictionary();
		return(array_key_exists($taxRateId,$dictionary));
	}
	
	/**************************************************************************/
	
	function manageEditColumns($column)
	{
		$column=array
		(
			'cb'=>$column['cb'],
			'title'=>esc_html__('Title','boat-charter-booking-system'),
			'value'=>esc_html__('Value','boat-charter-booking-system')
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
			case 'value':
				
				echo esc_html($meta['tax_rate_value']).'%';
				
			break;
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/