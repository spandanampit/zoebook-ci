<%*'Follow','Normal','Post','Live','Comment'*%>
<%section name=i loop=$notifications%>
<li id="notification_<%$notifications[i]['notification_id']%>">
    <div class="notification-box">
        <div class="notification-user">
            <div class="notification-user-img">
                <a href="<%$this->general->setdiplayprofileurl($notifications[i]['user_id'],$notifications[i]['user_name'])%>">
                    <img id="nprofileImage<%$notifications[i]['post_id']%>" src="" alt="Profile Image" width="100" height="100">
                </a>
                <input type="hidden" id="nbase64Image<%$notifications[i]['post_id']%>" value="<%$notifications[i]['user_profile_image']%>">
            </div>
            <%assign var="notification_link" value=""%>
            <%if $notifications[i]['un_type'] eq 'Live' && $notifications[i]['post_id'] gt 0%>
                <%assign var="notification_link" value=$this->general->setdiplayliveposturl($notifications[i]['post_id'])%>
            <%elseif $notifications[i]['post_id'] gt 0%>
                <%assign var="notification_link" value=$this->general->setdiplayposturl($notifications[i]['post_id'], "post")%>
            <%/if%>
            <div class="notification-user-content cmn-user-name" >
                <%if $notification_link neq ''%><a href="<%$notification_link%>"><%/if%>
                <h6><span style="color: gray;"><%$notifications[i]['un_notification_text']%></span></h6>
                <%if $notification_link neq ''%></a><%/if%>
            </div>
        </div>
        <%if $notifications[i]['un_type'] eq 'Follow'%>
            <div class="follow_block_<%$notifications[i]['pending_request_id']%>">
                <a href="javascript://" data-notificationid="<%$notifications[i]['notification_id']%>" data-follow_request_id="<%$notifications[i]['pending_request_id']%>" class="btn btn-primary accept_frequest"><%$accept%></a>
                <a href="javascript://" data-notificationid="<%$notifications[i]['notification_id']%>" data-follow_request_id="<%$notifications[i]['pending_request_id']%>" class="btn btn-secondary reject_frequest"><%$remove%></a>
            </div>
        <%/if%>
        <div class="notification-hour">
            <p class="notifi-time"><%time_elapsed_string($notifications[i]['un_added_date'])%></p>
        </div>
    </div>
</li>
<%sectionelse%>
<p class="no_posts" style="text-align: center;padding: 20px;font-size: 15px;"><%$no_notifications_at_the_moment%></p>
<%/section%>

<script>
    
        // Function to get the value of a URL parameter
    function getParameterByName(name, url) {
        name = name.replace(/[\[\]]/g, '\\$&');
        const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
        const results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    // Function to decode Base64 and set the image URL
    function n_setProfileImage(base64ImageId, profileImageId) {
        console.log(`Setting profile image for ${profileImageId}`);
        const inputElement = document.getElementById(base64ImageId);
        const profileImage = document.getElementById(profileImageId);

        if (inputElement && profileImage) {
            const dynamicUrl = inputElement.value;
            if (dynamicUrl) {
                console.log(`Found dynamic URL: ${dynamicUrl}`);
                const encodedString = getParameterByName('pic', dynamicUrl);
                if (encodedString) {
                    console.log(`Encoded String: ${encodedString}`);
                    const decodedUrl = atob(encodedString);
                    console.log(`Decoded URL: ${decodedUrl}`);
                    profileImage.src = decodedUrl;
                } else {
                    console.error(`No encoded string found in the URL for ${base64ImageId}`);
                }
            } else {
                console.error(`No dynamic URL found for ${base64ImageId}`);
            }
        } else {
            if (!inputElement) {
                console.error(`Input element not found: ${base64ImageId}`);
            }
            if (!profileImage) {
                console.error(`Profile image element not found: ${profileImageId}`);
            }
        }
    }

    // Loop through each suggestion and set the profile image
    if (!window.n_base64Elements_newf) {
    // Declare the variable only if it's not already declared
    const n_base64Elements_newf = document.querySelectorAll("[id^='nbase64Image']");
    n_base64Elements_newf.forEach(element => {
        const postId = element.id.replace('nbase64Image', ''); // Extract post_id from the id
        console.log(`Processing postId: ${postId}`);
        n_setProfileImage(`nbase64Image${postId}`, `nprofileImage${postId}`);
    });
}


    function closeModal() {
        var modal = document.getElementById('createPost');
        modal.classList.remove('show');
        modal.style.display = 'none';
        var modalBackdrop = document.getElementsByClassName('modal-backdrop');
        document.body.removeChild(modalBackdrop[0]);
    }
</script>
