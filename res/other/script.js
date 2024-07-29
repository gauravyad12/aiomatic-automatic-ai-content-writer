"use strict";
jQuery( document ).ready(function() {
    jQuery("#wp_coderevodashboard_hide").on('click', function( e ){
        e.preventDefault();
        jQuery("#coderevodashboard-widget-hide").trigger("click");
    });
});