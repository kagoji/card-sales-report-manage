/*##########################################
# Sales commission Modal
############################################
*/

jQuery(function(){


    jQuery(".sales_commission").on('click', function(event) {
        var action = jQuery(this).data('action');
        var site_url = jQuery('.site_url').val();
        var request_url = site_url+'/sales/settings-commission/ajax/view?action='+action;

        if(action=='edit'){
            var commission_id = jQuery(this).data('commission_id');
            request_url = site_url+'/sales/settings-commission/ajax/view?action='+action+'&commission_id='+commission_id;
        }

        jQuery.ajax({
            url: request_url,
            type: "get",
            success:function(data){
                jQuery('.modal-body').html(data);
                jQuery("#sales_commission").modal();
            }
        });
    });

});

/*##########################################
# Sales Config Modal
############################################
*/

jQuery(function(){


    jQuery(".sales_config").on('click', function(event) {
        var action = jQuery(this).data('action');
        var site_url = jQuery('.site_url').val();
        var request_url = site_url+'/sales/settings-config-sales/ajax/view?action='+action;

        if(action=='edit'){
            var config_id = jQuery(this).data('config_id');
            request_url = site_url+'/sales/settings-config-sales/ajax/view?action='+action+'&config_id='+config_id;
        }

        jQuery.ajax({
            url: request_url,
            type: "get",
            success:function(data){
                jQuery('.modal-body').html(data);
                jQuery("#sales_config").modal();
            }
        });
    });

});


/*##########################################
# Sales Zone Modal
############################################
*/

jQuery(function(){


    jQuery(".sales_zone").on('click', function(event) {
        var action = jQuery(this).data('action');
        var site_url = jQuery('.site_url').val();
        var request_url = site_url+'/sales/settings-zone/ajax/view?action='+action;

        if(action=='edit'){
            var zone_id = jQuery(this).data('zone_id');
            request_url = site_url+'/sales/settings-zone/ajax/view?action='+action+'&zone_id='+zone_id;
        }

        jQuery.ajax({
            url: request_url,
            type: "get",
            success:function(data){
                jQuery('.modal-body').html(data);
                jQuery("#sales_zone").modal();
            }
        });
    });

});

/*##########################################
# Sales Person Modal
############################################
*/

jQuery(function(){


    jQuery(".sales_person").on('click', function(event) {
        var action = jQuery(this).data('action');
        var site_url = jQuery('.site_url').val();
        var request_url = site_url+'/sales/settings-person-sales/ajax/view?action='+action;

        if(action=='edit'){
            var person_id = jQuery(this).data('person_id');
            request_url = site_url+'/sales/settings-person-sales/ajax/view?action='+action+'&person_id='+person_id;
        }

        jQuery.ajax({
            url: request_url,
            type: "get",
            success:function(data){
                jQuery('.modal-body').html(data);
                jQuery("#sales_person").modal();
            }
        });
    });

});


/*##########################################
# Report History Modal
############################################
*/

jQuery(function(){


    jQuery(".report_history").on('click', function(event) {
        var action = jQuery(this).data('action');
        var site_url = jQuery('.site_url').val();
        var request_url = site_url+'/report-history/ajax/view?action='+action;

        if(action=='edit'){
            var history_id = jQuery(this).data('history_id');
            request_url = site_url+'/report-history/ajax/view?action='+action+'&history_id='+history_id;
        }

        jQuery.ajax({
            url: request_url,
            type: "get",
            success:function(data){
                jQuery('.modal-body').html(data);
                jQuery("#report_history").modal();
            }
        });
    });

});