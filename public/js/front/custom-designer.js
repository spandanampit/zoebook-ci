$(document).ready(function() {

  // Media slider
  $('.media-slider').owlCarousel({
    loop: true,
    margin: 10,
    items: 1,
    dots:true,
    nav:false,
    video:true,
    autoHeight:true,
    navText: [
      '<i class="fas fa-angle-left"></i>',
      '<i class="fas fa-angle-right"></i>'
    ],
  });

  // SVG Images to Cods
  $('img.svg').each((i, e) => {
    const $img = $(e);
    const imgID = $img.attr('id');
    const imgClass = $img.attr('class');
    const imgURL = $img.attr('src');
    $.get(imgURL, (data) => {
        // Get the SVG tag, ignore the rest
        let $svg = $(data).find('svg');
        // Add replaced image's ID to the new SVG
        if (typeof imgID !== 'undefined') {
            $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if (typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', `${imgClass}replaced-svg`);
        }
        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');
        // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
        if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
            $svg.attr(`viewBox 0 0  ${$svg.attr('height')} ${$svg.attr('width')}`);
        }
        // Replace image with new SVG
        $img.replaceWith($svg);
    }, 'xml');
  });

  // Profile upload coad
  $("#imageUpload").change(function(data){
    var imageFile = data.target.files[0];
    var reader = new FileReader();
    reader.readAsDataURL(imageFile);

    reader.onload = function(evt){
      $('#imagePreview').attr('src', evt.target.result);
      $('#imagePreview').hide();
      $('#imagePreview').fadeIn(650);
    }
  });

  // Profile progress circle
  (function($) {
    $('.post-circle').circleProgress({
      size: 50,
      //value: 0.9,
      fill: '#f27373',
      startAngle: -Math.PI  / 4 * 0,
    });
  })(jQuery);

  // Like and unlike code
  /*$(".like-post").click(function() {
    $(".like-post i").removeClass("far");
    $(".like-post i").addClass("fas");
    $(this).addClass("active");
  });*/

  // Custom Scrollbar
  /*(function($){
    $(window).on("load",function(){

      $(".follow-friend-block").mCustomScrollbar({
        theme:"dark",
        scrollbarPosition:"outside",
      });

    });
  })(jQuery);*/

  // Reply comment
  $('.reply-link').click(function(){
      $(this).parent().find('.reply-comment-box').slideToggle();
  });



  $('.navbar-toggler').click(function(){
    $('nav.main-menu').toggleClass("open-menu");
    $('body').toggleClass("overlay");
  });

  $('.user-open').click(function(){
    $('.user-info-block').toggleClass('open-user-info-block');
    //$(this).hide();
  });

  $('.user-friends').click(function(){
    $(".online-friend-list").toggleClass('open-online-friend-list');
  });

});






