$(".box-switch").on("click", () => {
        $("body").toggleClass("dark");
});

// header class add
$(window).on("scroll", function () {
        if ($(window).scrollTop() > 50) {
                $("header").addClass("newheader");
        } else {
                $("header").removeClass("newheader");
        }
});

// search open close
$(".search-toggle").addClass("closed");

$(".search-toggle .search-icon").click(function (e) {
        if ($(".search-toggle").hasClass("closed")) {
                $(".search-toggle").removeClass("closed").addClass("opened");
                $(".search-toggle, .search-container").addClass("opened");
                $("#search-terms").focus();
        } else {
                $(".search-toggle").removeClass("opened").addClass("closed");
                $(".search-toggle, .search-container").removeClass("opened");
        }
});

// click to top
$(document).ready(function () {
        "use strict";
        var offSetTop = 100;
        var $scrollToTopButton = $(".scrollToTop");
        //Check to see if the window is top if not then display button
        $(window).scroll(function () {
                if ($(this).scrollTop() > offSetTop) {
                        $scrollToTopButton.fadeIn();
                } else {
                        $scrollToTopButton.fadeOut();
                }
        });

        //Click event to scroll to top
        $scrollToTopButton.click(function () {
                $("html, body").animate({ scrollTop: 0 }, 800);
                return false;
        });
});

// banner slider

$(".banner-slider").owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        dots: true,
        responsive: {
                0: {
                        items: 1,
                },
                600: {
                        items: 1,
                },
                1000: {
                        items: 1,
                },
        },
});

// plalist slider

$(".playlist-slider").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
                0: {
                        items: 1,
                },
                600: {
                        items: 3,
                },
                1000: {
                        stagePadding: 100,
                        items: 1,
                },
        },
});

// video play

let vid = document.getElementById("myVideo");
$(document).ready(function () {
        $("#vidplay").on("click", function (event) {
                var videosrc = $(this).attr("data_src");
                console.log(videosrc);
                if (videosrc == "pause") {
                        vid.play();
                        $(this).attr("data_src", "play");
                } else if (videosrc == "play") {
                        vid.pause();
                        $(this).attr("data_src", "pause");
                }
        });
});

$(document).ready(function () {
        $("#vidplay").on("click", function () {
                $(".video-widget-box").toggleClass("open");
        });
});

// load more
$(document).ready(function () {
        $(".content").slice(0, 5).show();
        $("#loadMore").on("click", function (e) {
                e.preventDefault();
                $(".content:hidden").slice(0, 5).slideDown();
                if ($(".content:hidden").length == 0) {
                        $("#loadMore").text("No Content").addClass("noContent");
                        $(".load-more-box").addClass("noContent");
                }
        });
});

// drop down
$(function () {
        $("div.dropdown > a").on("click", function (event) {
                event.preventDefault();
                $(this).parent().find("ul").first().toggle(300);
                $(this).parent().siblings().find("ul").hide(200);
                //Hide menu when clicked outside
                $(this)
                        .parent()
                        .find("ul")
                        .mouseleave(function () {
                                var thisUI = $(this);
                                $("html").click(function () {
                                        thisUI.hide();
                                        $("html").unbind("click");
                                });
                        });
        });
});

// video detail banner

document.addEventListener("DOMContentLoaded", function () {
        const video = document.getElementById("video");
        const circlePlayButton = document.getElementById("circle-play-b");

        function togglePlay() {
                if (video.paused || video.ended) {
                        video.play();
                } else {
                        video.pause();
                }
        }

        circlePlayButton.addEventListener("click", togglePlay);
        video.addEventListener("playing", function () {
                circlePlayButton.style.opacity = 0;
        });
        video.addEventListener("pause", function () {
                circlePlayButton.style.opacity = 1;
        });
});

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

$(document).ready(function () {
        $("#comment-box").emojioneArea({
                pickerPosition: "bottom",
        });
});

// input file structure change
$('input[name="upload-img"]').on("change", function () {
        readURL(this, $(".file-wrapper")); //Change the image
});

$(".close-btn").on("click", function () {
        //Unset the image
        let file = $('input[name="upload-img"]');
        $(".file-wrapper").css("background-image", "unset");
        $(".file-wrapper").removeClass("file-set");
        file.replaceWith((file = file.clone(true)));
});

//FILE
function readURL(input, obj) {
        if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                        obj.css(
                                "background-image",
                                "url(" + e.target.result + ")"
                        );
                        obj.addClass("file-set");
                };
                reader.readAsDataURL(input.files[0]);
        }
}

document.getElementById("upload_file").addEventListener(
        "change",
        function (event) {
                const files = event.target.files;
                const previewContainer = document.getElementById("preview");
                previewContainer.innerHTML = "";

                Array.from(files).forEach((file, index) => {
                        if (file.type.startsWith("image/")) {
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                        const wrapper =
                                                document.createElement("div");
                                        wrapper.style.display = "inline-block";
                                        wrapper.style.position = "relative";
                                        wrapper.style.margin = "5px";
                                        wrapper.style.width = "120px";
                                        wrapper.style.height = "120px";
                                        wrapper.style.overflow = "hidden";

                                        const img =
                                                document.createElement("img");
                                        img.src = e.target.result;
                                        img.style.width = "100%";
                                        img.style.height = "100%";
                                        img.style.objectFit = "cover";
                                        img.style.borderRadius = "10px";

                                        const removeBtn =
                                                document.createElement("span");
                                        removeBtn.innerHTML = "&times;";
                                        removeBtn.style.position = "absolute";
                                        removeBtn.style.top = "5px";
                                        removeBtn.style.right = "5px";
                                        removeBtn.style.background =
                                                "rgba(0, 0, 0, 0.5)";
                                        removeBtn.style.color = "#fff";
                                        removeBtn.style.cursor = "pointer";
                                        removeBtn.style.padding = "2px 5px";
                                        removeBtn.style.borderRadius = "50%";
                                        removeBtn.style.fontSize = "14px";

                                        removeBtn.addEventListener(
                                                "click",
                                                function () {
                                                        previewContainer.removeChild(
                                                                wrapper
                                                        );
                                                }
                                        );

                                        wrapper.appendChild(img);
                                        wrapper.appendChild(removeBtn);
                                        previewContainer.appendChild(wrapper);
                                };
                                reader.readAsDataURL(file);
                        }
                });
        }
);

var swiper = new Swiper(".swiper-container", {
        loop: true, // Enable looping
        navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
        },
        pagination: {
                el: ".swiper-pagination",
                clickable: true,
        },
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false,
        // },
});

function movement_post_like(post_id) {
        console.log(post_id);
        var url = "<%$this->url->make('movement/movement/like_post')%>";
        console.log("url : " + url);

        $.ajax({
                url: url, // Make sure the `url` variable is properly defined
                type: "POST",
                data: {
                        post_id: post_id,
                        status: 1,
                },
                dataType: "json",
                success: function (response) {
                        console.log("Parsed response:", response);

                        if (response.success == 1) {
                                $("#heart-icon-" + post_id)
                                        .removeClass("far")
                                        .addClass("fas");
                        } else {
                                $("#heart-icon-" + post_id)
                                        .removeClass("fas")
                                        .addClass("far");
                        }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", textStatus, errorThrown);
                        console.log("Full jqXHR object:", jqXHR);
                        console.log("Response text:", jqXHR.responseText);
                },
        });
}

function movement_post_comment(post_id, post_media_id) {
        var formData = new FormData();

        var commentText = $("#comment-box" + post_id).val();
        formData.append("comment_text", commentText);
        console.log(commentText);

        var fileInput = $("#input_media_" + post_id)[0];
        if (fileInput.files.length > 0) {
                formData.append("upload_file", fileInput.files[0]);
        }

        console.log("hitting => this is movement comment ");

        var emoji = $("#post_comment_emoji").val();
        formData.append("post_comment_emoji", emoji);

        formData.append("post_id", post_id);
        formData.append("post_media_id", post_media_id);

        var url = "<%$this->url->make('movement/movement/comment')%>";

        $.ajax({
                url: url,
                type: "POST",
                data: {
                        commentText: commentText,
                        postId: post_id,
                        mediaId: post_media_id,
                },
                dataType: "json",
                success: function (response) {
                        console.log("Parsed response:", response);

                        if (response.success == 1) {
                                $("#heart-icon-" + post_id)
                                        .removeClass("far")
                                        .addClass("fas");
                        } else {
                                $("#heart-icon-" + post_id)
                                        .removeClass("fas")
                                        .addClass("far");
                        }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", textStatus, errorThrown);
                        console.log("Full jqXHR object:", jqXHR);
                        console.log("Response text:", jqXHR.responseText);
                },
        });
}

function openModalWithPostId(postId) {
        document.getElementById("modal_post_id").value = postId;

        // Open the modal
        var myModal = new bootstrap.Modal(
                document.getElementById("postShare"),
                {
                        backdrop: "static",
                        keyboard: false,
                }
        );
        myModal.show();
}

function openComments(post_id) {
        var commentSection = document.getElementById("openComment_" + post_id);

        if (commentSection.style.display === "block") {
                commentSection.style.display = "none";
        } else {
                commentSection.style.display = "block";
        }
}
