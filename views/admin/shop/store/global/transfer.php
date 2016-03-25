<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3>轉帳帳號管理</h3>
    <h4>請填寫轉帳帳號資訊，將顯示於使用者結帳畫面</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
	<div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                銀行代號
            </div>
            <div class="spanLineLeft width300">
                <input type="text" class="text" name="bank_code_Str" placeholder="請填寫銀行代號" value="<?=$transfer_SettingList->obj_Arr['bank_code']->value_Str?>" required>
            </div>
        </div>
	</div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                銀行帳號
            </div>
            <div class="spanLineLeft width300">
                <input type="text" class="text" name="bank_account_Str" placeholder="請填寫銀行帳號" value="<?=$transfer_SettingList->obj_Arr['bank_account']->value_Str?>" required>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                銀行戶名
            </div>
            <div class="spanLineLeft width300">
                <input type="text" class="text" name="bank_account_name_Str" placeholder="請填寫銀行戶名" value="<?=$transfer_SettingList->obj_Arr['bank_account_name']->value_Str?>" required>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                備註
            </div>
            <div class="spanLineLeft width300">
                <textarea name="bank_account_remark_Str" placeholder="請填寫備註"><?=$transfer_SettingList->obj_Arr['bank_account_remark']->value_Str?></textarea>
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