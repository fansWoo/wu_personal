<?=$temp['header_up']?>
<?=$temp['header_down']?>
<script src="js/jquery.scrollex.js"></script>
<script>
$(function(){
	
	$(document).on('click', '.arrow', function(){
		var scroll_top = $(document).scrollTop();
        var $this = $(this);
        if($this.hasClass('go_to_content2'))
        {
            var scroll_top = content01_height;
        }
        $("body,html").animate({scrollTop: scroll_top} , 500, 'swing');
    });

	var content01_pager = $('.content01 .cycle-pager ').height() / 2 + 60 ;
	$('.content01 .cycle-pager').css('margin-top', - content01_pager);
	
	var window_width = $(window).width();
	var content01_height = $(window).height() - $(".header_bar .top_box").height();
	
	
	if( is_mobile() == false ){

		$('.content01').css('height', content01_height);
		$('.bgbg').css('height', content01_height);
 
		$(window).resize(function(){
			var content01_height = $(window).height() - $(".header_bar .top_box").height();
			$('.content01').css('height', content01_height);
			$('.bgbg').css('height', content01_height);
		});
	}	
	
	$(".content01 .slide_pic > .square").cycle({
		fx      :       "scrollHorz", 
		//fade
		//scrollHorz
		timeout: 3000 ,
		speed: 1000,
		manualSpeed: 600,
		slides: ' > .slide_pic_href',
		next: '.content01 .slide_pic_box .next',
		prev: '.content01 .slide_pic_box .prev',
		pager: '.content01 .cycle-pager '
    });
	$('.content01').on('swiperight', function(event){
		$('.content01 .slide_pic .square .prev').click();
	});
	$('.content01').on('swipeleft', function(event){
		$('.content01 .slide_pic .square .next').click();
	});
	
	$(".content04 .slide_pic_box ").cycle({
		fx      :       "scrollHorz", 
		//fade
		//scrollHorz
		timeout: 0 ,
		speed: 1000,
		manualSpeed: 600,
		slides: '.slide_pic_href',
		next: '.content04 .slide_pic_box .next',
		prev: '.content04 .slide_pic_box .prev',
		pager: '.content04 .cycle-pager '
    });
	$('.content04').on('swiperight', function(event){
		$('.content04 .slide_pic_box .prev').click();
	});
	$('.content04').on('swipeleft', function(event){
		$('.content04 .slide_pic_box .next').click();
	});
	
	$(document).scroll(function(){
		var window_width = $(window).width();
        var scroll_top = $(document).scrollTop();
		
		if(scroll_top == 0){
			$('.content01').css("position", "absolute");	
			//$('.content01').css("opacity", "1");
		}
		if(scroll_top > 0){
			$('.content01').css("position", "fixed");
		}
		if(scroll_top < 100 ){
			$('.content01 .slide_pic_box').addClass("opacity_none");
			$('.content01 .slide_pic_box').removeClass("opacity");
			
		}
		else if (scroll_top > 100){
			$('.content01 .slide_pic_box').addClass("opacity");
			$('.content01 .slide_pic_box').removeClass("opacity_none");
		}
	});	
	
	$(document).scroll(function(){
		var window_width = $(window).width();
        var scroll_top = $(document).scrollTop();
		var other_nav_padding_top = $(".header_bar").height();
		if(scroll_top <= content01_height)
		{
			$('.header_bar').removeClass('fixed');
			$('.other_nav').css('padding-top','0px');
			//$('.hover_fixed_nav').addClass('hover2');
			$('.hover_fixed_nav').removeClass('hover');
			
			$(document).on('mouseenter', ' .header_bar .nav_box .downbox', function(){
				$('.hover_fixed_nav').addClass('inedx_hover');
				$('.hover_fixed_nav').css('display' ,"block");
			});
			$(document).on('mouseenter', ' .hover_fixed_nav', function(){
				$('.hover_fixed_nav').addClass('inedx_hover');
				$('.hover_fixed_nav').css('display' ,"block");
			});
			$(document).on('mouseleave', ' .hover_fixed_nav', function(){
				
				$('.hover_fixed_nav').removeClass('inedx_hover'); 
				$('.hover_fixed_nav').css('display' ,"none");
			});
			$(document).on('mouseleave', ' .header_bar .nav_box .downbox', function(){
				
				$('.hover_fixed_nav').removeClass('inedx_hover');
				$('.hover_fixed_nav').css('display' ,"none");
			});

		}
		else 
		{
			$('.header_bar').addClass('fixed');
			$('.other_nav').css('padding-top',other_nav_padding_top);
			$('.hover_fixed_nav').removeClass('inedx_hover');
			
			$(document).on('mouseenter', ' .header_bar .nav_box .downbox', function(){
				$('.hover_fixed_nav').css('display' ,"block");
			});
			$(document).on('mouseenter', ' .hover_fixed_nav', function(){
				$('.hover_fixed_nav').css('display' ,"block");
			});
			$(document).on('mouseleave', ' .hover_fixed_nav', function(){
				
				$('.hover_fixed_nav').css('display' ,"none");
			});
			$(document).on('mouseleave', ' .header_bar .nav_box .downbox', function(){
				
				$('.hover_fixed_nav').css('display' ,"none");
			});
		}

	});
});	
function is_mobile() { 
	if( navigator.userAgent.match(/Android/i)
	|| navigator.userAgent.match(/webOS/i)
	|| navigator.userAgent.match(/iPhone/i)
	|| navigator.userAgent.match(/iPad/i)
	|| navigator.userAgent.match(/iPod/i)
	|| navigator.userAgent.match(/BlackBerry/i)
	|| navigator.userAgent.match(/Windows Phone/i)
	)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
<div class="content01">
	<div class="slide_pic_box">
		<div class="slide_pic">
			<div class="square">
				<?for($a=0;$a<1;$a++):?>
				<a href="" class="slide_pic_href"></a>
				<a href="" class="slide_pic_href"></a>	
				<a href="" class="slide_pic_href"></a>
				<a href="" class="slide_pic_href"></a>
				<a href="" class="slide_pic_href"></a>
				<a href="" class="slide_pic_href"></a>
				<?endfor?>	
				<span class="next" style="display: block;"></span>
				<span class="prev" style="display: block;"></span>
			</div>		
		</div>
	</div>
	<div class="cycle-pager"></div>	
	<div class="arrow go_to_content2">
		<img src="img/index/arrow.png">
	</div>
	<div class="opacity_bg_top"></div>
	<div class="opacity_bg_bottom"></div>
	<div class="bg" id="three"></div>
</div>
<div class="shadow_bg"></div>
<div class="bgbg"></div>
<?=$temp['header_bar']?>
<div class="content02">
	<div class="center_box">
		<div class="cycle-slideshow big_cycle"
			data-cycle-slides="> a" 
			data-cycle-swipe=true
			data-cycle-swipe-fx=scrollHorz
			data-cycle-fx=scrollHorz
			data-cycle-timeout=4000
			data-cycle-prev="#prevControl[data-number=note_class3]"
			data-cycle-next="#nextControl[data-number=note_class3]"
			data-cycle-pause-on-hover="true"
			>
			<!-- empty element for pager links -->
			<a href=""><div class="shadow"></div><img class="pic" src="img/index/content02/pic01.jpg"></a>
			<a href=""><div class="shadow"></div><img class="pic" src="img/index/content02/pic02.jpg"></a>
			<a href=""><div class="shadow"></div><img class="pic" src="img/index/content02/pic01.jpg"></a>
			<a href=""><div class="shadow"></div><img class="pic" src="img/index/content02/pic02.jpg"></a>
		
			<div  class="cycle-pager"></div>
			<span class="pageControl" id="prevControl" data-number="note_class3"><img src="img/prev.png"></span>
			<span class="pageControl" id="nextControl" data-number="note_class3"><img src="img/prev.png"></span>
		</div>
		<div class="cycle-slideshow small_cycle" 
			data-cycle-slides=".box" 
			data-cycle-timeout=5000
			data-cycle-swipe=true
			data-cycle-swipe-fx=scrollHorz
			data-cycle-fx=fade
			data-cycle-prev="#prevControl[data-number=note_class4]"
			data-cycle-next="#nextControl[data-number=note_class4]"
			data-cycle-pause-on-hover="true"
			>
			<!-- empty element for pager links -->
			<a href="" class="box">
				<div class="shadow"></div>
				<img class="pic" src="img/index/content02/pic05.jpg">
				<p>實木造型陶力研磨罐</p>
			</a>
			<a href="" class="box">
				<div class="shadow"></div>
				<img class="pic" src="img/index/content02/pic06.jpg">
				<p>休閒椅</p>
			</a>
			<a href="" class="box">
				<div class="shadow"></div>
				<img class="pic" src="img/index/content02/pic05.jpg">
				<p>實木造型陶力研磨罐</p>
			</a>
			<div  class="cycle-pager"></div>
		</div>
		<a href="" class="banner_box">
			<div class="shadow"></div>
			<img src="img/index/content02/pic03.jpg">
		</a>
		<div class="cycle-slideshow small_cycle" 
			data-cycle-slides=".box" 
			data-cycle-timeout=6000
			data-cycle-swipe=true
			data-cycle-swipe-fx=scrollHorz
			data-cycle-fx=scrollHorz
			data-cycle-pause-on-hover="true"
			data-cycle-prev="#prevControl[data-number=note_class5]"
			data-cycle-next="#nextControl[data-number=note_class5]"
			>
			<!-- empty element for pager links -->
			<a href="" class="box">
				<div class="shadow"></div>
				<img class="pic" src="img/index/content02/pic06.jpg">
				<p>休閒椅</p>
			</a>
			<a href="" class="box">
				<div class="shadow"></div>
				<img class="pic" src="img/index/content02/pic05.jpg">
				<p>實木造型陶力研磨罐</p>
			</a>
			<a href="" class="box">
				<div class="shadow"></div>
				<img class="pic" src="img/index/content02/pic06.jpg">
				<p>休閒椅</p>
			</a>
			<div  class="cycle-pager"></div>
		</div>
		<div class="cycle-slideshow big_cycle" id=""
			data-cycle-slides="> a" 
			data-cycle-swipe=true
			data-cycle-swipe-fx=scrollHorz
			data-cycle-fx=fadeout
			data-cycle-timeout=4000
			data-cycle-prev="#prevControl[data-number=note_class6]"
			data-cycle-next="#nextControl[data-number=note_class6]"
			data-cycle-pause-on-hover="true"
			>
			<!-- empty element for pager links -->
			<a><div class="shadow"></div><img class="pic" src="img/index/content02/pic02.jpg"><div class="shadow"></div></a>
			<a><div class="shadow"></div><img class="pic" src="img/index/content02/pic01.jpg"><div class="shadow"></div></a>
			<a><div class="shadow"></div><img class="pic" src="img/index/content02/pic02.jpg"><div class="shadow"></div></a>
			<a><div class="shadow"></div><img class="pic" src="img/index/content02/pic01.jpg"><div class="shadow"></div></a>

			<div class="cycle-pager"></div>
			<span class="pageControl" id="prevControl" data-number="note_class6"><img src="img/prev.png"></span>
			<span class="pageControl" id="nextControl" data-number="note_class6"><img src="img/prev.png"></span>
		</div>
		<a href="" class="banner_box">
			<div class="shadow"></div>
			<img src="img/index/content02/pic04.jpg">
		</a>
		<a href="" class="other_box one">
			<img class="pic" src="img/index/content02/other01.jpg">
			<div class="hover_bg">
				<img src="img/index/content02/enter.png">
			</div>
		</a>
		<a href="" class="other_box two">
			<img class="pic" src="img/index/content02/other02.jpg">
			<div class="hover_bg">
				<img src="img/index/content02/enter.png">
			</div>
		</a>
		<a href="" class="other_box three">
			<img class="pic" src="img/index/content02/other03.jpg">
			<div class="hover_bg">
				<img src="img/index/content02/enter.png">
			</div>
		</a>
		<a href="" class="other_box four">
			<img class="pic" src="img/index/content02/other04.jpg">
			<div class="hover_bg">
				<img src="img/index/content02/enter.png">
			</div>
		</a>
	</div>
	<a href="" class="more" >MORE PRODUCT</a>
</div>
<div class="content03">
	<div class="center_box">
		<a class="circle_box">
			<div class="move_box">
				<div class="hover_box">
					<img src="img/index/content03/new.png" class="en">
				</div>
				<div class="hover_box">
					<img src="img/index/content03/new1.png" class="cn">
				</div>
			</div>
		</a>
		<a class="circle_box">
			<div class="move_box">
				<div class="hover_box">
					<img src="img/index/content03/hot.png" class="en">
				</div>
				<div class="hover_box">
					<img src="img/index/content03/hot1.png" class="cn">
				</div>
			</div>
		</a>
		<a class="circle_box">
			<div class="move_box">
				<div class="hover_box">
					<img src="img/index/content03/sale.png" class="en">
				</div>
				<div class="hover_box">
					<img src="img/index/content03/sale1.png" class="cn">
				</div>
			</div>
		</a>
	</div>
	
</div>
<div class="content04">
	<div class="title_box">
		<p>Single product</p>
		<div class="line"></div>
		<h2>個性單品</h2>	
		<div class="line"></div>
	</div>
	<div class="slide_pic_box">
		<?for($box=0;$box<1;$box++):?>
		<div class="slide_pic_href ">
			<div class="item_area">
				<?for($item=0;$item<2;$item++):?>
				<a href="page/blog_moving" class="item_box">
					<img src="img/index/content02/pic07.png">
				</a>
				<a href="page/blog_moving" class="item_box">
					<img src="img/index/content02/pic08.png">
				</a>
				<?endfor?>
			</div>
		</div>
		<div class="slide_pic_href ">
			<div class="item_area">
				<?for($item=0;$item<2;$item++):?>
				<a href="page/blog_moving" class="item_box">
					<img src="img/index/content02/pic09.png">
				</a>
				<a href="page/blog_moving" class="item_box">
					<img src="img/index/content02/pic10.png">
				</a>
				<?endfor?>
			</div>
		</div>
		<div class="slide_pic_href ">
			<div class="item_area">
				<?for($item=0;$item<2;$item++):?>
				<a href="page/blog_moving" class="item_box">
					<img src="img/index/content02/pic07.png">
				</a>
				<a href="page/blog_moving" class="item_box">
					<img src="img/index/content02/pic10.png">
				</a>
				<?endfor?>
			</div>
		</div>				
		<?endfor?>
		<div class="cycle-pager"></div>			
		<img src="img/index/content02/arrow.png" class="next">
		<img src="img/index/content02/arrow.png" class="prev">
	</div>
</div>
<div class="content05">
	<img src="img/shadow_top.png" class="shadow_top">
	<div class="bg_box">
		<div class="center_box">
			<h2>ASSARI</h2>
			<p>堅持誠懇、信用、親切是我們的經營理念，</p>
			<p>絕對是您挑選家具的第一首選。</p>
		</div>
	
	</div>

</div>



<?=$temp['footer_bar']?>
<?=$temp['body_end']?>