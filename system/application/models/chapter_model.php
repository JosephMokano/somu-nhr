<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Eye View Design CMS module Ajax Model
 *
 * PHP version 5
 *
 * @category  CodeIgniter
 * @package   Chapter Information
 * @copyright 2008 Tatwaa
 * @version   0.1
*/
class chapter_model extends Model 
{
  /**
  * Instanciar o CI
  */
  public function chapter_model()
    {
        parent::Model();
    $this->CI =& get_instance();
    }
  
  public function get_chapterlist($chapterid=0) 
  {
        $this->load->database();
    $qryCondiation='';
    if ($chapterid!=0){
      $qryCondiation=" where chapter_ID=".$chapterid;
    }
    $returnvalue = $this->db->query("Select chapter_ID,chapter_name from tbl_chapters ".$qryCondiation);
    return $returnvalue->result_array();
  }
}  
?>
