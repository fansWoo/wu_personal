<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > 設置</h3>
    <h4>本設置可銷毀所有刪除的檔案或復原所有刪除的檔案</h4>
    <div class="spanLine spanSubmit" style="padding:0 0 10px 0;">
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_destroy_post/") ?>
        <input type="submit" class="submit" value="銷毀檔案">
    </form>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_recovery_post/") ?>
        <input type="submit" class="submit" value="復原檔案">
    </form>
    </div>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>