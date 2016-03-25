<?php
        
class Pic_Controller extends MY_Controller {

    public function upload_pic()
    {
        $upload_status_Str = $this->input->get('upload_status');
        if($upload_status_Str == 'unclassified')
        {
            $upload_status_Num = 2;
        }
        else if($upload_status_Str == 'hidden')
        {
            $upload_status_Num = 3;
        }

        $response_Arr = [];

        $picids_FilesArr = $this->input->file('picids_FilesArr');
        foreach($picids_FilesArr['name'] as $key => $value)
        {
            if(!empty($value))
            {
                $pic_PicObj = new PicObj([
                    'picfile_FileArr' => getfile_from_files([
                        'files_Arr' => $picids_FilesArr,
                        'key_Str' => $key
                    ]),
                    'upload_status_Num' => $upload_status_Num,//預設上傳待分類的圖，除非特別指定
                    'thumb_Str' => 'w50h50,w300h300,w600h600'
                ]);
                $pic_upload_Return = $pic_PicObj->upload();
                if( $pic_upload_Return === TRUE )
                {
                    $pic_Arr[] = $pic_PicObj;
                }
                else if ( $pic_upload_Return === FALSE)
                {
                    $response_Arr['status'] = 'false';
                    $response_Arr['error_message'] = '未知的錯誤';
                    echo json_encode($response_Arr);
                    return TRUE;
                }
                else
                {
                    $response_Arr['status'] = 'false';
                    $response_Arr['error_message'] = $pic_upload_Return;
                    echo json_encode($response_Arr);
                    return TRUE;
                }
            }
        }
        $response_Arr['status'] = 'true';
        $response_Arr['error_message'] = '上傳成功';
        $response_Arr['pic_Arr'] = $pic_Arr;
        echo json_encode($response_Arr);
        return TRUE;
    }
    
    public function delete_pic($do, $picid = 0)
    {
        global $admin;
        $data = $this->common_model->data;
        $child_name = 'postpic';//管理分類類別名稱
        
        if( !empty($picid) )
        {
            $PicObj = new PicObj([
                'picid_Num' => $picid
            ]);
            $PicObj->delete();
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
}

?>