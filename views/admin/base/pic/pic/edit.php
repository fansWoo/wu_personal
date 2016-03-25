<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2>圖片管理 - 新增圖片</h2>
<div class="contentBox allWidth">
	<h3>新增圖片</h3>
	<h4>請填寫欲新增之圖片資訊</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_post/") ?>
    <?if(empty($PicObj->picid_Num)):?>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                圖片上傳
            </div>
            <div class="spanLineLeft width500">
                <div fanswoo-pic_upload_ajax>上傳更多圖片</div>
                <div class="picidUploadList" fanswoo-piclist>
                    <div fanswoo-picid class="picidUploadLi" fanswoo-clone>
                        <div class="pic"><img src="" fanswoo-picid_img></div>
                        <div class="other">
                            <div class="pic_copy"><input type="text" fanswoo-input_copy readonly /></div>
                            <div fanswoo-pic_delete class="pic_delete">刪除圖片</div>
                        </div>
                        <input type="hidden" fanswoo-picid_input_hidden_picid name="picids_Arr[]">
                    </div>
                </div>
		    </div>
		</div>
	</div>
    <?else:?>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                圖片預覽
            </div>
            <div class="spanLineLeft width500">
                <img src="<?if(!empty($PicObj->path_Arr['w300h300'])):?><?=$PicObj->path_Arr['w300h300']?><?endif?>">
		    </div>
		</div>
	</div>
	<div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                圖片網址
            </div>
            <div class="spanLineLeft width500">
                <input type="text" value="<?=$PicObj->path_Arr['w0h0']?>" fanswoo-input_copy readonly>
                <br>
                <a href="<?=$PicObj->path_Arr['w0h0']?>" target="_blank">
                    <?=$PicObj->path_Arr['w0h0']?>
                </a>
		    </div>
		</div>
	</div>
    <?endif?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                分類標籤
            </div>
            <div class="spanLineLeft width300">
                <?if(!empty($PicObj->class_ClassMetaList->obj_Arr)):?>
                <div>
                    <select name="classids_Arr[]">
                        <option value="">沒有分類標籤</option>
                        <?foreach($ClassMetaList->obj_Arr as $key2 => $value2_ClassMeta):?>
                        <option value="<?=$value2_ClassMeta->classid_Num?>"<?if($PicObj->class_ClassMetaList->obj_Arr[0]->classid_Num == $value2_ClassMeta->classid_Num):?> selected<?endif?>><?=$value2_ClassMeta->classname_Str?></option>
                        <?endforeach?>
                    </select>
                </div>
                <?else:?>
                <div>
                    <select name="classids_Arr[]">
                        <option value="">沒有分類標籤</option>
                        <?foreach($ClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
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
                <a href="admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/album/tablelist">管理分類標籤</a>
            </div>
        </div>
    </div>
    <?if(!empty($PicObj->picid_Num)):?>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                更新日期
            </div>
            <div class="spanLineLeft">
                <?=$PicObj->updatetime_DateTime->datetime_Str?>
            </div>
        </div>
    </div>
    <?endif?>
	<div class="spanLine spanSubmit">
	    <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($PicObj->picid_Num)):?><input type="hidden" name="picid_Num" value="<?=$PicObj->picid_Num?>"><?endif?>
                <input type="submit" class="submit" value="儲存變更">
                <?if(!empty($PicObj->picid_Num)):?><span class="submit gray" onClick="fanswoo.check_href_action('刪除後將進入回收空間，確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?picid=<?=$PicObj->picid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除<?=$child3_title_Str?></span><?endif?>
            </div>
        </div>
	</div>
	</form>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>