<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > <?if(!empty($ClassMeta->classid_Num)):?>編輯<?else:?>新增<?endif?></h3>
    <h4>請填寫<?=$child3_title_Str?>之詳細資訊</h4>
    <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                分類名稱
            </div>
            <div class="spanLineLeft">
                <input type="text" class="text" name="classname_Str" placeholder="分類名稱" value="<?=$ClassMeta->classname_Str?>" required>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">請輸入分類標籤的名稱，此標籤名稱將作為分類名稱</p>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                分類代號
            </div>
            <div class="spanLineLeft">
                <input type="text" class="text" name="slug_Str" placeholder="分類代號" value="<?=$ClassMeta->slug_Str?>">
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">請填寫分類標籤的代號，此標籤代號將作為搜尋關鍵字</p>
                <p class="gray">本值需為英文及數字組合，不得含有中文，並且不得與其它分類標籤有重複</p>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                分類簡介
            </div>
            <div class="spanLineLeft width400">
                <textarea name="content_Str" placeholder="分類簡介"><?=$ClassMeta->content_Str?></textarea>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">請填寫200字以內的分類簡介</p>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                優先排序指數
            </div>
            <div class="spanLineLeft">
                <input type="number" class="text width100" name="prioritynum_Num" value="<?=$ClassMeta->prioritynum_Num?>">
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">優先排序值較高者，其排序較為前面</p>
            </div>
        </div>
    </div>
    <?if(!empty($ClassMeta->classid_Num)):?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                更新日期
            </div>
            <div class="spanLineLeft">
                <?=$ClassMeta->updatetime_DateTime->datetime_Str?>
            </div>
        </div>
    </div>
    <?endif?>
    <div class="spanLine spanSubmit">
        <div class="spanLineLeft">
        </div>
        <div class="spanLineRight">
            <?if(!empty($ClassMeta->classid_Num)):?><input type="hidden" name="classid_Num" value="<?=$ClassMeta->classid_Num?>"><?endif?>
            <input type="submit" class="submit" value="<?if(!empty($ClassMeta->classid_Num)):?>儲存變更<?else:?>新增標籤<?endif?>">
            <?if(!empty($ClassMeta->classid_Num)):?><span class="submit gray" onClick="fanswoo.check_href_action('確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?classid=<?=$ClassMeta->classid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除<?=$child3_title_Str?></span><?endif?>
        </div>
    </div>
    </form>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>