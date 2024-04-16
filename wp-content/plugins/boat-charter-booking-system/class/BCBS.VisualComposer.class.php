<?php

/******************************************************************************/
/******************************************************************************/

class BCBSVisualComposer
{
	/**************************************************************************/
	
	function __construct()
	{		
		
	}
	
	/**************************************************************************/
	
	function init()
	{		
		add_action('vc_before_init',array($this,'beforeInitAction'));
	}
	
	/**************************************************************************/
	
	function beforeInitAction()
	{
		require_once(PLUGIN_BCBS_VC_PATH.'vc_'.PLUGIN_BCBS_CONTEXT.'_booking_form.php');
	}
	
	/**************************************************************************/
	
	function createParamDictionary($data)
	{		
		$dictionary=array();
		
		foreach($data as $index=>$value)
		{
			if(is_array($value))
				$dictionary[$index]=$value['post']->post_title;
		}
		
		return(array_combine(array_values($dictionary),array_keys($dictionary)));
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/