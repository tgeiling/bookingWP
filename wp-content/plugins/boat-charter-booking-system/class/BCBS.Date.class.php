<?php

/******************************************************************************/
/******************************************************************************/

class BCBSDate
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->day=array();
		
		for($i=1;$i<8;$i++)
		{
			$this->day[$i]=array(date_i18n('l',strtotime('0'.$i.'-04-2013')));
		}
	}
	
	/**************************************************************************/
	
	function getDayName($number)
	{
		return($this->day[$number][0]);
	}
	
	/**************************************************************************/
	
	function compareTime($time1,$time2)
	{
		$time1=array_map('intval',preg_split('/:/',$time1));
		$time2=array_map('intval',preg_split('/:/',$time2));

		if($time1[0]>$time2[0]) return(1);

		if($time1[0]==$time2[0])
		{
			if($time1[1]>$time2[1]) return(1);
			if($time1[1]==$time2[1]) return(0);
		}
		
		return(2);
	}
	
	/**************************************************************************/
	
	function compareDate($date1,$date2)
	{
		$date1=strtotime($date1);
		$date2=strtotime($date2);
		
		if($date1-$date2==0) return(0);
		if($date1-$date2>0) return(1);
		if($date1-$date2<0) return(2);
	}
	
	/**************************************************************************/
	
	function reverseDate($date)
	{
		$date=preg_split('/-/',$date);
		return($date[2].'-'.$date[1].'-'.$date[0]);
	}
	
	/**************************************************************************/
	
	function dateInRange($date1,$date2,$date3)
	{
	   return((in_array($this->compareDate($date1,$date2),array(0,1))) && (in_array($this->compareDate($date1,$date3),array(0,2))));
	}
	
	/**************************************************************************/
	
	function timeInRange($time1,$time2,$time3)
	{
	   return((in_array($this->compareTime($time1,$time2),array(0,1))) && (in_array($this->compareTime($time1,$time3),array(0,2))));
	}
  
	/**************************************************************************/

	function getDayNumberOfWeek($date)
	{
		return(date_i18n('N',strtotime($date)));
	}
	
	/**************************************************************************/
	
	function formatTime($time)
	{
		return(number_format($time,2,':',''));
	}
	
	/**************************************************************************/
	
	function formatMinuteToTime($minute)
	{
		$hour=floor($minute/60);
		$minute=($minute%60);
		
		if(strlen($hour)==1) $hour='0'.$hour;
		if(strlen($minute)==1) $minute='0'.$minute;
		
		return($hour.':'.$minute);
	}
	
	/**************************************************************************/
	
	function formatDateToStandard($date)
	{
		$Validation=new BCBSValidation();
		if($Validation->isEmpty($date)) return('');
		
		return(date_format(date_create_from_format(BCBSOption::getOption('date_format'),$date),'d-m-Y'));
	}
	
	/**************************************************************************/
	
	function formatDateToDisplay($date,$sourceFormat='d-m-Y')
	{
		$Validation=new BCBSValidation();
		if($Validation->isEmpty($date)) return('');
		
		return(date_format(date_create_from_format($sourceFormat,$date),BCBSOption::getOption('date_format')));
	}
	
	/**************************************************************************/
	
	function formatTimeToStandard($time)
	{
		$Validation=new BCBSValidation();
		if($Validation->isEmpty($time)) return('');
		if($Validation->isTime($time)) return($time);
		
		return(date_format(date_create_from_format(BCBSOption::getOption('time_format'),$time),'H:i'));
	}
	
	/**************************************************************************/
	
	function formatTimeToDisplay($time,$sourceFormat='H:i')
	{
		$Validation=new BCBSValidation();
		if($Validation->isEmpty($time)) return('');
		
		return(date_format(date_create_from_format($sourceFormat,$time),BCBSOption::getOption('time_format')));
	}
	
	/**************************************************************************/
	
	static function getNow()
	{
		return(strtotime(date_i18n('d-m-Y H:i')));
	}
	
	/**************************************************************************/
	
	static function strtotime($time)
	{
		return(strtotime($time,self::getNow()));
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/