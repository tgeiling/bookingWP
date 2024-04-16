<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBookingFormElement
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->fieldType=array
		(
			1=>array(esc_html__('Text','boat-charter-booking-system')),
			3=>array(esc_html__('File','boat-charter-booking-system')),
			2=>array(esc_html__('Select list','boat-charter-booking-system')),
		);
	}
	
	/**************************************************************************/
	
	function getFieldType()
	{
		return($this->fieldType);
	}
	
	/**************************************************************************/
	
	function isFieldType($fieldType)
	{
		return(array_key_exists($fieldType,$this->getFieldType()) ? true : false);
	}
	
	/**************************************************************************/
	   
	function save($bookingFormId)
	{
		/***/
		
		$formElementPanel=array();
		$formElementPanelPost=BCBSHelper::getPostValue('form_element_panel');
		
		if(isset($formElementPanelPost['id']))
		{
			$Validation=new BCBSValidation();
			
			foreach($formElementPanelPost['id'] as $index=>$value)
			{
				if($Validation->isEmpty($formElementPanelPost['label'][$index])) continue;
				
				if($Validation->isEmpty($value))
					$value=BCBSHelper::createId();
				
				$formElementPanel[]=array('id'=>$value,'label'=>$formElementPanelPost['label'][$index]);
			}
		}
		
		BCBSPostMeta::updatePostMeta($bookingFormId,'form_element_panel',$formElementPanel); 
		
		$meta=BCBSPostMeta::getPostMeta($bookingFormId);
		
		/***/
		
		$formElementField=array();
		$formElementFieldPost=BCBSHelper::getPostValue('form_element_field');		
		
		if(isset($formElementFieldPost['id']))
		{
			$Validation=new BCBSValidation();
			
			$panelDictionary=$this->getPanel($meta);
			
			foreach($formElementFieldPost['id'] as $index=>$value)
			{
				if(!isset($formElementFieldPost['label'][$index],$formElementFieldPost['field_type'][$index],$formElementFieldPost['mandatory'][$index],$formElementFieldPost['dictionary'][$index],$formElementFieldPost['message_error'][$index],$formElementFieldPost['panel_id'][$index])) continue;
				
				if($Validation->isEmpty($formElementFieldPost['label'][$index])) continue;
				
				if(!$this->isFieldType($formElementFieldPost['field_type'][$index])) continue;
				
				if($formElementFieldPost['field_type'][$index]===2)
				{
					if($Validation->isEmpty($formElementFieldPost['dictionary'][$index])) continue;
				}
				
				if(!$Validation->isBool((int)$formElementFieldPost['mandatory'][$index])) continue;
				else 
				{
					if($formElementFieldPost['mandatory'][$index]==1)
					{	
						if($Validation->isEmpty($formElementFieldPost['message_error'][$index])) continue;
					}
				}
				
				if(!$this->isPanel($formElementFieldPost['panel_id'][$index],$panelDictionary)) continue;
				
				if($Validation->isEmpty($value))
					$value=BCBSHelper::createId();
				
				$formElementField[]=array('id'=>$value,'label'=>$formElementFieldPost['label'][$index],'field_type'=>$formElementFieldPost['field_type'][$index],'mandatory'=>$formElementFieldPost['mandatory'][$index],'dictionary'=>$formElementFieldPost['dictionary'][$index],'message_error'=>$formElementFieldPost['message_error'][$index],'panel_id'=>$formElementFieldPost['panel_id'][$index]);
			}
		}  
		
		BCBSPostMeta::updatePostMeta($bookingFormId,'form_element_field',$formElementField); 
		
		/***/
		
		$formElementAgreement=array();
		$formElementAgreementPost=BCBSHelper::getPostValue('form_element_agreement');		
		
		if(isset($formElementAgreementPost['id']))
		{
			$Validation=new BCBSValidation();
			
			foreach($formElementAgreementPost['id'] as $index=>$value)
			{
				if(!isset($formElementAgreementPost['text'][$index])) continue;
				if($Validation->isEmpty($formElementAgreementPost['text'][$index])) continue;
				
				if($Validation->isEmpty($value))
					$value=BCBSHelper::createId();
				
				$formElementAgreement[]=array('id'=>$value,'text'=>$formElementAgreementPost['text'][$index]);
			}
		}		
		
		BCBSPostMeta::updatePostMeta($bookingFormId,'form_element_agreement',$formElementAgreement);		
	}
	
	/**************************************************************************/
	
	function getPanel($meta)
	{
		$panel=array
		(
			array
			(
				'id'=>1,
				'label'=>esc_html__('- Contact details -','boat-charter-booking-system')
			),
			array
			(
				'id'=>2,
				'label'=>esc_html__('- Billing address -','boat-charter-booking-system')
			)
		);
			 
		if(isset($meta['form_element_panel']))
		{
			foreach($meta['form_element_panel'] as $value)
				$panel[]=$value;
		}
		
		return($panel);
	}

	/**************************************************************************/
	
	function isPanel($panelId,$panelDictionary)
	{
		foreach($panelDictionary as $value)
		{
			if($value['id']==$panelId) return(true);
		}
		
		return(false);
	}
	
	/**************************************************************************/
	
	function createField($panelId,$meta)
	{
		$html=array(null,null);
		
		$Validation=new BCBSValidation();
		
		if(!array_key_exists('form_element_field',$meta)) return(null);
		
		foreach($meta['form_element_field'] as $value)
		{
			if($value['panel_id']==$panelId)
			{
				$name='form_element_field_'.$value['id'];
				
				if(in_array($value['field_type'],array(1,2)))
				{
					$html[1].=
					'
						<div class="bcbs-clear-fix">
							<div class="bcbs-form-field bcbs-form-field-width-100">
								<label>'.esc_html($value['label']).((int)$value['mandatory']===1 ? ' *' : '').'</label>
					';
				
					if((int)$value['field_type']===2)
					{
						$fieldHtml=null;
						$fieldValue=preg_split('/;/',$value['dictionary']);

						foreach($fieldValue as $fieldValueValue)
						{
							if($Validation->isNotEmpty($fieldValueValue))
								$fieldHtml.='<option value="'.esc_attr($fieldValueValue).'"'.BCBSHelper::selectedIf($fieldValueValue,BCBSHelper::getPostValue($name),false).'>'.esc_html($fieldValueValue).'</option>';
						}

						$html[1].=
						'
							<select name="'.BCBSHelper::getFormName($name,false).'">
								'.$fieldHtml.'
							</select>
						';	
					}
					elseif((int)$value['field_type']===1)
					{
						$html[1].=
						'
							<input type="text" name="'.BCBSHelper::getFormName($name,false).'"  value="'.esc_attr(BCBSHelper::getPostValue($name)).'"/>	
						';
					}

					$html[1].=
					'							
							</div>						
						</div>
					';
				}
				elseif((int)$value['field_type']===3)
				{
					$classButton=array(array('bcbs-file-upload','bcbs-button','bcbs-button-style-4'),array('bcbs-file-remove'));
			
					$fileName=null;
			
					if($Validation->isEmpty(BCBSHelper::getPostValue($name.'_name')))
						array_push($classButton[1],'bcbs-hidden');
					else 
					{
						$fileName=BCBSHelper::getPostValue($name.'_name');
						array_push($classButton[0],'bcbs-hidden');
					}
					
					$html[1].=
					'
						<div class="bcbs-form-field">
							<label>'.esc_html($value['label']).((int)$value['mandatory']===1 ? ' *' : '').'</label>
							<div'.BCBSHelper::createCSSClassAttribute($classButton[0]).'>
								<span>'.esc_html__('Upload a file','boat-charter-booking-system').'</span>
								<input type="file" name="'.BCBSHelper::getFormName($name,false).'"></input>
							</div>
							<div'.BCBSHelper::createCSSClassAttribute($classButton[1]).'>
								<span>'.esc_html__('Uploaded file:','boat-charter-booking-system').'<span>'.esc_html($fileName).'</span></span>
								<span'.BCBSHelper::createCSSClassAttribute(array('bcbs-button','bcbs-button-style-4')).'>'.esc_html__('Remove file','boat-charter-booking-system').'</span>
							</div>
							<input type="hidden" name="'.BCBSHelper::getFormName($name,false).'_type" value="'.esc_attr(BCBSHelper::getPostValue($name.'_type')).'"/>
							<input type="hidden" name="'.BCBSHelper::getFormName($name,false).'_name" value="'.esc_attr(BCBSHelper::getPostValue($name.'_name')).'"/>
							<input type="hidden" name="'.BCBSHelper::getFormName($name,false).'_tmp_name" value="'.esc_attr(BCBSHelper::getPostValue($name.'_tmp_name')).'"/>							
						</div>	
					';
				}
			}
		}
		
		if(array_key_exists('form_element_panel',$meta))
		{
			if(!in_array($panelId,array(1,2)))
			{
				foreach($meta['form_element_panel'] as $value)
				{
					if($value['id']==$panelId)
					{
						$html[0].=
						'
							<label class="bcbs-form-panel-label">'.esc_html($value['label']).'</label> 
						';
					}
				}
			}
		}
		
		if($Validation->isNotEmpty($html[0]))
		{
			$html=
			'
				<div class="bcbs-form-panel">
					'.$html[0].'
					<div class="bcbs-form-panel-content bcbs-clear-fix">
						'.$html[1].'
					</div>
				</div>
			';
		}
		else $html=$html[1];
		
		return($html);
	}
	
	/**************************************************************************/
	
	function createAgreement($meta)
	{
		$html=null;
		$Validation=new BCBSValidation();
		
		if(!array_key_exists('form_element_agreement',$meta)) return($html);
		
		foreach($meta['form_element_agreement'] as $value)
		{
			$html.=
			'
				<li>
					<span class="bcbs-form-checkbox">
						<span class="bcbs-meta-icon-24-tick"></span>
					</span>
					<span>'.$value['text'].'</span>
					<input type="hidden" name="'.BCBSHelper::getFormName('form_element_agreement_'.$value['id'],false).'" value="0"/> 
				</li>	  
			';
		}
		
		if($Validation->isNotEmpty($html))
		{
			$html=
			'
				<div id="bcbs-agreement">
					<h3>'.esc_html__('Agreements','boat-charter-booking-system').'</h3>
					<ul class="bcbs-list-reset">
						'.$html.'
					</ul>
				</div>
			';
		}
		
		return($html);
	}
	
	/**************************************************************************/
	
	static function createAgreementS($meta)
	{
		$BookingFormElement=new BCBSBookingFormElement();
		return($BookingFormElement->createAgreement($meta));
	}
	
	/**************************************************************************/
	
	function validateField($meta,$data)
	{
		$error=array();
		
		$Validation=new BCBSValidation();
		
		if(!array_key_exists('form_element_field',$meta)) return($error);
		
		foreach($meta['form_element_field'] as $value)
		{
			$name='form_element_field_'.$value['id'];
			
			if((int)$value['mandatory']===1)
			{
				$name1=$name2=$name;
				
				if((int)$value['field_type']===3) $name2=$name1.='_tmp_name';
				
				if(array_key_exists($name1,$data))
				{
					if($value['panel_id']==2)
					{
						if((int)$data['client_billing_detail_enable']===1)
						{
							if($Validation->isEmpty($data[$name1]))
								$error[]=array('name'=>BCBSHelper::getFormName($name2,false),'message_error'=>$value['message_error']);							
						}
					}
					else
					{
						if($Validation->isEmpty($data[$name1]))
							$error[]=array('name'=>BCBSHelper::getFormName($name2,false),'message_error'=>$value['message_error']);
					}
				}
			}
		}
		
		return($error);
	}
	
	/**************************************************************************/
	
	function validateAgreement($meta,$data)
	{
		if(!array_key_exists('form_element_agreement',$meta)) return(false);
		
		foreach($meta['form_element_agreement'] as $value)
		{
			$name='form_element_agreement_'.$value['id'];  
			
			if((!array_key_exists($name,$data)) || ((int)$data[$name]!==1))
				return(true);
		}
		
		return(false);
	}
	
	/**************************************************************************/
	
	function sendBookingField($bookingId,$meta,$data)
	{
		if(!array_key_exists('form_element_field',$meta)) return;
		
		foreach($meta['form_element_field'] as $index=>$value)
		{
			$name='form_element_field_'.$value['id']; 
			$meta['form_element_field'][$index]['value']=$data[$name];
			
			if(array_key_exists($name.'_tmp_name',$data))
			{
				$file1=BCBSFile::getUploadPath().'/'.$data[$name.'_tmp_name'];
				$file2=BCBSFile::getUploadPath().'/'.$data[$name.'_name'];
			
				if(rename($file1,$file2))
				{
					$upload=wp_upload_bits($data[$name.'_name'],null,file_get_contents($file2));

					if($upload['error']===false)
					{
						$attachment=array
						(
							'post_title'=>$data[$name.'_name'],
							'post_mime_type'=>$data[$name.'_type'],
							'post_content'=>'',
							'post_status'=>'inherit'
						);

						$attachmentId=wp_insert_attachment($attachment,$upload['file'],$bookingId);

						if($attachmentId>0)
						{
							$attachmentData=wp_generate_attachment_metadata($attachmentId,$upload['file']);
							wp_update_attachment_metadata($attachmentId,$attachmentData);
							
							$meta['form_element_field'][$index]['attachment_id']=$attachmentId;
						}
					}
				}
			
				@unlink($file1);
				@unlink($file2);
			}
		}
		
		BCBSPostMeta::updatePostMeta($bookingId,'form_element_panel',$meta['form_element_panel']);
		BCBSPostMeta::updatePostMeta($bookingId,'form_element_field',$meta['form_element_field']);
	}
	
	/**************************************************************************/
	
	function displayField($panelId,$meta,$type=1,$argument=array())
	{
		$html=null;
		
		if(!array_key_exists('form_element_field',$meta)) return($html);
		
		foreach($meta['form_element_field'] as $value)
		{
			if($value['panel_id']==$panelId)
			{
				$fieldValue=esc_html($value['value']);
				$fieldLabel=esc_html($value['label']);
				
				if((int)$value['field_type']===3)
				{
					if((int)$value['attachment_id']>0)
					{
						if(!is_null($file=get_post($value['attachment_id'])))
						{
							if($type===1)
								$fieldValue='<a href="'.esc_url(get_edit_post_link($value['attachment_id'])).'" target="_blank">'.esc_html($file->post_title).'</a>';
							else $fieldValue=esc_html($file->post_title);
						}
						else continue;
					}
					else continue;
				}
				
				if($type==1)
				{
					$html.=
					'
						<div>
							<span class="to-legend-field">'.$fieldLabel.': </span>
							<div class="to-field-disabled">'.$fieldValue.'</div>								
						</div>	
					';
				}
				elseif($type==2)
				{
					$html.=
					'
						<tr>
							<td '.$argument['style']['cell'][1].'>'.$fieldLabel.'</td>
							<td '.$argument['style']['cell'][2].'>'.$fieldValue.'</td>
						</tr>
					';					
				}
			}
		}
		
		return($html);
	}
	
	/**************************************************************************/
	
	static function displayFieldS($panelId,$meta,$type=1,$argument=array())
	{
		$BookingFormElement=new BCBSBookingFormElement();
		return($BookingFormElement->displayField($panelId,$meta,$type,$argument));
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/