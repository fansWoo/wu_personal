<?php

class MY_Controller extends FS_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = $this->data;

        $this->data['global']['js'][] = 'global.js';

        //開發期間，限定使用者必須登入後始可瀏覽全部頁面
        // $no_rewrite_Str = $this->input->get('no_rewrite');
        // if($data['User']->uid_Num == '' && $no_rewrite_Str !== 'true')
        // {
        //     $url = base_url('user/login/?no_rewrite=true');
        //     header('Location: '.$url);
        // }

    }
}