<?php

class Slide extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('slide_model');
    }
    
    /*
     * hien thi danh sach san pham
     */
    function index()
    {
        // lay ra tong tat ca cac slide
        $total_rows = $this->slide_model->get_total();
        $this->data['total_rows'] = $total_rows;
        
        $input = array();
        
        // lay sanh sach slide
        $list = $this->slide_model->get_list($input);
        $this->data['list'] = $list;
        //pre($list);
        // lay nội dung của biến message
        
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        
        // load view
        $this->data['temp'] = 'admin/slide/index';
        $this->load->view('admin/main', $this->data);
    }
    

    function add()
    {
        $this->data['temp'] = 'admin/slide/add';
        $this->load->view('admin/main', $this->data);
        // load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên slide', 'required');
            // nhập liệu chính xác
            if ($this->form_validation->run()) {
                // them vao csdl
              
                // lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                $upload_path = './upload/slide';
                
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $image_link = '';
                if (isset($upload_data['file_name'])) {
                    $image_link = $upload_data['file_name'];
                }
                // luu du lieu can them
                $data = array(
                    'name'          => $this->input->post('name'),
                    'image_link'    => $image_link,
                    'link'          => $this->input->post('link'),
                    'info'          => $this->input->post('info'),
                    'sort_order'    => $this->input->post('sort_order'),
                );
                // them moi vao csdl
                if ($this->slide_model->create($data)) {
                    // tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                } else {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                // chuyen tới trang danh sách
                redirect(admin_url('slide'));
            }
        }
       
    }

    function edit()
    {
        $id = $this->uri->rsegment('3');
        $slide = $this->slide_model->get_info($id);
        // pre($slide);
        if (! $slide) {
            
            $this->session->set_flashdata('message', 'không tồn tại bài viết này');
            redirect(admin_url('slide'));
        }
        $this->data['slide'] = $slide;
        // load view
        $this->data['temp'] = 'admin/slide/edit';
        $this->load->view('admin/main', $this->data);
        
        // load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên slide', 'required');
            
            // nhập liệu chính xác
            if ($this->form_validation->run()) {
                // them vao csdl
                
                // lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                $upload_path = './upload/slide';
                
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $image_link = '';
                if (isset($upload_data['file_name'])) {
                    $image_link = $upload_data['file_name'];
                }
                // luu du lieu can them
                 $data = array(
                    'name'          => $this->input->post('name'),
                    'link'          => $this->input->post('link'),
                    'info'          => $this->input->post('info'),
                    'sort_order'    => $this->input->post('sort_order'),
                );
                if ($image_link != '') {
                    $data['image_link'] = $image_link;
                }
                // them moi vao csdl
                if ($this->slide_model->update($slide->id, $data)) {
                    // tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                } else {
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                // chuyen tới trang danh sách
                redirect(admin_url('slide'));
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
        $this->session->set_flashdata('message', 'Bạn đã xóa thành công slide');
        redirect(admin_url('slide'));
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
        $slide = $this->slide_model->get_info($id);
        if (! $slide) {
            $this->session->set_flashdata('message', 'Không tồn tại slide này');
            redirect(admin_url('slide'));
        }
        // thuc hien xoa san pham
        $this->slide_model->delete($id);
        // xoa cac anh san pham
        $image_link = './upload/slide' . $slide->image_link;
        if (file_exists($image_link)) {
            unlink($image_link);
        }
        
    }
    
}