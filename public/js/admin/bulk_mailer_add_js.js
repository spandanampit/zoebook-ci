/** bulk_mailer module script */
Project.modules.bulk_mailer = {
    init: function() {
                $(document).off("click", "[name='selectusers']");
         
        valid_more_elements = [];
        
        
        cc_json_1 = [
	    {
	        "cond_type": "AND",
	        "show_list": [
	            {
	                "id": "mlh_userid"
	            }
	        ],
	        "cond_list": [
	            {
	                "id": "selectusers",
	                "type": "radio_buttons",
	                "oper": "eq",
	                "value": [
	                    "Select"
	                ]
	            }
	        ]
	    }
	];
        cc_json_2 = [
	    {
	        "cond_type": "AND",
	        "hide_list": [
	            {
	                "id": "mlh_userid"
	            }
	        ],
	        "cond_list": [
	            {
	                "id": "selectusers",
	                "type": "radio_buttons",
	                "oper": "eq",
	                "value": [
	                    "All"
	                ]
	            }
	        ]
	    }
	];
        $(document).on("click", "[name='selectusers']", function() {
            checkCCEventValues((cc_json_1).concat(cc_json_2));
        });
    },
    validate: function (){
        
        $("#frmaddupdate").validate({
            onfocusout: false,
            ignore:".ignore-valid, .ignore-show-hide",
            rules : {
		    "selectusers": {
		        "required": true
		    },
		    "mlh_userid": {
		        "required": true
		    },
		    "mlh_email_template_id": {
		        "required": true
		    }
		},
            messages : {
		    "selectusers": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.BULK_MAILER_SELECT)
		    },
		    "mlh_userid": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.BULK_MAILER_SELECT_USERS)
		    },
		    "mlh_email_template_id": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.BULK_MAILER_EMAIL_TEMPLATE)
		    }
		},
            errorPlacement : function(error, element) {
                switch(element.attr("name")){
                    
                        case 'selectusers':
                            $('#selectusersErr').html(error);
                            break;
                        case 'mlh_userid':
                            $('#'+element.attr('id')+'Err').html(error);
                            break;
                        case 'mlh_email_template_id':
                            $('#'+element.attr('id')+'Err').html(error);
                            break;
                    default:
                        printErrorMessage(element, valid_more_elements, error);
                        break;
                }
                
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {                    
                    validator.errorList[0].element.focus();
                }
            },
            submitHandler: function (form) {
                getAdminFormValidate();
                return false;
            }
        });
        
    },
    callEvents: function() {
        this.validate();
        this.initEvents();
        this.toggleEvents();
        callGoogleMapEvents();
        
    },
    callChilds: function(){
        
        callGoogleMapEvents();
    },
    initEvents: function(elem){
        
            
                        if(!$('#mlh_userid').is('input[type=hidden]')){
                            $('#mlh_userid').tokenInput(el_form_settings.token_auto_complete_url+'&unique_name=mlh_userid&mode='+$('#mode').val()+'&id='+$('#id').val(), {
                                minChars : 2, 
preventDuplicates : true, 
propertyToSearch : 'val', 
theme : 'facebook', 
hintText : js_lang_label.GENERIC_TYPE_IN_A_SEARCH_TERM, 
noResultsText : js_lang_label.GENERIC_NO_RESULTS, 
searchingText : js_lang_label.GENERIC_SEARCHING_C46_C46_C46,
                                onAdd: function (item) {
                                  $('#mlh_userid').valid();
                                },
                                onDelete: function (item) {
                                  $('#mlh_userid').valid();
                                },
                                prePopulate: $.parseJSON($('#mlh_userid').attr('aria-token-json'))
                            });
                        }
                        
    },
    childEvents: function(elem, eleObj){
        
    },
    toggleEvents: function(){
        
        pre_cond_code_arr.push((cc_json_1).concat(cc_json_2));
    },
    dropdownLayouts:function(elem){
        
    }
}
Project.modules.bulk_mailer.init();
