'use strict';

var InViewController = function(){

    if (!window.theme_vars.theme_prefix.length) return;
    var inview_options = eval('window.' + window.theme_vars.theme_prefix + '_inview_options');
    if ('object' != typeof inview_options) return;

    this.itemsContainer = document.querySelector( inview_options.item_container );
    this.gridItems = this.itemsContainer.querySelectorAll( inview_options.item_selector );

    var callback = this.showItemsInViewport.bind(this);
    this.observer = new window.IntersectionObserver(callback,{
        threshold: 0.01,
    });

    for (var i = 0; i < this.gridItems.length; i++){
        this.observer.observe(this.gridItems[i]);
        this.gridItems[i].classList.add('viewport');
    }

};

InViewController.prototype.showItemsInViewport = function(changes){
    changes.forEach( function(change){
        if ( change.isIntersecting ) {
            change.target.classList.add('in');
        }
    });
};

document.addEventListener('DOMContentLoaded', function(){
    window.inViewController = new InViewController();
});

