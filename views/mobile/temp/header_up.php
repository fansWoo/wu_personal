<!DOCTYPE html>
<html lang="zh-Hant-TW" class="<?=$global['browser_agent']['browser']?><?if(!empty($global['browser_agent']['browser_ie'])){echo ' '.$global['browser_agent']['browser_ie'];}?>">
<head>
	<title><?=$global['website_title_name']?><?if($global['website_title_introduction']):?> - <?=$global['website_title_introduction']?><?endif?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?foreach( $global['website_metatag_Arr'] as $key => $value_Str ):?>
    <meta name="keywords" content="<?=$value_Str?>" />
    <?endforeach?>
	<?if(isset($global['website_metatag_array'])):?>
	<?foreach($global['website_metatag_array'] as $value):?>
	<meta name="keywords" content="<?=$value?>">
	<?endforeach?>
	<?endif?>
	<base href="<?=prep_url($_SERVER['HTTP_HOST'].base_url())?>" />
	<script src="fanswoo-framework/js/jquery-1.11.1.min.js"></script>
	<script src="fanswoo-framework/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<script src="fanswoo-framework/js/velocity.min.js"></script>
	<script src="fanswoo-framework/js/jquery.mobile.touchevent.js"></script>
	<script src="fanswoo-framework/js/fanswoo-mobile.js"></script>
	<link rel="stylesheet" type="text/css" href="fanswoo-framework/js/jquery-ui-1.11.4.custom/jquery-ui.css"></link>
	<script src="fanswoo-framework/js/fanswoo-1.3.1.js"></script>
	<script src="app/js/mobile/global.js"></script>
	<?foreach( (array) $global['js'] as $value):?>
	<script src="<?=$value?>"></script>
	<?endforeach?>
	<?if(!empty($global['website_script_plugin_ga'])):?><?=$global['website_script_plugin_ga']?><?endif?>
	<?if(!empty($global['website_script_plugin_fb'])):?><?=$global['website_script_plugin_fb']?><?endif?>
	<?if(!empty($global['website_script_plugin_custom'])):?><?=$global['website_script_plugin_custom']?><?endif?>
	<link rel="shortcut icon" href="img/favicon.ico"></link>
	<link rel="stylesheet" type="text/css" href="fanswoo-framework/style/fanswoo-framework.css"></link>