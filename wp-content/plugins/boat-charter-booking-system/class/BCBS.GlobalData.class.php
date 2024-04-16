<?php

/******************************************************************************/
/******************************************************************************/

class BCBSGlobalData
{
	/**************************************************************************/
	
	static function setGlobalData($name,$functionCallback,$refresh=false)
	{
		global $bcbsGlobalData;
		
		if(isset($bcbsGlobalData[$name]) && (!$refresh)) return($bcbsGlobalData[$name]);
		
		$bcbsGlobalData[$name]=call_user_func($functionCallback);
		
		return($bcbsGlobalData[$name]);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/