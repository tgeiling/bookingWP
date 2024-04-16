<?php

/******************************************************************************/
/******************************************************************************/

class BCBSPayment
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->payment=array
		(
			'1'=>array(esc_html__('Cash','boat-charter-booking-system'),'cash'),
			'2'=>array(esc_html__('Stripe','boat-charter-booking-system'),'stripe'),
			'3'=>array(esc_html__('PayPal','boat-charter-booking-system'),'paypal'),
			'4'=>array(esc_html__('Wire transfer','boat-charter-booking-system'),'wire_transfer')
		);
	}
	
	/**************************************************************************/
	
	function getPayment($payment=null)
	{
		if($payment===null) return($this->payment);
		else return($this->payment[$payment]);
	}
	
	/**************************************************************************/
	
	function getPaymentName($payment)
	{
		if($this->isPayment($payment))
			return($this->payment[$payment][0]);
		
		return(null);
	}
	
	/**************************************************************************/
	
	function getPaymentPrefix($payment)
	{
		if($this->isPayment($payment))
			return($this->payment[$payment][1]);
		
		return(null);
	}
	
	/**************************************************************************/
	
	function isPayment($payment)
	{
		return(array_key_exists($payment,$this->payment));
	}
		
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/