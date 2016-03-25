<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3>訂單滿額優惠</h3>
    <h4>請填寫訂單優惠規則</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post") ?>
	<div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                訂單優惠規則
            </div>
            <div class="spanLineLeft width500">
                單次購物訂單金額滿
                <input type="text" name="shop_rule_use_tradein_money_Num" placeholder="消費金額" style="width: 80px;" value="<?=$tradein_SettingList->obj_Arr['shop_rule_use_tradein_money']->value_Str?>">
                元，享有
                <input type="text" name="shop_rule_get_tradein_money_Num" placeholder="減免數量" style="width: 80px;" value="<?=$tradein_SettingList->obj_Arr['shop_rule_get_tradein_money']->value_Str?>">
                <select name="shop_rule_get_tradein_money_type_Str" style="float: none; display: inline; width: 60px; min-width: 60px;">
                    <option value="money"<?if($tradein_SettingList->obj_Arr['shop_rule_get_tradein_money_type']->value_Str == 'money'):?> selected<?endif?>>元</option>
                    <option value="tradein"<?if($tradein_SettingList->obj_Arr['shop_rule_get_tradein_money_type']->value_Str == 'tradein'):?> selected<?endif?>>折</option>
                </select>
                現金減免優惠
                <br>
                單次購物訂單件數滿
                <input type="text" name="shop_rule_use_tradein_count_Num" placeholder="消費金額" style="width: 80px;" value="<?=$tradein_SettingList->obj_Arr['shop_rule_use_tradein_count']->value_Str?>">
                件，享有
                <input type="text" name="shop_rule_get_tradein_count_Num" placeholder="減免數量" style="width: 80px;" value="<?=$tradein_SettingList->obj_Arr['shop_rule_get_tradein_count']->value_Str?>">
                <select name="shop_rule_get_tradein_count_type_Str" style="float: none; display: inline; width: 60px; min-width: 60px;">
                    <option value="money"<?if($tradein_SettingList->obj_Arr['shop_rule_get_tradein_count_type']->value_Str == 'money'):?> selected<?endif?>>元</option>
                    <option value="tradein"<?if($tradein_SettingList->obj_Arr['shop_rule_get_tradein_count_type']->value_Str == 'tradein'):?> selected<?endif?>>折</option>
                </select>
                現金減免優惠
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">本項目為訂單滿多少金額享有之現金減免優惠，先計算訂單之現金滿額減免優惠，後計算訂單滿件數之減免優惠，留空則不啟用現金減免優惠</p>
                <p class="gray">例如：單次購物訂單滿1000元享有100元現金減免優惠</p>
            </div>
        </div>
	</div>
	<div class="spanLine spanSubmit">
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <input type="submit" class="submit" value="儲存設置">
            </div>
        </div>
	</div>
	</form>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>