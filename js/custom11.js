$(document).ready(function(){
	if($('press_carousel_1').length || $('.press_carousel_2').length || $('.press_carousel_3').length){
		var owl1 = $('.press_carousel_1');
		var owl2 = $('.press_carousel_2');
		var owl3 = $('.press_carousel_3');
		owl1.owlCarousel({singleItem: true});
		owl2.owlCarousel({singleItem: true});
		owl3.owlCarousel({singleItem: true});
		$('.pc_1 .press_c_button_prev').on('click',function(){owl1.trigger('owl.prev');});
		$('.pc_1 .press_c_button_next').on('click',function(){owl1.trigger('owl.next');});
		$('.pc_2 .press_c_button_prev').on('click',function(){owl2.trigger('owl.prev');});
		$('.pc_2 .press_c_button_next').on('click',function(){owl2.trigger('owl.next');});
		$('.pc_3 .press_c_button_prev').on('click',function(){owl3.trigger('owl.prev');});
		$('.pc_3 .press_c_button_next').on('click',function(){owl3.trigger('owl.next');});
		}

	/* BG GALLERY*/

    var container = $('.parallax_container');
    container.children('ul').children('li').each(function(){
        var h = $(window).height() - $('.navigation_wrap').height() + 250 ,
            w = $(this).children('img').width(),
            bg = $(this).children('img').attr('src');

        $(this).css({'background-image':'url(' + bg + ')','height':h, 'width' : '100%'});
        $(this).children('img').hide();
    });
    if($('html').hasClass('ie8')){
    	$('[class*="parallax_container"] > ul > li').css({backgroundSize : "cover"})
    }
    if($('.ftleft').length){
	   	$.fn.waypointInit = function(classN,offset,delay){
			return $(this).waypoint(function(direction){
				var current = $(this);
				if(direction === 'down'){
					if(delay !== 0){
						setTimeout(function(){
							current.addClass(classN);
						},delay);
					}
					else{
						$(this).addClass(classN);
					}
				}else
                {
                        $(this).removeClass(classN);

                }

			},{ offset : offset })
		};
		// synchronise
		$.fn.waypointSynchronise = function(synchroniseElement,offset,classN,delay){
			var element = $(this);
			 return $(synchroniseElement).waypoint(function(direction){
				if(direction === 'down'){
					setTimeout(function(){
						element.addClass(classN);
					},delay);
				}

			},{ offset : offset });
		};


		$('.lookbook_cb .ftleft').waypointInit('ftleft-finished',700);
		$('.lookbook_cb').waypointInit('fixed',500);

         $('.container h2.ftleft').waypointInit('ftleft-finished',700,0);
		$('.container p.ftleft').waypointSynchronise('.text_container h2.ftleft','500px','ftleft-finished',200);
		$('.container a.ftleft').waypointSynchronise('.text_container h2.ftleft','500px','ftleft-finished',400);

		if($(window).width() > 1400){
			$('.shop_mini_section span.ftleft_pos:first-child').waypointInit('ftleft_pos_finished', ($(window).height() + 250) + 'px',0);
			$('.shop_mini_section span.ftleft_pos:nth-child(2)').waypointInit('ftleft_pos_finished',($(window).height() + 250)+ 'px',150);
		}
		else if($(window).width() < 1400){
			$('.shop_mini_section span.ftleft_pos:first-child').waypointInit('ftleft_pos_finished',($(window).height() + 250),0);
			$('.shop_mini_section span.ftleft_pos:nth-child(2)').waypointInit('ftleft_pos_finished',($(window).height()  + 250),150);
		}

	}

	if($('.navigation_wrap.home').length){
		$('.navigation_wrap').waypoint(function(direction){
			if(direction === 'down'){
				$(this).addClass('sticky');
			}
			else if(direction === 'up'){
				$(this).removeClass('sticky');
			}
		},{offset : -1});
	}
	function preventDefault(e) {
	  e = e || window.event;
	  if (e.preventDefault)
	      e.preventDefault();
	  e.returnValue = false;  
	}
	function keydown(e) {
	    for (var i = keys.length; i--;) {
	        if (e.keyCode === keys[i]) {
	            preventDefault(e);
	            return;
	        }
	    }
	}
	function wheel(e) {
	  preventDefault(e);
	}
	function disable_scroll() {
	  if (window.addEventListener) {
	      window.addEventListener('DOMMouseScroll', wheel, false);
	  }
	  window.onmousewheel = document.onmousewheel = wheel;
	  document.onkeydown = keydown;
	}
	function enable_scroll() {
	    if (window.removeEventListener) {
	        window.removeEventListener('DOMMouseScroll', wheel, false);
	    }
	    window.onmousewheel = document.onmousewheel = document.onkeydown = null;  
	}

	// globale variables
	var next = $('.parallax_container.type1').next(),
	collBanner1 = $('.parallax_container.type1 .collection_banner');

	if(next.length){
		next.waypoint(function(direction){
			if(direction === "down"){
				collBanner1.removeClass('fixed');
			}else if(direction === "up"){
				collBanner1.addClass('fixed');
			}
		},{offset : 300 });
	}

	if($('.bottom_arrow').not(".lb").length){
	$('.bottom_arrow').not(".lb").waypoint(function(direction){
		var curr = $(this);
		if(direction === "down"){
			curr.addClass('out');
            $('.new_collection').css({'position':'fixed'});
            $('.new_collection').stop().animate({'top' : '61px'},1000,function(){

                $('.new_collection .ftleft').addClass('ftleft-finished');
            });

		}
		else if(direction === "up"){
			curr.removeClass('out');
            $('.new_collection .ftleft').removeClass('ftleft-finished');
            $('.new_collection').stop().animate({'top' : '1500px'},1000,function(){

            });
		}
	},{offset:400});
	}
	$('.parallax_container ul li').each(function(){

		$(this).waypoint(function(direction){
			if(direction === 'down'){

                if (! $(this).hasClass('bottom-in-view')){
                    $(this).addClass('bottom-in-view');
                    disable_scroll();
                    if (! $(this).hasClass('locked')){
                        $(this).addClass('locked');
                        $(window).scrollTop($(this).offset().top - $('.navigation_wrap').height() + 250)
                    } else{

                        $('.parallax_container ul li').removeClass('locked');
                        $('.text_container.mercedes').removeClass('locked')
                    }

                    setTimeout(enable_scroll,1000);
                } else{
                    $('.parallax_container ul li').removeClass('bottom-in-view');
                }
			}
		},{offset : 40});

        $(this).waypoint(function(direction){
            if(direction === 'up'){
                $(this).removeClass('locked');
            }
        },{offset : 0});

	});
	if($('.text_container.mercedes').length){
    $('.text_container.mercedes').waypoint(function(direction){
        if(direction === 'down'){

            if (! $(this).hasClass('bottom-in-view')){
                $(this).addClass('bottom-in-view');
                disable_scroll();
                if (! $(this).hasClass('locked')){
                    $(this).addClass('locked');
                    /*$(window).animate(
                        {
                            'scrollTop': ($(this).offset().top - $('.navigation_wrap').height())
                        }, 10000,  function() {
                            // Animation complete.
                        });
                        */
                    $(window).scrollTop($(this).offset().top - $('.navigation_wrap').height()- 40);
                } else{

                    $('.text_container.mercedes').removeClass('locked');
                }

                setTimeout(enable_scroll,1000);
            } else{
                $(this).removeClass('bottom-in-view');
            }
        } else {
            $(this).removeClass('bottom-in-view');
			$(this).removeClass('locked');
        }
    },{offset : 180});

	$.waypoints('refresh');
	}
	// submenu
	function subMenu(){
	var mContainer = $('nav[role="navigation"] .menu'),
		sMenu = $('.secondary_nav .secondary_menu'),
		fHeight = 0,
		fsHeight = 0;
	if(mContainer.find('ul').length){
		mContainer.find('ul').each(function(){
			fHeight += $(this).outerHeight();
		});
		fHeight += mContainer.children('li').children('ul').position().top - 22;
		mContainer.closest('nav[role="navigation"]').css('height',fHeight);
	}
	if(sMenu.length){
		fsHeight += sMenu.outerHeight() - 5;
		sMenu.find('ul').each(function(){
			fsHeight += $(this).outerHeight();
		});
		sMenu.closest('.secondary_nav').css('height',fsHeight);
	}
	}
	subMenu();
	$(window).on("resize",subMenu);




    /*lookbook*/
    if($('.lookbook_list').length){
        $(".lookbook_list").owlCarousel({
            items: 2,
            responsive: false,
            slideSpeed: 2500,
            dragBeforeAnimFinish : false,
            addClassActive : true,
            beforeMove : function(){
                $(".lookbook_list").parent().addClass('animating');
            },
            animationFinished : function(){
                $(".lookbook_list").parent().removeClass('animating');
               // $(".lookbook_list").parent().addClass('zooming');
            }
        });
    }
    if($('.lookbook').length){
        var _W = $('.lookbook_list .owl-item').width();
        $(".lookbook").mousewheel(function(event, delta) {

        	$('.bottom_arrow.lb').addClass("out");
            if ($(".lookbook_list").parent().hasClass('animating')){
                event.preventDefault();
                return;
            }

            if ($(".lookbook_list").parent().hasClass('zooming')){
                var img_w = $(".owl-item.active .zoom-image>img").width();
                var left = 0;
                var discr = 30;
                if(delta < 0){

                    var left = parseInt($(".owl-item.active .zoom-image>img").css('left'));

                    if (left <= -(img_w -445)){
                        $(".lookbook_list").trigger('owl.next');
                        $(".lookbook_list").parent().removeClass('zooming');
                        $(".owl-item .zoom-image>img").stop().animate({'left':0},700);
                        event.preventDefault();
                        return;
                    }
                    if ((-(img_w -445) - (left - discr)) > -50){
                        $(".owl-item.active .zoom-image>img").stop().css({'left': -(img_w -445) });
                        event.preventDefault();
                        return;
                    }
                    $(".owl-item.active .zoom-image>img").stop().animate({'left': left - discr},50, function(){
                        if ((-(img_w -445) - (left - discr)) > -30){
                            $(".owl-item.active .zoom-image>img").stop().animate({'left': -(img_w -445) },50);
                        }
                    });

                }else if(delta > 0){
                    var left = parseInt($(".owl-item.active .zoom-image>img").css('left'));

                    if (left == 0){
                        $(".lookbook_list").trigger('owl.prev');
                        $(".lookbook_list").parent().removeClass('zooming');
                        $(".owl-item .zoom-image>img").stop().animate({'left':0},700);
                        event.preventDefault();
                        return;
                    }
                    if (((left + discr)) > -50){
                        $(".owl-item.active .zoom-image>img").stop().css({'left': 0 });
                        event.preventDefault();
                        return;
                    }
                    $(".owl-item.active .zoom-image>img").stop().animate({'left': left + discr},50, function(){
                        if ((-(img_w -445) - (left - discr)) > -30){
                            $(".owl-item.active .zoom-image>img").stop().animate({'left': 0 },50);
                        }
                    });



                    //$(".owl-item.active .zoom-image>img").stop().animate({'left':0},700);


                }


                event.preventDefault();
                return;
            }
            if(delta < 0){
                $(".lookbook_list").trigger('owl.next');
            }else if(delta > 0){
                $(".lookbook_list").trigger('owl.prev');
            }
            $('.lookbook_list .owl-item').animate({'width':_W},300);
            event.preventDefault();
        });
    }
    /*end lookbook*/
	configure_lookbook();

	if($('.lookbook_list .owl-item').length){
		var container = $('.lookbook_list .owl-item');
		container.hover(function(){
			$(this).find('.hover_container').stop().animate({'bottom':'0px'});
		},function(){
			$(this).find('.hover_container').stop().animate({'bottom':'-80px'});
		});
	}

	if($('.share').length){
		$('.share').hover(function(){
			$(this).find('.title').stop().animate({'margin-top':'-67px'});
		},function(){
			$(this).find('.title').stop().animate({'margin-top':'0'});
		});
	}
	// toggle
	if($('.toggle').length){
		$('.toggle').on("click","dt",function(){
			$(this).toggleClass("active");
			$(this).next("dd").slideToggle(300);
		});
	}
	// responsive changes 
	function headeR(){
		var wW = $(window).width(),
			nWrap = $('.navigation_wrap'),
			header = $('[role="banner"]'),
			shop = $('.shop_btn'),
			cList = $(".h_contact_list");
		if( wW < 993) {
			header.before(nWrap);
			nWrap.append(shop);
		}else {
			header.after(nWrap);
			cList.after(shop);
		}
	}
	$(window).on('resize',headeR);
	headeR();

	function rMenu(){
		var menu = $('[role="navigation"]'),
			wW = $(window).width();
		if(wW < 993){
			menu.css('height',"auto");
			var dHeight = $(document).height();
			menu.css('height',dHeight);
		}else{
			menu.removeAttr('style');
		}
	}
	rMenu();
	$(window).on('resize',rMenu);

	$('#menu_button').on('click',function(){
		$(this).toggleClass('active');
		$('[role="navigation"],body').toggleClass('opened');
	});
});


var configure_lookbook = function(){

	if ($('section.lookbook').length > 0) {

			if ($(window).height() < 750){	
			
						$('.lookbook_list .carousel-item ').css({
							'height' : '350px'
						})
						$('header').css({
							'padding' : '10px 0 0px'
						})
			} else {
				$('.lookbook_list .carousel-item ').css({
							'height' : '521px'
						});
						$('header').css({
							'padding' : '20px 0 36px'
						})
			}

		}
}

$(window).resize(function(){


configure_lookbook();
	
		

});
$(window).load(function(){
	$(".toggle_link").click(function(event){
		$(this).toggleClass("active")
		$($(this).attr("data-show")).slideToggle('slow');
		event.preventDefault();
	});
	$(".lookbook_list").trigger('owl.next');
	if($('#single_galery').length){
	$('#single_galery').boutique({
        front_img_width:    320,
        front_img_height:   245,
        autoplay:           true,
        autoplay_interval:  4000,
        front_topmargin:    0,
        behind_topmargin:   100,
        back_topmargin:     100,
        behind_size:        0.3,
        back_size:          0.3,
        behind_distance:    100,
        behind_opacity:     0.4,
        back_opacity:       0.4,
        hovergrowth:        0,
        move_more_directly: true,
        text_opacity:       1
    });
	}
});