<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > 設置</h3>
    <h4>本設置可銷毀所有刪除的產品或復原所有刪除的產品</h4>
    <div class="spanLine spanSubmit" style="padding:0 0 10px 0;">
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_destroy_post/") ?>
        <input type="submit" class="submit" value="銷毀產品">
    </form>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_recovery_post/") ?>
        <input type="submit" class="submit" value="復原產品">
    </form>
    </div>
</div>
<?if(0):?>
<div class="contentBox allWidth">
    <h3>庫存規格</h3>
    <h4>本設置關係到產品編輯之庫存規格顯示</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_smtp_post/") ?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                規格A的顯示名稱
            </div>
            <div class="spanLineLeft width100">
                <input type="text" class="text" placeholder="輸入顯示名稱" name="smtp_account" value="<?if(!empty($global['smtp_account'])):?><?=$global['smtp_account']?><?endif?>">
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <label><input type="checkbox" name="smtp_ssl_checkbox"<?if(!empty($global['smtp_ssl_checkbox']) && $global['smtp_ssl_checkbox'] == 1):?> checked<?endif?>> 這個庫存規格的類型是產品顏色，需要在產品規格處顯示RGB色碼</label>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">本設置關係到產品編輯之庫存規格A顯示名稱</p>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                規格B的顯示名稱
            </div>
            <div class="spanLineLeft width100">
                <input type="text" class="text" placeholder="輸入顯示名稱" name="smtp_account" value="<?if(!empty($global['smtp_account'])):?><?=$global['smtp_account']?><?endif?>">
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">本設置關係到產品編輯之庫存規格B顯示名稱</p>
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
<?endif?>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>