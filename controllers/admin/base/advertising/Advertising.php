<?php

class Advertising_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'advertising';
    protected $child3_name_Str = 'advertising';

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
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function edit()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data([
            'child4_name_Str' => 'edit'//管理分類名稱
        ]));
            
        $advertisingid_Num = $this->input->get('advertisingid');

        $data['Advertising'] = new Advertising([
            'db_where_Arr' => [
                'advertisingid_Num' => $advertisingid_Num
            ]
        ]);

        $data['AdvertisingClassList'] = new ObjList([
            'db_where_Arr' => [
                'modelname' => 'advertising'
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);

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

        $this->form_validation->set_rules('title_Str', '廣告標題', 'required');
        $this->form_validation->set_rules('href_Str', '廣告連結', 'required');

        if ($this->form_validation->run() !== FALSE)
        {
            //基本post欄位
            $advertisingid_Num = $this->input->post('advertisingid_Num', TRUE);
            $title_Str = $this->input->post('title_Str', TRUE);
            $href_Str = $this->input->post('href_Str', TRUE);
            $classids_Arr = $this->input->post('classids_Arr', TRUE);
            $content_Str = $this->input->post('content_Str');
            $prioritynum_Num = $this->input->post('prioritynum_Num', TRUE);
            $picids_Arr = $this->input->post('picids_Arr', TRUE);

            //建構Advertising物件，並且更新
            $Advertising = new Advertising([
                'advertisingid_Num' => $advertisingid_Num,
                'title_Str' => $title_Str,
                'href_Str' => $href_Str,
                'picids_Arr' => $picids_Arr,
                'classids_Arr' => $classids_Arr,
                'content_Str' => $content_Str,
                'prioritynum_Num' => $prioritynum_Num
            ]);
            $Advertising->update();

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show([
                'message' => '設定成功',
                'url' => 'admin/base/advertising/advertising/tablelist'
            ]);
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show([
                'message' => $validation_errors_Str,
                'url' => 'admin/base/advertising/advertising/edit'
            ]);
        }
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data([
            'child4_name_Str' => 'tablelist'//管理分類名稱
        ]));

        $data['search_advertisingid_Num'] = $this->input->get('advertisingid');
        $data['search_title_Str'] = $this->input->get('title');
        $data['search_class_slug_Str'] = $this->input->get('class_slug');

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 20;

        $class_ClassMeta = new ClassMeta([
            'db_where_Arr' => [
                'slug_Str' => $data['search_class_slug_Str']
            ]
        ]);

        $data['AdvertisingList'] = new ObjList([
            'db_where_Arr' => [
                'advertisingid_Num' => $data['search_advertisingid_Num']
            ],
            'db_where_like_Arr' => [
                'title_Str' => $data['search_title_Str']
            ],
            'db_where_or_Arr' => [
                'classids' => [ $class_ClassMeta->classid_Num ]
            ],
            'db_orderby_Arr' => [
                'prioritynum' => 'DESC',
                'updatetime' => 'DESC'
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'Advertising',
            'limitstart_Num' => $limitstart_Num,
            'limitcount_Num' => $limitcount_Num
        ]);
        $data['page_link'] = $data['AdvertisingList']->create_links(['base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']]);

        $data['AdvertisingClassList'] = new ObjList([
            'db_where_Arr' => [
                'modelname' => 'advertising'
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
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

    public function tablelist_post()
    {
        $data = $this->data;//取得公用數據

        $search_advertisingid_Num = $this->input->post('search_advertisingid_Num', TRUE);
        $search_class_slug_Str = $this->input->post('search_class_slug_Str', TRUE);
        $search_title_Str = $this->input->post('search_title_Str', TRUE);

        $url_Str = base_url('admin/base/advertising/advertising/tablelist/?');

        if(!empty($search_advertisingid_Num))
        {
            $url_Str = $url_Str.'&advertisingid='.$search_advertisingid_Num;
        }

        if(!empty($search_class_slug_Str))
        {
            $url_Str = $url_Str.'&class_slug='.$search_class_slug_Str;
        }

        if(!empty($search_title_Str))
        {
            $url_Str = $url_Str.'&title='.$search_title_Str;
        }

        header("Location: $url_Str");
    }

    public function delete()
    {
        $hash_Str = $this->input->get('hash');
        $advertisingid_Num = $this->input->get('advertisingid');

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            $advertising_Advertising = new Advertising(['advertisingid_Num' => $advertisingid_Num]);
            $advertising_Advertising->destroy();

            $this->load->model('Message');
            $this->Message->show([
                'message' => '刪除成功',
                'url' => 'admin/base/advertising/advertising/tablelist'
            ]);
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/advertising/advertising/tablelist'
            ]);
        }
    }

}

?>