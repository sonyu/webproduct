<?php

class News extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
    }
    
    /*
     * hien thi danh sach san pham
     */
    function index()
    {
        // lay ra tong tat ca cac bai viet
        $total_rows = $this->news_model->get_total();
        $this->data['total_rows'] = $total_rows;
        
        // load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows; // tong cac san pham
        $config['base_url'] = admin_url('news/index'); // link hien thi danh sach san pham
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
        $title = $this->input->get('title');
        if ($title) {
            $input['like'] = array(
                'title',
                $title
            );
        }
        
        // lay sanh sach san pham
        $list = $this->news_model->get_list($input);
        $this->data['list'] = $list;
       
        // lay nội dung của biến message
        
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        
        // load view
        $this->data['temp'] = 'admin/news/index';
        $this->load->view('admin/main', $this->data);
    }
    

    function add()
    {
        $this->data['temp'] = 'admin/news/add';
        $this->load->view('admin/main', $this->data);
        // load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('content', 'Nội dung', 'required');
            
            // nhập liệu chính xác
            if ($this->form_validation->run()) {
                // them vao csdl
              
                // lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                $upload_path = './upload/news';
                
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $image_link = '';
                if ($upload_data['file_name']) {
                    $image_link = $upload_data['file_name'];
                }
                // luu du lieu can them
                $data = array(
                    'title' => $this->input->post('title'),
                    'image_link' => $image_link,
                    'meta_desc' => $this->input->post('meta_desc'),
                    'meta_key' => $this->input->post('meta_key'),
                    'content' => $this->input->post('content'),
                    'created' => now()
                );
                // them moi vao csdl
                if ($this->news_model->create($data)) {
                    // tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                } else {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                // chuyen tới trang danh sách
                redirect(admin_url('news'));
            }
        }
    }

    function edit()
    {
        $id = $this->uri->rsegment('3');
        $news = $this->news_model->get_info($id);
        // pre($news);
        if (! $news) {
            
            $this->session->set_flashdata('message', 'không tồn tại bài viết này');
            redirect(admin_url('news'));
        }
        $this->data['news'] = $news;
        // load view
        $this->data['temp'] = 'admin/news/edit';
        $this->load->view('admin/main', $this->data);
        
        // load thư viện validate dữ liệu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('content', 'Nội dung', 'required');
            
            // nhập liệu chính xác
            if ($this->form_validation->run()) {
                // them vao csdl
                
                // lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                $upload_path = './upload/news';
                
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $image_link = '';
                if (isset($upload_data['file_name'])) {
                    $image_link = $upload_data['file_name'];
                }
                // luu du lieu can them
               $data = array(
                    'title' => $this->input->post('title'),
                    'meta_desc' => $this->input->post('meta_desc'),
                    'meta_key' => $this->input->post('meta_key'),
                    'content' => $this->input->post('content'),
                    'created' => now()
                );
                if ($image_link != '') {
                    $data['image_link'] = $image_link;
                }
                // them moi vao csdl
                if ($this->news_model->update($news->id, $data)) {
                    // tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                } else {
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                // chuyen tới trang danh sách
                redirect(admin_url('news'));
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
        $this->session->set_flashdata('message', 'Bạn đã xóa thành công bài viết');
        redirect(admin_url('news'));
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
        $news = $this->news_model->get_info($id);
        if (! $news) {
            $this->session->set_flashdata('message', 'Không tồn tại bài viết này');
            redirect(admin_url('news'));
        }
        // thuc hien xoa san pham
        $this->news_model->delete($id);
        // xoa cac anh san pham
        $image_link = './upload/news' . $news->image_link;
        if (file_exists($image_link)) {
            unlink($image_link);
        }
        
    }
    
}