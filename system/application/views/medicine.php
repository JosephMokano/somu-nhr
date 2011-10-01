
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
      <script>
      function validateForm()
{
var x=document.forms["medicine"]["medicineName"].value;
if (x==null || x=="")
  {
  alert("Medicine name must be filled out");
  document.forms["medicine"]["medicineName"].focus();
  return false;
  }
}
      </script>
    <!-- Content Page -->
    <form name="medicine" id="medicine" action="/medicine/add_medicine" onsubmit="return validateForm()" method="post">
<table cellspacing="2" cellpadding="5" align="center"  align='center'>
<tr>
<td>Medicine Name:</td><td><input type="text"  name="medicineName" id="medicineName" value="" size="18%" class="required"/></td>
</tr>
<tr>
<td>Company Name:</td><td><select name="companyName" >
<option>Select company</option>
<?php foreach($feed as $row)  { ?>
   <option value="<?php echo $row['comp_id']; ?>"><?php echo $row['comp_name']; ?></option>
<?php  } ?>
</select>
</td>
</tr>
<tr>
<td>Factor Type:</td><td><select name="type">
<option>Choose one</option>
<?php foreach($feed1 as $row)  { ?>
   <option value="<?php echo $row['fact_id']; ?>"><?php echo $row['factor_type']; ?></option>
<?php  } ?>
</select>
</td>
</tr>
<tr>
<td>Notes:</td><td><TEXTAREA input type="text" name="notes" ROWS=2 COLS=23 </TEXTAREA><!--<input type="text" style="width:175px; height:40px;" name="notes" size="18%"/>--></td>
</tr>
<tr>
<td>Others:</td><td><input type="text"  name="others" id="others" value="" size="18%" class="required"/></td>
</tr>
<td></td><td><input type="submit"  name="submit"  value="submit" /></td>
</tr>
</table>
</form>
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





