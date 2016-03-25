<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3>折扣金使用規則</h3>
    <h4>請填寫折扣金使用規則</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_rule_post/") ?>
	<div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                單次折扣金滿額限制
            </div>
            <div class="spanLineLeft width500">
                單次購物訂單滿 <input type="text" name="shop_rule_use_coupon_count_Num" placeholder="消費金額" style="width: 80px;" value="<?=$coupon_SettingList->obj_Arr['shop_rule_use_coupon_count']->value_Str?>"> 元，可以使用 <input type="text" name="shop_rule_use_get_coupon_count_Num" placeholder="使用金額" style="width: 80px;" value="<?=$coupon_SettingList->obj_Arr['shop_rule_use_get_coupon_count']->value_Str?>"> 元折扣金
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">本項目為滿多少錢可以啟用折扣規則及會員可以使用之多少折扣金，留空則不啟用折扣金系統</p>
                <p class="gray">例如：滿1000元才可使用折扣金100元</p>
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
<div class="contentBox allWidth">
    <h3>折扣金贈送規則</h3>
    <h4>請填寫折扣金贈送之規則</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_get_post/") ?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                首次加入會員贈送折扣金
            </div>
            <div class="spanLineLeft width500">
                <input type="text" name="shop_user_register_get_coupon_count_Num" placeholder="贈送金額" style="width: 80px;" value="<?=$coupon_SettingList->obj_Arr['shop_user_register_get_coupon_count']->value_Str?>"> 元
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">留空則不贈送折扣金</p>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                單次購物滿額贈送
            </div>
            <div class="spanLineLeft width500">
                單次購物訂單滿 <input type="text" name="shop_rule_coupon_count_Num" placeholder="消費金額" style="width: 80px;" value="<?=$coupon_SettingList->obj_Arr['shop_rule_coupon_count']->value_Str?>"> 元，可以贈送 <input type="text" name="shop_rule_get_coupon_count_Num" placeholder="贈送金額" style="width: 80px;" value="<?=$coupon_SettingList->obj_Arr['shop_rule_get_coupon_count']->value_Str?>"> 元折扣金
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">本項目為訂單滿多少金額可以贈送多少折扣金，留空則不啟用滿額贈送折扣金之規則</p>
                <p class="gray">例如：滿1000元才可使用折扣金100元</p>
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