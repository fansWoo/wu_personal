<?php

class Global_Controller extends MY_Controller {

    protected $child1_name_Str = 'shop';
    protected $child2_name_Str = 'store';
    protected $child3_name_Str = 'global';

    public function __construct()
    {
        parent::__construct();
        $data = $this->data;

        $this->load->model('AdminModel');
        $this->AdminModel->child1_name_Str = $this->child1_name_Str;
        $this->AdminModel->child2_name_Str = $this->child2_name_Str;
        $this->AdminModel->child3_name_Str = $this->child3_name_Str;

        if($data['User']->uid_Num == '')
        {
            $url = base_url('user/login/?url=admin');
            header('Location: '.$url);
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function hot()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'hot'//管理分類名稱
        )));

        $shop_hot_product_Setting = new Setting();
        $shop_hot_product_Setting->construct_db([
            'db_where_Arr' => [
                'keyword' => 'shop_hot_product'
            ]
        ]);
        $data['global']['shop_hot_product'] = $shop_hot_product_Setting->value_Str;

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

    public function hot_post()
    {

        $shop_hot_product = $this->input->post('shop_hot_product', TRUE);

        $SettingList = new SettingList();
        $SettingList->construct([
            'construct_Arr' => [
                [
                    'keyword_Str' => 'shop_hot_product',
                    'value_Str' => $shop_hot_product,
                    'modelname_Str' => 'shop'
                ]
            ]
        ]);
        $SettingList->update();

        //送出成功訊息
        $this->load->model('Message');
        $this->Message->show(array(
            'message' => '設定成功',
            'url' => 'admin/shop/store/global/hot'
        ));
    }

    public function coupon()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'coupon'//管理分類名稱
        )));

        $data['coupon_SettingList'] = new SettingList();
        $data['coupon_SettingList']->construct_db([
            'db_where_Arr' => [
                'modelname' => 'shop_coupon'
            ]
        ]);

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

    public function coupon_rule_post()
    {
        $shop_rule_use_coupon_count_Num = $this->input->post('shop_rule_use_coupon_count_Num', TRUE);
        $shop_rule_use_get_coupon_count_Num = $this->input->post('shop_rule_use_get_coupon_count_Num', TRUE);

        $SettingList = new SettingList();
        $SettingList->construct([
            'construct_Arr' => [
                [
                    'keyword_Str' => 'shop_rule_use_coupon_count',
                    'value_Str' => $shop_rule_use_coupon_count_Num,
                    'modelname_Str' => 'shop_coupon'
                ],
                [
                    'keyword_Str' => 'shop_rule_use_get_coupon_count',
                    'value_Str' => $shop_rule_use_get_coupon_count_Num,
                    'modelname_Str' => 'shop_coupon'
                ]
            ]
        ]);
        $SettingList->update();

        //送出成功訊息
        $this->load->model('Message');
        $this->Message->show(array(
            'message' => '設定成功',
            'url' => 'admin/shop/store/global/coupon'
        ));
    }

    public function coupon_get_post()
    {
        $shop_user_register_get_coupon_count_Num = $this->input->post('shop_user_register_get_coupon_count_Num', TRUE);
        $shop_rule_coupon_count_Num = $this->input->post('shop_rule_coupon_count_Num', TRUE);
        $shop_rule_get_coupon_count_Num = $this->input->post('shop_rule_get_coupon_count_Num', TRUE);

        $SettingList = new SettingList();
        $SettingList->construct([
            'construct_Arr' => [
                [
                    'keyword_Str' => 'shop_user_register_get_coupon_count',
                    'value_Str' => $shop_user_register_get_coupon_count_Num,
                    'modelname_Str' => 'shop_coupon'
                ],
                [
                    'keyword_Str' => 'shop_rule_coupon_count',
                    'value_Str' => $shop_rule_coupon_count_Num,
                    'modelname_Str' => 'shop_coupon'
                ],
                [
                    'keyword_Str' => 'shop_rule_get_coupon_count',
                    'value_Str' => $shop_rule_get_coupon_count_Num,
                    'modelname_Str' => 'shop_coupon'
                ]
            ]
        ]);
        $SettingList->update();

        //送出成功訊息
        $this->load->model('Message');
        $this->Message->show(array(
            'message' => '設定成功',
            'url' => 'admin/shop/store/global/coupon'
        ));
    }

    public function tradein()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'tradein'//管理分類名稱
        )));

        $data['tradein_SettingList'] = new SettingList();
        $data['tradein_SettingList']->construct_db([
            'db_where_Arr' => [
                'modelname' => 'shop_tradein'
            ]
        ]);

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

    public function tradein_post()
    {
        $shop_rule_use_tradein_money_Num = $this->input->post('shop_rule_use_tradein_money_Num', TRUE);
        $shop_rule_get_tradein_money_Num = $this->input->post('shop_rule_get_tradein_money_Num', TRUE);
        $shop_rule_get_tradein_money_type_Str = $this->input->post('shop_rule_get_tradein_money_type_Str', TRUE);
        $shop_rule_use_tradein_count_Num = $this->input->post('shop_rule_use_tradein_count_Num', TRUE);
        $shop_rule_get_tradein_count_Num = $this->input->post('shop_rule_get_tradein_count_Num', TRUE);
        $shop_rule_get_tradein_count_type_Str = $this->input->post('shop_rule_get_tradein_count_type_Str', TRUE);

        $SettingList = new SettingList();
        $SettingList->construct([
            'construct_Arr' => [
                [
                    'keyword_Str' => 'shop_rule_use_tradein_money',
                    'value_Str' => $shop_rule_use_tradein_money_Num,
                    'modelname_Str' => 'shop_tradein'
                ],
                [
                    'keyword_Str' => 'shop_rule_get_tradein_money',
                    'value_Str' => $shop_rule_get_tradein_money_Num,
                    'modelname_Str' => 'shop_tradein'
                ],
                [
                    'keyword_Str' => 'shop_rule_get_tradein_money_type',
                    'value_Str' => $shop_rule_get_tradein_money_type_Str,
                    'modelname_Str' => 'shop_tradein'
                ],
                [
                    'keyword_Str' => 'shop_rule_use_tradein_count',
                    'value_Str' => $shop_rule_use_tradein_count_Num,
                    'modelname_Str' => 'shop_tradein'
                ],
                [
                    'keyword_Str' => 'shop_rule_get_tradein_count',
                    'value_Str' => $shop_rule_get_tradein_count_Num,
                    'modelname_Str' => 'shop_tradein'
                ],
                [
                    'keyword_Str' => 'shop_rule_get_tradein_count_type',
                    'value_Str' => $shop_rule_get_tradein_count_type_Str,
                    'modelname_Str' => 'shop_tradein'
                ]
            ]
        ]);
        $SettingList->update();

        //送出成功訊息
        $this->load->model('Message');
        $this->Message->show(array(
            'message' => '設定成功',
            'url' => 'admin/shop/store/global/tradein'
        ));
    }

    public function transfer()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'transfer'//管理分類名稱
        )));

        $data['transfer_SettingList'] = new SettingList();
        $data['transfer_SettingList']->construct_db([
            'db_where_Arr' => [
                'modelname' => 'shop_transfer'
            ]
        ]);

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

    public function transfer_post()
    {

        $bank_code_Str = $this->input->post('bank_code_Str', TRUE);
        $bank_account_Str = $this->input->post('bank_account_Str', TRUE);
        $bank_account_name_Str = $this->input->post('bank_account_name_Str', TRUE);
        $bank_account_remark_Str = $this->input->post('bank_account_remark_Str', TRUE);

        $SettingList = new SettingList();
        $SettingList->construct([
            'construct_Arr' => [
                [
                    'keyword_Str' => 'bank_code',
                    'value_Str' => $bank_code_Str,
                    'modelname_Str' => 'shop_transfer'
                ],
                [
                    'keyword_Str' => 'bank_account',
                    'value_Str' => $bank_account_Str,
                    'modelname_Str' => 'shop_transfer'
                ],
                [
                    'keyword_Str' => 'bank_account_name',
                    'value_Str' => $bank_account_name_Str,
                    'modelname_Str' => 'shop_transfer'
                ],
                [
                    'keyword_Str' => 'bank_account_remark',
                    'value_Str' => $bank_account_remark_Str,
                    'modelname_Str' => 'shop_transfer'
                ]

            ]
        ]);
        $SettingList->update();

        //送出成功訊息
        $this->load->model('Message');
        $this->Message->show(array(
            'message' => '設定成功',
            'url' => 'admin/shop/store/global/transfer'
        ));
    }
}

?>