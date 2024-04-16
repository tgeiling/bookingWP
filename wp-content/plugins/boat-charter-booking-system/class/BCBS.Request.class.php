<?php

/******************************************************************************/
/******************************************************************************/

class BCBSRequest
{
	/**************************************************************************/
	
	static function get($name,$attribute=true)
	{
		if(array_key_exists($name,$_GET))
		{
			if($attribute) return(esc_attr(BCBSHelper::stripslashes($_GET[$name])));
			return(BCBSHelper::stripslashes($_GET[$name]));
		}
		if(array_key_exists($name,$_POST))
		{
			if($attribute) return(esc_attr(BCBSHelper::stripslashes($_POST[$name])));
			return(BCBSHelper::stripslashes($_POST[$name]));
		}
		return;
	}
	
	/**************************************************************************/
	
	static function getOnPrefix($prefix,$attribute=true)
	{
		$data=array();
		
		foreach($_GET as $index=>$value)
		{
			$key='/^'.$prefix.'_/';
			if(preg_match($key,$index))
			{
				$data[preg_replace($key,'',$index)]=$value;
			}
		}
		
		if($attribute) return(esc_attr(json_encode(BCBSHelper::stripslashes($data),JSON_UNESCAPED_UNICODE)));
		
		return($data);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/