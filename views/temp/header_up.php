<!DOCTYPE html>
<html lang="<?=$global['locale']?>" class="<?=$global['browser_agent']['browser']?><?if(!empty($global['browser_agent']['browser_ie'])){echo ' '.$global['browser_agent']['browser_ie'];}?>">
<head>
	<title><?=$global['website_title_name']?><?if($global['website_title_introduction']):?> - <?=$global['website_title_introduction']?><?endif?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?foreach( (array) $global['website_metatag_Arr'] as $key => $value_Str ):?>
    <meta name="keywords" content="<?=$value_Str?>" />
    <?endforeach?>
	<?if(isset($global['website_metatag_array'])):?>
	<?foreach($global['website_metatag_array'] as $value):?>
	<meta name="keywords" content="<?=$value?>">
	<?endforeach?>
	<?endif?>
	<base href="//<?=$_SERVER['HTTP_HOST'].base_url()?>" />
	<script src="<?=base_url(APPURL.'js/jquery-1.11.1.min.js')?>"></script>
	<script src="<?=base_url(APPURL.'js/jquery-ui-1.11.4.custom/jquery-ui.js')?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url(APPURL.'js/jquery-ui-1.11.4.custom/jquery-ui.css')?>"></link>
	<script src="<?=base_url(APPURL.'js/fanswoo-1.3.1.js')?>"></script>
	<?foreach( (array) $global['js'] as $value):?>
	<script src="<?=base_url(APPURL.'js/'.$value)?>"></script>
	<?endforeach?>
	<?if(!empty($global['website_script_plugin_ga'])):?><?=$global['website_script_plugin_ga']?><?endif?>
	<?if(!empty($global['website_script_plugin_fb'])):?><?=$global['website_script_plugin_fb']?><?endif?>
	<?if(!empty($global['website_script_plugin_custom'])):?><?=$global['website_script_plugin_custom']?><?endif?>
	<link rel="shortcut icon" href="<?=base_url(APPURL.'img/favicon.ico')?>"></link>
	<link rel="stylesheet" type="text/css" href="<?=base_url(APPURL.'style/fanswoo-framework/global.css')?>"></link>