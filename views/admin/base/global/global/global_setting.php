<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<?foreach($setting_Arr as $key => $value_Arr):?>
<div class="contentBox allWidth">
    <h3><?=$value_Arr['title']?></h3>
    <h4><?=$value_Arr['subtitle']?></h4>
    <?php echo form_open_multipart($value_Arr['form_open']) ?>
    <?foreach($value_Arr['child'] as $key2 => $value2_Arr):?>
	<div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                <?=$value2_Arr['title']?>
            </div>
            <div class="spanLineLeft">
                <input type="text" class="text" name="<?=$value2_Arr['name']?>" placeholder="<?=$value2_Arr['placeholder']?>" value="<?=$global[$value2_Arr['name']]?>" required>
            </div>
        </div>
        <?if(!empty($value2_Arr['explanation'])):?>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray"><?=$value2_Arr['explanation']?></p>
            </div>
        </div>
        <?endif?>
	</div>
    <?endforeach?>
	<div class="spanLine spanSubmit">
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <input type="submit" class="submit" value="儲存設置">
            </div>
        </div>
	</div>
	</form>
</div>
<?endforeach?>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>