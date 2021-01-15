(function($) {
    var gallery_container = $('.elementor-image-gallery').find('.gallery');
    $(gallery_container).each(function(){
        var cur_gallery_container = $(this);
        $(cur_gallery_container).imagesLoaded().always(function(){
            $(cur_gallery_container).isotope({
                itemSelector: '.gallery-item',
                layoutMode: 'packery',
                packery: {
                    columnWidth: 0
                }
            });
        });
    });
})(jQuery);