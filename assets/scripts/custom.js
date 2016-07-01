'use strict';

// Foundation initialization
$( document ).foundation();

// Loader
$( window ).load(function() {

  // Animate loader off screen
  $( '.se-pre-con' ).addClass( 'fadeout' );
});

// Lazy load function https://github.com/tvler/lazy-progressive-enhancement
function loadMedia( media, onloadfn, scroll ) {

  var intervals = [];

  // Fires replaceNoscript either on DOMContentLoaded or after
  // @see https://gist.github.com/tvler/8fd53d11ed775ebc72419bb5d96b8696
  // @author tvler
  function onwheneva() {
    replaceNoscript( media );
  }

  document.readyState !== 'loading' ? onwheneva() :
  document.addEventListener( 'DOMContentLoaded', onwheneva );

  function scrollVisibility( img, src, srcset ) {
    var rect = img.getBoundingClientRect(),
    offset = 300;
    if (
      ( rect.bottom >= -offset && rect.top - window.innerHeight < offset ) &&
      ( rect.right >= -offset && rect.left - window.innerWidth < offset )
    ) {
      clearInterval( intervals[src] );
      img.onload = onloadfn;
      srcset && ( img.srcset = srcset );
      img.src = src;
    }
  }

  function replaceNoscript( media ) {
    var noscript, img, src, srcset, parent, i = 0,

    // Smallest data URI image possible for a transparent image
    // @see http://bit.ly/29fYDtR
    // @author layke
    tempSrc = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

    if ( media == null || ( typeof media === 'string' ) ) {
      media = document.body.querySelectorAll( media || 'noscript' );
    } else if ( ! media.length ) {
      media = [media];
    }

    while ( noscript = media[i++] ) {

      // Create an img element in a DOMParser so the image won't load.

      img = ( new DOMParser() ).parseFromString( noscript.textContent, 'text/html' ).body.firstChild;
      parent = noscript.parentElement;

      if ( scroll ) {
        src = img.getAttribute( 'src' );
        srcset = img.getAttribute( 'srcset' );
        img.src = tempSrc;
        img.removeAttribute( 'srcset' );
        parent.replaceChild( img, noscript );
        intervals[src] = setInterval( scrollVisibility, 100, img, src, srcset );
      } else {
        img.onload = onloadfn;
        parent.replaceChild( img, noscript );
      }
    }
  }
}

loadMedia( null, null, true, function() {
  this.classList.add( 'loaded' );
});

// End lazy load function
