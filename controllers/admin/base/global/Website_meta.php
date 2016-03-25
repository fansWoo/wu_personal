<?php

class Website_meta_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'global';
    protected $child3_name_Str = 'website_meta';

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
    
    public function seo($input = '')
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'seo'//管理分類名稱
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

    public function seo_post()
    {
        $this->form_validation->set_rules('website_metatag', 'SEO標籤', 'required');
                
        if ($this->form_validation->run() === TRUE)
        {
            $website_metatag = $this->input->post('website_metatag', TRUE);

            $Setting = new Setting;
            $Setting->construct(array(
                'keyword_Str' => 'website_metatag',
                'value_Str' => $website_metatag
            ));
            $Setting->update();

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/global/website_meta/seo'
            ));
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => $validation_errors_Str,
                'url' => 'admin/base/global/website_meta/seo'
            ));
        }
    }
    
    public function plugin($input = '')
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'plugin'//管理分類名稱
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

    public function plugin_ga_post()
    {

        $this->form_validation->set_rules('website_script_plugin_ga', 'GA Script Plugin');

        if ($this->form_validation->run() === TRUE)
        {
            $website_script_plugin_ga = $this->input->post('website_script_plugin_ga');

            $SettingList = new SettingList();
            $SettingList->construct(array(
                'construct_Arr' => array(
                    array(
                        'keyword_Str' => 'website_script_plugin_ga',
                        'value_Str' => $website_script_plugin_ga
                    )
                )
            ));
            $SettingList->update(array());

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/global/website_meta/plugin'
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
                'url' => 'admin/base/global/website_meta/plugin'
            ));
        }
    }

    public function plugin_fb_post()
    {
        $this->form_validation->set_rules('website_script_plugin_fb', 'Custom Script Plugin');

        if ($this->form_validation->run() === TRUE)
        {
            $website_script_plugin_fb = $this->input->post('website_script_plugin_fb');

            $SettingList = new SettingList();
            $SettingList->construct(array(
                'construct_Arr' => array(
                    array(
                        'keyword_Str' => 'website_script_plugin_fb',
                        'value_Str' => $website_script_plugin_fb
                    )
                )
            ));
            $SettingList->update(array());

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/global/website_meta/plugin'
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
                'url' => 'admin/base/global/website_meta/plugin'
            ));
        }
    }

    public function plugin_custom_post()
    {

        $this->form_validation->set_rules('website_script_plugin_custom', 'Custom Script Plugin');

        if ($this->form_validation->run() === TRUE)
        {
            $website_script_plugin_custom = $this->input->post('website_script_plugin_custom');

            $SettingList = new SettingList();
            $SettingList->construct(array(
                'construct_Arr' => array(
                    array(
                        'keyword_Str' => 'website_script_plugin_custom',
                        'value_Str' => $website_script_plugin_custom
                    )
                )
            ));
            $SettingList->update(array());

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/global/website_meta/plugin'
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
                'url' => 'admin/base/global/website_meta/plugin'
            ));
        }
    }

}

?>