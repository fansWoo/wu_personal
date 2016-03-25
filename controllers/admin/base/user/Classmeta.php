<?php

class Classmeta_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'user';
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
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'edit'//管理分類名稱
        )));

        //引入GET數值
        $classid_Num = $this->input->get('classid');
        $slug_Str = $this->input->get('slug');

        //初始化ClassMeta
        $data['ClassMeta'] = new ClassMeta();
        $data['ClassMeta']->construct_db(array(
            'db_where_Arr' => array(
                'classid_Num' => $classid_Num,
                'slug_Str' => $slug_Str
            ),
            'db_where_deletenull_Bln' => TRUE
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
            $prioritynum_Num = $this->input->post('prioritynum_Num', TRUE);

            $class_ClassMeta = new ClassMeta();
            $class_ClassMeta->construct(array(
                'classid_Num' => $classid_Num,
                'classname_Str' => $classname_Str,
                'prioritynum_Num' => $prioritynum_Num,
                'modelname_Str' => 'advertising'
            ));
            $class_ClassMeta->update(array());

            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/advertising/classmeta/tablelist'
            ));
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => validation_errors(),
                'url' => 'admin/base/advertising/classmeta/tablelist'
            ));
        }
    }

    public function tablelist()
    {
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'tablelist'//管理分類名稱
        )));

        $limitstart = $this->input->get('limitstart');
        $limitcount = $this->input->get('limitcount');
        $limitcount = !empty($limitcount) ? $limitcount : 20;
        $limitcount = $limitcount > 100 ? $limitcount : 100;

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
            'db_where_Arr' => [
                'groupid !=' => $groupids_1_purview,
                'groupid != ' => $groupids_2_purview,
                'groupid !=  ' => $groupids_3_purview
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'UserGroup',
            'limitstart_Num' => $limitstart,
            'limitcount_Num' => $limitcount
        ));
        $data['class_links'] = $data['UserGroupList']->create_links(array('base_url_Str' => 'admin/'.$data['child1_name_Str'].'/'.$data['child2_name_Str'].'/'.$data['child3_name_Str'].'/'.$data['child4_name_Str']));

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

}