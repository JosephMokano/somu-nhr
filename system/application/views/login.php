<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <title>NHR</title>
   <link type="text/css" rel="stylesheet" href="<?=$this->config->item('base_url')?>/styles/layout.css" />
</head>
<body>
	<div id="wrapper">
		<div id="pageBlock">
		
			<!-- content Block -->
			<div id="content">
			
				<div align="center"><img src="/images/login_logo.jpg"/></div>
				<h2 align="center">National Hemophilia Registry</h2>
				<!-- Content Page -->
				
				<?= $content ?>
				
			</div>
			
			<!-- Footer Block -->
			<div id="footer">
				<?= $footer; ?>
			</div>
		</div>
   </div>
</body>
</html>