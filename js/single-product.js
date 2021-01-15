jQuery(document).ready(function($) {
    "use strict";

    function incDecNumber() {
        $('<div class="quantity-nav"><div class="quantity-button quantity-up"></div><div class="quantity-button quantity-down"></div></div>').insertAfter('form.cart .quantity input.qty');
        $('form.cart .quantity').each(function () {
            var spinner = $(this),
                input = spinner.find('input[type="number"].qty'),
                btnUp = spinner.find('.quantity-up'),
                btnDown = spinner.find('.quantity-down'),
                min = input.attr('min'),
                max = input.attr('max');

            btnUp.click(function () {

                var oldValue = parseFloat(input.val());
                if (oldValue >= parseFloat(max)) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue + 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });

            btnDown.click(function () {
                var oldValue = parseFloat(input.val());
                if (oldValue <= parseFloat(min)) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue - 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });

        });
    }

    var productReviewPopUp = function(){
        var buttonText = 'Write a Review'; //default button text
        if (typeof options.label_write_review != 'undefined') buttonText = options.label_write_review; // if possible get button text with translation
        if ( $('body').hasClass('single-product') ) { // if we are on single product page
            if ( $('#review_form_wrapper').length ){ // if review form exists on the page
                var reviewFormContainer = $('#review_form_wrapper').detach(); // detach it from the DOM
                $('body').append('<div id="review-form-shadow"/></div>'); // add screen shadow to display review form on
                $('body').append('<div id="review-form-popup-container"/>'); // create a container for the review popup
                $('#review-form-popup-container').append('<div class="rf-cont"><a href="#" id="review-form-close"></a></div>');
                $('#review-form-popup-container').find('.rf-cont').append(reviewFormContainer); // add review form to the container
                $('#reviews').find('#comments').after('<div class="review-button-cont"><a id="review-popup-open" class="button" href="#">' + buttonText + '</a></div>'); // add button to show review popup

                if ( $('a#review-popup-open').length ) { // if the button is successfully created
                    var reviewPopUpTrigger = $('a#review-popup-open');
                    $(reviewPopUpTrigger).on('click', function(event){
                        event.preventDefault();
                        $('#page').addClass('blur');
                        $('#review-form-shadow').addClass('open');
                        $('#review-form-popup-container').addClass('opened');
                    });

                }

                if ( $('a#review-form-close').length ) {
                    var reviewPopUpClose = $('a#review-form-close');
                    $(reviewPopUpClose).on('click', function(event){
                        event.preventDefault();
                        $('#page').removeClass('blur');
                        $('#review-form-shadow').removeClass('open');
                        $('#review-form-popup-container').removeClass('opened');
                    });
                }
            }
        }
    };

    incDecNumber();
    productReviewPopUp();

});