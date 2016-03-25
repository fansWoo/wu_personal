<?php

class File_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'file';
    protected $child3_name_Str = 'file';
    
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

        $fileid_Num = $this->input->get('fileid');
            
        $data['FileObj'] = new FileObj();
        $data['FileObj']->construct_db(array(
        	'db_where_Arr' => array(
        		'fileid_Num' => $fileid_Num
        	)
        ));
            
        $data['ClassMetaList'] = new ObjList();
        $data['ClassMetaList']->construct_db(array(
        	'db_where_Arr' => array(
        		'uid_Str' => $data['User']->uid_Num,
        		'modelname' => 'file'
        	),
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ));

        //global
        $data['global']['style'][] = 'admin/global.css';
        $data['global']['js'][] = 'admin.js';
        $data['global']['js'][] = 'tool/jquery.form.js';
            
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
        $fileids_Arr = $this->input->post('fileids_Arr');
		$fileid_Num = $this->input->post('fileid_Num');
        $classids_Arr = $this->input->post('classids_Arr');
        $permission_emails_Str = $this->input->post('permission_emails_Str');

		if(!empty($fileid_Num))
		{
		    $FileObj = new FileObj();
		    $FileObj->construct_db(array(
		    	'db_where_Arr' => array(
		        	'fileid_Num' => $fileid_Num,
		        )
		    ));

            $FileObj->set__permission_uids_UserList(['permission_emails_Str' => $permission_emails_Str]);

            $FileObj->class_ClassMetaList = new ObjList();
            $FileObj->class_ClassMetaList->construct_db(array(
                'db_where_or_Arr' => array(
                    'classid' => $classids_Arr
                ),
                'db_from_Str' => 'class',
                'model_name_Str' => 'ClassMeta',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ));
            $FileObj->updatetime_DateTime = new DateTimeObj();
		    $FileObj->updatetime_DateTime->construct();
		    $FileObj->update();

			$this->load->model('Message');
			$this->Message->show(array(
			    'message' => '設定成功',
			    'url' => 'admin/base/file/file/tablelist'
			));
		}
		else if( !empty($fileids_Arr) )
		{
		    $FileObjList = new ObjList;
            $FileObjList->construct_db([
                'db_where_or_Arr' => [
                    'fileid' => $fileids_Arr
                ],
                'model_name_Str' => 'FileObj',
                'db_orderby_Arr' => [
                    ['prioritynum', 'DESC'],
                    ['updatetime', 'DESC']
                ],
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ]);

            foreach($FileObjList->obj_Arr as $key => $value_FileObj)
            {
                $value_FileObj->set('class_ClassMetaList', [
                    'classids_Arr' => $classids_Arr
                ], 'ClassMetaList');
                $value_FileObj->set__permission_uids_UserList(['permission_emails_Str' => $permission_emails_Str]);
                $value_FileObj->update();
            }

            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/file/file/tablelist'
            ));
		}
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '未知的錯誤',
                'url' => 'admin/base/file/file/tablelist'
            ));
        }

	}
	
	public function tablelist()
	{
        $data = $this->data;//取得公用數據
        $data = array_merge($data, $this->AdminModel->get_data(array(
            'child4_name_Str' => 'tablelist'//管理分類名稱
        )));

		$limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = empty($limitcount_Num) ? 20 : $limitcount_Num;
        $limitcount_Num = $limitcount_Num > 100 ? 100 : $limitcount_Num;

        $data['search_class_slug_Str'] = $this->input->get('class_slug');
        $data['search_title_Str'] = $this->input->get('title');
        $data['search_fileid_Num'] = $this->input->get('fileid');

        $class_ClassMeta = new ClassMeta();
        $class_ClassMeta->construct_db(array(
            'db_where_Arr' => array(
                'uid_Str' => $data['User']->uid_Num,
                'slug_Str' => $data['search_class_slug_Str']
            ),
            'db_where_deletenull_Bln' => FALSE
        ));

        $data['filelist_FileList'] = new ObjList;
        $data['filelist_FileList']->construct_db(array(
            'db_where_Arr' => array(
                'fileid_Num' => $data['search_fileid_Num'],
                'uid_Num' => $data['User']->uid_Num,
            ),
            'db_where_like_Arr' => array(
                'title_Str' => $data['search_title_Str']
            ),
            'db_where_or_Arr' => array(
                'classids_Str' => array($class_ClassMeta->classid_Num)
            ),
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'FileObj',
            'db_orderby_Arr' => array(
                'prioritynum' => 'DESC',
                'updatetime' => 'DESC'
            ),
            'limitstart_Num' => $limitstart_Num,
            'limitcount_Num' => $limitcount_Num
      	));
        $data['file_links'] = $data['filelist_FileList']->create_links(array('base_url_Str' => "admin/base/file/file/tablelist/?class_slug=$data[search_class_slug_Str]"));

        $data['file_ClassMetaList'] = $this->load->model('ObjList', nrnum());
        $data['file_ClassMetaList']->construct_db(array(
            'db_where_Arr' => array(
                'uid_Num' => $data['User']->uid_Num,
                'modelname' => 'file'
            ),
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'ClassMeta',
            'db_orderby_Arr' => array(
                array('prioritynum', 'DESC'),
                array('updatetime', 'DESC')
            ),
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

        $search_fileid_Num = $this->input->post('search_fileid_Num', TRUE);
        $search_title_Str = $this->input->post('search_title_Str', TRUE);
        $search_class_slug_Str = $this->input->post('search_class_slug_Str', TRUE);

        $url_Str = base_url('admin/base/file/file/tablelist/?');

        if(!empty($search_fileid_Num))
        {
            $url_Str = $url_Str.'&fileid='.$search_fileid_Num;
        }

        if(!empty($search_title_Str))
        {
            $url_Str = $url_Str.'&title='.$search_title_Str;
        }

        if(!empty($search_class_slug_Str))
        {
            $url_Str = $url_Str.'&class_slug='.$search_class_slug_Str;
        }

        header("Location: $url_Str");
    }
	
    public function delete()
    {
        $hash_Str = $this->input->get('hash');
        $fileid_Num = $this->input->get('fileid');
        $fileid_Arr = $this->input->post('fileid_Arr[]');

        if(empty($fileid_Arr)&&empty($fileid_Num))
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '未選擇要刪除的檔案',
                'url' => 'admin/base/file/file/tablelist'
            ));
        }

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            if(!empty($fileid_Num))
            {
                $FileObj = new FileObj([
                    'fileid_Num' => $fileid_Num
                ]);
                $FileObj->delete();
            }
            
            if(!empty($fileid_Arr))
            {
                foreach($fileid_Arr as $key => $value_file)
                {
                    $FileObj = new FileObj([
                        'fileid_Num' => $value_file
                    ]);
                    $FileObj->delete();
                }
            }

            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '刪除成功',
	        	'url' => 'admin/base/file/file/tablelist'
            ));
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/file/file/tablelist'
            ));
        }
    }
}

?>