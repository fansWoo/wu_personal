<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > <?if(!empty($PagerField->pagerid_Num)):?>編輯<?else:?>新增<?endif?></h3>
	<h4>請填寫<?=$child3_title_Str?>之詳細資訊</h4>
	<?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                頁面標題
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="title_Str" placeholder="請輸入頁面名稱" value="<?=$PagerField->title_Str?>" required>
		    </div>
		</div>
	</div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                頁面代號
            </div>
            <div class="spanLineLeft width200">
                <input type="text" class="text" name="slug_Str" placeholder="請輸入頁面代號" value="<?=$PagerField->slug_Str?>">
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineLeft width500">
                <p class="gray">本頁面代號為網址後方之英文及數字</p>
                <p class="gray">本頁面網址為：「http://<?=$_SERVER['HTTP_HOST'].base_url()?>page/頁面代號」</p>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                頁面分類
            </div>
            <?if(!empty($PagerField->class_ClassMetaList->obj_Arr)):?>
                <?foreach($PagerField->class_ClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
                    <div class="selectLine" fanswoo-selectEachLine>
                        <span class="floatleft">分類：</span>
                        <select fanswoo-selectEachLineMaster="class">
                            <option value="">沒有分類標籤</option>
                            <?foreach($class_ClassMetaList->obj_Arr as $key2 => $value2_ClassMeta):?>
                            <option value="<?=$value2_ClassMeta->classid_Num?>"<?if($value_ClassMeta->class_ClassMetaList->obj_Arr[0]->classid_Num == $value2_ClassMeta->classid_Num):?> selected<?endif?>><?=$value2_ClassMeta->classname_Str?></option>
                            <?endforeach?>
                        </select>
                        <span fanswoo-selectEachLineSlave="class">
                        <?foreach($class_ClassMetaList->obj_Arr as $key2 => $value2_ClassMeta):?>
                            <select fanswoo-selectValue="<?=$value2_ClassMeta->classid_Num?>" fanswoo-selectName="classids_Arr[]"<?if($value_ClassMeta->class_ClassMetaList->obj_Arr[0]->classid_Num == $value2_ClassMeta->classid_Num):?> name="classids_Arr[]"<?else:?> style="display:none;"<?endif?>>
                                <option value="">沒有分類標籤</option>
                                <?
                                    $test_ClassMetaList = new ObjList();
                                    $test_ClassMetaList->construct_db(array(
                                        'db_where_Arr' => array(
                                            'modelname_Str' => 'pager'
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
                <?else:?>
                <div class="selectLine" fanswoo-selectEachLine>
                    <span class="floatleft">分類：</span>
                    <select fanswoo-selectEachLineMaster="class">
                        <option value="">沒有分類標籤</option>
                        <?foreach($class_ClassMetaList->obj_Arr as $key2 => $value2_ClassMeta):?>
                        <option value="<?=$value2_ClassMeta->classid_Num?>"><?=$value2_ClassMeta->classname_Str?></option>
                        <?endforeach?>
                    </select>
                    <span fanswoo-selectEachLineSlave="class">
                    <?foreach($class_ClassMetaList->obj_Arr as $key2 => $value2_ClassMeta):?>
                        <select name="classids_Arr[]" fanswoo-selectValue="<?=$value2_ClassMeta->classid_Num?>" fanswoo-selectName="classids_Arr[]" style="display:none;">
                            <option value="">沒有分類標籤</option>
                            <?
                                $test_ClassMetaList = new ObjList();
                                $test_ClassMetaList->construct_db(array(
                                    'db_where_Arr' => array(
                                        'modelname_Str' => 'pager'
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
            <?endif?>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineLeft width500">
                <span class="gray">請選擇二級分類及分類標籤，多種分類可以重複選取</span>
            </div>
        </div>
    </div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                頁面內容
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
                </div>
                <textarea cols="80" id="content_Str" name="content_Str" rows="10"><?=$PagerField->content_Html?></textarea>
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
                開新視窗
            </div>
            <div class="spanLineLeft width500">
                <label>
                    <input type="checkbox" name="target_Num"<?if(!empty($PagerField->target_Num)):?> checked<?endif?>> 開啟
                </label>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">若啟用此選項，則由外部連結此頁面時，將以開新視窗的方式進入此頁面</p>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                網站轉址
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="href_Str" placeholder="http://" value="<?=$PagerField->href_Str?>">
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">若不啟用網站轉址則留空此選項，如需啟用網站轉址功能，請填寫欲轉址之網址，使用者將於連線此頁面時啟用強制轉址</p>
            </div>
        </div>
    </div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                優先排序指數
            </div>
            <div class="spanLineLeft">
                <input type="number" class="text width100" name="prioritynum_Num" min="0" value="<?=$PagerField->prioritynum_Num?>">
            </div>
		</div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">優先排序指數越高，排序順序越前面</p>
            </div>
        </div>
	</div>
    <?if(!empty($PagerField->pagerid_Num)):?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                更新日期
            </div>
            <div class="spanLineLeft">
                <?=$PagerField->updatetime_DateTime->datetime_Str?>
            </div>
        </div>
    </div>
    <?endif?>
	<div class="spanLine spanSubmit">
	    <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($PagerField->pagerid_Num)):?><input type="hidden" name="pagerid_Num" value="<?=$PagerField->pagerid_Num?>"><?endif?>
                <input type="submit" class="submit" value="<?if(!empty($PagerField->pagerid_Num)):?>儲存變更<?else:?>新增頁面<?endif?>">
                <?if(!empty($PagerField->pagerid_Num)):?><span class="submit gray" onClick="fanswoo.check_href_action('刪除後將進入回收空間，確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?pagerid=<?=$PagerField->pagerid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除<?=$child3_title_Str?></span><?endif?>
            </div>
        </div>
	</div>
	</form>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>