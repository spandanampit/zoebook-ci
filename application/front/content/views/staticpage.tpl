<div class="page-heading">
    <h2><%$page_title%></h2>
</div>
<div class="page-content-row">
    <div class="container">
        <%if $display_lang eq 'en'%>
            <%include file="static/`$page_code`.tpl"%>
        <%else%>
            <%$page_content%>
        <%/if%>
    </div>
</div>