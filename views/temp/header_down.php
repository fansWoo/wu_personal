	<?foreach( (array) $global['style'] as $value):?>
	<link rel="stylesheet" type="text/css" href="<?=base_url(APPURL.'style/'.$value)?>"></link>
	<?endforeach?>
</head>
<body id="body">
	<?=$temp['message_window']?>