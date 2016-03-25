<?php

class Note_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'note';
    protected $child3_name_Str = 'note';

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
            
        $noteid_Num = $this->input->get('noteid');

        if(empty($noteid_Num))
        {
            $data['NoteField'] = new NoteField([
                'db_where_Arr' => [
                    'note.noteid' => $noteid_Num
                ]
            ]);
        }
        else
        {
            $Note = new Note([
                'db_where_Arr' => [
                    'noteid_Num' => $noteid_Num
                ]
            ]);

            if( $Note->noteid_Num == 0 )
            {
                header('Location: '.base_url('admin/base/note/note/edit'));
            }
            else
            {
                $data['NoteField'] = new NoteField([
                    'db_where_Arr' => [
                        'note.noteid' => $noteid_Num
                    ]
                ]);
            }
        }

        $data['UserGroup_Num'] = $data['User']->group_UserGroupList->obj_Arr[0]->groupid_Num;

        if($data['UserGroup_Num'] == 100)
        {
            $data['NoteClassMetaList'] = new ObjList([
                'db_where_Arr' => [
                    'modelname' => 'note',
                    'uid' => $data['User']->uid_Num
                ],
                'model_name_Str' => 'ClassMeta',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ]);
        }
        else
        {
            $data['NoteClassMetaList'] = new ObjList([
                'db_where_Arr' => [
                    'modelname' => 'note'
                ],
                'model_name_Str' => 'ClassMeta',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ]);
        }

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

        $this->form_validation->set_rules('title_Str', '文章標題', 'required');
        $this->form_validation->set_rules('content_Str', '文章內容', 'required');
        
        $noteid_Num = $this->input->post('noteid_Num', TRUE);

        if ($this->form_validation->run() !== FALSE)
        {
            //基本post欄位
            $title_Str = $this->input->post('title_Str', TRUE);
            $slug_Str = $this->input->post('slug_Str', TRUE);
            $classids_Arr = $this->input->post('classids_Arr', TRUE);
            $content_Str = $this->input->post('content_Str');
            $prioritynum_Num = $this->input->post('prioritynum_Num', TRUE);
            $updatetime_Str = $this->input->post('updatetime_Str', TRUE);
            $picids_Arr = $this->input->post('picids_Arr');
            $shelves_status_Num = $this->input->post('shelves_status_Num', TRUE);
            $show_Bln = $this->input->post('show_Bln', TRUE);

            if(!empty($show_Bln))
            {
                $shelves_status_Num = 2;
            }

            //建構Note物件，並且更新
            $NoteField = new NoteField([
                'noteid_Num' => $noteid_Num,
                'title_Str' => $title_Str,
                'slug_Str' => $slug_Str,
                'classids_Arr' => $classids_Arr,
                'content_Str' => $content_Str,
                'picids_Arr' => $picids_Arr,
                'prioritynum_Num' => $prioritynum_Num,
                'updatetime_Str' => $updatetime_Str,
                'shelves_status_Num' => $shelves_status_Num,
                'modelname_Str' => 'note'
            ]);
            $NoteField->update();

            if(!empty($show_Bln))
            {
                header('Location: '.base_url('note/'.$NoteField->noteid_Num));
            }
            else
            {
                //送出成功訊息
                $this->load->model('Message');
                $this->Message->show([
                    'message' => '設定成功',
                    'url' => 'admin/base/note/note/tablelist/'
                ]);
            }
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show([
                'message' => $validation_errors_Str,
                'url' => 'admin/base/note/note/edit/?noteid='.$noteid_Num
            ]);
        }
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge( $data, $this->AdminModel->get_data([
            'child4_name_Str' => 'tablelist'//管理分類名稱
        ]) );

        $data['search_noteid_Num'] = $this->input->get('noteid');
        $data['search_title_Str'] = $this->input->get('title');
        $data['search_username_Str'] = $this->input->get('username');
        $data['search_class_slug_Str'] = $this->input->get('class_slug');
        $data['search_shelves_status_Num'] = $this->input->get('shelves_status');

        //預設顯示已發表文章
        if(empty($data['search_shelves_status_Num']))
        {
            $data['search_shelves_status_Num'] = 1;
        }

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 20;

        $class_ClassMeta = new ClassMeta([
            'db_where_Arr' => [
                'slug' => $data['search_class_slug_Str']
            ]
        ]);

        $User = new User([
            'db_where_Arr' => [
                'username' => $data['search_username_Str']
            ]
        ]);
        
        $data['UserGroup_Num'] = $data['User']->group_UserGroupList->obj_Arr[0]->groupid_Num;

        if($data['UserGroup_Num'] == 100)
        {
            $data['NoteList'] = new ObjList([
                'db_where_Arr' => [
                    'modelname' => 'note',
                    'noteid' => $data['search_noteid_Num'],
                    'shelves_status' => $data['search_shelves_status_Num'],
                    'uid' => $data['User']->uid_Num
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
                'model_name_Str' => 'Note',
                'limitstart_Num' => $limitstart_Num,
                'limitcount_Num' => $limitcount_Num
            ]);
        }
        else
        {
            $data['NoteList'] = new ObjList([
                'db_where_Arr' => [
                    'modelname' => 'note',
                    'noteid' => $data['search_noteid_Num'],
                    'shelves_status' => $data['search_shelves_status_Num'],
                    'uid' => $User->uid_Num
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
                'model_name_Str' => 'Note',
                'limitstart_Num' => $limitstart_Num,
                'limitcount_Num' => $limitcount_Num
            ]);
        }
        $data['page_link'] = $data['NoteList']->create_links(['base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']]);

        if($data['UserGroup_Num'] == 100)
        {
            $data['NoteClassMetaList'] = new ObjList([
                'db_where_Arr' => [
                    'modelname' => 'note',
                    'uid' => $data['User']->uid_Num
                ],
                'model_name_Str' => 'ClassMeta',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ]);
        }
        else
        {
            $data['NoteClassMetaList'] = new ObjList([
                'db_where_Arr' => [
                    'modelname' => 'note'
                ],
                'model_name_Str' => 'ClassMeta',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ]);
        }

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

        $search_noteid_Num = $this->input->post('search_noteid_Num', TRUE);
        $search_class_slug_Str = $this->input->post('search_class_slug_Str', TRUE);
        $search_title_Str = $this->input->post('search_title_Str', TRUE);
        $search_username_Str = $this->input->post('search_username_Str', TRUE);
        $search_shelves_status_Num = $this->input->post('search_shelves_status_Num', TRUE);

        $url_Str = base_url('admin/base/note/note/tablelist/?');

        if(!empty($search_noteid_Num))
        {
            $url_Str = $url_Str.'&noteid='.$search_noteid_Num;
        }

        if(!empty($search_class_slug_Str))
        {
            $url_Str = $url_Str.'&class_slug='.$search_class_slug_Str;
        }

        if(!empty($search_title_Str))
        {
            $url_Str = $url_Str.'&title='.$search_title_Str;
        }

        if(!empty($search_shelves_status_Num))
        {
            $url_Str = $url_Str.'&shelves_status='.$search_shelves_status_Num;
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
        $noteid_Num = $this->input->get('noteid');
        $noteid_Arr = $this->input->post('noteid_Arr[]');

        if(empty($noteid_Arr)&&empty($noteid_Num))
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => '未選擇要刪除的文章',
                'url' => 'admin/base/note/note/tablelist'
            ]);
        }

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            if(!empty($noteid_Num))
            {
                $Note = new Note([
                    'noteid_Num' => $noteid_Num
                ]);
                $Note->delete();
            }
            
            if(!empty($noteid_Arr))
            {
                foreach($noteid_Arr as $key => $value_note)
                {
                    $Note = new Note([
                        'noteid_Num' => $value_note
                    ]);
                    $Note->delete();
                }
            }
            
            $this->load->model('Message');
            $this->Message->show([
                'message' => '刪除成功',
                'url' => 'admin/base/note/note/tablelist'
            ]);
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/note/note/tablelist'
            ]);
        }
    }
}

?>