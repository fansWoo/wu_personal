<?=$temp['header_up']?>
<script>
$(function(){
	$(document).on('change', 'input.big_text', function(){
		if( $.isNumeric( $('input.big_text').val() ) )
		{
			<?if(!empty($shop_rule_use_get_coupon_count_Setting->value_Str)):?>
			if( $('input.big_text').val() > <?=$shop_rule_use_get_coupon_count_Setting->value_Str?> )
			{
				$('input.big_text').val(<?=$shop_rule_use_get_coupon_count_Setting->value_Str?>);
			}
			<?endif?>
		}
		else
		{
			$('input.big_text').val(0);
		}
	});
	
	//自動執行計算運費總和(預設寄送方式)
	var price_freight_before = $(".productOther .priceFreight").text();
	var coupon_count_before = $("input.big_text").val();
	var product_amount_total = 0;
	//商品數量計算
	$(".cartList .cartLi .amount").each(function(key, value){
	    product_amount_total += parseInt($(".cartList .cartLi .amount").eq(key).text());
	});
	var base_price = <?=$OrderShop->transport_base_price_Num?>; //基底運費
	var additional_price = <?=$OrderShop->transport_additional_price_Num?>; //附加運費
    var freight_price_total = additional_price * product_amount_total; //附加運費*商品數量
	$(".productOther .priceFreight").text(base_price+freight_price_total);

	if((<?=$UserFieldShop->coupon_count_Num?>) !== 0){
	$('.productPriceTotal').text( parseInt( $('.productPriceTotal').text() ) - price_freight_before + parseInt( $(".productOther .priceFreight").text() ) + parseInt( coupon_count_before ) - parseInt( $('input.big_text').val() ) );
	}
	else{
		$('.productPriceTotal').text( parseInt( $('.productPriceTotal').text() ) - price_freight_before + parseInt( $(".productOther .priceFreight").text() ));
	}
	//Select寄送方式 運費變更
	$(document).on('change', ".productOther .sendType, input.big_text", function(){
		var price_freight_before = $(".productOther .priceFreight").text();
		var coupon_count_before = $("input.big_text").val();
		var product_amount_total = 0;
		//商品數量計算
	    $(".cartList .cartLi .amount").each(function(key, value){
	    	product_amount_total += parseInt($(".cartList .cartLi .amount").eq(key).text());
	    });
		<?foreach($transportList->obj_Arr as $key => $value_transport):?>
            if($(this).val() == '<?=$value_transport->name_Str?>'){
            	$(".productOther .base_priceFreight").text('<?=$value_transport->base_price_Num?>');
            	$(".productOther .additional_priceFreight").text('<?=$value_transport->additional_price_Num?>');
            	var base_price = <?=$value_transport->base_price_Num?>; //基底運費
            	var additional_price = <?=$value_transport->additional_price_Num?>; //附加運費
            	var freight_price_total = additional_price * product_amount_total; //附加運費*商品數量
				$(".productOther .priceFreight").text(base_price+freight_price_total); //基底運費+附加運費
			}
		<?endforeach?>
		if((<?=$UserFieldShop->coupon_count_Num?>) !== 0){
		$('.productPriceTotal').text( parseInt( $('.productPriceTotal').text() ) - price_freight_before + parseInt( $(".productOther .priceFreight").text() ) + parseInt( coupon_count_before ) - parseInt( $('input.big_text').val() ) );
		}
		else{
			$('.productPriceTotal').text( parseInt( $('.productPriceTotal').text() ) - price_freight_before + parseInt( $(".productOther .priceFreight").text() ));
		}
	});
});
</script>
<?=$temp['header_down']?>
<?=$temp['header_bar']?>
<div class="wrapContent">
	<h2 class="borderTitle">結帳中心</h2>
	<div class="checkoutBox">
    <?=form_open('order/cartlist_post')?>
		<div class="title">
			<div class="cartLi">
				<span class="name">商品名稱</span>
				<span class="price">單價</span>
				<span class="amount">數量</span>
				<span class="priceTotal">小計</span>
				<span class="delete">操作</span>
			</div>
		</div>
		<div class="cartList">
			<?if(!empty($OrderShop->cart_CartShopList->obj_Arr)):?>
			<?foreach($OrderShop->cart_CartShopList->obj_Arr as $key => $value_CartShop):?>
			<div class="cartLi">
				<span class="name"><a href="product/<?=$value_CartShop->productid_Num?>" target="_blank"><?=$value_CartShop->product_ProductShop->name_Str?> ( <?=$value_CartShop->StockProductShop->classname1_Str?> / <?=$value_CartShop->StockProductShop->classname2_Str?> )</a></span>
				<span class="price"><?=$value_CartShop->price_Num?></span>
				<span class="amount"><?=$value_CartShop->amount_Num?></span>
				<span class="priceTotal"><?=$value_CartShop->price_total_Num?></span>
				<span class="delete"><a href="order/delete_cart/?cartid=<?=$value_CartShop->cartid_Num?>" class="deleteButton" fanScript-hrefNone>刪除</a></span>
			</div>
			<?endforeach?>
			<?else:?>
			<div class="cartLi">
				<span class="name"><a href="product">請先選擇想要購買的產品</a></span>
			</div>
			<?endif?>
		</div>
		<div class="productOther">
			<?if(!empty($OrderShop->cart_CartShopList->obj_Arr)):?>
			<div class="productTotal">
				消費總金額共
				<b class="productPriceTotal"><?=$OrderShop->pay_price_total_Num?></b> 元
				<?if($OrderShop->tradein_count_Num > 0):?>
	            <br>含滿額優惠減免 NT$<?=$OrderShop->tradein_count_Num?>
	            <?endif?>
			</div>
			<?endif?>
			<select name="pay_paytype_Str" class="payType">
				<option value="atm"<?if($OrderShop->pay_paytype_Str == 'atm'):?> selected<?endif?>>ATM轉帳</option>
				<!-- <option value="card"<?if($OrderShop->pay_paytype_Str == 'card'):?> selected<?endif?>>信用卡</option> -->
				<option value="cash_on_delivery"<?if($OrderShop->pay_paytype_Str == 'cash_on_delivery'):?> selected<?endif?>>貨到付款</option>
			</select>
			<select name="transport_mode_Str" class="sendType" id="transport_mode">
                <?foreach($transportList->obj_Arr as $key => $value_transport):?>
                    <option value="<?=$value_transport->name_Str?>"<?if($OrderShop->transport_mode_Str == $value_transport->name_Str):?> selected<?endif?>><?=$value_transport->name_Str?></option>
                <?endforeach?>
            </select>
            <div class="freight">
            基底運費 <span class="base_priceFreight"><?=$OrderShop->transport_base_price_Num?></span> 元，
            每增加一個物件加 <span class="additional_priceFreight"><?=$OrderShop->transport_additional_price_Num?></span> 元，
			總共運費為 <span class="priceFreight"><?=$OrderShop->pay_price_freight_Num?></span> 元
			</div>
		</div>
		<?if($UserFieldShop->coupon_count_Num > 0 && $shop_rule_use_get_coupon_count_Setting->value_Str > 0):?>
		<div class="productOther">
			帳戶尚有 <span class="big_text"><?=$UserFieldShop->coupon_count_Num?></span> 元折扣金，本次購物使用 <input type="text" name="coupon_count_Num" class="big_text" max="<?=$shop_rule_use_get_coupon_count_Setting->value_Str?>" value="<?=$OrderShop->coupon_count_Num?>"> 元折扣金，每滿 <span class="big_text"><?=$shop_rule_use_coupon_count_Setting->value_Str?></span> 元最高可折扣 <span class="big_text"><?=$shop_rule_use_get_coupon_count_Setting->value_Str?></span> 元
		</div>
		<?else:?>
		<input class="big_text" style="display:none;" value="0">
		<?endif?>
		<div class="checkoutPost">
			<a href="product" class="button">繼續購物</a>
			<input type="submit" id="checkoutSteip1Submit" name="checkoutSteip1Submit" value="準備結帳">
		</div>
	</form>
	</div>
</div>
<?=$temp['footer_bar']?>
<?=$temp['body_end']?>