
$(document).ready(function() {
  //alert("test");

  $(function() {
    $('.popup-youtube, .popup-vimeo').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
});

  $(".rev-my-button").click(function(e) {
    e.preventDefault();
    $(".remove-video").toggleClass('toggled');
  }); 

    $('#comment-box').emojioneArea({
      pickerPosition: "bottom",
    });

    $('#comment-box2').emojioneArea({
        pickerPosition: "bottom",
    });

    $('#comment-box3').emojioneArea({
       pickerPosition: "bottom"
    });

    $('#comment-box4').emojioneArea({
      pickerPosition: "bottom"
    });

    $('#comment-box5').emojioneArea({
      pickerPosition: "bottom"
   });

   $('#comment-box6').emojioneArea({
     pickerPosition: "bottom"
   });

   $('#comment-box7').emojioneArea({
    pickerPosition: "bottom"
  });

  $('#comment-box8').emojioneArea({
    pickerPosition: "bottom"
  });

  $('#comment-box9').emojioneArea({
    pickerPosition: "bottom"
  });

  $('#comment-box10').emojioneArea({
    pickerPosition: "bottom"
  });

  $('#comment-box11').emojioneArea({
    pickerPosition: "bottom"
  });

  $('#comment-box12').emojioneArea({
    pickerPosition: "bottom"
  });

  $('#comment-box13').emojioneArea({
    pickerPosition: "bottom"
  });

  $('#comment-box14').emojioneArea({
    pickerPosition: "bottom"
  });

  $('#comment-box15').emojioneArea({
    pickerPosition: "bottom"
  });

  $('#comment-box16').emojioneArea({
    pickerPosition: "bottom"
  });


  // $('.fa-ellipsis-vertical').click(function(){
  //   $('.remove-video').toggleClass("red");
  // });
});


$(".box-switch").on("click", () => {
   $("body").toggleClass("dark");
});


// header class add
 $(window).on("scroll", function() {
     if($(window).scrollTop() > 50) {
         $("header").addClass("newheader");
     } else {
        $("header").removeClass("newheader");
     }
 });


// search open close
 $('.search-toggle').addClass('closed');

$('.search-toggle .search-icon').click(function(e) {
  if ($('.search-toggle').hasClass('closed')) {
    $('.search-toggle').removeClass('closed').addClass('opened');
    $('.search-toggle, .search-container').addClass('opened');
    $('#search-terms').focus();
  } else {
    $('.search-toggle').removeClass('opened').addClass('closed');
    $('.search-toggle, .search-container').removeClass('opened');
  }
});


 // click to top
 $(document).ready(function(){
   "use strict";
  var offSetTop = 100;
  var $scrollToTopButton = $('.scrollToTop');
   //Check to see if the window is top if not then display button
   $(window).scroll(function(){
      if ($(this).scrollTop() > offSetTop) {
         $scrollToTopButton.fadeIn();
      } else {
         $scrollToTopButton.fadeOut();
      }
   });
   
   //Click event to scroll to top
   $scrollToTopButton.click(function(){
      $('html, body').animate({scrollTop : 0},800);
      return false;
   });
   
});

 // banner slider

 $('.banner-slider').owlCarousel({
    loop:true,
    margin:0,
    nav:false,
    dots: true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});

$('.banner-slider-comment').owlCarousel({
  loop:true,
  margin:0,
  nav:false,
  dots: true,
  autoplay:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:1,
      },
      1000:{
          items:1,
      }
  }
});

$('.banner-slider-comment-two').owlCarousel({
  loop:true,
  margin:0,
  nav:false,
  dots: true,
  autoplay:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:1,
      },
      1000:{
          items:1,
      }
  }
});

// plalist slider

$('.playlist-slider').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    dots: false,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:3,
        },
        1000:{
            stagePadding: 100,
            items:5,
        }
    }
}); 

// video play

let vid = document.getElementById("myVideo"); 
$(document).ready(function() {
    $("#vidplay").on('click', function(event) {
    var videosrc = $(this).attr('data_src');
    console.log(videosrc);
    if (videosrc == 'pause'){
        vid.play(); 
        $(this).attr('data_src', 'play');

    }
    else if (videosrc == 'play'){
        vid.pause(); 
        $(this).attr('data_src', 'pause');
    }
  
 }); 
}); 


$(document).ready(function(){
    $('#vidplay').on('click', function(){
        $('.video-widget-box').toggleClass('open');
    });
});

// load more
$(document).ready(function(){
  $(".content").slice(0, 5).show();
  $("#loadMore").on("click", function(e){
    e.preventDefault();
    $(".content:hidden").slice(0, 5).slideDown();
    if($(".content:hidden").length == 0) {
      $("#loadMore").text("No Content").addClass("noContent");
      $(".load-more-box").addClass("noContent");
    }
  });  
});

// drop down
$(function(){
  
  $('div.dropdown > a').on('click',function(event){    
    event.preventDefault()    
    $(this).parent().find('ul').first().toggle(300);    
    $(this).parent().siblings().find('ul').hide(200);    
    //Hide menu when clicked outside
    $(this).parent().find('ul').mouseleave(function(){  
      var thisUI = $(this);
      $('html').click(function(){
        thisUI.hide();
        $('html').unbind('click');
      });
    });  
  });
});

// video detail banner

const video = document.getElementById("video");
const circlePlayButton = document.getElementById("circle-play-b");

function togglePlay() {
    if (video.paused || video.ended) {
        video.play();
    } else {
        video.pause();
    }
}

// circlePlayButton.addEventListener("click", togglePlay);
// video.addEventListener("playing", function () {
//     circlePlayButton.style.opacity = 0;
// });
// video.addEventListener("pause", function () {
//     circlePlayButton.style.opacity = 1;
// });



// $('.back-button').backButton();


// dasboard menu open close
$(".mobile-dash").on("click", (event) => {
    event.stopPropagation();
   $(".sidebar").toggleClass("show");
   $("body").addClass("hidden");
   $(".sidebar").after("<div class='sidebar-backdrop fade show'></div>");
});
$("html").on("click", () => {
    $(".sidebar").removeClass("show");
    $("body").removeClass("hidden");
    $(".sidebar-backdrop").remove(); 
});







// $(document).ready(function() {
//   $("#my-button").click(function() {
//     // $("#content").toggleClass('toggled');
//     alert('sdsd');
//   });
// });