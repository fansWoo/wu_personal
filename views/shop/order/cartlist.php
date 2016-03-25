<?=$temp['header_up']?>
<link rel="stylesheet" type="text/css" href="js/scrollbar/jquery.mCustomScrollbar.css">
<script src="js/scrollbar/jquery.mCustomScrollbar.min.js"></script>
<script>
$(function(){

	var window_width = $(window).width();
	if(window_width < 700)
	{
		$('.checkoutBox .scrollbar').mCustomScrollbar({
			axis:"x",
			theme:"dark",
			advanced:{autoExpandHorizontalScroll:true}
		});
	}
	
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
	$(".checkoutBox .product_amount").each(function(key, value){
	    product_amount_total += parseInt($(".checkoutBox .product_amount select").eq(key).val());
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
	    $(".checkoutBox .product_amount").each(function(key, value){
		    product_amount_total += parseInt($(".checkoutBox .product_amount select").eq(key).val());
		});
		<?foreach($TransportList->obj_Arr as $key => $value_Transport):?>
            if($(this).val() == '<?=$value_Transport->name_Str?>'){
            	$(".productOther .base_priceFreight").text('<?=$value_Transport->base_price_Num?>');
            	$(".productOther .additional_priceFreight").text('<?=$value_Transport->additional_price_Num?>');
            	var base_price = <?=$value_Transport->base_price_Num?>; //基底運費
            	var additional_price = <?=$value_Transport->additional_price_Num?>; //附加運費
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
<script>
$(document).on('change', '.cartlistBox .product_amount select', function(){
    var cartid = $(this).data('cartid');
    var orderid = $(this).data('orderid');
    var amount = $(this).val();
    $.ajax({
        url: 'order/cartlist_amount_change/?cartid=' + cartid + '&amount=' + amount + '&orderid=' + orderid,
        error: function(xhr){},
        success: function(response)
        {
        	location.reload() 
        }
    });
});
</script>
<?=$temp['header_down']?>
<?=$temp['header_bar']?>
<div class="content01">
	<div class="wrapContent">
		<div class="checkoutBox">
			<h2 class="borderTitle">我的購物車</h2>
			<?=form_open('order/cartlist_post')?>
			<div class="scrollbar">
				<div class="cartlistBox">
					<table>
						<tr>
							<td></td>
							<td class="product_name">商品名稱</td>
							<td>單價</td>
							<td>數量</td>
							<td>小計</td>
							<td>刪除</td>
						</tr>
						<?if(!empty($OrderShop->cart_CartShopList->obj_Arr)):?>
						<?foreach($OrderShop->cart_CartShopList->obj_Arr as $key => $value_CartShop):?>
						<tr>
							<td class="product_img"><img src="img/product/product2.png"></td>
							<td class="product_name"><a href="product/<?=$value_CartShop->productid_Num?>" target="_blank"><?=$value_CartShop->product_ProductShop->name_Str?> ( <?=$value_CartShop->StockProductShop->classname1_Str?> / <?=$value_CartShop->StockProductShop->classname2_Str?> )</a></td>
							<td class="product_price">NT$ <?=$value_CartShop->price_Num?></td>
							<td class="product_amount">
								<select class="LiSelect" name="amount_Num" id="amount" data-cartid="<?=$value_CartShop->cartid_Num?>" data-orderid="<?=$OrderShop->orderid_Num?>" required>
								<option><?=$value_CartShop->amount_Num?></option>
								<?php
								$ProductShop = new ProductShop();
								$ProductShop->construct_db(array(
				                    'db_where_Arr' => array(
				                        'productid_Num' => $value_CartShop->productid_Num,
				                        'shelves_status_Num' => 1
				                    )
				                ));
								?>
								<?for($qty_Num=1;$qty_Num<(($ProductShop->stock_StockProductShopList->obj_Arr[0]->stocknum_Num)+1);$qty_Num++):?>
									<?if($qty_Num == $value_CartShop->amount_Num):?>
									<?else:?>
									<option><?=$qty_Num?></option>
									<?endif?>
								<?endfor?>
								</select>
							</td>
							<td class="product_price_total">NT$ <?=$value_CartShop->price_total_Num?></td>
							<td class="product_delect"><a href="order/delete_cart/?cartid=<?=$value_CartShop->cartid_Num?>" class="deleteButton" fanScript-hrefNone><img src="img/dustbin.png"></a></td>
						</tr>
						<?endforeach?>
						<?else:?>
						<tr>
							<td></td>
							<td class="product_name"><a href="product">請先選擇想要購買的產品</a></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?endif?>
					</table>
				</div>
			</div>
			<div class="productOther">
				<div class="select_box">
					<img src="img/footer/dog3.png">請選擇付款方式：
					<select name="pay_paytype_Str" class="payType">
						<option value="atm"<?if($OrderShop->pay_paytype_Str == 'atm'):?> selected<?endif?>>ATM轉帳</option>
						<option value="cash_on_delivery"<?if($OrderShop->pay_paytype_Str == 'cash_on_delivery'):?> selected<?endif?>>貨到付款</option>
					</select>
				</div>
				<div class="select_box">
					<img src="img/footer/dog3.png">請選擇運送方式：
					<select name="transport_mode_Str" class="sendType" id="transport_mode">
		                <?foreach($TransportList->obj_Arr as $key => $value_Transport):?>
		                    <option value="<?=$value_Transport->name_Str?>"<?if($OrderShop->transport_mode_Str == $value_Transport->name_Str):?> selected<?endif?>><?=$value_Transport->name_Str?></option>
		                <?endforeach?>
		            </select>
		            基本運費 <span class="base_priceFreight"><?=$OrderShop->transport_base_price_Num?></span> 元，
	            	每增加一項商品加 <span class="additional_priceFreight"><?=$OrderShop->transport_additional_price_Num?></span> 元，
					總共運費為 <span class="priceFreight"><?=$OrderShop->pay_price_freight_Num?></span> 元<br>
	            </div>
				<?if($UserFieldShop->coupon_count_Num > 0 && $shop_rule_use_get_coupon_count_Setting->value_Str > 0):?>
				<img src="img/footer/dog3.png">帳戶尚有 <span class="big_text"><?=$UserFieldShop->coupon_count_Num?></span> 元折扣金，本次購物使用 <input type="text" name="coupon_count_Num" class="big_text" max="<?=$shop_rule_use_get_coupon_count_Setting->value_Str?>" value="<?=$OrderShop->coupon_count_Num?>"> 元折扣金，每滿 <span class="big_text"><?=$shop_rule_use_coupon_count_Setting->value_Str?></span> 元最高可折扣 <span class="big_text"><?=$shop_rule_use_get_coupon_count_Setting->value_Str?></span> 元
				<?else:?>
				<input class="big_text" style="display:none;" value="0">
				<?endif?>
				<?if(!empty($OrderShop->cart_CartShopList->obj_Arr)):?>
				<div class="productTotal">
					總計
					<b class="NT">NT$ </b><b class="productPriceTotal"><?=$OrderShop->pay_price_total_Num?></b>
					<?if($OrderShop->tradein_count_Num > 0):?>
		            <br>含滿額優惠減免 NT$<?=$OrderShop->tradein_count_Num?>
		            <?endif?>
				</div>
				<?endif?>
			</div>
			<div class="checkoutPost">
				<a href="product" class="button">繼續購物</a>
				<input type="submit" id="checkoutSteip1Submit" name="checkoutSteip1Submit" value="前往結帳">
			</div>
			</form>
		</div>
	</div>
</div>
<?=$temp['footer_bar']?>
<?=$temp['body_end']?>