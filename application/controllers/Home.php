<?php
Class Home extends MY_Controller
{
	function index()
	{
		$data = array();
		$data['temp'] = 'site/home/index';
		$this->load->view('site/layout', $data);
	}
}