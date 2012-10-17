<?php 
class managemembers extends Controller {

  function managemembers() {
          parent::Controller();
           $this->load->database();
    
    $this->load->library('session');
   $this->template->write_view('header','header',$this->session->userdata('headerdata'), True);
    $this->template->add_js('js/jquery-ui-1.8.7.custom.min.js','import');
    $this->template->add_css('styles/smoothness/jquery-ui-1.8.7.custom.css');
  }
  function index() {  
    $this->loginscreen();
  }
  
  function patient_addform(){
    $this->load->database();
    $this->load->helper('form');
    $this->load->library('session');
    $formAttr=array('name'=>'members_form','id'=>'members_form');
    $displayVar='';
    $displayVar.='<div style="width:500px;margin:0px auto">';
    $displayVar.='<div class="error"></div>
    <div class="ui-state-highlight ui-corner-all infoMessage" style="margin:10px 0px;">
      <p>
        <div class="ui-icon ui-icon-info nhrIcon" /></div>Before adding PWH data, Software will scan through for matching PWH data from your chapter 
        to avoid duplication entry. 
      </p>
    </div>
    ';    
    $displayVar.=form_open('managemembers/validatemember',$formAttr);
    $displayVar.='<div class="label">';
    $displayVar.=form_label('First Name: ','lblfname');
    $displayVar.='</div>';
    
    $displayVar.='<div class="boxarea">';
    $txtformElement=array(
        'id'=>'txtfname',
        'name'=>'txtfname',
        'class'=>'required',  
        'value'=>'',
      );
    $displayVar.=form_input($txtformElement);
    $displayVar.='</div>';
    
    $displayVar.='<div class="clearfield"></div>';
    
    $displayVar.='<div class="label">';
    $displayVar.=form_label('Last Name: ','lbllname');
    $displayVar.='</div>';
    
    $displayVar.='<div class="boxarea">';
    $txtformElement=array(
        'id'=>'txtlname',
        'name'=>'txtlname',
        'class'=>'',  
        'value'=>'',
      );
    $displayVar.=form_input($txtformElement);
    $displayVar.='</div>';    
    
    $displayVar.='<div class="clearfield"></div>';
    
    $displayVar.='<div class="label">';
    $displayVar.=form_label('Factor Deficiency : ','lblfctdef');
    $displayVar.='</div>';
    
    $displayVar.='<div class="boxarea">';
    $Mulattr=' id="txtfctdef" class="factorvalidate" size="14" style="width:230px"';
    $txtformElement=array(
        '0'=>'',
        '1'=>'1 (Factor - I)',
        '2'=>'2 (Factor - II)',
        '3'=>'3 (Factor - III)', 
        '4'=>'4 (Factor - IV)',
        '5'=>'5 (Factor - V)',
        '6'=>'6 (Factor - VI)',
        '7'=>'7 (Factor - VII)',
        '8'=>'8 (Factor - VIII)',
        '9'=>'9 (Factor - IX)',
        '10'=>'10 (Factor - X)',
        '11'=>'11 (Factor - XI)',
        '12'=>'12 (Factor - XII)',
        '13'=>'13 (Factor - XIII)',
        
      );
      
      $fDefaultValue=0;
      
    $displayVar.=form_multiselect('txtfctdef[]',$txtformElement,$fDefaultValue,$Mulattr );
    $displayVar.='</div>';
    
    $displayVar.='<div class="clearfield"></div>';
    $displayVar.='<div class="label">';
    $displayVar.=form_label('Other Deficiency : ','lblOtherdef');
    $displayVar.='</div>';
    
    $displayVar.='<div class="boxarea">';
    $Mulattr=' id="txtOtherdef" class="factorvalidate" size="6" style="width:230px"';
    $txtformElement=array(
        '0'=>'',
        '1'=>'Von Willebrand',
        '2'=>'Glanzmann',
        '3'=>'Fibrinogenemia', 
        '4'=>'Hypofibrinogenemia',
        '5'=>'Functional Platelet Disorder',
        
        
      );
      
      $fDefaultValue=0;
      
    $displayVar.=form_multiselect('txtOtherdef[]',$txtformElement,$fDefaultValue,$Mulattr );
    $displayVar.='</div>';
    
    $displayVar.='<div class="clearfield"></div>';
    $displayVar.='<div style="border:0px solid #000;text-align:center">';
    $attri=array(
      'name'=>'patsubmit',
      'value'=>'Next'
      );
     $displayVar.=form_submit($attri);
     $displayVar.='</div>';
    $displayVar.=form_close();
    $displayVar.='</div>';
    $data = array('formdisplay'=>$displayVar,'cur_class'=>$this->router->class,'cur_method'=>$this->router->method);
    $this->template->add_css('styles/form.css');
      $this->template->add_js('js/jquery.validate.js','import');
    $this->template->add_js('$(document).ready(function() {
      
        
        
        jQuery.validator.addMethod("accept", function(value, element, param) {
            return value.match(new RegExp(param ));
        });
        jQuery.validator.addMethod("factorvalidate",function(value) {
          
            var1=parseInt($("#txtfctdef").val());
            var2=parseInt($("#txtOtherdef").val());
            dbvalue = parseInt(value);
            if ((var1==0)&&(var2==0)){
              return false;
            }else{
              return true;
            }
          
      }, "Select Factor deficiency");
        
         $("#members_form").validate();
        
     
       
         
        
     
      
    });','embed');
    $this->template->add_css('#members_form .error {
      width: auto;
        
        color:#ff0000;
      }', 'embed', 'all');
    $this->template->write('pageheader', 'Add PWH Data ');
    $this->template->write_view('content','members/list_member',$data,True);
    $this->template->render();
  }

  function validatemember(){
    $newentryArray=$_POST;
    //Here For  SuperAdmin we need to edit
    $this->session->set_userdata('newentryArray',$newentryArray);
        $buildQry='';
    if (isset($_POST['txtfname'])){
      $buildQry="patient_first_name like '%".$_POST['txtfname']."%'";
    }
    if (!empty($_POST['txtlname'])){
      if (!empty($buildQry)){
        $buildQry.=' or ';
      }
      $buildQry.="patient_last_name like '%".$_POST['txtlname']."%'";
    }
    
    
    $qryData="select * from tbl_pat_personal 
        where (".$buildQry.") and 
        patient_factor_deficient='".implode(',',$_POST['txtfctdef'])."'
        and chap_id=".$this->session->userdata('chapter')."
        ";
     
     $qryDBvalue=$this->db->query($qryData);
     $displayVar='';
     if ($qryDBvalue->num_rows()>0){
     
    // $displayVar.='<div class="topnewright"><a href="patient_form">Add New</a></div></div>';
     $displayVar .='<table cellpadding="0" cellspacing="5" width="100%">';
    $displayVar .='<tr><td width="50%" >';
    $displayVar .='<div class="ui-state-highlight ui-corner-all" style="margin:10px 0px;">';
    $displayVar .='<div class="ui-accordion-header ui-state-default ui-corner-all nhrpaneltitle" ><div class="ui-icon ui-icon-info nhrIcon" /></div>Following are list of matched PWH Entry in existing DB</div>';
    $displayVar .='
      <ol>
        <li>Click on the names to veiw the details</li>
        <li>If data match with the new PWH entry, click on edit button</li>
        <li>Non of the data is matched <a href="'.base_url().'homepage/patient_form/">Click here to add</a></l>
      </ol>
    
    ';
    $displayVar.="</div>";
    $displayVar .='<table cellpadding="0" cellspacing="0" width="100%" class="memberList">';
    $displayVar .='<tr><th width="30"> Sl.No</th>
            <th>Full Name</th>
            
            <th width="100">Factor<br/>Deficient</th>
            <th></th>
            </tr>';
      $i=1;      
     foreach($qryDBvalue->result() as $row){
      $displayVar.='<tr>
          <td>'.$i.'</td>
          <td><a id="'.$row->patient_ID.'" class="pwhdetailslink">'.$row->patient_first_name.' '.$row->patient_last_name.'</a></td>
          
          <td align="center">'.$row->patient_factor_deficient.'</td>
          <td align="center"><a href="'.base_url().'homepage/patient_form/'.$row->patient_ID.'">Edit</a></td>
      </tr>';   
          $i++;     
     }
     $displayVar.='</table>';
     $displayVar.='</td>
     <td width="50%">
      <div id="pwh_resultdetails"></div>
        </td></tr></table>';
     
    $displayVar.='<div id="nhrdynamicjs"></div>';
     $data = array('formdisplay'=>$displayVar,'cur_class'=>$this->router->class,'cur_method'=>$this->router->method);
    $this->template->add_css('styles/form.css');
    $this->template->write('pageheader', 'Data Scanning');
    $this->template->write_view('content','members/list_member',$data,True);
    
     $this->template->add_js('$(document).ready(function() {
        
       
        $(".memberList tr:even").css("background-color", "#E8E8E8");
        $(".memberList th").addClass("ui-accordion-header ui-state-default");
        $(".memberList th").css("font-size", "11px");
        $(".pwhdetailslink").click(function() {
          var clickValue=$(this).attr(\'id\');
         
         $.ajax({
            url: "'.base_url().'managepatient/details_pwh_dashboard/"+clickValue,
          
            success: function(data) {
             
               var testobj=$.parseJSON(data);
            // alert(testobj.a);
              
               $("#pwh_resultdetails").html(testobj.pwh_details);
               var scriptobj   = document.createElement("script");
              scriptobj.type  = "text/javascript";
            //script.src   = "path/to/your/javascript.js";    // use this for linked script
            scriptobj.text  = testobj.jsnhrscript;              // use this for inline script
            document.body.appendChild(scriptobj);
               //$("#nhrdynamicjs").append();
              
               eval(testobj.nhrcallfunc);
          }
        });
         
         
          
        });
        
        });
        
        
        function updatedata(){
          var chkValue=$("#tracedmode:checked").val();
          var clickID=$("#selectedid").val();
          //alert("I am clicked selectedid: "+chkValue+" "+clickID);
          if (chkValue=="on"){
          $.post("'.$this->config->item("base_path").'managepatient/details_pwh_dashboard", { selectedid: clickID },
            function(data){
              
            });          
          }
          
        }
        
      ', 'embed');
    
    
    $this->template->render();
     }else{
       redirect($this->config->item("base_path")."homepage/patient_form/");
     }
  }
  function missingdata_list(){
    $displayVar='';
    $dataQueryObject=$this->db->query('select * from
            tbl_pat_personal where chap_id='.$this->session->userdata('chapter').' and dv_mode=0
              order by patient_first_name,patient_last_name
            ');
    $displayVar='
      <table cellpadding="5" cellspacing="0" width="100%" border="0" class="memberList">
      <tr>
        <th>
          Sl.No
        </th>
        <th>
          Full Name
        </th>
       <th>
          Father Name
        </th>
        <th class="midwidth">
          Sex
        </th> 
         <th class="midwidth">
          DOB
        </th> 
        <th class="midwidth">
          Address
        </th>  
         <th class="midwidth">
          Blood Group
        </th> 
           
       <th class="midwidth">
          Factor Deficient
        </th>  
       <th class="midwidth">
          Factor Assay
        </th>      
         <th></th>    
          <th>Comments</th>              
      </tr>
    ';
    $i=1;
    foreach($dataQueryObject->result() as $pwhrow){
      $this->load->library('lib_missingdata');
      $displayVar.='<tr>';
      $displayVar.='<td align="right" width="10" >'.$i.'&nbsp;&nbsp;</td>';
      $displayVar.='<td><a href="/homepage/patient_form/'.$pwhrow->patient_ID.'">'.$pwhrow->patient_first_name.' '.$pwhrow->patient_last_name.'</a></td>';
      $displayVar.='<td>'.$pwhrow->patient_father_name.'</td>';
      $displayVar.='<td class="midwidth">'.$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_sex($pwhrow->patient_sex)).'</td>';
      $displayVar.='<td class="midwidth">'.$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_dob($pwhrow->patient_dob)).'</td>';
      $displayVar.='<td class="midwidth">'.$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_address($pwhrow->comm_flat)).'</td>';
      $displayVar.='<td class="midwidth">'.$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_bloodgroup($pwhrow->patient_bloodgroup)).'</td>';
      $displayVar.='<td class="midwidth">'.$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_factor_deficient($pwhrow->patient_factor_deficient,$pwhrow->patient_factor_defother)).'</td>';
      $displayVar.='<td class="midwidth">'.$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_factor_level($pwhrow->patient_factor_level)).'</td>';
      $displayVar.='<td class="midwidth"><a href="/managepatient/downloadpwdhform/'.$pwhrow->patient_ID.'"><img src="/images/Download_icon.png" width="20"/></a></td>';
      $displayVar.='<td class="midwidth"><a href="/core_tracker/dv_communication/'.$pwhrow->patient_ID.'"><img src="/images/report1-icon.png" width="20"/></a></td>';
      $displayVar.='</tr>';
      $i++;
    }      
      $displayVar.='</table>'; 
    $data = array('formdisplay'=>$displayVar);
    $this->template->add_css('
      .midwidth{
        width:40px;
        text-align:center;
      }
    ','embed');
    $this->template->add_js('
       $(document).ready(function(){
         $("tr:even").css("background-color","#F6F4F2");
       })
    ','embed');
    $this->template->write('pageheader', 'List of Missing Data');
    $this->template->write_view('content','members/list_member',$data,True);
    $this->template->render();
  }
  function update_dv_mode(){
    $queryobject=$this->db->query('select * from tbl_pat_personal');
    $this->load->library('lib_missingdata');
    
    foreach($queryobject->result() as $pwhrow){
    $getVar=$this->lib_missingdata->getMissingPWH($pwhrow);
    if ($getVar==0){
      $this->db->where('patient_ID',$pwhrow->patient_ID);
      $this->db->update('tbl_pat_personal',array('dv_mode'=>1));
    }
    }
  }
/* Missing Data Download */
function downloadpdfdata(){
    $displayVar='';
    $dataQueryObject=$this->db->query('select * from
            tbl_pat_personal where chap_id='.$this->session->userdata('chapter').' and dv_mode=0
              order by patient_first_name,patient_last_name
            ');
    $outdata=array();
    $outdata[]=array( 'Sl.No',
      ' Full Name ',     
     ' Father Name ',    
     ' Sex ',
     ' DOB ',
     ' Address ',
     ' Blood Group ',
     ' Factor Deficient ',
     ' Factor Assay '
     );        
   
    $i=1;
    foreach($dataQueryObject->result() as $pwhrow){
      $dataTempArray=array(); 
      $this->load->library('lib_missingdata');
     
      $dataTempArray[]=$i;
       $dataTempArray[]=$pwhrow->patient_first_name.' '.$pwhrow->patient_last_name;
       $dataTempArray[]=$pwhrow->patient_father_name;
      $dataTempArray[]=$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_sex($pwhrow->patient_sex));
      $dataTempArray[]=$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_dob($pwhrow->patient_dob));
      $dataTempArray[]=$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_address($pwhrow->comm_flat));
      $dataTempArray[]=$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_bloodgroup($pwhrow->patient_bloodgroup));
      $dataTempArray[]=$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_factor_deficient($pwhrow->patient_factor_deficient,$pwhrow->patient_factor_defother));
      $dataTempArray[]=$this->lib_missingdata->ui_marker($this->lib_missingdata->patient_factor_level($pwhrow->patient_factor_level));
      
      $i++;
      $outdata[]=$dataTempArray;
    }   
    
    
    $queryObject=$this->db->query('select * from tbl_chapters 
          where chapter_id='.$this->session->userdata('chapter'));
    $chapterRow=$queryObject->row();      
    $filename1=str_replace(" ","_",$chapterRow->chapter_name)."_".date("j_m_Y_g_i_s").".csv";
      
      $filename=$this->config->item('project_abs_path')."uploads/".$filename1;
      $fp = fopen($filename, 'w');
      foreach ($outdata as $fields) {
          fputcsv($fp, $fields);
      }

      fclose($fp);
    redirect($this->config->item("base_url")."uploads/".$filename1);
  }
}
?>
