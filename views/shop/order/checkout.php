<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['header_bar']?>
<div class="content01">
	<div class="wrapContent">
		<div class="checkoutBox">
			<h2 class="borderTitle">付款資料確認</h2>	
			<?if($OrderShop->pay_paytype_Str === 'card'):?>
			<?=form_open('order/checkout_card_post')?>
			<?else:?>
			<?=form_open('order/checkout_post')?>
			<?endif?>
			<div class="cardTable">
				<h2 class="bigTitle"><img src="img/dog.png">付款方式</h2>
				<div class="stage">
					<div class="floatleft">付款方式</div>
					<div class="floatright">
						<?if($OrderShop->pay_paytype_Str === 'atm'):?>
						ATM轉帳
						<?elseif($OrderShop->pay_paytype_Str === 'card'):?>
						信用卡
						<?elseif($OrderShop->pay_paytype_Str === 'cash_on_delivery'):?>
						貨到付款
						<?endif?>
					</div>
					<input type="hidden" id="payType" name="payType" value="$checkout[pay][payType]">
				</div>
				<div class="stage">
					<div class="floatleft">付款總金額</div>
					<div class="floatright">
						NT$ <?=$OrderShop->pay_price_total_Num?>（含運費 NT$ <?=$OrderShop->pay_price_freight_Num?>
						<?if($OrderShop->tradein_count_Num > 0):?>
						、 滿額優惠減免 NT$<?=$OrderShop->tradein_count_Num?>
						<?endif?>
						<?if($OrderShop->coupon_count_Num > 0):?>
						、 折扣金減免 NT$<?=$OrderShop->coupon_count_Num?>
						<?endif?>
						）
						<input type="hidden" id="priceTotal" name="priceTotal" value="$checkout[price][priceTotal]">
					</div>
				</div>
				<?if($OrderShop->pay_paytype_Str === 'atm'):?>
				<h2 class="bigTitle"><img src="img/dog.png">轉帳帳號</h2>
				<div class="stage">
					<div class="floatleft">銀行代號</div>
					<div class="floatright"><?=$transfer_SettingList->obj_Arr['bank_code']->value_Str?></div>
				</div>
				<div class="stage">
					<div class="floatleft">銀行帳號</div>
					<div class="floatright"><?=$transfer_SettingList->obj_Arr['bank_account']->value_Str?></div>
				</div>
				<div class="stage">
					<div class="floatleft">銀行戶名</div>
					<div class="floatright"><?=$transfer_SettingList->obj_Arr['bank_account_name']->value_Str?></div>
				</div>
				<div class="stage">
					<div class="floatleft">備註</div>
					<div class="floatright"><?=$transfer_SettingList->obj_Arr['bank_account_remark']->value_Str?></div>
				</div>
				<?endif?>
				<h2 class="bigTitle"><img src="img/dog.png">寄件資訊</h2>
				<div class="stage">
					<div class="floatleft">寄送方式</div>
					<div class="floatright">
						<?=$OrderShop->transport_mode_Str?>
					</div>
				</div>
				<div class="stage">
					<div class="floatleft">收件人姓名</div>
					<div class="floatright"><input type="text" id="receive_name_Str" name="receive_name_Str" value="<?=$UserFieldShop->receive_name_Str?>" required></div>
				</div>
				<div class="stage">
					<div class="floatleft">寄件地址</div>
					<div class="floatright"><input type="text" id="receive_address_Str" name="receive_address_Str" value="<?=$UserFieldShop->receive_address_Str?>" required></div>
				</div>
				<div class="stage">
					<div class="floatleft">聯絡電話</div>
					<div class="floatright"><input type="text" id="receive_phone_Str" name="receive_phone_Str" value="<?=$UserFieldShop->receive_phone_Str?>" required></div>
				</div>
				<div class="stage">
					<div class="floatleft">收貨時間</div>
					<div class="floatright">
						<select id="receive_time_Str" name="receive_time_Str" required>
							<option value="morning">早上 8:00 ~ 12:00</option>
							<option value="afternoon">下午 12:00 ~ 17:00</option>
							<option value="night">晚上 17:00 以後</option>
						</select>
					</div>
				</div>
				<div class="stage" style="height:auto;">
					<div class="floatleft">備註事項</div>
					<div class="floatright">
						<textarea id="receive_remark_Str" name="receive_remark_Str"></textarea>
					</div>
				</div>
			</div>
			<div class="checkoutPost">
				<a href="order/cartlist" class="button">回上一步</a>
				<input type="hidden" id="cid" name="cid" value="$checkout[cid]">
				<input type="submit" value="送出訂單">
			</div>
			</form>
		</div>
	</div>	
</div>	
<?=$temp['footer_bar']?>
<?=$temp['body_end']?>