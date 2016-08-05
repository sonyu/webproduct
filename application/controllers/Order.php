<?php
class Order extends MY_Controller {
	function __construct() {
		parent::__construct ();
	}
	
	// lay thong tin của khách hàng
	function checkout() {
		$carts = $this->cart->contents ();
		$total_items = $this->cart->total_items ();
		//pre($carts);
		if ($total_items <= 0) {
			redirect ();
		}
		//tong so tien can thanh toan
		$total_amount = 0;
		foreach ($carts as $row){
			
			$total_amount =$total_amount + $row['subtotal'];
		}
		$this->data['total_amount'] = $total_amount;
		
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
			$this->form_validation->set_rules('email', 'Email nhận hàng', 'required|valid_email');
			$this->form_validation->set_rules('name', 'Tên', 'required|min_length[4]');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'required');
			$this->form_validation->set_rules('message', 'ghi chú', 'required');
			$this->form_validation->set_rules('payment', 'Cổng thanh toán', 'required');
			
			//nhập liệu chính xác
			if($this->form_validation->run())
			{
				//them vao csdl
				$payment = $this->input->post('payment');
		
				$data = array(
						'status' 		=> 0, //trang thai chua thanh toan
						'user_id'		=> $user_id,
						'user_email'    => $this->input->post('email'),
						'user_name'     => $this->input->post('name'),
						'user_phone'    => $this->input->post('phone'),
						'message'    	=> $this->input->post('message'),//ghi chu khi mua hang
						'amount'		=> $total_amount,
						'payment'		=> $payment,//cong thanh toan
						'created'		=> now()
				);
				//them du lieu vao bang transaction
				$this->load->model('transaction_model');
				//$this->load->model('order_model');
				$this->transaction_model->create($data);
				$transaction_id = $this->db->insert_id();//lay ra id của giao dich
				//them vao bang chi tiet don hang
				$this->load->model('order_model');
				foreach ($carts as $row){
					$data = array(
						
					'transaction_id' => $transaction_id,
					'product_id'	 => $row['id'],
					'qty'			 => $row['qty'],
					'amount'		 => $row['subtotal'],
					'status'		 => '0',
						);
					$this->order_model->create($data);  
				}
				// xoa toan bo gio hang
				$this->cart->destroy ();
				if($payment == 'offline'){
					//tạo ra nội dung thông báo
					$this->session->set_flashdata('message', 'Bạn đã đặt hàng thành công, chúng tôi sẽ kiểm tra và gửi hàng cho bạn');
					//chuyen tới trang danh sách quản trị viên
					redirect(site_url());
				}elseif (in_array($payment, array('nganluong','baokim'))){
					
				}
				
			}
		}
		
		$this->data ['temp'] = 'site/order/checkout';
		$this->load->view ( 'site/layout', $this->data );
	}
	
}