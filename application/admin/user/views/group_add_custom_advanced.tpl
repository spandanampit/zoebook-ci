<div class="form-row row-fluid capability-header label-lt-fix">
    <div class='header-title'>
        <%$this->lang->line('GENERIC_CAPABILITIES')%>
    </div>
</div>
<div class='capability-container'>
    <%if $capability_categories|@is_array && $capability_categories|@count gt 0%>
        <%foreach from=$capability_categories key=key item=val%>    
            <%assign var="capabilty_data" value=$capability_masters[$val['iCapabilityCategoryId']]%>
            <%if $capabilty_data|@is_array && capabilty_data|@count gt 0%>
            <div class="box">
                <div class="title">
                    <h4>
                        <input type="checkbox" class="regular-checkbox parent-category" capabilty-attr="<%$val['iCapabilityCategoryId']%>" name="category[<%$val['iCapabilityCategoryId']%>]" id="category_<%$val['iCapabilityCategoryId']%>" />
                        <label class="right-label-inline" for="category_<%$val['iCapabilityCategoryId']%>" class="right-label-inline">&nbsp;</label>
                        <label class="right-label-inline" for="category_<%$val['iCapabilityCategoryId']%>"><%$val['vCategoryName']%></label>    
                    </h4>
                </div>
                <div class='content capability-content'>
                    <div class="form-row row-fluid label-lt-fix capability-block" id="child_capability_<%$val['iCapabilityCategoryId']%>">
                        <%if $capabilty_data['module']['default']|is_array && $capabilty_data['module']['default']|count gt 0%>
                            <div class='module-default-list'>
                            <%foreach from=$capabilty_data['module']['default'] key=inkey item=inval%>
                                <div class="module-default-item">
                                    <%if $is_admin_group eq true%>
                                        <%assign var="is_selected" value=true%>
                                    <%else%>
                                        <%assign var="is_selected" value=$group_capabilities[$inval['iCapabilityId']][0]|is_array%>
                                    <%/if%>
                                    <input type="checkbox" class="regular-checkbox capability-category" name="capability[<%$inval['iCapabilityId']%>]" id="capability_<%$inval['iCapabilityId']%>" value="<%$inval['iCapabilityId']%>" <%if $is_selected eq true%>checked=checked<%/if%> />
                                    <label class="right-label-inline" for="capability_<%$inval['iCapabilityId']%>" class="right-label-inline">&nbsp;</label>
                                    <label class="right-label-inline" for="capability_<%$inval['iCapabilityId']%>"><%$inval['vCapabilityName']%></label>
                                    <%if $inval['eCapabilityType'] eq 'FormField'%>
                                        <%assign var=cap_json value=$group_capabilities[$inval['iCapabilityId']][0]['tCapabilities']|json_decode:true%>
                                        <div id="capability_json_<%$inval['iCapabilityId']%>" class="capabilities-json <%if $is_selected neq true%>hide<%/if%>">
                                            <input type="radio" class="regular-radio" name="capability_json[<%$inval['iCapabilityId']%>]" id="capability_json_<%$inval['iCapabilityId']%>_editable" value="editable" checked='checked' />
                                            <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_editable" class="right-label-inline">&nbsp;</label>
                                            <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_editable"><%$this->lang->line('GENERIC_EDITABLE')%></label>
                                            &nbsp;&nbsp;
                                            <input type="radio" class="regular-radio" name="capability_json[<%$inval['iCapabilityId']%>]" id="capability_json_<%$inval['iCapabilityId']%>_readonly" value="readonly" <%if $cap_json['access_mode'] eq 'readonly'%>checked='checked'<%/if%> />
                                            <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_readonly" class="right-label-inline">&nbsp;</label>
                                            <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_readonly"><%$this->lang->line('GENERIC_READONLY')%></label>
                                        </div>
                                    <%/if%>
                                </div>
                            <%/foreach%>
                            <div class='clear'></div>
                            </div>
                        <%/if%>
                        <%if $capabilty_data['settings']|is_array && $capabilty_data['settings']|count gt 0%>
                            <%if $capabilty_data['settings']['view']|is_array && $capabilty_data['settings']['view']|count gt 0%>
                                <div class='settings-view-list'>
                                <%foreach from=$capabilty_data['settings']['view'] key=inkey item=inval%>
                                    <div class="settings-view-item">
                                        <%if $is_admin_group eq true%>
                                            <%assign var="is_selected" value=true%>
                                        <%else%>
                                            <%assign var="is_selected" value=$group_capabilities[$inval['iCapabilityId']][0]|is_array%>
                                        <%/if%>
                                        <input type="checkbox" class="regular-checkbox capability-category" name="capability[<%$inval['iCapabilityId']%>]" id="capability_<%$inval['iCapabilityId']%>" value="<%$inval['iCapabilityId']%>" <%if $is_selected eq true%>checked=checked<%/if%> />
                                        <label class="right-label-inline" for="capability_<%$inval['iCapabilityId']%>" class="right-label-inline">&nbsp;</label>
                                        <label class="right-label-inline" for="capability_<%$inval['iCapabilityId']%>"><%$inval['vCapabilityName']%></label>
                                        <%if $inval['eCapabilityType'] eq 'FormField'%>
                                            <%assign var=cap_json value=$group_capabilities[$inval['iCapabilityId']][0]['tCapabilities']|json_decode:true%>
                                            <div id="capability_json_<%$inval['iCapabilityId']%>" class="capabilities-json <%if $is_selected neq true%>hide<%/if%>">
                                                <input type="radio" class="regular-radio" name="capability_json[<%$inval['iCapabilityId']%>]" id="capability_json_<%$inval['iCapabilityId']%>_editable" value="Editable" checked='checked' />
                                                <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_editable" class="right-label-inline">&nbsp;</label>
                                                <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_editable"><%$this->lang->line('GENERIC_EDITABLE')%></label>
                                                &nbsp;&nbsp;
                                                <input type="radio" class="regular-radio" name="capability_json[<%$inval['iCapabilityId']%>]" id="capability_json_<%$inval['iCapabilityId']%>_readonly" value="Readonly" <%if $cap_json['access_mode'] eq 'Readonly'%>checked='checked'<%/if%> />
                                                <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_readonly" class="right-label-inline">&nbsp;</label>
                                                <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_readonly"><%$this->lang->line('GENERIC_READONLY')%></label>
                                            </div>
                                        <%/if%>
                                    </div>
                                <%/foreach%>
                                <div class='clear'></div>
                                </div>
                            <%/if%>
                            <%if $capabilty_data['settings']['update']|is_array && $capabilty_data['settings']['update']|count gt 0%>
                                <div class='settings-update-list'>
                                <%foreach from=$capabilty_data['settings']['update'] key=inkey item=inval%>
                                    <div class="settings-update-item">
                                        <%if $is_admin_group eq true%>
                                            <%assign var="is_selected" value=true%>
                                        <%else%>
                                            <%assign var="is_selected" value=$group_capabilities[$inval['iCapabilityId']][0]|is_array%>
                                        <%/if%>
                                        <input type="checkbox" class="regular-checkbox capability-category" name="capability[<%$inval['iCapabilityId']%>]" id="capability_<%$inval['iCapabilityId']%>" value="<%$inval['iCapabilityId']%>" <%if $is_selected eq true%>checked=checked<%/if%> />
                                        <label class="right-label-inline" for="capability_<%$inval['iCapabilityId']%>" class="right-label-inline">&nbsp;</label>
                                        <label class="right-label-inline" for="capability_<%$inval['iCapabilityId']%>"><%$inval['vCapabilityName']%></label>
                                        <%if $inval['eCapabilityType'] eq 'FormField'%>
                                            <%assign var=cap_json value=$group_capabilities[$inval['iCapabilityId']][0]['tCapabilities']|json_decode:true%>
                                            <div id="capability_json_<%$inval['iCapabilityId']%>" class="capabilities-json <%if $is_selected neq true%>hide<%/if%>">
                                                <input type="radio" class="regular-radio" name="capability_json[<%$inval['iCapabilityId']%>]" id="capability_json_<%$inval['iCapabilityId']%>_editable" value="Editable" checked='checked' />
                                                <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_editable" class="right-label-inline">&nbsp;</label>
                                                <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_editable"><%$this->lang->line('GENERIC_EDITABLE')%></label>
                                                &nbsp;&nbsp;
                                                <input type="radio" class="regular-radio" name="capability_json[<%$inval['iCapabilityId']%>]" id="capability_json_<%$inval['iCapabilityId']%>_readonly" value="Readonly" <%if $cap_json['access_mode'] eq 'Readonly'%>checked='checked'<%/if%> />
                                                <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_readonly" class="right-label-inline">&nbsp;</label>
                                                <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_readonly"><%$this->lang->line('GENERIC_READONLY')%></label>
                                            </div>
                                        <%/if%>
                                    </div>
                                <%/foreach%>
                                <div class='clear'></div>
                                </div>
                            <%/if%>
                        <%/if%>
                        <%if $capabilty_data['others']|is_array && $capabilty_data['others']|count gt 0%>
                            <div class="custom-view-list">
                            <%foreach from=$capabilty_data['others'] key=inkey item=inval%>
                                <div class="custom-view-item">
                                    <%if $is_admin_group eq true%>
                                        <%assign var="is_selected" value=true%>
                                    <%else%>
                                        <%assign var="is_selected" value=$group_capabilities[$inval['iCapabilityId']][0]|is_array%>
                                    <%/if%>
                                    <input type="checkbox" class="regular-checkbox capability-category" name="capability[<%$inval['iCapabilityId']%>]" id="capability_<%$inval['iCapabilityId']%>" value="<%$inval['iCapabilityId']%>" <%if $is_selected eq true%>checked=checked<%/if%> />
                                    <label class="right-label-inline" for="capability_<%$inval['iCapabilityId']%>" class="right-label-inline">&nbsp;</label>
                                    <label class="right-label-inline" for="capability_<%$inval['iCapabilityId']%>"><%$inval['vCapabilityName']%></label>
                                    <%if $inval['eCapabilityType'] eq 'FormField'%>
                                        <%assign var=cap_json value=$group_capabilities[$inval['iCapabilityId']][0]['tCapabilities']|json_decode:true%>
                                        <div id="capability_json_<%$inval['iCapabilityId']%>" class="capabilities-json <%if $is_selected neq true%>hide<%/if%>">
                                            <input type="radio" class="regular-radio" name="capability_json[<%$inval['iCapabilityId']%>]" id="capability_json_<%$inval['iCapabilityId']%>_editable" value="Editable" checked='checked' />
                                            <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_editable" class="right-label-inline">&nbsp;</label>
                                            <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_editable"><%$this->lang->line('GENERIC_EDITABLE')%></label>
                                            &nbsp;&nbsp;
                                            <input type="radio" class="regular-radio" name="capability_json[<%$inval['iCapabilityId']%>]" id="capability_json_<%$inval['iCapabilityId']%>_readonly" value="Readonly" <%if $cap_json['access_mode'] eq 'Readonly'%>checked='checked'<%/if%> />
                                            <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_readonly" class="right-label-inline">&nbsp;</label>
                                            <label class="right-label-inline" for="capability_json_<%$inval['iCapabilityId']%>_readonly"><%$this->lang->line('GENERIC_READONLY')%></label>
                                        </div>
                                    <%/if%>
                                </div>
                            <%/foreach%>
                            </div>
                        <%/if%>
                    </div>
                    <%*
                    <div class="form-row row-fluid label-lt-fix">
                        <div class='text-error'>No capabilities are avialable</div>
                    </div>
                    *%>
                </div>
            </div>
            <%/if%>
        <%/foreach%>
    <%/if%>
</div>