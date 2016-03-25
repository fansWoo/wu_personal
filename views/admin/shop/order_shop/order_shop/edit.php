<?=$temp['header_up']?>
<script>
$(function(){
    $(document).on('click', '[fanScript-picDelete]', function(){
        var picid = $(this).parent('[fanScript-picid]').attr('fanScript-picid');
        $.ajax({
            url: 'ajax/pic/delete_pic/picid/' + picid,
            error: function(xhr){},
            success: function(response){
                $('[fanScript-picid=' + picid + ']').remove();
                alert('刪除成功')
            }
        });
    });
    $(document).on('change', 'select', function(){
        if($(this).hasClass('red') || $(this).hasClass('green'))
        {
            var value = $(this).val();
            $(this).removeClass('red green');
            if(value == 0)
            {
                $(this).addClass('red');
            }
            else
            {
                $(this).addClass('green');
            }
        }
    });
});
</script>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2>訂單管理 - 確認訂單</h2>
<div class="contentBox allWidth">
    <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
	<h3>訂單資訊</h3>
	<h4>請確認訂單、款項、貨物及收件資訊</h4>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                訂單編號
            </div>
            <div class="spanLineLeft width500">
                <?if(!empty($OrderShop->orderid_Num)):?><?=$OrderShop->orderid_Num?><?endif?>
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                訂購會員帳號
            </div>
            <div class="spanLineLeft width500">
                <?if(!empty($OrderShop->uid_User->email_Str)):?><?=$OrderShop->uid_User->email_Str?><?endif?>
		    </div>
		</div>
	</div>
    <div style="border-top: 2px #AAA dashed;margin:30px 0;"></div>
	<h3>付款資訊</h3>
	<h4>請確認本訂單之付款資訊</h4>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                付款方式
            </div>
            <div class="spanLineLeft">
                <?if($OrderShop->pay_paytype_Str == 'atm'):?>
                ATM轉帳
                <?elseif($OrderShop->pay_paytype_Str == 'card'):?>
                信用卡
                <?elseif($OrderShop->pay_paytype_Str == 'cash_on_delivery'):?>
                貨到付款
                <?endif?>
		    </div>
		</div>
	</div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                訂單總金額
            </div>
            <div class="spanLineLeft width600">
                NT$ <?=$OrderShop->pay_price_total_Num?>
                （ 包含運費 
                NT$ <?=$OrderShop->pay_price_freight_Num?>
                <?if($OrderShop->tradein_count_Num > 0):?>
                、 滿額優惠減免 NT$<?=$OrderShop->tradein_count_Num?>
                <?endif?>
                <?if($OrderShop->coupon_count_Num > 0):?>
                、 折扣金減免 NT$<?=$OrderShop->coupon_count_Num?>
                <?endif?>
                ）
            </div>
        </div>
    </div>
    <?if($OrderShop->pay_status_Num == 1 && $OrderShop->pay_paytype_Str == 'atm'):?>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                轉帳帳號
            </div>
            <div class="spanLineLeft">
                <?=$OrderShop->pay_account_Str?>
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                轉帳人姓名
            </div>
            <div class="spanLineLeft">
                <?=$OrderShop->pay_name_Str?>
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                轉帳時間
            </div>
            <div class="spanLineLeft width500">
                <?=$OrderShop->pay_paytime_DateTimeObj->datetime_Str?>
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                付款備註
            </div>
            <div class="spanLineLeft width500">
                <?=$OrderShop->pay_remark_Str?>
		    </div>
		</div>
	</div>
    <?endif?>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                付款狀態
            </div>
            <div class="spanLineLeft width500">
                <?if($OrderShop->pay_status_Num == 0):?>
                <span class="red">會員尚未填寫付款資訊</span>
                <?elseif($OrderShop->pay_status_Num == 1):?>
                <span class="green">會員已填寫付款資訊</span>
                <?endif?>
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                款項確認狀態
            </div>
            <div class="spanLineLeft width500">
                <select name="paycheck_status_Num" class="<?if($OrderShop->paycheck_status_Num == 0):?>red<?elseif($OrderShop->paycheck_status_Num == 1):?>green<?endif?>">
                    <option value="0" class="red"<?if($OrderShop->paycheck_status_Num == 0):?> selected<?endif?>>款項待確認</option>
                    <option value="1" class="green"<?if($OrderShop->paycheck_status_Num == 1):?> selected<?endif?>>款項已確認</option>
                </select>
		    </div>
		</div>
	</div>
    <div style="border-top: 2px #AAA dashed;margin:30px 0;"></div>
    <h3>貨運資訊</h3>
    <h4>請確認本訂單之貨運資訊</h4>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                運輸方式
            </div>
            <div class="spanLineLeft width150">
                <?=$OrderShop->transport_mode_Str?>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                運輸單號
            </div>
            <div class="spanLineLeft width150">
                <input type="text" class="text" name="transport_id_Str" placeholder="請輸入運輸單號" value="<?=$OrderShop->transport_id_Str?>">
            </div>
        </div>
    </div>
    <div style="border-top: 2px #AAA dashed;margin:30px 0;"></div>
	<h3>貨物確認狀態</h3>
	<h4>請確認貨物處理狀態</h4>
    <div class="spanLineTable">
        <div class="spanLineTableContent">
            <div class="spanLine order tablelist tableTitle">
                <div class="spanLineLeft">
                    購物貨物列表
                </div>
                <div class="spanLineLeft width300">
                    貨物名稱
                </div>
                <div class="spanLineLeft width100 aligncenter">
                    單價
                </div>
                <div class="spanLineLeft width100 aligncenter">
                    數量
                </div>
                <div class="spanLineLeft width100 aligncenter">
                    小計
                </div>
            </div>
            <?foreach($OrderShop->cart_CartShopList->obj_Arr as $key => $value_CartShop):?>
            <div class="spanLine order tablelist">
                <div class="spanLineLeft">
                </div>
                <div class="spanLineLeft width300">
                    <a href="admin/shop/product/product/edit/?productid=<?=$value_CartShop->product_ProductShop->productid_Num?>" target="_blank">
                        <?=$value_CartShop->product_ProductShop->name_Str?> ( <?=$value_CartShop->StockProductShop->classname1_Str?> / <?=$value_CartShop->StockProductShop->classname2_Str?> )
                    </a>
                </div>
                <div class="spanLineLeft width100 aligncenter">
                    <?=$value_CartShop->price_Num?>
                </div>
                <div class="spanLineLeft width100 aligncenter">
                    <?=$value_CartShop->amount_Num?>
                </div>
                <div class="spanLineLeft width100 aligncenter">
                    <?=$value_CartShop->price_total_Num?>
                </div>
            </div>
            <?endforeach?>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                貨物確認狀態
            </div>
            <div class="spanLineLeft width500">
                <select name="product_status_Num" class="<?if($OrderShop->product_status_Num == 0):?>red<?elseif($OrderShop->product_status_Num == 1):?>green<?endif?>">
                    <option value="0" class="red"<?if($OrderShop->product_status_Num == 0):?> selected<?endif?>>貨物待確認</option>
                    <option value="1" class="green"<?if($OrderShop->product_status_Num == 1):?> selected<?endif?>>貨物已確認</option>
                </select>
            </div>
        </div>
    </div>
    <div style="border-top: 2px #AAA dashed;margin:30px 0;"></div>
	<h3>收件人資訊</h3>
	<h4>請確認訂單收件人資訊</h4>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                收件人姓名
            </div>
            <div class="spanLineLeft">
                <input type="text" class="text" name="receive_name_Str" placeholder="請輸入收件人姓名" value="<?if(!empty($OrderShop->receive_name_Str)):?><?=$OrderShop->receive_name_Str?><?endif?>">
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                收件人電話
            </div>
            <div class="spanLineLeft">
                <input type="text" class="text" name="receive_phone_Str" placeholder="請輸入收件人電話" value="<?if(!empty($OrderShop->receive_phone_Str)):?><?=$OrderShop->receive_phone_Str?><?endif?>">
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                收件最佳時間
            </div>
            <div class="spanLineLeft">
                <select name="receive_time_Str">
                    <option value="morning"<?if($OrderShop->receive_time_Str == 'morning'):?> selected<?endif?>>早上 8:00 ~ 12:00</option>
                    <option value="afternoon"<?if($OrderShop->receive_time_Str == 'afternoon'):?> selected<?endif?>>下午 12:00 ~ 17:00</option>
                    <option value="night"<?if($OrderShop->receive_time_Str == 'night'):?> selected<?endif?>>晚上 17:00 以後</option>
                </select>
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                收件人地址
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="receive_address_Str" placeholder="請輸入收件人地址" value="<?if(!empty($OrderShop->receive_address_Str)):?><?=$OrderShop->receive_address_Str?><?endif?>">
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                收件人備註
            </div>
            <div class="spanLineLeft width500">
                <textarea cols="80" id="receive_remark" name="receive_remark_Str" rows="10"><?if(!empty($OrderShop->receive_remark_Str)):?><?=$OrderShop->receive_remark_Str?><?endif?></textarea>
		    </div>
		</div>
	</div>
    <div style="border-top: 2px #AAA dashed;margin:30px 0;"></div>
    <h3>訂單留言</h3>
    <h4>請確認訂單留言資訊</h4>
    <div class="spanLine">
        <?if( !empty($OrderShop->comment_CommentList->obj_Arr) ):?>
        <div class="spanStage">
            <div class="spanLineLeft">
                訂單留言
            </div>
            <div class="spanLineLeft width500">
                <?foreach($OrderShop->comment_CommentList->obj_Arr as $key => $value_Comment):?>
                <p><?=$value_Comment->uid_User->username_Str?> <span class="gray"><?=$value_Comment->updatetime_DateTime->datetime_Str?></span></p>
                <div style="word-wrap:break-word;"><?=$value_Comment->content_Html?></div>
                <div style="border-top: 1px #CCC dashed;margin:10px 0;"></div>
                <?endforeach?>
            </div>
        </div>
        <?endif?>
        <div class="spanStage">
            <div class="spanLineLeft">
                <?if( empty($OrderShop->comment_CommentList->obj_Arr) ):?>
                訂單留言
                <?endif?>
            </div>
            <div class="spanLineLeft width500">
                <textarea cols="80" name="content_Str" rows="10" placeholder="請填寫新的留言..."></textarea>
            </div>
        </div>
    </div>
    <div style="border-top: 2px #AAA dashed;margin:30px 0;"></div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                下單時間
            </div>
            <div class="spanLineLeft width500">
                <?=$OrderShop->setuptime_DateTimeObj->datetime_Str?>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                最後更新時間
            </div>
            <div class="spanLineLeft width500">
                <?=$OrderShop->updatetime_DateTimeObj->datetime_Str?>
            </div>
        </div>
    </div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                貨物寄出時間
            </div>
            <div class="spanLineLeft">
                <script src="js/tool/jquery-ui-timepicker-addon/script.js"></script>
                <link rel="stylesheet" type="text/css" href="js/tool/jquery-ui-timepicker-addon/style.css"></link>
                <script>
                $(function(){
                    $('#sendtime_Str').datetimepicker({
                        dateFormat: 'yy-mm-dd',
                        timeFormat: 'HH:mm:ss'
                    });
                });
                </script>
                <input type="text" id="sendtime_Str" class="text" name="sendtime_Str" value="<?=$OrderShop->sendtime_DateTimeObj->datetime_Str?>">
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                訂單確認狀態
            </div>
            <div class="spanLineLeft width500">
                <select name="order_status_Num" class="<?if($OrderShop->order_status_Num == 0):?>red<?elseif($OrderShop->order_status_Num == 1):?>green<?endif?>">
                    <option value="0" class="red"<?if($OrderShop->order_status_Num == 0):?> selected<?endif?>>訂單未完成</option>
                    <option value="1" class="green"<?if($OrderShop->order_status_Num == 1):?> selected<?endif?>>訂單已完成，已確認貨物及付款狀態</option>
                </select>
		    </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">訂單確認狀態選項經確認送出後，便無法再修改本訂單所有資料</p>
            </div>
		</div>
	</div>
	<div class="spanLine spanSubmit">
	    <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($OrderShop->orderid_Num)):?><input type="hidden" name="orderid_Num" value="<?=$OrderShop->orderid_Num?>"><?endif?>
                <input type="submit" class="submit" value="<?if(!empty($OrderShop->orderid_Num)):?>儲存變更<?else:?>確認訂單<?endif?>">
                <?if( empty($OrderShop->orderid_Num) === FALSE ):?><span class="submit gray" onClick="fanswoo.check_href_action('刪除後將進入回收空間，確定要刪除嗎？', 'admin/shop/order_shop/order_shop/delete/?orderid=<?=$OrderShop->orderid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除訂單</span><?endif?>
            </div>
        </div>
	</div>
	</form>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>