<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox contentTablelist allWidth">
	<h3><?=$child3_title_Str?> > <?=$child4_title_Str?></h3>
	<h4>請選擇欲修改之<?=$child3_title_Str?></h4>
	<div class="spanLine noneBg">
        <div class="spanLineLeft">
			<a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit" class="button">新增<?=$child3_title_Str?></a>
        </div>
	</div>
    <div class="spanLineTable">
        <div class="spanLineTableContent">
        	<div class="spanLine tablelist tableTitle">
                <?if(!empty($NoteList->obj_Arr)):?>
                <div class="spanLineLeft checkbox"></div>
                <?endif?>
                <div class="spanLineLeft text width100">
        			文章ID
                </div>
                <div class="spanLineLeft text width300">
        			文章標題
                </div>
                <div class="spanLineLeft text width150">
                    文章分類標籤
                </div>
                <div class="spanLineLeft text width150">
                    擁有人
                </div>
                <div class="spanLineLeft text width100">
                    文章發表狀態
                </div>
                <div class="spanLineLeft text width100">
                    編輯操作
                </div>
        	</div>
            <div class="spanLine tablelist">
                <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
                    <?if(!empty($NoteList->obj_Arr)):?>
                    <div class="spanLineLeft checkbox">
                        <input type="checkbox" id="check_all">
                    </div>
                    <?endif?>
                    <div class="spanLineLeft text width100">
                        <input type="number" class="text" style="margin-left:-6px;" value="<?=!empty($search_noteid_Num)?$search_noteid_Num:''?>" name="search_noteid_Num" placeholder="請填寫ID">
                    </div>
                    <div class="spanLineLeft text width300">
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_title_Str)?$search_title_Str:''?>" name="search_title_Str" placeholder="請填寫文章標題">
                    </div>
                    <div class="spanLineLeft text width150">
                        <select name="search_class_slug_Str" style="margin-left:-6px;">
                            <option value="">不透過分類標籤篩選</option>
                            <?foreach($NoteClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
                            <option value="<?=$value_ClassMeta->slug_Str?>"<?if(!empty($search_class_slug_Str) && $search_class_slug_Str == $value_ClassMeta->slug_Str) echo ' selected'?>><?=$value_ClassMeta->classname_Str?></option>
                            <?endforeach?>
                        </select>
                    </div>
                    <div class="spanLineLeft text width150">
                        <?if($UserGroup_Num==100):?>
                            會員名稱
                        <?else:?>
                            <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_username_Str)?$search_username_Str:''?>" name="search_username_Str" placeholder="請填寫擁有人完整名稱">
                        <?endif?>
                    </div>
                    <div class="spanLineLeft text width100">
                        <select name="search_shelves_status_Num" style="min-width:50px; margin-left:-6px;">
                            <option value="1"<?if(!empty($search_shelves_status_Num) && $search_shelves_status_Num == 1):?>selected<?endif?>>已發表</option>
                            <option value="2"<?if(!empty($search_shelves_status_Num) && $search_shelves_status_Num == 2):?>selected<?endif?>>未發表</option>
                        </select>
                    </div>
                    <div class="spanLineLeft text width100">
                        <input type="submit" class="button filter" value="篩選">
                    </div>
                </form>
            </div>
            <?if(!empty($NoteList->obj_Arr)):?>
            <?foreach($NoteList->obj_Arr as $key => $value_Note):?>
            <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/delete/") ?>
            <div class="spanLine tablelist">
                <div class="spanLineLeft checkbox">
                    <input type="checkbox" name="noteid_Arr[]" value="<?=$value_Note->noteid_Num?>" class="check">
                </div>
                <div class="spanLineLeft text width100">
                    <?=$value_Note->noteid_Num?>
                </div>
                <div class="spanLineLeft text width300">
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?noteid=<?=$value_Note->noteid_Num?>"><?=$value_Note->title_Str?></a>
                </div>
                <div class="spanLineLeft text width150">
                    <?if(!empty($value_Note->class_ClassMetaList->obj_Arr)):?>
                    <?foreach($value_Note->class_ClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
                        <?if($key !== 0):?>,<?endif?><?=$value_ClassMeta->classname_Str?>
                    <?endforeach?>
                    <?else:?>
                    <span class="gray">沒有分類標籤</span>
                    <?endif?>
                </div>
                <div class="spanLineLeft text width150">
                    <?=$value_Note->uid_User->username_Str?>
                </div>
                <div class="spanLineLeft text width100">
                    <?if($value_Note->shelves_status_Num ==1 ):?>
                    已發表
                    <?else:?>
                    未發表
                    <?endif?>
                </div>
                <div class="spanLineLeft width100 tablelistMenu">
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?noteid=<?=$value_Note->noteid_Num?>">編輯</a>
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
    <?if(!empty($NoteList->obj_Arr[0]->noteid_Num)):?>
    <div class="batch_deletion">
        <input type="submit" class="button" style="height: 32px;" onclick="return confirm('刪除後將進入回收空間，確定要刪除嗎？')" value="刪除文章">
        <span class="delete_prompt">可以選取單篇或多篇文章刪除<span>
    </div>
    <?endif?>
    </form>
    <div class="pageLink"><?=$page_link?></div>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>