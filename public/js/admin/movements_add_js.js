/** movements module script */
Project.modules.movements = {
    init: function() {
        
        valid_more_elements = [];
        
        
    },
    validate: function (){
        
        $("#frmaddupdate").validate({
            onfocusout: false,
            ignore:".ignore-valid, .ignore-show-hide",
            rules : {
		    "m_status": {
		        "required": true
		    },
		    "m_added_date": {
		        "required": true,
		        "date": true
		    },
		    "m_modified_date": {
		        "required": true,
		        "date": true
		    }
		},
            messages : {
		    "m_status": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.MOVEMENTS_STATUS)
		    },
		    "m_added_date": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.MOVEMENTS_ADDED_DATE),
		        "date": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_VALID_DATE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.MOVEMENTS_ADDED_DATE)
		    },
		    "m_modified_date": {
		        "required": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.MOVEMENTS_MODIFIED_DATE),
		        "date": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_VALID_DATE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.MOVEMENTS_MODIFIED_DATE)
		    }
		},
            errorPlacement : function(error, element) {
                switch(element.attr("name")){
                    
                        case 'm_status':
                            $('#'+element.attr('id')+'Err').html(error);
                            break;
                        case 'm_added_date':
                            $('#'+element.attr('id')+'Err').html(error);
                            break;
                        case 'm_modified_date':
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
        
            $('#m_description').elastic();
            $('#m_device_group_token').elastic();
            
                        $('#m_added_date').datepicker({
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
                            $('#m_added_date').attr('readonly', true);
                        }
                        
            
                        $('#m_modified_date').datepicker({
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
                            $('#m_modified_date').attr('readonly', true);
                        }
                        
    },
    childEvents: function(elem, eleObj){
        
    },
    toggleEvents: function(){
        
    },
    dropdownLayouts:function(elem){
        
    }
}
Project.modules.movements.init();
