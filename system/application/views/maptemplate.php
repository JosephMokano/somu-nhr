<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
   <title>Template</title>
   <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

   <?php echo  $_scripts ?>
   <?php echo  $_styles ?>
   
   <?php //$this->jquery->output(); ?>
   <?php if (isset($grid_js))
        echo $grid_js; 
     ?>
 
</head>
<body>

  <div id="wrapper">
   
        <?php echo  $content ?>
       
   </div>
</body>
</html>