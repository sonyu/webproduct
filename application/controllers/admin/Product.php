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
        //lay ra tong tat ca cac san pham
        $total_rows=$this->product_model->get_total();
        $this->data['total_rows']=$total_rows;
        
        // load ra thu vien phan trang
        $this->load->library('pagination');
        $config=array();
        $config['total_rows']=$total_rows;//tong cac san pham
        $config['base_url']= admin_url('product/index');//link hien thi danh sach san pham
        $config['per_page']=10;//so luong san pham hien thi tren mot trang
        $config['uri_segment']=4;//phan doan hien thi trang so xxx
        $config['next_link']='Trang kế tiếp';
        $config['prev_link']='Trang trước';
        //khoi tao cac cau hinh phan trang
        $this->pagination->initialize($config);
        
        $segment = $this->uri->segment(4);
        $segment = intval($segment);
        $input = array();
        $input['limit']= array($config['per_page'],$segment);
        
        //kiem tra dieu kien loc
        $id= $this->input->get('id');
        $id= intval($id);
        $input['where'] = array();
        if($id>0){
            $input['where']['id']=$id;
        }
        $name = $this->input->get('name');
        if($name){
            $input['like'] = array('name',$name);
        }
        $catalog_id = $this->input->get('catalog');
        $catalog_id= intval($catalog_id);
        if($catalog_id>0){
            $input['where']['catalog_id'] =$catalog_id;        }
        
        //lay sanh sach san pham
        $list = $this->product_model->get_list($input);
        $this->data['list']=$list;
        $input = array();
        $input['where']=array('parent_id'=>0);
        $this->load->model('catalog_model');
        $catalogs= $this->catalog_model->get_list($input);
        foreach ($catalogs as  $row){
            $input['where']=array('parent_id'=> $row->id);
            $subs = $this->catalog_model->get_list($input);
            $row->subs = $subs;
        }
        $this->data['catalogs']=$catalogs;
        
        //lay nội dung của biến message
        
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        
        // load view
        $this->data['temp'] = 'admin/product/index';
        $this->load->view('admin/main', $this->data);
    }
}