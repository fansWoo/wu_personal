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
                <?if(!empty($user_UserList->obj_Arr)):?>
                <div class="spanLineLeft checkbox"></div>
                <?endif?>
                <div class="spanLineLeft text width100">
        			會員ID
                </div>
                <div class="spanLineLeft text width200">
        			會員名稱
                </div>
                <div class="spanLineLeft text width300">
                    電子郵件帳號
                </div>
                <div class="spanLineLeft text width150">
                    會員群組
                </div>
                <div class="spanLineLeft text width100">
                    編輯操作
                </div>
        	</div>
            <div class="spanLine tablelist">
                <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
                    <?if(!empty($user_UserList->obj_Arr)):?>
                    <div class="spanLineLeft checkbox">
                        <input type="checkbox" id="check_all">
                    </div>
                    <?endif?>
                    <div class="spanLineLeft text width100">
                        <input type="number" class="text" style="margin-left:-6px;" min="0" value="<?=!empty($search_uid_Num)?$search_uid_Num:''?>" name="search_uid_Num" placeholder="請填寫ID">
                    </div>
                    <div class="spanLineLeft text width200">
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_username_Str)?$search_username_Str:''?>" name="search_username_Str" placeholder="請填寫會員名稱">
                    </div>
                    <div class="spanLineLeft text width300">
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_email_Str)?$search_email_Str:''?>" name="search_email_Str" placeholder="請填寫會員電子郵件帳號">
                    </div>
                    <div class="spanLineLeft text width150">
                        <select name="search_group_groupid_Num" style="margin-left:-6px;">
                            <option value="">不透過分類標籤篩選</option>
                            <?foreach($UserGroupList->obj_Arr as $key => $value_UserGroup):?>
                            <option value="<?=$value_UserGroup->groupid_Num?>"<?if(!empty($search_group_groupid_Num) && $search_group_groupid_Num == $value_UserGroup->groupid_Num) echo ' selected'?>><?=$value_UserGroup->groupname_Str?></option>
                            <?endforeach?>
                        </select>
                    </div>
                    <div class="spanLineLeft text width100">
                        <input type="submit" class="button filter" value="篩選">
                    </div>
                </form>
            </div>
            <?if(!empty($user_UserList->obj_Arr)):?>
            <?foreach($user_UserList->obj_Arr as $key => $value_User):?>
            <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/delete/") ?>
            <div class="spanLine tablelist">
                <div class="spanLineLeft checkbox">
                    <input type="checkbox" name="uid_Arr[]" value="<?=$value_User->uid_Num?>" class="check">
                </div>
                <div class="spanLineLeft text width100">
                    <?=$value_User->uid_Num?>
                </div>
                <div class="spanLineLeft text width200">
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?uid=<?=$value_User->uid_Num?>"><?=$value_User->username_Str?></a>
                </div>
                <div class="spanLineLeft text width300">
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?uid=<?=$value_User->uid_Num?>"><?=$value_User->email_Str?></a>
                </div>
                <div class="spanLineLeft text width150">
                    <?if(!empty($value_User->group_UserGroupList->obj_Arr)):?>
                    <?foreach($value_User->group_UserGroupList->obj_Arr as $key => $value_UserGroup):?>
                        <?if($key !== 0):?>,<?endif?><?=$value_UserGroup->groupname_Str?>
                    <?endforeach?>
                    <?else:?>
                    <span class="gray">沒有分類標籤</span>
                    <?endif?>
                </div>
                <div class="spanLineLeft width100 tablelistMenu">
                    <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?uid=<?=$value_User->uid_Num?>">編輯</a>
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
    <?if(!empty($user_UserList->obj_Arr[0]->uid_Num)):?>
    <div class="batch_deletion">
        <input type="submit" class="button" style="height: 32px;" onclick="return confirm('刪除後將進入回收空間，確定要刪除嗎？')" value="刪除會員">
        <span class="delete_prompt">可以選取單位或多位會員刪除<span>
    </div>
    <?endif?>
    </form>
    <div class="pageLink"><?=$product_links?></div>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>