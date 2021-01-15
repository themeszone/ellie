'use strict';

var CartToggler = function(){
  this.toggler = document.querySelector( '.cart-toggler' );
  if ( ( ! this.toggler )
      || (document.body.classList.contains('woocommerce-cart'))
      || (document.body.classList.contains('woocommerce-checkout'))
  ) return;


  this.closeToggler = document.querySelector( '.cart-close' );

  document.body.classList.add('offcanvas-cart-enabled');

  var clickCallBack = this.togglerClick.bind(this);
  this.toggler.addEventListener('click', clickCallBack);
  this.closeToggler.addEventListener('click', clickCallBack);

};

CartToggler.prototype.togglerClick = function(event){
    event.preventDefault();
    event.stopPropagation();
    document.body.classList.toggle('cart-toggled-on');
};

document.addEventListener('DOMContentLoaded', function(){
    window.CartToggler = new CartToggler();
});