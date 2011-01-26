<?php
class nhrtools1 extends Controller {

  function nhrtools1() {
          parent::Controller();
          
  }
  function index() {  
  
  }
  function readhtml(){
    $dom = new domDocument; 
    $dom->loadHTMLFile("docs/KUNNAMKUL.html");
    $dom->preserveWhiteSpace = false;
    $tables = $dom->getElementsByTagName('table');

    /*** get all rows from the table ***/
    $rows = $tables->item(0)->getElementsByTagName('tr');

    /*** loop over the table rows ***/
    $dataArray=array();
    foreach ($rows as $row)
    {
        /*** get each column by tag name ***/
        $cols = $row->getElementsByTagName('td');
        /*** echo the values ***/
       
        if (($cols->item(0)->nodeValue)){
            $tmpArray=array();
           
            $tmpArray[]=$cols->item(0)->nodeValue;
            $name=$cols->item(1)->getElementsByTagName('p');
             
             $tmpArray[]=$name->item(0)->nodeValue;
            $tmpstring=isset($name->item(1)->nodeValue)?$name->item(1)->nodeValue:'';
            $tmpstring.=isset($name->item(2)->nodeValue)?$name->item(2)->nodeValue:'';
            $tmpstring.=isset($name->item(3)->nodeValue)?$name->item(3)->nodeValue:'';
            $tmpArray[].=$tmpstring;
            //$tmpArray[]=$cols->item(1)->nodeValue;
            $bsdob=$cols->item(2)->getElementsByTagName('p');
            $tmpArray[]=$bsdob->item(0)->nodeValue;
            $tmpArray[]=isset($bsdob->item(1)->nodeValue)?$bsdob->item(1)->nodeValue:'';
             
             $tmpArray[]=isset($bsdob->item(2)->nodeValue)?$bsdob->item(2)->nodeValue:'';
              //$tmpArray[]=$bsdob->item(2)->nodeValue;
             $factorinfo=$cols->item(3)->getElementsByTagName('p');
            $tmpArray[]=isset($factorinfo->item(0)->nodeValue)?$factorinfo->item(0)->nodeValue:'';
            $tmpArray[]=isset($factorinfo->item(1)->nodeValue)?$factorinfo->item(1)->nodeValue:'';
            $dpan=$cols->item(4)->getElementsByTagName('p');
            $tmpArray[]=$dpan->item(0)->nodeValue;
           $tmpArray[]=isset($dpan->item(1)->nodeValue)?$dpan->item(1)->nodeValue:'';
            $tmpArray[]=isset($dpan->item(2)->nodeValue)?$dpan->item(2)->nodeValue:'';
            
         
            $dataArray[]=$tmpArray;
        }
    } 
     $this->load->library('table');
    $tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" class="mytable">' );
    $this->table->set_template($tmpl); 
   echo $this->table->generate($dataArray); 
  }
} 