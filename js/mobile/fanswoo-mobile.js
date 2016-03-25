$(function(){

	//頂部菜單初始化
	var swipe_data = 
	{
		'event_path': false,
		'left_size': 0,
		'duration': 0,
		'page': {'x': 0, 'y': 0}
	};
	var header_bar_mobile_content_width = $('.header_bar_mobile_content').width();

	//頁面高度初始化
	var window_width = $(window).width();
	var window_height = $(window).height();
	$(window).load(function(){
		$('[fanswoo-m-page]').css('height', (window_height - ( 50 + parseInt($('[fanswoo-m-page]').css('margin-top')) + parseInt($('[fanswoo-m-page]').css('margin-bottom')) + parseInt($('[fanswoo-m-page]').css('padding-top')) + parseInt($('[fanswoo-m-page]').css('padding-bottom') ) ) ) + 'px');
	});

	//頁面轉換
	$("[fanswoo-m-page]").css('display', 'none');
	$("[fanswoo-m-page]:eq(0)").css({'display': 'block'});
	$(document).on('click', "[fanswoo-m-pageto]", function(){
		$this = $(this);
		history.pushState({},'title', 'mobile/' + $this.attr("fanswoo-m-pageto"));
		pageto( $this.attr("fanswoo-m-pageto") );
	});
	$(window).on('popstate', function(e){
		var href_Arr = location.href.split("/mobile/");
		pageto( href_Arr[1] );
	});
	function pageto(pageto)
	{
		if(pageto == '')
		{
			pageto = 'index';
		}
		$.Velocity.animate( $("[fanswoo-m-page]"), { 'opacity': 0, 'translateY': '-10px' }, 200 )
		.then( function(){
			$("[fanswoo-m-page]").css({'display': 'none'});
			$("[fanswoo-m-page=" + pageto + "]").css({'display': 'block'}); 
			$("[fanswoo-m-page=" + pageto + "]").velocity({'opacity': 1, 'translateY': 0}, 200 );
		});
	}

	//新增菜單陰影層
	$("body").prepend("<div class='wrap_shadow'></div>");
	$('.wrap_shadow').css({"display": "none", "position": "fixed", "width": "100%", "height": "100%", "background": "rgba(0, 0, 0, 0.5)", "z-index": "997", "opacity": "0"});
	$(document).on('click', '.wrap_shadow, .header_bar_mobile > .menu', function(event){
		if($('.header_bar_mobile').hasClass('clicked'))
		{
			$('.header_bar_mobile').removeClass('clicked');
			$('.header_bar_mobile_content').css('margin-left', -header_bar_mobile_content_width);
			$('.header_bar_mobile_content').animate({ marginLeft: 0 }, {
			    step: function(now,fx) {
			      $(this).css('transform','matrix(1, 0, 0, 1, ' + now + ', 0)');
			    },
			    duration : 300
			},'linear');

			$('.wrap_shadow').velocity({ opacity: 0 }, {'display': 'none'}, 300);
		}
		else
		{

			$('.wrap_shadow').css('display', 'block');
			$('.wrap_shadow').velocity({ opacity: 1 }, 300);

			$('.header_bar_mobile').addClass('clicked');
			$('.header_bar_mobile_content').css('margin-left', '0px');
			$('.header_bar_mobile_content').animate({ marginLeft: -header_bar_mobile_content_width }, {
				step: function(now,fx) {
					$(this).css('transform','matrix(1, 0, 0, 1, ' + now + ', 0)');
				},
				duration : 300
			},'linear');
		}
	});

	//菜單左划
	$(document).on('swipeleft', function(event){
		if( event.swipestop.coords[0] > $(window).width() - 80 )
		{
			$('.wrap_shadow').css('display', 'block');
			$('.wrap_shadow').velocity({ opacity: 1 }, 300);

				swipe_data.page.x = event.swipestop.coords[0];
				swipe_data.page.y = event.swipestop.coords[1];
				swipe_data.event_path = 'left';
				swipe_data.duration = event.swipestop.time - event.swipestart.time;
		}
	});

	//菜單右划
	$(document).on('swiperight', function(event){
		swipe_data.page.x = event.swipestop.coords[0];
		swipe_data.page.y = event.swipestop.coords[1];
		swipe_data.event_path = 'right';
		swipe_data.duration = event.swipestop.time - event.swipestart.time;
		$('.wrap_shadow').css('display', 'block');
	});

	//菜單滑動結束
	$(document).on('touchend', function(event){
		var translate_x = $(".header_bar_mobile_content").css('transform').split('matrix(1, 0, 0, 1,');
		var translate_x = translate_x[1];
		var translate_x = translate_x.split(', 0)');
		var translate_x = translate_x[0];
		if(
			swipe_data.event_path === 'left' && swipe_data.left_size <= -50 ||
			swipe_data.event_path === 'right' && swipe_data.left_size <= -150
		)
		{
			$('.header_bar_mobile_content').css('margin-left', translate_x + 'px');
			$('.header_bar_mobile_content').animate({ marginLeft: -header_bar_mobile_content_width }, {
				step: function(now,fx) {
				    $(this).css('transform','matrix(1, 0, 0, 1, ' + now + ', 0)');
				},
				duration : 150
			},'linear');

			$('.header_bar_mobile').addClass('clicked');
			$('.wrap_shadow').velocity({ opacity: 1 }, 150);
		}
		else if(
			swipe_data.event_path === 'right' && swipe_data.left_size > -150 ||
			swipe_data.event_path === 'left' && swipe_data.left_size > -50
		)
		{
			$('.header_bar_mobile_content').css('margin-left', translate_x + 'px');
			$('.header_bar_mobile_content').animate({ marginLeft: 0 }, {
			    step: function(now,fx) {
			      $(this).css('transform','matrix(1, 0, 0, 1, ' + now + ', 0)');
			    },
			    duration : 150
			},'linear');

			$('.header_bar_mobile').removeClass('clicked');
			$('.wrap_shadow').velocity({ opacity: 0 }, {'display': 'none'}, 150);
		}
		swipe_data.event_path = false;
	});

	//菜單移動中
	$(document).touchmove(function (event) {requestAnimationFrame(function(){
		if(swipe_data.event_path === 'left')
		{
			swipe_data.left_size = event.originalEvent.changedTouches[0].clientX - swipe_data.page.x;
			if(swipe_data.left_size < -header_bar_mobile_content_width)
			{
				swipe_data.left_size = -header_bar_mobile_content_width;
			}
			$('.header_bar_mobile_content').css({ 'transform': 'translateX(' + swipe_data.left_size + 'px)' });
			// $('.wrap_shadow').css({ 'opacity': -swipe_data.left_size / header_bar_mobile_content_width });
		}
		else if(swipe_data.event_path === 'right' && $('.header_bar_mobile_content').css('transform') !== 'matrix(1, 0, 0, 1, 0, 0)')
		{
			swipe_data.left_size = event.originalEvent.changedTouches[0].clientX - swipe_data.page.x - header_bar_mobile_content_width;
			if(swipe_data.left_size < -header_bar_mobile_content_width)
			{
				swipe_data.left_size = -header_bar_mobile_content_width;
			}
			$('.header_bar_mobile_content').css('transform', 'translateX(' + swipe_data.left_size + 'px)');
			// $('.wrap_shadow').css('opacity', -swipe_data.left_size / header_bar_mobile_content_width);
		}
	}); });

});