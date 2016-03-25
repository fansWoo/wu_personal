<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > <?if(!empty($transport->transportid_Num)):?>編輯<?else:?>新增<?endif?></h3>
	<h4>請填寫<?=$child3_title_Str?>之詳細資訊</h4>
	<?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
    <div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                運輸名稱
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="name_Str" placeholder="請輸入運輸名稱" value="<?=$transport->name_Str?>" required>
		    </div>
		</div>
	</div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                運輸公司
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="company_Str" placeholder="請輸入運輸公司" value="<?=$transport->company_Str?>" required>
            </div>
        </div>
    </div>
        <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                運輸查貨網址
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="url_Str" placeholder="請輸入運輸查貨網址" value="<?=$transport->url_Str?>" required>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                基底運費金額
            </div>
            <div class="spanLineLeft">
                <input type="number" min="0" class="text" name="base_price_Num" placeholder="請輸入基底運費金額" value="<?=$transport->base_price_Num?>">
            </div>
        </div>
    </div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                加購運費金額
            </div>
            <div class="spanLineLeft">
                <input type="number" min="0" class="text" name="additional_price_Num" placeholder="請輸入加購運費金額" value="<?=$transport->additional_price_Num?>">
		    </div>
		</div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">每運輸一個物件增加的運費，範例：總運費 = 基底運費 + 物件數量 * 加購運費</p>
            </div>
        </div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                優先排序指數
            </div>
            <div class="spanLineLeft">
                <input type="number" class="text width100" name="prioritynum_Num" value="<?=$transport->prioritynum_Num?>">
            </div>
		</div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">優先排序指數越高，排序順序越前面</p>
            </div>
        </div>
	</div>
    <?if(!empty($transport->transportid_Num)):?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                更新日期
            </div>
            <div class="spanLineLeft">
                <?=$transport->updatetime_DateTime->datetime_Str?>
            </div>
        </div>
    </div>
    <?endif?>
	<div class="spanLine spanSubmit">
	    <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($transport->transportid_Num)):?><input type="hidden" name="transportid_Num" value="<?=$transport->transportid_Num?>"><?endif?>
                <input type="submit" class="submit" name="send_Bln" value="<?if(!empty($transport->transportid_Num)):?>儲存變更<?else:?>新增產品<?endif?>">
                <?if(!empty($transport->transportid_Num)):?><span class="submit gray" onClick="fanswoo.check_href_action('確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?transportid=<?=$transport->transportid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除<?=$child3_title_Str?></span><?endif?>
            </div>
        </div>
	</div>
	</form>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>