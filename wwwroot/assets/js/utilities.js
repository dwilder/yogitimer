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
    
    supportedAudioFormat: function() {
        'use strict';
        var ext = "";
        var aud = document.createElement('audio');
        if ( aud.canPlayType("audio/mp3") == "probably" || aud.canPlayType("audio/mp3") == "maybe" ) {
            ext = "mp3";
        }
        else if ( aud.canPlayType("audio/ogg") == "probably" || aud.canPlayType("audio/ogg") == "maybe" ) {
            ext = "ogg";
        }
        else if ( aud.canPlayType("audio/wav") == "probably" || aud.canPlayType("audio/wav") == "maybe" ) {
            ext = "wav";
        }
        
        return ext;
    },
    
    audioSupport: function() {
        'use strict';
        var format = this.supportedAudioFormat();
        if ( format == "" ) {
            return false;
        }
        return true;
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
