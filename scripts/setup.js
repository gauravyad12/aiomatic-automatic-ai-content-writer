"use strict"; 
jQuery(document).ready(function($) 
{
    $(window).off('beforeunload');
    window.onbeforeunload = function () {return null;};
});