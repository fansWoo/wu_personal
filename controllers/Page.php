<?php

class Page_Controller extends MY_Controller {

    public $data = array();

    public function index()
    {
    	header("Location: page/index");
    }
    
	public function view($arg = ''){
        $data = $this->data;

        if( empty($arg) )
        {
            $pageid_Num = $this->input->get('pageid');
            $slug_Str = $this->input->get('slug');
        }
        else if( is_numeric($arg) )
        {
            $pageid_Num = $arg;
        }
        else if( is_string($arg) )
        {
            $slug_Str = $arg;
        }

        if(!empty($slug_Str))
        {
            $data['PagerField'] = new PagerField([
                'db_where_Arr' => [
                    'pager.slug' => $slug_Str,
                    'pager.locale' => $data['global']['locale']
                ]
            ]);
        }
        else if(!empty($noteid_Num))
        {
            $data['PagerField'] = new PagerField([
                'db_where_Arr' => [
                    'pager.pageid' => $pageid_Num,
                    'pager.locale' => $data['global']['locale']
                ]
            ]);
        }
        
        $data['page_slug_Str'] = $data['PagerField']->slug_Str;

        if( !empty( $data['PagerField']->pagerid_Num ) )
        {
        	//以資料庫為內容的page
        	if(!empty($data['PagerField']->href_Str))
        	{
        		header("Location: " . base_url($data['PagerField']->href_Str) );
        	}

	        $data['ClassMeta'] = new ClassMeta([
	            'db_where_Arr' => [
	                'classid' => $data['PagerField']->class_ClassMetaList->obj_Arr[0]->classid_Num
	            ]
	        ]);

	        $data['PagerList'] = new ObjList([
	            'db_where_Arr' => [
                	'classids' => $data['ClassMeta']->classid_Num
	            ],
	            'db_orderby_Arr' => [
	                'prioritynum' => 'DESC',
	                'pagerid' => 'DESC'
	            ],
	            'model_name_Str' => 'Pager',
	            'limitstart_Num' => 0,
	            'limitcount_Num' => 100
	        ]);

	        //global
			$data['global']['style'][] = 'temp/global.css';
	        $data['global']['style'][] = 'pager/default.css';
	        
	        //temp
			$data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
			$data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
			$data['temp']['header_bar'] = $this->load->view('temp/header_bar', $data, TRUE);
			$data['temp']['footer_bar'] = $this->load->view('temp/footer_bar', $data, TRUE);
			$data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);
			
			//輸出模板
			$this->load->view('pager/default', $data);
        }
        //以FTP為內容的page
        else
        {

			//沒有這個頁面
			if ( ! file_exists('app/views/page/'.$slug_Str.'.php')){
				show_404();
			}
	        
	        //global
	    	$data['global']['js'][] = 'script_header_bar_mobile';
	    	
			$data['global']['style'][] = 'temp/global.css';
			$data['global']['style'][] = 'temp/header_bar.css';
			$data['global']['style'][] = 'temp/footer_bar.css';
	        if($slug_Str == 'index')
	        {
				$data['global']['style'][] = 'page/index.css';
	        }
	        else
	        {
			  $data['global']['style'][] = 'page/'.$slug_Str.'.css';
	        }
	        
	        //temp
			$data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
			$data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
			$data['temp']['header_bar'] = $this->load->view('temp/header_bar', $data, TRUE);
			$data['temp']['footer_bar'] = $this->load->view('temp/footer_bar', $data, TRUE);
			$data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);
			
			//輸出模板
			$this->load->view('page/'.$slug_Str, $data);
        }
	}
}

?>