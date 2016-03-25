<?php

class Showpiece_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'showpiece';
    protected $child3_name_Str = 'showpiece';

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
        $data = array_merge($data, $this->AdminModel->get_data([
            'child4_name_Str' => 'edit'//管理分類名稱
        ]));
            
        $showpieceid_Num = $this->input->get('showpieceid');

        $data['showpiece_Showpiece'] = new Showpiece([
            'db_where_Arr' => [
                'showpieceid_Num' => $showpieceid_Num
            ]
        ]);
        
        $data['class_ClassMetaList'] = new ObjList([
            'db_where_Arr' => [
                'modelname_Str' => 'showpiece'
            ],
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);
        
        $data['class2_ClassMetaList'] = new ObjList([
            'db_where_Arr' => [
                'modelname_Str' => 'showpiece_class2'
            ],
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

        $this->form_validation->set_rules('name_Str', '產品名稱', 'required');

        if ($this->form_validation->run() !== FALSE)
        {
            //基本post欄位
            $showpieceid_Num = $this->input->post('showpieceid_Num', TRUE);
            $name_Str = $this->input->post('name_Str', TRUE);
            $price_Num = $this->input->post('price_Num', TRUE);
            $synopsis_Str = $this->input->post('synopsis_Str', TRUE);
            $classids_Arr = $this->input->post('classids_Arr', TRUE);
            $content_Str = $this->input->post('content_Str');
            $content_specification_Str = $this->input->post('content_specification_Str');
            $prioritynum_Num = $this->input->post('prioritynum_Num', TRUE);
            $picids_Arr = $this->input->post('picids_Arr', TRUE);

            //建構Showpiece物件，並且更新
            $showpiece_Showpiece = new Showpiece([
                'showpieceid_Num' => $showpieceid_Num,
                'name_Str' => $name_Str,
                'price_Num' => $price_Num,
                'synopsis_Str' => $synopsis_Str,
                'mainpicids_Arr' => $mainpicids_Arr,
                'picids_Arr' => $picids_Arr,
                'classids_Arr' => $classids_Arr,
                'content_Str' => $content_Str,
                'content_specification_Str' => $content_specification_Str,
                'prioritynum_Num' => $prioritynum_Num
            ]);
            $showpiece_Showpiece->update();

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show([
                'message' => '設定成功',
                'url' => 'admin/base/showpiece/showpiece/tablelist'
            ]);
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show([
                'message' => $validation_errors_Str,
                'url' => 'admin/base/showpiece/showpiece/tablelist'
            ]);
        }
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data([
            'child4_name_Str' => 'tablelist'//管理分類名稱
        ]));

        $data['search_showpieceid_Num'] = $this->input->get('showpieceid');
        $data['search_name_Str'] = $this->input->get('name');
        $data['search_class_slug_Str'] = $this->input->get('class_slug');

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 20;

        $class_ClassMeta = new ClassMeta([
            'db_where_Arr' => [
                'slug_Str' => $data['search_class_slug_Str']
            ]
        ]);

        $data['showpiece_ShowpieceList'] = new ObjList([
            'db_where_Arr' => [
                'showpieceid_Num' => $data['search_showpieceid_Num']
            ],
            'db_where_like_Arr' => [
                'name_Str' => $data['search_name_Str']
            ],
            'db_where_or_Arr' => [
                'classids' => [$class_ClassMeta->classid_Num]
            ],
            'db_orderby_Arr' => [
                'prioritynum' => 'DESC',
                'updatetime' => 'DESC'
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'Showpiece',
            'limitstart_Num' => $limitstart_Num,
            'limitcount_Num' => $limitcount_Num
        ]);
        $data['showpiece_links'] = $data['showpiece_ShowpieceList']->create_links(['base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']]);

        $data['class_ClassMetaList'] = new ObjList([
            'db_where_Arr' => [
                'modelname_Str' => 'showpiece'
            ],
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

        $search_showpieceid_Num = $this->input->post('search_showpieceid_Num', TRUE);
        $search_class_slug_Str = $this->input->post('search_class_slug_Str', TRUE);
        $search_name_Str = $this->input->post('search_name_Str', TRUE);

        $url_Str = base_url('admin/base/showpiece/showpiece/tablelist/?');

        if(!empty($search_showpieceid_Num))
        {
            $url_Str = $url_Str.'&showpieceid='.$search_showpieceid_Num;
        }

        if(!empty($search_class_slug_Str))
        {
            $url_Str = $url_Str.'&class_slug='.$search_class_slug_Str;
        }

        if(!empty($search_name_Str))
        {
            $url_Str = $url_Str.'&name='.$search_name_Str;
        }

        header("Location: $url_Str");
    }

    public function delete()
    {
        $hash_Str = $this->input->get('hash');
        $showpieceid_Num = $this->input->get('showpieceid');
        $showpieceid_Arr = $this->input->post('showpieceid_Arr[]');

        if(empty($showpieceid_Arr)&&empty($showpieceid_Num))
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => '未選擇要刪除的產品',
                'url' => 'admin/base/showpiece/showpiece/tablelist'
            ]);
        }

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            if(!empty($showpieceid_Num))
            {
                $Showpiece = new Showpiece([
                    'showpieceid_Num' => $showpieceid_Num
                ]);
                $Showpiece->delete();
            }
            
            if(!empty($showpieceid_Arr))
            {
                foreach($showpieceid_Arr as $key => $value_showpiece)
                {
                    $Showpiece = new Showpiece([
                        'showpieceid_Num' => $value_showpiece
                    ]);
                    $Showpiece->delete();
                }
            }

            $this->load->model('Message');
            $this->Message->show([
                'message' => '刪除成功',
                'url' => 'admin/base/showpiece/showpiece/tablelist'
            ]);
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/showpiece/showpiece/tablelist'
            ]);
        }
    }
}

?>