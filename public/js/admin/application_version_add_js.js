/** application_version module script */
Project.modules.application_version = {
    init: function() {
        
        valid_more_elements = [];
        
        
    },
    validate: function (){
        
        $("#frmaddupdate").validate({
            onfocusout: false,
            ignore:".ignore-valid, .ignore-show-hide",
            rules : {
		    "mav_application_master_id": {
		        "required": true
		    },
		    "mav_version_name": {
		        "required": true
		    },
		    "mav_force_update": {
		        "required": true
		    },
		    "mav_version_number": {
		        "required": true
		    }
		},
            messages : {
		    "mav_application_master_id": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.APPLICATION_VERSION_APPLICATION_TYPE)
		    },
		    "mav_version_name": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.APPLICATION_VERSION_VERSION_NAME)
		    },
		    "mav_force_update": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.APPLICATION_VERSION_FORCE_UPDATE)
		    },
		    "mav_version_number": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.APPLICATION_VERSION_VERSION_NUMBER)
		    }
		},
            errorPlacement : function(error, element) {
                switch(element.attr("name")){
                    
                        case 'mav_application_master_id':
                            $('#'+element.attr('id')+'Err').html(error);
                            break;
                        case 'mav_version_name':
                            $('#'+element.attr('id')+'Err').html(error);
                            break;
                        case 'mav_force_update':
                            $('#'+element.attr('id')+'Err').html(error);
                            break;
                        case 'mav_version_number':
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
        
    },
    childEvents: function(elem, eleObj){
        
    },
    toggleEvents: function(){
        
    },
    dropdownLayouts:function(elem){
        
    }
}
Project.modules.application_version.init();
