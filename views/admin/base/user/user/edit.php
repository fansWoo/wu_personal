<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<?if(empty($user_UserFieldShop->uid_Num)):?>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > <?if(!empty($user_UserFieldShop->uid_Num)):?>編輯<?else:?>新增<?endif?></h3>
    <h4>請填寫<?=$child3_title_Str?>之詳細資訊</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_adduser_post/") ?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                會員電子郵件
            </div>
            <div class="spanLineLeft width200">
                <input type="text" name="email_Str" class="text" placeholder="請輸入會員的電子郵件" required>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                會員密碼
            </div>
            <div class="spanLineLeft width200">
                <input type="password" name="password_Str" class="text" placeholder="請輸入8-16字元的密碼" required>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                確認密碼
            </div>
            <div class="spanLineLeft width200">
                <input type="password" name="password2_Str" class="text" placeholder="請再次輸入8-16字元的密碼" required>
            </div>
        </div>
    </div>
    <div class="spanLine spanSubmit">
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <input type="submit" class="submit" value="新增會員">
            </div>
        </div>
    </div>
    </form>
</div>
<?endif?>
<?if(!empty($user_UserFieldShop->uid_Num)):?>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > 基本資料<?if(!empty($user_UserFieldShop->uid_Num)):?>編輯<?else:?>新增<?endif?></h3>
	<h4>請填寫<?=$child3_title_Str?>之詳細資訊</h4>
	<?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                電子郵件帳號
            </div>
            <div class="spanLineLeft width200">
                <?=$user_UserFieldShop->email_Str?>
            </div>
        </div>
    </div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                會員名稱
            </div>
            <div class="spanLineLeft width200">
                <input type="text" class="text" name="username_Str" placeholder="請輸入會員名稱" value="<?=$user_UserFieldShop->username_Str?>" required>
		    </div>
		</div>
	</div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                會員群組
            </div>
            <div class="spanLineLeft width300">
                <?if(!empty($user_UserFieldShop->group_UserGroupList->obj_Arr)):?>
                <div>
                    <select name="groupids_Arr[]">
                        <option value="">沒有分類標籤</option>
                        <?foreach($UserGroupList->obj_Arr as $key2 => $value2_UserGroup):?>
                        <option value="<?=$value2_UserGroup->groupid_Num?>"<?if($user_UserFieldShop->group_UserGroupList->obj_Arr[0]->groupid_Num == $value2_UserGroup->groupid_Num):?> selected<?endif?>><?=$value2_UserGroup->groupname_Str?></option>
                        <?endforeach?>
                    </select>
                </div>
                <?else:?>
                <div>
                    <select name="groupids_Arr[]">
                        <option value="">沒有分類標籤</option>
                        <?foreach($UserGroupList->obj_Arr as $key => $value_UserGroup):?>
                        <option value="<?=$value_UserGroup->groupid_Num?>"><?=$value_UserGroup->groupname_Str?></option>
                        <?endforeach?>
                    </select>
                </div>
                <?endif?>
            </div>
        </div>
    </div>
    <?if(!empty($user_UserFieldShop->uid_Num)):?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                更新日期
            </div>
            <div class="spanLineLeft">
                <?=$user_UserFieldShop->updatetime_DateTime->datetime_Str?>
            </div>
        </div>
    </div>
    <?endif?>
	<div class="spanLine spanSubmit">
	    <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($user_UserFieldShop->uid_Num)):?><input type="hidden" name="uid_Num" value="<?=$user_UserFieldShop->uid_Num?>"><?endif?>
                <input type="submit" class="submit" value="<?if(!empty($user_UserFieldShop->uid_Num)):?>儲存變更<?else:?>新增會員<?endif?>">
                <?if(!empty($user_UserFieldShop->uid_Num)):?><span class="submit gray" onClick="fanswoo.check_href_action('刪除後將進入回收空間，確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?uid=<?=$user_UserFieldShop->uid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除<?=$child3_title_Str?></span><?endif?>
            </div>
        </div>
	</div>
	</form>
</div>
<?endif?>
<?if(!empty($user_UserFieldShop->uid_Num)):?>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > 變更密碼</h3>
    <h4>請填寫新的<?=$child3_title_Str?>會員密碼</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_changepassword_post/") ?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                電子郵件帳號
            </div>
            <div class="spanLineLeft width200">
                <?=$user_UserFieldShop->email_Str?>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                變更密碼
            </div>
            <div class="spanLineLeft width200">
                <input type="password" class="text" name="password_Str" placeholder="請輸入欲變更的會員密碼" required>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
                
            </div>
            <div class="spanLineRight">
                <span class="gray">請輸入英文與數字結合之8-16個字元的密碼</span>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                確認密碼
            </div>
            <div class="spanLineLeft width200">
                <input type="password" class="text" name="password2_Str" placeholder="請再次輸入欲變更的會員密碼" required>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
                
            </div>
            <div class="spanLineRight">
                <span class="gray">請確認兩次輸入的密碼一致</span>
            </div>
        </div>
    </div>
    <?if(!empty($user_UserFieldShop->uid_Num)):?>
    <div class="spanLine spanSubmit">
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($user_UserFieldShop->uid_Num)):?><input type="hidden" name="uid_Num" value="<?=$user_UserFieldShop->uid_Num?>"><?endif?>
                <input type="submit" class="submit" value="<?if(!empty($user_UserFieldShop->uid_Num)):?>儲存變更<?else:?>新增會員<?endif?>">
            </div>
        </div>
    </div>
    <?endif?>
    </form>
</div>
<?endif?>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>