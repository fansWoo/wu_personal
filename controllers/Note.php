<?php

class Note_Controller extends MY_Controller {
    
	public function index()
    {
        $data = $this->data;

        $limitstart_Num = $this->input->get('limitstart');
        $limitcount_Num = $this->input->get('limitcount');
        $limitcount_Num = !empty($limitcount_Num) ? $limitcount_Num : 10;

        $search_class_slug_Str = $this->input->get('class_slug');
        $class_ClassMeta = new ClassMeta([
            'db_where_Arr' => array(
                'slug' => $search_class_slug_Str
            )
        ]);
        
        $data['new_NoteFieldList'] = new ObjList([
            'db_where_Arr' => [
                'note.modelname' => 'note',
                'note.locale' => $data['global']['locale']
            ],
            'db_where_or_Arr' => [
                'classids' => [$class_ClassMeta->classid_Num]
            ],
            'db_orderby_Arr' => [
                'note.prioritynum' => 'DESC',
                'note.updatetime' => 'DESC'                
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'NoteField',
            'limitstart_Num' => $limitstart_Num,
            'limitcount_Num' => $limitcount_Num
        ]);
        $data['page_link'] = $data['new_NoteFieldList']->create_links(array('base_url_Str' => 'note/'));

        $data['ClassMetaList'] = new ObjList([
            'db_where_Arr' => [
                'modelname' => 'note'
            ],
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);
        
        //global
		$data['global']['style'][] = 'temp/global.css';
		$data['global']['style'][] = 'note/index.css';
        
        //temp
        $data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
        $data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
        $data['temp']['header_bar'] = $this->load->view('temp/header_bar', $data, TRUE);
        $data['temp']['footer_bar'] = $this->load->view('temp/footer_bar', $data, TRUE);
        $data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);
		
		//輸出模板
		$this->load->view('note/index', $data);
	}

    public function view($arg = '')
    {
        $data = $this->data;

        if( empty($arg) )
        {
            $noteid_Num = $this->input->get('noteid');
            $slug_Str = $this->input->get('slug');
        }
        else if( is_numeric($arg) )
        {
            $noteid_Num = $arg;
        }
        else if( is_string($arg) )
        {
            $slug_Str = $arg;
        }

        if(!empty($slug_Str))
        {
            $data['NoteField'] = new NoteField([
                'db_where_Arr' => [
                    'note.slug' => $slug_Str,
                    'note.locale' => $data['global']['locale']
                ]
            ]);
        }
        else if(!empty($noteid_Num))
        {
            $data['NoteField'] = new NoteField([
                'db_where_Arr' => [
                    'note.noteid' => $noteid_Num,
                    'note.locale' => $data['global']['locale']
                ]
            ]);
        }
        
        if(
            empty( $data['NoteField']->noteid_Num )
        )
        {
            $this->load->model('Message');
            $this->Message->show(array('message' => '文章連結錯誤', 'url' => 'note'));
            return FALSE;
        }
        
        $data['ClassMetaList'] = new ObjList([
            'db_where_Arr' => [
                'modelname' => 'note'
            ],
            'model_name_Str' => 'ClassMeta',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);

        $data['new_NoteFieldList'] = new ObjList([
            'db_where_Arr' => [
                'modelname' => 'note'
            ],
            'db_orderby_Arr' => [
                'note.updatetime' => 'DESC',
                'note.prioritynum' => 'DESC'
            ],
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'NoteField',
            'limitstart_Num' => 0,
            'limitcount_Num' => 5
        ]);
        
        //global
        $data['global']['style'][] = 'temp/global.css';
        $data['global']['style'][] = 'note/view.css';
        
        //temp
        $data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
        $data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
        $data['temp']['header_bar'] = $this->load->view('temp/header_bar', $data, TRUE);
        $data['temp']['footer_bar'] = $this->load->view('temp/footer_bar', $data, TRUE);
        $data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);
        
        //輸出模板
        $this->load->view('note/view', $data);
    }

}

?>