
<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<%$this->css->css_src()%>
<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}

    .fade-in {
      animation: fadeIn 3s;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .swiper-container {
    width: 100%;
    height: auto;
    overflow: hidden;
    }

    .image-wrapper {
    width: 100%;
    height: 0;
    padding-bottom: 100%; /* Creates a square aspect ratio */
    position: relative;
    overflow: hidden;
    }

    .image-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    }

    .swiper-button-next, .swiper-button-prev {
    width: 30px; /* Adjust width */
    height: 30px; /* Adjust height */
    background-size: 20px 20px; 
    color:black;
}

.swiper-button-next::after, .swiper-button-prev::after {
    font-size: 16px; /* Adjust the icon font size */
}
</style>
<section class="dashboard-sec movement-sec">
    <div class="container customContainer">
        <div class="row">
            <div class="col-xl-3 col-md-12">
            <%include file="common/navbar.tpl"%>
            </div>
            <div class=" col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                <div class="main">
                    <div class="row">
                    <%foreach item=row from=$popularmovement%>

                        <div class="col-lg-4 col-md-6">
                            <div class="image-dash-post mb-3">
                                <div class="image-dash-post-heading">
                                    <div class="image-dash-post-user">
                                        <div class="image-dash-post-img">
                                            <img src="<%$row['users_profile_image']%>" alt="">
                                        </div>
                                        <div class="image-post-content">
                                            <p><%$initiated_by_leader%></p>
                                            <h5><%$row['users_name']%></h5>
                                        </div>
                                    </div>

                                </div>

                                <div class="image-post-vid">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                            <%if !empty($row.get_movement_file)%>
                                                <%foreach item=file from=$row.get_movement_file%>
                                                <div class="swiper-slide">
                                                    <div class="image-wrapper">
                                                    <a href="<%$this->url->make('movement/movement/movementjoin')%>?movement_id=<%$row['movements_id']%>">
                                                        <%if !empty($file)%>
                                                            <img src="<%$file['mi_upload_file']%>" alt="">
                                                        <%else%>
                                                            <img src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture">
                                                        <%/if%>
                                                    </a>
                                                    </div>
                                                </div>
                                                <%/foreach%>
                                            <%else%>
                                                <div class="swiper-slide">
                                                    <div class="image-wrapper">
                                                            <img src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture">
                                                    </div>
                                                </div>
                                            <%/if%>
                                        </div>
                                
                                        <!-- Add Pagination -->
                                        <div class="swiper-pagination"></div>
                                    
                                        <!-- Add Navigation -->
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                                <div class="img-post-title-view">
                                    <div class="title">
                                    <%assign var=posted_text_withouemoji value=removeEmoji($row.movement_name)%>
                                        <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
                                        <h3>
                                        <%$this->general->displayposttext($posted_text)%>
                                        </h3>
                                    </div>
                                    <div class="total-view">
                                        <%$row['total_members']%> <%$members%>
                                    </div>
                                </div>
                                <div class="image-post-content">
                                    <%assign var=posted_description_withouemoji value=removeEmoji($row.description)%>
                                    <%assign var=posted_description value=$this->general->truncateChars($posted_description_withouemoji,40)%>
                                    <p><%$this->general->displayposttext($posted_description)%></p>
                                </div>

                                <%if $row['join_status'] neq 'Inactive'%>
                                    <a href="<%$this->url->make('movement/movement/leave')%>?movement_id=<%$row['movements_id']%>"><button class="btn btn-leave btn-block"><%$leave%></button></a>
                                <%else%>
                                    <a href="<%$this->url->make('movement/movement/join')%>?movement_id=<%$row['movements_id']%>"><button class="btn btn-join btn-block"><%$join%></button></a>
                                <%/if%>
                            </div>
                        </div>
                    <%/foreach%>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                    <button class="btn btn-leave btn-block" id="view-more" data-page="1">
                        <%$view_more%>
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            // pagination: {
            //     el: '.swiper-pagination',
            //     clickable: false,
            // },
        });

        $(document).ready(function() {
            $('#view-more').on('click', function() {
                var pageIndex = $(this).data('page'); // Get the current page index
                var nextPage = pageIndex + 1; // Increment page index for next page

                $.ajax({
                    url: '<%$this->url->make("movement/movement/popularmovement")%>', // Replace with your actual controller path
                    type: 'POST',
                    data: { page_index: nextPage },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        // Assuming the response contains 'popularMovements.popularmovement'
                        if (response.success && response.popularMovements.popularmovement.length > 0) {
                            var movements = response.popularMovements.popularmovement;

                            // Select the container where you want to append the movements
                            var container = $('.main .row').first(); // Target the existing row

                            // Loop through each movement and append the data
                            movements.forEach(function(row) {
                                var displayedText = displayPostText(row.description);
                                var movementHtml = `
                                    <div class="col-lg-4 col-md-6">
                                        <div class="image-dash-post mb-3">
                                            <div class="image-dash-post-heading">
                                                <div class="image-dash-post-user">
                                                    <div class="image-dash-post-img">
                                                        <img src="${row.users_profile_image}" alt="">
                                                    </div>
                                                    <div class="image-post-content">
                                                        <p><%$initiated_by_leader%></p>
                                                        <h5>${row.users_name}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="image-post-vid">
                                                <div class="swiper-container">
                                                    <div class="swiper-wrapper">`;

                                if (row.get_movement_file.length > 0) {
                                    row.get_movement_file.forEach(function(file) {
                                        movementHtml += `
                                            <div class="swiper-slide">
                                                <div class="image-wrapper">
                                                    <a href="<%$this->url->make('movement/movement/movementjoin')%>?movement_id=${row.movements_id}">
                                                        <img src="${file.mi_upload_file}" alt="">
                                                    </a>
                                                </div>
                                            </div>`;
                                    });
                                } else {
                                    movementHtml += `
                                        <div class="swiper-slide">
                                            <div class="image-wrapper">
                                                <img src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture">
                                            </div>
                                        </div>`;
                                }

                                movementHtml += `
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
                                                </div>
                                            </div>
                                            <div class="img-post-title-view">
                                                <div class="title">
                                                    <h3>${row.movement_name}</h3>
                                                </div>
                                                <div class="total-view">
                                                    ${row.total_members} <%$members%>
                                                </div>
                                            </div>
                                            <div class="image-post-content">
                                                <p>${displayedText}</p>
                                            </div>`;

                                if (row.join_status !== 'Inactive') {
                                    movementHtml += `
                                            <a href="<%$this->url->make('movement/movement/leave')%>?movement_id=${row.movements_id}">
                                                <button class="btn btn-leave btn-block"><%$leave%></button>
                                            </a>`;
                                } else {
                                    movementHtml += `
                                            <a href="<%$this->url->make('movement/movement/join')%>?movement_id=${row.movements_id}">
                                                <button class="btn btn-join btn-block"><%$join%></button>
                                            </a>`;
                                }

                                movementHtml += `
                                        </div>
                                    </div>
                                `;

                                // Append the newly created HTML to the container
                                container.append(movementHtml);
                            });

                            // Update the page index data attribute for the next load
                            $('#view-more').data('page', nextPage);
                        } else {
                            // No more data or some error occurred
                            alert('No more movements to load.');
                        }
                    },
                    error: function(error) {
                        console.error('Error loading movements:', error);
                    }
                });
            });
        });


    function removeEmoji(text) {
        return text.replace(/[\u{1F600}-\u{1F64F}]/gu, ''); 
    }

    function truncateText(text, limit) {
        return text.length > limit ? text.substring(0, limit) + '...' : text;
    }

    function displayPostText(text) {
        var cleanText = removeEmoji(text);
        return truncateText(cleanText, 40); // Adjust 40 based on your PHP function
    }

    </script>
