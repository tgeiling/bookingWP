<?php

/******************************************************************************/
/******************************************************************************/

class BCBSHelper
{
	/**************************************************************************/
	
	static function setDefault(&$data,$index,$value)
	{	
		if(array_key_exists($index,(array)$data)) return;
		$data[$index]=$value;		
	}
	
	/**************************************************************************/
	
	static function createNonceField($name)
	{
		return(wp_nonce_field('savePost',$name.'_noncename',false,false));
	}
	
	/**************************************************************************/
	
	static function createId($prefix=null)
	{
		return((is_null($prefix) ? null : $prefix.'_').strtoupper(md5(microtime().rand())));
	}
	
	/**************************************************************************/
	
	static function createHash($value)
	{
		return(strtoupper(md5($value)));
	}
	
	/**************************************************************************/
	
	static function createRandomString()
	{
		return(strtoupper(md5(uniqid(mt_rand(),true))));
	}
	
	/**************************************************************************/
	
	static function getPostOption($prefix=null)
	{
		if(!is_null($prefix)) $prefix='_'.$prefix.'_';
		
		$option=array();
		$result=array();
		
		$data=filter_input_array(INPUT_POST);
		if(!is_array($data)) $data=array();
		
		foreach($data as $key=>$value)
		{
			if(preg_match('/^'.PLUGIN_BCBS_OPTION_PREFIX.$prefix.'/',$key,$result)) 
			{
				$index=preg_replace('/^'.PLUGIN_BCBS_OPTION_PREFIX.'_/','',$key);
				$option[$index]=$value;
			}
		}	
		
		$option=BCBSHelper::stripslashes($option);
		
		return($option);
	}

	/**************************************************************************/
	
	static function stripslashes($value)
	{
		if((function_exists('get_magic_quotes_gpc')) && (@get_magic_quotes_gpc()))
			return(stripslashes_deep($value));
		else return($value);
	}

	/**************************************************************************/
	
	static function getFormName($name,$display=true)
	{
		if(!$display) return(PLUGIN_BCBS_OPTION_PREFIX.'_'.$name);
		echo PLUGIN_BCBS_OPTION_PREFIX.'_'.$name;
	}
	
	/**************************************************************************/
	
	static function displayIf($value,$testValue,$text,$display=true)
	{
		if(is_array($value))
		{
			foreach($value as $v)
			{
				if(strcmp($v,$testValue)==0) 
				{
					if($display) echo esc_html($text);
					else return($text);
					return;
				}	
			}
		}
		else 
		{
			if(strcmp($value,$testValue)==0) 
			{
				if($display) echo esc_html($text);
				else return($text);
			}
		}
	}
	
	/**************************************************************************/
	
	static function disabledIf($value,$testValue,$display=true)
	{
		return(self::displayIf($value,$testValue,' disabled ',$display));
	}
	
	/**************************************************************************/

	static function checkedIf($value,$testValue=1,$display=true)
	{
		return(self::displayIf($value,$testValue,' checked ',$display));
	}
	
	/**************************************************************************/
	
	static function selectedIf($value,$testValue=1,$display=true)
	{
		return(self::displayIf($value,$testValue,' selected ',$display));
	}
		
	/**************************************************************************/
	
	static function removeUIndex(&$data)
	{
		$argument=array_slice(func_get_args(),1);
		
		$data=(array)$data;
		
		foreach($argument as $index)
		{
			if(!is_array($index))
			{
				if(!array_key_exists($index,$data))
					$data[$index]='';
			}
			else
			{
				if(!array_key_exists($index[0],$data))
					$data[$index[0]]=$index[1];				
			}
		}
	}
	
	/**************************************************************************/
	
	static function addProtocolName($value,$protocol='http://')
	{
		if(!preg_match('/^'.preg_quote($protocol,'/').'/',$value)) return($protocol.$value);
		return($value);
	}
 
	/**************************************************************************/
	
	static function createLink($value)
	{
		return(preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>',$value));
	}
 
	/**************************************************************************/
	
	static function createMailToLink($value)
	{
		return(preg_replace('/([A-z0-9\._-]+\@[A-z0-9_-]+\.)([A-z0-9\_\-\.]{1,}[A-z])/','<a href="mailto:$1$2">$1$2</a>',$value));
	}

	/**************************************************************************/
	
	static function getPostValue($name,$prefix=true)
	{
		if($prefix) $name=PLUGIN_BCBS_CONTEXT.'_'.$name;
		
		if(!array_key_exists($name,$_POST)) return(null);
		
		return($_POST[$name]);
	}
	
	/**************************************************************************/
	
	static function getGetValue($name,$prefix=true)
	{
		if($prefix) $name=PLUGIN_BCBS_CONTEXT.'_'.$name;
		
		if(!array_key_exists($name,$_GET)) return(null);
		
		return($_GET[$name]);
	}
	
	/**************************************************************************/
	
	static function getEmailFromString($value)
	{
		foreach(preg_split('/\s/', $value) as $token)
		{
			$email=filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
			if($email!==false) return($email);
		}
	
		return(null);
	}
	
	/**************************************************************************/
	
	static function sessionStart()
	{
		if(version_compare(PHP_VERSION,'5.4.0','<'))
		{
			if(session_id()=='') session_start();
		}
		else
		{
			if(session_status()==PHP_SESSION_NONE) session_start();
		}
	}
	
	/**************************************************************************/
	
	static function checkSavePost($post_id,$name,$action=null)
	{
		if((defined('DOING_AUTOSAVE')) && (DOING_AUTOSAVE)) return(false);

		if(!array_key_exists($name,$_POST)) return(false);

		if(!wp_verify_nonce($_POST[$name],$action)) return(false);

		unset($_POST[$name]);
		
		if(!current_user_can('edit_post',$post_id)) return(false);
		
		return(true);
	}
	
	/**************************************************************************/
	
	static function isEditMode()
	{
		global $pagenow;
		return(!($pagenow=='post-new.php'));
	}
	
	/**************************************************************************/
	
	static function createCSSClassAttribute($class)
	{
		$Validation=new BCBSValidation();
		
		if(!is_array($class)) $class=func_get_args();
		
		$class=esc_attr(join(' ',$class));
		
		if($Validation->isNotEmpty($class)) return(' class="'.$class.'"');
		
		return(null);
	}
	
	/**************************************************************************/
	
	static function createStyleAttribute($style)
	{
		$ret=null;
		$Validation=new BCBSValidation();
		
		if(!is_array($style)) return($ret);
		
		foreach($style as $index=>$value)
		{
			if($Validation->isEmpty($value)) continue;
			$ret.=$index.':'.$value.';';
		}
		
		return($Validation->isEmpty($ret) ? null : ' style="'.esc_attr($ret).'"');
	}
	
	/**************************************************************************/
	
	static function preservePost(&$post,&$bPost,$action=1)
	{
		if(!is_object($post)) return;
		
		if($action==1) $bPost=$post;
		else 
		{
			if(!is_object($bPost)) return;
			
			$post=$bPost;
			setup_postdata($post); 
		}
	}
	
	/**************************************************************************/
	
	static function valueInRange($value,$start,$stop)
	{
		return(($start<=$value) && ($value<=$stop) ? true : false);
	}
	
	/**************************************************************************/
	
	static function displayAddress($data,$separator='<br>')
	{
		$Country=new BCBSCountry();
		$Validation=new BCBSValidation();
		
		$html=null;
		if(array_key_exists('name',$data))
			$html=$data['name'];
		
		if($Validation->isNotEmpty($data['street']))
		{
			if($Validation->isNotEmpty($html)) $html.=$separator;
			$html.=trim($data['street'].' '.$data['street_number']);
		}
		
		if($Validation->isNotEmpty($data['postcode']) || $Validation->isNotEmpty($data['city']))
		{
			if($Validation->isNotEmpty($html)) $html.=$separator;
			$html.=trim($data['postcode'].' '.$data['city']);
		}
		
		if($Validation->isNotEmpty($data['state']))
		{
			if($Validation->isNotEmpty($html)) $html.=$separator;
			$html.=$data['state'];
		}
		
		if($Country->isCountry($data['country']))
		{
			if($Validation->isNotEmpty($html)) $html.=$separator;
			$html.=$Country->getCountryName($data['country']);			
		}
		
		return($html);
	}
	
	/**************************************************************************/
	
	static function createJSONResponse($response)
	{
		echo json_encode($response);
		exit;			  
	}
	
	/**************************************************************************/
	
	static function getTempDir()
	{
		return((ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir()).'/');
	}
	
	/***************************************************************************/
	
	static function createPostIdField($label)
	{
		global $post;
		
		$html=
		'
			<li>
				<h5>'.esc_html($label).'</h5>
				<span class="to-legend">'.esc_html($label).'.</span>
				<div class="to-field-disabled">
					'.esc_html($post->ID).'
					<a href="#" class="to-copy-to-clipboard to-float-right" data-clipboard-text="'.esc_attr($post->ID).'" data-label-on-success="'.esc_attr__('Copied!','boat-charter-booking-system').'">'.esc_html__('Copy','boat-charter-booking-system').'</a>
				</div>
			</li>		
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	static function displayNonce($data)
	{
		return($data['nonce']);
	}
	
	/**************************************************************************/
	
	static function addInlineScript($name,$script,$type=1)
	{
		if((int)$type===1)
		{
			wp_add_inline_script($name,$script);
		}
		else
		{
			echo 
			'
				<script>
					'.$script.'
				</script>
			';
		}
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/