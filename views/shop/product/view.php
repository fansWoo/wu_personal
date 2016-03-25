<?=$temp['header_up']?>
<script>
$(function(){
	var stock_json = {
		"stock": [
		<?foreach($ProductShop->stock_StockProductShopList->obj_Arr as $key => $value_StockProductShop):?>
			<?if($key !== 0):?>,<?endif?>
			{
				"stockid": <?=$value_StockProductShop->stockid_Num?>,
				"classname1": "<?=$value_StockProductShop->classname1_Str?>",
				"classname2": "<?=$value_StockProductShop->classname2_Str?>",
				"stocknum": <?=$value_StockProductShop->stocknum_Num?>
			}
		<?endforeach?>
		]
	};
	$(document).on('click', '[fanswoo-product_stock_classname1], [fanswoo-product_stock_classname2]', function(){
		if( $(this).attr('fanswoo-product_stock_classname1') )
		{
			$('[fanswoo-product_stock_classname1_select]').removeAttr('fanswoo-product_stock_classname1_select');
			$(this).attr('fanswoo-product_stock_classname1_select', true);
		}
		if( $(this).attr('fanswoo-product_stock_classname2') )
		{
			$('[fanswoo-product_stock_classname2_select]').removeAttr('fanswoo-product_stock_classname2_select');
			$(this).attr('fanswoo-product_stock_classname2_select', true);
		}
		if(
			$('[fanswoo-product_stock_classname1_select]').size() == 1 &&
			$('[fanswoo-product_stock_classname2_select]').size() == 1 
		)
		{
			for(var i = 0; i < stock_json.stock.length; i++)
			{
				if(
					stock_json.stock[i].classname1 == $('[fanswoo-product_stock_classname1_select]').attr('fanswoo-product_stock_classname1') &&
					stock_json.stock[i].classname2 == $('[fanswoo-product_stock_classname2_select]').attr('fanswoo-product_stock_classname2')
				)
				{
					$('[fanswoo-product_stockid]').attr('fanswoo-product_stockid', stock_json.stock[i].stockid);
					$('[fanswoo-product_stockid]').val(stock_json.stock[i].stockid);
					$('[fanswoo-product_stocknum]').attr('fanswoo-product_stocknum', stock_json.stock[i].stocknum);
					$('[fanswoo-product_stocknum]').text(stock_json.stock[i].stocknum);
					break;
				}
				else
				{
					$('[fanswoo-product_stockid]').attr('fanswoo-product_stockid', 0);
					$('[fanswoo-product_stockid]').val(0);
					$('[fanswoo-product_stocknum]').attr('fanswoo-product_stocknum', 0);
					$('[fanswoo-product_stocknum]').text(0);
				}
			}
		}
	});
	$("form").submit(function(event){
		if(<?if(empty($User->uid_Num)):?>1<?else:?>0<?endif?>)
		{
			event.preventDefault();
			alert('請先登入或註冊會員');
		}
		else if(
			$('[fanswoo-product_stock_classname1_select]').size() !== 1 ||
			$('[fanswoo-product_stock_classname2_select]').size() !== 1 
		)
		{	
			event.preventDefault();
			alert('請先選擇產品規格');
		}
		else if(
			$('[fanswoo-product_stocknum]').attr('fanswoo-product_stocknum') == 0
		)
		{	
			event.preventDefault();
			alert('庫存數量不足');
		}
	});
});
</script>
<?=$temp['header_down']?>
<?=$temp['header_bar']?>

<div>產品名稱：<?=$ProductShop->name_Str?></div>
<div>產品價格：<?=$ProductShop->price_Num?></div>
<div class="stock_classname1_bar">
	規格1：
	<?foreach($ProductShop->stock_classname1_Arr as $key => $value_stock_classname1_Str):?>
		<span fanswoo-product_stock_classname1="<?=$value_stock_classname1_Str?>"><?=$value_stock_classname1_Str?></span>
	<?endforeach?>
</div>
<div class="stock_classname2_bar">
	規格2：
	<?foreach($ProductShop->stock_classname2_Arr as $key => $value_stock_classname2_Str):?>
		<span fanswoo-product_stock_classname2="<?=$value_stock_classname2_Str?>"><?=$value_stock_classname2_Str?></span>
	<?endforeach?>
</div>
<div class="stock_stocknum">
	點選兩項規格後顯示庫存: <span fanswoo-product_stocknum>0</span>
</div>
<?=form_open('shop/order/add_cart')?>
	<input type="number" name="amount_Num" value="1" min="1" max="99">
	<input type="submit" name="checkoutAddProductSubmit" value="購買">
	<input type="hidden" name="stockid_Num" value="" fanswoo-product_stockid>
	<input type="hidden" name="productid_Num" value="<?=$ProductShop->productid_Num?>">
</form>

<?=$temp['footer_bar']?>
<?=$temp['body_end']?>