<script src="js/smooth_scrollerator.js"></script>
<script src="js/cycle2.js"></script>
<script>
$(function(){
    
    $('a[href^=#]').click(function () {
			var speed = 500;
			var href = $(this).attr("href");
			var target = $(href == "" || href == "" ? 'html' : href);
			var position = target.offset().top;
		  $("html, body").animate({scrollTop: position}, speed, "swing");
				return false;
	});
	
    $('.hover_fixed_nav').css('display' ,"none");
	$(document).on('mouseenter', ' .header_bar .nav_box .downbox', function(){
		$('.hover_fixed_nav').css('display' ,"block");
        $(".wrap_shadow2").addClass('hover');
	});
	$(document).on('mouseenter', ' .hover_fixed_nav', function(){
		$('.hover_fixed_nav').css('display' ,"block");
        $(".wrap_shadow2").addClass('hover');
	});
	$(document).on('mouseleave', ' .hover_fixed_nav', function(){
		$('.hover_fixed_nav').css('display' ,"none");
        $(".wrap_shadow2").removeClass('hover');
	});
	$(document).on('mouseleave', ' .header_bar .nav_box .downbox', function(){
		$('.hover_fixed_nav').css('display' ,"none");	
		$('.header_bar .nav_box .center_box .downbox').removeClass("hover2");
		$('.header_bar .nav_box .center_box .downbox').removeClass("hover3");
        $(".wrap_shadow2").removeClass('hover');
	});
     
	$(document).on('mouseenter', ' .header_bar .nav_box .center_box .downbox ', function(){
		var header_item = $(this).data('header_item');
		//新增的
		//$(this).addClass('hover');
		$('.hover_fixed_nav .hover_arae').removeClass('hover');
		$('.hover_fixed_nav .hover_arae[data-header_item=' + header_item + ']').addClass('hover');
		$('.header_bar .nav_box .center_box .downbox').removeClass("hover3");
		$(this).addClass('hover3');
	
		$(document).on('mouseenter', ' .hover_fixed_nav', function(){
			
			if($('.hover_fixed_nav .hover_arae[data-header_item=' + header_item + ']').hasClass('hover') == true)
			{
				$('.header_bar .nav_box .center_box .downbox[data-header_item=' + header_item + ']').addClass("hover2");
			}
			
		});
		
		$(document).on('mouseleave', ' .hover_fixed_nav', function(){	
			$('.header_bar .nav_box .center_box .downbox').removeClass("hover2");
		});
		
	});
});
</script>
<div class="body">
	<div class="header_bar">
		<div class="top_box">
			<div class="center_box">
				<a href="" class="logo_box">
					<img src="img/logo-19.png">
				</a>	
				<div class="right_box">
					<div class="box user">
						<a href="" class="icon">
							<img src="img/people-22.png">	
							<P>會員登入</p>
						</a>
						<a href="" class="" ><P>註冊</p></a>
						<a href="" class="fb">
							<img src="img/fb-20.png" class="fb">
						</a>
					</div>
					<div class="box search">
						<input type="text">
						<input type="submit" value=" ">
					</div>
					<div class="box hello">
						<p>您好! JUDY，歡迎光臨鑫億家俱</p>
					</div>
				</div>
			</div>
		</div>
		<div class="nav_box">
			<div class="center_box">
				<a href="" data-header_item="item01" class="downbox">床墊</a>	
				<a href="" data-header_item="item02" class="downbox">客廳</a>	
				<a href="" data-header_item="item03" class="downbox">臥室</a>	
				<a href="" data-header_item="item04" class="downbox">書房</a>	
				<a href="" data-header_item="item05" class="downbox">餐廚</a>	
				<a href="" data-header_item="item06" class="downbox">居家收納</a>	
				<a href="" >促銷商品</a>	
				<a href="" >熱門商品</a>	
				<a href="" >最新消息</a>
			</div>		
		</div>
		<div class="hover_fixed_nav">
			<div class="hover_arae" data-header_item="item01">
				<div class="nav pic">
					<div class="center">
						<p>Mattress</p>
						<div class="pic_box">
							<img src="img/header_pic.jpg">
						</div>
					</div>
				</div>
				<?for($nav=0;$nav<2;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>沙發</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">單人沙發</a>
						<a href="" class="">雙人沙發雙人沙發雙人沙發</a>
						<a href="" class="">腳蹬/休閒椅</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<?for($nav=0;$nav<3;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>客廳桌</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發</a>
						<a href="" class="">雙人沙發</a>
						<a href="" class="">懶骨頭懶骨頭懶骨頭懶骨頭</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<div class="nav">
					<div class="center">
						<h3>其他</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發L型沙發L型沙發L型</a>
						<a href="" class="">雙人沙發</a>
						<a href="" class="">懶骨頭</a>
						<?endfor?>
					</div>
				</div>
			</div>
			<div class="hover_arae" data-header_item="item02">
				<div class="nav pic">
					<div class="center">
						<p>Living room</p>
						<div class="pic_box">
							<img src="img/header_pic.jpg">
						</div>
					</div>
				</div>
				<?for($nav=0;$nav<3;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>客廳桌</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發</a>
						<a href="" class="">雙人沙發雙人沙發雙人沙發</a>
						<a href="" class="">懶骨頭</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<?for($nav=0;$nav<2;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>沙發</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">單人沙發單人沙發單人沙發</a>
						<a href="" class="">雙人沙發</a>
						<a href="" class="">腳蹬/休閒椅</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<div class="nav">
					<div class="center">
						<h3>其他</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發</a>
						<a href="" class="">雙人沙發雙人沙發雙人沙發</a>
						<a href="" class="">懶骨頭</a>
						<?endfor?>
					</div>
				</div>
			</div>
			<div class="hover_arae" data-header_item="item03">
				<div class="nav pic">
					<div class="center">
						<p>Bedroom</p>
						<div class="pic_box">
							<img src="img/header_pic.jpg">
						</div>
					</div>
				</div>
				<?for($nav=0;$nav<2;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>沙發</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">單人沙發</a>
						<a href="" class="">雙人沙發雙人沙發雙人沙發</a>
						<a href="" class="">腳蹬/休閒椅</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<?for($nav=0;$nav<3;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>客廳桌</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發</a>
						<a href="" class="">雙人沙發</a>
						<a href="" class="">懶骨頭懶骨頭懶骨頭懶骨頭</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<div class="nav">
					<div class="center">
						<h3>其他</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發L型沙發L型沙發L型</a>
						<a href="" class="">雙人沙發</a>
						<a href="" class="">懶骨頭</a>
						<?endfor?>
					</div>
				</div>
			</div>
			<div class="hover_arae" data-header_item="item04">
				<div class="nav pic">
					<div class="center">
						<p>Study</p>
						<div class="pic_box">
							<img src="img/header_pic.jpg">
						</div>
					</div>
				</div>
				<?for($nav=0;$nav<3;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>客廳桌</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發</a>
						<a href="" class="">雙人沙發雙人沙發雙人沙發</a>
						<a href="" class="">懶骨頭</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<?for($nav=0;$nav<2;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>沙發</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">單人沙發單人沙發單人沙發</a>
						<a href="" class="">雙人沙發</a>
						<a href="" class="">腳蹬/休閒椅</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<div class="nav">
					<div class="center">
						<h3>其他</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發</a>
						<a href="" class="">雙人沙發雙人沙發雙人沙發</a>
						<a href="" class="">懶骨頭</a>
						<?endfor?>
					</div>
				</div>
			</div>
			<div class="hover_arae" data-header_item="item05">
				<div class="nav pic">
					<div class="center">
						<p>kitchen</p>
						<div class="pic_box">
							<img src="img/header_pic.jpg">
						</div>
					</div>
				</div>
				<?for($nav=0;$nav<2;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>沙發</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">單人沙發</a>
						<a href="" class="">雙人沙發雙人沙發雙人沙發</a>
						<a href="" class="">腳蹬/休閒椅</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<?for($nav=0;$nav<3;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>客廳桌</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發</a>
						<a href="" class="">雙人沙發</a>
						<a href="" class="">懶骨頭懶骨頭懶骨頭懶骨頭</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<div class="nav">
					<div class="center">
						<h3>其他</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發L型沙發L型沙發L型</a>
						<a href="" class="">雙人沙發</a>
						<a href="" class="">懶骨頭</a>
						<?endfor?>
					</div>
				</div>
			</div>
			<div class="hover_arae" data-header_item="item06">
				<div class="nav pic">
					<div class="center">
						<p>Household</p>
						<div class="pic_box">
							<img src="img/header_pic.jpg">
						</div>
					</div>
				</div>
				<?for($nav=0;$nav<3;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>客廳桌</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發</a>
						<a href="" class="">雙人沙發雙人沙發雙人沙發</a>
						<a href="" class="">懶骨頭</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<?for($nav=0;$nav<2;$nav++):?>
				<div class="nav">
					<div class="center">
						<h3>沙發</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">單人沙發單人沙發單人沙發</a>
						<a href="" class="">雙人沙發</a>
						<a href="" class="">腳蹬/休閒椅</a>
						<?endfor?>
					</div>
				</div>
				<?endfor?>
				<div class="nav">
					<div class="center">
						<h3>其他</h3>
						<?for($item=0;$item<2;$item++):?>
						<a href="" class="">L型沙發</a>
						<a href="" class="">雙人沙發雙人沙發雙人沙發</a>
						<a href="" class="">懶骨頭</a>
						<?endfor?>
					</div>
				</div>
			</div>
            <div class="line_box"></div>
		</div>
        <div class="wrap_shadow2"></div>
	</div>
	
	
	
	
	<div class="header_bar_mobile">
		<h2 class="ui_title">fansWoo</h2>
		<div class="menu">
			<img src="img/menu.png">
		</div>
	</div>
	<div class="header_bar_mobile_content">
		<a href="<?=base_url()?>">首頁</a>
		<a href="admin">後台</a>
		<a href="user/logout">登出</a>
	</div>
  
	<div class="wrap_shadow"></div>
	<div class="wrap">
		<div class="other_nav">
			<div class="center_box">
				<div class="logo_box">
					<img src="img/logo.png">
				</div>
				<div class="right_nav">
					<a href="" class="li">聯絡我們</a>
					<a href="" class="li">關於鑫憶</a>
					<a href="" class="li">Q&A</a>
					<a href="" class="li">購物須知 </a>
				</div>
			</div>
		</div>
	
	
	