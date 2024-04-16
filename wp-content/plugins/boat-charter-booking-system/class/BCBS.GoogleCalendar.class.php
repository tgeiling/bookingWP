<?php

/******************************************************************************/
/******************************************************************************/

class BCBSGoogleCalendar
{
	/**************************************************************************/
	
	function __construct()
	{

	}
	
	/**************************************************************************/
	
	function sendBooking($bookingId)
	{
		$Booking=new BCBSBooking();
		$Marina=new BCBSMarina();
		$Validation=new BCBSValidation();
			
		/***/
		
		if(($booking=$Booking->getBooking($bookingId))===false) return(false);
		
		$marinaDepartureId=$booking['meta']['marina_departure_id'];
		
		$dictionary=$Marina->getDictionary(array('marina_id'=>$marinaDepartureId));
		if(count($dictionary)!=1) return(false);
		
		$marinaDeparture=$dictionary[$marinaDepartureId];
		
		if((int)$marinaDeparture['meta']['google_calendar_enable']!==1) return(false);
		
		if(($Validation->isEmpty($marinaDeparture['meta']['google_calendar_id'])) || ($Validation->isEmpty($marinaDeparture['meta']['google_calendar_settings']))) return(false);
		
		/***/
		
		$this->token=get_option(PLUGIN_BCBS_CONTEXT.'_google_calendar_token','');
		$this->expiration=get_option(PLUGIN_BCBS_CONTEXT.'_google_calendar_expiration','');
		
		$this->calendar_id=$marinaDeparture['meta']['google_calendar_id']; 
		$this->settings=json_decode($marinaDeparture['meta']['google_calendar_settings']); 
		
		/***/
		
		$token=$this->getToken();
		if(!$token) return(false);
				
		/***/

		$Timezone=new DateTimeZone($this->getTimezoneString());
		
		/***/
		
		$departure=$booking['meta']['departure_date'].' '.$booking['meta']['departure_time'];
		$departureDate=new DateTime($departure,$Timezone);
		
		$return=$booking['meta']['return_date'].' '.$booking['meta']['return_time'];
		$returnDate=new DateTime($return,$Timezone);		
		
		$bookingDescription='<a href="'.esc_url(admin_url('post.php').'?post='.$bookingId.'&action=edit').'" target="_blank">'.esc_html($booking['post']->post_title).'</a><br>';
		$bookingDescription.=sprintf(esc_html__('Client: %s %s','boat-charter-booking-system'),esc_html($booking['meta']['client_contact_detail_first_name']),esc_html($booking['meta']['client_contact_detail_last_name'])).'<br>';
		$bookingDescription.=sprintf(esc_html__('Boat: %s','boat-charter-booking-system'),esc_html($booking['meta']['boat_name'])).'<br>';
		
		$bookingDetails=array
		(
			'summary'=>$booking['post']->post_title,
			'location'=>$marinaDeparture['post']->post_title,
			'description'=>$bookingDescription,
			'start'=>array
			(
				'dateTime'=>$departureDate->format(DateTime::RFC3339),
			),
			'end'=>array
			(
				'dateTime'=>$returnDate->format(DateTime::RFC3339),
			),
		);
				
		/***/

		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,'https://www.googleapis.com/calendar/v3/calendars/'.$this->calendar_id.'/events?access_token='.$token);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($bookingDetails));
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json')); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		
		$response=curl_exec($ch);
		$responseDecoded=json_decode($response);
		
		$LogManager=new BCBSLogManager();
		$LogManager->add('google_calendar',1,print_r($responseDecoded,true));   
		
		curl_close($ch);
		
		if((is_object($responseDecoded)) && (property_exists($responseDecoded,'kind')) && ($responseDecoded->kind=='calendar#event'))
			return(true);
		
		return(false);
	}
	
	/**************************************************************************/
	
	function getCalendarList()
	{
		$token=$this->getToken();
		if(!$token) return(false);
		
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,'https://www.googleapis.com/calendar/v3/users/me/calendarList?access_token='.$token);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		
		$response=curl_exec($ch);
		$responseDecoded=json_decode($response);
		
		curl_close($ch);
		
		if((is_object($responseDecoded)) && (property_exists($responseDecoded,'kind')) && ($responseDecoded->kind=='calendar#calendarList'))
			return($responseDecoded);
		
		return(false);
	}
	
	/**************************************************************************/

	function getToken()
	{		
		if(($this->token) && ($this->expiration) && ($this->expiration>time()))
			return($this->token);
		
		/***/

		$header='{"alg":"RS256","typ":"JWT"}';
		$headerEncoded=$this->base64URLEncode($header);
		
		/***/
		
		$assertionTime=time();
		$expirationTime=$assertionTime+3600;
		
		$claimSet='{
		  "iss":"'.$this->settings->client_email.'",
		  "scope":"https://www.googleapis.com/auth/calendar",
		  "aud":"https://www.googleapis.com/oauth2/v4/token",
		  "exp":'.$expirationTime.',
		  "iat":'.$assertionTime.'
		}';
		
		$claimSetEncoded=$this->base64URLEncode($claimSet);
		
		/***/
		
		$signature='';
		openssl_sign($headerEncoded.'.'.$claimSetEncoded,$signature,$this->settings->private_key,'SHA256');
		$signatureEncoded=$this->base64URLEncode($signature);
		$assertion=$headerEncoded.'.'.$claimSetEncoded.'.'.$signatureEncoded;

		/***/
		
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,'https://www.googleapis.com/oauth2/v4/token');
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_POSTFIELDS,'grant_type=urn%3Aietf%3Aparams%3Aoauth%3Agrant-type%3Ajwt-bearer&assertion='.$assertion);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		
		$response=curl_exec($ch);
		$responseDecoded=json_decode($response);
		
		curl_close($ch);
		
		if((is_object($responseDecoded)) && (property_exists($responseDecoded,'access_token')))
		{
			$this->token=$responseDecoded->access_token;
			$this->expiration=$expirationTime;
			
			update_option(PLUGIN_BCBS_CONTEXT.'_google_calendar_token',$this->token);
			update_option(PLUGIN_BCBS_CONTEXT.'_google_calendar_expiration',$this->expiration);
			
			return($this->token);
		}
			
		return(false);
	}
	
	/**************************************************************************/
	
	function base64URLEncode($data)
	{
		return(rtrim(strtr(base64_encode($data),'+/','-_'),'='));
	}
	
	/**************************************************************************/
	
	function getTimezoneString()
	{
		$timezoneString=get_option('timezone_string');
		if(!$timezoneString)
		{
			$gmtOffset=get_option('gmt_offset');
			$timezoneString=timezone_name_from_abbr('',$gmtOffset*3600,false);
			if($timezoneString===false)
				$timezoneString=timezone_name_from_abbr('',0,false);
		}
		return($timezoneString);		
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/