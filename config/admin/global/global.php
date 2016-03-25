<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['setting_Arr'] = [
    [
        'title' => '網站標題管理',
        'subtitle' => '請填寫標題之詳細資訊',
        'form_open' => 'admin/base/global/global/global_setting_post',
        'child' => [
            [
                'title' => '網站標題名稱',
                'type' => 'input:text',
                'placeholder' => '請輸入網站標題名稱',
                'explanation' => '本網站標題名稱將於網站標題最前端顯示',
                'name' => 'website_title_name'
            ],
            [
                'title' => '網站標題引言',
                'type' => 'input:text',
                'placeholder' => '請輸入網站標題名稱',
                'explanation' => '本網站標題名稱將於網站標題最前端顯示',
                'name' => 'website_title_introduction'
            ]
        ]
    ],
    [
        'title' => '網站名稱設置',
        'subtitle' => '請填寫網站名稱及LOGO圖檔，此設置之設置將影響網站前台之顯示',
        'form_open' => 'admin/base/global/global/global_setting_post',
        'child' => [
            [
                'title' => '網站名稱',
                'type' => 'input:text',
                'placeholder' => '請輸入網站名稱',
                'explanation' => '',
                'name' => 'website_title_name'
            ],
            [
                'title' => '網站LOGO圖檔',
                'type' => 'input:text',
                'placeholder' => '請輸入圖檔連結，http://',
                'explanation' => '請填寫圖檔位置，可以填寫hc本網站圖檔之相對位置，也可以填寫外網之絕對位置網址',
                'name' => 'website_title_introduction'
            ]
        ]
    ]
];