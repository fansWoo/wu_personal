<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['header_bar']?>
<div class="newsContant_view">
	<div class="content">
	   <h1>NEWS</h1>
	</div> 
	<div class="contentArea">
			
		<div class="leftBar">
			<h3>分類</h3>
			<div class="box">
				
				<?foreach($ClassMetaList->obj_Arr as $key => $value_ClassMeta):?>
				<a href="news/?class_slug=<?=$value_ClassMeta->slug_Str?>" class="li"><?=$value_ClassMeta->classname_Str?><img src="img/arrow.png" class="arrow"><img src="img/li_bg.png" class="bg"></a>
				<?endforeach?>
			</div>
			<h3>最新消息</h3>
			<div class="box">
				
				<?foreach($new_NoteFieldList->obj_Arr as $key => $value_NoteField):?>
				<a href="note/<?=$value_NoteField->slug_Str?>" class="li"><?=$value_NoteField->title_Str?><img src="img/arrow.png" class="arrow"></a>
				<?endforeach?>
			</div>
		</div>
		<div class="stageBox">
			<div class="stage" style="border:none;">
				<h2><?=$NoteField->title_Str?></h2>	
				<div>
					<?=$NoteField->content_Html?>
				</div>
			</div>
		</div>
	</div>
<?=$temp['footer_bar']?>
<?=$temp['body_end']?>