<?php

class Set_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'file';
    protected $child3_name_Str = 'set';

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

    public function set()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'set'//管理分類名稱
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

    public function set_destroy_post()
    {
        $FileList = new ObjList([
            'db_where_Arr' => [
                'status' => -1,
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'FileObj',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);
        foreach ($FileList->obj_Arr as $key => $value_file)
        {   
            $FileObj = new FileObj(['db_where_Arr' => array('fileid_Num' => $value_file->fileid_Num,'status' => -1)]);
            $FileObj->destroy();
        }

        if(!empty($FileList->obj_Arr))
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '銷毀成功',
                'url' => 'admin/base/file/set/set'
            ));
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '已無可銷毀的項目',
                'url' => 'admin/base/file/set/set'
            ));
        }
    }

    public function set_recovery_post()
    {
        $FileList = new ObjList([
            'db_where_Arr' => [
                'status' => -1,
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'FileObj',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);
        foreach ($FileList->obj_Arr as $key => $value_file)
        {
            $FileObj = new FileObj(['fileid_Num' => $value_file->fileid_Num]);
            $FileObj->recovery();
        }

        if(!empty($FileList->obj_Arr))
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '復原成功',
                'url' => 'admin/base/file/set/set'
            ));
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '已無可復原的項目',
                'url' => 'admin/base/file/set/set'
            ));
        }
    }
}

?>