<?php

class Contact_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'contact';
    protected $child3_name_Str = 'contact';

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
            
        $contactid_Num = $this->input->get('contactid');

        if(empty($contactid_Num))
        {
            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show([
                'message' => '請選擇欲編輯的聯繫單',
                'url' => 'admin/base/contact/contact/tablelist'
            ]);
            return FALSE;
        }

        $data['Contact'] = new Contact([
            'db_where_Arr' => [
                'contactid_Num' => $contactid_Num
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

    public function edit_post()
    {
        $data = $this->data;//取得公用數據

        //基本post欄位
        $contactid_Num = $this->input->post('contactid_Num', TRUE);
        $status_process_Num = $this->input->post('status_process_Num');

        //建構Contact物件，並且更新
        $Contact = new Contact([
            'contactid_Num' => $contactid_Num,
            'status_process_Num' => $status_process_Num
        ]);
        $Contact->update([
            'db_update_Arr' => ['status_process']
        ]);

        //送出成功訊息
        $this->load->model('Message');
        $this->Message->show([
            'message' => '設定成功',
            'url' => 'admin/base/contact/contact/tablelist'
        ]);
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data([
            'child4_name_Str' => 'tablelist'//管理分類名稱
        ]));

        $data['search_contactid_Num'] = $this->input->get('contactid');
        $data['search_username_Str'] = $this->input->get('username');
        $data['search_status_process_Num'] = $this->input->get('status_process');

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 20;

        $data['ContactList'] = new ObjList([
            'db_where_Arr' => [
                'contactid' => $data['search_contactid_Num'],
                'status_process' => $data['search_status_process_Num']
            ],
            'db_where_like_Arr' => [
                'username_Str' => $data['search_username_Str']
            ],
            'db_where_or_Arr' => [
                'classids' => [ $class_ClassMeta->classid_Num ]
            ],
            'db_orderby_Arr' => [
                'contactid' => 'DESC'
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'Contact',
            'limitstart_Num' => $limitstart_Num,
            'limitcount_Num' => $limitcount_Num
        ]);
        $data['page_links'] = $data['ContactList']->create_links(['base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']]);

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

        $search_contactid_Num = $this->input->post('search_contactid_Num', TRUE);
        $search_status_process_Num = $this->input->post('search_status_process_Num', TRUE);
        $search_username_Str = $this->input->post('search_username_Str', TRUE);

        $url_Str = base_url('admin/base/contact/contact/tablelist/?');

        if(!empty($search_contactid_Num))
        {
            $url_Str = $url_Str.'&contactid='.$search_contactid_Num;
        }

        if(!empty($search_status_process_Num))
        {
            $url_Str = $url_Str.'&status_process='.$search_status_process_Num;
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
        $contactid_Num = $this->input->get('contactid');
        $contactid_Arr = $this->input->post('contactid_Arr[]');

        if(empty($contactid_Arr)&&empty($contactid_Num))
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => '未選擇要刪除的聯繫單',
                'url' => 'admin/base/contact/contact/tablelist'
            ]);
        }

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            if(!empty($contactid_Num))
            {
                $Contact = new Contact([
                    'contactid_Num' => $contactid_Num
                ]);
                $Contact->delete();
            }
            
            if(!empty($contactid_Arr))
            {
                foreach($contactid_Arr as $key => $value_contact)
                {
                    $Contact = new Contact([
                        'contactid_Num' => $value_contact
                    ]);
                    $Contact->delete();
                }
            }

            $this->load->model('Message');
            $this->Message->show([
                'message' => '刪除成功',
                'url' => 'admin/base/contact/contact/tablelist'
            ]);
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/contact/contact/tablelist'
            ]);
        }
    }
}

?>