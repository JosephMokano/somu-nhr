<?php
class search extends Controller {

	function search() {
        parent::Controller();
		$this->load->database();
		$this->load->library('session');
	}
	
	function index() {	
		$this->datasearch();
	}
	function hfireportvalue(){
	  $chapQuery="select * from tbl_chapters";
 $chapResults=$this->db->query($chapQuery);
    foreach($chapResults->result_array() as $row){
      echo $row['chapter_name']."<br>";
     // $tempString=preg_replace($patmatch,$repString,$orgString);
      
       $data=array(
        'chap_id'=>$row['chapter_ID']
       );
       $this->db->insert('tbl_hfirefrence', $data); 
    }
	}
  function listhfiupdate(){
    $chapQuery="SELECT a.chapter_id,a.chapter_name,b.pwh_count,b.livemode,b.hfichap_id,a.chapter_zone
    FROM tbl_chapters a left join tbl_hfirefrence 
    b on a.chapter_ID=b.chap_id order by a.chapter_zone, a.chapter_name";
    $zonearray=array('','North','West','East','South');
    $chapResults=$this->db->query($chapQuery);
    $dispobj='';
    $dispobj.='<table>';
    $dispobj.="<tr><th>Slno</th><th>Chapter Name</th><th>Count</th><th>Mode</th></tr>";
    
    $tmpZone=0;
    foreach($chapResults->result_array() as $row){
      if ($tmpZone!=$row['chapter_zone']){
        $tmpZone=$row['chapter_zone'];
         $dispobj.='<tr><td colspan="4" style="background-color:#cccccc">'.$zonearray[$tmpZone].'</td></tr>';
         $i=1;
      }
      $dispobj.='<tr>';
      $dispobj.='<td>'.$i.'</td>';
      $dispobj.='<td><a href="hfishowform/'.$row['hfichap_id'].'">'.$row['chapter_name'].'</a></td>';
      $dispobj.='<td>'.$row['pwh_count'].'</td>';
      $dispobj.='<td>'.$row['livemode'].'</td>';
      $dispobj.='</tr>';
      $i++;
    }
    $dispobj.='</table>';
    $headerdata='';
    $data=array('formdisplay'=>$dispobj,'chapterName'=>'');
      $this->template->write('pageheader', 'Search');
      //$this->template->write_view('header','header',$headerdata, True);
      $this->template->write_view('content','members/list_member',$data, True);
      $this->template->render();
  }
  function hfishowform($rowid=0){
    $selHfiQry=$this->db->query('select * from tbl_hfirefrence where hfichap_id='.$rowid);
    $hfiRow=$selHfiQry->row_array();
   // echo $hfiRow['chap_id'];
    $selQry=$this->db->query('select * from tbl_chapters where chapter_ID='.$hfiRow['chap_id']);
    $chapRow=$selQry->row_array();
    $this->load->helper('form');
    $formdisplay='';
    $formdisplay.='<table>';
    
    $formdisplay.=form_open('search/updatehfiform');
    $formdisplay.='<tr><th>Chapter Name</th>';
    $formdisplay.='<th>'.$chapRow['chapter_name'].'</th></tr>';
    $formdisplay.='<tr><th>Count Provided</th>';
    $formdisplay.='<td><input type="text" name="pwhcount" value="'.$hfiRow['pwh_count'].'"/></td></tr>';
    $formdisplay.='<tr><th>Published</th>';
    $chkvar='';
    $hfiRow['livemode']==1?$chkvar='checked':$chkvar;
    $formdisplay.='<td><input type="checkbox" name="livemode" '.$chkvar.' /></td></tr>';
    $formdisplay.='<tr><td></td><td><input type="submit" /></td></tr>';
    $formdisplay.='<input type="hidden" value="'.$rowid.'" name="hfirowid"/>';
    $formdisplay.=form_close();
    $formdisplay.='</table>';
   $data=array('formdisplay'=>$formdisplay,'chapterName'=>'');
      $this->template->write('pageheader', 'Search');
      //$this->template->write_view('header','header',$headerdata, True);
      $this->template->write_view('content','members/list_member',$data, True);
      $this->template->render();
  }
  function updatehfiform(){
   // print_r($_POST);
    $livemode=$_POST['livemode']=='on'?1:0;
    $data=array(
      'pwh_count'=>$_POST['pwhcount'],
      'livemode'=>$livemode
    );
    $this->db->where('hfichap_id', $_POST['hfirowid']);
    $this->db->update('tbl_hfirefrence', $data); 
    redirect('/search/listhfiupdate');
  }
	function datasearch(){		
	
		$this->session->unset_userdata('searchQueryArray');
		$this->load->helper('form');
		
		$formdisplay=form_open('search/searchresult');
		$formdisplay.='<h2 align="center">Search</h2>';
		$formdisplay.='<table align="center">';
		
		$formdisplay.='<tr>';
		$formdisplay.='<td> Enter Name :';
		$formdisplay.='</td>';
		$formdisplay.='<td>';
			$txtformElement=array(
				'id'=>'name',
				'name'=>'name',
				'size'=>'40',
				'value'=>'',
				'alt'=>'Title' );
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
    
   /*   $formdisplay.='<tr>';
    $formdisplay.='<td> Fathers Name :';
    $formdisplay.='</td>';
    $formdisplay.='<td>';
      $txtformElement=array(
        'id'=>'fname',
        'fname'=>'fname',
        'size'=>'40',
        'value'=>'',
        'alt'=>'Title' );
    $formdisplay.=form_input($txtformElement);
    $formdisplay.='</td>';
    $formdisplay.='</tr>';*/
		
		$formdisplay.='<tr>';
		$formdisplay.='<td> Factor Deficiency :';
		$formdisplay.='</td>';
		$formdisplay.='<td>';
		$this->load->helper('dropdown');
		//$Mulattr=test_method(1);
		$Mulattr='id="factor" class=""';
			$txtformElement=array(
				'1' => 'I Fibrinogen',
				'2' => 'II Prothrombin',
				'3' => 'III Tissue Factor',
				'4' => 'VI Calcium',
				'5' => 'V Proaccelerin, labile factor',
				'6' => 'VI',
				'7' => 'VII Stable Factor',
				'8' => 'VIII Anti Hemophilic Factor A',
				'9' => 'IX Anti Hemophilic Factor B or Christmas Factor',
				'10' => 'X Stuart-Prower Factor',
				'11' => 'XI Plasma Thromboplastin Antecedent)',
				'12' => 'XII Hageman Factor',
				'13' => 'XIII Fibrin-Stabilizing Factor',
				'14' => 'Others'
			);
			$formdisplay.=form_multiselect('factor[]',$txtformElement,0,'multiple',$Mulattr);
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
		
		$formdisplay.='<tr>';
		$formdisplay.='<td> Others :';
		$formdisplay.='</td>';
		$formdisplay.='<td>';
		$Mulattr='id="other" class=""';
			$txtformElement=array(
				'1'=>'Von Willebrand',
				'2'=>'Glanzmann',
			);
			$formdisplay.=form_multiselect('other[]',$txtformElement,0,'multiple',$Mulattr);
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
		
		$formdisplay.='<tr>';
		$formdisplay.='<td> Severity :';
		$formdisplay.='</td>';
		$formdisplay.='<td>';
			$txtformElement=array(
				'0'=>'select',
				'1'=>'severe',
				'2'=>'modrate',
				'3'=>'mild',
			);
			$formdisplay.=form_dropdown('severe',$txtformElement);
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
			
		if($this->session->userdata('group')==1){
		$query = $this->db->query('SELECT chapter_ID,chapter_name FROM tbl_chapters');
		$resultarray=array(
			'0'=>'Select'
		);
		$attr='id="chapters"';
		foreach ($query->result() as $row)
		{
			$resultarray[$row->chapter_ID]=$row->chapter_name;
		}
		$formdisplay.='<tr>';
		$formdisplay.='<td> Chapters :';
		$formdisplay.='</td>';
		$formdisplay.='<td>';
			$formdisplay.=form_dropdown('chapters',$resultarray);
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
		}
		
		$formdisplay.='<tr>';
		$formdisplay.='<td colspan="2" align="center">';
			$data = array(
			'id'  => 'mysubmit',
			'name'  => 'mysubmit',
			'value'	=> 'Send',
			'style'   => 'visibilty:hidden'
			);
		$formdisplay.=form_submit($data);
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
		
		$formdisplay.='<tr>';
		$formdisplay.='<td colspan="2">';
			
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
		
		$formdisplay.='</table>';
		$formdisplay.=form_close();
		
		if($this->session->userdata('group')==1){
			$data= array(
				'formdisplay'=>$formdisplay,
			);
			$headerdata = array(
				'username'=>$this->session->userdata('username'),
				'chapterName'=>'Hemophilia Federation (India)'
			);
			
			$this->template->write('pageheader', 'Search');
			$this->template->write_view('header','header',$headerdata, True);
			$this->template->write_view('content','members/list_member',$data, True);
			$this->template->render();
		}else if($this->session->userdata('group')==2){
			$data= array(
				'formdisplay'=>$formdisplay,
			);
			$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
			$result = $query->row_array();
			//print_r($result);
			$headerdata = array(
				'username'=>$this->session->userdata('username'),
				'chapterName'=>$result['chapter_name']
			);
			
			$this->template->write('pageheader', 'Search');
			$this->template->write_view('header','header',$headerdata, True);
			$this->template->write_view('content','members/list_member',$data, True);
			$this->template->render();
		}else{
			$display="<div align='center'>Session expired please <a href='".$this->config->item('base_url')."'>login</a> again</div>";
			$this->data['content']=$display;
			
			$this->load->view('normalview',$this->data);
		}
	}
	function redirectToSearch(){
		$formdisplay='<div align="center">No Data selected to search <a href="'.$this->config->item('base_url').'search/datasearch">Back</a> to Search</div>';
		$data= array(
			'formdisplay'=>$formdisplay,
		);
		$headerdata = array(
			'username'=>$this->session->userdata('username'),
			'chapterName'=>'Hemophilia Federation (India)'
		);
		$this->template->write('pageheader', 'Search');
		$this->template->write_view('header','header',$headerdata, True);
		$this->template->write_view('content','members/list_member',$data, True);
		$this->template->render();
	}
	function buildSearchQuery($searchKey,$searchValue){
		if($searchKey=='patient_first_name'){
			$retrimStatement=" (".$searchKey." like ('%".$searchValue."%'))";
		}else if ($searchKey==is_array($searchValue)){
			$factor=implode($searchValue,",");
			$retrimStatement="(".$searchKey." in (".$factor."))";
		}else if ($searchKey=='patient_factor_level'){
			switch ($searchValue) {
				case 0:
				$retrimStatement="";
				break;
				case 1:
				$retrimStatement= "(".$searchKey."<1)";
				break;
				case 2:
				$retrimStatement="patient_factor_level>=1 and patient_factor_level<6";
				break;
				case 3:
				$retrimStatement="patient_factor_level>6";
				break;
			}
		}else{
			$retrimStatement="(".$searchKey."='".$searchValue."')";
		}
		return $retrimStatement;
	}
	function searchresult($pagenumber=0){
		$this->load->database();
		$this->load->library('session');
		//Pagination Module
		$this->load->library('pagination');
		$queryArray=array();
		$searchQueryArray=$this->session->userdata('searchQueryArray');
		
		if($this->session->userdata('group')==1){
			if ((count($_POST)==4)&&(empty($_POST['name']))&&($_POST['severe']==0)&&($_POST['chapters']==0)){
				//User here 
				$this->load->helper("url");
				$tempVer=$this->config->item('base_url')."search/redirectToSearch";
				redirect($tempVer);
			}
			if (!(is_array($searchQueryArray))){
				$queryArray['patient_first_name']=isset($_POST['name'])?$_POST['name']:'';
				$queryArray['patient_factor_level']=isset($_POST['severe'])?$_POST['severe']:'';
				$queryArray['patient_factor_defother']=isset($_POST['other'])?$_POST['other']:'';
				$queryArray['patient_factor_deficient']=isset($_POST['factor'])?$_POST['factor']:'';
				
				$queryArray['chap_id']=isset($_POST['chapters'])?$_POST['chapters']:'';
				
				$this->session->set_userdata('searchQueryArray',$queryArray);
				unset($_POST);
			}else{			
				$queryArray=$this->session->userdata('searchQueryArray');			
			}
		}else if($this->session->userdata('group')==2){
			if((count($_POST)==3)&&(empty($_POST['name']))&&($_POST['severe']==0)){
				$this->load->helper("url");
				$tempVer=$this->config->item('base_url')."search/redirectToSearch";
				redirect($tempVer);
			}
			if (!(is_array($searchQueryArray))){
				$queryArray['patient_first_name']=isset($_POST['name'])?$_POST['name']:'';
				$queryArray['patient_factor_level']=isset($_POST['severe'])?$_POST['severe']:'';
				$queryArray['patient_factor_defother']=isset($_POST['other'])?$_POST['other']:'';
				$queryArray['patient_factor_deficient']=isset($_POST['factor'])?$_POST['factor']:'';
				$this->session->set_userdata('searchQueryArray',$queryArray);
				unset($_POST);
			}else{			
				$queryArray=$this->session->userdata('searchQueryArray');			
			}
		}
		
		$searchStatement='';
		foreach ($queryArray as $searchKey=>$searchValue){
			if (!empty($queryArray[$searchKey])){
				if (empty($searchStatement)){
					$searchStatement=$this->buildSearchQuery($searchKey,$searchValue);
				}else{
					$searchStatement.=' and ('.$this->buildSearchQuery($searchKey,$searchValue).')';	
				}
			}
		}
		
		//echo $searchStatement;exit;
		
		/*if (isset($_POST)&&count($_POST)>0){
			$name=$_POST['name'];
			isset($_POST['factor'])?$factor=$_POST['factor']:$factor='';
			isset($_POST['other'])?$other=$_POST['other']:$other='';
			$severe=$_POST['severe'];
			$chapterid=$_POST['chapters'];
		}else{
			$name=$this->session->userdata('patname');
			$factor=$this->session->userdata('factorids');
			$other=$this->session->userdata('other');
			$severe=$this->session->userdata('severity');
			$chapterid=$this->session->userdata('chapid');
		}
		
		if($name!=''){
			$namesearch= " patient_first_name like '%".$name."%'";
			//echo $name;
			$this->session->set_userdata('patname',$namesearch);
		}
		//echo $this->session->userdata('patname');
		if (is_array($factor)){
			$factor=implode($factor,",");
			$factorids= " and patient_factor_deficient in (".$factor.")";
			//echo $factorids;
			$this->session->set_userdata('factorids',$factorids);
		}	
		
		if (is_array($other)){
			$factor=implode($other,",");
			
			$other= " and patient_factor_defother in (".$other.")";
			$this->session->set_userdata('other',$other);
		}
		if($severe == 0){
			
		}
		if($severe == 1){
			$severity= " and patient_factor_level<1";
			$this->session->set_userdata('severity',$severity);
		}
		if($severe == 2){
			$severity= " and patient_factor_level>1 and patient_factor_level<6";
			$this->session->set_userdata('severity',$severity);
		}
		if($severe == 3){
			$severity= " and patient_factor_level>6";
			$this->session->set_userdata('severity',$severity);
		}
		
		if($chapterid != 0){
			$chapid= " and chap_id =".$chapterid."";
			$this->session->set_userdata('chapid',$chapid);
		}*/
		//to fetch chapeter id for chapter search
		$chpqury=$this->db->query("SELECT * from tbl_users where user_id=".$this->session->userdata('userid')."");
		$chapary=$chpqury->result_array();

			if($this->session->userdata('group')==1){
				//echo 'im here in one';
				$query_count=$this->db->query("SELECT count(patient_id) as patcount FROM tbl_pat_personal where ".$searchStatement."");
				//echo "SELECT count(patient_id) as patcount FROM tbl_pat_personal where".$searchStatement."";
			}else if($this->session->userdata('group')==2){
				//echo 'im here in two';
				$query_count=$this->db->query("SELECT count(patient_id) as patcount FROM tbl_pat_personal where chap_id=".$chapary[0]['chap_id']." and ".$searchStatement."");
				//echo "SELECT count(patient_id) as patcount FROM tbl_pat_personal where chap_id=58 and ".$searchStatement."";
			}
			$qryResultCount = $query_count->result_array();

			$rec_perpage=15;
			$config['base_url'] = $this->config->item('base_url').'search/searchresult/';
			$config['total_rows'] = $qryResultCount[0]["patcount"];
			$config['per_page'] = $rec_perpage;
			$config['uri_segment'] = 3;
			
			if($this->session->userdata('group')==1){
				$query=$this->db->query("SELECT * FROM tbl_pat_personal where ".$searchStatement." limit ".$pagenumber.",".$rec_perpage."");
			}else if($this->session->userdata('group')==2){
				$query=$this->db->query("SELECT * FROM tbl_pat_personal where chap_id=".$chapary[0]['chap_id']." and ".$searchStatement." order by patient_ID desc limit ".$pagenumber.",".$rec_perpage."");
			}
			$qryResult = $query->result_array();
			$i=$pagenumber;
			if ($qryResult==array()){
				$displaylist='<div align="center">No Data Exits. Try again. <a href="'.$this->config->item('base_url').'search/datasearch">Back</a> to Search</div>';
			}else if (!($qryResult==array())){
				$displaylist='<table border="0" width="99%" class="memberList">';
				$displaylist.='<tr>';
				$displaylist.='<th rowspan="2">';
				$displaylist.='Sl. no';
				
				$displaylist.='</th>';
				$displaylist.='<th rowspan="2">';
				$displaylist.='Reg No';
				$displaylist.='</th>';
				$displaylist.='<th rowspan="2">';
				$displaylist.='Name';
				$displaylist.='</th>';
				$displaylist.='<th colspan="2">';
				$displaylist.='Factor';
				$displaylist.='</th>';
				$displaylist.='<th rowspan="2">';
				$displaylist.='Deformity';
				$displaylist.='</th>';
				$displaylist.='<th rowspan="2">';
				$displaylist.='Inhibitor';
				$displaylist.='</th>';
				$displaylist.='<th rowspan="2">';
				$displaylist.="H's";
				$displaylist.='</th>';
				$displaylist.='<th rowspan="2">';
				$displaylist.='Clinical';
				$displaylist.='</th>';
				$displaylist.='</tr>';
				
				$displaylist.='<tr>';
				$displaylist.='<th>Deficiency';
				$displaylist.='</th>';
				$displaylist.='<th>Level';
				$displaylist.='</th>';
				$displaylist.='</tr>';
				
				foreach($query->result_array() as $row){
					if($i%4):$color="odd";else: $color="even"; endif;
					$displaylist.='<tr class="'.$color.'">';
					$displaylist.='<td align="center">';
					$i++;
					$displaylist.=$i;
					$displaylist.='</td>';
					$displaylist.='<td>';
					$displaylist.='<a href="patient_form/'.$row['patient_ID'].'">'.$row['patient_effected_nhrid'].'</a>';
					$displaylist.='</td>';
					$displaylist.='<td>';
					$displaylist.='<a href="'.$this->config->item('base_url').'homepage/patient_form/'.$row['patient_ID'].'"/>'.$row['patient_first_name'].' '.$row['patient_last_name'].'</a>';
					$displaylist.='</td>';
					$displaylist.='<td align="center">';
					$displaylist.=$row['patient_factor_deficient'];
					$displaylist.='</td>';
					$displaylist.='<td align="center">';
					$displaylist.=$row['patient_factor_level'];
					$displaylist.='</td>';
					if($row['patient_Deformity']=='1'){
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
					$displaylist.='</td>';
					$displaylist.='<td>';
					//$displaylist.=$row['commu_email'];
					$displaylist.='</td>';
					$displaylist.='</tr>';
					$i++;
				}
				$displaylist.='</table>';
				$displaylist.='<br/><br/>';
				$displaylist.='<div class="paginationstyle">';
				$this->pagination->initialize($config);
				$displaylist.=$this->pagination->create_links();
				$displaylist.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$this->config->item('base_url').'search/datasearch">Back to search</a>';
				$displaylist.='&nbsp;&nbsp;&nbsp;&nbsp;<span>total results '.$qryResultCount[0]["patcount"].'</span>';
				$displaylist.='</div>';
			}
		
		
		if($this->session->userdata('group')==1){
			$data= array(
				'formdisplay'=>$displaylist,
			);
			$headerdata = array(
				'username'=>$this->session->userdata('username'),
				'chapterName'=>'Hemophilia Federation (India)'
			);
			
			$this->template->write('pageheader', 'Dashboard');
			$this->template->write_view('header','header',$headerdata, True);
			$this->template->write_view('content','members/list_member',$data, True);
			$this->template->render();
		}else if($this->session->userdata('group')==2){
			$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
			$result = $query->row_array();
			$data= array(
				'formdisplay'=>$displaylist,
			);
			$headerdata = array(
				'username'=>$this->session->userdata('username'),
				'chapterName'=>$result['chapter_name']
			);
			
			$this->template->write('pageheader', 'Dashboard');
			$this->template->write_view('header','header',$headerdata, True);
			$this->template->write_view('content','members/list_member',$data, True);
			$this->template->render();
		}else{
			$display="<div align='center'>Session expired please <a href='".$this->config->item('base_url')."'>login</a> again</div>";
			$this->data['content']=$display;
			
			$this->load->view('normalview',$this->data);
		}
	}
}
?>