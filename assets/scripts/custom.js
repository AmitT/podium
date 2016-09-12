'use strict';

// Foundation initialization
$( document ).foundation();

// Loader
$( window ).load(function() {

  // Animate loader off screen
  $( '.se-pre-con' ).addClass( 'fadeout' );
});

//top bar sticky since foundation was buggy
if ( $( '.top-bar' ).length > 0 ) {
    var headerTop = $( '.top-bar' ).offset().top;
    $( window ).scroll( function() {
        if ( $( window ).scrollTop() > headerTop ) {
            $( '.top-bar' ).addClass( 'sticky' );
        }
        else {
            $( '.top-bar' ).removeClass( 'sticky' );
        }
    });
}