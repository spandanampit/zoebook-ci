 // <!-- Document Ready Start -->
/* $(document).ready(function($) {
         $("#owl-example").owlCarousel({
             loop: true,
             margin: 0,
             singleItem: true,
             animateIn: 'fadeIn',
             animateOut: 'fadeOut',
             nav: true,
             autoplay: true,
             items: 1,
             responsiveClass: true,
             responsive: {
                 0: {
                     items: 1,
                     nav: true
                 },
                 400: {
                     items: 1,
                     nav: true
                 },
                 700: {
                     items: 1,
                     nav: false
                 },
                 1000: {
                     items: 1,
                     nav: true,
                     loop: true
                 }
             }
         });
     });*/
     $(document).ready(function($) {             
// function checkPosition() {
//     if (window.matchMedia('(max-width: 767px)').matches) {
//         //...
//     } else {
//         //...
//     }
// }


if ($(window).width() > 768) {
  $(function() {
    $('section.scrollsections').scrollSections({
      createNavigation: false,
      navigation: true
    });
  });

}

if ($(window).width() > 767) {
    
      $(window).scroll(function(){
    if($(document).scrollTop() > 0) {
        $('#scrollsections-navigation').addClass('nav-shrink');
    } else {
        $('#scrollsections-navigation').removeClass('nav-shrink');
    }
  });

  }


    
var $item = $('.carousel-item'); 
var $wHeight = $(window).height();
$item.eq(0).addClass('active');
$item.height($wHeight); 
$item.addClass('full-screen');


//sumbit button onclck
$(document).on("click",'#submit_contact_us',function(event){
     event.preventDefault();
            $('body').toggleClass("loadstate");
            $('#submit_contact_us').attr('disabled','disabled');
             $.ajax({
                url: site_url + 'WS/contact_us_submit/?&name='+$('#contact_name').val()+'&email='+$('#contact_email').val()+'&message_text='+$('#contact_message').val(),
                type: 'get',
                success: function(data) {
                    $('body').toggleClass("loadstate");
                    if(data.settings.success == 1){
                        $('#contact_name').val('');
                        $('#contact_email').val('');
                        $('#contact_message').val('');
                        swal("Success", data.settings.message, "success");
                        $('#submit_contact_us').removeAttr('disabled');
                    }else{
                        swal("Error", data.settings.message, "error");
                        $('#submit_contact_us').removeAttr('disabled');
                    }
                }
            });
});
 

 });

     $.material.init();
     new WOW().init();
