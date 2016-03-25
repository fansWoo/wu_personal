<?php

class Comment_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'comment';
    protected $child3_name_Str = 'comment';

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
            
        $commentid_Num = $this->input->get('commentid');

        if(empty($commentid_Num))
        {
            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show([
                'message' => '請選擇欲查看的留言',
                'url' => 'admin/base/comment/comment/tablelist'
            ]);
            return FALSE;
        }

        $data['Comment'] = new Comment([
            'db_where_Arr' => [
                'commentid_Num' => $commentid_Num
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

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data([
            'child4_name_Str' => 'tablelist'//管理分類名稱
        ]));

        $data['search_content_Str'] = $this->input->get('content');
        $data['search_title_Str'] = $this->input->get('title');
        $data['search_username_Str'] = $this->input->get('username');
        $data['search_class_slug_Str'] = $this->input->get('class_slug');

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 20;

        $User = new User([
            'db_where_Arr' => [
                'username' => $data['search_username_Str']
            ]
        ]);

        $data['UserGroup_Num'] = $data['User']->group_UserGroupList->obj_Arr[0]->groupid_Num;

        if($data['UserGroup_Num'] == 100)
        {
            $data['CommentList'] = new ObjList([
                'db_where_Arr' => [
                    'typename != ' => 'order',
                    'uid' => $data['User']->uid_Num
                ],
                'db_where_like_Arr' => [
                    'content' => $data['search_content_Str'],
                    'typename' => $data['search_class_slug_Str']
                ],
                'db_orderby_Arr' => [
                    'updatetime' => 'DESC'
                ],
                'db_where_deletenull_Bln' => TRUE,
                'model_name_Str' => 'Comment',
                'limitstart_Num' => $limitstart_Num,
                'limitcount_Num' => $limitcount_Num
            ]);
        }
        else
        {
            $data['CommentList'] = new ObjList([
                'db_where_Arr' => [
                    'typename != ' => 'order',
                    'uid' => $User->uid_Num
                ],
                'db_where_like_Arr' => [
                    'content' => $data['search_content_Str'],
                    'typename' => $data['search_class_slug_Str']
                ],
                'db_orderby_Arr' => [
                    'updatetime' => 'DESC'
                ],
                'db_where_deletenull_Bln' => TRUE,
                'model_name_Str' => 'Comment',
                'limitstart_Num' => $limitstart_Num,
                'limitcount_Num' => $limitcount_Num
            ]);
        }
        $data['page_link'] = $data['CommentList']->create_links(['base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']]);

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

        $search_content_Str = $this->input->post('search_content_Str', TRUE);
        $search_class_slug_Str = $this->input->post('search_class_slug_Str', TRUE);
        $search_title_Str = $this->input->post('search_title_Str', TRUE);
        $search_username_Str = $this->input->post('search_username_Str', TRUE);

        $url_Str = base_url('admin/base/comment/comment/tablelist/?');

        if(!empty($search_content_Str))
        {
            $url_Str = $url_Str.'&content='.$search_content_Str;
        }

        if(!empty($search_class_slug_Str))
        {
            $url_Str = $url_Str.'&class_slug='.$search_class_slug_Str;
        }

        if(!empty($search_title_Str))
        {
            $url_Str = $url_Str.'&title='.$search_title_Str;
        }

        if(!empty($search_username_Str))
        {
            $url_Str = $url_Str.'&username='.$search_username_Str;
        }

        header("Location: $url_Str");
    }

    public function delete()
    {
        $hash_Str = $this->input->get('hash');
        $commentid_Num = $this->input->get('commentid');

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            $Comment = new Comment(['commentid_Num' => $commentid_Num]);
            $Comment->destroy();

            $this->load->model('Message');
            $this->Message->show([
                'message' => '刪除成功',
                'url' => 'admin/base/comment/comment/tablelist'
            ]);
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/comment/comment/tablelist'
            ]);
        }
    }

}

?>