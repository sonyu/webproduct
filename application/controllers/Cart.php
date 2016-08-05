<?php
class Cart extends MY_Controller {
	function __construct() {
		parent::__construct ();
	}
	/*
	 * phuong thuoc them san pham vao gio hang
	 */
	function add() {
		// lay ra san pham muon them vao gio hang
		$this->load->model ( 'product_model' );
		
		$id = $this->uri->rsegment ( 3 );
		$product = $this->product_model->get_info ( $id );
		if (! $product) {
			redirect ();
		}
		// tong so san pham;
		$qty = 1;
		$price = $product->price;
		if ($product->discount > 0) {
			$price = $product->price - $product->discount;
		}
		$data = array ();
		$data ['id'] = $product->id;
		$data ['qty'] = $qty;
		$data ['name'] = url_title ( $product->name );
		$data ['image_link'] = $product->image_link;
		$data ['price'] = $product->price;
		$this->cart->insert ( $data );
		
		redirect ( base_url ( 'cart' ) );
	}
	
	/*
	 * danh sach gio hang
	 */
	function index() {
		
		// thong tin gio hang
		$carts = $this->cart->contents ();
		// tong so san pham co trong gio hang
		$total_items = $this->cart->total_items ();
		//pre($carts);
		$this->data ['carts'] = $carts;
		$this->data ['total_items'] = $total_items;
		
		$this->data ['temp'] = 'site/cart/index';
		$this->load->view ( 'site/layout', $this->data );
	}
	/*
	 * update gio hang
	 */
	function update() {
		$carts = $this->cart->contents ();
		foreach ( $carts as $key => $row ) {
			// tong so luong thanh pham
			$total_qty = $this->input->post ( 'qty_' . $row ['id'] );
			$data = array ();
			$data ['rowid'] = $key;
			$data ['qty'] = $total_qty;
			$this->cart->update ( $data );
		}
		redirect ( base_url ( 'cart' ) );
	}
	
	/*
	 * xoa cac san pham trong gio hang
	 */
	function del() {
		$id = $this->uri->rsegment ('3');
		$id = intval ( $id );
		// trong truong hop xoa 1 san pham nao do
		if ($id > 0) {
			
			$carts = $this->cart->contents ();
			// pre($carts);
			foreach ( $carts as $key => $row ) {
				// tong so luong thanh pham
				if ($row ['id'] == $id) {
					$data = array ();
					$data ['rowid'] = $key;
					// pre($key);
					$data ['qty'] = 0;
					$this->cart->update ( $data );
				}
			}
		} else {
			// xoa toan bo gio hang
			$this->cart->destroy ();
		}
		
		redirect ( base_url ( 'cart' ) );
	}
}