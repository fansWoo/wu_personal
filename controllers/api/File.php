<?php
        
class File_Controller extends MY_Controller {

    public function upload_file()
    {
        $response_Arr = [];

        $fileids_FilesArr = $this->input->file('fileids_FilesArr');
        foreach($fileids_FilesArr['name'] as $key => $value)
        {
            if(!empty($value))
            {
                $file_FileObj = new FileObj([
                    'filefile_FileArr' => getfile_from_files(array(
                        'files_Arr' => $fileids_FilesArr,
                        'key_Str' => $key
                    )),
                    // 'thumb_Str' => 'w50h50,w300h300,w600h600'
                ]);
                $file_upload_Return = $file_FileObj->upload();
                if( $file_upload_Return === TRUE )
                {
                    $file_Arr[] = $file_FileObj;
                }
                else if ( $file_upload_Return === FALSE)
                {
                    $response_Arr['status'] = 'false';
                    $response_Arr['error_message'] = '未知的錯誤';
                    echo json_encode($response_Arr);
                    return TRUE;
                }
                else
                {
                    $response_Arr['status'] = 'false';
                    $response_Arr['error_message'] = $file_upload_Return;
                    echo json_encode($response_Arr);
                    return TRUE;
                }
            }
        }
        $response_Arr['status'] = 'true';
        $response_Arr['error_message'] = '上傳成功';
        $response_Arr['file_Arr'] = $file_Arr;
        echo json_encode($response_Arr);
        return TRUE;
    }
    
    public function delete_file($do, $fileid = 0)
    {
        $data = $this->data;
        $child_name = 'postfile';//管理分類類別名稱
        
        if( !empty($fileid) )
        {
            $FileObj = new FileObj([
                'fileid_Num' => $fileid
            ]);
            $FileObj->delete();
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function download_file($fileid = 0)
    {
        $data = $this->data;
        
        if( !empty($fileid) )
        {
            $FileObj = new FileObj([
                'db_where_Arr' => [
                    'fileid' => $fileid
                ]
            ]);
            
            if( empty($FileObj->fileid_Num) )
            {
                echo '檔案不存在';
                return FALSE;
            }

            if(
                $data['User']->uid_Num == $FileObj->uid_Num ||
                in_array( $data['User']->uid_Num, $FileObj->permission_uids_UserList->uniqueids_Arr )
            )
            {

                $file_name = $FileObj->filename_Str;

                $file_path = $FileObj->file_path_Str;
                $file_size = filesize($file_path);

                header('Pragma: public');
                header('Expires: 0');
                header('Last-Modified: ' . gmdate('D, d M Y H:i ') . ' GMT');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Cache-Control: private', false);
                header('Content-Type: application/octet-stream');
                header('Content-Length: ' . $file_size);
                header('Content-Disposition: attachment; filename="' . $file_name . '";');
                header('Content-Transfer-Encoding: binary');
                readfile($file_path);

                return TRUE;

            }
            else
            {

                echo '檔案觀看權限不足';
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    
}

?>