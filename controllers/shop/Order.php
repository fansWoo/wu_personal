<?php

class Order_Controller extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $data = $this->data;

        if($data['User']->uid_Num == '')
        {
            $url = base_url('user/login/?url=order');
            header('Location: '.$url);
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
    }
	
	public function index()
	{
        $url_Str = base_url('order/cartlist');
        header("Location: $url_Str");
	}

    public function cartlist()
    {
        $data = $this->data;

        //讀取建構中的訂單
        $data['OrderShop'] = new OrderShop([
            'db_where_Arr' => array(
                'uid_Num' => $data['User']->uid_Num,
                'order_status_Num' => -1//建構中的訂單
            )
        ]);

        $data['transportList'] = new ObjList([
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'Transport',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);

        //如果沒有建構中的訂單則建立一個新的訂單
        if(empty($data['OrderShop']->orderid_Num))
        {
            $data['OrderShop'] = new OrderShop([
                'uid_Num' => $data['User']->uid_Num,
                'transport_mode_Str' => $data['transportList']->obj_Arr[0]->name_Str,
                'transport_base_price_Num' => $data['transportList']->obj_Arr[0]->base_price_Num,
                'transport_additional_price_Num' => $data['transportList']->obj_Arr[0]->additional_price_Num,
                'pay_paytype_Str' => 'atm',
                'order_status_Num' => -1//建構中的訂單
            ]);
            $data['OrderShop']->update();
        }

        $data['UserFieldShop'] = new UserFieldShop([
            'db_where_Arr' => array(
                'user.uid' => $data['User']->uid_Num
            )
        ]);

        $data['shop_rule_use_coupon_count_Setting'] = new Setting([
            'db_where_Arr' => [
                'keyword' => 'shop_rule_use_coupon_count'
            ]
        ]);

        $data['shop_rule_use_get_coupon_count_Setting'] = new Setting([
            'db_where_Arr' => [
                'keyword' => 'shop_rule_use_get_coupon_count'
            ]
        ]);
        
        //global
        $data['global']['style'][] = 'temp/global.css';
        $data['global']['style'][] = 'shop/order.css';
        
        //temp
        $data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
        $data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
        $data['temp']['header_bar'] = $this->load->view('temp/header_bar', $data, TRUE);
        $data['temp']['footer_bar'] = $this->load->view('temp/footer_bar', $data, TRUE);
        $data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);
        
        //輸出模板
        $this->load->view('shop/order/cartlist', $data);
    }

    public function cartlist_post()
    {
        $data = $this->data;

        $pay_paytype_Str = $this->input->post('pay_paytype_Str', TRUE);
        $coupon_count_Num = $this->input->post('coupon_count_Num', TRUE);
        $transport_mode_Str = $this->input->post('transport_mode_Str', TRUE);
        
        $Transport = new Transport();
        $Transport->construct_db(array(
            'db_where_Arr' => array(
                'name_Str' => $transport_mode_Str
            )
        ));

        //讀取建構中的訂單
        $OrderShop = new OrderShop([
            'db_where_Arr' => array(
                'uid_Num' => $data['User']->uid_Num,
                'order_status_Num' => -1//建構中的訂單
            )
        ]);

        foreach ($OrderShop->cart_CartShopList->obj_Arr as $key => $value_cart)
        {
            $total_cart_amount += $value_cart->amount_Num;
        }
        $pay_price_freight_Num = $Transport->base_price_Num + $Transport->additional_price_Num * $total_cart_amount;

        if(empty($OrderShop->cart_CartShopList->obj_Arr))
        {
            $message_Str = '請先選擇想要購買的產品';
            $url_Str = 'order/cartlist';
            $this->load->model('Message');
            $this->Message->show(array('message' => $message_Str, 'url' => $url_Str));
            return FALSE;
        }

        $OrderShop->pay_paytype_Str = $pay_paytype_Str;
        $OrderShop->transport_mode_Str = $transport_mode_Str;
        $OrderShop->transport_base_price_Num = $Transport->base_price_Num;
        $OrderShop->transport_additional_price_Num = $Transport->additional_price_Num;
        $OrderShop->change_freight(array(
            'pay_price_freight_Num' => $pay_price_freight_Num
        ));
        $coupon_count_status = $OrderShop->change_coupon_count(['coupon_count_Num' => $coupon_count_Num]);
        if( $coupon_count_status === TRUE )
        {
            $OrderShop->update();
            $url_Str = base_url('order/checkout');
            header("Location: $url_Str");
        }
        else
        {
            $message_Str = $coupon_count_status;
            $url_Str = 'order/cartlist';
            $this->load->model('Message');
            $this->Message->show(array('message' => $message_Str, 'url' => $url_Str));
            return TRUE;
        }
    }

    public function checkout()
    {
        $data = $this->data;

        $data['UserFieldShop'] = new UserFieldShop([
            'db_where_Arr' => array(
                'user.uid' => $data['User']->uid_Num
            )
        ]);

        $data['transfer_SettingList'] = new SettingList([
            'db_where_Arr' => [
                'modelname' => 'shop_transfer'
            ]
        ]);

        //讀取建構中的訂單
        $data['OrderShop'] = new OrderShop([
            'db_where_Arr' => array(
                'uid_Num' => $data['User']->uid_Num,
                'order_status_Num' => -1//建構中的訂單
            )
        ]);
        //如果沒有建構中的訂單則建立一個新的訂單
        if(empty($data['OrderShop']->orderid_Num))
        {
            $url_Str = base_url('order/cartlist');
            header("Location: $url_Str");
        }
        
        //global
        $data['global']['style'][] = 'temp/global.css';
        $data['global']['style'][] = 'shop/order.css';
        
        //temp
        $data['temp']['header_up'] = $this->load->view('temp/header_up', $data, TRUE);
        $data['temp']['header_down'] = $this->load->view('temp/header_down', $data, TRUE);
        $data['temp']['header_bar'] = $this->load->view('temp/header_bar', $data, TRUE);
        $data['temp']['footer_bar'] = $this->load->view('temp/footer_bar', $data, TRUE);
        $data['temp']['body_end'] = $this->load->view('temp/body_end', $data, TRUE);
        
        //輸出模板
        $this->load->view('shop/order/checkout', $data);
    }

    public function checkout_post()
    {
        $data = $this->data;

        $this->form_validation->set_rules('receive_name_Str', '收件人姓名', 'required');
        $this->form_validation->set_rules('receive_address_Str', '收件人地址', 'required');
        $this->form_validation->set_rules('receive_phone_Str', '收件人電話', 'required');

        if ($this->form_validation->run() !== FALSE)
        {
            $receive_name_Str = $this->input->post('receive_name_Str', TRUE);
            $receive_address_Str = $this->input->post('receive_address_Str', TRUE);
            $receive_phone_Str = $this->input->post('receive_phone_Str', TRUE);
            $receive_time_Str = $this->input->post('receive_time_Str', TRUE);
            $receive_remark_Str = $this->input->post('receive_remark_Str', TRUE);

            //讀取建構中的訂單
            $OrderShop = new OrderShop([
                'db_where_Arr' => array(
                    'uid_Num' => $data['User']->uid_Num,
                    'order_status_Num' => -1//建構中的訂單
                )
            ]);
            if($OrderShop->pay_paytype_Str === 'card')
            {
                $OrderShop->pay_status_Num = 1;
                $OrderShop->paycheck_status_Num = 1;
            }
            else if($OrderShop->pay_paytype_Str === 'cash_on_delivery')
            {
                $OrderShop->pay_status_Num = 1;
            }
            $OrderShop->receive_name_Str = $receive_name_Str;
            $OrderShop->receive_address_Str = $receive_address_Str;
            $OrderShop->receive_phone_Str = $receive_phone_Str;
            $OrderShop->receive_time_Str = $receive_time_Str;
            $OrderShop->receive_remark_Str = $receive_remark_Str;

            //將訂單從建構中改為已建立
            $finish_order_Return = $OrderShop->finish_order();
            if( $finish_order_Return === TRUE )
            {
                //寄出訂單新增通知給管理員
                $smtp_email_Setting = new Setting([
                    'db_where_Arr' => [
                        'keyword_Str' => 'smtp_email'
                    ]
                ]);

                $smtp_username_Setting = new Setting([
                    'db_where_Arr' => [
                        'keyword_Str' => 'smtp_username'
                    ]
                ]);

                $email_Str = $smtp_email_Setting->value_Str;
                $email_name_Str = $smtp_username_Setting->value_Str;
                $title_Str = '訂單成交通知';

                $message_Str = '您好：<br><br>我們已經收到一則訂單資訊！<br><br>'.
                '購買人：'.$data['User']->email_Str.'<br>'.
                '購買的產品如下：<br><br>';

                foreach($OrderShop->cart_CartShopList->obj_Arr as $key => $value_CartShop)
                {
                    $message_Str .= 
                    $value_CartShop->product_ProductShop->name_Str.' ( '.
                    $value_CartShop->StockProductShop->classname1_Str.' / '.
                    $value_CartShop->StockProductShop->classname2_Str.' ) '.
                    '單價'.$value_CartShop->price_Num.'元 * '.
                    $value_CartShop->amount_Num.' 總價共 '.
                    $value_CartShop->price_total_Num.'元<br>';
                }

                $message_Str .= '<br><br>運費總金額：'.
                $OrderShop->pay_price_freight_Num.'元<br>'.
                '購物總金額（含運費）：'.
                $OrderShop->pay_price_total_Num.'元<br><br>'.
                '訂購時間：'.date('Y-m-d H:i:s');

                $Mailer = new Mailer;
                $return_message_Str = $Mailer->sendmail($email_Str, $email_name_Str, $title_Str, $message_Str);
                if($return_message_Str === TRUE)
                {
                    //寄件成功
                }
                else
                {
                    //送出訊息
                    $this->load->model('Message');
                    $this->Message->show(array(
                        'message' => 'error(4)：郵件伺服器出錯',
                        'url' => 'order/cartlist'
                    ));
                    return FALSE;
                }

                //寄出下單通知給買家
                $email_Str = $data['User']->email_Str;
                $email_name_Str = $data['User']->email_Str;
                $title_Str = '訂單成交通知';

                $message_Str = '您好：<br><br>我們收到您的訂單資訊！<br><br>'.
                '購買人：'.$data['User']->email_Str.'<br>'.
                '購買的產品如下：<br><br>';


                foreach($OrderShop->cart_CartShopList->obj_Arr as $key => $value_CartShop)
                {
                    $message_Str .= 
                    $value_CartShop->product_ProductShop->name_Str.' ( '.
                    $value_CartShop->StockProductShop->classname1_Str.' / '.
                    $value_CartShop->StockProductShop->classname2_Str.' ) '.
                    '單價'.$value_CartShop->price_Num.'元 * '.
                    $value_CartShop->amount_Num.' 總價共 '.
                    $value_CartShop->price_total_Num.'元<br>';
                }

                $message_Str .= '<br><br>運費總金額：'.
                $OrderShop->pay_price_freight_Num.'元<br>'.
                '購物總金額（含運費）：'.
                $OrderShop->pay_price_total_Num.'元<br><br>'.
                '訂購時間：'.date('Y-m-d H:i:s');

                $Mailer = new Mailer;
                $return_message_Str = $Mailer->sendmail($email_Str, $email_name_Str, $title_Str, $message_Str);
                if($return_message_Str === TRUE)
                {
                    //寄件成功
                }
                else
                {
                    //送出訊息
                    $this->load->model('Message');
                    $this->Message->show(array(
                        'message' => 'error(4)：郵件伺服器出錯',
                        'url' => 'order/cartlist'
                    ));
                    return FALSE;
                }

                $message_Str = '訂單完成';
                $url_Str = 'admin/user/order_shop/order_shop/tablelist';
                $this->load->model('Message');
                $this->Message->show(array('message' => $message_Str, 'url' => $url_Str));
                return TRUE;
            }
            else
            {
                $message_Str = $finish_order_Return;
                $url_Str = 'order/cartlist';
                $this->load->model('Message');
                $this->Message->show(array('message' => $message_Str, 'url' => $url_Str, 'second' => 7));
                return TRUE;
            }
        }
        else
        {
            $message_Str = '請填寫詳細收件人資料';
            $url_Str = 'order/checkout';
            $this->load->model('Message');
            $this->Message->show(array('message' => $message_Str, 'url' => $url_Str));
        }
    }

    public function checkout_card_post()
    {
        $data = $this->data;

        $this->form_validation->set_rules('receive_name_Str', '收件人姓名', 'required');
        $this->form_validation->set_rules('receive_address_Str', '收件人地址', 'required');
        $this->form_validation->set_rules('receive_phone_Str', '收件人電話', 'required');

        if ($this->form_validation->run() !== FALSE)
        {
            $receive_name_Str = $this->input->post('receive_name_Str', TRUE);
            $receive_address_Str = $this->input->post('receive_address_Str', TRUE);
            $receive_phone_Str = $this->input->post('receive_phone_Str', TRUE);
            $receive_time_Str = $this->input->post('receive_time_Str', TRUE);
            $receive_remark_Str = $this->input->post('receive_remark_Str', TRUE);

            //讀取建構中的訂單
            $OrderShop = new OrderShop([
                'db_where_Arr' => array(
                    'uid_Num' => $data['User']->uid_Num,
                    'order_status_Num' => -1//建構中的訂單
                )
            ]);
            if(
                $OrderShop->pay_paytype_Str === 'card' ||
                $OrderShop->pay_paytype_Str === 'cash_on_delivery')
            {
                $OrderShop->pay_status_Num = 1;
                $OrderShop->paycheck_status_Num = 1;
            }
            $OrderShop->receive_name_Str = $receive_name_Str;
            $OrderShop->receive_address_Str = $receive_address_Str;
            $OrderShop->receive_phone_Str = $receive_phone_Str;
            $OrderShop->receive_time_Str = $receive_time_Str;
            $OrderShop->receive_remark_Str = $receive_remark_Str;
            $OrderShop->update(array());

            //金流開始
            include_once(APPPATH.'libraries/auth_mpi/auth_mpi_mac.php');

            $purchAmt = (int) $OrderShop->pay_price_total_Num;
            $cid = (int) $OrderShop->orderid_Num;
            // $data['AuthResURL'] = "http://localhost/ipix/order/checkout_card_response_post/";
            $data['AuthResURL'] = 'http://'.$_SERVER['HTTP_HOST'].base_url("order/checkout_card_response_post/");
            $MerchantName = '大田映像有限公司';
            $MerchantID = '8220276806380';
            $TerminalID = '90008132';
            $txType = '0';
            $Option = '1';
            $OrderDetail = '大田映像有限公司';
            $AutoCap = '1';
            $customize = '1';
            $Key = 'asxPcbeXE7o9qn2dlH0hC8ti';
            $debug = '0';
        
            $data['merID'] = '3001';
            $data['MACString'] = auth_in_mac($MerchantID,$TerminalID,$cid,$purchAmt,$txType,$Option,$Key,$MerchantName,$data['AuthResURL'],$OrderDetail,$AutoCap,$customize,$debug);
        
            $data['URLEnc'] = get_auth_urlenc($MerchantID,$TerminalID,$cid,$purchAmt,$txType,$Option,$Key,$MerchantName,$data['AuthResURL'],$OrderDetail,$AutoCap,$customize,$data['MACString'],$debug);
        
            //輸出模板
            $this->load->view('shop/order/checkout_card', $data);
        }
        else
        {
            $message_Str = '請填寫詳細收件人資料';
            $url_Str = 'order/checkout';
            $this->load->model('Message');
            $this->Message->show(array('message' => $message_Str, 'url' => $url_Str));
        }
    }

    public function checkout_card_response_post()
    {
        $data = $this->data;
        // error_reporting();
        
        //接收金流回傳值
        include_once(APPPATH.'libraries/auth_mpi/auth_mpi_mac.php');
        $EncRes = $this->input->post('URLResEnc');
        $Key = "asxPcbeXE7o9qn2dlH0hC8ti";
        $debug = "0";
        $EncArray=gendecrypt($EncRes,$Key,$debug);
        foreach($EncArray AS $name => $val){
            // echo $name ."=>". urlencode(trim($val,"\x00..\x08")) ."\n";
        }
        $status = isset($EncArray['status']) ? $EncArray['status'] : "";
        $errCode = isset($EncArray['errcode']) ? $EncArray['errcode'] : "";
        $authCode = isset($EncArray['authcode']) ? $EncArray['authcode'] : "";
        $authAmt = isset($EncArray['authamt']) ? $EncArray['authamt'] : "";
        $lidm = isset($EncArray['lidm']) ? $EncArray['lidm'] : "";
        $OffsetAmt = isset($EncArray['offsetamt']) ? $EncArray['offsetamt'] : "";
        $OriginalAmt = isset($EncArray['originalamt']) ? $EncArray['originalamt'] : "";
        $UtilizedPoint = isset($EncArray['utilizedpoint']) ? $EncArray['utilizedpoint'] : "";
        $Option = isset($EncArray['numberofpay']) ? $EncArray['numberofpay'] : "";
        //紅利交易時請帶入prodcode
        //$Option = isset($EncArray['prodcode']) ? $EncArray['prodcode'] : "";
        $Last4digitPAN = isset($EncArray['last4digitpan']) ? $EncArray['last4digitpan'] : "";
        $CardNumber = isset($EncArray['CardNumber']) ? $EncArray['CardNumber'] : "";
        $MACString = auth_out_mac($status,$errCode,$authCode,$authAmt,$lidm,$OffsetAmt,$OriginalAmt,$UtilizedPoint,$Option, $Last4digitPAN,$Key,$debug);
        
        //交易成功或失敗
        if($MACString === $EncArray['outmac'])
        {
            //讀取建構中的訂單
            $OrderShop = new OrderShop([
                'db_where_Arr' => array(
                    'uid_Num' => $data['User']->uid_Num,
                    'order_status_Num' => -1//建構中的訂單
                )
            ]);
            $OrderShop->pay_status_Num = 1;
            $OrderShop->paycheck_status_Num = 1;
            $OrderShop->order_status_Num = 0;//將訂單從建構中改為已建立
            $OrderShop->update();

            $message_Str = '交易成功';
            $url_Str = 'shop';
            $this->load->model('Message');
            $this->Message->show(array('message' => $message_Str, 'url' => $url_Str));
        }
        else
        {
            $message_Str = '信用卡交易失敗';
            $url_Str = 'order/cartlist';
            $this->load->model('Message');
            $this->Message->show(array('message' => $message_Str, 'url' => $url_Str));
        }
    }

    public function delete_cart()
    {
        $data = $this->data;

        $cartid_Num = $this->input->get('cartid');

        //讀取建構中的訂單
        $OrderShop = new OrderShop([
            'db_where_Arr' => array(
                'uid_Num' => $data['User']->uid_Num,
                'order_status_Num' => -1//建構中的訂單
            )
        ]);
        $OrderShop->delete_cart(array(
            'cartid_Num' => $cartid_Num
        ));

        $OrderShop->update(array());

        $url_Str = base_url('order/cartlist');
        header("Location: $url_Str");
    }

    public function add_cart()
    {
        $data = $this->data;

        $productid_Num = $this->input->post('productid_Num', TRUE);
        $stockid_Num = $this->input->post('stockid_Num', TRUE);
        $amount_Num = $this->input->post('amount_Num', TRUE);

        if( empty($productid_Num) || empty($stockid_Num) || empty($amount_Num) )
        {
            $message_Str = '產品訊息傳遞錯誤';
            $url_Str = 'order/cartlist';
            $this->load->model('Message');
            $this->Message->show(array('message' => $message_Str, 'url' => $url_Str));
        }

        //讀取建構中的訂單
        $OrderShop = new OrderShop([
            'db_where_Arr' => array(
                'uid_Num' => $data['User']->uid_Num,
                'order_status_Num' => -1//建構中的訂單
            )
        ]);

        $data['transportList'] = new ObjList([
            'db_where_deletenull_Bln' => TRUE,
            'model_name_Str' => 'Transport',
            'limitstart_Num' => 0,
            'limitcount_Num' => 100
        ]);

        //如果沒有建構中的訂單則建立一個新的訂單
        if(empty($OrderShop->orderid_Num))
        {
            $OrderShop = new OrderShop([
                'uid_Num' => $data['User']->uid_Num,
                'transport_mode_Str' => $data['transportList']->obj_Arr[0]->name_Str,
                'transport_base_price_Num' => $data['transportList']->obj_Arr[0]->base_price_Num,
                'transport_additional_price_Num' => $data['transportList']->obj_Arr[0]->additional_price_Num,
                'pay_paytype_Str' => 'atm',
                'order_status_Num' => -1//建構中的訂單
            ]);
            $OrderShop->update();
        }

        $OrderShop->add_cart([
            'productid_Num' => $productid_Num,
            'stockid_Num' => $stockid_Num,
            'amount_Num' => $amount_Num
        ]);

        $OrderShop->update();

        $url_Str = base_url('order/cartlist');
        header("Location: $url_Str");
    }
	
}

?>