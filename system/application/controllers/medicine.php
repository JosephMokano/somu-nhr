<?php 
class medicine extends Controller {

  function medicine() {
          parent::Controller();
           $this->load->model('Company_model');
  }
  function index() {  
    //$this->loginscreen();
   
  }
  function medicine_view(){
     $data['feed'] =  $this->Company_model->comp_name();
   //print_r($data['feed']);exit;
     $this->load->view('medicine',$data);
  }
  function add_medicine(){
     //$this->load->db('pwhdatabase');
     $this->load->model('Company_model');
  $data = array(
          'medicine_name' => $this->input->post('medicineName'),
          'comp_name' => $this->input->post('companyName'),
          'medicine_type' => $this->input->post('type'),
          'notes' => $this->input->post('notes'),
          'others' => $this->input->post('others'),
          );
          
         $this->Company_model->add_medicine($data);
           $this->load->view('medicine',$data);
           redirect('/medicine/list_medicine');   
}
  
  function comp_name(){ 
    $this->load->model('Company_model');
   
    $this->load->view('medicine/medicine_view',$data);
  }
  
  function list_medicine(){
    $this->load->model('Company_model');
        $data['feed'] =  $this->Company_model->list_medicine();
        //print_r($data['feed']);exit();
        //$data['css'] = $this->config->item('css');
        //$user_id =$this->session->userdata('user_id');
        //$data['value']=$this->Model_print->name($user_id);
        $this->load->view('medicinelist_view',$data);
  }
  
  function edit_medicine($medical_id){
    $data=$this->Company_model->edit_medicine($medical_id);
    $this->load->view("medicineedit_view", $data);
  }
  
  function update_medicine(){
   $this->load->model('Company_model');
  $data = array(
          'medicine_name' => $this->input->post('medicineName'),
          'comp_name' => $this->input->post('companyName'),
          'medicine_type' => $this->input->post('type'),
          'notes' => $this->input->post('notes'),
          'others' => $this->input->post('others'),
          );
       $this->Company_model->update_medicine($data);  
       redirect('/medicine/list_medicine');  
  }
}