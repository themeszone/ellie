'use strict';

var StickyController = function(){

    this.header = document.querySelector( '.sticky-header' );
    this.last_known_scroll_position = 0;
    this.ticking = false;
    var callBack = this.scrolledEvent.bind(this);
    window.addEventListener('scroll', callBack);

};

StickyController.prototype.toggleView = function(position){
    if ( position > ( this.header.clientHeight / 2) ) {
        this.header.classList.add('out');
    } else {
        this.header.classList.remove('out');
    }
};

StickyController.prototype.scrolledEvent = function(event){
    this.last_known_scroll_position = window.scrollY;
    var _self = this;
    if ( ! this.ticking ) {
        window.requestAnimationFrame(function() {
            _self.toggleView(_self.last_known_scroll_position);
            _self.ticking = false;
        });
        this.ticking = true;
    }
};

document.addEventListener('DOMContentLoaded', function(){
    window.StickyController = new StickyController();
});

