<?php
class Order extends MY_Controller {
	function __construct() {
		parent::__construct ();
	}
	
	// lay thong tin của khách hàng
	function checkout() {
		$carts = $this->cart->contents ();
		$total_items = $this->cart->total_items ();
		if ($total_items <= 0) {
			redirect ();
		}
		
		// nếu thành viên đã đăng nhập thì lấy thông tin của thành viên
		$user_id = 0;
		$user='';
		if ($this->session->userdata ('user_id_login')) {
			$user_id = $this->session->userdata ( 'user_id_login' );
			$user = $this->user_model->get_info ( $user_id );
		}
		// lay thong tin của thanh viên
		$this->data['user'] = $user;
		
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		//neu ma co du lieu post len thi kiem tra
		if($this->input->post())
		{
			$this->form_validation->set_rules('name', 'Tên', 'required|min_length[4]');
			$this->form_validation->set_rules('email', 'Email nhận hàng', 'required|valid_email');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'required');
			$this->form_validation->set_rules('address', 'Địa chỉ', 'required');
			
			//nhập liệu chính xác
			if($this->form_validation->run())
			{
				//them vao csdl
		
		
				$data = array(
						'name'     => $this->input->post('name'),
						'phone'     => $this->input->post('phone'),
						'address'     => $this->input->post('address'),
				);
				if($password){
		
					$data['password'] = md5($password);
				}
				if($this->user_model->update($user_id,$data))
				{
					//tạo ra nội dung thông báo
					$this->session->set_flashdata('message', 'Cập nhật thành công');
				}else{
					$this->session->set_flashdata('message', 'Không cập nhật được');
				}
				//chuyen tới trang danh sách quản trị viên
				redirect(site_url('user'));
			}
		}
		
		$this->data ['temp'] = 'site/order/checkout';
		$this->load->view ( 'site/layout', $this->data );
	}
	
}