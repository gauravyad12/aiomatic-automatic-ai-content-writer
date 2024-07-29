"use strict";
jQuery(document).ready(function(){
    (function($) {
        function aiGetStringAfterHash() {
            var hash = window.location.hash;
            if (hash.length > 0) {
              return hash.substring(1);
            }
            return '';
        }
        var syncdone1 = sessionStorage.getItem("syncdone1");
        var syncdone2 = sessionStorage.getItem("syncdone2");
        var syncdone3 = sessionStorage.getItem("syncdone3");
        var tabs = $('.nav-tab-wrapper a');
        var tab1 = '';
        var aiGetStringAfterHash = aiGetStringAfterHash();
        if(aiGetStringAfterHash != '')
        {
            var pattern = /^tab-\d+$/;
            if(pattern.test(aiGetStringAfterHash) === true)
            {
                tab1 = aiGetStringAfterHash;
            }
        }
        if(tab1 == '')
        {
            tab1 = 'tab-1';
            var activeTab = localStorage.getItem('active-tab') || tab1;
        }
        else
        {
            var activeTab = tab1;
        }
        $('.tab-content').hide();
        $('#' + activeTab).show();
        if( $('#' + activeTab).length ) 
        {
            $('#' + activeTab).show();
        }
        else
        {
            activeTab = 'tab-1';
            $('#' + activeTab).show();
        }
        if(window.location.search !== undefined && window.location.search.includes('page=aiomatic_admin_settings'))
        {
            if(activeTab == 'tab-15')
            {
                jQuery('#btnSubmit').hide();
            }
            else
            {
                jQuery('#btnSubmit').show();
            }
        }
        $('.nav-tab[href="#' + activeTab + '"]').addClass('aiomatic-nav-tab-active');
        $('.aiomatic-nav-tab[href="#' + activeTab + '"]').addClass('aiomatic-nav-tab-active');
        tabs.on('click', function(e) {
            e.preventDefault();
            var link = $(this).attr('datahref');
            if(link !== undefined && link !== null && link !== '')
            {
                window.location.href = link;
                return;
            }
            var tab = $(this).attr('href').substr(1);
            localStorage.setItem('active-tab', tab);
            $('.tab-content').hide();
            if(window.location.search !== undefined && window.location.search.includes('page=aiomatic_admin_settings'))
            {
                if(tab == 'tab-15')
                {
                    jQuery('#btnSubmit').hide();
                }
                else
                {
                    jQuery('#btnSubmit').show();
                }
            }
            $('#' + tab).show();
            tabs.removeClass('aiomatic-nav-tab-active');
            $(this).addClass('aiomatic-nav-tab-active');
            if($("#aiomatic_sync_files").is(":visible"))
            {
                if(syncdone1 === false || syncdone1 === null)
                {
                    sessionStorage.setItem("syncdone1", true);
                    $('.aiomatic_sync_files').click();
                }
            }
            if($("#aiomatic_sync_batches").is(":visible"))
            {
                if(syncdone3 === false || syncdone3 === null)
                {
                    sessionStorage.setItem("syncdone3", true);
                    $('.aiomatic_sync_batches').click();
                }
            }
            if($("#aiomatic_sync_finetunes").is(":visible"))
            {
                if(syncdone2 === false || syncdone2 === null)
                {
                    sessionStorage.setItem("syncdone2", true);
                    $('.aiomatic_sync_finetunes').click();
                }
            }
        });
        var hashFragment = window.location.hash;
        if(hashFragment !== '')
        {
            var xlink = jQuery('a[href="' + hashFragment + '"]');
            if (xlink.length) 
            {
                xlink.addClass('aiomatic-nav-tab-active');
            }
        }
    })(jQuery);
});