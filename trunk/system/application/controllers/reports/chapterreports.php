<?php 
class chapterreports extends Controller {
	function chapterreports(){
	parent::Controller();
		$this->load->library('session');
     $this->template->write_view('header','header',$this->session->userdata('headerdata'), True);
	}
	function index(){
		$this->listreports();
	}
	function listreports($reportname = ''){
		$reportlist = array(
			'ss'=>'nothing yet', 
			'factor_report'=>'Factor Deficiency', 
			'severity_report'=>'Severity'
		);
		if ( empty($reportname)) {
			$reportList = '<table border="0" id="reporticons" >';
			$reportList .= '<tr>';
			foreach ($reportlist as $key=>$value) {
				if($key=='ss'){
					//$reportList.='<td><a href="listreports/'.$key.'"><img src="'.$this->config->item("base_url").'images/reports-icon.png" /><br/>'.$value.'</a></td>';
				}else if($key=='factor_report'){
					$reportList.='<td align="center"><a href="'.$this->config->item("base_url").'reports/chapterreports/listreports/'.$key.'"><img src="'.$this->config->item("base_url").'images/report2.png" /><br/>'.$value.'</a></td>';
				}else if($key=='severity_report'){
					$reportList.='<td align="center"><a href="'.$this->config->item("base_url").'reports/chapterreports/listreports/'.$key.'"><img src="'.$this->config->item("base_url").'images/report1-icon.png" /><br/>'.$value.'</a></td>';
				}
			}
			$reportList .= '</tr>';
			$reportList .= '</table>';
			$reportsdisplay = $reportList;
			$data = array('reportsdisplay'=>$reportsdisplay);
			$this->template->write('pageheader', 'List of Reports');
		} else {
			$arryKey=array_search($reportname,array_keys($reportlist)); 
			$reportsdisplay=$this->generateReport($arryKey);
			$data = array('reportsdisplay'=>$reportsdisplay);
			$this->template->write('pageheader', $reportlist[$reportname]);
		}
		$this->load->database();
		$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
		$result = $query->row_array();
	
		$headerdata = array(
			'username'=>$this->session->userdata('username'),
			'chapterName'=>$result['chapter_name']
		);
			
		$this->template->write_view('header','header',$headerdata, True);
		$this->template->write_view('content', 'reports/adminreports', $data, True);
		$this->template->render();
	}
	function factordef(){
	  $headerdata="Factor Info";
    $reportsdisplay='';
    $reportsdisplay='<table width="950" cellpadding="0" cellspacing="0" border="0">';
    $reportsdisplay.='<tr><td width="400"><div id="chart1" style="height:400px;width:450px; "></div>
      <div id="info3"></div>';
    $reportsdisplay.='</td><td width="400"><div id="chart2" style="height:400px;width:450px; "></td></tr></table>';  
    $this->load->library("nhrpwhdetails");
      $pwhcount=$this->nhrpwhdetails->fetch_factorwise();
    
    $data = array('reportsdisplay'=>$reportsdisplay);
    $this->template->add_js('js/jquery.jqplot.min.js','import');
     $this->template->add_js('js/plot/jqplot.pieRenderer.js','import');
    
     $this->template->add_css('styles/jquery.jqplot.min.css');
     $this->template->write_view('header','header',$headerdata, True);
    $this->template->write_view('content', 'reports/adminreports', $data, True);
     $this->template->add_js('
     var url="'.$this->config->item('base_url').'reports/chapterreports/severitygrp";
     var selectedfact=-1;
      $(document).ready(function() {
           $.jqplot.config.enablePlugins = true;
          s1 = [["Factor 8: "+'.$pwhcount['count_f8'].','.$pwhcount['count_f8'].'], 
          ["Factor 9: "+'.$pwhcount['count_f9'].','.$pwhcount['count_f9'].'], 
          ["Others: "+'.$pwhcount['count_other_total'].','.$pwhcount['count_other_total'].'], 
          ["Empty: "+'.$pwhcount['count_empty'].','.$pwhcount['count_empty'].']];
           plot1 = $.jqplot("chart1", [s1], {
             title: "Pie Chart Factor Deficiency",
             
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions:{
                sliceMargin: 4,
                startAngle: -90,
                showLabel:true
            }
            
        },
        legend: {show:true,showLabels:true,placement: "insideGrid"}
    });
        $("#chart1").bind("jqplotDataClick", 
        function (ev, seriesIndex, pointIndex, data) {
            $("#info3").html("series: "+seriesIndex+", point: "+pointIndex+", data: "+data);
            selectedfact=pointIndex;
            $.ajax({
              type: "POST",
              url: url,
              data: "selfactor="+pointIndex,
               success: function(msg){
                $("#chart2").html("");
                updateassay(msg)
              }
            });
        }
    );  

      });
      //Function to handle after ajax
      function updateassay(seldata){
        if (seldata==":"){
          $("#chart2").html("<br/><br/><b>Oops! you can select Factor 8 or Factor 9</b>");
        }else{
          if (selectedfact==0){
            factstatment="Factor 8";
          }else{
            factstatment="Factor 9";
          }
        var assayarray=seldata.split(",");
          $.jqplot.config.enablePlugins = true;
          var s2 = [["Severe: "+assayarray[0],parseInt(assayarray[0])], 
          ["Mild: "+assayarray[1],parseInt(assayarray[1])], 
          ["Moderate: "+assayarray[2],parseInt(assayarray[2])], 
          ["Empty/Not Known: "+assayarray[3],parseInt(assayarray[3])]];
        
               plot2 = $.jqplot("chart2", [s2], {
             title: "Pie Chart showing severity of "+factstatment,
             
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions:{
                sliceMargin: 4,
                startAngle: -90,
                showLabel:true
            }
            
        },
        legend: {show:true,showLabels:true,placement: "insideGrid"}
    });
        
       // $("#chart2").html(assayarray[1]);
        }
      }
      function piaclickHandler(ev, gridpos, datapos, neighbor, plot) {
        alert("hello");
      }
     ', 'embed');
	  
    $this->template->render();
	}
    function severitygrp(){
      $postval=$_POST['selfactor'];
      if ($postval<2){
      $tempArray=array(8,9);
      $this->load->library("nhrpwhdetails");
      $assaycount=$this->nhrpwhdetails->assayFactor($tempArray[$postval]);
      
      $sendata=implode(",",$assaycount);
      echo $sendata;
      }else{
        echo ":";
      }
    }
	function generateReport($reportType=-1){
		$reportsdisplay="Reports to be displayed";
		//echo $reportType;
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
				 from tbl_pat_personal t1 where t1.chap_id='.$this->session->userdata('chapter').'
				 group by patient_factor_deficient 
				 order by factor	
				';
			break;
			case 2:
				$repo_query='SELECT 
				SUM(CASE WHEN patient_factor_level<=1 THEN 1 ELSE 0 END) as severe,
				SUM(CASE WHEN patient_factor_level>1 and patient_factor_level<=5 THEN 1 ELSE 0 END) as modrate,
				SUM(CASE WHEN patient_factor_level>5
				THEN 1 ELSE 0 END) as mild from tbl_pat_personal
				where chap_id='.$this->session->userdata('chapter');
			break;	
		}
		$this->load->model('reports/mod_adminreports', 'obj_adminreports');
		$result_report=$this->obj_adminreports->get_reportresults($repo_query);
		
		//Graph Display
		$displaygraph='<img src="'.$this->generategraph($reportType,$result_report).'" />';

		//Data set	
		$displaylist=$this->reprot_ui($result_report,$reportType);
		$retValue='';
		$retValue='<div style="text-align:right;background-color:#E6EEEE;margin:10px 0px;padding:5px;"><a href="'.$this->config->item("base_url").'reports/chapterreports/listreports">Back</a> to Reports</div>';
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
				$graph_file_name = $this->session->userdata('chapter').'_deficientgraph.png'; 
				$graph_file_location = $graph_temp_directory . '/' . $graph_file_name;
				if (file_exists($graph_file_location)) {
		  			unlink($graph_file_location);
				}
				$graph->Stroke($graph_file_location); 
				$returnvalue=$this->config->item('base_url').'graphimage/'.$this->session->userdata('chapter').'_deficientgraph.png';
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
				$graph_file_name = $this->session->userdata('chapter').'_severitygraph.png'; 
				$graph_file_location = $graph_temp_directory . '/' . $graph_file_name;
				if (file_exists($graph_file_location)) {
					unlink($graph_file_location);
				}
				$graph->Stroke($graph_file_location); 
				$returnvalue=$this->config->item('base_url').'graphimage/'.$this->session->userdata('chapter').'_severitygraph.png';
			break;
		}
		return $returnvalue;
	}
}
?>