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
    
    public function index()
    {
        $data = $this->data;

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 1;

        $data['search_class_slug_Str'] = $this->input->get('class_slug');

        $data['class_ClassMeta'] = new ClassMeta();
        $data['class_ClassMeta']->construct_db(array(
            'db_where_Arr' => array(
                'modelname' => 'product_shop',
                'slug' => $data['search_class_slug_Str']
            ),
            'db_where_deletenull_Bln' => FALSE
        ));
		
		$data['product_ProductList'] = new ObjList();
		$data['product_ProductList']->construct_db(array(
			'db_where_Arr' => array(
				'shelves_status_Num' => 1
			),
			'db_where_or_Arr' => array(
				'classids' => array($data['class_ClassMeta']->classid_Num)
			),
			'db_orderby_Arr' => array(
				'prioritynum' => 'DESC',
				'updatetime' => 'DESC'
			),
			'db_where_deletenull_Bln' => TRUE,
			'model_name_Str' => 'ProductShop',
			'limitstart_Num' => $limitstart_Num,
			'limitcount_Num' => $limitcount_Num
		));
        $data['page_link'] = $data['product_ProductList']->create_links(array('base_url_Str' => 'shop/product/?class_slug='.$data['search_class_slug_Str']));

        $data['class_ClassMetaList'] = new ObjList();
        $data['class_ClassMetaList']->construct_db(array(
            'db_where_Arr' => array(
                'modelname_Str' => 'product_shop'
            ),
            'db_orderby_Arr' => array(
                'prioritynum' => 'DESC',
                'classid' => 'DESC'
            ),
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ));

        $data['class2_ClassMetaList'] = new ObjList();
        $data['class2_ClassMetaList']->construct_db(array(
            'db_where_Arr' => array(
                'modelname_Str' => 'product_shop_class2'
            ),
            'db_orderby_Arr' => array(
                'prioritynum' => 'DESC',
                'classid' => 'DESC'
            ),
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ));
        
        //global
        $data['global']['style'][] = 'temp/global.css';
        $data['global']['style'][] = 'temp/header_bar.css';
        $data['global']['style'][] = 'temp/footer_bar.css';
        $data['global']['style'][] = 'shop/product/index.css';
		$data['global']['style'][] = 'shop/product/left_nav_box.css';

        $data['global']['js'][] = 'tool/smooth_scrollerator.js';
        $data['global']['js'][] = 'tool/cycle2.js';
        $data['global']['js'][] = 'payfor.js';
       
        //temp
        $data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
        $data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
        $data['temp']['header_bar'] = $this->load->view('temp/header_bar', $data, TRUE);
		$data['temp']['left_nav_box'] = $this->load->view('shop/product/left_nav_box', $data, TRUE);
        $data['temp']['footer_bar'] = $this->load->view('temp/footer_bar', $data, TRUE);
        $data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);
        
        //輸出模板
        $this->load->view('shop/product/index', $data);
    }

    public function view($productid_Num = 0)
    {
        $data = $this->data;
        
        $user_groupid = $data['User']->group_UserGroupList->obj_Arr[0]->groupid_Num;

        $data['ProductShop'] = new ProductShop();
        
        if(empty($productid_Num))
        {
            $productid_Num = $this->input->get('productid');
        }
        if(!empty($productid_Num))
        {
            if(($user_groupid) == 2 || ($user_groupid) == 1)
            {
                $data['ProductShop']->construct_db(array(
                    'db_where_Arr' => array(
                        'productid_Num' => $productid_Num,
                        'name !=' => 'Customized Glove'
                    )
                ));
            }
            else
            {
                $data['ProductShop']->construct_db(array(
                    'db_where_Arr' => array(
                        'productid_Num' => $productid_Num,
                        'shelves_status_Num' => 1 //上架中產品
                    )
                ));
            }
        }
        $productid_Num = $data['ProductShop']->productid_Num;

        if(empty($productid_Num))
        {
            $Message = $this->load->model('Message', nrnum());
            $Message->show(array('message' => 'Product link errors', 'url' => 'product'));
        }

        $data['StockProductShop'] = new StockProductShop();
        $data['StockProductShop']->construct_db(array(
            'db_where_Arr' => array(
                'productid_Num' => $productid_Num
            )
        ));

        $data['product_synopsis_Arr'] = explode("end", str_replace(chr(10),'end',$data['ProductShop']->synopsis_Str));
        
        $data['class_ClassMeta'] = new ClassMeta();
        $data['class_ClassMeta']->construct_db(array(
            'db_where_Arr' => array(
                'modelname' => 'product_shop',
                'slug' => $data['ProductShop']->class_ClassMetaList->obj_Arr[0]->slug_Str
            ),
            'db_where_deletenull_Bln' => FALSE
        ));

        $data['class_ClassMetaList'] = new ObjList();
        $data['class_ClassMetaList']->construct_db(array(
            'db_where_Arr' => array(
                'modelname_Str' => 'product_shop'
            ),
            'db_orderby_Arr' => array(
                'prioritynum' => 'DESC',
                'classid' => 'DESC'
            ),
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ));

        $data['class2_ClassMetaList'] = new ObjList();
        $data['class2_ClassMetaList']->construct_db(array(
            'db_where_Arr' => array(
                'modelname_Str' => 'product_shop_class2'
            ),
            'db_orderby_Arr' => array(
                'prioritynum' => 'DESC',
                'classid' => 'DESC'
            ),
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ));

         //global
        $data['global']['style'][] = 'temp/global.css';
        $data['global']['style'][] = 'temp/header_bar.css';
        $data['global']['style'][] = 'temp/footer_bar.css';
        $data['global']['style'][] = 'shop/product/view.css';
		$data['global']['style'][] = 'shop/product/left_nav_box.css';

        $data['global']['js'][] = 'tool/smooth_scrollerator.js';
        $data['global']['js'][] = 'tool/cycle2.js';
        $data['global']['js'][] = 'payfor.js';
       
        //temp
        $data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
        $data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
        $data['temp']['header_bar'] = $this->load->view('temp/header_bar', $data, TRUE);
		$data['temp']['left_nav_box'] = $this->load->view('shop/product/left_nav_box', $data, TRUE);
        $data['temp']['footer_bar'] = $this->load->view('temp/footer_bar', $data, TRUE);
        $data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);
        
        //輸出模板
        $this->load->view('shop/product/view', $data);
    }
}

?>