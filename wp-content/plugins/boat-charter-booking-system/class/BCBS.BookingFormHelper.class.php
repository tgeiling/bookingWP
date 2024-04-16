<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBookingFormHelper
{
	/**************************************************************************/
	
	function __construct()
	{

	}
	
	/**************************************************************************/
	
	static function getBookingFormDateTime($bookingForm,$data,$marinaType='departure',$timeDefault='23:59')
	{
		$date=null;
		
		if((int)$bookingForm['meta']['marina_departure_return_time_field_enable']===0)
			$date=$data[$marinaType.'_date'].' '.$timeDefault;
		else $date=$data[$marinaType.'_date'].' '.$data[$marinaType.'_time'];
		
		return($date);
	}
	
	/**************************************************************************/
	
	static function isPaymentDepositEnable($bookingForm,$bookingId=-1)
	{
		$WooCommerce=new BCBSWooCommerce();
		
		if($WooCommerce->isEnable($bookingForm['meta'])) return(false);

		$marinaDepartureId=$bookingForm['marina_departure_id'];
		
		$marinaDepartureMeta=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta'];
		
		$depositType=(int)$marinaDepartureMeta['payment_deposit_type'];
				
		if(in_array($depositType,array(1,2)))
		{
			if($marinaDepartureMeta['payment_deposit_day_number_before_departure_date']>0)
			{
				$data=BCBSHelper::getPostOption();
				$data=BCBSBookingHelper::formatDateTimeToStandard($data);
			
				$interval=(strtotime($data['departure_date'])-strtotime(date_i18n('d-m-Y')))/60/60/24;
			
				if(floor($interval)==$interval) $interval--;
				$interval=floor($interval)+1;
			
				if($interval<$marinaDepartureMeta['payment_deposit_day_number_before_departure_date']) return(0);
			}
		}
		
		if(($depositType===1) && ($marinaDepartureMeta['payment_deposit_type_fixed_value']>0)) return($depositType);
		if(($depositType===2) && ($marinaDepartureMeta['payment_deposit_type_percentage_value']>0)) return($depositType);
		
		return(0);
	}
	
	/**************************************************************************/
	
	static function isAllMarinaSelected($bookingForm,$type)
	{
		$data=BCBSHelper::getPostOption();
		$data=BCBSBookingHelper::formatDateTimeToStandard($data);

		if((in_array(2,$bookingForm['meta']['marina_selection_mandatory'])) && ($type=='departure'))
		{
			if(((int)$data['marina_departure_id']===-1) || ((int)$bookingForm['meta']['marina_departure_list_status']===2)) return(true);
		}
		
		if((in_array(3,$bookingForm['meta']['marina_selection_mandatory'])) && ($type=='return'))
		{
			if(((int)$data['marina_return_id']===-1) || (in_array((int)$bookingForm['meta']['marina_return_list_status'],array(2,3))))  return(true);
		}		
		
		return(false);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/