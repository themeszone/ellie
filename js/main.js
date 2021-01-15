( function( $ ) {
    "use strict";

    function useSelect2(){
        var selects = $('.buttons-wrapper .variations select, .woocommerce-ordering select, .dropdown_product_cat, .variations select');
        if ( selects.length && ( typeof $(document).select2 == 'function' ) ) {
            $(selects).select2({
                minimumResultsForSearch: 20
            });
        }
    }

    useSelect2();


    function preventSafariScroll(){
        var is_safari = navigator.userAgent.indexOf("Safari") > -1;
        if ( is_safari ) {
            $(window).on('wheel', function (e) {
                var deltaX = e.originalEvent.deltaX;
                var prevent_right;
                prevent_right = deltaX > 0;
                if ( prevent_right && e.cancelable ) {
                    e.preventDefault();
                }
            });
        }
    }

    preventSafariScroll();

} )( jQuery );
