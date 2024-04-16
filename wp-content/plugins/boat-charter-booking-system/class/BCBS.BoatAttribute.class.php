<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBoatAttribute
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->attributeType=array
		(
			'1'=>array(esc_html__('Text Value','boat-charter-booking-system')),
			'2'=>array(esc_html__('Single Choice','boat-charter-booking-system')),
			'3'=>array(esc_html__('Multi Choice','boat-charter-booking-system'))
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
		return(PLUGIN_BCBS_CONTEXT.'_boat_attr');
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
					'name'=>esc_html__('Boat Attributes','boat-charter-booking-system'),
					'singular_name'=>esc_html__('Boat Attribute','boat-charter-booking-system'),
					'add_new'=>esc_html__('Add New','boat-charter-booking-system'),
					'add_new_item'=>esc_html__('Add New Boat Attribute','boat-charter-booking-system'),
					'edit_item'=>esc_html__('Edit Boat Attribute','boat-charter-booking-system'),
					'new_item'=>esc_html__('New Boat Attribute','boat-charter-booking-system'),
					'all_items'=>esc_html__('Boat Attributes','boat-charter-booking-system'),
					'view_item'=>esc_html__('View Boat Attribute','boat-charter-booking-system'),
					'search_items'=>esc_html__('Search Boat Attributes','boat-charter-booking-system'),
					'not_found'=>esc_html__('No Boat Attributes Found','boat-charter-booking-system'),
					'not_found_in_trash'=>esc_html__('No Boat Attributes Found in Trash','boat-charter-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Boat Attributes','boat-charter-booking-system')
				),	
				'public'=>false,
				'show_ui'=>true,
				'show_in_menu'=>'edit.php?post_type='.BCBSBooking::getCPTName(),
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>array('title','page-attributes','thumbnail')
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_bcbs_meta_box_boat_attribute',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_boat_attribute',esc_html__('Main','boat-charter-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$data=array();
		
		$data['meta']=BCBSPostMeta::getPostMeta($post);
		
		$data['nonce']=BCBSHelper::createNonceField(PLUGIN_BCBS_CONTEXT.'_meta_box_boat_attribute');
		
		$data['dictionary']['attribute_type']=$this->getAttributeType();

		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/meta_box_boat_attribute.php');			
	}
	
	 /**************************************************************************/
	
	function adminCreateMetaBoxClass($class) 
	{
		array_push($class,'to-postbox-1');
		return($class);
	}
	
	/**************************************************************************/
	
	function getAttributeType()
	{
		return($this->attributeType);
	}
	
	/**************************************************************************/
	
	function isAttributeType($attributeType)
	{
		return(array_key_exists($attributeType,$this->getAttributeType()));
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		BCBSHelper::setDefault($meta,'attribute_type','1');
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(BCBSHelper::checkSavePost($postId,PLUGIN_BCBS_CONTEXT.'_meta_box_boat_attribute_noncename','savePost')===false) return(false);
		
		$meta=array();

		$Validation=new BCBSValidation();
		
		$this->setPostMetaDefault($meta);
		
		/***/
		
		if(BCBSHelper::getPostValue('is_edit_mode'))
		{
			$postMeta=BCBSPostMeta::getPostMeta($postId);
			$meta['attribute_type']=$postMeta['attribute_type'];
		}
		else
		{
			$meta['attribute_type']=BCBSHelper::getPostValue('attribute_type');
		}
		
		if(!$this->isAttributeType($meta['attribute_type']))
			$meta['attribute_type']=1;	  
		
		if($meta['attribute_type']!=1)
		{
			if(array_key_exists(PLUGIN_BCBS_CONTEXT.'_attribute_value',$_POST))
			{
				$data=BCBSHelper::getPostValue('attribute_value');
				if(!is_array($data)) $data=array();

				foreach($data as $index=>$value)
				{
					if($Validation->isNotEmpty($value))
					   $meta['attribute_value'][]=array('id'=>$index,'value'=>$value);
				}
			}
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
			'boat_attribute_id'=>0
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
		
		if($attribute['boat_attribute_id'])
			$argument['p']=$attribute['boat_attribute_id'];

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
			'title'=>esc_html__('Title','boat-charter-booking-system'),
			'attribute_type'=>esc_html__('Type','boat-charter-booking-system')
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
			case 'attribute_type':
				
				echo esc_html($this->attributeType[$meta['attribute_type']][0]);
				
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