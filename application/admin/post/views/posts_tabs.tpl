<ul class="nav nav-tabs module-tab-container">
    <li <%if $module_name eq "posts"%> class="active" <%/if%>>
        <a class="tab-item item-posts" 
        <%if $mode eq "Update"%>
            title="<%$this->lang->line('GENERIC_EDIT')%> <%$this->lang->line('POSTS_POSTS')%>"
        <%else%>
            title="<%$this->lang->line('GENERIC_ADD')%> <%$this->lang->line('POSTS_POSTS')%>"
        <%/if%>
        <%if $module_name eq "posts"%> 
            href="javascript://"
        <%else%> 
            href="<%$admin_url%>#<%$this->general->getAdminEncodeURL('post/posts/add')%>|mode|<%$mod_enc_mode['Update']%>|id|<%$this->general->getAdminEncodeURL($parID)%>" 
        <%/if%>
        >
        <%if $mode eq "Add"%>
            <%$this->lang->line('GENERIC_ADD')%> <%$this->lang->line('POSTS_POSTS')%>
        <%else%>
            <%$this->lang->line('GENERIC_EDIT')%> <%$this->lang->line('POSTS_POSTS')%>
        <%/if%>
    </a>
</li>
<li <%if $module_name eq "post_media"%> class="active" <%/if%>>
    <a class="tab-item item-post_media"  title="<%$this->lang->line('POSTS_POST_MEDIA')%> <%$this->lang->line('GENERIC_LIST')%>" 
        <%if $module_name eq "post_media"%> 
            href="javascript://"
        <%elseif $module_name eq "posts"%> 
            <%if $mode eq "Update"%>
                href="<%$admin_url%>#<%$this->general->getAdminEncodeURL('post/post_media/index')%>|parMod|<%$this->general->getAdminEncodeURL('posts')%>|parID|<%$this->general->getAdminEncodeURL($data['iPostId'])%>"
            <%else%>
                href="javascript://" aria-disabled="true" 
            <%/if%>                    
        <%else%> 
            href="<%$admin_url%>#<%$this->general->getAdminEncodeURL('post/post_media/index')%>|parMod|<%$this->general->getAdminEncodeURL('posts')%>|parID|<%$this->general->getAdminEncodeURL($parID)%>" 
        <%/if%>
        >
        <%$this->lang->line('POSTS_POST_MEDIA')%>
    </a>
</li>
<li <%if $module_name eq "post_comments"%> class="active" <%/if%>>
    <a class="tab-item item-post_comments"  title="<%$this->lang->line('POSTS_POST_COMMENTS')%> <%$this->lang->line('GENERIC_LIST')%>" 
        <%if $module_name eq "post_comments"%> 
            href="javascript://"
        <%elseif $module_name eq "posts"%> 
            <%if $mode eq "Update"%>
                href="<%$admin_url%>#<%$this->general->getAdminEncodeURL('post/post_comments/index')%>|parMod|<%$this->general->getAdminEncodeURL('posts')%>|parID|<%$this->general->getAdminEncodeURL($data['iPostId'])%>"
            <%else%>
                href="javascript://" aria-disabled="true" 
            <%/if%>                    
        <%else%> 
            href="<%$admin_url%>#<%$this->general->getAdminEncodeURL('post/post_comments/index')%>|parMod|<%$this->general->getAdminEncodeURL('posts')%>|parID|<%$this->general->getAdminEncodeURL($parID)%>" 
        <%/if%>
        >
        <%$this->lang->line('POSTS_POST_COMMENTS')%>
    </a>
</li>
</ul>            