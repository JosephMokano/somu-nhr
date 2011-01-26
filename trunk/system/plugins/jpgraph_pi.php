<?php
function barcart($datay){
	
	require_once ("jpgraph/jpgraph.php");
	require_once ("jpgraph/jpgraph_bar.php");
	
	// Setup the graph. 
	$graph = new Graph(660,250);    
	$graph->SetScale("textlin");
	
	// Add a drop shadow
	$graph->SetShadow();

	// Adjust the margin a bit to make more room for titles
	$graph->SetMargin(40,30,20,40);
	
	// Setup the titles
	$graph->title->Set('NHR Registry');
	$graph->xaxis->title->Set('X-title');
	$graph->yaxis->title->Set('Y-title');
	
	// Create the bar pot
	$bplot = new BarPlot($datay);
	
	// Adjust fill color
	$bplot->SetFillColor('orange');
	$graph->Add($bplot);
	 
	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
	
	return $graph;
}
?> 