
<%if $this->session->userdata('iUserId') gt 0%>
  <footer class="second-footer">
    <div class="container container-2">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="footer-text-2">
            <p><%$this->config->item('COPYRIGHTED_TEXT')%></p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="footer-social d-flex justify-content-end">
              <ul>
                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
              </ul>
            </div>
        </div>
      </div>
    </div>
  </footer>
<%else%>
  <div class="footer-sticky sticky-bottom">
  <!-- footer section start -->
    <footer class="footer-sec">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="footer-logo">
              <img src="<%$this->config->item('images_url')%>front/new-front-image/logo.png" alt="">
            </div>
            <div class="footer-link">
              <ul>
                <li><a href="<%$this->url->make('content/content/privacypolicy')%>"><%$privacy_policy%></a></li>
                <li><a href="<%$this->url->make('content/content/termsconditions')%>"><%$terms_and_conditions%></a></li>
                <li><a href="<%$this->url->make('content/content/aboutus')%>"><%$about_us%></a></li>
                <!--<li><a href="<%$this->url->make('content/content/staticpage','','code:faq')%>">FAQ</a></li>-->
                <li><a href="<%$this->url->make('content/content/contactus')%>"><%$contact_us%></a></li>
                <li><a href="<%$this->url->make('content/content/homepage')%>"><%$home%></a></li>
                
              </ul>
            </div>
            <div class="footer-social">
              <ul>
                <li><a href="<%$this->config->item('FACEBOOK_LINK')%>" target="_blank" class="fb" title="Facebook" ><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="" target="_blank" class="tw" title="Twitter"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="<%$this->config->item('LINKEDINLINK')%>" class="in" title="Linkedin"><i class="fa-brands fa-linkedin-in"></i></a></li>
                <li><a href="<%$this->config->item('TWITTERLINK')%>" target="_blank" class="tw" title="Twitter" ><i class="fa-brands fa-twitter"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  <!-- footer section end -->
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="footer-text">
              <p><%$this->config->item('COPYRIGHTED_TEXT')%></p>
            </div>              
          </div>
        </div>
      </div>
    </div>
  </div>
<%/if%>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchTermsInput = document.getElementById('search-terms');
        const searchFriendsInput = document.getElementById('searchfriends');
        const mobileSearchIcon = document.querySelector('.mobile-search .search-toggle .icon-search');
        const desktopSearchIcon = document.querySelector('.desktop-search .header-search-btn');

        function toggleSearchIcon(input, icon) {
            input.addEventListener('input', function() {
                if (input.value.length > 0) {
                    icon.style.display = 'none';
                } else {
                    icon.style.display = 'inline-block';
                }
            });
        }

        if (searchTermsInput && mobileSearchIcon) {
            toggleSearchIcon(searchTermsInput, mobileSearchIcon);
        }

        if (searchFriendsInput && desktopSearchIcon) {
            toggleSearchIcon(searchFriendsInput, desktopSearchIcon);
        }
    });
</script>