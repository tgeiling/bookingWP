<?php

/******************************************************************************/
/******************************************************************************/

class BCBSReportEmail
{
	/**************************************************************************/

	function __construct()
	{
	
	}

	/**************************************************************************/

	function send()
	{
		/***/
		
		global $bcbs_phpmailer;
		
		$Email=new BCBSEmail();
		$Validation=new BCBSValidation();
		$EmailAccount=new BCBSEmailAccount();
				
		if((int)BCBSOption::getOption('email_report_status')!=1) return(false);
	   		
		if(($emailAccount=$EmailAccount->getDictionary(array('email_account_id'=>BCBSOption::getOption('email_report_sender_email_account_id'))))===false) return(false);
		
		$emailRecipient=preg_split('/;/',BCBSOption::getOption('email_report_recipient_email_address'));
		foreach($emailRecipient as $index=>$value)
		{
			if(!$Validation->isEmailAddress($value,false))
			  unset($emailRecipient[$index]);
		}
		if(!count($emailRecipient)) return(false);
		
		$dictionary=$this->getBooking();
		if(!count($dictionary)) return(false);
		
		$emailAccount=$emailAccount[BCBSOption::getOption('email_report_sender_email_account_id')];
		
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

		$data['style']=$Email->getEmailStyle();
		$data['booking']=$dictionary;

		/***/
		
		$Template=new BCBSTemplate($data,PLUGIN_BCBS_TEMPLATE_PATH.'email_report.php');
		$body=$Template->output();
		
		/***/
		
		$recipient=preg_split('/;/',BCBSOption::getOption('email_report_recipient_email_address'));
		$Email->send($recipient,esc_html__('Boat Charter Booking System Report','boat-charter-booking-system'),$body);
	}
	
	/**************************************************************************/
	
	function getBooking()
	{
		global $post;
		
		$dictionary=array();
		$Booking=new BCBSBooking();
		
		BCBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>BCBSBooking::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc'),
			'suppress_filters'=>true,
			'meta_query'=>array
			(
				'relation'=>'OR',
				array
				(
					'key'=>PLUGIN_BCBS_CONTEXT.'_departure_date',
					'value'=>date_i18n('d-m-Y'),
					'compare'=>'='
				),
				array
				(
					'key'=>PLUGIN_BCBS_CONTEXT.'_return_date',
					'value'=>date_i18n('d-m-Y'),
					'compare'=>'='
				)
			)
		);

		$query=new WP_Query($argument);
		if($query===false) return($dictionary);
		
		while($query->have_posts())
		{
			$query->the_post();
			if(is_null($post)) continue;

			$dictionary[$post->ID]=$Booking->getBooking($post->ID);
		}

		BCBSHelper::preservePost($post,$bPost,0);	
		
		return($dictionary);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/