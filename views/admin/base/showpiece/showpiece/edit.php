<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > <?if(!empty($showpiece_Showpiece->showpieceid_Num)):?>編輯<?else:?>新增<?endif?></h3>
	<h4>請填寫<?=$child3_title_Str?>之詳細資訊</h4>
	<?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                產品名稱
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="name_Str" placeholder="請輸入商品名稱" value="<?=$showpiece_Showpiece->name_Str?>" required>
		    </div>
		</div>
	</div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                產品圖片
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
                        <input type="hidden" fanswoo-picid_input_hidden_picid name="picids_Arr[]">
                    </div>
                    <?if(!empty($showpiece_Showpiece->pic_PicObjList->obj_Arr)):?>
                    <?foreach($showpiece_Showpiece->pic_PicObjList->obj_Arr as $key => $value_PicObj):?>
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
                產品分類
            </div>
            <div class="spanLineLeft width500" fanswoo-selectEachDiv="class">
                <?if(!empty($showpiece_Showpiece->class_ClassMetaList->obj_Arr)):?>
                <?foreach($showpiece_Showpiece->class_ClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
                    <div class="selectLine" fanswoo-selectEachLine>
                        <span class="floatleft">分類 <span fanswoo-selectEachLineCount></span> ：</span>
                        <select fanswoo-selectEachLineMaster="class">
                            <option value="">沒有分類標籤</option>
                            <?foreach($class2_ClassMetaList->obj_Arr as $key2 => $value2_ClassMeta):?>
                            <option value="<?=$value2_ClassMeta->classid_Num?>"<?if($value_ClassMeta->class_ClassMetaList->obj_Arr[0]->classid_Num == $value2_ClassMeta->classid_Num):?> selected<?endif?>><?=$value2_ClassMeta->classname_Str?></option>
                            <?endforeach?>
                        </select>
                        <span fanswoo-selectEachLineSlave="class">
                        <?foreach($class2_ClassMetaList->obj_Arr as $key2 => $value2_ClassMeta):?>
                            <select fanswoo-selectValue="<?=$value2_ClassMeta->classid_Num?>" fanswoo-selectName="classids_Arr[]"<?if($value_ClassMeta->class_ClassMetaList->obj_Arr[0]->classid_Num == $value2_ClassMeta->classid_Num):?> name="classids_Arr[]"<?else:?> style="display:none;"<?endif?>>
                                <option value="">沒有分類標籤</option>
                                <?
                                    $test_ClassMetaList = new ObjList();
                                    $test_ClassMetaList->construct_db(array(
                                        'db_where_Arr' => array(
                                            'modelname_Str' => 'showpiece'
                                        ),
                                        'db_where_or_Arr' => array(
                                            'classids' => array($value2_ClassMeta->classid_Num)
                                        ),
                                        'model_name_Str' => 'ClassMeta',
                                        'limitstart_Num' => 0,
                                        'limitcount_Num' => 100
                                    ));
                                ?>
                                <?foreach($test_ClassMetaList->obj_Arr as $key3 => $value3_ClassMeta):?>
                                <option value="<?=$value3_ClassMeta->classid_Num?>"<?if($value_ClassMeta->classid_Num == $value3_ClassMeta->classid_Num):?> selected<?endif?>><?=$value3_ClassMeta->classname_Str?></option>
                                <?endforeach?>
                            </select>
                        <?endforeach?>
                        </span>
                    </div>
                <?endforeach?>
                <?endif?>
                <div class="selectLine" fanswoo-selectEachLine>
                    <span class="floatleft">分類 <span fanswoo-selectEachLineCount></span> ：</span>
                    <select fanswoo-selectEachLineMaster="class">
                        <option value="">沒有分類標籤</option>
                        <?foreach($class2_ClassMetaList->obj_Arr as $key2 => $value2_ClassMeta):?>
                        <option value="<?=$value2_ClassMeta->classid_Num?>"><?=$value2_ClassMeta->classname_Str?></option>
                        <?endforeach?>
                    </select>
                    <span fanswoo-selectEachLineSlave="class">
                    <?foreach($class2_ClassMetaList->obj_Arr as $key2 => $value2_ClassMeta):?>
                        <select name="classids_Arr[]" fanswoo-selectValue="<?=$value2_ClassMeta->classid_Num?>" fanswoo-selectName="classids_Arr[]" style="display:none;">
                            <option value="">沒有分類標籤</option>
                            <?
                                $test_ClassMetaList = new ObjList();
                                $test_ClassMetaList->construct_db(array(
                                    'db_where_Arr' => array(
                                        'modelname_Str' => 'showpiece'
                                    ),
                                    'db_where_or_Arr' => array(
                                        'classids' => array($value2_ClassMeta->classid_Num)
                                    ),
                                    'model_name_Str' => 'ClassMeta',
                                    'limitstart_Num' => 0,
                                    'limitcount_Num' => 100
                                ));
                            ?>
                            <?foreach($test_ClassMetaList->obj_Arr as $key3 => $value3_ClassMeta):?>
                            <option value="<?=$value3_ClassMeta->classid_Num?>"><?=$value3_ClassMeta->classname_Str?></option>
                            <?endforeach?>
                        </select>
                    <?endforeach?>
                    </span>
                </div>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineLeft width500">
                <span class="gray">請選擇二級分類及分類標籤，多種分類可以重複選取</span>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineLeft width500">
                <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/classmeta2/tablelist">管理二級分類</a>
            </div>
        </div>
    </div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                產品簡介
            </div>
            <div class="spanLineLeft width500">
                <textarea cols="80" id="synopsis_Str" name="synopsis_Str" rows="10"><?=$showpiece_Showpiece->synopsis_Str?></textarea>
		    </div>
		</div>
	</div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                產品內容
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
                <textarea cols="80" id="content" name="content_Str" rows="10"><?=$showpiece_Showpiece->content_Html?></textarea>
                <script src="js/tool/ckeditor/ckeditor.js"></script>
                <script>
                    CKEDITOR.replace( 'content', {
                        toolbar: 'html'
                    });
                </script>
            </div>
            <div class="spanLineLeft">
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                產品規格
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
                <textarea cols="80" id="content_specification" name="content_specification_Str" rows="10"><?=$showpiece_Showpiece->content_specification_Html?></textarea>
                <script src="js/tool/ckeditor/ckeditor.js"></script>
                <script>
                    CKEDITOR.replace( 'content_specification', {
                        toolbar: 'html'
                    });
                </script>
            </div>
            <div class="spanLineLeft">
            </div>
        </div>
    </div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                優先排序指數
            </div>
            <div class="spanLineLeft">
                <input type="number" class="text width100" name="prioritynum_Num" value="<?=$showpiece_Showpiece->prioritynum_Num?>">
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
    <?if(!empty($showpiece_Showpiece->showpieceid_Num)):?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                更新日期
            </div>
            <div class="spanLineLeft">
                <?=$showpiece_Showpiece->updatetime_DateTime->datetime_Str?>
            </div>
        </div>
    </div>
    <?endif?>
	<div class="spanLine spanSubmit">
	    <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($showpiece_Showpiece->showpieceid_Num)):?><input type="hidden" name="showpieceid_Num" value="<?=$showpiece_Showpiece->showpieceid_Num?>"><?endif?>
                <input type="submit" class="submit" value="<?if(!empty($showpiece_Showpiece->showpieceid_Num)):?>儲存變更<?else:?>新增產品<?endif?>">
                <?if(!empty($showpiece_Showpiece->showpieceid_Num)):?><span class="submit gray" onClick="fanswoo.check_href_action('刪除後將進入回收空間，確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?showpieceid=<?=$showpiece_Showpiece->showpieceid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除<?=$child3_title_Str?></span><?endif?>
            </div>
        </div>
	</div>
	</form>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>