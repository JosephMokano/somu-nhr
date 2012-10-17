<?php
class duplicatebrowse extends Controller {
  var $pwhDisplayData='';
  function duplicatebrowse() {
          parent::Controller();
           $this->load->library("session");
         $this->session->set_userdata("chapter",0);
  }
  function index() {  
    echo "I am called";
  }
  function chaptersnapshot($chap_zone=1){
     //echo $pwhid;
    $displaylist='';
    
    
  
   //Build Form
   $formElement='
      <fieldset >
        <legend>&nbsp;<b>Chapter Selector</b>&nbsp;</legend>
          <div class="formholder">
            <label> Zones:</label><br/>
            <input type="radio" name="chap_zone" value="1" checked class="chap_zone" />&nbsp;North
            <input type="radio" name="chap_zone" value="2" class="chap_zone"/>&nbsp;West
            <input type="radio" name="chap_zone" value="3" class="chap_zone"/>&nbsp;East
            <input type="radio" name="chap_zone" value="4" class="chap_zone"/>&nbsp;South
          </div>
          <div class="formholder" >
            <label> List of chapters:</label><br/>
            <select name="chap_names" id="chap_names">'.$this->chaptercall($chap_zone).'</select>
          </div>
          
      </fieldset>
      
      <div id="chapterdetails"></div>
            
      </div>
        
   ';
   $chapterinfo='<div id="chapterinfodisplay" >
    
    </div>';
  $displaylist.='<table cellpadding="0" cellspacing="4" border="0" width="100%">
    <tr><td width="60%">'.$formElement.'</td><td width="40%">'.$chapterinfo.'</td></tr></table>';
  $data= array('formdisplay'=>$displaylist);
  $this->template->add_js('
    $(document).ready(function() {
      $(".chap_zone").click(function(){
        var myobj=$(this);
        console.log(myobj.val());
        updatechapter(myobj.val());
      }); 
      $("#chap_names").change(function(){
        var myobj=$(this);
        console.log(myobj.val());
        getChapterinfo(myobj.val());
        });
      
    });
    $(document).ajaxStart(function(){
        show_overlay();
    }).ajaxStop(function(){
      hide_overlay();
    });
    //Page onload ends
    function updatechapter(chap_zone){
      
    
      $.ajax({
          "type":"POST",
          "data":"chap_zone="+chap_zone,
          "url":"'.$this->config->item('base_url').'duplicatebrowse/chaptercall",
          success:function(data){
            $("#chap_names").html(data);
          }
        });
    }
    function getChapterinfo(chapter_id){
      $.ajax({
          "type":"POST",
          "data":"chapter_id="+chapter_id,
          "url":"'.$this->config->item('base_url').'duplicatebrowse/dupmembers",
          success:function(data){
             // jdata=jQuery.parseJSON(data);
              
           // $("#chapterinfodisplay").html(jdata.pwddetails);
            $("#chapterdetails").html(data);
            $("#pwhtable tr:even").addClass("alt");
            $(".getdetails").bind("click",function() {
               var patID=$(this).attr("myid");
               getDupDetailsData(patID);
            });
          }
        });
    }
    function getDupDetailsData(patient_id){
      $.ajax({
          "type":"POST",
          "data":"patient_id="+patient_id,
          "url":"'.$this->config->item('base_url').'duplicatebrowse/getDupDetailsData",
          success:function(data){
             
              
           
            $("#chapterinfodisplay").html(data);
             
            
          }
        });
    }
  
  ','embed');
  $this->template->add_css('/styles/reports.css');
  $this->template->add_js('/js/overlay.js');
  $this->template->add_css('/styles/overlay.css');
  $this->template->add_css('
  .factDet1{
    width:100%;
    margin:0px auto;
  }
    .factDet1 th{
      width:50%;
      text-align:right;
      padding-right:10px;
    }
    .faceDet1 td{
      border-bottom:1px dotted #E7E7E7;
    }
  .styleblock{
    background-color:#F3EEEE;
    border-bottom:1px solid #cccccc;
    border-top:1px solid #cccccc;
  }
  .leftalign{
    text-align:left;
  }
  .alt{
    background-color:#F6F4F2;
  }
  .getdetails{
    cursor:pointer;
  }
  
  ','embed');
    $this->template->write('pageheader', 'Chapter Pending Details');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
  
  function chaptercall($chap_zone=0){
    $chapmode=0;
    if (isset($_POST['chap_zone'])){
      $chapmode=1;
      $chap_zone=$_POST['chap_zone'];
    }
  //Get Chapter Data
  $chap_query=$this->db->query('select chapter_ID,chapter_name,chapter_zone from tbl_chapters where chapter_zone='.$chap_zone.' order by chapter_name');
    $chapterelement='<option value="0">-- Select --</option>';
    foreach($chap_query->result() as $rowchap){
      $chapterelement.='<option value="'.$rowchap->chapter_ID.'">'.$rowchap->chapter_name.'</option>';
    }
  if ($chapmode==1){
    echo $chapterelement;
  }else{
    return $chapterelement;
  }
  
  }
  function dupmembers(){
    $chapter_id=$_POST['chapter_id'];
    $query='select patient_id,patient_first_name,patient_last_name from tbl_pat_personal where patient_id in 
        (select patient_id from tbl_dup) and chap_id='.$chapter_id.' order by patient_first_name';
    $queryobj=$this->db->query($query);
    $retValue='';
    $retValue.='<table cellpadding="2" cellspacing="2" width="100%" border="0" id="pwhtable">';
    $retValue.='<tr>
                  <th>Sl.No</th>
                  <th>Full Name</th>
                  <th>NHR.Ref</th>
                </tr>';
  $i=1;                   
  foreach($queryobj->result() as $patrow){
    $retValue.='<tr>
              <td width="10">'.$i.'</td>
              <td><span class="getdetails" myid="'.$patrow->patient_id.'">'.$patrow->patient_first_name.' '.$patrow->patient_last_name.'</span></td>
              <td width="20">'.$patrow->patient_id.'</td>
            </tr>';
            $i++;
  } 
    $retValue.='</table>';
    echo $retValue;               
  }
  function gendata(){
    $myFile = "/tmp/testFile.csv";
    
    $queryobj=$this->db->query('select * from tbl_chapters order by chapter_zone');
    $retValue='';
    foreach($queryobj->result() as $row){
        $retValue='/tmp/nhr/'.str_replace(" ","_",$row->chapter_name).'.xls';
        $fp = fopen($retValue, 'w');
         $this->forvikash($row->chapter_ID,$fp);
         fclose($fp);
       }
   
  }
  function forvikash($chap_id,$fileref){
    $rowarray=array();   
    $dupRec='select * from tbl_dup where patient_ID in (select patient_ID from tbl_pat_personal where chap_id='.$chap_id.')';
    $dupObject=$this->db->query($dupRec);
    foreach($dupObject->result() as $dupRow){
      
        $orgPatient=$this->db->query('select * from tbl_pat_personal where patient_ID in ('.$dupRow->patient_match.')');
        foreach($orgPatient->result() as $extRow){
            $row='';
            $row.=$extRow->patient_ID.','.$extRow->patient_first_name.','.$extRow->patient_last_name.',
            '.$extRow->patient_father_name.','.mysqltohuman($extRow->patient_dob).',
            '.bloodgroupretrun($extRow->patient_bloodgroup).',
            '.factordeficiencyreturn($extRow->patient_factor_deficient).','.$extRow->patient_factor_level;
            //$rowarray[]=explode(',',$row);
            fputcsv($fileref, explode(',',$row));
        }
        
    }
    
    //return $rowarray;
    
  }
  function getDupDetailsData(){
    $patient_id=$_POST['patient_id'];
    $dupQuery='select * from tbl_dup where patient_id='.$patient_id;
    $dupObject=$this->db->query($dupQuery);
    $dupRow=$dupObject->row(); 
   $this->load->helper('apputility_helper');
   
    $query='select * from tbl_pat_personal a join tbl_chapters b on a.chap_id=b.chapter_id
          where patient_id = '.$patient_id;
    $queryOrgObject=$this->db->query($query);
    $orgRow=$queryOrgObject->row();
   //Duplicate
    $query='select * from tbl_pat_personal a join tbl_chapters b on a.chap_id=b.chapter_id
          where patient_id in ('.$dupRow->patient_match.')';
     $queryObj=$this->db->query($query);     
    $retValue="";
    
    $retValue.='<table cellpadding="4" cellspacing="2" border="0" width="100%">';
    //Clicked Data
    $retValue.='<tr>
            <td colspan="2" class="chapname" style="background-color:#F3EEEE"><b>Clicked PWH Details</b></td>
        </tr>';
      $retValue.='<tr>
            <th width="100">Patient Name</th>
            <td>'.$orgRow->patient_first_name.' '.$orgRow->patient_last_name.'</td>
        </tr>';  
         $retValue.='<tr>
            <th>Father Name</th>
            <td>'.$orgRow->patient_father_name.'</td>
        </tr>'; 
         $retValue.='<tr>
            <th>Data of Birth</th>
            <td>'.mysqltohuman($orgRow->patient_dob).'</td>
        </tr>'; 
        
         $retValue.='<tr>
            <th>Medical Details</th>
            <td>'.bloodgroupretrun($orgRow->patient_bloodgroup).' / '.factordeficiencyreturn($orgRow->patient_factor_deficient).' / '.$orgRow->patient_factor_level.'</td>
        </tr>'; 
         $retValue.='<tr>
            <th>NHR Ref ID*</th>
            <td>'.$orgRow->patient_ID.'</td>
        </tr>';
         $retValue.='<tr><td colspan="2" style="border-bottom:2px solid #ff0000"><br/></td></tr>';
    foreach($queryObj->result() as $qryRow){
      $retValue.='<tr>
            <td colspan="2" class="chapname" style="background-color:#F3EEEE"><b>Chapter Name: </b>'.$qryRow->chapter_name.'</td>
        </tr>';
      $retValue.='<tr>
            <th width="100">Patient Name</th>
            <td>'.$qryRow->patient_first_name.' '.$qryRow->patient_last_name.'</td>
        </tr>';  
         $retValue.='<tr>
            <th>Father Name</th>
            <td>'.$qryRow->patient_father_name.'</td>
        </tr>'; 
         $retValue.='<tr>
            <th>Data of Birth</th>
            <td>'.mysqltohuman($qryRow->patient_dob).'</td>
        </tr>'; 
        
         $retValue.='<tr>
            <th>Medical Details</th>
            <td>'.bloodgroupretrun($qryRow->patient_bloodgroup).' / '.factordeficiencyreturn($qryRow->patient_factor_deficient).' / '.$qryRow->patient_factor_level.'</td>
        </tr>'; 
         $retValue.='<tr>
            <th>NHR Ref ID*</th>
            <td>'.$qryRow->patient_ID.'</td>
        </tr>';
         $retValue.='<tr><td colspan="2" style="border-bottom:2px solid #cccccc"><br/></td></tr>';
    }   
    $retValue.='<tr><td colspan="2" style="font-size:.8em;color:#ff0000">* This is IT team reference not NHR ID</td></tr>'  ; 
    $retValue.='</table>';
    echo $retValue;
  }
  function chapterdetails(){
    $chapter_id=$_POST['chapter_id'];
    $params = array('chapter_id' => $chapter_id);
     $this->load->library("nhrpwhdetails",$params);
     $pwhcount=$this->nhrpwhdetails->fetch_factorwise($chapter_id);
     //PWH Snapshot
     $pwhCountdisplay='';
      $pwhCountdisplay.='<table width="100%" cellpadding="0" celspacing="0" border="0" >';
      $pwhCountdisplay.='<tr><td width="50%">';
      $pwhCountdisplay.='<table width="100%" cellpadding="0" celspacing="0" border="0" class="factDet">';
      $pwhCountdisplay.='<tr><td class="'.$this->config->item("secction_head").'" colspan="5" style="font-weight:bold;font-size:1.2em">PwH Factorwise Count</td></tr>';
     
      $pwhCountdisplay.='<tr>';
      $pwhCountdisplay.='<th >Factor 8</th>';
      $pwhCountdisplay.='<th >Factor 9</th>';
      $pwhCountdisplay.='<th >Others</th>';
      $pwhCountdisplay.='<th >Not Known</th>';
      $pwhCountdisplay.='<th > Tot Num</th>';
      $pwhCountdisplay.='</tr><tr>';
      $pwhCountdisplay.='<td>'.$pwhcount['count_f8'].'</td>';
      $pwhCountdisplay.='<td>'.$pwhcount['count_f9'].'</td>';
      $pwhCountdisplay.='<td>'.$pwhcount['count_other_total'].'</td>';
      $pwhCountdisplay.='<td>'.$pwhcount['count_empty'].'</td>';
      $pwhCountdisplay.='<td>'.$pwhcount['count_total'].'</td>';
      $pwhCountdisplay.='</tr>';
      $pwhCountdisplay.='<tr><td style="font-size:.8em" colspan="5"><b>Note: </b> Total may not come correct if you add-up Factor 8, Factor - 9, Others, Not Known. 
        Becuase of multiple factor deficiency</td></tr>';
       
      $pwhCountdisplay.='</table>';
      
      $emptycount=$this->nhrpwhdetails->fetch_empty($chapter_id);
      $emptydisplay='';
      $emptydisplay.='<div style="text-align:center"in><a href="'.$this->config->item('base_url').'datamanage/generatespreadsheet/'.$chapter_id.'">Download Excel</a></div>';
      $emptydisplay.='<br/><table width="100%" cellpadding="0" celspacing="0" border="0" class="factDet factDet1" >';
       $emptydisplay.='<tr><td class="'.$this->config->item("secction_head").'" colspan="2" style="font-weight:bold;font-size:1.2em">Data to be Collected</td></tr>';
      $emptydisplay.='<tr><td colspan="2" class="styleblock">High Priority</td></tr>';
      $emptydisplay.='<tr><th width="180">Data of Birth</td><td>'.$emptycount['patient_dob'].'</td></tr>';
      $emptydisplay.='<tr><th>Blood Group</th><td>'.$emptycount['patient_bloodgroup'].'</td></tr>';
      $emptydisplay.='<tr><th>Factor Deficiency</th><td>'.$emptycount['patient_factor'].'</td></tr>';
      $emptydisplay.='<tr><th>Factor Assay/Level</th><td>'.$emptycount['patient_level'].'</td></tr>';
      $emptydisplay.='<tr><th>Deformity</th><td>'.$emptycount['patient_Deformity'].'</td></tr>';
       $emptydisplay.='<tr><th>BPL Eligibility</th><td>'.$emptycount['patient_bpl_eligibility'].'</td></tr>';
      
      $emptydisplay.='<tr><td colspan="2" class="styleblock">Priority</td></tr>';
      $emptydisplay.='<tr><th>Inhibitors</th><td>'.$emptycount['patient_inhibitor_screen'].'</td></tr>';
      $emptydisplay.='<tr><th>HIV</th><td>'.$emptycount['h2'].'</td></tr>';
      $emptydisplay.='<tr><th>HCV</th><td>'.$emptycount['h3'].'</td></tr>';
     
      $emptydisplay.='<tr><th>BPL Refrence</th><td>'.$emptycount['patient_bpl_eligibility'].'</td></tr>';
      
      $emptydisplay.='<tr><td colspan="2" class="styleblock">Important</td></tr>';
      $emptydisplay.='<tr><th>Father Name</th><td>'.$emptycount['patient_fathername'].'</td></tr>';
      $emptydisplay.='<tr><th>Address</th><td>'.$emptycount['patient_address'].'</td></tr>';
      //$emptydisplay.='<tr><th>Phone number</th><td>'.$emptycount['patient_phone'].'</td></tr>';
      $emptydisplay.='<tr><th>Studying</th><td>'.$emptycount['patient_studying'].'</td></tr>';
      $emptydisplay.='<tr><th>Highest Class</th><td>'.$emptycount['patient_highestedu'].'</td></tr>';
      $emptydisplay.='<tr><th>Employed</th><td>'.$emptycount['patient_working'].'</td></tr>';
      $emptydisplay.='<tr><th>Remboursement</th><td>'.$emptycount['patient_Remboursement_faclity'].'</td></tr>';
      
      
     
      
      $emptydisplay.='</table>';
      
      $chapterinfo='<div class="spacer"></div>';
      if ($pwhcount['count_total']==0){
        $chapterinfo.='<div class="alertbox">Data needs to be collected from this Chapter</div><div class="spacer"></div>';
      }
     $retValueajax=array(
      'pwddetails'=>$chapterinfo.$pwhCountdisplay.'<div class="spacer"></div>'.$emptydisplay,
      'chapterdetails'=>$this->_viewchatper($chapter_id)
     );
      echo json_encode($retValueajax);
  }
  
  function chpaterseethrough(){
    $chapterquery='select b.chapter_name,count(a.chap_id) pcount,b.chapter_zone from tbl_pat_personal a 
    left join tbl_chapters b on a.chap_id=b.chapter_id 
    group by a.chap_id order by b.chapter_zone, b.chapter_name';    
  $qrychapter=$this->db->query($chapterquery);
  $i=1;
  $displayView='';
  $displayView='<div style="margin:10px 0px;text-align:center">
            <a href="/datamanage/chpaterseethrough">:: List of chapters Data Available  </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/datamanage/chpaterseethroughnot">:: Chapters Data to be collected   </a>
      </div>';
  $displayView.='<table cellpadding="2" cellspacing="1" border="0" width="100%" class="factDet">';
  $displayView.='<tr>
      <th>Slno</th>
      <th>C.Slno</th>
      <th>Chapter Name</th>
      <th>Count</th>
    </tr>';
  $zonearray=array('North','West','East','South');
  $zoneid=0;
  $j=0;

  foreach($qrychapter->result() as $chaprow){
    if ($zoneid!=$chaprow->chapter_zone){
      
      $zoneid=$chaprow->chapter_zone;
      $displayView.='<tr><td class="styleblock"></td><td colspan="3" class="styleblock">'.$zonearray[$zoneid-1].'</td></tr>';
      $j=1;
    }
    $displayView.='
      <tr>
        <td>'.$i.'</td>
        <td>'.$j.'</td>
        <td>'.$chaprow->chapter_name.'</td>
        <td>'.$chaprow->pcount.'</td>
      </tr>
    ';
    $i++;$j++;
    
  }
  
  $displayView.='</table>'; 
  $data= array('formdisplay'=>$displayView);
  $this->template->add_js('','embed');
  $this->template->add_css('styles/reports.css');
  $this->template->add_css('
  .factDet{
    width:80%;
    margin:0px auto;
  }
    .factDet th{
      
      padding-right:10px;
    }
    .factDet td{
        text-align:left;
      border-bottom:1px dotted #E7E7E7;
    }<tr><td class="'.$this->config->item("secction_head").'" colspan="2" style="font-weight:bold;font-size:1.2em">Data to be Collected</td></tr>
  .styleblock{
    background-color:#F3EEEE;
    border-bottom:1px solid #cccccc;
    border-top:1px solid #cccccc;
    text-align:center;
    font-size:1.2em;
    font-weight:bold;
  }
  .leftalign{
    text-align:left;
  }
  ','embed');
    $this->template->write('pageheader', 'Chapters Data Available ');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
function chpaterseethroughnot(){
    //$chapterquery='select chapter_name,chapter_zone from tbl_chapters where not (chapter_id in (select DISTINCT chap_id from tbl_pat_personal))';
    $chapterquery='select a.chapter_name,a.chapter_zone,count(b.patient_id) as co from 
    tbl_chapters a left join tbl_pat_personal b on a.chapter_id=b.chap_id   group by a.chapter_id order by a.chapter_zone';
        
  $qrychapter=$this->db->query($chapterquery);
  $i=1;
  $displayView='';
  $displayView='<div style="margin:10px 0px;text-align:center">
            <a href="/datamanage/chpaterseethrough">:: List of chapters Data Available  </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/datamanage/chpaterseethroughnot">:: Chapters Data to be collected   </a>
      </div>';
  $displayView.='<table cellpadding="2" cellspacing="1" border="0" width="100%" class="factDet">';
  $displayView.='<tr>
      <th>Slno</th>
      <th>C.Slno</th>
      <th>Chapter Name</th>
      
    </tr>';
  $zonearray=array('North','West','East','South');
  $zoneid=0;
  $j=0;

  foreach($qrychapter->result() as $chaprow){
    if ($zoneid!=$chaprow->chapter_zone){
      
      $zoneid=$chaprow->chapter_zone;
      $displayView.='<tr><td class="styleblock"></td><td colspan="3" class="styleblock">'.$zonearray[$zoneid-1].'</td></tr>';
      $j=1;
    }
    if ($chaprow->co==0){
    $displayView.='
      <tr>
        <td>'.$i.'</td>
        <td>'.$j.'</td>
        <td>'.$chaprow->chapter_name.'</td>
        
      </tr>
    ';
    $i++;$j++;
    }
    
  }
  
  $displayView.='</table>'; 
  $data= array('formdisplay'=>$displayView);
  $this->template->add_js('','embed');
  $this->template->add_css('styles/reports.css');
  $this->template->add_css('
  .factDet{
    width:80%;
    margin:0px auto;
  }
    .factDet th{
      
      padding-right:10px;
    }
    .factDet td{
        text-align:left;
      border-bottom:1px dotted #E7E7E7;
    }
  .styleblock{
    background-color:#F3EEEE;
    border-bottom:1px solid #cccccc;
    border-top:1px solid #cccccc;
    text-align:center;
    font-size:1.2em;
    font-weight:bold;
  }
  ','embed');
    $this->template->write('pageheader', 'Chapter Pending Details');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
  
  
  
  
  
 
  //Chapter Details:
  private function _viewchatper($chapter_id=0){
    $chapterDetails=$this->db->query('select * from tbl_chapters where chapter_ID='.$chapter_id);
    $chapterRow=$chapterDetails->row();
    
    $pwhCountdisplay='';
    $this->load->library('session');
    if ($this->session->userdata('group')==10){
      $this->load->library("session");

      $pwhCountdisplay='<tr><td></td><td style="text-align:left">
      <ol> 
      <li><a href="'.$this->config->item('base_url').'datamanage/updatecalls/'.$chapter_id.'">Update Calls</a></li>
      <li><a href="'.$this->config->item('base_url').'datamanage/emailthischapter/'.$chapter_id.'">Email this Chapter</a></li>
        <li><a href="'.$this->config->item('base_url').'datamanage/smsthischapter/'.$chapter_id.'">SMS this Chapter</a></li>
        <li><a href="'.$this->config->item('base_url').'datamanage/editchapterdetails/'.$chapter_id.'">Edit this Chapter</a></li> 
          <li><br/></li> 
          <li><a href="'.$this->config->item('base_url').'datamanage/editpwhlist/'.$chapter_id.'">PWH Edit</a>
          
          
          </li> 
        
        </ol>
        
       </td></tr>
       ';
      
    }
    $displaylist='
    <table cellpadding="4" cellspacing="2" border="1" width="100%" class="factDet factDet1">
      <tr><td class="'.$this->config->item("secction_head").'" colspan="2" style="font-weight:bold;font-size:1.2em">Chapter Details</td></tr>
      <tr><th >Chapter Name: </th><td style="text-align:left">'.$chapterRow->chapter_name.'</td></tr>
      <tr><th>Chapter Address: </th><td style="text-align:left">'.$chapterRow->chapter_address1.'</td></tr>
      <tr><th> </th><td style="text-align:left">'.$chapterRow->chapter_address2.'</td></tr>
      <tr><th>Phone Number: </th><td style="text-align:left">'.$chapterRow->chapter_phone.'</td></tr>
      <tr><th>Cell Number: </th><td style="text-align:left">'.$chapterRow->chapter_cell.'</td></tr>
      <tr><th>Key Person: </th><td style="text-align:left">'.$chapterRow->chapter_keyperson.'</td></tr>
      <tr><th>Fax: </th><td style="text-align:left">'.$chapterRow->chapter_fax.'</td></tr>
      <tr><th>Email: </th><td style="text-align:left">'.$chapterRow->chapter_email.'</td></tr>
      
      '.$pwhCountdisplay.'
      
    </table>';
    
  
  return $displaylist;
    
  }
  
  
  
} 
?>