<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function buildformui($pFormArray){
	$CI =& get_instance();
	$CI->load->helper('form');
	
	$formvalue='';
	if (($pFormArray['type']!='formopen')&&($pFormArray['type']!='formclose')){
		$formvalue.='<div>';
	}
	$placeholder='';
	//Build Label 
	if (isset($pFormArray['label'])){
		$formvalue.=form_label($pFormArray['label'], 'lbl'.$pFormArray['label']);
	}
	if (isset($pFormArray['placeholder'])){
			$placeholder=$pFormArray['placeholder'];	
	}
	switch ($pFormArray['type']){
		case 'input':
			$inArray=array(
				'name' =>$pFormArray['name'],
				'id'   =>$pFormArray['name'],
				'value'=>$pFormArray['value'],
				'class'=>$pFormArray['class'],
				'placeholder' =>$placeholder 
			);
			$formvalue.=form_input($inArray);
			break;
    case 'button':
      $inArray=array(
        'name' =>$pFormArray['name'],
        'id'   =>$pFormArray['name'],
        'content'=>$pFormArray['value'],
        'class'=>$pFormArray['class']
        
      );
     $formvalue.=form_button($inArray);
      break;
    case 'file':
      $inArray=array(
        'name' =>$pFormArray['name'],
        'id'   =>$pFormArray['name'],
        'value'=>$pFormArray['value'],
        'class'=>$pFormArray['class'],
        'placeholder' =>$placeholder 
      );
      $formvalue.=form_upload($inArray);
      break;  
        
		case 'password':
			$inArray=array(
				'name' =>$pFormArray['name'],
				'id'   =>$pFormArray['name'],
				'value'=>$pFormArray['value'],
				'class'=>$pFormArray['class'],
				'placeholder' =>$placeholder 
			);
			$formvalue.=form_password($inArray);
			break;	
		case 'dropdown':
			$attr=' id="'.$pFormArray['name'].'"';
			$formvalue.=form_dropdown($pFormArray['name'], $pFormArray['dropvalue'], $pFormArray['selectedvalue'],$attr);
			break;
		case 'textarea':
			$inArray=array(
				'name' =>$pFormArray['name'],
				'id'   =>$pFormArray['name'],
				'value'=>$pFormArray['value'],
				'class'=>$pFormArray['class'],
			);
			$formvalue.=form_textarea($inArray);
			break;
		case 'radiobutton':
			$radiovalues=$pFormArray['radiovalues'];
			foreach($radiovalues as $key=>$value){
				$inArray=array(
				'name' =>$pFormArray['name'],
				'id'   =>$pFormArray['name'].'_'.$key,
				'value'=>$key,
				'class'=>$pFormArray['class'],
			);
			$formvalue.=form_radio($inArray);
			$formvalue.='<span>&nbsp;'.$value.'</span>';
			}
			
			break;	
		case 'checkbox':
			$radiovalues=$pFormArray['checkbox'];
			foreach($radiovalues as $key=>$value){
				$inArray=array(
				'name' =>$pFormArray['name'],
				'id'   =>$pFormArray['name'].'_'.$key,
				'value'=>$key,
				'class'=>$pFormArray['class'],
			);
			$formvalue.=form_radio($inArray);
			$formvalue.='<span>&nbsp;'.$value.'</span>';
			}
			
			break;		
		case 'submit':
			$inArray=array(
				'name' =>$pFormArray['name'],
				'id'   =>$pFormArray['name'],
				'value'=>$pFormArray['value'],
				'class'=>$pFormArray['class'],
			);
			$formvalue.='<a style="text-decoration:none" href="'.$pFormArray['backlink'].'">
			<input type="button" value="Cancel" class="button medium white"/></a>&nbsp;&nbsp;&nbsp;';
			$formvalue.=form_submit($inArray);
			
			break;
		case 'formopen':
				$formvalue.=form_open($pFormArray['action'],$pFormArray['attr']);
				break;
		case 'formclose':
			$formvalue.=form_close();
			break;
		case 'hidden':
				
				$formvalue.=form_hidden($pFormArray['name'], $pFormArray['value']);
				break;
    case 'hidden1':
        
        $formvalue.=form_hidden($pFormArray['name'], $pFormArray['value']);
         
        break;    
		case 'displaytext':
			$formvalue.='<span class="formdisplaytext">'.$pFormArray['value'].'</span>';
			break;		
	}
  //Add Extra Value for the Form
  if (isset($pFormArray['extravalues'])){
    $tmpExtraString=substr($formvalue,0,-2);
    $formvalue=$tmpExtraString.' '.$pFormArray['extravalues'].' />';
  }
	if (isset($pFormArray['tiptag'])){
		$formvalue.='<span class="tiptag">'.$pFormArray['tiptag'].'</span>';
	}
	
	
	if (($pFormArray['type']!='formopen')&&($pFormArray['type']!='formclose')){
		$formvalue.='</div>';
	}
  
	return $formvalue;
}



?>