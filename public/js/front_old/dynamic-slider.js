$(document).ready(function() {
	initSwiperSlider();
	initowlSlider();
});

var mobilemode = false;
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
	mobilemode = true;
}


var owl_options_arr = {};
owl_options_arr['items'] = 'hbdata-items';
owl_options_arr['loop'] = 'hbdata-loop';
owl_options_arr['autoplay'] = 'hbdata-autoplay';
owl_options_arr['autoplaySpeed'] = 'hbdata-speed';
owl_options_arr['transitionStyle'] = 'hbdata-style';
owl_options_arr['margin'] = 'hbdata-margin';
owl_options_arr['dots'] = 'hbdata-dots';
owl_options_arr['small-items'] = 'hbdata-small-items';
owl_options_arr['medium-items'] = 'hbdata-medium-items';
owl_options_arr['large-items'] = 'hbdata-large-items';
owl_options_arr['custom-resolution-items'] = 'hbdata-custom-resolution-items';

function initSwiperSlider() {
	for (var i = 1; i < 6; i++) {
		var swiper = $('#swiper-slider-' + i);
		if (swiper.length > 0) {
			var type = swiper.data('type')
			if (type == 'vertical') {
				var swiper_nav = new Swiper('#swiper-slider-' + i, {
					loop: true,
					direction: 'vertical',
					setWrapperSize: true,
					autoplay: {
						delay: 5000,
						disableOnInteraction: false,
					}
				});
			} else {
				var swiper_nav = new Swiper('#swiper-slider-' + i, {
					loop: true,
					autoplay: {
						delay: 5000,
						disableOnInteraction: false,
					}
				});
			}
		}
	}
}

function initowlSlider() {
	for (var i = 1; i < 6; i++) {
		var owl = $('#owl-carousel-'+i);
		var options = {
			items: 1,
			loop: true,
			margin: 0,
			autoplay: true,
			autoplaySpeed: 1500,
			autoplayHoverPause: false,
			transitionStyle: "fade",
			dots:true,
			nav:true,
			responsive: {
				200: {
					items: 1
				},
				768: {
					items:1
				},
				1024: {
					items: 1
				}
			}
		};
		owlCarouselCustomInit(owl,options);
	}
}

function owlCarouselCustomInit(owl,options){
	if (owl.length > 0) {
		$.each(owl_options_arr,function(index,elem){
			if(typeof(owl.attr(elem)) != 'undefined' && owl.attr(elem) != ''){
				switch(index){
					case 'small-items':
					var value = owl.attr(elem).split('@');
					if(value.length  == 1){
						options['responsive']['200']['items'] =  parseInt(owl.attr(elem))
						options['responsive']['200']['slideBy'] =  parseInt(owl.attr(elem))	
					}else{
						options['responsive']['200']['items'] =  parseInt(value[0]);
						options['responsive']['200']['slideBy'] =  parseInt(value[1]);
					}
					
					break;

					case 'medium-items':
					var value = owl.attr(elem).split('@');
					if(value.length  == 1){
						options['responsive']['768']['items'] =  parseInt(owl.attr(elem));
						options['responsive']['768']['slideBy'] =  parseInt(owl.attr(elem))	
					}else{
						options['responsive']['768']['items'] =  parseInt(value[0]);
						options['responsive']['768']['slideBy'] =  parseInt(value[1])
					}
					
					break;

					case 'large-items':
					var value = owl.attr(elem).split('@');
					if(value.length  == 1){
						options['responsive']['1024']['items'] =  parseInt(owl.attr(elem));
						options['responsive']['1024']['slideBy'] =  parseInt(owl.attr(elem))
					}else{
						options['responsive']['1024']['items'] =  parseInt(value[0]);
						options['responsive']['1024']['slideBy'] =  parseInt(value[1])
					}
					
					break;

					case 'custom-resolution-items':
					var custom_res = owl.attr(elem).split("|||");
					var custom_res_arr;
					for(var inner_item in custom_res){
						
						custom_res_arr=inner_item.split("@");

						if(custom_res_arr.length  == 2){
							options['responsive'][custom_res_arr[0]]['items'] =  parseInt(custom_res_arr[1]);
							options['responsive'][custom_res_arr[0]]['slideBy'] =  parseInt(custom_res_arr[1])	
						}else{
							options['responsive'][custom_res_arr[0]]['items'] =  parseInt(custom_res_arr[1]);
							options['responsive'][custom_res_arr[0]]['slideBy'] =  parseInt(custom_res_arr[2]);
						}


					}
					
					break;

					default:
					if(owl.attr(elem) == 'false'){
						options[index]  = false;
					}else if(owl.attr(elem) == 'true') {
						options[index]  = true;
					}else{
						options[index]  = parseInt(owl.attr(elem));
					}
					break;
				}
			}
		});

		options['rewindNav'] = false;

		if(typeof(owl.attr("hbdata-only-mobile")) != 'undefined' && owl.attr("hbdata-only-mobile") == 'true'){
			if(mobilemode){
				owl.owlCarousel(options);
			}else{
				owl.removeClass('owl-carousel owl-theme');
			}
		}else{
			owl.owlCarousel(options);	
		}
		// setTimeout(function(){
		// 	loadSvgImages();	
		// },100);	
	}
}

$(document).ready(function() {
	if ($('#swiper-slider-custom-1').length > 0) {
		var swiper_nav = new Swiper('#swiper-slider-custom-1', {
			loop: true,
			setWrapperSize: true,
			autoplay: {
				delay: 5000,
				disableOnInteraction: false,
			},
			slidesPerView: 4,
			slidesPerGroup: 1,
			navigation: {
				nextEl: '.swiper-button-next-cus',
				prevEl: '.swiper-button-prev-cus',
			}
		});
	}

	
	if ($('.anim-1').length > 0) {
		$('.anim-1').text_animation({
			animation_style: 'fadeInLeft',
			selector: 'sub_text',
			sync_selector: '.anim-2',
			char_delay: 100,
			p_el_delay: 1000,
			s_el_delay: 800,
		});
	}

	if ($('#owl-carousel-12').length > 0) {
		if (mobilemode) {
			var options = {
				items: 1,
				loop: true,
				dots: false,
				margin: 10,
				autoplay: true,
				autoplayHoverPause: true,
				autoplaySpeed: 500,
				responsive: {
					200: {
						items: 2,
						slideBy: 1

					},
					768: {
						items: 2,
						slideBy: 1
					},
					1024: {
						items: 3,
						slideBy: 1
					}
				}
			};
			owlCarouselCustomInit($('#owl-carousel-12'),options);
		} else {
			$('#owl-carousel-12').removeClass();
		}
	}


	/*slider for only mobile solution sec*/
	if ($('#owl-carousel-qa-testing').length > 0) {
		if (mobilemode) {
			var options = {
				items: 5,
				loop: false,
				dots: false,
				margin: 10,
				autoplay: false,
				autoplayHoverPause: false,
				slideTransition: 'linear',
				autoplaySpeed: 2000,
				nav: true,
				responsive: {
					200: {
						items: 5,
						slideBy: 1

					},
					768: {
						items: 6,
						slideBy: 1
					},
					1024: {
						items: 6,
						slideBy: 1
					}
				}
			};
			owlCarouselCustomInit($('#owl-carousel-qa-testing'),options);
		} else {
			$('#owl-carousel-qa-testing').removeClass('owl-carousel owl-theme');
		}
	}
	$('#owl-carousel-qa-testing').find('.item').click(function() {
		$('#owl-carousel-qa-testing').find('a.active').removeClass('active');
		$('#owl-carousel-qa-testing').find('.owl-item.active').removeClass('active');
	});
	/*slider for only mobile solution sec ends*/

});

/*profolio slider starts*/
$(document).ready(function() {
	//portfolio-sec  //portfolio-slide-outer
	var height = parseInt($('.portfolio-slide-outer').css('height'));
	var applyheight = height/2 + 'px';
	$('.portfolio-slide-outer').css('margin-top','calc(50% - '+applyheight+')');

	var owl = $('#portfolio-slider');
	var option = {
		items: 1,
		loop: true,
		margin: 10,
		autoplay: 2000,
		nav:true,
		autoplayHoverPause: true,
	}
	if(!mobilemode){
		option['animateIn'] = 'fadeInRight';
	}
	owl.owlCarousel(option);
	owl.on('changed.owl.carousel', function(e) {
		if(mobilemode){
            //var animateType = "slideIn";
            var animateType = "fadeIn";
        }else{
        	var animateType = "fadeInLeft";
        }
        $('.active-img').hide().removeClass();
        $('#img'+e.page.index).show();
        $('#img'+e.page.index).addClass('active-img animated '+animateType);
    });
});
/*profolio slider ends*/


/*dynamic accordion.js start*/
$(document).ready(function() {
	getAccordion("#process-tabs", 768, 'process-sec');
	getAccordion("#tabsfocus", 768, 'area-of-focus-sec');


	$('.panel-collapse').not('.added-fn').on('shown.bs.collapse', function (e) {
    var $panel = $(this).closest('.panel');
	if($('body').scrollTop() > $panel.offset().top || $('hmtl').scrollTop() > $panel.offset().top){
			$('html,body').animate({
				scrollTop: $panel.offset().top - 83
		},300); 
	}
	});
	$('.panel-collapse').addClass('added-fn');
});


var hb_tabcnt = 0;

function getAccordion(element_id, screen, parent) {

	if ($(window).width() < screen && $(element_id).length > 0 && mobilemode) {

		var concat = '';
		obj_tabs = $(element_id + " li").toArray();
		obj_cont = $('#' + parent).find(".tab-pane").toArray();
		obj_parant_id = $("#" + parent).find('.accordion').attr("id");
		console.log(obj_parant_id);
		if (typeof obj_parant_id == 'undefined' || obj_parant_id == "") {
			obj_parant_id = "hbaccordian-" + hb_tabcnt;
			$("#" + parent).find('.accordion').attr("id", obj_parant_id);
		}
		jQuery.each(obj_tabs, function(n, val) {
			concat += '<div id="' + hb_tabcnt + '" class="panel panel-default">';
			concat += '<div class="panel-heading" role="tab" id="heading' + hb_tabcnt + '">';
			concat += '<h4 class="panel-title"><a class="tab-title-arrow collapsed" role="button" data-toggle="collapse" data-parent="#' + obj_parant_id + '" href="#collapse' + hb_tabcnt + '" aria-expanded="false" aria-controls="collapse' + hb_tabcnt + '">' + val.innerText + '</a></h4>';
			concat += '</div>';
			concat += '<div id="collapse' + hb_tabcnt + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + hb_tabcnt + '" data-parent="#' + obj_parant_id + '">';
			concat += '<div class="panel-body">' + obj_cont[n].innerHTML + '</div>';
			concat += '</div>';
			concat += '</div>';
			hb_tabcnt++;
		});
		$("#" + parent).find('.accordion').html(concat);
		$("#" + parent).find('.accordion').find('.panel-collapse:first').addClass("show");
		$("#" + parent).find('.accordion').find('.panel-title a:first').attr("aria-expanded", "true");
		$(element_id).remove();
		$("#" + parent).find(".tab-content").remove();
		
		/*$('.panel-collapse').not('.added-fn').on('shown.bs.collapse', function (e) {
			var $panel = $(this).closest('.panel');
			if($('body').scrollTop() > $panel.offset().top || $('hmtl').scrollTop() > $panel.offset().top){
				$('html,body').animate({
					scrollTop: $panel.offset().top - 83
				},300); 
			}
		});
		$('.panel-collapse').addClass('added-fn')
		});*/
	}
}

$(document).ready(function(){
	if($('.cmn-link-to-video').length){
		var $playObj = "<div class='video-popup-box popup'><div class='content-popup'> <span class='video-close close' id='x'></span><div class='video-play-box'><iframe id='video_player_box' width='750' height='450' frameborder='0' allowfullscreen=''></iframe></div></div></div>";
		$('body').append($playObj);
	}
	var cmn_play_video_url = '//www.youtube.com/embed/###?rel=0&autoplay=1&enablejsapi=1';
	var cmn_video_overlay = $('<div id="overlay"></div>');
	$('.video-close').click(function() {
		$('.video-popup-box').hide();
		cmn_video_overlay.appendTo(document.body).remove();
		var iframe_video_box = document.getElementsByTagName("iframe")[0].contentWindow;
		iframe_video_box.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
		$('#video_player_box').attr('src', '');
		return false;
	});

	$('.cmn-link-to-video').click(function() {
		var req_video_url = cmn_play_video_url.replace('###', $(this).attr("data-id"));

		$('#video_player_box').attr('src', req_video_url);
		cmn_video_overlay.show();
		cmn_video_overlay.appendTo(document.body);
		$('.video-popup-box').show();
		return false;
	});
});

$(document).ready(function(){
	if($('#officebtn').length > 0){
		$('#officebtn').click(function(){
			$('#officebtn').addClass('active');
			$('#clientbtn').removeClass('active');
			$("#cli-img").fadeOut();
			$("#off-img").fadeIn();
			$('.txt.client').hide();
			$('.txt.office').show();

		});

		$('#clientbtn').click(function(){
			$('#officebtn').removeClass('active');
			$('#clientbtn').addClass('active');
			$("#off-img").fadeOut();
			$("#cli-img").fadeIn();
			$('.txt.office').hide();
			$('.txt.client').show();
		});    
	}
});

var btn = document.getElementById('fltBtn');
var act = document.getElementsByClassName('action');
function fling(){
	if(btn == null){
		return;
	}
	if(btn.children[0].className === 'plus'){
		btn.children[0].className = 'plus textpand';
		btn.className = 'floating-btn boxspand';
		setTimeout(function(){act[0].className = 'action actionive';}, 1)
		setTimeout(function(){act[1].className = 'action actionive';}, 70)
		setTimeout(function(){act[2].className = 'action actionive';}, 140)
    	//setTimeout(function(){act[3].className = 'action actionive';}, 210)
	}else{
		btn.children[0].className = 'plus';
		btn.className = 'floating-btn';
		act[0].className = 'action';
		act[1].className = 'action';
		act[2].className = 'action';
    }
}

/*on hover js for tabs*/
	$(document).ready(function(){
        $('#tabsfocus li a,.tabsfocus li a').on('mouseover',function(){
            $('#tabsfocus li a').removeClass('active');             
            var target = $(this).data('target');
            $(this).addClass('active');
            $(target).parent('.tab-content').find('.tab-pane').removeClass('active show');
            $(target).addClass('active show');
        });
    });
/*on hover js for tabs*/

/*contact us js part*/
$(document).ready(function(){
        if($('#officebtn').length > 0){
            $('#officebtn').click(function(){
                $('#clientbtn').removeClass('active');
                $('#officebtn').addClass('active');

                $("#cli-img").fadeOut();
                $("#off-img").fadeIn();
                $('.txt.client').hide();
                $('.txt.office').show();

            });

            $('#clientbtn').click(function(){
                $('#officebtn').removeClass('active');
                $('#clientbtn').addClass('active');

                $("#off-img").fadeOut();
                $("#cli-img").fadeIn();

                $('.txt.office').hide();
                $('.txt.client').show();
            });    
        }
 });
 
 $(document).ready(function(){
	//<input type="hidden" id="icon-code" value="android_floating_icon">
	if($('#icon-code').length > 0){
		var img_src = $('#icon-code').val();
		var site_url = $('#floating-icon').data('src').replace('floating-icon.png',img_src+'.jpg');
		$('#floating-icon').find('.setting-icon').css('background','url('+site_url+')');
	}
 });
/*contact us js part*/
/*dynamic accordion.js end*/