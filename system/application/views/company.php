
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
var x=document.forms["company"]["companyName"].value;
if (x==null || x=="")
  {
  alert("Company name must be filled out");
  document.forms["company"]["companyName"].focus();
  return false;
  }
}
      </script>
    <!-- Content Page -->
    <form name="company" id="company" action="/company/add_company" onsubmit="return validateForm()" method="post">
<table cellspacing="2" cellpadding="5" align="center" style='font-size:1.0em' align='center'>
<tr>
<td>Compamy name:</td><td><input type="text" name="companyName" id="companyName"/></td>
</tr>
<tr>
<td>Phone Number:</td><td><input type="text"  name="PhoneNumber" id="PhoneNumber" /></td>
</tr>
<tr>
<td>Email:</td><td><input type="text"  name="Email" id="Email"  /></td>
</tr>
<td></td><td><input type="submit"  name="submit"  value="submit" /></td>
</tr>
</table>
</form><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
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