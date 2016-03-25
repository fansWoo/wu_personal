    <link rel="stylesheet" type="text/css" href="js/tool/scrollbar/jquery.mCustomScrollbar.css">
    <script src="js/tool/scrollbar/jquery.mCustomScrollbar.min.js"></script>

    <script>
    $(function(){
        var phone_scrollbar_height = $(window).height() - 80 ;
        var width_scrollbar = $('.header_bar_mobile_content ').css(' width ', '200px' );
        $('.header_bar_mobile_content .scrollbar').mCustomScrollbar({

            theme:"dark", // 設定捲軸樣式
            setWidth: width_scrollbar , // 設定寬度
            setHeight: phone_scrollbar_height ,  // 設定高度    
        });
        
        var window_width = $(window).width();
        var window_height = $(window).height();

        $('a[href^=#]').click(function () {
            var speed = 500;
            var href = $(this).attr("href");
            var target = $(href == "#" || href == "" ? 'html' : href);
            var position = target.offset().top;
            $("html, body").animate({scrollTop: position}, speed, "swing");
                return false;
        });
        $(".child_area").hide();
        $(".header_bar_mobile_content .header_father_area").click(function() {
            $(this).toggleClass("active");
            $(this).children(".child_area").slideToggle();
        });

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
                
                $(".child_area").hide();
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
                
                $(".child_area").hide();
            }
            swipe_data.event_path = false;
        });
    });
    </script>
    <div class="body">
        <div class="header">
            <a href="" class="logo"></a>
            <div class="logStatus">
                <span class="username"><?=$User->email_Str?></span>
                <a href="user/logout">登出</a>
            </div>
        </div>
        <div class="header_bar_mobile">
        <a href="" class="logo"></a>
            <div class="menu">
                <img src="img/menu.png">
            </div>
        </div>
        <div class="header_bar_mobile_content">
            <div class="scrollbar">
                <a class="li" href="<?=base_url()?>">首頁</a>
                <?foreach($admin_sidebox as $key => $child1):?>
                <?foreach($child1['child2'] as $key2 => $child2):?>
                <div class="header_father_area">
                    <p><?=$child2['title']?></p>
                    <?foreach($child2['child3'] as $key3 => $child3):?>
                    <div class="child_area">
                        <?if(!empty($child3['child4'])):?>
                            <?foreach($child3['child4'] as $key4 => $child4):?>
                                <?if( $child4['sidebar_hidden'] !== TRUE ):?>
                                <a href="admin/<?=$key?>/<?=$key2?>/<?=$key3?>/<?=$key4?>" class="acHrefSmall<?if(!empty($child4['selected'])):?> selected hover<?endif?><?if(!empty($child4['display'])):?> hidden<?endif?>">
                                        <?=$child3['title']?> > <?=$child4['title']?>
                                </a>
                                <?endif?>
                            <?endforeach?>
                        <?endif?>
                    </div>
                    <?endforeach?>
                </div>
                <?endforeach?>
                <?endforeach?>
                <a class="li" href="user/logout">登出</a>
            </div>
        </div>
        <div class="wrap_shadow"></div>
        <div class="wrap">
            <div class="sidebar">
                <?foreach($admin_sidebox as $key => $child1):?>
                <div class="sidebox<?if(!empty($child1['selected']) && $child1['selected'] === TRUE):?> hover<?endif?>">
                    <h2><?=$child1['title']?></h2>
                    <?if(!empty($child1['child2'])):?>
                    <?foreach($child1['child2'] as $key2 => $child2):?>
                    <div class="acHref<?if(!empty($child2['selected']) && $child2['selected'] === TRUE):?> selected hover<?endif?><?if(!empty($child2['display']) && $child2['display'] === TRUE):?> hidden<?endif?>">
                        <div class="acHrefBig">
                            <?=$child2['title']?>
                        </div>
                        <div class="acHrefSmallBar">
                        <?if(!empty($child2['child3'])):?>
                        <?foreach($child2['child3'] as $key3 => $child3):?>
                            <?if(!empty($child3['child4'])):?>
                            <?foreach($child3['child4'] as $key4 => $child4):?>
                                <?if( $child4['sidebar_hidden'] !== TRUE ):?>
                                <a href="admin/<?=$key?>/<?=$key2?>/<?=$key3?>/<?=$key4?>" class="acHrefSmall<?if(!empty($child4['selected'])):?> selected hover<?endif?><?if(!empty($child4['display'])):?> hidden<?endif?>">
                                    <?=$child3['title']?> > <?=$child4['title']?>
                                </a>
                                <?endif?>
                            <?endforeach?>
                            <?endif?>
                        <?endforeach?>
                        <?endif?>
                        </div>
                    </div>
                    <?endforeach?>
                    <?endif?>
                </div>
                <?endforeach?>
            </div>
            <div class="content">