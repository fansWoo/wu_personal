<?php

class Global_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
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

        if(empty($data['User']->uid_Num))
        {
            $url = base_url('user/login/?url=admin');
            header('Location: '.$url);
            return FALSE;
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function common()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'common'//管理分類名稱
        )));

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

    public function common_title_post()
    {

        $this->form_validation->set_rules('website_title_name', '網站標題名稱', 'required');

        if ($this->form_validation->run() === TRUE)
        {
            $website_title_name = $this->input->post('website_title_name', TRUE);
            $website_title_introduction = $this->input->post('website_title_introduction', TRUE);

            $SettingList = new SettingList();
            $SettingList->construct(array(
                'construct_Arr' => array(
                    array(
                        'keyword_Str' => 'website_title_name',
                        'value_Str' => $website_title_name
                    ),
                    array(
                        'keyword_Str' => 'website_title_introduction',
                        'value_Str' => $website_title_introduction
                    )
                )
            ));
            $SettingList->update(array());

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/global/global/common'
            ));
        }
        else
        {
            //送出失敗訊息
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => $validation_errors_Str,
                'url' => 'admin/base/global/global/common'
            ));
        }
    }

    public function common_webname_post()
    {

        $this->form_validation->set_rules('website_name', '網站名稱', 'required');
        $this->form_validation->set_rules('website_logo', '網站LOGO', 'required');
                
        if ($this->form_validation->run() !== FALSE)
        {
            $website_name = $this->input->post('website_name', TRUE);
            $website_logo = $this->input->post('website_logo', TRUE);

            $SettingList = new SettingList();
            $SettingList->construct(array(
                'construct_Arr' => array(
                    array(
                        'keyword_Str' => 'website_name',
                        'value_Str' => $website_name
                    ),
                    array(
                        'keyword_Str' => 'website_logo',
                        'value_Str' => $website_logo
                    )
                )
            ));
            $SettingList->update(array());

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/global/global/common'
            ));
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => $validation_errors_Str,
                'url' => 'admin/base/global/global/common'
            ));
        }
    }

    public function common_email_post()
    {

        $this->form_validation->set_rules('website_email', '網站電子郵件', 'required');
                
        if ($this->form_validation->run() === TRUE)
        {
            $website_email = $this->input->post('website_email', TRUE);

            $SettingList = new SettingList();
            $SettingList->construct(array(
                'construct_Arr' => array(
                    array(
                        'keyword_Str' => 'website_email',
                        'value_Str' => $website_email
                    )
                )
            ));
            $SettingList->update(array());

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/global/global/common'
            ));
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => $validation_errors_Str,
                'url' => 'admin/base/global/global/common'
            ));
        }
    }

    public function email()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'email'//管理分類名稱
        )));


        $SettingList = new SettingList();
        $SettingList->construct_db([
            'db_where_Arr' => [
                'modelname' => 'smtp'
            ]
        ]);
        $data['global'] = array_merge($data['global'], $SettingList->get_array());

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

    public function email_smtp_post()
    {

        $this->form_validation->set_rules('smtp_account', 'SMTP顯示郵件', 'required');
        $this->form_validation->set_rules('smtp_email', 'SMTP帳號', 'required');
        $this->form_validation->set_rules('smtp_password', 'SMTP密碼', 'required');
        $this->form_validation->set_rules('smtp_email', 'SMTP姓名', 'required');
        $this->form_validation->set_rules('smtp_password', 'SMTP Host', 'required');

        if ($this->form_validation->run() === TRUE)
        {
            $smtp_account_Str = $this->input->post('smtp_account', TRUE);
            $smtp_email_Str = $this->input->post('smtp_email', TRUE);
            $smtp_password_Str = $this->input->post('smtp_password', TRUE);
            $smtp_username_Str = $this->input->post('smtp_username', TRUE);
            $smtp_host_Str = $this->input->post('smtp_host', TRUE);
            $smtp_ssl_checkbox_Num = $this->input->post('smtp_ssl_checkbox', TRUE);
            $smtp_ssl_checkbox_Num = !empty($smtp_ssl_checkbox_Num) ? 1 : 0;

            $SettingList = new SettingList();
            $SettingList->construct(array(
                'construct_Arr' => array(
                    array(
                        'keyword_Str' => 'smtp_account',
                        'value_Str' => $smtp_account_Str,
                        'modelname_Str' => 'smtp'
                    ),
                    array(
                        'keyword_Str' => 'smtp_email',
                        'value_Str' => $smtp_email_Str,
                        'modelname_Str' => 'smtp'
                    ),
                    array(
                        'keyword_Str' => 'smtp_password',
                        'value_Str' => $smtp_password_Str,
                        'modelname_Str' => 'smtp'
                    ),
                    array(
                        'keyword_Str' => 'smtp_host',
                        'value_Str' => $smtp_host_Str,
                        'modelname_Str' => 'smtp'
                    ),
                    array(
                        'keyword_Str' => 'smtp_username',
                        'value_Str' => $smtp_username_Str,
                        'modelname_Str' => 'smtp'
                    ),
                    array(
                        'keyword_Str' => 'smtp_ssl_checkbox',
                        'value_Str' => $smtp_ssl_checkbox_Num,
                        'modelname_Str' => 'smtp'
                    )
                )
            ));
            $SettingList->update(array());

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/global/global/email'
            ));
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => $validation_errors_Str,
                'url' => 'admin/base/global/global/email'
            ));
        }
    }

}

?>