<?php

class Product extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
    }
    
    /*
     * hien thi danh sach san pham
     */
    function index()
    {
        // lay ra tong tat ca cac san pham
        $total_rows = $this->product_model->get_total();
        $this->data['total_rows'] = $total_rows;
        
        // load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows; // tong cac san pham
        $config['base_url'] = admin_url('product/index'); // link hien thi danh sach san pham
        $config['per_page'] = 10; // so luong san pham hien thi tren mot trang
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
        $name = $this->input->get('name');
        if ($name) {
            $input['like'] = array(
                'name',
                $name
            );
        }
        $catalog_id = $this->input->get('catalog');
        $catalog_id = intval($catalog_id);
        if ($catalog_id > 0) {
            $input['where']['catalog_id'] = $catalog_id;
        }
        
        // lay sanh sach san pham
        $list = $this->product_model->get_list($input);
        $this->data['list'] = $list;
        $input = array();
        $input['where'] = array(
            'parent_id' => 0
        );
        $this->load->model('catalog_model');
        $catalogs = $this->catalog_model->get_list($input);
        foreach ($catalogs as $row) {
            $input['where'] = array(
                'parent_id' => $row->id
            );
            $subs = $this->catalog_model->get_list($input);
            $row->subs = $subs;
        }
        $this->data['catalogs'] = $catalogs;
        
        // lay nội dung của biến message
        
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        
        // load view
        $this->data['temp'] = 'admin/product/index';
        $this->load->view('admin/main', $this->data);
    }

    function add()
    {
        
        // lay sanh sach san pham
        $input = array();
        $input['where'] = array(
            'parent_id' => 0
        );
        $this->load->model('catalog_model');
        $catalogs = $this->catalog_model->get_list($input);
        foreach ($catalogs as $row) {
            $input['where'] = array(
                'parent_id' => $row->id
            );
            $subs = $this->catalog_model->get_list($input);
            $row->subs = $subs;
        }
        $this->data['catalogs'] = $catalogs;
        // load view
        $this->data['temp'] = 'admin/product/add';
        $this->load->view('admin/main', $this->data);
        
        // load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên', 'required');
            $this->form_validation->set_rules('catalog', 'Thể loại', 'required');
            $this->form_validation->set_rules('price', 'Giá', 'required');
            
            // nhập liệu chính xác
            if ($this->form_validation->run()) {
                // them vao csdl
                $name = $this->input->post('name');
                $catalog_id = $this->input->post('catalog');
                $price = $this->input->post('price');
                $price = str_replace(',', '', $price);
                $discount = $this->input->post('discount');
                $discount = str_replace(',', '', $discount);
                
                // lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                $upload_path = './upload/product';
                
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $image_link = '';
                if ($upload_data['file_name']) {
                    $image_link = $upload_data['file_name'];
                }
                // upload cac anh kem theo
                $image_list = array();
                $image_list = $this->upload_library->upload_file($upload_path, 'image_list');
                $image_list = json_encode($image_list);
                // luu du lieu can them
                $data = array(
                    'name' => $name,
                    'catalog_id' => $catalog_id,
                    'price' => $price,
                    'image_link' => $image_link,
                    'image_list' => $image_list,
                    'discount' => $discount,
                    'warranty' => $this->input->post('warranty'),
                    'gifts' => $this->input->post('gifts'),
                    'site_title' => $this->input->post('site_title'),
                    'meta_desc' => $this->input->post('meta_desc'),
                    'meta_key' => $this->input->post('meta_key'),
                    'content' => $this->input->post('content'),
                    'created' => now()
                );
                // them moi vao csdl
                if ($this->product_model->create($data)) {
                    // tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                } else {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                // chuyen tới trang danh sách
                redirect(admin_url('product'));
            }
        }
    }

    function edit()
    {
        $id = $this->uri->rsegment('3');
        $product = $this->product_model->get_info($id);
        // pre($product);
        if (! $product) {
            
            $this->session->set_flashdata('message', 'không tồn tại dữ liệu này');
            redirect(admin_url('product'));
        }
        $this->data['product'] = $product;
        // lay sanh sach san pham
        $input = array();
        $input['where'] = array(
            'parent_id' => 0
        );
        $this->load->model('catalog_model');
        $catalogs = $this->catalog_model->get_list($input);
        foreach ($catalogs as $row) {
            $input['where'] = array(
                'parent_id' => $row->id
            );
            $subs = $this->catalog_model->get_list($input);
            $row->subs = $subs;
        }
        $this->data['catalogs'] = $catalogs;
        // load view
        $this->data['temp'] = 'admin/product/edit';
        $this->load->view('admin/main', $this->data);
        
        // load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên', 'required');
            $this->form_validation->set_rules('catalog', 'Thể loại', 'required');
            $this->form_validation->set_rules('price', 'Giá', 'required');
            
            // nhập liệu chính xác
            if ($this->form_validation->run()) {
                // them vao csdl
                $name = $this->input->post('name');
                $catalog_id = $this->input->post('catalog');
                $price = $this->input->post('price');
                $price = str_replace(',', '', $price);
                $discount = $this->input->post('discount');
                $discount = str_replace(',', '', $discount);
                
                // lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                $upload_path = './upload/product';
                
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $image_link = '';
                if (isset($upload_data['file_name'])) {
                    $image_link = $upload_data['file_name'];
                }
                // upload cac anh kem theo
                $image_list = array();
                $image_list = $this->upload_library->upload_file($upload_path, 'image_list');
                $image_list_json = json_encode($image_list);
                // pre($image_list_json);
                // luu du lieu can them
                $data = array(
                    'name' => $name,
                    'catalog_id' => $catalog_id,
                    'price' => $price,
                    'discount' => $discount,
                    'warranty' => $this->input->post('warranty'),
                    'gifts' => $this->input->post('gifts'),
                    'site_title' => $this->input->post('site_title'),
                    'meta_desc' => $this->input->post('meta_desc'),
                    'meta_key' => $this->input->post('meta_key'),
                    'content' => $this->input->post('content')
                );
                if ($image_link != '') {
                    $data['image_link'] = $image_link;
                }
                // pre($image_link);
                if (! empty($image_list)) {
                    $data['image_list'] = $image_list_json;
                }
                // them moi vao csdl
                if ($this->product_model->update($product->id, $data)) {
                    // tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                } else {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                // chuyen tới trang danh sách
                redirect(admin_url('product'));
            }
        }
    }
    
    /*
     * xoa
     */
    function xoa()
    {
        $id = $this->uri->rsegment(3);
        $this->_del($id);
        $this->session->set_flashdata('message', 'Bạn đã xóa thành công sản phẩm');
        redirect(admin_url('product'));
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
        $product = $this->product_model->get_info($id);
        if (! $product) {
            $this->session->set_flashdata('message', 'Không tồn tại sản phẩm này');
            redirect(admin_url('product'));
        }
        // thuc hien xoa san pham
        $this->product_model->delete($id);
        // xoa cac anh san pham
        $image_link = './upload/product' . $product->image_link;
        if (file_exists($image_link)) {
            unlink($image_link);
        }
        
        // xoa cac anh kem theo
        $image_list = json_encode($product->image_list);
        if (is_array($image_list)) {
            foreach ($image_list as $img) {
                $image_link = './upload/product' . $product->$img;
                if (file_exists($image_link)) {
                    unlink($image_link);
                }
            }
        }
    }
    
}