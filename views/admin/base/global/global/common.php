<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$this->lang->line('common_website_title_management')?></h3>
    <h4>請填寫標題之詳細資訊</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_title_post/") ?>
	<div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                網站標題名稱
            </div>
            <div class="spanLineLeft">
                <input type="text" class="text" name="website_title_name" placeholder="請輸入網站標題名稱" value="<?=$global['website_title_name']?>" required>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">本網站標題名稱將於網站標題最前端顯示</p>
            </div>
        </div>
	</div>
	<div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                網站標題引言
            </div>
            <div class="spanLineLeft width300">
			<input type="text" class="text" name="website_title_introduction" placeholder="請輸入網站標題文字" value="<?=$global['website_title_introduction']?>">
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">本網站標題文字將於網站標題最後端顯示</p>
            </div>
        </div>
	</div>
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
<div class="contentBox allWidth">
	<h3>網站名稱設置</h3>
	<h4>請填寫網站名稱及LOGO圖檔，此設置之設置將影響網站前台之顯示</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_webname_post/") ?>
	<div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                網站名稱
            </div>
            <div class="spanLineLeft">
                <input type="text" class="text" placeholder="請輸入網站名稱" name="website_name" value="<?=$global['website_name']?>" required>
            </div>
        </div>
	</div>
	<div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                網站LOGO圖檔
            </div>
            <div class="spanLineLeft width300">
                <input type="text" class="text" placeholder="請輸入圖檔連結，http://" name="website_logo" value="<?=$global['website_logo']?>" required>
            </div>
        </div>
        <div class="spanStage">
            <div class="spanLineLeft">
            </div>
            <div class="spanLineRight">
                <p class="gray">請填寫圖檔位置，可以填寫本網站圖檔之相對位置，也可以填寫外網之絕對位置網址</p>
            </div>
        </div>
	</div>
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
<div class="contentBox allWidth">
	<h3>客服電子郵件</h3>
	<h4>請填寫電子郵件位置，此設置之設置將影響網站前台之顯示</h4>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_email_post/") ?>
	<div class="spanLine">
        <div class="spanStage">
            <div class="spanLineLeft">
                電子郵件
            </div>
            <div class="spanLineLeft width300">
                <input type="text" class="text" placeholder="請輸入電子郵件，ex: service@fanswoo.com" name="website_email" value="<?=$global['website_email']?>" required>
            </div>
        </div>
	</div>
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
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>