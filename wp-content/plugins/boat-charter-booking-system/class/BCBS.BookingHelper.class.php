<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBookingHelper
{
	/**************************************************************************/
	   
	static function calculateRentalPeriod($departureDate,$departureTime,$returnDate,$returnTime,$billingType=-1)
	{
		$period=array('day'=>0,'hour'=>0);
		
		if($billingType===-1)
			$billingType=BCBSOption::getOption('billing_type');
		
		$hour=strtotime($returnDate.' '.$returnTime)-strtotime($departureDate.' '.$departureTime);
		$hour=ceil($hour/60/60);
		
		switch($billingType)
		{
			case 1:
				
				$period['hour']=$hour;
				
			break;
		
			case 2:
				
				$period['day']=ceil($hour/24);
				if($period['day']==0) $period['day']=1;
				
			break;
		
			case 3:
				
				$period['day']=floor($hour/24);
				$period['hour']=$hour-$period['day']*24;
		
			break;
		}
		
		return($period);
	}
	
	/**************************************************************************/
	
	static function getRentalPeriodLabel($period,$billingType=-1)
	{
		$html=null;
		
		if($billingType===-1)
			$billingType=BCBSOption::getOption('billing_type');		
		
		$label=array();
		
		if(array_key_exists('hour',$period))
			$label['hour']=$period['hour']<=1 ? esc_html__('hour','boat-charter-booking-system') : esc_html__('hours','boat-charter-booking-system');
			
		if(array_key_exists('day',$period))
			$label['day']=$period['day']<=1 ? esc_html__('day','boat-charter-booking-system') : esc_html__('days','boat-charter-booking-system');	
		
		switch($billingType)
		{
			case 1:
			   
				$html=sprintf(esc_html__('%s %s','boat-charter-booking-system'),$period['hour'],$label['hour']);
				
			break;
		
			case 2:
				
				$html=sprintf(esc_html__('%s %s','boat-charter-booking-system'),$period['day'],$label['day']);
				
			break;
		
			case 3:
				
				$html=sprintf(esc_html__('%s %s, %s %s','boat-charter-booking-system'),$period['day'],$label['day'],$period['hour'],$label['hour']);
				
			break;
		}	
		
		return($html);
	}
	
	/**************************************************************************/
	
	static function getPaymentImage($paymentId,$bookingForm)
	{
		$Payment=new BCBSPayment();
		$Validation=new BCBSValidation();
		$WooCommerce=new BCBSWooCommerce();
		
		$marinaDepartureId=$bookingForm['marina_departure_id'];
		
		if(!array_key_exists($marinaDepartureId,$bookingForm['dictionary']['marina'])) return(null);
		
		$marinaDeparture=$bookingForm['dictionary']['marina'][$marinaDepartureId];
		
		if(!self::isPayment($paymentId,$bookingForm['meta'],$marinaDeparture)) return(null);
		
		$wooCommerceEnable=$WooCommerce->isEnable($bookingForm['meta']);
		
		if($wooCommerceEnable)
		{
		   $paymentImage=$WooCommerce->getPaymentImage($paymentId);
		}
		else
		{
			$prefix=$Payment->getPaymentPrefix($paymentId);
			
			$paymentImage=$bookingForm['dictionary']['marina'][$marinaDepartureId]['meta']['payment_'.$prefix.'_logo_src'];
			
			if($Validation->isEmpty($paymentImage)) $paymentImage=null;
		}

		return($paymentImage);	
	}
	
	/**************************************************************************/
	
	static function getPaymentName($paymentId,$bookingFormMeta=array(),$wooCommerceEnable=-1)
	{
		$Payment=new BCBSPayment();
		$WooCommerce=new BCBSWooCommerce();
		
		if($wooCommerceEnable===-1)
			$wooCommerceEnable=$WooCommerce->isEnable($bookingFormMeta);
		
		if($wooCommerceEnable)
		{
		   $paymentName=$WooCommerce->getPaymentName($paymentId);
		}
		else
		{
			$paymentName=$Payment->getPaymentName($paymentId);
		}
		
		return($paymentName);
	}
	
	/**************************************************************************/
	
	static function isPayment(&$paymentId,$bookingFormMeta,$marinaMeta)
	{
		$Payment=new BCBSPayment();
		$WooCommerce=new BCBSWooCommerce();
		
		if(($WooCommerce->isEnable($bookingFormMeta)) && ((int)$bookingFormMeta['payment_woocommerce_step_3_enable']===0))
		{
			return(true);
		}
		
		if((int)$marinaMeta['payment_mandatory_enable']===0)
		{
			if($WooCommerce->isEnable($bookingFormMeta))
			{
				if(empty($paymentId))
				{
					$paymentId=0;
					return(true);
				}
			}
			else
			{
				if($paymentId==0)
				{
					return(true);
				}
			}
		}
		
		if($WooCommerce->isEnable($bookingFormMeta))
		{
			return($WooCommerce->isPayment($paymentId));
		}
		else
		{
			if(!$Payment->isPayment($paymentId)) return(false);
		}
		
		return(true);
	}
	
	/**************************************************************************/
	
	static function formatDateTimeToStandard($data)
	{
		$Date=new BCBSDate();
		
		BCBSHelper::removeUIndex($data,'departure_date','departure_time','return_date','return_time');
		
		$data['departure_date']=$Date->formatDateToStandard($data['departure_date']);
		$data['departure_time']=$Date->formatTimeToStandard($data['departure_time']);

		$data['return_date']=$Date->formatDateToStandard($data['return_date']);
		$data['return_time']=$Date->formatTimeToStandard($data['return_time']);
		
		return($data);
	}
	
	/**************************************************************************/
	
	static function createListIcon($attribute,$content)
	{
		$html='<ul class="bcbs-list-icon">'.do_shortcode($content).'</ul>';
		return($html);
	}
	
	/**************************************************************************/
	
	static function createListIconItem($attribute,$content)
	{
		$html='<li>'.do_shortcode($content).'</li>';
		return($html);
	}
	
	/**************************************************************************/
}
/******************************************************************************/
/******************************************************************************/