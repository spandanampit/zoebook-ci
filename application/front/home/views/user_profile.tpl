<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
<%if $errormsg neq ''%>
<div>
  <div class="container">
    <div id="notfound">
      <div class="notfound">
        <div class="notfound-404">
          <h1>OOPS!</h1>
        </div>
        <h2><%$errormsg%></h2>
        <a href="<%$this->url->make('home/home/my_profile')%>">Go To Homepage</a>
      </div>
    </div>
  </div>
</div>
<%else%>
<%$this->js->add_js("front/userprofile.js")%>
<div class="post-pages dashboard-sec">
    <div class="container">
    <%if ($this->session->flashdata('error'))%>
    <div class="alert alert-danger">
        <%$this->session->flashdata('error')%>
    </div>
   <%/if%>
        <div class="row">
            <div class="col-lg-3 user-info-block">
                <div class="user-open" style="display:none;">
                    <i class="far fa-user"></i>
                </div>
                <!--User info start here-->
                <%include file="common/user_info.tpl"%>
                <!--User info End here-->
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <!--Profile cover block start here-->
                        <%include file="common/profile_cover.tpl"%>
                        <!--Profile cover block End here-->
                    </div>
                    <div class="col-lg-8" style="margin-top: 35px !important;">
                        <input type="hidden" id="cr_pg" value="<%$cr_pg%>"/>
                        <input type="hidden" id="nx_pg" value="<%$nx_pg%>"/>
                        <input type="hidden" id="page_type" name="page_type" value="other_profile"/>
                        <input type="hidden" id="other_user_id" name="other_user_id" value="<%$other_user_id%>"/>
                        <!--Feed list start here-->
                        <div id="feed_list">
                              <%include file="common/feed_list.tpl"%>
                        </div>
                        <!--Feed list End here-->
                    </div>
                    <div class="col-lg-4">
                        <div class="sugested-video-box right-panel" style="border-radius: 15px;">
                                <h3>Suggested </h3>              
                                <div class="suggested-wrapper user-listing">
                                    <!--suggestions start here-->
                                    <%include file="common/suggestions.tpl"%>
                                    <!--suggestions End here-->
                                </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
<%/if%>
<!-- Follower Modal Popup -->
<div class="modal fade cmn-modal" id="followModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Follower List</h5>
            </div>
            <div class="modal-body">
                <div class="follow-friend-block scrollbarContent">
                    <div class="follow-friend-list">
                        <%include file="common/user_follower_modal.tpl" followarr=$userfollower%>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Following Modal Popup -->
<div class="modal fade cmn-modal" id="followingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Following List</h5>
            </div>
            <div class="modal-body">
                <div class="follow-friend-block scrollbarContent">
                    <div class="follow-friend-list">
                        <%include file="common/user_follower_modal.tpl" followarr=$userfollowing%>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<%include file="common/common_editpost.tpl" %>
<script>
      let loading = false;
      let pageIndex = 2;
      const scrollThreshold = 900;

      window.addEventListener('scroll', function() {
            const scrollTop = window.scrollY;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            const scrolledHeight = scrollTop + windowHeight;
            
            if ((documentHeight - scrolledHeight) <= scrollThreshold && !loading) {
                  loading = true;
                  console.log('User is near the bottom. Triggering AJAX call...');
                  
                  const params = {
                        page_index: pageIndex,
                        viral_feed: 1,
                        user_id: $('#other_user_id').val(),
                  };
                  
                  $.ajax({
                  url: '/user_profile_posts_scroll_feed',
                  method: 'GET',
                  dataType: 'json',
                  data: params,
                  success: function(response) {
                        if (response.success) {
                              $('#feed_list').append(response.html_content);
                              $(document).trigger('newContentLoaded');
                              pageIndex++;
                        } else {
                              console.log(response.message);
                        }
                  loading = false;

                  },
                  error: function(xhr, status, error) {
                        console.error('Error loading data:', error);
                  },
                  complete: function() {
                        loading = false;
                  }
                  });
            }
      });
</script>
<%$this->js->add_js("front/posts.js")%>