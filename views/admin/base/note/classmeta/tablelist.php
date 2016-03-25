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
                <div class="spanLineLeft text width300">
        			標籤名稱
                </div>
                <div class="spanLineLeft text">
        			標籤代號
                </div>
                <div class="spanLineLeft text width150">
                    擁有人
                </div>
                <div class="spanLineLeft text width150">
                    編輯操作
                </div>
        	</div>
            <div class="spanLine tablelist">
                <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
                    <div class="spanLineLeft text width300">
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_classname_Str)?$search_classname_Str:''?>" name="search_classname_Str" placeholder="請填寫標籤名稱">
                    </div>
                    <div class="spanLineLeft text width150">
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_slug_Str)?$search_slug_Str:''?>" name="search_slug_Str" placeholder="請填寫標籤代號">
                    </div>
                    <div class="spanLineLeft text width150">
                    <?if($UserGroup_Num==100):?>
                        會員名稱
                    <?else:?>
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_username_Str)?$search_username_Str:''?>" name="search_username_Str" placeholder="請填寫擁有人完整名稱">
                    <?endif?>
                    </div>
                    <div class="spanLineLeft text width150">
                        <input type="submit" class="button" style="height: 30px; margin-left:-6px;" value="篩選">
                    </div>
                </form>
            </div>
            <?if(!empty($class_list_ClassMetaList->obj_Arr)):?>
            <?foreach($class_list_ClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
            <div class="spanLine tablelist">
                <div class="spanLineLeft text width300">
                    <?=$value_ClassMeta->classname_Str?>
                </div>
                <div class="spanLineLeft text width150">
                    <?=$value_ClassMeta->slug_Str?>
                </div>
                <div class="spanLineLeft text width150">
                    <?=$value_ClassMeta->uid_User->username_Str?>
                </div>
                <div class="spanLineLeft width150 tablelistMenu">
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/note/tablelist/?class_slug=<?=$value_ClassMeta->slug_Str?>">查看文章</a>
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?slug=<?=$value_ClassMeta->slug_Str?>">編輯</a>
                    <span class="ahref" onClick="fanswoo.check_href_action('確定要刪除這個標籤？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?classid=<?=$value_ClassMeta->classid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除</span>
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
    <div class="pageLink"><?=$class_links?></div>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>