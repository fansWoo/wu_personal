<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > 查看</h3>
	<h4>請查看<?=$child3_title_Str?>之詳細資訊</h4>
	<div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                標題
            </div>
            <div class="spanLineLeft width500">
                <?php
                    $data['Pic'] = new PicObj();
                    $data['Pic']->construct_db(array(
                        'db_where_Arr' => array(
                            'picid' => $Comment->id_Num
                        )
                    ));
                    
                    $data['Note'] = new Note();
                    $data['Note']->construct_db(array(
                        'db_where_Arr' => array(
                            'noteid' => $Comment->id_Num
                        )
                    ));
                ?>
                <?if(($Comment->typename_Str) == 'pic'):?>
                    <?=$data['Pic']->title_Str?>
                <?elseif(($Comment->typename_Str) == 'note'):?>
                    <?=$data['Note']->title_Str?>
                <?endif?>
            </div>
        </div>
    </div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                分類標籤
            </div>
            <div class="spanLineLeft width500">
                <?if(($Comment->typename_Str) == 'pic'):?>圖片
                <?elseif(($Comment->typename_Str) == 'note'):?>文章
                <?endif?>
            </div>
        </div>
    </div>
    <div class="spanLine">
	    <div class="spanStage">
            <div class="spanLineLeft">
                留言內容
            </div>
            <div class="spanLineLeft width500">
                <?=$Comment->content_Html?>
		    </div>
		</div>
	</div>
    <div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                留言日期
            </div>
            <div class="spanLineLeft">
                <?=$Comment->updatetime_DateTime->datetime_Str?>
            </div>
        </div>
    </div>
	<div class="spanLine spanSubmit">
	    <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <?if(!empty($Comment->commentid_Num)):?><span class="submit gray" onClick="fanswoo.check_href_action('確定要刪除嗎？', 'admin/<?=$child1_name_Str?>/<?=$child2_name_Str?>/<?=$child3_name_Str?>/delete/?commentid=<?=$Comment->commentid_Num?>&hash=<?=$this->security->get_csrf_hash()?>');">刪除<?=$child3_title_Str?></span><?endif?>
            </div>
        </div>
	</div>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>