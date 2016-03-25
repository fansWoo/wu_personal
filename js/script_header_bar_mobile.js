$(function(){
	var swipe_data = 
	{
		'event_path': false,
		'left_size': 0,
		'duration': 0,
		'page': {'x': 0, 'y': 0}
	};
	$(document).on('click', '.wrap_shadow, .header_bar_mobile > .menu', function(event){
		if($('.header_bar_mobile').hasClass('clicked'))
		{
			$('.header_bar_mobile').removeClass('clicked');
			$('.footer_bar_mobile').removeClass('clicked');
			$('.header_bar_mobile_content').css('margin-left', '-200px');
			$('.header_bar_mobile_content').animate({ marginLeft: 0 }, {
			    step: function(now,fx) {
			      $(this).css('transform','matrix(1, 0, 0, 1, ' + now + ', 0)');
			    },
			    duration : 300
			},'linear');

			$('.wrap_shadow').animate({ opacity: 0 }, {
				duration : 300
			},'linear');

			setTimeout(function(){
				$('.wrap_shadow').css('display', 'none');
			}, 300);
		}
		else
		{
			$('.header_bar_mobile').addClass('clicked');
			$('.footer_bar_mobile').addClass('clicked');
			$('.header_bar_mobile_content').css('margin-left', '0px');
			$('.header_bar_mobile_content').animate({ marginLeft: -200 }, {
				step: function(now,fx) {
				    $(this).css('transform','matrix(1, 0, 0, 1, ' + now + ', 0)');
				},
				duration : 300
			},'linear');

			$('.wrap_shadow').css('display', 'block');
			$('.wrap_shadow').animate({ opacity: 1 }, {
				duration : 300
			},'linear');
		}
	});
	$(document).on('swipeleft', function(event){
		swipe_data.page.x = event.swipestop.coords[0];
		swipe_data.page.y = event.swipestop.coords[1];
		swipe_data.event_path = 'left';
		swipe_data.duration = event.swipestop.time - event.swipestart.time;
		$('.wrap_shadow').css('display', 'block');
	});
	$(document).on('swiperight', function(event){
		swipe_data.page.x = event.swipestop.coords[0];
		swipe_data.page.y = event.swipestop.coords[1];
		swipe_data.event_path = 'right';
		swipe_data.duration = event.swipestop.time - event.swipestart.time;
		$('.wrap_shadow').css('display', 'block');
	});
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
			$('.header_bar_mobile_content').animate({ marginLeft: -200 }, {
				step: function(now,fx) {
				    $(this).css('transform','matrix(1, 0, 0, 1, ' + now + ', 0)');
				},
				duration : swipe_data.duration * 2
			},'linear');

			$('.header_bar_mobile').addClass('clicked');
			$('.footer_bar_mobile').addClass('clicked');
			$('.wrap_shadow').animate({ opacity: 1 }, {
				duration : swipe_data.duration * 2
			},'linear');
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
			    duration : swipe_data.duration * 2
			},'linear');

			$('.header_bar_mobile').removeClass('clicked');
			$('.footer_bar_mobile').removeClass('clicked');
			$('.wrap_shadow').animate({ opacity: 0 }, {
				duration : swipe_data.duration * 2
			},'linear');

			setTimeout(function(){
				$('.wrap_shadow').css('display', 'none');
			}, swipe_data.duration * 2);
		}
		swipe_data.event_path = false;
	});
	$(document).touchmove(function (event) {
		if(swipe_data.event_path === 'left' && $('.header_bar_mobile_content').css('transform') !== 'matrix(1, 0, 0, 1, -200, 0)')
		{
			swipe_data.left_size = event.originalEvent.changedTouches[0].clientX - swipe_data.page.x;
			if(swipe_data.left_size < -200)
			{
				swipe_data.left_size = -200;
			}
			$('.header_bar_mobile_content').css('transform', 'translateX(' + swipe_data.left_size + 'px)');
			$('.wrap_shadow').css('opacity', -swipe_data.left_size / 200);
			// console.log(event.originalEvent.changedTouches[0].clientX + ',' + event.originalEvent.changedTouches[0].clientY);
		}
		else if(swipe_data.event_path === 'right' && $('.header_bar_mobile_content').css('transform') !== 'matrix(1, 0, 0, 1, 0, 0)')
		{
			swipe_data.left_size = event.originalEvent.changedTouches[0].clientX - swipe_data.page.x - 200;
			if(swipe_data.left_size < -200)
			{
				swipe_data.left_size = -200;
			}
			$('.header_bar_mobile_content').css('transform', 'translateX(' + swipe_data.left_size + 'px)');
			$('.wrap_shadow').css('opacity', -swipe_data.left_size / 200);
			// console.log(event.originalEvent.changedTouches[0].clientX + ',' + event.originalEvent.changedTouches[0].clientY);
		}
	});
});