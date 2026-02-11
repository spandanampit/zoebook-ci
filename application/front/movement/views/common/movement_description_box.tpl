<div class="col-lg-4 col-md-12" >
    <div class="sugested-video-box no-fixed  mt-3 movement-details-right" style="height: unset; position: sticky;">
    <h2 class="mb-2"><%$description%></h2>
    <%assign var=posted_description_withouemoji value=removeEmoji($movement['get_movements']['description'])%>
    <%assign var=posted_description value=$this->general->truncateChars($posted_description_withouemoji,500)%>
    <p><%$this->general->displayposttext($posted_description)%></p>
    </div>
</div>