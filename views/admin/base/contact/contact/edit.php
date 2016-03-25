<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > <?if(!empty($Contact->contactid_Num)):?>編輯<?else:?>新增<?endif?></h3>
	<h4>請填寫<?=$child3_title_Str?>之詳細資訊</h4>
	<?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                聯繫人名稱
            </div>
            <div class="spanLineLeft width500">
                <?=$Contact->username_Str?>
		    </div>
		</div>
	</div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                電子郵件
            </div>
            <div class="spanLineLeft width500">
                <?=$Contact->email_Str?>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                聯繫電話
            </div>
            <div class="spanLineLeft width500">
                <?=$Contact->phone_Str?>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                詢問類別
            </div>
            <div class="spanLineLeft width500">
                <?=$Contact->classtype_Str?>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                聯繫內容
            </div>
            <div class="spanLineLeft width500">
                <?=$Contact->content_Str?>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                聯繫狀態
            </div>
            <div class="spanLineLeft width500">
                <select name="status_process_Num">
                    <option value="1"<?if($Contact->status_process_Num == 1):?> selected<?endif?>>未處理</option>
                    <option value="2"<?if($Contact->status_process_Num == 2):?> selected<?endif?>>已處理</option>
                </select>
            </div>
        </div>
    </div>
    <?if(!empty($Contact->contactid_Num)):?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                聯繫日期
            </div>
            <div class="spanLineLeft">
                <?=$Contact->updatetime_DateTime->datetime_Str?>
            </div>
        </div>
    </div>
    <?endif?>
	<div class="spanLine spanSubmit">
	    <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($Contact->contactid_Num)):?><input type="hidden" name="contactid_Num" value="<?=$Contact->contactid_Num?>"><?endif?>
                <input type="submit" class="submit" value="<?if(!empty($Contact->contactid_Num)):?>儲存變更<?else:?>新增產品<?endif?>">
                <?if(!empty($Contact->contactid_Num)):?><span class="submit gray" onClick="fanswoo.check_href_action('刪除後將進入回收空間，確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?contactid=<?=$Contact->contactid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除<?=$child3_title_Str?></span><?endif?>
            </div>
        </div>
	</div>
	</form>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>