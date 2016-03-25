<?php

class Global_Controller extends MY_Controller {

    protected $child1_name_Str = 'user';
    protected $child2_name_Str = 'global';
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

    public function user()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'user'//管理分類名稱
        )));

        $data['user_UserFieldShop'] = new UserFieldShop();
        $data['user_UserFieldShop']->construct_db(array(
            'db_where_Arr' => array(
                'user.uid' => $data['User']->uid_Num
            )
        ));

        $data['UserGroupList'] = new ObjList();
        $data['UserGroupList']->construct_db(array(
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'UserGroup',
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

    public function user_post()
    {
        $data = $this->data;//取得公用數據

        $this->form_validation->set_rules('username_Str', '會員名稱', 'required');
        $uid_Num = $this->input->post('uid_Num', TRUE);

        if ($this->form_validation->run() !== FALSE)
        {
            //基本post欄位
            $username_Str = $this->input->post('username_Str', TRUE);

            //建構User物件，並且更新
            $UserFieldShop = new UserFieldShop();
            $UserFieldShop->construct(array(
                'uid_Num' => $uid_Num,
                'username_Str' => $username_Str
            ));
            $UserFieldShop->update(array(
                'db_update_Arr' => array(
                    'user.username', 'user.updatetime'
                )
            ));

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/user/global/global/user'
            ));
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => $validation_errors_Str,
                'url' => 'admin/user/global/global/user'
            ));
        }
    }

    public function user_changepassword_post()
    {
        $data = $this->data;//取得公用數據

        $this->form_validation->set_rules('password_Str', '會員密碼', 'required');
        $this->form_validation->set_rules('password2_Str', '會員密碼', 'required');
        $uid_Num = $this->input->post('uid_Num', TRUE);

        if ($this->form_validation->run() !== FALSE)
        {
            //基本post欄位
            $password_Str = $this->input->post('password_Str', TRUE);
            $password2_Str = $this->input->post('password2_Str', TRUE);

            //建構User物件，並且更新
            $User = new User();
            $User->construct(array(
                'uid_Num' => $uid_Num
            ));
            $change_status_Bln = $User->change_password(array(
                'password_Str' => $password_Str,
                'password2_Str' => $password2_Str
            ));

            if($change_status_Bln === TRUE)
            {
                //送出成功訊息
                $this->load->model('Message');
                $this->Message->show(array(
                    'message' => '密碼變更成功',
                    'url' => 'admin/user/global/global/user'
                ));
            }
            else
            {
                //送出成功訊息
                $this->load->model('Message');
                $this->Message->show(array(
                    'message' => $change_status_Bln,
                    'url' => 'admin/user/global/global/user'
                ));
            }
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => $validation_errors_Str,
                'url' => 'admin/user/global/global/user'
            ));
        }
    }

}

?>