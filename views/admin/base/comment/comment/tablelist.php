<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox contentTablelist allWidth">
    <h3><?=$child3_title_Str?> > <?=$child4_title_Str?></h3>
    <h4>請選擇欲查看之<?=$child3_title_Str?></h4>
    <div class="spanLineTable">
        <div class="spanLineTableContent">
            <div class="spanLine tablelist tableTitle">
                <div class="spanLineLeft text width200">
                    標題
                </div>
                <div class="spanLineLeft text width200">
                    留言內容
                </div>
                <div class="spanLineLeft text width150">
                    留言分類標籤
                </div>
                <div class="spanLineLeft text width150">
                    擁有人
                </div>
                <div class="spanLineLeft text width100">
                    編輯操作
                </div>
            </div>
            <div class="spanLine tablelist">
                <?php echo form_open("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
                    <div class="spanLineLeft text width200">
                        留言項目
                        <!-- <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_title_Str)?$search_title_Str:''?>" name="search_title_Str" placeholder="請填寫標題"> -->
                    </div>
                    <div class="spanLineLeft text width200">
                        <input type="text" class="text" style="margin-left:-6px;" value="<?=!empty($search_content_Str)?$search_content_Str:''?>" name="search_content_Str" placeholder="請填寫留言內容">
                    </div>
                    <div class="spanLineLeft text width150">
                        <select name="search_class_slug_Str" style="margin-left:-6px;">
                            <option value="">不透過分類標籤篩選</option>
                            <option value="pic">圖片</option>
                            <option value="note">文章</option>
                        </select>
                    </div>
                    <div class="spanLineLeft text width150">
                        <?if($UserGroup_Num==100):?>
                            會員名稱
                        <?else:?>
                            <input type="text" class="text" value="<?=!empty($search_username_Str)?$search_username_Str:''?>" name="search_username_Str" placeholder="請填寫擁有人完整名稱">
                        <?endif?>
                    </div>
                    <div class="spanLineLeft text width100">
                        <input type="submit" class="button filter" value="篩選">
                    </div>
                </form>
            </div>
            <?if(!empty($CommentList->obj_Arr)):?>
            <?foreach($CommentList->obj_Arr as $key => $value_Comment):?>
                <?php
                    $data['Pic'] = new PicObj();
                    $data['Pic']->construct_db(array(
                        'db_where_Arr' => array(
                            'picid' => $value_Comment->id_Num
                        )
                    ));
                                
                    $data['Note'] = new Note();
                    $data['Note']->construct_db(array(
                        'db_where_Arr' => array(
                            'noteid' => $value_Comment->id_Num
                        )
                    ));
                ?>
                <div class="spanLine tablelist">
                    <div class="spanLineLeft text width200">
                        <?if(($value_Comment->typename_Str) == 'pic'):?>
                            <?=$data['Pic']->title_Str?>
                        <?elseif(($value_Comment->typename_Str) == 'note'):?>
                            <?=$data['Note']->title_Str?>
                        <?endif?>
                    </div>
                    <div class="spanLineLeft text width200">
                        <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?commentid=<?=$value_Comment->commentid_Num?>">
                            <?if((mb_strlen($value_Comment->content_Html, "utf-8")>14)):?>
                            <?=mb_substr(strip_tags($value_Comment->content_Html), 0, 14, 'utf-8')?> ...
                            <?else:?>
                            <?=mb_substr(strip_tags($value_Comment->content_Html), 0, 14, 'utf-8')?>
                            <?endif?>
                        </a>
                    </div>
                    <div class="spanLineLeft text width150">
                        <?if(!empty($value_Comment->typename_Str)):?>
                            <?if(($value_Comment->typename_Str) == 'pic'):?>圖片
                            <?elseif(($value_Comment->typename_Str) == 'note'):?>文章
                            <?endif?>
                        <?else:?><span class="gray">沒有分類標籤</span>
                        <?endif?>
                    </div>
                    <div class="spanLineLeft text width150">
                        <?=$value_Comment->uid_User->username_Str?>
                    </div>
                    <div class="spanLineLeft width100 tablelistMenu">
                        <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/edit/?commentid=<?=$value_Comment->commentid_Num?>">查看</a>
                        <span class="ahref" onClick="fanswoo.check_href_action('確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?commentid=<?=$value_Comment->commentid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除</span>
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
    <div class="pageLink"><?=$page_link?></div>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>