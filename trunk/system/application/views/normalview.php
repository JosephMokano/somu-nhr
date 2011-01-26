<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Template</title>
</head>
<style>
body {
	margin:0px;
	padding:0px;	
	font-family:"Trebuchet MS",Arial, Helvetica, sans-serif;
	font-size:9pt;
	background-color:#999999;
}
html{
	margin:0px;
	padding:0px;
}
#wrapper{
	width:1020px;
	margin:0px auto;
	background:url(../images/backpatti.jpg) repeat-y top left;
	border:1px solid #999999;
	height:100%;
	min-height:400px;
}
</style>
<body>
	<div id="wrapper">
		<br/><br/>
		<?php echo $content ?>
	</div>
</body>
</html>