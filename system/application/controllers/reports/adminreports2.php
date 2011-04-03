<?php 
class adminreports2 extends Controller {
	function adminreports2(){
	parent::Controller();
		$this->load->library('session');
		
		//loading db to generate reports....
		$this->load->model('reports/mod_adminreports');
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
					$reportList.='<td align="center"><a href="'.$this->config->item("base_url").'reports/adminreports2/listreports/'.$key.'"><img src="'.$this->config->item("base_url").'images/report2.png" /><br/>'.$value.'</a></td>';
				}else if($key=='severity_report'){
					$reportList.='<td align="center"><a href="'.$this->config->item("base_url").'reports/adminreports2/listreports/'.$key.'"><img src="'.$this->config->item("base_url").'images/report1-icon.png" /><br/>'.$value.'</a></td>';
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
    $reportsdisplay='<div id="chart1" style="height:400px;width:400px; "></div>
      <div id="info3"></div>';
    $this->load->library("nhrpwhdetails");
      $pwhcount=$this->nhrpwhdetails->fetch_factorwise();
    
    $data = array('reportsdisplay'=>$reportsdisplay);
    $this->template->add_js('js/jquery.jqplot.min.js','import');
     $this->template->add_js('js/plot/jqplot.pieRenderer.js','import');
    
     $this->template->add_css('styles/jquery.jqplot.min.css');
     $this->template->write_view('header','header',$headerdata, True);
    $this->template->write_view('content', 'reports/adminreports', $data, True);
     $this->template->add_js('
      $(document).ready(function() {
           $.jqplot.config.enablePlugins = true;
          s1 = [["Factor 8",'.$pwhcount['count_f8'].'], 
          ["Factor 9",'.$pwhcount['count_f9'].'], 
          ["Others",'.$pwhcount['count_other_total'].'], 
          ["Empty",'.$pwhcount['count_empty'].']];
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
            
        }
    );  

      });
	  
      function piaclickHandler(ev, gridpos, datapos, neighbor, plot) {
        alert("hello");
      }
     ', 'embed');
	  
    $this->template->render();
	}

//added by deepak
	//zone info and graph comes here....
	
	function zoneinfo(){
		
	  $headerdata="Zone Info";
	  
    $reportsdisplay='';
	$reportsdisplay .= '<table cellspacing="0" cellpadding="4" width="100%">';
	$reportsdisplay .= '<tr>';
	$reportsdisplay .= '<td align="center">';
    $reportsdisplay .= '<div id="zone" style="height:400px;width:700px;"></div>';
	$reportsdisplay .= '</td>';
	$reportsdisplay .= '</tr>';
	$reportsdisplay .= '</table>';
	$result = $this->mod_adminreports->get_zone_reports();
	$zone = $result->result_array();
	$zone1 = $zone[0]['ct'];
	$zone2 = $zone[1]['ct'];
	$zone3 = $zone[2]['ct'];
	$zone4 = $zone[3]['ct'];
	
	
    
    $data = array('reportsdisplay'=>$reportsdisplay);
    $this->template->add_js('js/jquery.jqplot.min.js','import');
     $this->template->add_js('js/plot/jqplot.pieRenderer.js','import');
    
     $this->template->add_css('styles/jquery.jqplot.min.css');
     $this->template->write_view('header','header',$headerdata, True);
    $this->template->write_view('content', 'reports/adminreports', $data, True);
     $this->template->add_js('
      $(document).ready(function() {
           $.jqplot.config.enablePlugins = true;
          
          s1 = [["North: '.$zone1.'",'.$zone1.'], 
          ["West: '.$zone2.'",'.$zone2.'], 
          ["East: '.$zone3.'",'.$zone3.'], 
          ["South: '.$zone4.'",'.$zone4.']];
           plot1 = $.jqplot("zone", [s1], {
             title: "Pie Chart of Zone",
              
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions:{
                sliceMargin: 4,
                startAngle: -90,
                showLabel:true
            }
            
        },
         cursor: {
        		style: "hand",    
                show: true,
        		},
        legend: {show:true,showLabels:true,placement: "insideGrid"}
    });
        $("#zone").bind("jqplotDataClick", 
        function (ev, seriesIndex, pointIndex, data) {
        		var number = pointIndex+1,	
        		
			  url = "'.base_url().'reports/adminreports2/show_zone_content/"+number;
			     
              window.location.href = url;
            
            
        }
    );  

      });
	  
     
     ', 'embed');
	  
    $this->template->render();
	}
	
	//to display zone content in bar graph
	
	function show_zone_content($id=0)
	{
		
	$headerdata="Zone Info";
	 
    $reportsdisplay='';
	$reportsdisplay .= '<table cellspacing="0" cellpadding="4" width="100%">';
	$reportsdisplay .= '<tr>';
	$reportsdisplay .= '<td width="90%">';
	$reportsdisplay .='<div id="zone" style="height:400px;width:900px;"></div>';
	$reportsdisplay .= '</td>';
	$reportsdisplay .= '<td width="55%">&nbsp;';
	$reportsdisplay .= '<table id="flex1" style="display:none" border=0 align=left ></table>';
	//adding flexigrid....
	$this->load->helper('flexigrid');
	
	  $colModel['chapter_id'] = array('Sl No',50,TRUE,'center',0);
      $colModel['chapter_name'] = array('Chapter Name',210,TRUE,'left',2);
	  $colModel['total'] = array('Total',70,TRUE,'left',0);
    
    $gridParams = array(
      'width' => '370',
      'height' => '300',
      'rp' => 15,
      'rpOptions' => '[10,20,30,40]',
      'pagestat' => 'Displaying:{from} to {to} of {total} items.',
      'blockOpacity' => 0.5,
      'title' => 'List of Cities in Karnataka',
      'showTableToggleBtn' => true
    );
    
    
	 
	
	
	$reportsdisplay .= '</td>';
	$reportsdisplay .= '</tr>';
	$reportsdisplay .= '</table>';
    
	if($id == 1)
	{
		$zone_name = 'North Zone';
	}
	else if($id == 2)
	{
		$zone_name = 'West Zone';
	}
	else if($id == 3)
	{
		$zone_name = 'East Zone';
	}
	else
	{
		$zone_name = 'South Zone';
	}
		
	
	$result = $this->mod_adminreports->get_each_zone_info($id);
	
	$value = $result->result_array();
	//print_r($value);exit;
	$line1_data = ''; 
	$tick_data ='';
	$line1_data .= '[';
	$tick_data .= '[';
	foreach($value as $row)
	{
		
		$line1_data .= $row['count(b.patient_id)'].',';
		$tick_data .= '"'.$row['cityname'].'",';
	}  
	$line1_data .= '];';
	$tick_data .= ']';
	
	//echo $tick_data;exit;
	
	
    $this->template->add_js('js/jquery.jqplot.min.js','import');
     $this->template->add_js('js/plot/jqplot.categoryAxisRenderer.min.js','import');
    $this->template->add_js('js/plot/jqplot.barRenderer.min.js','import');
	
	//added flexgrid for js

	 $this->template->add_js('js/flexigrid.pack.js','import');
     $this->template->add_css('styles/flexigrid.css');
	$grid_js = build_grid_js('flex1',site_url("/reports/adminreports2/zone_table/".$id),$colModel,'city_id','asc',$gridParams);
	
	    $data = array('reportsdisplay'=>$reportsdisplay,'js_grid'=>$grid_js);
	
     $this->template->add_css('styles/jquery.jqplot.min.css');
     $this->template->write_view('header','header',$headerdata, True);
	 
     $this->template->write_view('content', 'reports/adminreports', $data, True);
  
	$this->template->add_js('
      $(document).ready(function() {
            line1 = '.$line1_data.';
			
		
			plot2 = $.jqplot("zone", [line1], {
			    legend:{show:true, location:"ne", xoffset:55},
			    title:"Bar Chart of '.$zone_name.'",
			    seriesDefaults:{
			        renderer:$.jqplot.BarRenderer, 
			        rendererOptions:{barPadding: 8, barMargin: 20}
			    },
			    series:[
			        {label:"'.$zone_name.'"}, 
			        {show:false},
			        
			    ],
			    axes:{
			        xaxis:{
			            renderer:$.jqplot.CategoryAxisRenderer, 
			            ticks:'.$tick_data.'
			        }, 
			        yaxis:{min:0}
			    }
			});

      });
	  
     
     ', 'embed');
	  
    $this->template->render();
		
	}
//constructing flexi table for each zone...

	

function zone_table($id)
{
	$this->load->library('flexigrid');
	
    $valid_fields = array('chapter_id');
    
    $this->flexigrid->validate_post('chapter_name','asc',$valid_fields);

    $records = $this->mod_adminreports->get_ajax_chapterinfo($id);
    
    $this->output->set_header($this->config->item('json_header'));
    
    $i =1;
    foreach ($records['records']->result() as $row)
    {
    	
      $record_items[] = array($row->chapter_id,$i,
      '<span><a href="'.base_url().'reports/adminreports2/show_chapter_content/'.$row->chapter_id.'">'.$row->chapter_name.'</a></span>',
      $row->total 
          );
      $i++;   
            
    }
    if($records['record_count'])
    {
        $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    else
    {
      $record_items[] = array('No');
      $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
	
}
	// to display number patients by age...
	function show_report_by_age()
	{
		$result = $this->mod_adminreports->get_patient_age();
		$val = $result->result_array();
		
		$max = max($val[0])+100;
		foreach($val[0] as $row)
		{
				
		}
		
		$data ='';
		$data .='[';
	
	
	    $data .= '["under 20","'.$val[0]['under 20'].'"],';
		$data .= '["20-39","'.$val[0]['20 - 39'].'"],';
		$data .= '["40-59","'.$val[0]['40 - 59'].'"],';
		$data .= '["60-79","'.$val[0]['60 - 79'].'"],';
		$data .= '["80-99","'.$val[0]['80 - 99'].'"],';
		$data .= '["100 plus","'.$val[0]['100 plus'].'"]]';
	//echo $data;exit;	
	$headerdata="By Age";
    $reportsdisplay='';
	
    $reportsdisplay='<div id="chart1" style="height:400px;width:500px; "></div>
      <div id="info3"></div>';
  
    
    $data = array('reportsdisplay'=>$reportsdisplay);
    $this->template->add_js('js/jquery.jqplot.min.js','import');
     $this->template->add_js('js/plot/jqplot.cursor.min.js','import');
    $this->template->add_js('js/plot/jqplot.dateAxisRenderer.min.js','import');
     $this->template->add_css('styles/jquery.jqplot.min.css');
     $this->template->write_view('header','header',$headerdata, True);
    $this->template->write_view('content', 'reports/adminreports', $data, True);
     $this->template->add_js('
      $(document).ready(function() {
      	$.jqplot.config.enablePlugins = true;
		
           var data = [["0","2008"],["20","1228"],["40","333"],["60","42"],["80","5"],["100 ","17"]];
	
		plot = $.jqplot("chart1", [data], { 
    title: "Age Report", 
    series: [{ 
        label: "Age ", 
        neighborThreshold: -1 
    }], 
    axes: { 
         xaxis: {min: 0,ticks:[0,20, 40, 60, 80,100,120],tickOptions:{formatString:"%d"} },
        yaxis: { 
            min:0,max:'.$max.',tickOptions:{formatString:"%d"}
            
        } 
    }, 
    cursor:{zoom:true, showTooltip:false} 
});
		
		
      });
	  
      
     ', 'embed');
	  
    $this->template->render();
		
		
	}

// code for bar graph to display patient based on age
/*
function show_report_by_age()
	{
		$result = $this->mod_adminreports->get_patient_age();
		$val = $result->result_array();
	//	print_r($val);exit;
		$line1 = '['.$val[0]['under 20'].']';
		$line2 = '['.$val[0]['20 - 39'].']';
		$line3 = '['.$val[0]['40 - 59'].']';
		$line4 = '['.$val[0]['60 - 79'].']';
		$line5 = '['.$val[0]['80 - 99'].']';
		$line6 = '['.$val[0]['100 plus'].']';	
	$headerdata="By Age";
    $reportsdisplay='';
	
    $reportsdisplay='<div id="chart1" style="height:400px;width:500px; "></div>
      <div id="info3"></div>';
  
    
    $data = array('reportsdisplay'=>$reportsdisplay);
    $this->template->add_js('js/jquery.jqplot.min.js','import');
     $this->template->add_js('js/plot/jqplot.categoryAxisRenderer.min.js','import');
    $this->template->add_js('js/plot/jqplot.barRenderer.min.js','import');
     $this->template->add_css('styles/jquery.jqplot.min.css');
     $this->template->write_view('header','header',$headerdata, True);
    $this->template->write_view('content', 'reports/adminreports', $data, True);
     $this->template->add_js('
      $(document).ready(function() {
           line1 = '.$line1.';
		   line2 = '.$line2.';
		   line3 = '.$line3.';
		   line4 = '.$line4.';
		   line5 = '.$line5.';
		   line6 = '.$line6.';
		
		plot1 = $.jqplot("chart1", [line1, line2,line3,line4,line5,line6], {
		    legend:{show:true, location:"ne"},title:"Age Chart",
		    series:[
		        {label:"Under 20", renderer:$.jqplot.BarRenderer}, 
		        {label:"20-39", renderer:$.jqplot.BarRenderer},
		        {label:"40-59", renderer:$.jqplot.BarRenderer},
		        {label:"60-79", renderer:$.jqplot.BarRenderer},
		        {label:"80-99", renderer:$.jqplot.BarRenderer},
		        {label:"100 plus", renderer:$.jqplot.BarRenderer}
		    ],
		    axes:{
		        xaxis:{
			            renderer:$.jqplot.CategoryAxisRenderer, 
			            ticks:["Age -->"]
			        },  
		        yaxis:{min:0}
		    }
		});

      });
	  
      
     ', 'embed');
	  
    $this->template->render();
		
		
	}
	*/


//this is commented because changed to bar graph....	
//added by deepak

	//to display zone content in pie graph
	/*
	function show_zone_content($id=0)
	{
		
	$headerdata="Zone Info";
	 
    $reportsdisplay='';
    $reportsdisplay .='<div id="zone" style="height:500px;width:600px; "></div>';
	if($id == 1)
	{
		$zone_name = 'North Zone';
	}
	else if($id == 2)
	{
		$zone_name = 'West Zone';
	}
	else if($id == 3)
	{
		$zone_name = 'East Zone';
	}
	else
	{
		$zone_name = 'South Zone';
	}
		
	
	$result = $this->mod_adminreports->get_each_zone_info($id);
	
	$value = $result->result_array();
	$arr_data = ''; 
			
	$arr_data .= '['; 
	foreach($value as $row)
	{
		$arr_data .= '["'.$row['chapter_name'].'",'.$row['count(b.patient_id)'].'.'.$row['chapter_id'].'],';
	}  
	$arr_data .= '];';
	
    $data = array('reportsdisplay'=>$reportsdisplay);
    $this->template->add_js('js/jquery.jqplot.min.js','import');
     $this->template->add_js('js/plot/jqplot.pieRenderer.js','import');
    
     $this->template->add_css('styles/jquery.jqplot.min.css');
     $this->template->write_view('header','header',$headerdata, True);
     $this->template->write_view('content', 'reports/adminreports', $data, True);
  
	$this->template->add_js('
      $(document).ready(function() {
           $.jqplot.config.enablePlugins = true;
          
          s1 = '.$arr_data.'
           plot1 = $.jqplot("zone", [s1], {
             title: "Pie Chart of '.$zone_name.'",
              
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions:{
                sliceMargin: 4,
                startAngle: -90,
                showLabel:true
            }
            
        },
         cursor: {
        		style: "hand",    
                show: true,
        		},
        legend: {show:true,showLabels:true,placement: "insideGrid"}
    });
        $("#zone").bind("jqplotDataClick", 
        function (ev, seriesIndex, pointIndex, data) {
        		//to separate id number
				$.post("'.base_url().'reports/adminreports2/get_chapter_id", { id:data },
 				function(data) {
  						url = "'.base_url().'reports/adminreports2/show_chapter_content/"+data;
			     
              			window.location.href = url;
 						},"json");
        		
				       });  

      });
	  
     
     ', 'embed');
	  
    $this->template->render();
		
	}
	 * 
	 */
//added by deepak
	//this function is used to separate id using ajax... 
	function get_chapter_id(){
		list($tot,$id) =explode('.',$_POST['id'][1]);
		echo json_encode($id);
	}
	
	//show chapter...
	function show_chapter_content($chapid=0)
	{
			
	$headerdata="Factor Info";
    $reportsdisplay='';
    $reportsdisplay='<div id="chart1" style="height:400px;width:400px; "></div>
      <div id="info3"></div>';
    	$chapid=array('chapid'=>$chapid);
        $this->load->library("nhrpwhdetails",$chapid);
        $pwhcount=$this->nhrpwhdetails->fetch_factorwise();
		
    
    $data = array('reportsdisplay'=>$reportsdisplay);
    $this->template->add_js('js/jquery.jqplot.min.js','import');
     $this->template->add_js('js/plot/jqplot.pieRenderer.js','import');
    
     $this->template->add_css('styles/jquery.jqplot.min.css');
     $this->template->write_view('header','header',$headerdata, True);
    $this->template->write_view('content', 'reports/adminreports', $data, True);
     $this->template->add_js('
      $(document).ready(function() {
           $.jqplot.config.enablePlugins = true;
          s1 = [["Factor 8",'.$pwhcount['count_f8'].'], 
          ["Factor 9",'.$pwhcount['count_f9'].'], 
          ["Others",'.$pwhcount['count_other_total'].'], 
          ["Empty",'.$pwhcount['count_empty'].']];
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
            
        }
    );  

      });
	  
      function piaclickHandler(ev, gridpos, datapos, neighbor, plot) {
        alert("hello");
      }
     ', 'embed');
	  
    $this->template->render();
		
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
		$retValue='<div style="text-align:right;background-color:#E6EEEE;margin:10px 0px;padding:5px;"><a href="'.$this->config->item("base_url").'reports/adminreports2/listreports">Back</a> to Reports</div>';
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