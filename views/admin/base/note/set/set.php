<?=$temp['header_up']?>
<?=$temp['header_down']?>
<?=$temp['admin_header_bar']?>
<h2><?=$child2_title_Str?> - <?=$child3_title_Str?></h2>
<div class="contentBox allWidth">
    <h3><?=$child3_title_Str?> > 設置</h3>
    <h4>本設置可銷毀所有刪除的文章或復原所有刪除的文章</h4>
    <div class="spanLine spanSubmit" style="padding:0 0 10px 0;">
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_destroy_post/") ?>
        <input type="submit" class="submit" value="銷毀文章">
    </form>
    <?php echo form_open_multipart("admin/$child1_name_Str/$child2_name_Str/$child3_name_Str/{$child4_name_Str}_recovery_post/") ?>
        <input type="submit" class="submit" value="復原文章">
    </form>
    </div>
</div>
<?=$temp['admin_footer_bar']?>
<?=$temp['body_end']?>