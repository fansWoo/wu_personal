<?php

class User_shop_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'user';
    protected $child3_name_Str = 'user_shop';

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
            
        $uid_Num = $this->input->get('uid');

        $data['user_UserFieldShop'] = new UserFieldShop();
        $data['user_UserFieldShop']->construct_db(array(
            'db_where_Arr' => array(
                'user.uid' => $uid_Num
            )
        ));

        if(
            !empty( $data['user_UserFieldShop']->group_UserGroupList->uniqueids_Arr ) &&
            in_array( 1, $data['user_UserFieldShop']->group_UserGroupList->uniqueids_Arr) &&
            !in_array( 1, $data['User']->group_UserGroupList->uniqueids_Arr) ||
            !empty( $data['user_UserFieldShop']->group_UserGroupList->uniqueids_Arr ) &&
            in_array( 2, $data['user_UserFieldShop']->group_UserGroupList->uniqueids_Arr) &&
            !in_array( 2, $data['User']->group_UserGroupList->uniqueids_Arr) &&
            !in_array( 1, $data['User']->group_UserGroupList->uniqueids_Arr) ||
            !empty( $data['user_UserFieldShop']->group_UserGroupList->uniqueids_Arr ) &&
            in_array( 3, $data['user_UserFieldShop']->group_UserGroupList->uniqueids_Arr) &&
            !in_array( 2, $data['User']->group_UserGroupList->uniqueids_Arr) &&
            !in_array( 1, $data['User']->group_UserGroupList->uniqueids_Arr)
        )
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '不可以編輯權限更高的管理員',
                'url' => 'admin/base/user/user_shop/tablelist'
            ));
            return FALSE;
        }

        //權限判斷
        if(
            in_array( 1, $data['User']->group_UserGroupList->uniqueids_Arr)
        )
        {
        }
        else if(
            in_array( 2, $data['User']->group_UserGroupList->uniqueids_Arr)
        )
        {
            $groupids_1_purview = 1;
        }
        else if(
            in_array( 3, $data['User']->group_UserGroupList->uniqueids_Arr)
        )
        {
            $groupids_1_purview = 1;
            $groupids_2_purview = 2;
            $groupids_3_purview = 3;
        }
        
        $data['UserGroupList'] = new ObjList();
        $data['UserGroupList']->construct_db(array(
            'db_where_Arr' => array(
                'groupid !=' => $groupids_1_purview,
                'groupid != ' => $groupids_2_purview,
                'groupid !=  ' => $groupids_3_purview
            ),
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

    public function edit_post()
    {
        $data = $this->data;//取得公用數據

        $this->form_validation->set_rules('username_Str', '會員名稱', 'required');
        $uid_Num = $this->input->post('uid_Num', TRUE);

        if ($this->form_validation->run() !== FALSE)
        {
            $data['user_UserFieldShop'] = new UserFieldShop();
            $data['user_UserFieldShop']->construct_db(array(
                'db_where_Arr' => array(
                    'user.uid' => $uid_Num
                )
            ));

            //權限判斷
            if( 
                in_array( 1, $data['user_UserFieldShop']->group_UserGroupList->uniqueids_Arr) &&
                !in_array( 1, $data['User']->group_UserGroupList->uniqueids_Arr) ||
                in_array( 2, $data['user_UserFieldShop']->group_UserGroupList->uniqueids_Arr) &&
                !in_array( 2, $data['User']->group_UserGroupList->uniqueids_Arr) &&
                !in_array( 1, $data['User']->group_UserGroupList->uniqueids_Arr) ||
                in_array( 3, $data['user_UserFieldShop']->group_UserGroupList->uniqueids_Arr) &&
                !in_array( 2, $data['User']->group_UserGroupList->uniqueids_Arr) &&
                !in_array( 1, $data['User']->group_UserGroupList->uniqueids_Arr)
            )
            {
                $this->load->model('Message');
                $this->Message->show(array(
                    'message' => '不可以編輯權限更高的管理員',
                    'url' => 'admin/base/user/user_shop/tablelist'
                ));
                return FALSE;
            }

            //基本post欄位
            $username_Str = $this->input->post('username_Str', TRUE);
            $groupids_Arr = $this->input->post('groupids_Arr', TRUE);

            //建構User物件，並且更新
            $UserFieldShop = new UserFieldShop();
            $UserFieldShop->construct(array(
                'uid_Num' => $uid_Num,
                'username_Str' => $username_Str
            ));
            
            //建立UserGroupList物件
            check_comma_array($groupids_Str, $groupids_Arr);
            $UserFieldShop->group_UserGroupList = new ObjList;
            $UserFieldShop->group_UserGroupList->construct_db(array(
                'db_where_or_Arr' => array(
                    'groupid_Num' => $groupids_Arr
                ),
                'model_name_Str' => 'UserGroup',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ));

            $UserFieldShop->update(array(
                'db_update_Arr' => array(
                    'user.username', 'user.updatetime', 'user.groupids'
                )
            ));

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/user/user_shop/edit/?uid='.$uid_Num
            ));
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => $validation_errors_Str,
                'url' => 'admin/base/user/user_shop/edit/?uid='.$uid_Num
            ));
        }
    }

    public function edit_adduser_post()
    {
        $data = $this->data;//取得公用數據
        
        $this->form_validation->set_rules('email_Str', 'email', 'required');
        $this->form_validation->set_rules('password_Str', '密碼', 'required');
        $this->form_validation->set_rules('password2_Str', '確認密碼', 'required');
        
        if ($this->form_validation->run() !== FALSE)
        {
            $email_Str = $this->input->post('email_Str', TRUE);
            $password_Str = $this->input->post('password_Str', TRUE);
            $password2_Str = $this->input->post('password2_Str', TRUE);

            $User = new User();
            $register_status = $User->add(array(
                'email_Str' => $email_Str,
                'password_Str' => $password_Str,
                'password2_Str' => $password2_Str
            ));

            if($register_status === TRUE)
            {
                $url_Str = 'admin/base/user/user_shop/tablelist';
                $message_Str = "註冊成功";
                
                $this->load->model('Message');
                $this->Message->show(array('message' => $message_Str, 'url' => $url_Str));
            }
            else
            {
                $url_Str = 'admin/base/user/user_shop/edit';
                $message_Str = $register_status;
                
                $this->load->model('Message');
                $this->Message->show(array('message' => $message_Str, 'url' => $url_Str));
            }
        }
        else
        {
            $url_Str = 'admin/base/user/user_shop/edit';
            $message = validation_errors();
            
            $this->load->model('Message');
            $this->Message->show(array('message' => $message, 'url' => $url_Str));
        }
    }

    public function edit_userfieldshop_post()
    {
        $data = $this->data;//取得公用數據

        $uid_Num = $this->input->post('uid_Num', TRUE);

        //基本post欄位
        $receive_name_Str = $this->input->post('receive_name_Str', TRUE);
        $receive_phone_Str = $this->input->post('receive_phone_Str', TRUE);
        $receive_address_Str = $this->input->post('receive_address_Str', TRUE);
        $coupon_count_Num = $this->input->post('coupon_count_Num', TRUE);

        //建構User物件，並且更新
        $UserFieldShop = new UserFieldShop();
        $UserFieldShop->construct(array(
            'uid_Num' => $uid_Num,
            'receive_name_Str' => $receive_name_Str,
            'receive_phone_Str' => $receive_phone_Str,
            'receive_address_Str' => $receive_address_Str,
            'coupon_count_Num' => $coupon_count_Num
        ));
        $UserFieldShop->update(array(
            'db_update_Arr' => array(
                'user_field_shop.receive_name',
                'user_field_shop.receive_phone',
                'user_field_shop.receive_address',
                'user_field_shop.coupon_count'
            )
        ));

        //送出成功訊息
        $this->load->model('Message');
        $this->Message->show(array(
            'message' => '設定成功',
            'url' => 'admin/base/user/user_shop/edit/?uid='.$uid_Num
        ));
    }

    public function edit_changepassword_post()
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
                    'url' => 'admin/base/user/user_shop/edit/?uid='.$uid_Num
                ));
            }
            else
            {
                //送出成功訊息
                $this->load->model('Message');
                $this->Message->show(array(
                    'message' => $change_status_Bln,
                    'url' => 'admin/base/user/user_shop/edit/?uid='.$uid_Num
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
                'url' => 'admin/base/user/user_shop/edit/?uid='.$uid_Num
            ));
        }
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'tablelist'//管理分類名稱
        )));

        $data['search_uid_Num'] = $this->input->get('uid');
        $data['search_username_Str'] = $this->input->get('username');
        $data['search_email_Str'] = $this->input->get('email');
        $data['search_group_groupid_Num'] = $this->input->get('group_groupid');

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 20;

        $UserGroup = new UserGroup();
        $UserGroup->construct_db(array(
            'db_where_Arr' => array(
                'groupid_Num' => $data['search_group_groupid_Num']
            )
        ));
        
        //權限判斷
        if(
            in_array( 1, $data['User']->group_UserGroupList->uniqueids_Arr)
        )
        {
        }
        else if(
            in_array( 2, $data['User']->group_UserGroupList->uniqueids_Arr)
        )
        {
            $groupids_1_purview = 1;
        }
        else if(
            in_array( 3, $data['User']->group_UserGroupList->uniqueids_Arr)
        )
        {
            $groupids_1_purview = 1;
            $groupids_2_purview = 2;
            $groupids_3_purview = 3;
        }

        $data['user_UserList'] = new ObjList();
        $data['user_UserList']->construct_db(array(
            'db_where_Arr' => array(
                'uid' => $data['search_uid_Num'],
                'groupids !=' => $groupids_1_purview,
                'groupids != ' => $groupids_2_purview,
                'groupids !=  ' => $groupids_3_purview
            ),
            'db_where_like_Arr' => array(
                'username' => $data['search_username_Str'],
                'email' => $data['search_email_Str']
            ),
            'db_where_or_Arr' => array(
                'groupids' => array($UserGroup->groupid_Num)
            ),
            'db_orderby_Arr' => array(
                array('updatetime', 'DESC'),
                array('uid', 'DESC')
            ),
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'User',
            'limitstart_Num' => $limitstart_Num,
            'limitcount_Num' => $limitcount_Num
        ));
        $data['product_links'] = $data['user_UserList']->create_links(array('base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']));

        $data['UserGroupList'] = new ObjList();
        $data['UserGroupList']->construct_db(array(
            'db_where_Arr' => array(
                'groupid !=' => $groupids_1_purview,
                'groupid != ' => $groupids_2_purview,
                'groupid !=  ' => $groupids_3_purview
            ),
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

    public function tablelist_post()
    {
        $data = $this->data;//取得公用數據

        $search_uid_Num = $this->input->post('search_uid_Num', TRUE);
        $search_username_Str = $this->input->post('search_username_Str', TRUE);
        $search_email_Str = $this->input->post('search_email_Str', TRUE);
        $search_group_groupid_Num = $this->input->post('search_group_groupid_Num', TRUE);

        $url_Str = base_url('admin/base/user/user_shop/tablelist/?');

        if(!empty($search_uid_Num))
        {
            $url_Str = $url_Str.'&uid='.$search_uid_Num;
        }

        if(!empty($search_username_Str))
        {
            $url_Str = $url_Str.'&username='.$search_username_Str;
        }

        if(!empty($search_email_Str))
        {
            $url_Str = $url_Str.'&email='.$search_email_Str;
        }

        if(!empty($search_group_groupid_Num))
        {
            $url_Str = $url_Str.'&group_groupid='.$search_group_groupid_Num;
        }

        header("Location: $url_Str");
    }

    public function delete()
    {
        $hash_Str = $this->input->get('hash');
        $uid_Num = $this->input->get('uid');
        $uid_Arr = $this->input->post('uid_Arr[]');

        if(empty($uid_Arr)&&empty($uid_Num))
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '未選擇要刪除的會員',
                'url' => 'admin/base/user/user_shop/tablelist'
            ));
        }

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            if(!empty($uid_Num))
            {
                $User = new UserFieldShop([
                    'uid_Num' => $uid_Num
                ]);
                $User->delete();
            }
            
            if(!empty($uid_Arr))
            {
                foreach($uid_Arr as $key => $value_uid)
                {
                    $User = new UserFieldShop([
                        'uid_Num' => $value_uid
                    ]);
                    $User->delete();
                }
            }

            $user_User = new UserFieldShop();
            $user_User->construct(array('uid_Num' => $uid_Num));
            $user_User->delete();

            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '刪除成功',
                'url' => 'admin/base/user/user_shop/tablelist'
            ));
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/user/user_shop/tablelist'
            ));
        }
    }

}

?>