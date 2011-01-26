<?php
Class flexgridtry extends Controller {

  function flexgridtry() {
          parent::Controller();
  }
  function index() {  
    $this->displaygrid();
  }
  function testfun(){
    $this->load->library("nhrpwhdetails");
    $this->nhrpwhdetails->fetch_factorwise();
  }
  function displaygrid(){
      $displaylist="Testing flex Grid";
      $headerdata = array(
        //'chapterName' => 0,
        'chapterName' => "Test Chapter",
        'username' => "No User Just list"
        );
       //FlexGrid Data Starts Here 
        $this->load->helper('flexigrid');
        
          /*
     * 0 - display name
     * 1 - width
     * 2 - sortable
     * 3 - align
     * 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.)
     */
    $colModel['patient_id'] = array('ID',40,TRUE,'center',2);
    $colModel['patient_first_name'] = array('Name',200,TRUE,'center',1);
    $colModel['patient_factor_level'] = array('Factor',20,TRUE,'center',0);
    
     /*
     * Aditional Parameters
     */
    $gridParams = array(
    'width' => '300',
    'height' => 400,
    'rp' => 15,
    'rpOptions' => '[10,15,20,25,40]',
    'pagestat' => 'Displaying: {from} to {to} of {total} items.',
    'blockOpacity' => 0.5,
    'title' => 'Hello',
    'showTableToggleBtn' => true
    );   
        
     
     /*
     * 0 - display name
     * 1 - bclass
     * 2 - onpress
     */
     $buttons=array();
     $buttons[] = array('separator');
    /*$buttons[] = array('Delete','delete','test');
    
    $buttons[] = array('Select All','add','test');
    $buttons[] = array('DeSelect All','delete','test');
    $buttons[] = array('separator');*/
     
     //Build js
    //View helpers/flexigrid_helper.php for more information about the params on this function
    $this->template->add_js('js/flexigrid.pack.js','import');
          $this->template->add_css('styles/flexigrid.css');
    $grid_js = build_grid_js('flex1',site_url("/flexgridtry/ajaxcall"),$colModel,'patient_id','asc',$gridParams,$buttons);
   
   //$this->template->add_js($grid_js, 'embed');
        
       // $this->template->write('js_grid', $grid_js);
   // $data['grid_js'] = $grid_js;
   //$this->template->write('pageheader1', 'upload profile photo');
       //FlexGrid Data Ends Here
       $data['grid_js']=$grid_js;
       $this->template->write_view('content','members/flexlist_member',$data, True);
        $this->template->render(); 
    //      $this->load->view('testview',$data);
  }

  function ajaxcall(){
    $this->load->library('flexigrid');
      //List of all fields that can be sortable. This is Optional.
    //This prevents that a user sorts by a column that we dont want him to access, or that doesnt exist, preventing errors.
    $valid_fields = array('patient_id','patient_first_name','patient_factor_level');
    
    $this->flexigrid->validate_post('patient_id','asc',$valid_fields);
    $this->load->model('patient_ajax_model','ajax_model');
    $records = $this->ajax_model->get_patientlist();
    
    $this->output->set_header($this->config->item('json_header'));
    
    /*
     * Json build WITH json_encode. If you do not have this function please read
     * http://flexigrid.eyeviewdesign.com/index.php/flexigrid/example#s3 to know how to use the alternative
     */
    foreach ($records['records']->result() as $row)
    {
      $record_items[] = array( $row->patient_id,
      $row->patient_id,
      $row->patient_first_name,
      $row->patient_factor_level
     
      );
    }
    //Print please
    $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    
  }
}  
?>