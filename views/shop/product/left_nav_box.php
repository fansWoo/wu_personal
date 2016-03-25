	<script>
	$(function(){
		
		/* $(".second_class").hide();
		$(".first_class").click(function() {
			//$(this).toggleClass("active");
			$(this).children(".second_class").slideToggle();
		}); */
		
		$(" .a_href_box").hide()
		$(" .second_class ").hide()
		$(" .first_class .first_class_title").click(function() {
			$(this).parents(".first_class").children(".second_class").slideToggle().toggleClass("opacity");
		});
		$(" .third_class .second_class_title").click(function() {
			
			//$(" .a_href_box").slideToggle().removeClass("hide");
			$(this).parents(".third_class").find(".a_href_box").slideToggle().toggleClass("hide");
			$(this).children("img").toggleClass("arrow");
		});
	
	});
	</script>
	<div class="left_area">	
		<div class="product_list">
			<div class="title_box">
				<div class="triangle"></div>
				<div class="text">產品分類</div>
			</div>
			<div class="center_box">
				<div class="top_nav">
					<a href="" class="top">
						<img src="img/shop/hot.png">	
						熱門商品
					</a>
					<a href="" class="top">
						<img src="img/shop/sale.png">	
						促銷商品
					</a>
					<a href="" class="top" >
						<img src="img/shop/a+b.png">	
						A+B特惠組合
					</a>
				</div>
				<div class="top_nav">
					<?for($box=0;$box<2;$box++):?>
					<div class="first_class">
						<p class="first_class_title"><span class="dotted">￭</span> 床墊</p>
						<div class="second_class">
							<div class="third_class">
								<div class="second_class_title"><p>書桌</p> <img src="img/arrow.jpg"></div>
								<div class="a_href_box">
									<a href="">平面桌</a>
									<a href="">鍵盤型</a>
									<a href="">書櫃層架型</a>
									<a href="">附櫃組</a>
									<a href="">主機架/活動櫃</a>
								</div>
							</div>
							<div class="third_class">
								<div class="second_class_title"><p>電腦椅</p> <img src="img/arrow.jpg"></div>
								<div class="a_href_box">
									<a href="">平面桌</a>
									<a href="">鍵盤型</a>
									<a href="">書櫃層架型書櫃層架型書櫃層架型</a>
									<a href="">附櫃組</a>
									<a href="">主機架/活動櫃</a>
								</div>
							</div>
							<div class="third_class">
								<div class="second_class_title"><p>書櫃</p> <img src="img/arrow.jpg"></div>
								<div class="a_href_box">
									<a href="">平面桌</a>
									<a href="">鍵盤型</a>
									<a href="">書櫃層架型</a>
									<a href="">附櫃組</a>
									<a href="">主機架/活動櫃</a>
								</div>
							</div>
						</div>
					</div>
					<?endfor?>
					<?for($box=0;$box<2;$box++):?>
					<div class="first_class">
						<p class="first_class_title"><span class="dotted">￭</span> 居家收納</p>
						<div class="second_class">
							<div class="third_class">
								<div class="second_class_title"><p>書桌</p> <img src="img/arrow.jpg"></div>
								<div class="a_href_box">
									<a href="">平面桌</a>
									<a href="">鍵盤型</a>
									<a href="">書櫃層架型</a>
									<a href="">附櫃組</a>
									<a href="">主機架/活動櫃</a>
								</div>
							</div>
							<div class="third_class">
								<div class="second_class_title"><p>電腦椅</p> <img src="img/arrow.jpg"></div>
								<div class="a_href_box">
									<a href="">平面桌</a>
									<a href="">鍵盤型</a>
									<a href="">書櫃層架型書櫃層架型書櫃層架型</a>
									<a href="">附櫃組</a>
									<a href="">主機架/活動櫃</a>
								</div>
							</div>
							<div class="third_class">
								<div class="second_class_title"><p>書櫃</p> <img src="img/arrow.jpg"></div>
								<div class="a_href_box">
									<a href="">平面桌</a>
									<a href="">鍵盤型</a>
									<a href="">書櫃層架型</a>
									<a href="">附櫃組</a>
									<a href="">主機架/活動櫃</a>
								</div>
							</div>
						</div>
					</div>
					<?endfor?>
				</div>
			</div>
		</div>
		<div class="product_list">
			<div class="title_box">
				<div class="triangle"></div>
				<div class="text">最新消息</div>
			</div>
			<div class="center_box">
				<div class="top_nav news">
					<a href="">
						<span class="dotted">￭</span> <p>加入LINE@好友 享受即時問與答與不定期特惠!/</p>
					</a>
					<a href="">
						<span class="dotted">￭</span> <p>重要公告,12/18開始，全省門市無自取服務</p>
					</a>
					<a href="">
						<span class="dotted">￭</span> <p>加入LINE@好友 享受即時問與答與不定期特惠!</p>
					</a>
					<a href="">
						<span class="dotted">￭</span> <p>重要公告,12/18開始，全省門市無自取服務</p>
					</a>
					<a href="">
						<span class="dotted">￭</span> <p>加入LINE@好友 享受即時問與答與不定期特惠!</p>
					</a>
					<a href="" class="button">觀看更多</a>
				</div>
			</div>
		</div>
		<div class="product_list hot">
			<div class="title_box">
				<div class="triangle"></div>
				<div class="text">熱銷商品</div>
			</div>
			<div class="center_box">
				<div class="top_nav">
					<a href="" class="">
						<div class="pic_box">
							<img src="">
						</div>
						<div class="text"></div>
						<div class="price_box"></div>
					</a>
					<a href="" class="">
						
					</a>
					<a href="" class="">
						
					</a>
				</div>
				
			</div>
		</div>
	</div>