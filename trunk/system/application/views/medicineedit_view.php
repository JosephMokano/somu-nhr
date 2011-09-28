<!--<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html> 
<head>
</head>
<body>
<form name="medicine" id="medicine" action="/medicine/update_medicine" method="post">
 <input type="hidden" name="medical_id" value="<?php echo isset($medical_id)?$medical_id:'' ?>"  />
<table cellspacing="2" cellpadding="5" align="center"  align='center'>
<tr>
<td>Medicine Name:</td><td><input type="text"  name="medicineName" id="medicineName" value="<?php echo isset($medicine_name)?$medicine_name:'' ?>" size="18%" class="required"/></td>
</tr>
<tr>
<td>Company Name:</td><td><select name="companyName" id="companyName" value="<?php echo isset($comp_name)?$comp_name:'' ?>">
<option>Select company</option>
<?php foreach($feed as $row)  { ?>
   <option><?php echo $row->comp_name ?></option>
<?php  } ?>
</select>
</td>
</tr>
<tr>
<td>Medicine Type:</td><td><select name="type" value="<?php echo isset($medicine_type)?$medicine_type:'' ?>">
<option value="0">Choose one</option> 
<option value="FActor 1">FActor 1</option>
<option value="FActor 2">FActor 2</option>
<option value="FActor 3">FActor 3</option>
<option value="FActor 4">FActor 4</option>
<option value="FActor 5">FActor 5</option>
<option value="Factor 6">FActor 6</option>
<option value="FActor 7">FActor 7</option>
<option value="FActor 8">FActor 8</option>
<option value="FActor 9">FActor 9</option>
<option value="FActor 10">FActor 10</option>
<option value="FActor 11">FActor 11</option>
<option value="FActor 12">FActor 12</option>
<option value="FActor 13">FActor 13</option>
</select>
</td>
</tr>
<tr>
<td>Notes:</td><td><textarea rows="3" cols="23" name="notes"></textarea></td>
</tr>
<tr>
<td>Others:</td><td><input type="text"  name="others" id="others" value="<?php echo isset($others)?$others:'' ?>" size="18%" class="required"/></td>
</tr>
<td></td><td><input type="submit"  name="submit"  value="submit" /></td>
</tr>
</table>
</body>
</html>-->





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <title>Template</title>
   <script type="text/javascript" src="http://nhr.app/js/jquery-1.4.4.min.js"></script><script type="text/javascript" src="http://nhr.app/js/jquery-ui-1.8.7.custom.min.js"></script>   <link type="text/css" rel="stylesheet" href="http://nhr.app/styles/layout.css" /><link type="text/css" rel="stylesheet" href="http://nhr.app/styles/smoothness/jquery-ui-1.8.7.custom.css" />   
       
</head>
<body>

  <div id="wrapper">
    <div id="pageBlock">
      <!-- Header Block -->
       <div id="header">
          <div id="left">
  <h1>Hemophilia Society Bangalore Chapter</h1>
    
  <div class="style1">(Affiliated to HFI and WFH)</div>
</div>

<div id="right">
  Welcome somushiv&nbsp;
</div>
        
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
        

        <div id="pageheaderright">
          <a href="http://nhr.app/homepage/chapterdashboard"><img src="/images/home.jpg" alt="Dashboard"/></a>
          <a href="http://nhr.app/homepage/loginaccess/logout"><img src="/images/logout.jpg" alt="logout"/></a>
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
   <form name="medicine" id="medicine" action="/medicine/update_medicine" method="post">
 <input type="hidden" name="medical_id" value="<?php echo isset($medical_id)?$medical_id:'' ?>"  />
<table cellspacing="2" cellpadding="5" align="center"  align='center'>
<tr>
<td>Medicine Name:</td><td><input type="text"  name="medicineName" id="medicineName" value="<?php echo isset($medicine_name)?$medicine_name:'' ?>" size="18%" class="required"/></td>
</tr>
<tr>
<td>Company Name:</td><td><select name="companyName" id="companyName" value="<?php echo isset($comp_name)?$comp_name:'' ?>">
<option>Select company</option>
<?php foreach($feed as $row)  { ?>
   <option><?php echo $row->comp_name ?></option>
<?php  } ?>
</select>
</td>
</tr>
<tr>
<td>Medicine Type:</td><td><select name="type" value="<?php echo isset($medicine_type)?$medicine_type:'' ?>">
<option value="0">Choose one</option> 
<option value="FActor 1">FActor 1</option>
<option value="FActor 2">FActor 2</option>
<option value="FActor 3">FActor 3</option>
<option value="FActor 4">FActor 4</option>
<option value="FActor 5">FActor 5</option>
<option value="Factor 6">FActor 6</option>
<option value="FActor 7">FActor 7</option>
<option value="FActor 8">FActor 8</option>
<option value="FActor 9">FActor 9</option>
<option value="FActor 10">FActor 10</option>
<option value="FActor 11">FActor 11</option>
<option value="FActor 12">FActor 12</option>
<option value="FActor 13">FActor 13</option>
</select>
</td>
</tr>
<tr>
<td>Notes:</td><td><textarea rows="3" cols="23" name="notes"></textarea></td>
</tr>
<tr>
<td>Others:</td><td><input type="text"  name="others" id="others" value="<?php echo isset($others)?$others:'' ?>" size="18%" class="required"/></td>
</tr>
<td></td><td><input type="submit"  name="submit"  value="submit" /></td>
</tr>
</table>
</form><br /><br /><br /><br /><br /><br /><br /><br />
            <!-- Footer Block -->

       <div id="footer">
          <div class="footer">
  NHR 2009 
</div>
       </div>
   </div>
   </div>
</body>
</html>