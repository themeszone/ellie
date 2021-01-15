jQuery(document).ready(function($) {
    "use strict";

    $.fn.extend({ // extending jquery to help us with animate.css animations
        animateCss: function(animationName, callback) {
            var animationEnd = (function(el) {
                var animations = {
                    animation: 'animationend',
                    OAnimation: 'oAnimationEnd',
                    MozAnimation: 'mozAnimationEnd',
                    WebkitAnimation: 'webkitAnimationEnd',
                };

                for (var t in animations) {
                    if (el.style[t] !== undefined) {
                        return animations[t];
                    }
                }
            })(document.createElement('div'));

            this.addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);

                if (typeof callback === 'function') callback();
            });

            return this;
        },
    });

    // Cart toggler animation when product is added to cart

    var togglerAnimate = function(event){
        var toggler = $('a.cart-contents');
        if ( toggler.length ) {
            toggler.animateCss('pulse', function() {
                toggler.removeClass('pulse');
            });
        }
    };

    $('body').on('added_to_cart', togglerAnimate);

});