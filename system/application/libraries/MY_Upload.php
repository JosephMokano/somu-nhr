<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Extension of Upload Class to output special data
 *
 */
 
class MY_Upload extends CI_Upload {

	public $CI;

	public function __construct($props = array())
	{
		parent::__construct();

		if (count($props) > 0)
		{
			$this->initialize($props);
		}

		log_message('debug', "Upload Class Initialized");
	}

	public function data()
	{
		return array (
						'file_name'			=> $this->file_name,
						'file_type'			=> $this->file_type,
						'file_path'			=> $this->upload_path,
						'full_path'			=> $this->upload_path.$this->file_name,
						'raw_name'			=> str_replace($this->file_ext, '', $this->file_name),
						'orig_name'			=> $this->orig_name,
						
						'file_ext'			=> $this->file_ext,
						'file_size'			=> $this->file_size,
						'is_image'			=> $this->is_image(),
						'image_width'		=> $this->image_width,
						'image_height'		=> $this->image_height,
						'image_type'		=> $this->image_type,
						'image_size_str'	=> $this->image_size_str,
						// new file url key
						'file_url'			=> $this->file_url($this->upload_path.$this->file_name),
					);
	}

	/*
	 * New function creates a URL to the file that was uploaded
	 *
	*/
	public function file_url($full_path)
	{
		$this->CI = get_instance();

		$this->CI->config->load('uploading_script');

		$path_parts = explode('/', $full_path);

		$target_dir = FALSE;

		$upload_dir = $this->CI->config->item('upload_dir');

		$file_url = '';

		for($x=0; $x <= count($path_parts)-1; $x++)
		{
			if($path_parts[$x] == $upload_dir OR $target_dir == 'reached')
			{
				$file_url .= '/' . $path_parts[$x];
				$target_dir = 'reached';
			}
		}
		return $file_url;
	}
 /*
  * Required Javascript for uploading
*/
function upload_js_script($fileArray){
  
  $retValue='
 
 <script type="text/javascript" src="/js/ajaxupload.js"></script>
 <script type="text/javascript" src="/js/uploadscript.js"></script>
   
  ';
  return $retValue;
}
 /*
  * Required Javascript for uploading
*/
function uploadify_js_script(){
  
  $retValue='/js/uploadify/jquery.uploadify-3.1.min.js';
  return $retValue;
}


function uploadframe_ui($buttonStyle=''){
  $retvalue='<div id="upload-div">
   <div class="text"></div>
   <div class="loadedfilelist"></div>
   <div id="loader_overlay" class="loader_overlay_BG"></div>
  <div id="loader" class="loading">Loading</div>
  
   <a href="#" id="upload_button" class="button medium white">Select File</a>
   </div>';
   return $retvalue;
}
}

/* End of file MY_Upload.php */
/* Location: ./application/libraries/MY_Upload.php */
