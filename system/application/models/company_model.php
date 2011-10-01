<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
      class Company_model extends Model {

      function Company_model ()
      {
        // Call the Model constructor
        parent::__construct();
         $this->load->helper('url'); 
      }
        //company model begins//
          
      function add_company($data) {   
      $this->db->insert('tbl_pharmacompany',$data); 
      }
      
      function list_company(){ 
      $qry="select * from tbl_pharmacompany";
      $res=$this->db->query($qry);
      return $res->result_array();
      }
      
      function edit_company($comp_id){
      $qry="select * from tbl_pharmacompany where comp_id='$comp_id'";
      $res=$this->db->query($qry);
      return $res->row_array();  
      }
      
      function update_company($data){
      $this->db->update('tbl_pharmacompany', $data,array('comp_id'=>$_POST['comp_id']));  
      }
      
      // medicine model begins //
      
      function add_medicine($data){
      $this->db->insert('tbl_medicine',$data);  
      }
      
      function comp_name(){
      $qry="select comp_id,comp_name from tbl_pharmacompany";
      $res=$this->db->query($qry);
      return $res->result_array(); 
      }
      
      function factor(){
      //$data['feed1']=$feed1;
      $qry="select * from factors order by fact_id";
      $res=$this->db->query($qry);
      return $res->result_array();  
      }
      
      function list_medicine(){
      $qry="select * from tbl_medicine";
      $res=$this->db->query($qry);
      return $res->result_array(); 
      }
      
      function edit_medicine($medical_id){
      $qry="select * from tbl_medicine where medical_id='$medical_id'";
      $res=$this->db->query($qry);
      return $res->row_array();  
      }
      
      function update_medicine($data){
      $this->db->update('tbl_medicine', $data,array('medical_id'=>$_POST['medical_id']));  
      }
   }  
      
   
   