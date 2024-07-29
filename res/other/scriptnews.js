"use strict";
jQuery( document ).ready(function() {
    jQuery("#wp_coderevonewsdashboard_hide").on('click', function( e ){
        e.preventDefault();
        jQuery("#coderevonewsdashboard-widget-hide").trigger("click");
    });
});