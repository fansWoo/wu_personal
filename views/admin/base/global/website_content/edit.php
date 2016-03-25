<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > <?if(!empty($NoteField->noteid_Num)):?>編輯<?else:?>新增<?endif?></h3>
    <h4>請填寫<?=$child3_title_Str?>之詳細資訊</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                文章標題
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="title_Str" placeholder="請輸入文章名稱" value="<?=$NoteField->title_Str?>" required>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                文章代碼
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="slug_Str" placeholder="文章代碼" value="<?=$NoteField->slug_Str?>">
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">請填寫文章代碼，將會顯示於此文章連結網址，若無填寫則會自動產生亂碼</p>
                <p class="gray">本值需為英文或數字組合，不得含有中文及特殊符號，並且不得與其它文章代碼有重複</p>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                分類標籤
            </div>
            <div class="spanLineLeft width300">
                <?if(!empty($NoteField->class_ClassMetaList->obj_Arr)):?>
                <div>
                    <select name="classids_Arr[]">
                        <option value="">沒有分類標籤</option>
                        <?foreach($NoteClassMetaList->obj_Arr as $key2 => $value2_NoteClass):?>
                        <option value="<?=$value2_NoteClass->classid_Num?>"<?if($NoteField->class_ClassMetaList->obj_Arr[0]->classid_Num == $value2_NoteClass->classid_Num):?> selected<?endif?>><?=$value2_NoteClass->classname_Str?></option>
                        <?endforeach?>
                    </select>
                </div>
                <?else:?>
                <div>
                    <select name="classids_Arr[]">
                        <option value="">沒有分類標籤</option>
                        <?foreach($NoteClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
                        <option value="<?=$value_ClassMeta->classid_Num?>"><?=$value_ClassMeta->classname_Str?></option>
                        <?endforeach?>
                    </select>
                </div>
                <?endif?>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineLeft width500">
                <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/classmeta/tablelist">管理分類標籤</a>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                文章預覽圖
            </div>
            <div class="spanLineRight">
                <div fanswoo-pic_upload_ajax fanswoo-upload_status="hidden">上傳更多圖片</div>
                <div class="picidUploadList" fanswoo-piclist>
                    <div fanswoo-picid class="picidUploadLi" fanswoo-clone>
                        <div class="pic"><img src="" fanswoo-picid_img></div>
                        <div class="other">
                            <div class="pic_copy"><input type="text" fanswoo-picid_path_input fanswoo-input_copy readonly /></div>
                            <div fanswoo-pic_delete class="pic_delete">刪除圖片</div>
                        </div>
                        <input type="hidden" fanswoo-picid_input_hidden_picid name="picids_Arr[]">
                    </div>
                    <?if(!empty($NoteField->pic_PicObjList->obj_Arr)):?>
                    <?foreach($NoteField->pic_PicObjList->obj_Arr as $key => $value_PicObj):?>
                    <div fanswoo-picid="<?=$value_PicObj->picid_Num?>" class="picidUploadLi">
                        <div class="pic"><img src="<?=$value_PicObj->path_Arr['w50h50']?>" fanswoo-picid_img></div>
                        <div class="other">
                            <div class="pic_copy"><input type="text" fanswoo-picid_path_input fanswoo-input_copy readonly value="<?=$value_PicObj->path_Arr['w0h0']?>" /></div>
                            <div fanswoo-pic_delete class="pic_delete">刪除圖片</div>
                        </div>
                        <input type="hidden" fanswoo-picid_input_hidden_picid name="picids_Arr[]" value="<?=$value_PicObj->picid_Num?>">
                    </div>
                    <?endforeach?>
                    <?endif?>
                </div>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineLeft width500">
                <span class="gray">請上傳300x300之圖檔，多張圖檔將以第一張為默認顯示圖檔</span>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                文章內容
            </div>
            <div class="spanLineRight">
                <div fanswoo-pic_upload_ajax fanswoo-upload_status="unclassified">上傳更多圖片</div>
                <div class="picidUploadList" fanswoo-piclist>
                    <div fanswoo-picid class="picidUploadLi" fanswoo-clone>
                        <div class="pic"><img src="" fanswoo-picid_img></div>
                        <div class="other">
                            <div class="pic_copy"><input type="text" fanswoo-picid_path_input fanswoo-input_copy readonly /></div>
                            <div fanswoo-pic_delete class="pic_delete">刪除圖片</div>
                        </div>
                    </div>
                </div>
                <textarea cols="80" id="content_Str" name="content_Str" rows="10" required ><?=$NoteField->content_Html?></textarea>
                <script src="js/tool/ckeditor/ckeditor.js"></script>
                <script>
                    CKEDITOR.replace( 'content_Str', {
                        toolbar: 'html'
                    });
                </script>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                文章新增時間
            </div>
            <div class="spanLineLeft">
                <script src="js/tool/jquery-ui-timepicker-addon/script.js"></script>
                <link rel="stylesheet" type="text/css" href="js/tool/jquery-ui-timepicker-addon/style.css"></link>
                <script>
                $(function(){
                    $('#updatetime_Str').datetimepicker({
                        dateFormat: 'yy-mm-dd',
                        timeFormat: 'HH:mm:ss'
                    });
                });
                </script>
                <input type="text" id="updatetime_Str" class="text" name="updatetime_Str" value="<?=$NoteField->updatetime_DateTime->datetime_Str?>">
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                 文章發表狀態
            </div>
            <div class="spanLineLeft">
                <select name="shelves_status_Num">
                    <option value="2"<?if($NoteField->shelves_status_Num == 2):?> selected<?endif?>>未發表</option>
                    <option value="1"<?if($NoteField->shelves_status_Num == 1):?> selected<?endif?>>已發表</option>
                </select>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                優先排序指數
            </div>
            <div class="spanLineLeft">
                <input type="number" class="text width100" name="prioritynum_Num" min="0" value="<?=$NoteField->prioritynum_Num?>">
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">優先排序值較高者，其排序較為前面</p>
            </div>
        </div>
    </div>
    <?if(0):?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                瀏覽數
            </div>
            <div class="spanLineLeft">
                <?=$NoteField->viewnum_Num?>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                回應數
            </div>
            <div class="spanLineLeft">
                <?=$NoteField->viewnum_Num?>
            </div>
        </div>
    </div>
    <?endif?>
    <div class="spanLine spanSubmit">
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($NoteField->noteid_Num)):?><input type="hidden" name="noteid_Num" value="<?=$NoteField->noteid_Num?>"><?endif?>
                <input type="submit" class="submit" value="<?if(!empty($NoteField->noteid_Num)):?>儲存變更<?else:?>新增文章<?endif?>">
                <input type="submit" class="submit" name="show_Bln" value="存成草稿並預覽">
                <?if(!empty($NoteField->noteid_Num)):?><span class="submit gray" onClick="fanswoo.check_href_action('刪除後將進入回收空間，確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?noteid=<?=$NoteField->noteid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除<?=$child3_title_Str?></span><?endif?>
            </div>
        </div>
    </div>
    </form>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>