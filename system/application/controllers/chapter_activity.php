<?php
class chapter_activity extends Controller {
  var $pwhDisplayData='';
  function chapter_activity() {
          parent::Controller();
          $this->load->library('session');
         
      //$this->template->add_css('styles/form.css');
      $pwhid=$this->uri->segment(3);
      
      
      
     
     $this->template->write_view('header','header',$this->session->userdata('headerdata'), True);
  }
  function index() {  
    echo "I am called";
  }
  function listactivity(){
    $queryObject=$this->db->query('select * from tbl_activity a join tbl_activity_master b on
        a.act_cat_id=b.act_cat_id where a.chap_id='.$this->session->userdata('chapter'));
     $displaylist='';
        $displaylist.='<div class="inputdatablock">
          <div style="text-align:right;padding:0px 10px">
        <a href="/chapter_activity/manage_activity">Add New</a> </div>';
        $displaylist.='<table width="90 ``%" align="center" cellpadding="2">
        
        ';
      
    $displaylist.='<tr>';
    $displaylist.='<th style="width:10px" width=10>Sl.No</th><th style="width:250px">Activity Name</th>
    <th style="width:150px">Activity</th>
    <th  style="width:100px">Picture</th>';
    $displaylist.='</tr>';
    $i=1;
    foreach($queryObject->result() as $row){
      $displaylist.='<tr>';
    $displaylist.='<td>'.$i.'</td>
          <td>'.$row->activity_name.'</td><td>'.$row->act_cat_desc.'</td>
          <td align="center">
            <a href="/mediaupload/view_uploadform/'.$row->activity_id.'/2">[ Add ]</a>&nbsp;
            
            <a href="/chapter_activity/report_view/'.$row->activity_id.'">[ View ]</a>&nbsp;
            '.$this->countimages($row->activity_id).' images
          </td>';
    $displaylist.='</tr>';
    $i++;
    }
    $displaylist.='</table>';
    $displaylist.='</div>';
    $data= array('formdisplay'=>$displaylist);
     $this->template->add_css ('
      .inputdatablock input{
        width:80px;
      }
      .inputdatablock th{
        background-color:#E8E1D9;
  border:1px solid #E0CFC2;
        width:80px;
      }
      .blockheader{
  background-color:#E3E1E1;
  padding:5px 5px;
  margin-top:10px;
}
        .inputdatablock table{
          
        }
     ','embed');
     
      
    $this->template->write('pageheader', 'List of Chapter Activity');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
  function manage_activity($activity_id=0){
    //Data Array
    if ($activity_id>0){
      $activityobject=$this->db->query('select * from tbl_activity where activity_id='.$activity_id);
      $activityRow=$activityobject->row_array();
    }else{
      $activityRow=array(
        'act_datefrom'=>'',
        'act_dateto'=>'',
        'aboutactivity'=>'',
        'outcome'=>'',
        'act_cat_desc'=>'',
        'activity_name'=>''
      );
    }
     $displaylist='';
        $displaylist.='<div class="inputdatablock" >';
     $displaylist.='<form action="/chapter_activity/update_data" method="post" >';
    $displaylist.='<div class="inputdatablock">';
        $displaylist.='<ul>';
        
        $displaylist.='<li>
              <label>Activity Title</label>
              <input type="text" name="act_cat_desc" id="act_cat_desc" style="width:350px"
                value="'.$activityRow['activity_name'].'"
              /> 
              </li>';
         $displaylist.='<li>
              <label>Date</label>
              <input type="text" name="fromdate" id="fromdate"
              
              value="'.mysqltohuman($activityRow['act_datefrom']).'"
              /> to <input type="text" name="todate" id="todate"
              
              value="'.mysqltohuman($activityRow['act_dateto']).'"
              />
              </li>';
          $displaylist.='<li>
              <label>Activity Type</label>
               <select name="activity_type" id="activity_type" class="activity_type">
                  <option "0">--Select--</option>
                  '.$this->activityobject().'
               </select>
              </li>';
          $displaylist.='<li>
              <label>Activity</label>
             <select name="activity_details" id="activity_details" class="activity_details">
                  <option "0">--Select--</option>
                   
               </select>
              </li>';    
         $displaylist.='<li>
              <label>About Activity</label>
              <textarea name="aboutactivity" id="aboutactivity" class="paraArea">
               '.$activityRow['aboutactivity'].' 
              </textarea>
              </li>';    
         $displaylist.='<li>
              <label >Out come</label>
              <textarea name="outcome" id="outcome" class="paraArea">
                 '.$activityRow['aboutactivity'].' 
              </textarea>
              </li>';    
          
         $displaylist .='<input type="hidden" name="activity_id" value="'.$activity_id.'" />';
          $displaylist.='<li>
              <label >&nbsp;</label>
              <input type="submit" value="save" />    
              </li>';  
        $displaylist.='</ul>';
    $displaylist.='</div>';
    
    $displaylist.='</form>';
    $displaylist.='</div>';
    $data= array('formdisplay'=>$displaylist);
     $this->template->add_css ('/styles/chapterstyle.css ');
     $this->template->add_js('
     $(document).ready(function() {
           $("#activity_type").change(function() {
              console.log($(this).val());
              var clickValue=$(this).val();
              $.ajax({
                data: {refdata:clickValue},
                type:"post",
          url: "'.base_url().'chapter_activity/activityobject/",
             
            success: function(data) {
               console.log(data);
               data="<option value=0>--select--</option>"+data;
              $("#activity_details").html(data);
          }
              });
              
           });
           $( "#fromdate" ).datepicker({
               changeMonth: true,
               changeYear: true,
                
                dateFormat:"mm/dd/yy"
          });
           $( "#todate" ).datepicker({
               changeMonth: true,
               changeYear: true,
                
                dateFormat:"mm/dd/yy"
          });
       });
     ','embed');
     
    $this->template->write('pageheader', 'Manage Activity');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
/*
 * Update Data
 */
 
 function update_data(){
   
   $dataArray=array(
    'act_cat_id'=>$_POST['activity_details'],
    'act_datefrom'=>humantomysql($_POST['fromdate']),
    'act_dateto'=>humantomysql($_POST['todate']),
    'aboutactivity'=>$_POST['aboutactivity'],
    'activity_name'=>$_POST['act_cat_desc'],
    'outcomeactivity'=>$_POST['outcome'],
    'chap_id'=>$this->session->userdata('chapter'),
    
   );
   
    
  
   if ($_POST['activity_id']>0){
     $this->db->where('activity_id',$_POST['activity_id']);
      $this->db->update('tbl_activity',$dataArray);
   }else{
     $this->db->insert('tbl_activity',$dataArray);
   }
  redirect("/chapter_activity/listactivity");
 }
 function countimages($activity_id){
   $qryObj=$this->db->query('select * from tbl_chatper_attachments where activity_id='.$activity_id);
   return $qryObj->num_rows();
 } 
  function activityobject($refdata=0,$mode=0){
    if (isset($_POST['refdata'])){
     $refdata=$_POST['refdata'];
    }
    $qryObject=$this->db->query('select * from tbl_activity_master
              where act_cat_parent_id='.$refdata);
    $retvalue='';
    foreach($qryObject->result() as $row){
      $retvalue.='<option value="'.$row->act_cat_id.'">'.$row->act_cat_desc.'</option>';
    }  
    if (isset($_POST['refdata'])){
      echo  $retvalue;
    } else{
      return $retvalue;
    }       
    
  }
  // Report View
  function report_view($activity_id=0){
     
    $queryObject=$this->db->query('select * from tbl_activity a join tbl_activity_master b on 
      a.act_cat_id=b.act_cat_id
    where a.activity_id='.$activity_id);
    $queryImageObject=$this->db->query('select *  FROM tbl_chatper_attachments where activity_id='.$activity_id);
    $activityInfoRow=$queryObject->row();
     $displaylist='';
        $displaylist.='<div class="inputdatablock" >';
       $displaylist.='<h2 style="text-align:center;padding:5px"><span style="color:#ff0000">Name: </span>'.$activityInfoRow->activity_name.', '.$activityInfoRow->act_cat_desc.'</h2>';
      
        foreach($queryImageObject->result() as $rowImage){
           
          $displaylist.='<a class="fancybox" rel="group" href="/chapteractivity/'.$rowImage->a_filename.'">
            <img src="/chapteractivity/'.$rowImage->a_filename.'" alt="'.$rowImage->a_title.'" width="120"/>
            </a>';
             
        }
       
    $displaylist.='</div>';
    $data= array('formdisplay'=>$displaylist);
    $this->template->add_css('/js/fancy/jquery.fancybox.css?v=2.0.6');
  
     
    $this->template->add_js('js/fancy/jquery.fancybox.pack.js');
    $this->template->add_js('
      $(document).ready(function() {
    $(".fancybox").fancybox();
  });
    ','embed');
   
     
      
    $this->template->write('pageheader', 'Activity View');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
 
  }
}
?>