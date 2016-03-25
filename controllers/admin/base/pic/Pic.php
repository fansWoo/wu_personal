<?php

class Pic_Controller extends MY_Controller {

    protected $child1_name_Str = 'base';
    protected $child2_name_Str = 'pic';
    protected $child3_name_Str = 'pic';
    
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

        $picid_Num = $this->input->get('picid');
            
        $data['PicObj'] = new PicObj();
        $data['PicObj']->construct_db(array(
        	'db_where_Arr' => array(
        		'picid_Num' => $picid_Num
        	)
        ));

        $data['UserGroup_Num'] = $data['User']->group_UserGroupList->obj_Arr[0]->groupid_Num;

        if($data['UserGroup_Num'] == 100)
        {   
            $data['ClassMetaList'] = new ObjList();
            $data['ClassMetaList']->construct_db(array(
            	'db_where_Arr' => array(
            		'uid_Str' => $data['User']->uid_Num,
            		'modelname' => 'pic'
            	),
                'model_name_Str' => 'ClassMeta',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ));
        }
        else
        {
            $data['ClassMetaList'] = new ObjList();
            $data['ClassMetaList']->construct_db(array(
                'db_where_Arr' => array(
                    'modelname' => 'pic'
                ),
                'model_name_Str' => 'ClassMeta',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ));
        }

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
        $picids_Arr = $this->input->post('picids_Arr');

		$picid_Num = $this->input->post('picid_Num');
        $classids_Arr = $this->input->post('classids_Arr');

		if(!empty($picid_Num))
		{
		    $PicObj = new PicObj();
		    $PicObj->construct_db(array(
		    	'db_where_Arr' => array(
		        	'picid_Num' => $picid_Num
		        )
		    ));
            $PicObj->class_ClassMetaList = new ObjList();
            $PicObj->class_ClassMetaList->construct_db(array(
                'db_where_or_Arr' => array(
                    'classid' => $classids_Arr
                ),
                'db_from_Str' => 'class',
                'model_name_Str' => 'ClassMeta',
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ));
            $PicObj->updatetime_DateTime = new DateTimeObj();
		    $PicObj->updatetime_DateTime->construct();
            if(!empty($classids_Arr[0]))
            {
                $PicObj->upload_status_Num = 1;
            }
            else
            {
                $PicObj->upload_status_Num = 2;
            }
		    $PicObj->update();

            if( !empty($comment_content_Str) )
            {
                $Comment = new Comment;
                $Comment->construct([
                    'uid_Num' => $data['User']->uid_Num,
                    'typename_Str' => 'pic',
                    'id_Num' => $PicObj->picid_Num,
                    'content_Str' => $comment_content_Str
                ]);
                $Comment->update();
            }

			$this->load->model('Message');
			$this->Message->show(array(
			    'message' => '設定成功',
			    'url' => 'admin/base/pic/pic/tablelist'
			));
		}
		else if( !empty($picids_Arr) )
		{
		    $PicObjList = new ObjList;
            $PicObjList->construct_db([
                'db_where_or_Arr' => [
                    'picid' => $picids_Arr
                ],
                'model_name_Str' => 'PicObj',
                'db_orderby_Arr' => [
                    ['prioritynum', 'DESC'],
                    ['updatetime', 'DESC']
                ],
                'limitstart_Num' => 0,
                'limitcount_Num' => 100
            ]);

            if(!empty($classids_Arr))
            {
                foreach($PicObjList->obj_Arr as $key => $value_PicObj)
                {
                    $value_PicObj->set('class_ClassMetaList', [
                        'classids_Arr' => $classids_Arr
                    ], 'ClassMetaList');
                    // $value_PicObj->upload_status_Num = 1;
                    $value_PicObj->update();
                }
            }

            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '設定成功',
                'url' => 'admin/base/pic/pic/tablelist'
            ));
		}
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '未知的錯誤',
                'url' => 'admin/base/pic/pic/tablelist'
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
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 30;

        $data['search_class_slug_Str'] = $this->input->get('class_slug');
        $data['search_title_Str'] = $this->input->get('title');
        $data['search_picid_Num'] = $this->input->get('picid');
        $data['search_username_Str'] = $this->input->get('username');

        $class_ClassMeta = new ClassMeta();
        $class_ClassMeta->construct_db(array(
            'db_where_Arr' => array(
                'slug_Str' => $data['search_class_slug_Str']
            ),
            'db_where_deletenull_Bln' => FALSE
        ));

        $User = new User();
        $User->construct_db(array(
            'db_where_Arr' => array(
                'username' => $data['search_username_Str']
            )
        ));

        $data['UserGroup_Num'] = $data['User']->group_UserGroupList->obj_Arr[0]->groupid_Num;

        $construct_Arr = [
            'db_where_Arr' => [
                'picid' => $data['search_picid_Num'],
                'upload_status !=' => 3
            ],
            'db_where_like_Arr' => array(
                'title' => $data['search_title_Str']
            ),
            'db_where_or_Arr' => array(
                'classids' => array($class_ClassMeta->classid_Num)
            ),
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'PicObj',
            'db_orderby_Arr' => array(
                'prioritynum' => 'DESC',
                'updatetime' => 'DESC'
            ),
            'limitstart_Num' => $limitstart_Num,
            'limitcount_Num' => $limitcount_Num
        ];

        //搜尋upload_status=2的待分類圖片
        if( $data['search_class_slug_Str'] == 'unclassified' )
        {
            $construct_Arr['db_where_Arr']['upload_status'] = 2;
        }
        //搜尋upload_status=3的隱藏圖片
        else if( $data['search_class_slug_Str'] == 'hidden' )
        {
            $construct_Arr['db_where_Arr']['upload_status'] = 3;
        }

        if($data['UserGroup_Num'] == 100)
        {
            $construct_Arr['db_where_Arr']['uid'] = $data['User']->uid_Num;
        }

        // ec($construct_Arr);

        $data['piclist_PicList'] = new ObjList($construct_Arr);
        $data['pic_links'] = $data['piclist_PicList']->create_links(array('base_url_Str' => "admin/base/pic/pic/tablelist/?class_slug=$data[search_class_slug_Str]"));

        // ec($data['piclist_PicList']);

        if($data['UserGroup_Num'] == 100)
        {
            $data['pic_ClassMetaList'] = $this->load->model('ObjList', nrnum());
            $data['pic_ClassMetaList']->construct_db(array(
                'db_where_Arr' => array(
                    'uid_Num' => $data['User']->uid_Num,
                    'modelname' => 'pic'
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
        }
        else
        {
            $data['pic_ClassMetaList'] = $this->load->model('ObjList', nrnum());
            $data['pic_ClassMetaList']->construct_db(array(
                'db_where_Arr' => array(
                    'modelname' => 'pic'
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
        }

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

        $search_picid_Num = $this->input->post('search_picid_Num', TRUE);
        $search_title_Str = $this->input->post('search_title_Str', TRUE);
        $search_class_slug_Str = $this->input->post('search_class_slug_Str', TRUE);
        $search_username_Str = $this->input->post('search_username_Str', TRUE);

        $url_Str = base_url('admin/base/pic/pic/tablelist/?');

        if(!empty($search_picid_Num))
        {
            $url_Str = $url_Str.'&picid='.$search_picid_Num;
        }

        if(!empty($search_title_Str))
        {
            $url_Str = $url_Str.'&title='.$search_title_Str;
        }

        if(!empty($search_class_slug_Str))
        {
            $url_Str = $url_Str.'&class_slug='.$search_class_slug_Str;
        }

        if(!empty($search_username_Str))
        {
            $url_Str = $url_Str.'&username='.$search_username_Str;
        }

        header("Location: $url_Str");
    }
	
    public function delete()
    {
        $hash_Str = $this->input->get('hash');
        $picid_Num = $this->input->get('picid');
        $picid_Arr = $this->input->post('picid_Arr[]');

        if(empty($picid_Arr)&&empty($picid_Num))
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '未選擇要刪除的圖片',
                'url' => 'admin/base/pic/pic/tablelist'
            ));
        }

        //CSRF過濾
        if($hash_Str == $this->security->get_csrf_hash())
        {
            if(!empty($picid_Num))
            {
                $PicObj = new PicObj([
                    'picid_Num' => $picid_Num
                ]);
                $PicObj->delete();
            }
            
            if(!empty($picid_Arr))
            {
                foreach($picid_Arr as $key => $value_Pic)
                {
                    $PicObj = new PicObj([
                        'picid_Num' => $value_Pic
                    ]);
                    $PicObj->delete();
                }
            }

            $this->load->model('Message');
            $this->Message->show(array(
                'message' => '刪除成功',
	        	'url' => 'admin/base/pic/pic/tablelist'
            ));
        }
        else
        {
            $this->load->model('Message');
            $this->Message->show(array(
                'message' => 'hash驗證失敗，請使用標準瀏覽器進行刪除動作',
                'url' => 'admin/base/pic/pic/tablelist'
            ));
        }
    }
}

?>