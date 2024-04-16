<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBillingType
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->billingType=array
		(
			1=>array(esc_html__('Hourly','boat-charter-booking-system')),
			2=>array(esc_html__('Daily','boat-charter-booking-system')),
			3=>array(esc_html__('Daily + hourly','boat-charter-booking-system'))
		);
	}
	
	/**************************************************************************/
	
	function getDictionary()
	{
		return($this->billingType);
	}
	
	/**************************************************************************/
	
	function isBillingType($billingType)
	{
		return(array_key_exists($billingType,$this->billingType));
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/