<?php 
class company extends Controller {

  function company() {
          parent::Controller();
           $this->load->model('Company_model');
  }
  function index() {  
    //$this->loginscreen();
    
  }
  
  function company_view(){
    $this->load->view('company');
    $this->load->helper('form');
    $logindisplay='';
    $logindisplay.='<div align="center" class="login" >';
  }
  function add_company(){
     //$this->load->db('pwhdatabase');
     $this->load->model('Company_model');
  $data = array(
          'comp_name' => $this->input->post('companyName'),
          'phonenumber' => $this->input->post('PhoneNumber'),
          'email' => $this->input->post('Email')
          );
          
         //$this->db->insert('tbl_pharmacompany',$data); 
          $this->Company_model->add_company($data);
           $this->load->view('company',$data);
             redirect('/company/list_company');  
}
  
  function list_company(){
       
        $this->load->model('Company_model');
        $data['feed'] =  $this->Company_model->list_company();
        //print_r($data['feed']);exit();
        //$data['css'] = $this->config->item('css');
        //$user_id =$this->session->userdata('user_id');
        //$data['value']=$this->Model_print->name($user_id);
        $this->load->view('companylist_view',$data);
  }
  
  function edit_company($comp_id){
        $data=$this->Company_model->edit_company($comp_id);
        $this->load->view("companyedit_view", $data);
             
        }
  
  function update_company() {       
         $this->load->model('Company_model');
       $data = array(
          'comp_name' => $this->input->post('companyName'),
          'phonenumber' => $this->input->post('PhoneNumber'),
          'email' => $this->input->post('Email')
          );
      $this->Company_model->update_company($data);  
       redirect('/company/list_company');  
      //print_r($array);  exit;
    }
}