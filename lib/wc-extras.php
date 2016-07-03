<?php
/**
* woocommerece-specific functions and definitions.
*
* This file is centrally included from ``.
*
* @package podium
*/

// Discount related to quantity
add_action( 'woocommerce_before_calculate_totals', 'add_custom_price' );
function add_custom_price( $cart_object ) {
  foreach ( $cart_object->cart_contents as $key => $value ) {
    if ( $value['quantity']>=2 && $value['quantity']<5 ) {
      $discount = $value['data']->price * 0.02;
      $value['data']->price = $value['data']->price - $discount;
    }
    elseif ( $value['quantity']>=5 && $value['quantity']<10 ) {
      $discount = $value['data']->price * 0.05;
      $value['data']->price = $value['data']->price - $discount;
    }
    elseif ( $value['quantity']>=10 ) {
      $discount = $value['data']->price * 0.10;
      $value['data']->price = $value['data']->price - $discount;
    } else { ''; }
  }
}
