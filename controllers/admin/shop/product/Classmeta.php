<?php

class Classmeta_Controller extends MY_Controller {

    protected $child1_name_Str = 'shop';
    protected $child2_name_Str = 'product';
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
        $admin_data_Arr = $this->AdminModel->get_data(array(
            'child4_name_Str' => 'edit'//管理分類名稱
        ));
        if($admin_data_Arr === FALSE) return FALSE;
        $data = array_merge($data, $admin_data_Arr);

        //引入GET數值
        $classid_Num = $this->input->get('classid');
        $slug_Str = $this->input->get('slug');

        $uid = $this->session->userdata('uid');

        //初始化ClassMeta
        $data['class_ClassMeta'] = new ClassMeta();
        $data['class_ClassMeta']->construct_db(array(
            'db_where_Arr' => array(
                'classid_Num' => $classid_Num,
                'slug_Str' => $slug_Str
            ),
            'db_where_deletenull_Bln' => TRUE
        ));
        
        //建立class2_ClassMetaList
        $data['class2_ClassMetaList'] = new ObjList();
        $data['class2_ClassMetaList']->construct_db(array(
            'db_where_Arr' => array(
                'modelname_Str' => 'product_shop_class2'
            ),
            'model_name_Str' => 'ClassMeta',
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

        $this->form_validation->set_rules('classname_Str', 'classname_Str', 'required');

        if ($this->form_validation->run() !== FALSE)
        {
            $classid_Num = $this->input->post('classid_Num', TRUE);
            $classname_Str = $this->input->post('classname_Str', TRUE);
            $slug_Str = $this->input->post('slug_Str', TRUE);
            $classids_Arr = $this->input->post('classids_Arr', TRUE);
            $prioritynum_Num = $this->input->post('prioritynum_Num', TRUE);

            $class_ClassMeta = new ClassMeta();
            $class_ClassMeta->construct(array(
                'classid_Num' => $classid_Num,
                'classname_Str' => $classname_Str,
                'slug_Str' => $slug_Str,
                'classids_Arr' => $classids_Arr,
                'prioritynum_Num' => $prioritynum_Num,
                'modelname_Str' => 'product_shop'
            ));
            $class_ClassMeta->update(array());

            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/shop/product/classmeta/tablelist'
            ));
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => validation_errors(),
                'url' => 'admin/shop/product/classmeta/tablelist'
            ));
        }
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $admin_data_Arr = $this->AdminModel->get_data(array(
            'child4_name_Str' => 'tablelist'//管理分類名稱
        ));
        if($admin_data_Arr === FALSE) return FALSE;
        $data = array_merge($data, $admin_data_Arr);

        $data['search_classname_Str'] = $this->input->get('classname');
        $data['search_slug_Str'] = $this->input->get('slug');
        $data['search_class2_slug_Str'] = $this->input->get('class2_slug');

        $limitstart = $this->input->get('limitstart');
        $limitcount = $this->input->get('limitcount');
        $limitcount = empty($limitcount) ? 20 : $limitcount;
        $limitcount = $limitcount > 100 ? 100 : $limitcount;

        $class_ClassMeta = new ClassMeta();
        $class_ClassMeta->construct_db(array(
            'db_where_Arr' => array(
                'uid_Str' => $data['User']->uid_Num,
                'slug_Str' => $data['search_class2_slug_Str']
            ),
            'db_where_deletenull_Bln' => FALSE
        ));

        $data['class_list_ClassMetaList'] = new ObjList();
        $data['class_list_ClassMetaList']->construct_db(array(
            'db_where_Arr' => array(
                'modelname_Str' => 'product_shop',
                'slug_Str' => $data['search_slug_Str']
            ),
            'db_where_like_Arr' => array(
                'classname_Str' => $data['search_classname_Str']
            ),
            'db_where_or_Arr' => array(
                'classids' => array($class_ClassMeta->classid_Num)
            ),
            'db_where_deletenull_Bln' => TRUE,
            'db_orderby_Arr' => array(
                array('prioritynum', 'DESC'),
                array('classid', 'DESC')
            ),
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ));
        $data['class_links'] = $data['class_list_ClassMetaList']->create_links(array('base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']));
        
        //建立class2_ClassMetaList
        $data['class2_ClassMetaList'] = new ObjList();
        $data['class2_ClassMetaList']->construct_db(array(
            'db_where_Arr' => array(
                'modelname_Str' => 'product_shop_class2'
            ),
            'model_name_Str' => 'ClassMeta',
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
        $data = $this->data;

        $search_classname_Str = $this->input->post('search_classname_Str', TRUE);
        $search_slug_Str = $this->input->post('search_slug_Str', TRUE);
        $search_class2_slug_Str = $this->input->post('search_class2_slug_Str', TRUE);

        $url_Str = base_url('admin/shop/product/classmeta/tablelist/?');

        if(!empty($search_classname_Str))
        {
            $url_Str = $url_Str.'&classname='.$search_classname_Str;
        }

        if(!empty($search_slug_Str))
        {
            $url_Str = $url_Str.'&slug='.$search_slug_Str;
        }

        if(!empty($search_class2_slug_Str))
        {
            $url_Str = $url_Str.'&class2_slug='.$search_class2_slug_Str;
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
            $ClassMeta = new ClassMeta();
            $ClassMeta->construct(array('classid_Num' => $classid_Num));
            $ClassMeta->destroy();

            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '刪除成功',
                'url' => 'admin/shop/product/classmeta/tablelist'
            ));
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/shop/product/classmeta/tablelist'
            ));
        }
    }

}