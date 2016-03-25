<?php
		
class Product_Controller extends MY_Controller {
	
	public function delete_stock()
	{
        $data = $this->data;

        $stockid_Num = $this->input->get('stockid');

        if( empty($data['User']->uid_Num) )
        {
            echo '操作權限不足';
            return FALSE;
        }
		
		if( !empty($stockid_Num) )
        {
            $StockProductShop = new StockProductShop(
                ['stockid_Num' => $stockid_Num
            ]);
            $StockProductShop->delete();
            return TRUE;
		}
        else
        {
            echo '處理失敗';
            return FALSE;
        }
	}
    
}

?>