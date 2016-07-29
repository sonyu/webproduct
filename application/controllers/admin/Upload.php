<?php
class Upload extends MY_Controller {
	function index() {
		
		if($this->input->post('submit'))
		{
			$this->load->library('upload_library');
			$upload_path = './upload/user';
			$data = $this->upload_library->upload($upload_path,'image');
			pre($data);
		}
		
		$this->data['temp']='admin/upload/index';
		$this->load->view('admin/main',$this->data);
	}
}