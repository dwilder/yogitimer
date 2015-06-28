var U = {
    
    $: function( id ) {
        'use strict';
        return document.getElementById( id );
    },
    
    addEvent: function( target, type, callback ) {
        'use strict';
        if ( target && target.addEventListener ) {
            target.addEventListener( type, callback, false );
        }
        else if ( target && target.attachEvent ) {
            target.attachEvent( 'on' + type, callback );
        }
    },
    
    canvasSupport: function() {
        'use strict';
        var canvas = document.createElement( 'canvas' );
        return !!( canvas.getContext && canvas.getContext( '2d' ) );
    },
    
    getAjaxObject: function() {
        var ajax = null;
        if ( window.XMLHttpRequest ) {
            ajax = new XMLHttpRequest();
        }
        else if ( window.ActiveXObject ) {
            ajax = new ActiveXObject('MSXML2.XMLHTTP.3.0');
        }
        return ajax;
    },
    
    log: function( msg ) {
        console.log( msg );
    }
}
