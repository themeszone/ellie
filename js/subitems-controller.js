jQuery(document).ready(function($) {
    "use strict";

    var subMenuToggler = function(){
        var parent_items = $('.widget_nav_menu li[class*=has-children], .widget_product_categories li[class*=parent]');
        if (parent_items.length){
            $(parent_items).append('<span class="expand"></span>');
        }

        var togglers = $('.widget_nav_menu li[class*=has-children] > span.expand, .widget_product_categories li[class*=parent] > span.expand');

        if ( togglers.length ) {

            $(togglers).each( function(){
                $(this).on('click', function(){

                    var container = $(this).parent();
                    if ( $(container).hasClass('expanded') ) {
                        var MelementToExpand = $(container).find('ul.children, ul.sub-menu');
                        $(MelementToExpand).removeAttr('style');
                        $(container).toggleClass('expanded');
                    } else {
                        $(container).toggleClass('expanded');
                        var elementToExpand = $(container).find('ul.children, ul.sub-menu');
                        var curElementToExpand = $(container).find('ul.children, ul.sub-menu');
                        var elementToExpandHeight = 0;
                        $(elementToExpand).each(function(){
                            elementToExpandHeight += $(this).get(0).scrollHeight;
                        });
                        $(curElementToExpand).attr('style', 'max-height:'+elementToExpandHeight+'px;');

                    }

                });

            } );

        }
    };

    subMenuToggler();

});
