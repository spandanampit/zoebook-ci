<!-- dashboard section start -->
<section class="dashboard-sec movement-sec" style="min-height: 53rem;">
<div class="container customContainer">
  <div class="row">
    <div class="col-xl-3 col-md-12">
    <%include file="common/navbar.tpl"%>
    </div>
    <div class=" col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
      <div class="main">
        <div class="comment-img-box movement-banner-cont">
          <img src="<%$movement['get_movements_file'][0]['mi_upload_file']%>" alt="">
          <div class="conten">
            <div class="conten-dis">
              <%assign var=posted_text_withouemoji value=removeEmoji($movement['get_movements']['movement_name'])%>
              <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
              <h3><%$this->general->displayposttext($posted_text)%></h3>

              <%assign var=posted_description_withouemoji value=removeEmoji($movement.get_movements.description)%>
              <%assign var=posted_description value=$this->general->truncateChars($posted_description_withouemoji,40)%>
              <p class="mb-3"><%$this->general->displayposttext($posted_description)%></p>
              <p class="mb-0 green-text">
                Created: January 23, 2024
              </p>
              <p class="mb-0 yellow-text"><%$movement['get_movements']['total_members']%> Members </p>
            </div>
            <!--<%$movement|print_r%>-->
            <div class="conten-btn">
              <a href="<%$this->url->make('movement/movement/join')%>?movement_id=<%$movement['get_movements']['movements_id']%>"><button class="yellow-btn join-btn btn">Join</button></a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</section>
<!-- dashboard section end -->
