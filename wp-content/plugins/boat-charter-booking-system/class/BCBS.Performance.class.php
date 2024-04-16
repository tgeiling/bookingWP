<?php

/******************************************************************************/
/******************************************************************************/

class BCBSPerformance
{
	/**************************************************************************/
	
	static function start()
	{
		global $bcbs_performance_timer;
		$bcbs_performance_timer=microtime(true); 
	}
	
	/**************************************************************************/
	
	static function stop()
	{
		global $bcbs_performance_timer;
		
		$time=microtime(true)-$bcbs_performance_timer;
		
		echo sprintf(esc_html__('Total time: %s','boat-charter-booking-system'),$time).'<br>';
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/