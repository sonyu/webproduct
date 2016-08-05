<?php

class Transaction extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('transaction_model');
    }
    
    /*
     * hien thi danh sach giao dich
     */
    function index()
    {
        // lay ra tong tat ca cac giao dich
        $total_rows = $this->transaction_model->get_total();
        $this->data['total_rows'] = $total_rows;
        
        // load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows; // tong cac giao dich
        $config['base_url'] = admin_url('transaction/index'); // link hien thi danh sach giao dich
        $config['per_page'] = 10; // so luong giao dich hien thi tren mot trang
        $config['uri_segment'] = 4; // phan doan hien thi trang so xxx
        $config['next_link'] = 'Trang kế tiếp';
        $config['prev_link'] = 'Trang trước';
        // khoi tao cac cau hinh phan trang
        $this->pagination->initialize($config);
        
        $segment = $this->uri->segment(4);
        $segment = intval($segment);
        $input = array();
        $input['limit'] = array(
            $config['per_page'],
            $segment
        );
        
        // kiem tra dieu kien loc
        $id = $this->input->get('id');
        $id = intval($id);
        $input['where'] = array();
        if ($id > 0) {
            $input['where']['id'] = $id;
        }
        // lay sanh sach giao dich
        $list = $this->transaction_model->get_list($input);
        $this->data['list'] = $list;
        
        // lay nội dung của biến message
        
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        
        // load view
        $this->data['temp'] = 'admin/transaction/index';
        $this->load->view('admin/main', $this->data);
    }
    
    /*
     * xoa
     */
    function xoa()
    {
    	$id = $this->uri->rsegment(3);
    	$this->_del($id);
    	$this->session->set_flashdata('message', 'Bạn đã xóa thành công giao dịch');
    	redirect(admin_url('transaction'));
    }
    /*
     * xoa nhieu san pham
     */
    function del_all()
    {
    	$ids = $this->input->post('ids');
    	foreach ($ids as $id){
    
    		$this->_del($id);
    	}
    }
    
    private function _del($id)
    {
    	$transaction = $this->transaction_model->get_info($id);
    	if (! $transaction) {
    		$this->session->set_flashdata('message', 'Không tồn tại giao dịch này');
    		redirect(admin_url('transaction'));
    	}
    	// thuc hien xoa san pham
    	$this->transaction_model->delete($id);
    	
    }
}