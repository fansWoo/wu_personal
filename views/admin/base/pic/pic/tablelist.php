<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2>分類標籤管理 - 圖片列表</h2>
<div class="contentBox contentTablelist allWidth">
	<h3>圖片列表</h3>
	<h4>請填寫欲新增、編輯或刪除之圖片</h4>
	<div class="spanLine noneBg">
        <div class="spanLineLeft">
            <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit" class="button">新增<?=$child3_title_Str?></a>
        </div>
	</div>
	<div class="spanLineTable">
        <div class="spanLineTableContent">
            <div class="spanLine tablelist tableTitle">
                <div class="spanLineLeft text width100">
        			圖片ID
                </div>
                <div class="spanLineLeft text width400">
        			圖片標題
                </div>
                <div class="spanLineLeft text width150">
                    分類標籤
                </div>
                <!-- <div class="spanLineLeft text width150">
                    擁有人
                </div> -->
                <div class="spanLineLeft text width150">
                    編輯操作
                </div>
        	</div>
            <div class="spanLine tablelist">
                <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
                    <div class="spanLineLeft text width100">
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_picid_Num)?$search_picid_Num:''?>" name="search_picid_Num" placeholder="請填寫id">
                    </div>
                    <div class="spanLineLeft text width400">
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_title_Str)?$search_title_Str:''?>" name="search_title_Str" placeholder="請填寫標籤名稱">
                    </div>
                    <div class="spanLineLeft text width150">
                        <select name="search_class_slug_Str" style="margin-left:-6px;">
                            <option value="">不透過分類標籤篩選</option>
                            <!-- <option value="hidden"<?if(!empty($search_class_slug_Str) && $search_class_slug_Str == 'hidden') echo ' selected'?>>完全隱藏的圖片</option> -->
                            <option value="unclassified"<?if(!empty($search_class_slug_Str) && $search_class_slug_Str == 'unclassified') echo ' selected'?>>尚未分類的圖片</option>
                            <?foreach($pic_ClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
                            <option value="<?=$value_ClassMeta->slug_Str?>"<?if(!empty($search_class_slug_Str) && $search_class_slug_Str == $value_ClassMeta->slug_Str) echo ' selected'?>><?=$value_ClassMeta->classname_Str?></option>
                            <?endforeach?>
                        </select>
                    </div>
                    <!-- <div class="spanLineLeft text width150">
                        <?if($UserGroup_Num==100):?>
                            會員名稱
                        <?else:?>
                            <input type="text" class="text" value="<?=!empty($search_username_Str)?$search_username_Str:''?>" name="search_username_Str" placeholder="請填寫擁有人完整名稱">
                        <?endif?>
                    </div> -->
                    <div class="spanLineLeft text width150">
                        <input type="submit" class="button" style="height: 30px;" value="篩選">
                    </div>
                </form>
            </div>
            <?if(!empty($piclist_PicList->obj_Arr[0]->picid_Num)):?>
            <div class="spanLineTable">
                <div class="spanLine pic">
                <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/delete/") ?>
                    <?foreach($piclist_PicList->obj_Arr as $key => $value_Pic):?>
                        <div class="pic_block">
                            <input type="checkbox" class="pic_check" name="picid_Arr[]" value="<?=$value_Pic->picid_Num?>">
                            <div class="hover_box"><div class="p"><?=$value_Pic->title_Str?><br><?=$value_Pic->updatetime_DateTime->inputtime_date_Str?><br><a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?picid=<?=$value_Pic->picid_Num?>">編輯</a></div></div>
                            <img src="<?=$value_Pic->path_Arr[w300h300]?>" class="piclist"></img>
                        </div>
                    <?endforeach?>
                </div>
            </div>
            <?else:?>
            <div class="spanLine">
                <div class="spanLineLeft text width300">
                    這個篩選條件沒有搜尋到結果，請選擇其它篩選條件
                </div>
            </div>
            <?endif?>
        </div>
    </div>
    <?if(!empty($piclist_PicList->obj_Arr[0]->picid_Num)):?>
    <div class="batch_deletion">
        <input type="submit" class="button" style="height: 32px;" onclick="return confirm('刪除後將進入回收空間，確定要刪除嗎？')" value="刪除圖片">
        <span class="delete_prompt">可以選取單張或多張圖片刪除<span>
    </div>
    <?endif?>
    </form>
    <div class="pageLink"><?=$pic_links?></div>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>