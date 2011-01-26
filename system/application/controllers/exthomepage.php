<?php 
class exthomepage extends Controller {

  function exthomepage() {
          parent::Controller();
          $this->load->database();
  }
  function index() {  
    echo "Hello";
  }
  function nhrstatus(){
    $this->load->helper('form');
    

   
    $dispobj='';
    $chapQuery="SELECT a.chapter_id,a.chapter_name,b.pwh_count,b.livemode,b.hfichap_id,a.chapter_zone
    FROM tbl_chapters a left join tbl_hfirefrence 
    b on a.chapter_ID=b.chap_id order by a.chapter_zone, a.chapter_name,b.livemode";
    $zonearray=array('','North','West','East','South');
    $chapResults=$this->db->query($chapQuery);
    $dispobj='';
    $dispobj.='<table width="80%" align="center">';
    $dispobj.="<tr><th>Slno</th><th>Chapter Name</th><th>Mode</th></tr>";
    
    $tmpZone=0;
    foreach($chapResults->result_array() as $row){
      if ($tmpZone!=$row['chapter_zone']){
        $tmpZone=$row['chapter_zone'];
         $dispobj.='<tr><td colspan="4" style="background-color:#cccccc">'.$zonearray[$tmpZone].'</td></tr>';
         $i=1;
      }
      $dispobj.='<tr>';
      $dispobj.='<td>'.$i.'</td>';
      $dispobj.='<td>'.$row['chapter_name'].'</td>';
      $livemode='<span class="wipstyle">WiP</span>';
      if ($row['livemode']==1){
        $livemode='Live';
      }
      $dispobj.='<td>'.$livemode.'</td>';
      $dispobj.='</tr>';
      $i++;
    }
    $dispobj.='</table>';
    $data = array(
        'footer' => 'NHR 2011',
        'chapterName' => 'Hemophilia Federation (India)',
        'scrip' => '',
         
        'content' => $dispobj
      );
   
   $this->load->view('view_registration',$data);
    
  }
} 
?>  