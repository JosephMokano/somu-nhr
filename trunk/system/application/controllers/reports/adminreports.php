<?php 
class adminreports extends Controller {

	function adminreports() {
	parent::Controller();
		$this->load->library('session');
	}
	function index() {
	}
	function listreports($reportname = '') {
		
		$reportlist = array(
			'chapter_report'=>'Chapter Reports', 
			'factor_report'=>'Factor Deficiency', 
			'severity_report'=>'Severity'
		);
		$reportList = '';
		$reportList .= '<table border="0" id="reporticons">';
			$reportList .= '<tr>';
			foreach ($reportlist as $key=>$value) {
				if($key=='chapter_report'){
					$reportList.='<td align="center"><a href="listreports/'.$key.'"><img src="'.$this->config->item("base_url").'images/reports-icon.png" /><br/>'.$value.'</a></td>';
				}else if($key=='factor_report'){
					$reportList.='<td align="center"><a href="listreports/'.$key.'"><img src="'.$this->config->item("base_url").'images/report2.png" /><br/>'.$value.'</a></td>';
				}else if($key=='severity_report'){
					$reportList.='<td align="center"><a href="listreports/'.$key.'"><img src="'.$this->config->item("base_url").'images/report1-icon.png" /><br/>'.$value.'</a></td>';
				}
			}
		$reportList .= '</tr>';
		$reportList .= '</table>';
		if ( empty($reportname)) {
			$reportsdisplay = $reportList;
			$data = array('reportsdisplay'=>$reportsdisplay);
			$pagetitle= 'List of Reports';
		} else {
			$arryKey=array_search($reportname,array_keys($reportlist)); 
			$pagetitle=$reportlist[$reportname];
			$reportsdisplay=$this->generateReport($arryKey);
			$data = array('reportsdisplay'=>$reportsdisplay);
		}
	
		$headerdata = array(
			'username'=>$this->session->userdata('username'),
			'chapterName'=>'Hemophilia Federation (India)'
		);
		$this->template->write('pageheader', $pagetitle);
		$this->template->write_view('header','header',$headerdata, True);
		$this->template->write_view('content', 'reports/adminreports', $data, True);
		$this->template->render();
	}
	function generateReport($reportType=-1){
		$reportsdisplay="Reports to be displayed";
		switch ($reportType){
			case 0:
				$repo_query='select 
				count(t1.chap_id) as pat_count,
				t1.chap_id as chap_id,
				t2.chapter_name as chap_name 
				from tbl_pat_personal t1 inner join tbl_chapters t2 
				on t1.chap_id=t2.chapter_id 
				group by t1.chap_id order by chap_name';
			break;
			case 1:
				$repo_query='select
				 count(t1.chap_id) as deficient_count,
				 patient_factor_deficient as factor 
				 from tbl_pat_personal t1 
				 group by patient_factor_deficient 
				 order by factor	
				';
			break;
			case 2:
				$repo_query='SELECT 
				SUM(CASE WHEN patient_factor_level<=1 THEN 1 ELSE 0 END) as severe,
				SUM(CASE WHEN patient_factor_level>1 and patient_factor_level<=5 THEN 1 ELSE 0 END) as modrate,
				SUM(CASE WHEN patient_factor_level>5
				THEN 1 ELSE 0 END) as mild from tbl_pat_personal';
			break;	
		}
		$this->load->model('reports/mod_adminreports', 'obj_adminreports');
		$result_report=$this->obj_adminreports->get_reportresults($repo_query);
		
		//Graph Display
		$displaygraph='<img src="'.$this->generategraph($reportType,$result_report).'" />';
	
		//Data set	
		$displaylist=$this->reprot_ui($result_report,$reportType);
		$retValue='<div style="text-align:right;background-color:#E6EEEE;margin:10px 0px;padding:5px;"><a href="'.$this->config->item("base_url").'reports/adminreports/listreports">Back</a> to Reports</div>';
		$retValue.='<table cellpadding="0" cellspacing="0" border="0" width="99%">';
		$retValue.='<tr>';
			$retValue.='<td width="55%">';
			$retValue.=$displaylist;
			$retValue.='</td>';
			$retValue.='<td>';
			$retValue.=$displaygraph;
			$retValue.='</td>';
		$retValue.='</tr>';
		$retValue.='</table>';
		$this->template->add_js('js/jquery.tablesorter.js','import');
		//Java script for Sorting
		$this->template->add_js('$(document).ready(function() { 
			$.tablesorter.defaults.widgets = ["zebra"]; 
			$.tablesorter.defaults.sortList = [[0,0]]; 
			$("#memberslist").tablesorter(); 
		}); ', 'embed');
		
		return $retValue;
	}
	function reprot_ui($result_report,$reportType){
		$displaylist='<table border="0" width="99%" class="memberList" id="memberslist">';
		$displaylist.='<thead>';
		switch ($reportType){			
			case 0:
			//Header part
			$displaylist.='<tr>';
			$displaylist.='<th>';
			$displaylist.='Sl.No';
			$displaylist.='</th>';
			$displaylist.='<th>';
			$displaylist.='Chapter Name';
			$displaylist.='</th>';
			$displaylist.='<th>';
			$displaylist.='PWH Count';
			$displaylist.='</th>';
			$displaylist.='</tr>';
			$displaylist.='</thead>';
			
			$displaylist.='<tbody>';
		$i=1;
		$this->load->database();	
		foreach($result_report->result_array() as $row){
			$displaylist.='<tr>';
			$displaylist.='<td class="numbersstyle">';
			$displaylist.=$i;
			$displaylist.='</td>';
			$displaylist.='<td>';
			$displaylist.=$row['chap_name'];
			$displaylist.='</td>';
			$displaylist.='<td class="numbersstyle">';
			$displaylist.=$row['pat_count'];
			$displaylist.='</td>';			
			$displaylist.='</tr>';
			$i=$i+1;
		}
		$displaylist.='</tbody>';
		$displaylist.='</table>';
			break;
		case 1:
			//Header part
			$displaylist.='<tr>';
			$displaylist.='<th>';
			$displaylist.='Sl.No';
			$displaylist.='</th>';
			$displaylist.='<th>';
			$displaylist.='Factor deficiency';
			$displaylist.='</th>';
			$displaylist.='<th>';
			$displaylist.='Count';
			$displaylist.='</th>';
			$displaylist.='</tr>';
			$displaylist.='</thead>';
			
			$displaylist.='<tbody>';
		$i=1;
		$this->load->database();
		$this->load->helper('dropdown');
		foreach($result_report->result_array() as $row){
			$displaylist.='<tr>';
			$displaylist.='<td class="numbersstyle">';
			$displaylist.=$i;
			$displaylist.='</td>';
			$displaylist.='<td>';
			$displaylist.=test_method($row['factor']);
			$displaylist.='</td>';
			$displaylist.='<td class="numbersstyle">';
			$displaylist.=$row['deficient_count'];
			$displaylist.='</td>';			
			$displaylist.='</tr>';
			$i=$i+1;
		}
		$displaylist.='</tbody>';
		$displaylist.='</table>';
		break;
		case 2:
			//Header part
			$displaylist.='<tr>';
			$displaylist.='<th>';
			$displaylist.='Sl.No';
			$displaylist.='</th>';
			$displaylist.='<th>';
			$displaylist.='Factor deficiency';
			$displaylist.='</th>';
			$displaylist.='<th>';
			$displaylist.='Count';
			$displaylist.='</th>';
			$displaylist.='</tr>';
			$displaylist.='</thead>';
			
			$displaylist.='<tbody>';
		$i=1;
		$this->load->database();
		$this->load->helper('dropdown');
		$row=$result_report->result_array();
			$displaylist.='<tr>';
			$displaylist.='<td class="numbersstyle">';
			$displaylist.=1;
			$displaylist.='</td>';
			$displaylist.='<td>';
			$displaylist.='Severe PWHs';
			$displaylist.='</td>';
			$displaylist.='<td class="numbersstyle">';
			$displaylist.=$row[0]['severe'];
			$displaylist.='</td>';			
			$displaylist.='</tr>';
			
			$displaylist.='<tr>';
			$displaylist.='<td class="numbersstyle">';
			$displaylist.=2;
			$displaylist.='</td>';
			$displaylist.='<td>';
			$displaylist.='Moderate PWHs';
			$displaylist.='</td>';
			$displaylist.='<td class="numbersstyle">';
			$displaylist.=$row[0]['modrate'];
			$displaylist.='</td>';			
			$displaylist.='</tr>';
			
			$displaylist.='<tr>';
			$displaylist.='<td class="numbersstyle">';
			$displaylist.=3;
			$displaylist.='</td>';
			$displaylist.='<td>';
			$displaylist.='Mild PWHs';
			$displaylist.='</td>';
			$displaylist.='<td class="numbersstyle">';
			$displaylist.=$row[0]['mild'];
			$displaylist.='</td>';
			$displaylist.='</tr>';
		$displaylist.='</tbody>';
		$displaylist.='</table>';
		break;
		}
		return $displaylist;
	}
	function generategraph($report_id,$result_report){
		//to generate the chart
		$this->load->plugin('jpgraph');
		$graph = loadgraph($report_id);
		switch($report_id){
			case 0:
				// We need some data 
				//build Data Value
				$datay=array();
				foreach($result_report->result_array()  as $row){
					$datay[]=$row['pat_count'];
				}
					
				// Setup the graph. 
				$graph = new Graph(520,350);    
				$graph->SetScale("textlin");
				
				// Add a drop shadow
				$graph->SetShadow();
			
				// Adjust the margin a bit to make more room for titles
				$graph->SetMargin(40,30,20,40);
				
				// Setup the titles
				$graph->title->Set('NHR Registry');
				$graph->xaxis->title->Set('Chapters');
				$graph->yaxis->title->Set('Number PWHs');
				
				// Create the bar pot
				$bplot = new BarPlot($datay);
				
				// Adjust fill color
				$bplot->SetFillColor('orange');
				$graph->Add($bplot);
				 
				$graph->title->SetFont(FF_FONT1,FS_BOLD);
				$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
				$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
				
				$graph_temp_directory = $this->config->item('absolute_path').'graphimage';
				$graph_file_name = 'adminchaptergraph.png'; 
				$graph_file_location = $graph_temp_directory . '/' . $graph_file_name;
				if (file_exists($graph_file_location)) {
		  			unlink($graph_file_location);
				}
		
				// Finally send the graph to the browser
				$graph->Stroke($graph_file_location); 
				$returnvalue=$this->config->item('base_url').'graphimage/adminchaptergraph.png';	
			break;
			case 1:
				$data=array();
				$factorarray=array();
				$i=1;
				foreach($result_report->result_array()  as $row){
					$data[]=$row['deficient_count'];
					$factorarray[]=$i;
					$i=$i+1;
				}
				
				$graph = new PieGraph(520,320);
				$graph->SetShadow();
				 
				$graph->title->Set("Factor Deficiency Graph");
				
				$p1 = new PiePlot3D($data);
				$graph->Add($p1);
				$p1->ExplodeAll(10);
				$p1->SetAngle(70);
				$p1->SetLegends($factorarray);
				$graph_temp_directory = $this->config->item('absolute_path').'graphimage';
				$graph_file_name = 'admindeficientgraph.png'; 
				$graph_file_location = $graph_temp_directory . '/' . $graph_file_name;
				if (file_exists($graph_file_location)) {
		  			unlink($graph_file_location);
				}
				$graph->Stroke($graph_file_location); 
				$returnvalue=$this->config->item('base_url').'graphimage/admindeficientgraph.png';
			break;
			case 2:
				$data=array(1,2,3);
				$defarray=array();
				$i=1;
				$row=$result_report->result_array();
				$defarray[]=$row[0]['severe'];
				$defarray[]=$row[0]['modrate'];
				$defarray[]=$row[0]['mild'];
				
				$graph = new PieGraph(520,320);
				$graph->SetShadow();
					
				$graph->title->Set("Severity Graph");	
				
				$p1 = new PiePlot3D($defarray);
				$graph->Add($p1);
				$p1->ExplodeAll(10);
				$p1->SetAngle(70);
				$p1->SetLegends($data);
				$graph_temp_directory = $this->config->item('absolute_path').'graphimage';
				$graph_file_name = 'adminseveritygraph.png'; 
				$graph_file_location = $graph_temp_directory . '/' . $graph_file_name;
				if (file_exists($graph_file_location)) {
					unlink($graph_file_location);
				}
				$graph->Stroke($graph_file_location); 
				$returnvalue=$this->config->item('base_url').'graphimage/adminseveritygraph.png';
			break;
		}
		return $returnvalue;
	}
}
?>	
