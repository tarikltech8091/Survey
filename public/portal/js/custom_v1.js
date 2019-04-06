(function($){
    $(function(){
        var site_url = $('.site_url').val();
        $('ul.pagination').hide();
        $('.infinite-scroll').jscroll({
            //debug:true,
            autoTrigger: true,
            loadingHtml: '<img src="'+site_url+'/portal/img/loading.gif" alt="Loading..." />',
            padding:20,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    }); // end of document ready
})(jQuery); // end of jQuery name space