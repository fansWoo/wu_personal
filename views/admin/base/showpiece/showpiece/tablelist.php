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
                <?if(!empty($showpiece_ShowpieceList->obj_Arr)):?>
                <div class="spanLineLeft checkbox"></div>
                <?endif?>
                <div class="spanLineLeft text width100">
        			產品ID
                </div>
                <div class="spanLineLeft text width400">
        			產品名稱
                </div>
                <div class="spanLineLeft text width150">
                    產品分類標籤
                </div>
                <div class="spanLineLeft text width100">
                    編輯操作
                </div>
        	</div>
            <div class="spanLine tablelist">
                <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
                    <?if(!empty($showpiece_ShowpieceList->obj_Arr)):?>
                    <div class="spanLineLeft checkbox">
                        <input type="checkbox" id="check_all">
                    </div>
                    <?endif?>
                    <div class="spanLineLeft text width100">
                        <input type="number" class="text" style="margin-left:-6px;" value="<?=!empty($search_showpieceid_Num)?$search_showpieceid_Num:''?>" name="search_showpieceid_Num" placeholder="請填寫ID">
                    </div>
                    <div class="spanLineLeft text width400">
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_name_Str)?$search_name_Str:''?>" name="search_name_Str" placeholder="請填寫產品名稱">
                    </div>
                    <div class="spanLineLeft text width150">
                        <select name="search_class_slug_Str" style="margin-left:-6px;">
                            <option value="">不透過分類標籤篩選</option>
                            <?foreach($class_ClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
                            <option value="<?=$value_ClassMeta->slug_Str?>"<?if(!empty($search_class_slug_Str) && $search_class_slug_Str == $value_ClassMeta->slug_Str) echo ' selected'?>><?=$value_ClassMeta->classname_Str?></option>
                            <?endforeach?>
                        </select>
                    </div>
                    <div class="spanLineLeft text width100">
                        <input type="submit" class="button filter" value="篩選">
                    </div>
                </form>
            </div>
            <?if(!empty($showpiece_ShowpieceList->obj_Arr)):?>
            <?foreach($showpiece_ShowpieceList->obj_Arr as $key => $value_Showpiece):?>
            <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/delete/") ?>
            <div class="spanLine tablelist">
                <div class="spanLineLeft checkbox">
                    <input type="checkbox" name="showpieceid_Arr[]" value="<?=$value_Showpiece->showpieceid_Num?>" class="check">
                </div>
                <div class="spanLineLeft text width100">
                    <?=$value_Showpiece->showpieceid_Num?>
                </div>
                <div class="spanLineLeft text width400">
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?showpieceid=<?=$value_Showpiece->showpieceid_Num?>"><?=$value_Showpiece->name_Str?></a>
                </div>
                <div class="spanLineLeft text width150">
                    <?if(!empty($value_Showpiece->class_ClassMetaList->obj_Arr)):?>
                    <?foreach($value_Showpiece->class_ClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
                        <?if($key !== 0):?>,<?endif?><?=$value_ClassMeta->classname_Str?>
                    <?endforeach?>
                    <?else:?>
                    <span class="gray">沒有分類標籤</span>
                    <?endif?>
                </div>
                <div class="spanLineLeft width100 tablelistMenu">
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?showpieceid=<?=$value_Showpiece->showpieceid_Num?>">編輯</a>
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
    <?if(!empty($showpiece_ShowpieceList->obj_Arr[0]->showpieceid_Num)):?>
    <div class="batch_deletion">
        <input type="submit" class="button" style="height: 32px;" onclick="return confirm('刪除後將進入回收空間，確定要刪除嗎？')" value="刪除產品">
        <span class="delete_prompt">可以選取單個或多個產品刪除<span>
    </div>
    <?endif?>
    </form>
    <div class="pageLink"><?=$showpiece_links?></div>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>