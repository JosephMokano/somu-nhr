
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
   <a href="/medicine/medicine_view">back</a>
<?php 
require_once ('../Pager/Pager.php');
mysql_select_db("$db_name")or die("cannot select DB");
$result=mysql_query("SELECT COUNT(*) AS total FROM  tbl_pharmacompany");
$row = mysql_fetch_array($result);
$totalItems = $row['total'];
$pager_options = array(
'mode'       => 'Sliding',   // Sliding or Jumping mode. See below.
'perPage'    => 6,   // Total rows to show per page
'delta'      => 4,   // See below
'totalItems' => $totalItems,
);
$pager = Pager::factory($pager_options);
echo $pager->links;
list($from, $to) = $pager->getOffsetByPageId();
$from = $from - 1;
$perPage = $pager_options['perPage'];
//$result = mysql_query("SELECT * FROM  tbl_company_details  LIMIT $from , $perPage");
echo "<table cellspacing='3', cellpadding='3', border='0', align='center'>";
echo "<tr>
    <th>SlNo</th>
    <th>Medicine Name</th>  
    <th>Company ID</th>
    <th>Factor Type</th>
    <th>Notes</th>
    <th>Others</th>
    </tr>";
    $i=1;
    foreach($feed as $row) {  
    echo "<tr style=text-align:center>";
    echo "<td>".$i."</td>";
    echo "<td>".$row['medicine_name']."</td>";
    echo "<td>".$row['comp_id']."</td>";
    echo "<td>".$row['factor_type']."</td>";
    echo "<td>".$row['Notes']."</td>";
    echo "<td>".$row['others']."</td>";
    //echo "<td><a href='/branch/branch_list/".$row['company_id']."'><img src='../images/branch.gif' title='Branch'></a><a href='/user/user_add/".$row['company_id']."'><img src='../images/images.jpeg' title='Add user'></a></td>";
    echo "<td><a href='/medicine/edit_medicine/".$row['medical_id']."'>Edit </a></td>";
    //echo "<td><a href='/dashboard/mail/".$row['company_id']."'>Send mail </a></td>";
    echo "</tr>";
    $i++;
  }
  echo "</table>";
?>
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