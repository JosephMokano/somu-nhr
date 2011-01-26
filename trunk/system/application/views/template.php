<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <title>Template</title>
   <?php echo  $_scripts ?>
   <?php echo  $_styles ?>
   
   <?php //$this->jquery->output(); ?>
   <?php if (isset($grid_js))
        echo $grid_js; 
     ?>
 
</head>
<body>

	<div id="wrapper">
		<div id="pageBlock">
			<!-- Header Block -->
		   <div id="header">
		   		<?php echo  $header; ?>
		   	
		   	</div>
			<!-- content Block -->
		   <div id="content">
		     <!-- Page HEader -->
		      <div id="element-box">
			<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
			</div>
			<div class="m" style="height:25px">
				<div id="pageheaderleft">
					<h2><?php echo  $pageheader ?></h2>
				</div>
				<div id="pageheaderright">
					<a href="<?php echo $this->config->item('base_url')?>homepage/chapterdashboard"><img src="/images/home.jpg" alt="Dashboard"/></a>
					<a href="<?php echo $this->config->item('base_url')?>homepage/loginaccess/logout"><img src="/images/logout.jpg" alt="logout"/></a>
				</div>
				
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
   		</div>
		<!-- Content Page -->
		 <div id="element-box">
			<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
			</div>
			<div class="m">
			<div id="err">
			</div>
				<?php echo  $content ?>
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
   		</div>
			  
		   </div>
		   <!-- Footer Block -->
		   <div id="footer">
		   		<?php echo  $footer; ?>
		   </div>
   </div>
   </div>
</body>
</html>