<?php

class Classmeta_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'file';
    protected $child3_name_Str = 'classmeta';

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

        $classid_Num = $this->input->get('classid');
        $slug_Str = $this->input->get('slug');

        //初始化ClassMeta
        $data['class_ClassMeta'] = new ClassMeta([
            'db_where_Arr' => [
                'classid_Num' => $classid_Num,
                'slug_Str' => $slug_Str
            ],
            'db_where_deletenull_Bln' => TRUE
        ]);
        
        //建立class2_ClassMetaList
        $data['class2_ClassMetaList'] = new ObjList([
            'db_where_Arr' => [
                'modelname_Str' => 'file'
            ],
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
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

        $this->form_validation->set_rules('classname_Str', 'classname', 'required');

        if ($this->form_validation->run() === TRUE)
        {
          	$classid_Num = $this->input->post('classid_Num', TRUE);
            $classname_Str = $this->input->post('classname_Str', TRUE);
            $slug_Str = $this->input->post('slug_Str', TRUE);
            $content_Str = $this->input->post('content_Str', TRUE);
            $prioritynum_Num = $this->input->post('prioritynum_Num', TRUE);
                
            $ClassMeta = new ClassMeta([
            	'classid_Num' => $classid_Num,
            	'classname_Str' => $classname_Str,
            	'slug_Str' => $slug_Str,
                'content_Str' => $content_Str,
                'prioritynum_Num' => $prioritynum_Num,
            	'modelname_Str' => 'file'
            ]);
            $ClassMeta->update();

            //送出成功訊息
            $this->load->model('Message');
            $this->Message->show([
                'message' => '設定成功',
                'url' => 'admin/base/file/classmeta/tablelist'
            ]);
        }
        else
        {
            $validation_errors_Str = validation_errors();
            $validation_errors_Str = !empty($validation_errors_Str) ? $validation_errors_Str : '設定錯誤' ;
            $this->load->model('Message');
            $this->Message->show([
                'message' => $validation_errors_Str,
                'url' => 'admin/base/file/classmeta/tablelist'
            ]);
        }
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data([
            'child4_name_Str' => 'tablelist'//管理分類名稱
        ]));

        $data['search_classname_Str'] = $this->input->get('classname');
        $data['search_slug_Str'] = $this->input->get('slug');
        $data['search_class_slug_Str'] = $this->input->get('class_slug');

        $limitstart = $this->input->get('limitstart');
        $limitcount = $this->input->get('limitcount');
        $limitcount = empty($limitcount) ? 20 : $limitcount;
        $limitcount = $limitcount > 100 ? 100 : $limitcount;

        $class_ClassMeta = new ClassMeta([
            'db_where_Arr' => [
                'uid_Str' => $data['User']->uid_Num,
                'slug_Str' => $data['search_class_slug_Str']
            ],
            'db_where_deletenull_Bln' => FALSE
        ]);

        $data['class_list_ClassMetaList'] = new ObjList([
            'db_where_Arr' => [
                'modelname_Str' => 'file',
                'uid_Str' => $data['User']->uid_Num,
                'slug_Str' => $data['search_slug_Str']
            ],
            'db_where_like_Arr' => [
                'classname_Str' => $data['search_classname_Str']
            ],
            'db_where_or_Arr' => [
                'classids' => [$class_ClassMeta->classid_Num]
            ],
            'db_where_deletenull_Bln' => TRUE,
            'db_orderby_Arr' => [
                'prioritynum' => 'DESC',
                'classid' => 'DESC'
            ],
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);
        $data['class_links'] = $data['class_list_ClassMetaList']->create_links(['base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']]);

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

        $search_classname_Str = $this->input->post('search_classname_Str', TRUE);
        $search_slug_Str = $this->input->post('search_slug_Str', TRUE);

        $url_Str = base_url('admin/base/file/classmeta/tablelist/?');

        if(!empty($search_classname_Str))
        {
            $url_Str = $url_Str.'&classname='.$search_classname_Str;
        }

        if(!empty($search_slug_Str))
        {
            $url_Str = $url_Str.'&slug='.$search_slug_Str;
        }

        header("Location: $url_Str");
    }

    public function delete()
    {
        $hash_Str = $this->input->get('hash');
        $classid_Num = $this->input->get('classid');

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            $ClassMeta = new ClassMeta(['classid_Num' => $classid_Num]);
            $ClassMeta->destroy();

            $this->load->model('Message');
            $this->Message->show([
                'message' => '刪除成功',
                'url' => 'admin/base/file/classmeta/tablelist'
            ]);
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show([
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/file/classmeta/tablelist'
            ]);
        }
    }

}

?>