
    <!-- dashboard section start -->
    <section class="dashboard-sec movement-sec">
        <div class="container customContainer">
            <div class="row">
                <div class="col-xl-3 col-md-12">
                <%include file="common/navbar.tpl"%>
                </div>
                <div class=" col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="main">
                        <div class="row">
                        <%foreach item=row from=$mymovement%>
                            
                            <!--<%$row|print_r%>-->
                                <div class="col-lg-6 col-md-6">
                                    <div class="image-dash-post mb-3">
                                        <div class="image-dash-post-heading">
                                            <div class="image-dash-post-user">
                                                <div class="image-dash-post-img">
                                                    <img src="<%$row.users_profile_image%>" alt="">
                                                </div>
                                                <div class="image-post-content">
                                                    <!--<p>Initiated By Leader</p>-->
                                                    <h5><%$userinfo.vName%></h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="image-post-vid">
                                            <div class="image-wrapper">
                                                <a href="<%$this->url->make('movement/movement/movementdetails')%>?movement_id=<%$row['movements_id']%>&user_id=<%$userinfo['iUserId']%>">
                                                    <%if $row.get_movement_file neq ''%>
                                                    <img src="<%$row.get_movement_file.0.mi_upload_file%>" alt="">
                                                    <%else%>
                                                    <img src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture">
                                                    <%/if%>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="img-post-title-view">
                                            <div class="title">
                                            <%assign var=posted_text_withouemoji value=removeEmoji($row.movement_name)%>
                                            <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
                                                <h3><%$this->general->displayposttext($posted_text)%></h3>
                                            </div>
                                            <!--<div class="total-view">
                                                630 Members
                                            </div> -->
                                        </div>
                                        <div class="image-post-content">
                                            <%assign var=posted_description_withouemoji value=removeEmoji($row.description)%>
                                            <%assign var=posted_description value=$this->general->truncateChars($posted_description_withouemoji,40)%>
                                            <p><%$this->general->displayposttext($posted_description)%></p>
                                        </div>
                                        <%if $row['users_id'] eq $userinfo['iUserId']%>
                                        <a href="<%$this->url->make('movement/movement/editmovement')%>?movementId=<%$row['movements_id']%>"><button class="btn btn-leave btn-block" fdprocessedid="emi01m"><%$edit%></button></a>
                                        <%else%>
                                        <a href="<%$this->url->make('movement/movement/leave')%>?movement_id=<%$row['movements_id']%>"><button class="btn btn-leave btn-block" fdprocessedid="emi01m"><%$leave%></button></a>
                                        <%/if%>
                                    </div>
                                </div>
                            
                        <%/foreach%>       
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-4">
                            <button class="btn btn-leave btn-block" fdprocessedid="410sqc">
                                <%$view_more%>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- dashboard section end -->
    <a href="https://mydevfactory.com/~sanjib7php/sakil/zoebook/zoebook-new/movement-post.html#" class="scrollToTop" style="display: none;"><i class="fa-solid fa-angle-up"></i></a>
