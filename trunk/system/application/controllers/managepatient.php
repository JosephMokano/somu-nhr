<?php 
class managepatient extends Controller {

	function managepatient() {
        	parent::Controller();
          $this->load->library('session');
         
      //$this->template->add_css('styles/form.css');
     
      $this->template->write_view('header','header',$this->session->userdata('headerdata'), True);
	}
	function index() {	
		
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
	 $techChapterName='';
	 $backlinktechadmin='';
       if ($this->session->userdata('group')==10){
       	$retvalue=getChapterNamefordisplay($this->session->userdata('chapter'));
       	$techChapterName=$retvalue->chapter_name;
       	$backlinktechadmin='<a href="'.$this->config->item('base_url').'datamanage/chaptersnapshot">[ Back to Chapters List ]</a>';
       }
    
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
    'title' => 'List of PWH - '.$techChapterName,
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
      
      $data['topnavlinks']='<div class="topnewright">'.$backlinktechadmin.' &nbsp;<a 
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
	function patient_listdata1($pageNumber=0){
		
		$this->load->database();
		$this->load->library('pagination');
		$this->load->library('session');
		
		//Get Total Number of Records		
		$query1 = $this->db->query("Select count(patient_ID) as totalrows from tbl_pat_personal where chap_id='".$this->session->userdata('chapter')."'");
		$result1 = $query1->result_array();
		
		$rec_perpage=15;
		$config['base_url'] = $this->config->item('base_url').'homepage/patient_listdata/';
		$config['total_rows'] = $result1[0]["totalrows"];
		$config['per_page'] =$rec_perpage;
	
		$sqlquery="Select * from tbl_pat_personal where chap_id='".$this->session->userdata('chapter')."' order by patient_ID desc limit ".$pageNumber.",".$rec_perpage."";
		$result=$this->db->query($sqlquery);
	
	  $displaylist='';
		$displaylist.='<div class="tableheading">List of PWH';
    $displaylist.='<div class="topnewright"><a href="patient_form">Add New</a></div></div>';
    $displaylist .='<table cellpadding="0" cellspacing="0" width="100%">';
    $displaylist .='<tr><td width="50%">';
		$displaylist.='<table border="0" width="99%" class="memberList">';
		$displaylist.='<tr>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='Sl. no';
		$displaylist.='</th>';
		//$displaylist.='<th rowspan="2">';
		//$displaylist.='Reg No';
		//$displaylist.='</th>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='Name';
		$displaylist.='</th>';
		$displaylist.='<th colspan="2">';
		$displaylist.='Factor';
		$displaylist.='</th>';
	 //$displaylist.='<th rowspan="2">';
	//$displaylist.='Deformity';
	//$displaylist.='</th>';
	//$displaylist.='<th rowspan="2">';
	//$displaylist.='Inhibitor';
	//$displaylist.='</th>';
	//$displaylist.='<th rowspan="2">';
	//$displaylist.='Clinical';
	//$displaylist.='</th>';
	//$displaylist.='<th rowspan="2">';
	//$displaylist.="View";
	//$displaylist.='</th>';
	//$displaylist.='<th rowspan="2">';
	//$displaylist.="Upload";
	//$displaylist.='</th>';
		$displaylist.='</tr>';
		
		$displaylist.='<tr>';
		$displaylist.='<th>Deficiency';
		$displaylist.='</th>';
		$displaylist.='<th>Level';
		$displaylist.='</th>';
		$displaylist.='</tr>';
		$i=$pageNumber;
		foreach($result->result_array() as $row){
			$displaylist.='<tr>';
			$displaylist.='<td align="center">';
			$i++;
			$displaylist.=$i;
			$displaylist.='</td>';
			//$displaylist.='<td>';
			//$displaylist.='<a href="patient_form/'.$row['patient_ID'].'">'.$row['patient_effected_nhrid'].'</a>';
			//$displaylist.='</td>';
			$displaylist.='<td>';
			//$displaylist.='<a href="'.$this->config->item('base_url').'homepage/patient_form/'.$row['patient_ID'].'">'.$row['patient_first_name'].' '.$row['patient_last_name'].'</a>';
			$displaylist.='<a href="#" id="'.$row['patient_ID'].'" class="pwhdetailslink">'.$row['patient_first_name'].' '.$row['patient_last_name'].'</a>';
			$displaylist.='</td>';
			$displaylist.='<td align="center">';
			$displaylist.=$row['patient_factor_deficient'];
			$displaylist.='</td>';
			$displaylist.='<td align="center">';
			$displaylist.=$row['patient_factor_level'];
			$displaylist.='</td>';
		/*	if($row['patient_Deformity']=='1'){
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/deformity_blue.jpg"/>';
				$displaylist.='</td>';
			}else{
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/deformity_grey.jpg"/>';
				$displaylist.='</td>';
			}
			if($row['patient_inhibitor_screen']=='1'){
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/inhibitors_orange.jpg"/>';
				$displaylist.='</td>';
			}else{
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/inhibitors_grey.jpg"/>';
				$displaylist.='</td>';
			}
			$displaylist.='<td>';
			//$displaylist.=$row['commu_cellnumber'];
			$displaylist.='</td>';//abheshik roll no 61 sainic shcol kodagu kudige post 571232 kodagu distric somarpet taluk
			$displaylist.='<td align="center">';//pavan pawar roll no 32 8th cls sainic shol kodagu kudige distric
			$displaylist.='<!--<a href="'.$this->config->item('base_url').'homepage/pwhview/'.$row['patient_ID'].'">-->view<!--</a>-->';
			$displaylist.='</td>';
			$displaylist.='<td align="center">';
			$displaylist.='upload';
			$displaylist.='</td>';*/
			$displaylist.='</tr>';
			
		}
		$displaylist.='</table>';
    $displaylist .='</td><td width="50%">';
    $displaylist .='<div id="pwh_resultdetails"></div>';
    $displaylist .='</td></tr></table>';
		$displaylist.='<br/><br/>';
		$displaylist.='<div class="paginationstyle">';
		$this->pagination->initialize($config);
		$displaylist.=$this->pagination->create_links();
		$displaylist.='</div>';	
		
		if($this->session->userdata('group')==2){
			$this->load->library('session');
			$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
			$result = $query->row_array();
			
			$headerdata = array(
				//'chapterName' => 0,
				'chapterName' => $result['chapter_name'],
				'username' => $this->session->userdata('username')
				);
			$this->template->write_view('header','header',$headerdata, True);
			
			$data= array('formdisplay'=>$displaylist);
			
			$this->template->write('pageheader', 'Members List ');
			$this->template->write_view('content','members/list_member',$data, True);
      
      //Ajax Call for details
      
      //for tooltip
    $this->template->add_js('$(document).ready(function() {
        
       
        $(".memberList tr:even").css("background-color", "#E8E8E8");
        
        $(".pwhdetailslink").click(function() {
          var clickValue=$(this).attr(\'id\');
         var pagenumber=$(".pcontrol input").val();
         $.ajax({
            url: "'.base_url().'homepage/details_pwh_dashboard/"+clickValue+"/"+pagenumber,
            success: function(data) {
              // $("#pwh_resultdetails").html(data);
              $("#pwh_resultdetails").html(testobj.pwh_details);
          }
        });
         
         
          
        });
        
        });
        
       
        function updatedata(){
          var chkValue=$("#tracedmode:checked").val();
          var clickID=$("#selectedid").val();
          //alert("I am clicked selectedid: "+chkValue+" "+clickID);
          if (chkValue=="on"){
          $.post("'.base_url().'homepage/details_pwh_dashboard", { selectedid: clickID },
            function(data){
              
            });          
          }
          
        }
        
      ', 'embed');
      
      
			$this->template->render();
		}else{
			$display="<div align='center'>Session expired please <a href='".$this->config->item('base_url')."'>login</a> again</div>";
			$this->data['content']=$display;
			
			$this->load->view('normalview',$this->data);
		}
	}
  function  details_pwh_dashboard($id=0){
    //fetch data from database
    $this->load->database();     
    
    $pwh_query = $this->db->query("Select *  from tbl_pat_personal where patient_ID=".$id);
    $pwh_result = $pwh_query->result_array();
    $pwh_result=$pwh_result[0];
    $pwh_details='';
    $pwh_details='<div class="ui-accordion-header ui-state-default ui-corner-all nhrpaneltitle" style="margin:5px 0px">PWH Details</div>';
    $pwh_details.='<table width="100%" class="pwhdetails" border="0">';

    $pwh_details.='<tr>';
    $pwh_details.='<th>Name:</th>';
    $pwh_details.='<td>'.$pwh_result['patient_first_name'].' '.$pwh_result['patient_last_name'].'</td>';
    $pwh_details.='<td rowspan="5" class="pwhimage" style="border-bottom:1px solid #CCCCCC"><img src="'.$this->config->item('base_url').'images/miss_image.gif"/>
     <button style="width:100%" >Uload Photo</button>
    </td>';
    $pwh_details.='</tr>';

    $pwh_details.='<tr>';
    $pwh_details.='<th>Father/Gaurdin:</th>';
    $pwh_details.='<td>'.$pwh_result['patient_father_name'].'</td>';
   
    $pwh_details.='</tr>';
    
    $pwh_details.='<tr>';
    $pwh_details.='<th>Clinical:</th>';
    $otherFactorInfoTemp=otherfactors($pwh_result['patient_factor_defother']);
    $otherFactorInfoTemp=empty($otherFactorInfoTemp)?'':'/ '.$otherFactorInfoTemp;
    $factorinfo=factordeficiencyreturn($pwh_result['patient_factor_deficient']).$otherFactorInfoTemp;
    $pwh_details.='<td>Factor - '.$factorinfo.', '.$pwh_result['patient_factor_level'].', '.bloodgroupretrun($pwh_result['patient_bloodgroup']).'</td>';
    $pwh_details.='</tr>';
    
    $pwh_details.='<tr>';
    $pwh_details.='<th>Address:</th>';
    $pwh_details.='<td>';
    $pwh_details.=$pwh_result['comm_flat'].' '.$pwh_result['comm_building'].'<br/>';
    $pwh_details.=$pwh_result['commu_road'].' '.$pwh_result['commu_locality'].'<br/>';
    $pwh_details.=$pwh_result['commu_city'].'-'.$pwh_result['commu_pincode'].'<br/>';
    $pwh_details.=$pwh_result['commu_state'].'<br/>';
    $pwh_details.='</td>';
    $pwh_details.='</tr>';
    $this->load->helper('form');
    $pwh_details.='<tr>';
    $pwh_details.='<th style="border-bottom:1px solid #CCCCCC">Phone:</th>';
    $pwh_details.='<td style="border-bottom:1px solid #CCCCCC">'.$pwh_result['commu_phone'].' '.$pwh_result['commu_cellnumber'].'</td>';

    $pwh_details.='</tr>';
    $buttonlink=array();
    $buttonlink[]=base_url().'homepage/patient_form/'.$pwh_result['patient_ID'];
    $buttonlink[]=base_url().'managemed/med_list/'.$pwh_result['patient_ID'];
    $buttonlink[]=base_url().'manageclinical/list_clinical/'.$pwh_result['patient_ID'];
    $buttonlink[]=base_url().'managepatient/downloadpwdhform/'.$pwh_result['patient_ID'];
    $buttonlink[]=base_url().'communication/pwhsendmail/'.$pwh_result['patient_ID'];
    $buttonlink[]=base_url().'communication/sendmessage/'.$pwh_result['patient_ID'];
    $pwh_details.='<tr>
      <td></td>
      <td colspan="2">
      
       <a href="'.$buttonlink[0].'"><button id="pwhdataedit"><span class="ui-icon ui-icon-folder-open nhrIcon"></span>Edit</button></a>
       &nbsp;&nbsp;
      <a href="'.$buttonlink[1].'"><button id="managemed"><span class="ui-icon ui-icon-document nhrIcon"></span>Medicine Log</button></a>
     
     <a href="'.$buttonlink[2].'"> <button id="manageclinical"><span class="ui-icon ui-icon-contact nhrIcon"></span>Clinical</button></a>
      </td>
    </tr>';
    $pwh_details.='<tr>
    
      <td colspan="3">
      &nbsp;&nbsp;<a href="'.$buttonlink[3].'"><button id="pwhdataedit"><span class="ui-icon ui-icon-folder-open nhrIcon"></span>Download NHR Form</button></a>
      &nbsp;&nbsp;<a href="'.$buttonlink[4].'"><button id="pwhdataedit"><span class="ui-icon ui-icon-folder-open nhrIcon"></span>Send Mail</button></a>
     &nbsp;&nbsp; <a href="'.$buttonlink[5].'"><button id="pwhdataedit"><span class="ui-icon ui-icon-folder-open nhrIcon"></span>Send SMS</button></a>
      </td>
    </tr>';
    $pwh_details.='</table>';
   
    /*$pwh_details.='<div class="pwhnavigation">';
    $pwh_details.='<a href="#"><img src="'.$this->config->item('base_url').'images/medicinelog.jpg" /></a>';
    $pwh_details.='<a href="#"><img src="'.$this->config->item('base_url').'images/deformity.jpg" /></a>';
    $pwh_details.='<a href="#"><img src="'.$this->config->item('base_url').'images/clinicaldata.jpg" /></a>';
    $pwh_details.='<a href="#"><img src="'.$this->config->item('base_url').'images/modifydata.jpg" /></a>';
    $pwh_details.='</div>';*/
      $retData['pwh_details']=$pwh_details;
     $retData['jsnhrscript']='
      
        function bindcontrols(){
        //  alert("am called");
        /*  $(\'#pwhdataedit\').bind(\'click\', function() {
        	var pagenumber=$(".pcontrol input").val();
            window.location.replace("'.base_url().'homepage/patient_form/'.$pwh_result['patient_ID'].'");
        
          });
          $(\'#managemed\').bind(\'click\', function() {
            window.location.replace("'.base_url().'managemed/med_list/'.$pwh_result['patient_ID'].'");
        
          });
          $(\'#manageclinical\').bind(\'click\', function() {
            window.location.replace("'.base_url().'manageclinical/list_clinical/'.$pwh_result['patient_ID'].'");
        
          });*/
          
        }
      
     ';
     $retData['nhrcallfunc']='bindcontrols()';
    // $retData=array('a'=>'hello','b'=>'hi');
    $jsonObj= json_encode($retData);
    echo $jsonObj;
  }
	
	
	function profilephoto($pwhid){
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');

		$attr='enctype="multipart/form-data"';
		$display=form_open('homepage/uploadprofilepic',$attr);

		$display.='<table align="center">';
		
		$display.='<tr>';
		$display.='<td> Upload profile picture :';
		$display.='</td>';
		$display.='<td>';
		$txtformElement=array(
			'id'=>'profilepicname',
			'name'=>'profilepicname',
			'size'=>'40'
			);
		$display.=form_upload($txtformElement);
		$data = array(
			'pwnval' => $pwhid
			);
		$display.=form_hidden($data);
		$display.='</td>';
		$display.='</tr>';

		$display.='<tr>';
		$display.='<td colspan="2" align="center">';
		$data = array(
			'id'  => 'upload',
			'name'  => 'upload',
			'value'	=> 'upload',
			);
		$display.=form_submit('upload','upload');
		$display.='</td>';
		$display.='</tr>';
		$display.='</table>';
		
		$display.=form_close();	
		
		$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
		$result = $query->row_array();
		$headerdata = array(
			'chapterName' => 'Hemophilia Federation (India)',
			'username' => $this->session->userdata('username')
			);
		$this->template->write_view('header','header',$headerdata, True);
		
		$data= array('formdisplay'=>$display);
		$this->template->write('pageheader', 'upload profile photo');
		$this->template->write_view('content','members/list_member',$data, True);
        	$this->template->render();
	}

  //Flexgrid Ajax Call
  
  function ajaxcall($chapfilterid=0){
    $this->load->library('flexigrid');
      //List of all fields that can be sortable. This is Optional.
    //This prevents that a user sorts by a column that we dont want him to access, or that doesnt exist, preventing errors.
    $valid_fields = array('patient_id','patient_first_name','patient_factor_level');
    $this->load->helper('apputility');
    $this->flexigrid->validate_post('patient_id','asc',$valid_fields);
    $this->load->model('patient_ajax_model','ajax_model');
    if ($chapfilterid==0){
      $chapfilterid=$this->session->userdata('chapter');
    }
    
    $records = $this->ajax_model->get_patientlist($chapfilterid);
    
    $this->output->set_header($this->config->item('json_header'));
    
     $this->load->library("session");
     $this->session->set_userdata("gridpagenumber",$_POST['page']);
    
    /*
     * Json build WITH json_encode. If you do not have this function please read
     * http://flexigrid.eyeviewdesign.com/index.php/flexigrid/example#s3 to know how to use the alternative
     */
   
     
     
     $startValuePage=$_POST['rp']*($_POST['page']-1);
     $i=$startValuePage;
    foreach ($records['records']->result() as $row)
    {
      $i++;
      $record_items[] = array( $row->patient_id,
      $i,
      $row->patient_first_name,
      factordeficiencyreturn($row->patient_factor_deficient),
      $row->patient_factor_level,
      '<span class="pwh_detailscall">Details</span>'
      );
      
    }
    //Print please
    $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    
  }






	function uploadprofilepic(){
		$this->load->database();
		$this->load->library('upload');
		//echo $_POST['pwnval'];
// 		if(isset($_FILES['profilepicname'])){
// 			$file   = read_file($_FILES['profilepicname']['tmp_name']);
// 			$name   = basename($_FILES['profilepicname']['name']);
// 			write_file('profilepic/'.$name, $file);
// 			//updating into database
// 			$this->db->where('patient_ID', $_POST['pwnval']);
// 			$this->db->update();
// 		}
		$this->image_path = $this->config->item('base_url').'profilepic';
		//echo $this->config->item('abspro_path');exit;
		if ($this->input->post('upload')){
			$config = array(
				'allowed_types'=>'gif|jpg|png',
				'upload_path'=> $this->image_path
			);
			//$config['allowed_types'] = 'gif|jpg|png';
			//$config['max_size']	= '100';
			//$config['max_width']  = '1024';
			//$config['max_height']  = '768';
		}
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		//$this->upload->uploadprofilepic();
		/*if ( ! $this->homepage->uploadprofilepic())
		{
			$error = array('content' => 'errors in uploading');
			$this->load->view('normalview', $error);
		}	
		else
		{
			$data = array('content' => 'success');
			$this->load->view('normalview', $data);
		}*/
		//redirect('chapterdashboard');
		$this->patient_listdataadmin();
	}
	
	function listusers($pagenumber=0){
		$this->load->database();
		$this->load->library('session');
		//Pagination Module
		$this->load->library('pagination');
		$listdisplay='';
		
		$querytot=$this->db->query('select count(*) as totaluser from tbl_users');
		$totuser=$querytot->result_array();
		
		$rec_perpage=10;
		$config['base_url'] = $this->config->item('base_url').'homepage/listusers/';
		$config['total_rows'] = $totuser[0]["totaluser"];
		$config['per_page'] = $rec_perpage;
		$config['uri_segment'] = 3;
		
		$query=$this->db->query('select * from tbl_users limit '.$pagenumber.','.$rec_perpage.'');
		$uservar=$query->result_array();
	
		$listdisplay.='<table border="0" width="99%" cellpadding="4" cellspacing="2" class="memberList" id="memberslist">';
		$listdisplay.='<tr>';
		$listdisplay.='<th>sl no</th>';
		$listdisplay.='<th>Registered user</th>';
		$listdisplay.='<th>Chapter</th>';
		$listdisplay.='<th>Publish</th>';
		$listdisplay.='</tr>';
		$i=$pagenumber;
		
		foreach($uservar as $key=>$value){
			if($i%2):$color="odd";else: $color="even"; endif;
			$listdisplay.='<tr class="'.$color.'">';
			$i++;
			$listdisplay.='<td>'.$i.'</td>';
			
			$listdisplay.='<td>'.$uservar[$key]['username'].'</td>';
			$querychap=$this->db->query('select * from tbl_chapters where chapter_ID='.$uservar[$key]['chap_id'].'');
			$chapname=$querychap->result_array();
			$chaptername='';
			
			
				if(isset($chapname[0]['chapter_name'])==''){
					$chaptername='Super Administrator';
					$listdisplay.='<td>'.$chaptername.'</td>';
				}else{
					$chaptername=$chapname[0]['chapter_name'];
					$listdisplay.='<td>'.$chaptername.'</td>';
				}
			
			//print_r($chapname);
			
			
			$listdisplay.='<td align="center"><a href="#" onclick="publish_user('.$uservar[$key]['user_id'].')">';
			
			if($uservar[$key]['access_id']==1){
				$listdisplay.='<img id="publish" src="'.$this->config->item("base_url").'images/tick.png" style="border:none" />';
			}else{
				$listdisplay.='<img id="publish" src="'.$this->config->item("base_url").'images/unpublish.png"   style="border:none"/>';
			}
			$listdisplay.='</a></td>';
			$listdisplay.='</tr>';
		}
		$listdisplay.='</table>';
		$listdisplay.='<br/>';
		$listdisplay.='<div class="paginationstyle">';
		$this->pagination->initialize($config);
		$listdisplay.=$this->pagination->create_links();
		$listdisplay.='</div>';
		
		$data= array(
			'formdisplay'=>$listdisplay,
		);
		$headerdata = array(
			'username'=>$this->session->userdata('username'),
			'chapterName'=>'Hemophilia Federation (India)'
		);
		$this->template->add_js('js/un-publish.js','import');
		$this->template->write('pageheader', 'List of Users');
		$this->template->write_view('header','header',$headerdata, True);
		$this->template->write_view('content','members/list_member',$data, True);
		$this->template->render();
	}
	
	function downloadpwdhform($pwhid=22){
		$params=array('pwhid'=>$pwhid);
		$this->load->library('pdf_form',$params);
		$this->pdf_form->getpwhform($pwhid);
	}
	
	function downloadchapterforms($chapter_id=67){
		$params=array('pwhid'=>$chapter_id);
		$this->load->library('pdf_form',$params);
		$this->pdf_form->getchapterforms($chapter_id);
	}
	private function updateusernametemp(){
		$this->load->database();
		$qrydb=$this->db->query('select * from tbl_chapters where not (chapter_ID in (67,68))');
		$reparray=array('Hemophilia','Society','-','Chapter',',',' ','chapter','society','centre');
		foreach($qrydb->result() as $qrow){
			$tempname=str_replace($reparray, '', $qrow->chapter_name);
			$tempname=strtolower($tempname);
			echo $tempname.'<br/>';
			$dataArray=array(
				'username'=>$qrow->chapter_keyperson,
				'password'=>md5($tempname),
				'email_id'=>$tempname.'@hemophilia.in',
				'group_id'=>2,
				'access_id'=>1,
				'chap_id'=>$qrow->chapter_ID
			);
			$this->db->insert('tbl_users',$dataArray);
			
		}
	}

}
