<?php 
class adminpatientmanage extends Controller {

  function adminpatientmanage() {
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
  
function patient_listdata(){
	     
	//  print_r($this->session->userdata);
      $displaylist="Testing flex Grid";
      $headerdata = array(
        //'chapterName' => 0,
        'chapterName' => "Test Chapter",
        'username' => "No User Just list"
        );
       //FlexGrid Data Starts Here 
        $this->load->helper('flexigrid');
      //  echo $this->session->userdata('chapter');
        if ($this->session->userdata('chapter')==0){
        
         
         $data['chapterdropdown']=$this->chapterAdminList();
        }
          /*
     * 0 - display name
     * 1 - width
     * 2 - sortable
     * 3 - align
     * 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.)
     */
     
    $colModel['patient_id'] = array('ID',40,TRUE,'center',2);
    $colModel['patient_first_name'] = array('Name',180,TRUE,'left',1);
    $colModel['patient_factor'] = array('Factor',40,TRUE,'center',0);
    $colModel['patient_factor_level'] = array('Severity',40,TRUE,'center',0);
    $colModel['Details'] = array('',40,TRUE,'center',0,0,'rowClick');
    
    
    //Check Session
    $this->load->library("session");
    $getPage=$this->session->userdata("gridpagenumber");
    
    if (empty($getPage)){
    	$getPage=1;
    }
     /*
     * Aditional Parameters
     */
    $gridParams = array(
    
    'width' => 480,
    'height' => 360,
    'rp' => 15,
    'newp'=>$getPage,
    'rpOptions' => '[10,15,20,25,40]',
    'pagestat' => '{from} to {to} of {total}',
    'blockOpacity' => 0.5,
    'title' => 'List of PWH',
    'singleSelect'=> true,
    
    'showTableToggleBtn' => false
    );   
        
     
     /*
     * 0 - display name
     * 1 - bclass
     * 2 - onpress
     */
     $buttons=array();
     $buttons[] = array('separator');
     
     $buttons[] = array('Select All','add','call_user_function');
    /*$buttons[] = array('Delete','delete','test');
    
    $buttons[] = array('Select All','add','test');
    $buttons[] = array('DeSelect All','delete','test');
    $buttons[] = array('separator');*/
     
     //Build js
    //View helpers/flexigrid_helper.php for more information about the params on this function
    $this->template->write('pageheader', 'PWH List');
    $this->template->add_js('js/flexigrid.pack.js','import');
     $this->template->add_css('styles/flexigrid.css');
    $grid_js = build_grid_js('flex1',site_url("/managepatient/ajaxcall"),$colModel,'patient_first_name','asc',$gridParams,$buttons);
   
   $this->template->add_js('
   $(function(){
   		$("#clickme").click(function () { 
   			alert();
			
	    });
   
   });
   function rowClick(celDiv, id){
      $(celDiv).click(
        function() {
         // alert(id);
          $.ajax({
            url: "/managepatient/details_pwh_dashboard/"+id,
            success: function(data) {
               var testobj=$.parseJSON(data);
              
              $("#pwh_resultdetails").html(testobj.pwh_details);
              
              if (typeof window.bindcontrols==="undefined"){
               var scriptobj   = document.createElement("script");
              scriptobj.type  = "text/javascript";
            
           // scriptobj.text  = testobj.jsnhrscript;              // use this for inline script
          //  document.body.appendChild(scriptobj);
             // $("#nhrdynamicjs").html(scriptobj);
              
           //    eval(testobj.nhrcallfunc);
              
             }  
          }
        });
        }
      )
    }
    function call_user_function(com,grid)
    {
      if (com=="Select All")
      {
        $(".bDiv tbody tr",grid).addClass("trSelected");
      }
    
      if (com=="DeSelect All")
      {
        $(".bDiv tbody tr",grid).removeClass("trSelected");
      }
    
      if (com=="Delete")
        {
           if($(".trSelected",grid).length>0){
             if(confirm("Delete " + $(".trSelected",grid).length + " items?")){
                  var items = $(".trSelected",grid);
                  var itemlist ="";
                  itemlist+= items[i].id.substr(3)+",";
              }
          $.ajax({
             type: "POST",
             url: "",
             data: "items="+itemlist,
             success: function(data){
              $("#flex1").flexReload();
              alert(data);
             }
          });
        }
      } else {
        return false;
      } 
        }   
   
   
   ', 'embed');
        
       // $this->template->write('js_grid', $grid_js);
   // $data['grid_js'] = $grid_js;
   //$this->template->write('pageheader1', 'upload profile photo');
       //FlexGrid Data Ends Here
      $data['topnavlinks']='<div class="topnewright"><a 
        href="'.base_url().'managemembers/patient_addform">Add New PWH</a></div>';
     
       $data['grid_js']=$grid_js;
        
       $this->template->write_view('content','members/flexlist_member',$data, True);
        $this->template->render(); 
    //      $this->load->view('testview',$data);
  }
	
		
  function chapterAdminList(){
    $retvalue='';
    if ($this->session->userdata('group')==1){
      
      $this->load->model('chapter_model','mdchapters');
      $chapterlist=$this->mdchapters->get_chapterlist();
      $chaparray=$this->load->helper('form');
      $droparray=array();
      $droparray['0']='--Select--';
      print_r($chaparray);
      foreach($chapterlist as $row){
        $droparray[$row['chapter_ID']]=$row['chapter_name'];
      }
    $retvalue=form_dropdown('selechapter', $droparray);
    }
    return $retvalue;
  }
  
  
} 
 ?>