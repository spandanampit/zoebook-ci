<%section name=i loop=$block_users%>
    <li id="block_<%$block_users[i]['u_users_id']%>">
        <div class="cmn-user">
            <i class="cmn-user-img">
                <img src="<%$block_users[i]['u_profile_image']%>" alt="User profile picture">
            </i>
            <h6>
                <span>
                    <%$block_users[i]['u_name']%>
                </span>
            </h6>

        </div>
        <div class="cmn-user-name">
            <h6>
                <span><%$block_users[i]['u_email']%></span>
            </h6>
        </div>
        <div>
            <span>
                <a class="btn btn-danger unblock_user" href="javascript:void(0);"
                    data-userid="<%$block_users[i]['u_users_id']%>" data-nm="<%$block_users[i]['u_name']%>">unblock</a>
            </span>
        </div>
    </li>
<%sectionelse%>
    <p class="no_posts" style="text-align: center;padding: 20px;font-size: 15px;">No Blocked Users.</p>
<%/section%>