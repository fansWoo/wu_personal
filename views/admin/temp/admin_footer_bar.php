			</div>
		</div>
		<div class="footer">
			<div class="language">
				<?
					$this->config->load('i18n');
					$language_Arr = $this->config->item('language');
				?>
				語言切換：
				<select>
					<?foreach($language_Arr['locale'] as $key => $value_Str):?>
					<option value="languages/?change=<?=$key?>&back_url=<?='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>"<?if($global['locale'] == $key):?> selected<?endif?>><?=$value_Str?></option>
					<?endforeach?>
				</select>
				<script>
					$(function(){
						var base_Str = $('base').attr('href');
						$(document).on('change', '.footer .language select', function(){
							location.href = base_Str + $(this).val();
						});
					});
				</script>
			</div>
			<div class="center">
       			<a href="http://fanswoo.com" target="_blank">fansWoo</a> All Rights Reserved. Design By <a href="http://fanswoo.com" target="_blank">fansWoo 瘋沃科技</a>
       		</div>
		</div>