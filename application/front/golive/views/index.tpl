<style type="text/css">
    .live-screen{
    position:relative;
}

#video-bg {
    position:absolute;
    top: 0;
    left: 0;
    right: 0;
}
.bg-live {
    height: 76vh !important;
}
</style>
<section class="live-sec">
    <div class="container container-2">
        <div class="bg-live">
            <div class="row justify-content-center">
                <div class="col-md-7 col-11">
                    <div class="live-content-box">
                        <form id="frm_golive_start" method="post" action="golive-start-action.html" name="golive_start">
                            <input type="hidden" name="preview_thumb" id="preview_thumb" value=""/>
                            <div class="live-message">
                                <textarea class="form-control" id="post_text" name="post_text" rows="3" placeholder="Describe your live streaming....."></textarea>
                            </div>
                            <button type="submit" class="btn btn-denger go-live-btn" id="btn_golive_start"><i class="fa-solid fa-video"></i> <%$go_live%></button>
                        </form>
                    </div>
                    <div class="live-content">
                        <a href="#"><%$go_live_with_zoebook%></a>
                        <p><%$live_text%></p>
                        <canvas id="canvas" width="640" height="480"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<%$this->js->add_js("front/opentok/golive_start.js")%>
<%$this->js->add_js("front/chat-count.js")%>

