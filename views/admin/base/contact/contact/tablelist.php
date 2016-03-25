<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox contentTablelist allWidth">
	<h3><?=$child3_title_Str?> > <?=$child4_title_Str?></h3>
	<h4>請選擇欲修改之<?=$child3_title_Str?></h4>
	<div class="spanLineTable">
        <div class="spanLineTableContent">
            <div class="spanLine tablelist tableTitle">
                <?if(!empty($ContactList->obj_Arr)):?>
                <div class="spanLineLeft checkbox"></div>
                <?endif?>
                <div class="spanLineLeft text width100">
        			聯繫單ID
                </div>
                <div class="spanLineLeft text width200">
        			聯絡人姓名
                </div>
                <div class="spanLineLeft text width150">
                    處理狀態
                </div>
                <div class="spanLineLeft text width150">
                    聯繫日期
                </div>
                <div class="spanLineLeft text width100">
                    編輯操作
                </div>
        	</div>
            <div class="spanLine tablelist">
                <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
                    <?if(!empty($ContactList->obj_Arr)):?>
                    <div class="spanLineLeft checkbox">
                        <input type="checkbox" id="check_all">
                    </div>
                    <?endif?>
                    <div class="spanLineLeft text width100">
                        <input type="number" class="text" style="margin-left:-6px;" value="<?=!empty($search_contactid_Num)?$search_contactid_Num:''?>" name="search_contactid_Num" placeholder="請填寫ID">
                    </div>
                    <div class="spanLineLeft text width200">
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_username_Str)?$search_username_Str:''?>" name="search_username_Str" placeholder="請填寫姓名">
                    </div>
                    <div class="spanLineLeft text width150" style="margin-left:-6px;">
                        <select name="search_status_process_Num">
                            <option value="">不篩選</option>
                            <option value="1"<?if($search_status_process_Num == 1):?> selected<?endif?>>未處理</option>
                            <option value="2"<?if($search_status_process_Num == 2):?> selected<?endif?>>已處理</option>
                        </select>
                    </div>
                    <div class="spanLineLeft text width150" style="margin-left:6px;">
                        聯繫日期
                    </div>
                    <div class="spanLineLeft text width100">
                        <input type="submit" class="button filter" value="篩選">
                    </div>
                </form>
            </div>
            <?if(!empty($ContactList->obj_Arr)):?>
            <?foreach($ContactList->obj_Arr as $key => $value_Contact):?>
            <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/delete/") ?>
            <div class="spanLine tablelist">
                <div class="spanLineLeft checkbox">
                    <input type="checkbox" name="contactid_Arr[]" value="<?=$value_Contact->contactid_Num?>" class="check">
                </div>
                <div class="spanLineLeft text width100">
                    <?=$value_Contact->contactid_Num?>
                </div>
                <div class="spanLineLeft text width200">
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?contactid=<?=$value_Contact->contactid_Num?>"><?=$value_Contact->username_Str?></a>
                </div>
                <div class="spanLineLeft text width150">
                    <?if($value_Contact->status_process_Num == 1):?>
                    未處理
                    <?elseif($value_Contact->status_process_Num == 2):?>
                    已處理
                    <?endif?>
                </div>
                <div class="spanLineLeft text width150">
                    <?=$value_Contact->updatetime_DateTime->datetime_Str?>
                </div>
                <div class="spanLineLeft width100 tablelistMenu">
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?contactid=<?=$value_Contact->contactid_Num?>">編輯</a>
                </div>
        	</div>
            <?endforeach?>
            <?else:?>
            <div class="spanLine">
                <div class="spanLineLeft text width500">
                    這個篩選條件沒有搜尋到結果，請選擇其它篩選條件
                </div>
            </div>
            <?endif?>
        </div>
    </div>
    <?if(!empty($ContactList->obj_Arr[0]->contactid_Num)):?>
    <div class="batch_deletion">
        <input type="submit" class="button" style="height: 32px;" onclick="return confirm('刪除後將進入回收空間，確定要刪除嗎？')" value="刪除聯繫單">
        <span class="delete_prompt">可以選取單個或多個聯繫單刪除<span>
    </div>
    <?endif?>
    </form>
    <div class="pageLink"><?=$$contact_links?></div>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>