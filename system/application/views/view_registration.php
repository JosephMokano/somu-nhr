<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <title>Template</title>
   <link type="text/css" rel="stylesheet" href="<?=$this->config->item('base_url')?>/styles/layout.css" />
    <?= $scrip; ?>
	<script type="text/javascript" >
	$(document).ready(function() {

	var filePath="<?=$this->config->item('base_url')?>homepage/";
		
		$("#location").focus(function() {}).change(function(){
		cityid=$("OPTION:selected", this).val();
		//alert(cityid);
			$.ajax({
				type: "POST",
				url: filePath+"displaychapterdetails",
				data: ({cityid_x:cityid}),
				success: function(msg)
				{
					$("#message").html(msg);
				}
			});
		});
		
	});
	</script>
</head>
<body>
	<div id="wrapper">
		<div id="pageBlock">
			<!-- Header Block -->
		   <div id="header">
		   		<div id="left">
				<h1><?= $chapterName; ?></h1>
					
				<div class="style1">(Affiliated to HFI and WHF)</div>
				</div>
				<div id="right">
				&nbsp;
				</div>
		   	</div>
			<!-- content Block -->
		   <div id="content">
		     <!-- Page HEader -->
		      <div id="element-box">
   		</div>
		<!-- Content Page -->
		 <div id="element-box">
			<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
			</div>
			<div class="m">
				<div id="error">
				<?php echo validation_errors(); ?>
				</div>
				<?= $content ?>
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
		   		<?= $footer; ?>
		   </div>
   </div>
   </div>
</body>
</html>