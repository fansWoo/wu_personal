<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > <?if(!empty($Advertising->advertisingid_Num)):?>編輯<?else:?>新增<?endif?></h3>
    <h4>請填寫<?=$child3_title_Str?>之詳細資訊</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                廣告名稱
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="title_Str" placeholder="請輸入廣告名稱" value="<?=$Advertising->title_Str?>" required>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                二級分類
            </div>
            <div class="spanLineLeft width300">
                <?if(!empty($Advertising->class_ClassMetaList->obj_Arr)):?>
                <div>
                    <select name="classids_Arr[]">
                        <option value="">沒有分類標籤</option>
                        <?foreach($AdvertisingClassList->obj_Arr as $key2 => $value2_AdvertisingClass):?>
                        <option value="<?=$value2_AdvertisingClass->classid_Num?>"<?if($Advertising->class_ClassMetaList->obj_Arr[0]->classid_Num == $value2_AdvertisingClass->classid_Num):?> selected<?endif?>><?=$value2_AdvertisingClass->classname_Str?></option>
                        <?endforeach?>
                    </select>
                </div>
                <?else:?>
                <div>
                    <select name="classids_Arr[]">
                        <option value="">沒有分類標籤</option>
                        <?foreach($AdvertisingClassList->obj_Arr as $key => $value_AdvertisingClass):?>
                        <option value="<?=$value_AdvertisingClass->classid_Num?>"><?=$value_AdvertisingClass->classname_Str?></option>
                        <?endforeach?>
                    </select>
                </div>
                <?endif?>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                廣告圖片
            </div>
            <div class="spanLineRight">
                <div fanswoo-pic_upload_ajax>上傳更多圖片</div>
                <div class="picidUploadList" fanswoo-piclist>
                    <div fanswoo-picid class="picidUploadLi" fanswoo-clone>
                        <div class="pic"><img src="" fanswoo-picid_img></div>
                        <div class="other">
                            <div class="pic_copy"><input type="text" fanswoo-picid_path_input fanswoo-input_copy readonly /></div>
                            <div fanswoo-pic_delete class="pic_delete">刪除圖片</div>
                        </div>
                        <input type="hidden" fanswoo-picid_input_hidden_picid name="picids_Arr[]">
                    </div>
                    <?if(!empty($Advertising->pic_PicObjList->obj_Arr)):?>
                    <?foreach($Advertising->pic_PicObjList->obj_Arr as $key => $value_PicObj):?>
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
                廣告連結
            </div>
            <div class="spanLineLeft width500">
                <input type="text" class="text" name="href_Str" placeholder="請輸入廣告連結位置" value="<?=$Advertising->href_Str?>" required>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                廣告簡介
            </div>
            <div class="spanLineLeft width500">
                <textarea id="content_Str" name="content_Str" rows="10"><?=$Advertising->content_Html?></textarea>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                優先排序指數
            </div>
            <div class="spanLineLeft">
                <input type="number" class="text width100" name="prioritynum_Num" value="<?=$Advertising->prioritynum_Num?>">
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
    <?if(!empty($Advertising->advertisingid_Num)):?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                更新日期
            </div>
            <div class="spanLineLeft">
                <?=$Advertising->updatetime_DateTime->datetime_Str?>
            </div>
        </div>
    </div>
    <?endif?>
    <div class="spanLine spanSubmit">
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($Advertising->advertisingid_Num)):?><input type="hidden" name="advertisingid_Num" value="<?=$Advertising->advertisingid_Num?>"><?endif?>
                <input type="submit" class="submit" value="<?if(!empty($Advertising->advertisingid_Num)):?>儲存變更<?else:?>新增廣告<?endif?>">
                <?if(!empty($Advertising->advertisingid_Num)):?><span class="submit gray" onClick="fanswoo.check_href_action('確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?advertisingid=<?=$Advertising->advertisingid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除<?=$child3_title_Str?></span><?endif?>
            </div>
        </div>
    </div>
    </form>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>