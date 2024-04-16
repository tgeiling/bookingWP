<?php

/******************************************************************************/
/******************************************************************************/

class BCBSPrice
{
	/**************************************************************************/
	
	static function format($value,$currencyIndex)
	{
		$Currency=new BCBSCurrency();
		$currency=$Currency->getCurrency($currencyIndex);
		
		$value=self::numberFormat($value,$currencyIndex);
		
		if($currency['position']=='left') 
			$value=$currency['symbol'].$value;
		else $value.=$currency['symbol'];
		
		return($value);
	}
	
	/**************************************************************************/
	
	static function formatToSave($value,$empty=false)
	{
		$Validation=new BCBSValidation();
		
		if(($Validation->isEmpty($value)) && ($empty)) return('');
		
		$value=preg_replace('/,/','.',$value);
		$value=number_format($value,2,'.','');
		return($value);
	}
	
	/**************************************************************************/
	
	static function formatToCalc($value)
	{
		$Validation=new BCBSValidation();
		
		if($Validation->isEmpty($value)) $value=0.00;
		
		return(self::formatToSave($value));
	}
	
	/**************************************************************************/
	
	static function numberFormat($value,$currencyIndex=-1)
	{
		$Currency=new BCBSCurrency();
		
		if($currencyIndex==-1)
			$currencyIndex=BCBSCurrency::getFormCurrency();
		
		$currency=$Currency->getCurrency($currencyIndex);
		
		$value=number_format($value,2,$currency['separator'],$currency['separator2']);
		return($value);
	}
	
	/**************************************************************************/
	
	static function calculateGross($value,$taxRateId=0,$taxValue=0)
	{
		if($taxRateId!=0)
		{
			$TaxRate=new BCBSTaxRate();
			$dictionary=$TaxRate->getDictionary();
			$taxValue=$dictionary[$taxRateId]['meta']['tax_rate_value'];
		}
		
		$value*=(1+($taxValue/100));
		
		return($value);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/