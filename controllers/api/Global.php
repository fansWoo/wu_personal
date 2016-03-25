<?php
        
class Global_Controller extends MY_Controller {


    public function get_upload_max_size()
    {
        if( strtoupper( substr( ini_get('post_max_size'), -1 ) ) == 'G' )
        {
            $Arr['post_max_size'] = (int) ini_get('post_max_size') * 1024 * 1024 * 1024;
        }
        else if( strtoupper( substr( ini_get('post_max_size'), -1 ) ) == 'M' )
        {
            $Arr['post_max_size'] = (int) ini_get('post_max_size') * 1024 * 1024;
        }
        else if( strtoupper( substr( ini_get('post_max_size'), -1 ) ) == 'K' )
        {
            $Arr['post_max_size'] = (int) ini_get('post_max_size') * 1024;
        }

        if( strtoupper( substr( ini_get('upload_max_filesize'), -1 ) ) == 'G' )
        {
            $Arr['upload_max_filesize'] = (int) ini_get('upload_max_filesize') * 1024 * 1024 * 1024;
        }
        else if( strtoupper( substr( ini_get('upload_max_filesize'), -1 ) ) == 'M' )
        {
            $Arr['upload_max_filesize'] = (int) ini_get('upload_max_filesize') * 1024 * 1024;
        }
        else if( strtoupper( substr( ini_get('upload_max_filesize'), -1 ) ) == 'K' )
        {
            $Arr['upload_max_filesize'] = (int) ini_get('upload_max_filesize') * 1024;
        }

        echo json_encode($Arr);
        return TRUE;
    }
    
}

?>