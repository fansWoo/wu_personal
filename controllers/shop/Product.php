<?php

class Product_Controller extends MY_Controller {

    public $data = array();

    function __construct()
    {
        parent::__construct();
        $data = $this->data;

        $this->load->helper('form');
        $this->load->library('form_validation');
    }
    
    public function index(){
        $data = $this->data;

        $data['product_ProductList'] = new ObjList([
            'db_orderby_Arr' => array(
                array('prioritynum', 'DESC'),
                array('productid', 'DESC')
            ),
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'ProductShop',
            'limitstart_Num' => 0,
            'limitcount_Num' => 20
        ]);

        $data['search_class_slug_Str'] = $this->input->get('class_slug');

        $class_ClassMeta = new ClassMeta([
            'db_where_Arr' => array(
                'modelname' => 'showpiece',
                'slug' => $data['search_class_slug_Str']
            ),
            'db_where_deletenull_Bln' => FALSE
        ]);

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 1;

        $data['class_ClassMetaList'] = new ObjList([
            'db_where_Arr' => array(
                'modelname_Str' => 'showpiece'
            ),
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);
        
        //global
        $data['global']['style'][] = 'temp/global.css';
        $data['global']['style'][] = 'temp/header_bar.css';
        $data['global']['style'][] = 'temp/footer_bar.css';
        $data['global']['style'][] = 'shop/product/index.css';
       
        //temp
        $data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
        $data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
        $data['temp']['header_bar'] = $this->load->view('temp/header_bar', $data, TRUE);
        $data['temp']['footer_bar'] = $this->load->view('temp/footer_bar', $data, TRUE);
        $data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);
        
        //輸出模板
        $this->load->view('shop/product/index', $data);
    }
    
    public function view($productid_Num = 0)
    {
        $data = $this->data;
        
        if(empty($productid_Num))
        {
            $productid_Num = $this->input->get('productid');
        }

        if(!empty($productid_Num))
        {
            $data['ProductShop'] = new ProductShop([
                'db_where_Arr' => array(
                    'productid_Num' => $productid_Num
                )
            ]);
        }
        
        if( empty( $data['ProductShop']->productid_Num ) )
        {
            $Message = $this->load->model('Message', nrnum());
            $Message->show(array('message' => '產品連結輸入錯誤', 'url' => 'product'));
        }
        
        //global
        $data['global']['style'][] = 'temp/global.css';
        $data['global']['style'][] = 'temp/header_bar.css';
        $data['global']['style'][] = 'temp/footer_bar.css';
        $data['global']['style'][] = 'shop/product/view.css';
       
        //temp
        $data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
        $data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
        $data['temp']['header_bar'] = $this->load->view('temp/header_bar', $data, TRUE);
        $data['temp']['footer_bar'] = $this->load->view('temp/footer_bar', $data, TRUE);
        $data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);
        
        
        //輸出模板
        $this->load->view('shop/product/view', $data);
    }

}

?>