(function($) {

    var GridViewController = function() {

        if (!window.theme_vars.theme_prefix.length) return;
        var shuffle_options = eval('window.' + window.theme_vars.theme_prefix + '_isotope_options');
        if ('object' != typeof shuffle_options) return;

        var grid_container = shuffle_options.wrapper_id;
        var item_selector = shuffle_options.item_selector;
        $('#'+grid_container).imagesLoaded().always(function(){
            $('#'+grid_container).isotope({
                itemSelector: item_selector,
                layoutMode: 'packery',
                packery: {
                    columnWidth: 0
                }
            });
        });
    };
    $(window).gridViewController = new GridViewController();


})(jQuery);