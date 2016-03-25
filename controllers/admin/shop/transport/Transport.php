<?php

class Transport_Controller extends MY_Controller {

    protected $child1_name_Str = 'shop';
    protected $child2_name_Str = 'transport';
    protected $child3_name_Str = 'transport';

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

    public function edit()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'edit'//管理分類名稱
        )));
            
        $transportid_Num = $this->input->get('transportid');

        $data['transport'] = new Transport();
        $data['transport']->construct_db(array(
            'db_where_Arr' => array(
                'transportid_Num' => $transportid_Num
            )
        ));

        //global
        $data['global']['style'][] = 'admin/global.css';
        $data['global']['js'][] = 'admin.js';
        $data['global']['js'][] = 'tool/jquery.form.js';

        //temp
        $data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
        $data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
        $data['temp']['admin_header_bar'] = $this->load->view('admin/temp/admin_header_bar', $data, TRUE);
        $data['temp']['admin_footer_bar'] = $this->load->view('admin/temp/admin_footer_bar', $data, TRUE);
        $data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);

        //輸出模板
        $this->load->view('admin/'.$data['admin_child_url_Str'], $data);
    }

    public function edit_post()
    {
        $data = $this->data;//取得公用數據

        $this->form_validation->set_rules('name_Str', '運輸名稱', 'required');
        $this->form_validation->set_rules('company_Str', '運輸公司', 'required');
        $this->form_validation->set_rules('url_Str', '輸查貨網址', 'required');

        $transportid_Num = $this->input->post('transportid_Num', TRUE);

        if ($this->form_validation->run() !== FALSE)
        {
            //基本post欄位
            $name_Str = $this->input->post('name_Str', TRUE);
            $company_Str = $this->input->post('company_Str', TRUE);
            $url_Str = $this->input->post('url_Str', TRUE);
            $base_price_Num = $this->input->post('base_price_Num', TRUE);
            $additional_price_Num = $this->input->post('additional_price_Num', TRUE);
            $prioritynum_Num = $this->input->post('prioritynum_Num', TRUE);

            //檢測不能重複上傳
            $transport = new Transport();
            $transport->construct_db(array(
                'db_where_Arr' => array(
                    'transportid_Num !=' => $transportid_Num,
                    'name_Str' => $name_Str
                )
            ));

            if(!empty($transport->transportid_Num))
            {
                $this->load->model('Message');
                $this->Message->show(array(
                    'message' => '不可重複上傳相同名字的運輸方式',
                    'url' => 'admin/shop/transport/transport/tablelist'
                ));
                return FALSE;
            }

            //建構Transport物件，並且更新
            $transport = new Transport();
            $transport->construct(array(
                'transportid_Num' => $transportid_Num,
                'name_Str' => $name_Str,
                'company_Str' => $company_Str,
                'url_Str' => $url_Str,
                'base_price_Num' => $base_price_Num,
                'additional_price_Num' => $additional_price_Num,
                'prioritynum_Num' => $prioritynum_Num
            ));
            $transport->update();

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/shop/transport/transport/tablelist'
            ));
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => $validation_errors_Str,
                'url' => 'admin/shop/transport/transport/edit/?transportid='.$transportid_Num
            ));
        }
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'tablelist'//管理分類名稱
        )));

        $data['search_transportid_Num'] = $this->input->get('transportid');
        $data['search_name_Str'] = $this->input->get('name');
        $data['search_company_Str'] = $this->input->get('company');

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 20;

        $data['transportList'] = new ObjList();
        $data['transportList']->construct_db(array(
            'db_where_Arr' => array(
                'transportid_Num' => $data['search_transportid_Num']
            ),
            'db_where_like_Arr' => array(
                'name_Str' => $data['search_name_Str'],
                'company_Str' => $data['search_company_Str']
            ),
            'db_orderby_Arr' => array(
                array('prioritynum', 'DESC'),
                array('transportid', 'DESC')
            ),
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'Transport',
            'limitstart_Num' => $limitstart_Num,
            'limitcount_Num' => $limitcount_Num
        ));

        $data['page_links'] = $data['transportList']->create_links(array('base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']));

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

    public function tablelist_post()
    {
        $data = $this->data;//取得公用數據

        $search_transportid_Num = $this->input->post('search_transportid_Num', TRUE);
        $search_name_Str = $this->input->post('search_name_Str', TRUE);
        $search_company_Str = $this->input->post('search_company_Str', TRUE);

        $url_Str = base_url('admin/shop/transport/transport/tablelist/?');

        if(!empty($search_transportid_Num))
        {
            $url_Str = $url_Str.'&transportid='.$search_transportid_Num;
        }

        if(!empty($search_name_Str))
        {
            $url_Str = $url_Str.'&name='.$search_name_Str;
        }

        if(!empty($search_company_Str))
        {
            $url_Str = $url_Str.'&company='.$search_company_Str;
        }

        header("Location: $url_Str");
    }

    public function delete()
    {
        $hash_Str = $this->input->get('hash');
        $transportid_Num = $this->input->get('transportid');

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            $transport = new Transport();
            $transport->construct(array('transportid_Num' => $transportid_Num));
            $transport->destroy();

            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '刪除成功',
                'url' => 'admin/shop/transport/transport/tablelist'
            ));
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/shop/transport/transport/tablelist'
            ));
        }
    }

}

?>