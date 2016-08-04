<?php

class Product extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        
        // load model product
        $this->load->model('product_model');
    }
    
    /*
     * hien thi danh sach san pham
     */
    function catalog()
    {
        // lay ra id cua the loai
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        
        // lay ra thong tin cua danh muc cua the loai
        $catalog = $this->catalog_model->get_info($id);
        if (! $catalog) {
            redirect(base_url('product/catalog'));
        }
        $input = array();
        $this->data['catalog'] = $catalog;
        // kiem tra danh muc la con hay cha
        if ($catalog->parent_id == 0) {
            $input_catalog = array();
            $input_catalog['where'] = array(
                'parent_id' => $id
            );
            $catalog_subs = $this->catalog_model->get_list($input_catalog);
            //neu danh muc hien tai co danh muc con se lay tat ca cac san pham thuoc danh muc con
            if (! empty($catalog_subs)) {
                $catalog_subs_id = array();
                foreach ($catalog_subs as $subs) {
                    $catalog_subs_id[] = $subs->id;
                }
                $this->db->where_in('catalog_id', $catalog_subs_id);
            } else {
                $input['where'] = array(
                    'catalog_id' => $id
                );
            }
        } else {
            $input['where'] = array(
                'catalog_id' => $id
            );
        }
        
        // lay danh sach cua danh muc san pham do
        // lay ra tong tat ca cac san pham
        $total_rows = $this->product_model->get_total($input);
        $this->data['total_rows'] = $total_rows;
        
        // load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows; // tong cac san pham
        $config['base_url'] = base_url('product/catalog/' . $id); // link hien thi danh sach san pham
        $config['per_page'] = 6; // so luong san pham hien thi tren mot trang
        $config['uri_segment'] = 4; // phan doan hien thi trang so xxx
        $config['next_link'] = 'Trang kế tiếp';
        $config['prev_link'] = 'Trang trước';
        // khoi tao cac cau hinh phan trang
        $this->pagination->initialize($config);
        
        $segment = $this->uri->segment(4);
        $segment = intval($segment);
        
        $input['limit'] = array(
            $config['per_page'],
            $segment
        );
        
        // lay sanh sach san pham
        
        $list = $this->product_model->get_list($input);
        $this->data['list'] = $list;
        // hien thi ra phan view
        $this->data['temp'] = 'site/product/catalog';
        $this->load->view('site/layout', $this->data);
    }
    /*
     * xem chi tiet san pham
     */
    function view(){
        //lay id san pham
        $id = $this->uri->rsegment(3);
        $product = $this->product_model->get_info($id);
        if(!$product){
            redirect();
        }
        $this->data['product'] = $product;
        //lay ra danh sach anh
        //$image_list = json_decode($product->image_link);
        $image_list = json_decode($product->image_list);
        $this->data['image_list'] = $image_list;
        
        //cap nhat lai luot view
        $data = array();
        $data['view'] = $product->view+1;
        $this->product_model->update($product->id,$data);
        //lay thong tin cua danh muc san pham
        $catalog = $this->catalog_model->get_info($product->catalog_id);        
        $this->data['catalog'] = $catalog;
        // hien thi ra phan view
        $this->data['temp'] = 'site/product/view';
        $this->load->view('site/layout', $this->data);
    }
    /*
     * tim kiem theo ten san pham
     */
    function search(){
    	
    	if($this->uri->rsegment(3)==1){
    		//xu ly autocomplete
    		$key = $this->input->get('term');
    	}else{
    		$key = $this->input->get('key-search');
    	}
    	$this->data['key'] = trim($key);
    	$input['like'] = array('name',$key);
    	$list = $this->product_model->get_list($input);
    	$this->data['list'] = $list;
 
    	if($this->uri->rsegment(3)==1){
    		//xu ly autocomplete
    		$result = array();
    		foreach ($list as $row){
    			$item = array();
    			$item['id'] = $row->name;
    			$item['label'] = $row->name;
    			$result[] = $item;
    		}
    		die(json_encode($result));
    	}else{
    		//load view
    		$this->data['temp'] = 'site/product/search';
    		$this->load->view('site/layout', $this->data);
    	}
    }
    /*
     * tim kiem theo gia
     */
    function search_price(){
    	
    	$price_from = intval($this->input->get('price_from'));
    	$this->data['price_from'] = $price_from;
    	
    	$price_to = intval($this->input->get('price_to'));
    	$this->data['price_to'] = $price_to;
    	$input = array();
    	$input['where'] = array('price >='=>$price_from, 'price <='=>$price_to);
    	$list = $this->product_model->get_list($input);
    	$this->data['list'] = $list;
    	$this->data['temp'] = 'site/product/search_price';
    	$this->load->view('site/layout', $this->data);
    	//pre($list);
    }
}