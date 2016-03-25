<?php

class Faq_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'faq';
    protected $child3_name_Str = 'faq';

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
            
        $faqid_Num = $this->input->get('faqid');

        if(empty($faqid_Num))
        {
            $data['FaqField'] = new FaqField([
                'db_where_Arr' => [
                    'faq.faqid' => $faqid_Num
                ]
            ]);
        }
        else
        {
            $Faq = new Faq([
                'db_where_Arr' => [
                    'faq.faqid' => $faqid_Num
                ]
            ]);

            if( $Faq->faqid_Num == 0 )
            {
                header('Location: '.base_url('admin/base/faq/faq/edit'));
            }
            else
            {
                $data['FaqField'] = new FaqField([
                    'db_where_Arr' => [
                        'faq.faqid' => $faqid_Num
                    ]
                ]);
            }
        }

        $data['FaqClassMetaList'] = new ObjList();
        $data['FaqClassMetaList']->construct_db([
            'db_where_Arr' => [
                'modelname' => 'faq'
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

    public function edit_post()
    {
        $data = $this->data;//取得公用數據

        $this->form_validation->set_rules('title_Str', '問題標題', 'required');
        $this->form_validation->set_rules('content_Str', '回答內容', 'required');
        
        $faqid_Num = $this->input->post('faqid_Num', TRUE);

        if ($this->form_validation->run() !== FALSE)
        {
            //基本post欄位
            $title_Str = $this->input->post('title_Str', TRUE);
            $classids_Arr = $this->input->post('classids_Arr', TRUE);
            $content_Str = $this->input->post('content_Str');
            $prioritynum_Num = $this->input->post('prioritynum_Num', TRUE);
            $updatetime_Str = $this->input->post('updatetime_Str', TRUE);

            //建構Faq物件，並且更新
            $FaqField = new FaqField([
                'faqid_Num' => $faqid_Num,
                'title_Str' => $title_Str,
                'classids_Arr' => $classids_Arr,
                'content_Str' => $content_Str,
                'prioritynum_Num' => $prioritynum_Num,
                'updatetime_Str' => $updatetime_Str,
                'modelname_Str' => 'faq'
            ]);
            $FaqField->update();

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/faq/faq/tablelist/'
            ));
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => $validation_errors_Str,
                'url' => 'admin/base/faq/faq/edit/?faqid='.$faqid_Num
            ));
        }
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'tablelist'//管理分類名稱
        )));

        $data['search_faqid_Num'] = $this->input->get('faqid');
        $data['search_title_Str'] = $this->input->get('title');
        $data['search_class_slug_Str'] = $this->input->get('class_slug');

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 20;

        $class_ClassMeta = new ClassMeta([
            'db_where_Arr' => [
                'slug' => $data['search_class_slug_Str']
            ]
        ]);

        $data['FaqList'] = new ObjList();
        $data['FaqList']->construct_db(array(
            'db_where_Arr' => array(
                'modelname' => 'faq',
                'faqid' => $data['search_faqid_Num']
            ),
            'db_where_like_Arr' => array(
                'title_Str' => $data['search_title_Str']
            ),
            'db_where_or_Arr' => array(
                'classids' => array($class_ClassMeta->classid_Num)
            ),
            'db_orderby_Arr' => array(
                array('prioritynum', 'DESC'),
                array('updatetime', 'DESC')
            ),
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'Faq',
            'limitstart_Num' => $limitstart_Num,
            'limitcount_Num' => $limitcount_Num
        ));
        $data['page_link'] = $data['FaqList']->create_links(array('base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']));

        $data['FaqClassMetaList'] = new ObjList();
        $data['FaqClassMetaList']->construct_db(array(
            'db_where_Arr' => [
                'modelname' => 'faq'
            ],
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ));

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

        $search_faqid_Num = $this->input->post('search_faqid_Num', TRUE);
        $search_class_slug_Str = $this->input->post('search_class_slug_Str', TRUE);
        $search_title_Str = $this->input->post('search_title_Str', TRUE);

        $url_Str = base_url('admin/base/faq/faq/tablelist/?');

        if(!empty($search_faqid_Num))
        {
            $url_Str = $url_Str.'&faqid='.$search_faqid_Num;
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
        $faqid_Num = $this->input->get('faqid');
        $faqid_Arr = $this->input->post('faqid_Arr[]');

        if(empty($faqid_Arr)&&empty($faqid_Num))
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => '未選擇要刪除的常見問題',
                'url' => 'admin/base/faq/faq/tablelist'
            ]);
        }

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            if(!empty($faqid_Num))
            {
                $Faq = new Faq([
                    'faqid_Num' => $faqid_Num
                ]);
                $Faq->delete();
            }
            
            if(!empty($faqid_Arr))
            {
                foreach($faqid_Arr as $key => $value_faq)
                {
                    $Faq = new Faq([
                        'faqid_Num' => $value_faq
                    ]);
                    $Faq->delete();
                }
            }
            
            $this->load->model('Message');
            $this->Message->show([
                'message' => '刪除成功',
                'url' => 'admin/base/faq/faq/tablelist'
            ]);
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/faq/faq/tablelist'
            ]);
        }
    }

}

?>