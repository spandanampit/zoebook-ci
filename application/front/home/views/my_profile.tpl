<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
<%$this->js->add_js("front/myprofile.js")%>
<div class="post-pages dashboard-sec" >
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
               <div class="col-lg-8 col-md-7" style="margin-top:45px">
                  <input type="hidden" id="cr_pg" value="<%$cr_pg%>"/>
                  <input type="hidden" id="nx_pg" value="<%$nx_pg%>"/>
                  <input type="hidden" id="page_type" name="page_type" value="my_profile"/>
                  <!--Feed list start here-->
                  <div id="feed_list">
                     <%include file="common/feed_list.tpl"%>
                  </div>
                  <!--Feed list End here-->
               </div>
               <div class="col-lg-4 col-md-5" style="margin-top:14px">
                  <div class="sugested-video-box right-panel" style="border-radius: 15px;">
                        <h3><%$suggested%> </h3>              
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
<%$this->js->add_js("front/posts.js")%>
<script type="text/javascript" src="https://zoebook.mydevfactory.com/public/js/compiled/ee73a5ff120ec765efb4107ac6076528/main_combine.js"></script>
<script>
// C:\Users\letsa\OneDrive\Desktop\zoebook\zoebook\public\js\front\chat.js


let loading = false;
let pageIndex = 2; // Start from page 2, assuming page 1 is already loaded.
const scrollThreshold = 5000;

window.addEventListener('scroll', function() {
   const scrollTop = window.scrollY;
   const windowHeight = window.innerHeight;
   const documentHeight = document.documentElement.scrollHeight;
   const scrolledHeight = scrollTop + windowHeight;
   
   // Check if the user is near the bottom of the page
   if ((documentHeight - scrolledHeight) <= scrollThreshold && !loading) {
      loading = true;
      console.log('User is near the bottom. Triggering AJAX call...');
      
      const params = {
         page_index: pageIndex,
         viral_feed: 1,
      };
      
      $.ajax({
         url: '/profile_posts',
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