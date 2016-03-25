<?php

class Pdf_Controller extends MY_Controller {
    
	public function test()
    {
        $data = $this->data;

        $this->load->library('TcPdfDriver');
        $this->tcpdfdriver->config([
            'creator_Str' => '建立人',
            'author_Str' => '作者',
            'title_Str' => '主題',
            'subject_Str' => '副標題',
            'filename_Str' => '檔案名稱'
        ]);

        $this->tcpdfdriver->add_page();
        $html_Str = $this->load->view('pdf/test', $data, TRUE);
        $this->tcpdfdriver->write_html(['html_Str' => $html_Str]);
        $this->tcpdfdriver->last_page();

        $this->tcpdfdriver->output();
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

        $this->load->library('TcPdfDriver');
        $this->tcpdfdriver->config([
            'creator_Str' => '建立人',
            'author_Str' => '作者',
            'title_Str' => '主題',
            'subject_Str' => '副標題',
            'filename_Str' => '檔案名稱'
        ]);

        $this->tcpdfdriver->add_page();
        $this->tcpdfdriver->write_html([
            'html_Str' => $data['NoteField']->content_Html
        ]);
        $this->tcpdfdriver->last_page();

        $this->tcpdfdriver->output();
    }

}

?>