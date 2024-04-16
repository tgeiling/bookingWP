<?php

/******************************************************************************/
/******************************************************************************/

class BCBSGeoLocation
{
	/**************************************************************************/

	function __construct()
	{
		$this->server=array
		(
			1=>array
			(
				'name'=>esc_html__('KeyCDN [keycdn.com]','boat-charter-booking-system'),
				'api_url_address'=>'https://tools.keycdn.com/geo.json?host={CLIENT_IP}'
			),
			2=>array
			(
				'name'=>esc_html__('IP-API [ip-api.com]','boat-charter-booking-system'),
				'api_url_address'=>'http://ip-api.com/json/{CLIENT_IP}'
			),
			3=>array
			(
				'name'=>esc_html__('ipstack [ipstack.com]','boat-charter-booking-system'),
				'api_url_address'=>'http://api.ipstack.com/{CLIENT_IP}?access_key={API_KEY}'
			)		   
		);		
	}
	
	/**************************************************************************/
	
	function getIPAddress()
	{
		$address=null;
		
		$data=array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR');
		
		foreach($data as $value)
		{
			if(array_key_exists($value,$_SERVER))
			{
				$address=$_SERVER[$value];
				break;
			}	 
		}
		
		return($address);
	}
	
	/**************************************************************************/
	
	function getCountryCode()
	{
		$document=$this->getDocument();
		if($document===false) return(null);
		return($document['country_code']);
	}
	
	/**************************************************************************/
	
	function getCoordinate()
	{
		$Validation=new BCBSValidation();
		
		if(($document=$this->getDocument())===false)
			return(array('lat'=>0,'lng'=>0));
		
		$coordinate=array
		(
			'lat'=>strval($document['latitude']),
			'lng'=>strval($document['longitude'])
		);
		
		foreach($coordinate as $index=>$value)
		{
			if($Validation->isEmpty($value))
				$coordinate[$index]=0;
		}
		
		return($coordinate);
	}
	
	/**************************************************************************/
	
	function getDocument()
	{
		if(!array_key_exists(BCBSOption::getOption('geolocation_server_id'),$this->getServer())) return(false);
		
		if(!ini_get('allow_url_fopen')) return(false);
	 
		$sessionStart=true;
		$sessionIndex=PLUGIN_BCBS_CONTEXT.'_customer_geolocation_document';
		
		if(!session_id())
		{
			if(@session_start()===false)
				$sessionStart=false;
		}
		
		if(($sessionStart) && (is_array($_SESSION)) && (array_key_exists($sessionIndex,$_SESSION)))
		{
			$document=$_SESSION[$sessionIndex];
		}
		else
		{
			$addressIP=$this->getIPAddress();
			$addressURL=$this->server[BCBSOption::getOption('geolocation_server_id')]['api_url_address'];

			if(BCBSOption::getOption('geolocation_server_id')==3)
				$addressURL=preg_replace(array('/{CLIENT_IP}/','/{API_KEY}/'),array($addressIP,BCBSOption::getOption('geolocation_server_id_3_api_key')),$addressURL);
			else $addressURL=preg_replace(array('/{CLIENT_IP}/'),array($addressIP),$addressURL);

			$pageURL=parse_url(home_url());
			
			$context=stream_context_create(array('http'=>array('timeout'=>3,'user_agent'=>'keycdn-tools:'.$pageURL['scheme'].'://'.$pageURL['host'])));
			if(($document=file_get_contents($addressURL,false,$context))===false) return(false);

			if((is_null($document)) || ($document===false)) return(false);
		 
			$_SESSION[$sessionIndex]=$document;
		}
		
		/***/
		
		$data=array();
		
		$document=json_decode($document); 
		
		$LogManager=new BCBSLogManager();
		$LogManager->add('geolocation',1,print_r($document,true));  

		switch(BCBSOption::getOption('geolocation_server_id'))
		{
			case 1:
				
				if($document->{'status'}!='success') return(false);
				
				$data['latitude']=strval($document->{'data'}->{'geo'}->{'latitude'});
				$data['longitude']=strval($document->{'data'}->{'geo'}->{'longitude'});
				$data['country_code']=strval($document->{'data'}->{'geo'}->{'country_code'});
				
			break;
				
			case 2:
				
				if(!property_exists($document,'countryCode')) return(false);
				
				$data['latitude']=strval($document->{'lat'});
				$data['longitude']=strval($document->{'lon'});
				$data['country_code']=strval($document->{'countryCode'});
				
			break;
				
			case 3:
				
				if(!property_exists($document,'country_code')) return(false);
				
				$data['latitude']=strval($document->{'latitude'});
				$data['longitude']=strval($document->{'longitude'});
				$data['country_code']=strval($document->{'country_code'});
				 
			break;
		}

		return($data);
	}
	
	/**************************************************************************/
	
	function getServer()
	{
		return($this->server);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/