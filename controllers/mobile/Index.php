<?php

class Index_Controller extends MY_Controller {

    public function index()
    {
	    $data = $this->data;

		$data['global']['style'][] = 'mobile/temp/global.css';
		$data['global']['style'][] = 'mobile/temp/header_bar.css';
		$data['global']['style'][] = 'mobile/temp/footer_bar.css';
	    
	    //temp
		$data['temp']['header_up'] = $this->load->view('mobile/temp/header_up', $data, TRUE);
		$data['temp']['header_down'] = $this->load->view('mobile/temp/header_down', $data, TRUE);
		$data['temp']['header_bar'] = $this->load->view('mobile/temp/header_bar', $data, TRUE);
		$data['temp']['footer_bar'] = $this->load->view('mobile/temp/footer_bar', $data, TRUE);
		$data['temp']['body_end'] = $this->load->view('mobile/temp/body_end', $data, TRUE);
			
		//輸出模板
		$this->load->view('mobile/index', $data);
    }
}

?>