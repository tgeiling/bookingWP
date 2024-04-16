<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBookingFormStyle
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->color=array
		(
			1=>array
			(
				'color'=>'E57058'
			),
			2=>array
			(
				'color'=>'FFFFFF'
			),
			3=>array
			(
				'color'=>'778591'
			),
			4=>array
			(
				'color'=>'EAECEE'
			),
			5=>array
			(
				'color'=>'2C3E50'
			),
			6=>array
			(
				'color'=>'CED3D9'
			),
			7=>array
			(
				'color'=>'556677'
			),
			8=>array
			(
				'color'=>'254D78'
			),
			9=>array
			(
				'color'=>'9DACBF'
			),
			10=>array
			(
				'color'=>'EFF6FA'
			),
			11=>array
			(
				'color'=>'C2D6E2'
			),
			12=>array
			(
				'color'=>'A3ADB9'
			),
			13=>array
			(
				'color'=>'E6EFF5'
			),
		);
	}
	
	/**************************************************************************/
	
	function isColor($color)
	{
		return(array_key_exists($color,$this->getColor()));
	}
	
	/**************************************************************************/
	
	function getColor()
	{
		return($this->color);
	}
	
	/**************************************************************************/
	
	function createCSSFile()
	{
		$path=array
		(
			BCBSFile::getMultisiteBlog()
		);
		
		foreach($path as $pathData)
		{
			if(!BCBSFile::dirExist($pathData)) @mkdir($pathData);			
			if(!BCBSFile::dirExist($pathData)) return(false);
		}
				
		/***/
		
		$content=null;
		
		$Validation=new BCBSValidation();
		$BookingForm=new BCBSBookingForm();
		
		$dictionary=$BookingForm->getDictionary();
		
		foreach($dictionary as $dictionaryIndex=>$dictionaryValue)
		{
			$meta=$dictionaryValue['meta'];

			foreach($this->getColor() as $colorIndex=>$colorValue)
			{
				if((!isset($meta['style_color'][$colorIndex])) || (!$Validation->isColor($meta['style_color'][$colorIndex]))) 
					$meta['style_color'][$colorIndex]=$colorValue['color'];
			}
			
			$data=array();
		
			$data['color']=$meta['style_color'];
			$data['main_css_class']='.bcbs-booking-form-id-'.$dictionaryIndex;

			$Template=new BCBSTemplate($data,PLUGIN_BCBS_TEMPLATE_PATH.'public/style.php');
		
			$content.=$Template->output();
		}
		
		if($Validation->isNotEmpty($content))
			file_put_contents(BCBSFile::getMultisiteBlogCSS(),$content); 
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/