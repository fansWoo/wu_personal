<?php

class Pager_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'pager';
    protected $child3_name_Str = 'pager';

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
            
        $pagerid_Num = $this->input->get('pagerid');

        if(empty($pagerid_Num))
        {
            $data['PagerField'] = new PagerField([
                'db_where_Arr' => [
                    'pager.pagerid' => $pagerid_Num
                ]
            ]);
        }
        else
        {
            $Pager = new Pager([
                'db_where_Arr' => [
                    'pagerid_Num' => $pagerid_Num
                ]
            ]);

            if( $Pager->pagerid_Num == 0 )
            {
                header('Location: '.base_url('admin/base/pager/pager/edit'));
            }
            else
            {
                $data['PagerField'] = new PagerField([
                    'db_where_Arr' => [
                        'pager.pagerid' => $pagerid_Num
                    ]
                ]);
            }
        }

        $data['PagerClassMetaList'] = new ObjList([
            'db_where_Arr' => [
                'modelname' => 'pager'
            ],
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);

        $data['class_ClassMetaList'] = new ObjList([
            'db_where_Arr' => [
                'modelname_Str' => 'pager2'
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

        $this->form_validation->set_rules('title_Str', '頁面標題', 'required');
        
        $pagerid_Num = $this->input->post('pagerid_Num', TRUE);

        if ($this->form_validation->run() !== FALSE)
        {
            //基本post欄位
            $title_Str = $this->input->post('title_Str', TRUE);
            $slug_Str = $this->input->post('slug_Str', TRUE);
            $href_Str = $this->input->post('href_Str', TRUE);
            $target_Num = $this->input->post('target_Num', TRUE);
            $classids_Arr = $this->input->post('classids_Arr', TRUE);
            $content_Str = $this->input->post('content_Str');
            $prioritynum_Num = $this->input->post('prioritynum_Num', TRUE);

            if(!empty($target_Num))
            {
                $target_Num = 1;
            }

            //建構Pager物件，並且更新
            $PagerField = new PagerField([
                'pagerid_Num' => $pagerid_Num,
                'title_Str' => $title_Str,
                'slug_Str' => $slug_Str,
                'href_Str' => $href_Str,
                'target_Num' => $target_Num,
                'classids_Arr' => $classids_Arr,
                'content_Str' => $content_Str,
                'prioritynum_Num' => $prioritynum_Num
            ]);
            $PagerField->update();

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show([
                'message' => '設定成功',
                'url' => 'admin/base/pager/pager/tablelist/'
            ]);
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show([
                'message' => $validation_errors_Str,
                'url' => 'admin/base/pager/pager/edit/?pagerid='.$pagerid_Num
            ]);
        }
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data([
            'child4_name_Str' => 'tablelist'//管理分類名稱
        ]));

        $data['search_pagerid_Num'] = $this->input->get('pagerid');
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

        $data['PagerList'] = new ObjList([
            'db_where_Arr' => [
                'pagerid' => $data['search_pagerid_Num']
            ],
            'db_where_like_Arr' => [
                'title_Str' => $data['search_title_Str']
            ],
            'db_where_or_Arr' => [
                'classids' => [$class_ClassMeta->classid_Num]
            ],
            'db_orderby_Arr' => [
                'prioritynum' => 'DESC',
                'updatetime' => 'DESC'
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'Pager',
            'limitstart_Num' => $limitstart_Num,
            'limitcount_Num' => $limitcount_Num
        ]);
        $data['page_link'] = $data['PagerList']->create_links(['base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']]);

        $data['PagerClassMetaList'] = new ObjList([
            'db_where_Arr' => [
                'modelname' => 'pager'
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

        $search_pagerid_Num = $this->input->post('search_pagerid_Num', TRUE);
        $search_class_slug_Str = $this->input->post('search_class_slug_Str', TRUE);
        $search_title_Str = $this->input->post('search_title_Str', TRUE);

        $url_Str = base_url('admin/base/pager/pager/tablelist/?');

        if(!empty($search_pagerid_Num))
        {
            $url_Str = $url_Str.'&pagerid='.$search_pagerid_Num;
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
        $pagerid_Num = $this->input->get('pagerid');
        $pagerid_Arr = $this->input->post('pagerid_Arr[]');

        if(empty($pagerid_Arr)&&empty($pagerid_Num))
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => '未選擇要刪除的動態頁面',
                'url' => 'admin/base/pager/pager/tablelist'
            ]);
        }

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            if(!empty($pagerid_Num))
            {
                $Pager = new Pager([
                    'pagerid_Num' => $pagerid_Num
                ]);
                $Pager->delete();
            }
            
            if(!empty($pagerid_Arr))
            {
                foreach($pagerid_Arr as $key => $value_pager)
                {
                    $Pager = new Pager([
                        'pagerid_Num' => $value_pager
                    ]);
                    $Pager->delete();
                }
            }

            $this->load->model('Message');
            $this->Message->show([
                'message' => '刪除成功',
                'url' => 'admin/base/pager/pager/tablelist'
            ]);
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/pager/pager/tablelist'
            ]);
        }
    }
}

?>