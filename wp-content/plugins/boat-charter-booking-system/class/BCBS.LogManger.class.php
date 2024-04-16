<?php

/******************************************************************************/
/******************************************************************************/

class BCBSLogManager
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->type=array
		(
			'mail'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Sending an notification about new booking to the customer.','boat-charter-booking-system')
				),
				2=>array
				(
					'description'=>esc_html__('Sending an notification about new booking on defined e-mail addresses.','boat-charter-booking-system')
				),
				3=>array
				(
					'description'=>esc_html__('Sending an notification about new changes in the booking to the customer.','boat-charter-booking-system')
				)
			),
			'nexmo'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Sending an notification about new booking on defined phone number.','boat-charter-booking-system')
				)
			),
			'twilio'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Sending an notification about new booking on defined phone number.','boat-charter-booking-system')
				)
			),
			'telegram'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Sending an notification about new booking on defined phone number.','boat-charter-booking-system')
				)
			),
			'google_calendar'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Adding a new event to the calendar.','boat-charter-booking-system')
				)
			),
			'geolocation'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Getting country information based on customer IP address.','boat-charter-booking-system')
				)
			),
			'stripe'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Creating a payment.','boat-charter-booking-system')
				),
				2=>array
				(
					'description'=>esc_html__('Receiving a payment.','boat-charter-booking-system')
				)	
			),
			'paypal'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Creating a payment.','boat-charter-booking-system')
				),
				2=>array
				(
					'description'=>esc_html__('Receiving a payment.','boat-charter-booking-system')
				)	
			),
			'fixerio'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Importing an exchange rates.','boat-charter-booking-system')
				)	
			)
		);
	}
		
	/**************************************************************************/
	
	function add($type,$event,$message)
	{	
		$Validation=new BCBSValidation();
		
		if($Validation->isEmpty($message)) return;
		
		$logType=$this->get($type);
		
		array_unshift($logType,array
		(
			'event'=>$event,
			'timestamp'=>strtotime('now'),
			'message'=>$message
		));
		
		if(count($logType)>9) $logType=array_slice($logType,0,10);
		
		$logFull=$this->get();
		$logFull[$type]=$logType;
		
		update_option(PLUGIN_BCBS_OPTION_PREFIX.'_log',$logFull);
	}
	
	/**************************************************************************/
	
	function get($type=null)
	{
		$log=get_option(PLUGIN_BCBS_OPTION_PREFIX.'_log');

		if(!is_array($log)) $log=array();
		if(is_null($type)) return($log);
		
		if(!array_key_exists($type,$log)) $log[$type]=array();
		if(!is_array($log[$type])) $log[$type]=array();
		
		return($log[$type]);
	}
	
	/**************************************************************************/
	
	function show($type)
	{
		$log=$this->get($type);
		
		if(!count($log)) return;
		
		$Validation=new BCBSValidation();
		
		$i=0;
		$html=null;
		
		foreach($log as $value)
		{
			if($Validation->isNotEmpty($html)) $html.='<br/>';
			if(!array_key_exists($value['event'],$this->type[$type])) continue;
			
			$html.=
			'
				<li>
					<div class="to-field-disabled to-field-disabled-full-width">
						['.(++$i).']['.date_i18n('d-m-Y G:i:s',$value['timestamp']).']<br/>
						<b>'.$this->type[$type][$value['event']]['description'].'</b><br/><br/>
						'.nl2br(htmlspecialchars($value['message'])).'
					</div>
				</li>
			';
		}
		
		$html='<ul>'.$html.'</ul>';
		
		return($html);
	}
	
	/**************************************************************************/
	
	static function showS($type)
	{
		$LogManager=new BCBSLogManager();
		return($LogManager->show($type));
	}
	
	/**************************************************************************/

	function logWPMailError($wp_error)
	{
		global $bcbs_logEvent;
		
		$this->add('mail',$bcbs_logEvent,print_r($wp_error,true));
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/