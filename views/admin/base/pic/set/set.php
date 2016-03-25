<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > 設置</h3>
    <h4>本設置可銷毀所有刪除的圖片或復原所有刪除的圖片</h4>
    <div class="spanLine spanSubmit" style="padding:0 0 10px 0;">
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_destroy_post/") ?>
        <input type="submit" class="submit" value="銷毀圖片">
    </form>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_recovery_post/") ?>
        <input type="submit" class="submit" value="復原圖片">
    </form>
    </div>
</div>
<?if(0):?>
<div class="contentBox allWidth">
    <h3>照片顯示設置</h3>
    <h4>請填寫前台相簿顯示設置，此設置之設置將影響網站前台之顯示</h4>
    <?php echo form_open('admin/note/set/post') ?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                相簿排序方式
            </div>
            <div class="spanLineLeft">
                <select name="note_order">
                    <option value="date"<?if($setting_list_array['note_order'] == 'date'):?> selected<?endif?>>依照最新發表日期</option>
                    <option value="priority"<?if($setting_list_array['note_order'] == 'priority'):?> selected<?endif?>>依照優先排序指數</option>
                </select>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">本設置為前台相簿排序之方式設定</p>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                相簿顯示數量
            </div>
            <div class="spanLineLeft width100">
                <input type="number" class="text width100" min="1" max="30" name="note_amount" value="<?if($setting_list_array['note_amount']):?><?=$setting_list_array['note_amount']?><?endif?>">
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">本設置為前台相簿每頁顯示之數量</p>
            </div>
        </div>
    </div>
    <div class="spanLine spanSubmit">
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <input type="submit" class="submit" value="儲存變更">
            </div>
        </div>
    </div>
    </form>
</div>
<?endif?>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>