/** movements_image module script */
Project.modules.movements_image = {
    init: function() {
        
        valid_more_elements = [];
        
        
    },
    validate: function (){
        
        $("#frmaddupdate").validate({
            onfocusout: false,
            ignore:".ignore-valid, .ignore-show-hide",
            rules : {
		    "mi_added_date": {
		        "required": true,
		        "date": true
		    },
		    "mi_modified_date": {
		        "required": true,
		        "date": true
		    },
		    "mi_status": {
		        "required": true
		    }
		},
            messages : {
		    "mi_added_date": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.MOVEMENTS_IMAGE_ADDED_DATE),
		        "date": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_VALID_DATE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.MOVEMENTS_IMAGE_ADDED_DATE)
		    },
		    "mi_modified_date": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.MOVEMENTS_IMAGE_MODIFIED_DATE),
		        "date": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_VALID_DATE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.MOVEMENTS_IMAGE_MODIFIED_DATE)
		    },
		    "mi_status": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.MOVEMENTS_IMAGE_STATUS)
		    }
		},
            errorPlacement : function(error, element) {
                switch(element.attr("name")){
                    
                        case 'mi_added_date':
                            $('#'+element.attr('id')+'Err').html(error);
                            break;
                        case 'mi_modified_date':
                            $('#'+element.attr('id')+'Err').html(error);
                            break;
                        case 'mi_status':
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
        
            
                        $('#mi_added_date').datepicker({
                            dateFormat : 'yy-mm-dd', 
showOn : 'focus', 
changeMonth : true, 
changeYear : true, 
yearRange : 'c-100:c+100',
                            beforeShow: function(input, inst) {
                                var cal = inst.dpDiv;
                                var left = ($(this).offset().left + $(this).outerWidth()) - cal.outerWidth();
                                setTimeout(function() {
                                    cal.css({
                                        'left': left
                                    });
                                }, 10);
                            },
                            onSelect: function(value, inst) {
                                $(this).valid();
                                $(this).trigger('change');
                            } 
                        });
                        if(el_general_settings.mobile_platform){
                            $('#mi_added_date').attr('readonly', true);
                        }
                        
            
                        $('#mi_modified_date').datepicker({
                            dateFormat : 'yy-mm-dd', 
showOn : 'focus', 
changeMonth : true, 
changeYear : true, 
yearRange : 'c-100:c+100',
                            beforeShow: function(input, inst) {
                                var cal = inst.dpDiv;
                                var left = ($(this).offset().left + $(this).outerWidth()) - cal.outerWidth();
                                setTimeout(function() {
                                    cal.css({
                                        'left': left
                                    });
                                }, 10);
                            },
                            onSelect: function(value, inst) {
                                $(this).valid();
                                $(this).trigger('change');
                            } 
                        });
                        if(el_general_settings.mobile_platform){
                            $('#mi_modified_date').attr('readonly', true);
                        }
                        
    },
    childEvents: function(elem, eleObj){
        
    },
    toggleEvents: function(){
        
    },
    dropdownLayouts:function(elem){
        
    }
}
Project.modules.movements_image.init();
