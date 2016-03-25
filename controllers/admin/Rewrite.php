<?php

class Rewrite_Controller extends MY_Controller
{
	
	public function index()
	{
        $data = $this->data;

        $this->config->load('admin', TRUE);
        $group_purview_Arr = $this->config->item('group_purview_Arr', 'admin');
        $admin_sidebox = $this->config->item('admin_sidebox', 'admin');

        $groupid_Num = $data['User']->group_UserGroupList->obj_Arr[0]->groupid_Num;

        if($groupid_Num == 1)
        {
            $sidebox_title1_Str = key($admin_sidebox);
            $sidebox_title2_Str = key($admin_sidebox[$sidebox_title1_Str]['child2']);
            $sidebox_title3_Str = key($admin_sidebox[$sidebox_title1_Str]['child2'][$sidebox_title2_Str]['child3']);
            $sidebox_title4_Str = key($admin_sidebox[$sidebox_title1_Str]['child2'][$sidebox_title2_Str]['child3'][$sidebox_title3_Str]['child4']);

        }
        else
        {
            $sidebox_title1_Str = $group_purview_Arr[$groupid_Num][0][0];
            $sidebox_title2_Str = $group_purview_Arr[$groupid_Num][0][1];
            $sidebox_title3_Str = $group_purview_Arr[$groupid_Num][0][2];
            $sidebox_title4_Str = $group_purview_Arr[$groupid_Num][0][3];
        }

        if(!empty($sidebox_title1_Str) && !empty($sidebox_title2_Str) && !empty($sidebox_title3_Str) && !empty($sidebox_title4_Str))
        {
            $url_Str = "admin/$sidebox_title1_Str/$sidebox_title2_Str/$sidebox_title3_Str/$sidebox_title4_Str";
        }
        else
        {
            $url_Str = 'user/logout';
        }

        $this->load->model('Message');
        $this->Message->show(array(
            'message' => $data['global']['message_show']['content'],
            'url' => $url_Str,
            'second' => $data['global']['message_show']['second']
        ));
	}
	
}

?>