<?php

class Set_Controller extends MY_Controller {

    protected $child1_name_Str = 'shop';
    protected $child2_name_Str = 'order_shop';
    protected $child3_name_Str = 'set';

    public function __construct()
    {
        parent::__construct();
        $data = $this->data;

        $this->load->model('AdminModel');
        $this->AdminModel->child1_name_Str = $this->child1_name_Str;
        $this->AdminModel->child2_name_Str = $this->child2_name_Str;
        $this->AdminModel->child3_name_Str = $this->child3_name_Str;

        if(empty($data['User']->uid_Num))
        {
            $url = base_url('user/login/?url=admin');
            header('Location: '.$url);
            return FALSE;
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function set()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data([
            'child4_name_Str' => 'set'//管理分類名稱
        ]));

        //global
        $data['global']['style'][] = 'admin/global.css';
        $data['global']['js'][] = 'admin.js';

        //temp
        $data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
        $data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
        $data['temp']['admin_header_bar'] = $this->load->view('admin/temp/admin_header_bar', $data, TRUE);
        $data['temp']['admin_footer_bar'] = $this->load->view('admin/temp/admin_footer_bar', $data, TRUE);
        $data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);

        //輸出模板
        $this->load->view('admin/'.$data['admin_child_url_Str'], $data);
    }

    public function set_destroy_post()
    {
        $OrderShopList = new ObjList([
            'db_where_Arr' => [
                'status' => -1,
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'OrderShop',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);
        foreach ($OrderShopList->obj_Arr as $key => $value_order_shop)
        {
            $OrderShop = new OrderShop(['orderid_Num' => $value_order_shop->orderid_Num]);
            $OrderShop->destroy();
            
            $CartShop_List = new ObjList([
                'db_where_Arr' => [
                    'orderid_Num' => $OrderShop->orderid_Num,
                ],
                'db_where_deletenull_Bln' => TRUE,
                'model_name_Str' => 'CartShop',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ]);

            $CartShop2_List = new ObjList([
                'db_where_Arr' => [
                    'orderid_Num' => $OrderShop->orderid_Num,
                    'status' => -1,
                ],
                'db_where_deletenull_Bln' => TRUE,
                'model_name_Str' => 'CartShop',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ]);

            foreach ($CartShop_List->obj_Arr as $key => $value_cart_shop)
            {
                $CartShop = new CartShop(['cartid_Num' => $value_cart_shop->cartid_Num]);
                $CartShop->destroy();
            }
            foreach ($CartShop2_List->obj_Arr as $key => $value_cart_shop2)
            {
                $CartShop2 = new CartShop(['cartid_Num' => $value_cart_shop2->cartid_Num]);
                $CartShop2->destroy();
            }
        }

        if(!empty($OrderShopList->obj_Arr))
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => '銷毀成功',
                'url' => 'admin/shop/order_shop/set/set'
            ]);
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => '已無可銷毀的項目',
                'url' => 'admin/shop/order_shop/set/set'
            ]);
        }
    }

    public function set_recovery_post()
    {
        $OrderShopList = new ObjList([
            'db_where_Arr' => [
                'status' => -1,
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'OrderShop',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);
        foreach ($OrderShopList->obj_Arr as $key => $value_order_shop)
        {
            $OrderShop = new OrderShop(['orderid_Num' => $value_order_shop->orderid_Num]);
            $OrderShop->recovery();
        }

        if(!empty($OrderShopList->obj_Arr))
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => '復原成功',
                'url' => 'admin/shop/order_shop/set/set'
            ]);
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => '已無可復原的項目',
                'url' => 'admin/shop/order_shop/set/set'
            ]);
        }
    }

}

?>