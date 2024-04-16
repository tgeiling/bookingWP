<?php

/******************************************************************************/
/******************************************************************************/

class BCBSOption
{
	/**************************************************************************/
	
	static function createOption($refresh=false)
	{
		return(BCBSGlobalData::setGlobalData(PLUGIN_BCBS_CONTEXT,array('BCBSOption','createOptionObject'),$refresh));				
	}
		
	/**************************************************************************/
	
	static function createOptionObject()
	{	
		return((array)get_option(PLUGIN_BCBS_OPTION_PREFIX.'_option'));
	}
	
	/**************************************************************************/
	
	static function refreshOption()
	{
		return(self::createOption(true));
	}
	
	/**************************************************************************/
	
	static function getOption($name)
	{
		global $bcbsGlobalData;

		self::createOption();

		if(!array_key_exists($name,$bcbsGlobalData[PLUGIN_BCBS_CONTEXT])) return(null);
		return($bcbsGlobalData[PLUGIN_BCBS_CONTEXT][$name]);		
	}

	/**************************************************************************/
	
	static function getOptionObject()
	{
		global $bcbsGlobalData;
		return($bcbsGlobalData[PLUGIN_BCBS_CONTEXT]);
	}
	
	/**************************************************************************/
	
	static function updateOption($option)
	{
		$nOption=array();
		foreach($option as $index=>$value) $nOption[$index]=$value;
		
		$oOption=self::refreshOption();

		update_option(PLUGIN_BCBS_OPTION_PREFIX.'_option',array_merge($oOption,$nOption));
		
		self::refreshOption();
	}
	
	/**************************************************************************/
	
	static function resetOption()
	{
		update_option(PLUGIN_BCBS_OPTION_PREFIX.'_option',array());
		self::refreshOption();		
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/