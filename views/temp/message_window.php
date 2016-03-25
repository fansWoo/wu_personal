<?if(!empty($global['message_show']['content'])):?>
	<script>
	$(function(){
		var width_all = $('[fanswoo-message_show]').widthAll();
		$('[fanswoo-message_show]').css('margin-left', - (width_all) / 2);
		var animate_time = <?=$global['message_show']['second']?> * 1000 - 300;
		setTimeout(function(){
			$('[fanswoo-message_show]').animate({'opacity': 0}, 300, 'swing', function(){
				$('[fanswoo-message_show]').remove();
			});
		}, animate_time);
		$(document).on('click', '[fanswoo-message_show]', function(){
			$('[fanswoo-message_show]').animate({'opacity': 0}, 300, 'swing', function(){
				$('[fanswoo-message_show]').remove();
			});
		});
	});
	</script>
	<div fanswoo-message_show>
		<span class="delete"><img src="img/admin/delete15x15.png"></span>
		<?=$global['message_show']['content']?>
	</div>
<?endif?>