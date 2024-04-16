<?php

/******************************************************************************/
/******************************************************************************/

class BCBSEmailAccount
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->secureConnectionType=array
		(
			'none'=>array(esc_html__('- None -','boat-charter-booking-system')),
			'ssl'=>array(esc_html__('SSL','boat-charter-booking-system')),
			'tls'=>array(esc_html__('TLS','boat-charter-booking-system')),
		);
	}
	
	/**************************************************************************/
	
	function isSecureConnectionType($name)
	{
		return(array_key_exists($name,$this->getSecureConnectionType()) ? true : false);
	}
	
	/**************************************************************************/
	
	function getSecureConnectionType()
	{
		return($this->secureConnectionType);
	}
	
	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_BCBS_CONTEXT.'_email_account');
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
					'name'=>esc_html__('E-mail Accounts','boat-charter-booking-system'),
					'singular_name'=>esc_html__('E-mail Accounts','boat-charter-booking-system'),
					'add_new'=>esc_html__('Add New','boat-charter-booking-system'),
					'add_new_item'=>esc_html__('Add New E-mail Account','boat-charter-booking-system'),
					'edit_item'=>esc_html__('Edit E-mail Account','boat-charter-booking-system'),
					'new_item'=>esc_html__('New E-mail Account','boat-charter-booking-system'),
					'all_items'=>esc_html__('E-mail Accounts','boat-charter-booking-system'),
					'view_item'=>esc_html__('View E-mail Account','boat-charter-booking-system'),
					'search_items'=>esc_html__('Search E-mail Accounts','boat-charter-booking-system'),
					'not_found'=>esc_html__('No E-mail Accounts Found','boat-charter-booking-system'),
					'not_found_in_trash'=>esc_html__('No E-mail Accounts in Trash','boat-charter-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('E-mail Accounts','boat-charter-booking-system')
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
		add_filter('postbox_classes_'.self::getCPTName().'_bcbs_meta_box_email_account',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_BCBS_CONTEXT.'_meta_box_email_account',esc_html__('Main','boat-charter-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$data=array();
		
		$data['meta']=BCBSPostMeta::getPostMeta($post);
		
		$data['nonce']=BCBSHelper::createNonceField(PLUGIN_BCBS_CONTEXT.'_meta_box_email_account');
		
		$data['dictionary']['secure_connection_type']=$this->secureConnectionType;
		
		echo BCBSTemplate::outputS($data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/meta_box_email_account.php');			
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
		BCBSHelper::setDefault($meta,'sender_name','');
		BCBSHelper::setDefault($meta,'sender_email_address','');
		
		BCBSHelper::setDefault($meta,'smtp_auth_enable','0');
		BCBSHelper::setDefault($meta,'smtp_auth_username','');
		BCBSHelper::setDefault($meta,'smtp_auth_password','');
		BCBSHelper::setDefault($meta,'smtp_auth_host','');
		BCBSHelper::setDefault($meta,'smtp_auth_port','');
		BCBSHelper::setDefault($meta,'smtp_auth_secure_connection_type','none');
		BCBSHelper::setDefault($meta,'smtp_auth_debug_enable','0');
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(BCBSHelper::checkSavePost($postId,PLUGIN_BCBS_CONTEXT.'_meta_box_email_account_noncename','savePost')===false) return(false);
		
		$Validation=new BCBSValidation();
		
		$option=BCBSHelper::getPostOption();

		if(!$Validation->isBool($option['smtp_auth_enable']))
			$option['smtp_auth_enable']=0;
		
		if(!$this->isSecureConnectionType($option['smtp_auth_secure_connection_type']))
			$option['smtp_auth_secure_connection_type']='none';
		
		if(!$Validation->isBool($option['smtp_auth_debug_enable']))
			$option['smtp_auth_debug_enable']=0;
		
		$field=array
		(
			'sender_name',
			'sender_email_address',
			'smtp_auth_enable',
			'smtp_auth_username',
			'smtp_auth_password',
			'smtp_auth_host',
			'smtp_auth_port',
			'smtp_auth_secure_connection_type',
			'smtp_auth_debug_enable'
		);

		foreach($field as $value)
			BCBSPostMeta::updatePostMeta($postId,$value,$option[$value]);
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'email_account_id'=>0
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
		
		if($attribute['email_account_id'])
			$argument['p']=$attribute['email_account_id'];

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
			'title'=>$column['title'],
			'sender'=>esc_html__('Sender','boat-charter-booking-system')
		);
   
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$meta=BCBSPostMeta::getPostMeta($post);
		
		$Validation=new BCBSValidation();
		
		switch($column) 
		{
			case 'sender':
				
				$html=null;
				
				if($Validation->isNotEmpty($meta['sender_name']))
					$html.=esc_html($meta['sender_name']);
				
				if($Validation->isNotEmpty($meta['sender_email_address']))
					$html.=' <a href="mailto:'.esc_attr($meta['sender_email_address']).'">&lt;'.esc_html($meta['sender_email_address']).'&gt;</a>';
				
				echo trim($html);
				
			break;
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function sendTestEmail()
	{
		$Email=new BCBSEmail();
		
		$response=array('error'=>1,'error_message'=>__('Cannot set details needed to send an e-mail message.','boat-charter-booking-system'));
		
		$emailAccountId=(int)BCBSHelper::getPostValue('email_account_id',false);
		
		if(($dictionary=$this->getDictionary(array('email_account_id'=>$emailAccountId)))===false)
			BCBSHelper::createJSONResponse($response);
		
		$emailAccount=$dictionary[$emailAccountId];
		
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
		
		$data=array();
		
		$data['style']=$Email->getEmailStyle();
		
		$Template=new BCBSTemplate($data,PLUGIN_BCBS_TEMPLATE_PATH.'email_test.php');
		$body=$Template->output();
		
		/***/
		
		global $bcbs_logEvent;
		
		$bcbs_logEvent=-1;
		
		add_action('wp_mail_failed','logWPMailErrorLocal',10,1);
		
		function logWPMailErrorLocal($wp_error)
		{
			global $bcbsGlobalData;
			$bcbsGlobalData['wp_mail_error']=$wp_error;
		} 
		
		/***/
     
		global $bcbsGlobalData;
		
		$Email->send(array(BCBSHelper::getPostValue('receiver_email_address',false)),__('Test message','boat-charter-booking-system'),$body);
	   
		$response=array('error'=>0);
		
		$response['email_response']=esc_html(print_r($bcbsGlobalData['wp_mail_error'],true));
		
		BCBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/