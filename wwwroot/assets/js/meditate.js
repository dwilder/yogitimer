(function() {
    'use strict';
    
    if ( ! U.canvasSupport ) {
        return;
    }
    
    var states = [
        'DISPLAY_FORM',
        'MEDITATE',
        'SENDING_DATA',
        'REQUEST_LOGIN',
        'MEDITATION_SAVED'
    ];
    
    var loggedIn = false;
    
    var sendData = function( data ) {
        var layer, inner, content, pimg, img, p, p2, link;
        var createRequestLayer = function() {
            layer = document.createElement('div');
            layer.className = 'modal';
            document.body.appendChild( layer );
            
            inner = document.createElement( 'div' );
            inner.className = 'modal-inner';
            layer.appendChild( inner );
            
            content = document.createElement('div');
            content.className = 'modal-content';
            inner.appendChild( content );
            content.style.opacity = 0;
            
            pimg = document.createElement('p');
            pimg.className = 'meditate-modal-img';
            content.appendChild( pimg );
            
            img = document.createElement('img');
            img.src = '/assets/img/icons/icon_meditate.png';
            pimg.appendChild( img );
            
            p = document.createElement('p');
            p.className = 'meditate-modal-p';
            p.innerHTML = 'Thank you for meditating. Now saving...';
            content.appendChild( p );
            
            p2 = document.createElement('p');
            p2.className = 'modal-link';
            content.appendChild( p2 );
            
            link = document.createElement('a');
            link.className = 'link-button';
            link.innerHTML = 'Cancel';
            p2.appendChild( link );
            
            var i = 0;
            var fadeIn = setInterval( function() {
                i += 0.1;
                content.style.opacity = i;
                if ( i >= 1.0 ) {
                    content.style.opacity = 1;
                    clearInterval( fadeIn );
                }
            }, 20);
            
            U.addEvent( link, 'click', dismissLayer );
        };
        createRequestLayer();

        var dismissLayer = function() {
            var i = 1;
            var fadeOut = setInterval( function() {
                i -= 0.1;
                layer.style.opacity = i;
                if ( i <= 0 ) {
                    clearInterval( fadeOut );
                    layer.parentNode.removeChild( layer )
                }
            }, 20);
        };
        
        
        var ajax = U.getAjaxObject();
        ajax.onreadystatechange = function() {
            if ( ajax.readyState == 4 ) {
                if ( ( ajax.status >= 200 && ajax.status < 300 ) || ( ajax.status == 304 ) ) {
                    layer.parentNode.removeChild(layer);
                    
                    //U.log(ajax.responseText);
                    
                    if ( ajax.responseText == 'LOGIN' ) {
                        requestLogin();
                    }
                    else {
                        dataSaved();
                    }
                }
                else {
                    U.log('Ajax error');
                }
            }
        };
        //U.log('sending...');
        ajax.open( 'POST', 'http://yogitimer.com/meditate', true );
        //ajax.open( 'POST', 'http://meditate.dev/meditate', true );
        ajax.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
        ajax.send( data.join('&') );
        
        //ajax.setRequestHeader( 'Content-Type', 'application/json' );
        //ajax.send( data );
        
    };
    
    //var sendData = function() {}; // Send the meditation to the server and see if the user needs to log in.
    var dataSaved = function() {
        var layer, inner, content, pimg, img, p, p2, link;
        var createMessageLayer = function() {
            layer = document.createElement('div');
            layer.className = 'modal';
            document.body.appendChild( layer );
            layer.style.background = "rgba(56, 52, 69, 0.9)";
            
            inner = document.createElement('div');
            inner.className = 'modal-inner';
            layer.appendChild( inner );
            
            content = document.createElement('div');
            content.className = 'modal-content';
            inner.appendChild( content );
            content.style.opacity = 0;
            
            pimg = document.createElement('p');
            pimg.className = 'meditate-modal-img';
            content.appendChild( pimg );
            
            img = document.createElement('img');
            img.src = '/assets/img/icons/icon_meditate.png';
            pimg.appendChild( img );
            
            p = document.createElement('p');
            p.className = 'meditate-modal-p';
            p.innerHTML = 'This meditation has been added to your journal.';
            content.appendChild( p );
            
            p2 = document.createElement('p');
            p2.className = 'modal-link';
            content.appendChild( p2 );
            
            link = document.createElement('a');
            link.className = 'link-button';
            link.innerHTML = 'Close';
            p2.appendChild( link );
            
            var i = 0;
            var fadeIn = setInterval( function() {
                i += 0.1;
                content.style.opacity = i;
                if ( i >= 1.0 ) {
                    content.style.opacity = 1;
                    clearInterval( fadeIn );
                }
            }, 20);
            
            U.addEvent( link, 'click', dismissLayer );
            //U.log('saved');
            
        };
        
        var dismissLayer = function() {
            var i = 1;
            var fadeOut = setInterval( function() {
                i -= 0.1;
                layer.style.opacity = i;
                if ( i <= 0 ) {
                    clearInterval( fadeOut );
                    layer.parentNode.removeChild( layer )
                }
            }, 20);
        };
        
        createMessageLayer();
    };
    
    var requestLogin = function() {
        var layer, inner, content, pimg, img, p, p2, link, link2, link3;
        var createMessageLayer = function() {
            layer = document.createElement('div');
            layer.className = 'modal';
            document.body.appendChild( layer );
            layer.style.background = "rgba(56, 52, 69, 0.9)";
            
            inner = document.createElement('div');
            inner.className = 'modal-inner';
            layer.appendChild( inner );
            
            content = document.createElement('div');
            content.className = 'modal-content';
            inner.appendChild( content );
            content.style.opacity = 0;
            
            pimg = document.createElement('p');
            pimg.className = 'meditate-modal-img';
            content.appendChild( pimg );
            
            img = document.createElement('img');
            img.src = '/assets/img/icons/icon_meditate.png';
            pimg.appendChild( img );
            
            p = document.createElement('p');
            p.className = 'meditate-modal-p';
            p.innerHTML = 'Thank you for meditating. Login or sign up to save this meditation to your journal.';
            content.appendChild( p );
            
            p2 = document.createElement('p');
            p2.className = 'modal-link';
            content.appendChild( p2 );
            
            link = document.createElement('a');
            link.className = 'link-button';
            link.href = "/login";
            link.innerHTML = 'Login';
            p2.appendChild( link );
            
            link2 = document.createElement('a');
            link2.className = 'link-button';
            link2.href = "/signup";
            link2.innerHTML = 'Sign Up';
            p2.appendChild( link2 );
            
            link3 = document.createElement('a');
            link3.className = 'link-button';
            link3.innerHTML = 'Close';
            p2.appendChild( link3 );
            
            U.addEvent( link3, 'click', dismissLayer );
            //U.log('stored');
            
            var i = 0;
            var fadeIn = setInterval( function() {
                i += 0.1;
                content.style.opacity = i;
                if ( i >= 1 ) {
                    content.style.opacity = 1;
                    clearInterval( fadeIn );
                }
            }, 20);
        };
        
        var dismissLayer = function() {
            var i = 1;
            var fadeOut = setInterval( function() {
                i -= 0.5;
                layer.style.opacity = i;
                if ( i <= 0 ) {
                    clearInterval( fadeOut );
                    layer.parentNode.removeChild( layer )
                }
            }, 20);
        };
        
        createMessageLayer();
    };
    
    // -------------------- //
    // ---- MEDITATE ------ //
    
    var meditate = function(e) {
        
        if ( typeof e == 'undefined' ) e = window.event;
        
        // Elements
        var layer, inner, canvas, context, p, link;
        
        // Assets
    	var gong = new Audio('/assets/aud/gong.' + U.supportedAudioFormat() );
        
        // Dimensions
        var cw, ch, x, y, radius, padding, prep_vals = {}, cool_vals = {};
        
        // Times
        var start_time, now, elapsed, total = 0;
        
        // Values
        var vals = {
            'sections': {},
            'gong': null
        },
        last = 0;
        
        // Current section
        var num = -1, title, section_end_time = 0, started = false, stopped = false;
        
        
        // Get form values
        var setValues = function() {
            var inputs = document.forms[0].elements;
            
            // Iterate over inputs, building an object. Ignore submit.
            for ( var i = 0, count = inputs.length; i < count; i++ ) {
                var iname = inputs[i].name;
                // Check for gong value
                if ( iname == 'gong' ) {
                    vals.gong = inputs[i].value;
                }
                // Ignore submit button
                else if ( inputs[i].type == 'submit' ) {
                    continue;
                }
                // Store section names and times
                else {
                    var n = iname.substr(9, 1); // number
                    var t = iname.substr(13, 4); // type
                    var v = inputs[i].value; // value

                    if ( typeof vals.sections[n] == 'undefined' ) {
                        vals.sections[n] = {};
                    }
                    
                    vals.sections[n][t] = v;
                    
                    if ( t == 'time' ) {
                        total += ( v * 60 ); // Time in seconds
                        last++;
                    }
                }
            }
        };
        
        
        // Create the canvas layer (div, canvas, end link)
        var createCanvasLayer = function() {
            layer = document.createElement('div');
            layer.className = 'modal';
            document.body.appendChild( layer );
            layer.style.opacity = 0;
            
            inner = document.createElement( 'div' );
            inner.className = 'modal-inner';
            layer.appendChild( inner );
            
            canvas = document.createElement('canvas');
            canvas.className = 'meditate-canvas';
            inner.appendChild( canvas );
            
            context = canvas.getContext('2d');
            
            p = document.createElement('p');
            p.className = 'meditate-link';
            inner.appendChild( p );
            
            link = document.createElement('a');
            link.className = 'link-button';
            link.innerHTML = 'End';
            p.appendChild( link );
        
            // End the meditation if the End link is clicked
            // Add an event handler to the end link to trigger the meditation ending function
            U.addEvent( link, 'click', function() { stopped = true } );
            
            // Fade in the layer
            var i = 0;
            var fadeIn = setInterval( function() {
                i += .1;
                layer.style.opacity = i;
                if ( i >= 1 ) {
                    clearInterval( fadeIn );
                }
            }, 20);
        };
        
        // Set the canvas size
        var setDimensions = function() {
            var w = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var h = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
            
            var link_height = p.innerWidth || p.clientHeight;

            // canvas height = height - padding * 3 - link_height + height
            var ch = h - link_height;
            padding = Math.max( 20, ch * 0.04); // Padding is 20px or 4% of height
            
            ch = ch - padding * 3;
            cw = w;
            
            canvas.height = ch;
            canvas.width = cw;
            
            // Center
            x = cw/2;
            y = ch/2;
            
            // Circle radius
            var min = Math.min( cw/2 - 2*padding, ch/2 - 2*padding );
            radius = min - 1;
            
            // Wedge dimensions
            if ( vals.sections[0].name == 'Preparation' && vals.sections[0].time > 0 ) {
                prep_vals.degrees = degrees( vals.sections[0].time * 60 );
                prep_vals.arc_start = (Math.PI/180)*(-90);
                prep_vals.arc_end = (Math.PI/180)*(prep_vals.degrees-90);
                prep_vals.x_start = x;
                prep_vals.y_start = y - radius;
            }
            if ( vals.sections[2].name == 'Cool Down' && vals.sections[2].time > 0 ) {
                cool_vals.degrees = degrees( vals.sections[2].time * 60 );
                cool_vals.arc_start = (Math.PI/180)*(270 - cool_vals.degrees );
                cool_vals.arc_end = (Math.PI/180)*(270);
                cool_vals.x_start = x + Math.cos(cool_vals.arc_start) * radius;
                cool_vals.y_start = y + Math.sin(cool_vals.arc_start) * radius;
            }
        };
        
        
        // Redraw the canvas if the window is resized
        // Add an event handler to the window to redraw the canvas on resizing
        var refreshCanvas = function() {
            setDimensions();
            drawTimer();
            drawSections();
        };
        U.addEvent( window, 'resize', refreshCanvas );
        
        
        
        // Draw the timer background
        var drawTimer = function() {
            context.clearRect( 0, 0, cw, ch );
            
            context.beginPath();
            context.strokeStyle = '#8C8254';
            context.fillStyle = '#D0CFD7';
            context.lineWidth = 4;
            context.arc( x, y, radius, 0, (Math.PI/180)*360, false );
            
            context.stroke();
            context.fill();
            context.closePath();
        };
        
        // Draw segments for the preparation and cool down time
        var drawSections = function() {
            if ( prep_vals.degrees > 0 ) {
                drawWedge( prep_vals.arc_start, prep_vals.arc_end, prep_vals.x_start, prep_vals.y_start, '#746F88' );
            }
            
            if ( cool_vals.degrees > 0 ) {
                drawWedge( cool_vals.arc_start, cool_vals.arc_end, cool_vals.x_start, cool_vals.y_start, '#746F88' );
            }
            
            var current_angle = degrees(elapsed);
            drawWedge( (Math.PI/180)*(-90), (Math.PI/180)*(current_angle-90), x, y - radius, '#383445' );
        }
        
        // Draw a wedge
        var drawWedge = function( arc_start, arc_end, x_start, y_start, color ) {
            context.beginPath();
            context.fillStyle = color;
            context.arc( x, y, radius, arc_start, arc_end, false );
            context.lineTo( x, y );
            context.lineTo( x_start, y_start );
            context.fill();
            context.closePath();
        }
        
        
        // Draw the section name at the start of each section
        
        
        
        // Calculate degrees from time
        var degrees = function(t) {
            return 360 * (t/total);
        };
        
        
        
        
        // Set values for the next section
        var setSection = function(n) {
            title = vals.sections[n].name;
            section_end_time += vals.sections[n].time * 60;
        };
        
        
        // Check the time for the current section
        var checkSection = function() {
            if ( num == -1 || elapsed > section_end_time ) {
                num++;
                setSection( num );
                playGong();
            }
        };
        
        // Play the gong, if it's supposed to be played
        var playGong = function() {
            if ( gong != null ) {
                if ( vals.gong == 'all' || ( vals.gong == 'meditation' && num == 1 ) ) {
                    gong.play();
                }
            }
        }
        
        
        // Start the meditation
        var start = function() {
            started = true;
            start_time = new Date();
            var int = setInterval( function() {
                var now = new Date();
                elapsed = (now - start_time)/1000;
                if ( elapsed >= total || stopped == true ) {
                    clearInterval( int );
                    end();
                }
                
                checkSection();
                drawTimer();
                drawSections();
                
            }, 20 );
        };
        
        // End the meditation. Remove the canvas layer.
        var end = function() {
            layer.parentNode.removeChild( layer );
            
            // Decide whether to attempt to save this meditation
            var duration = elapsed - ( vals.sections[0]['time'] * 60 + 60 ); // At least one minute
            //U.log(duration);
            if ( duration > 0 ) {
            
            //if ( true ) {
                
                // Encode data. Start time, section names and times in minutes (round down), gong setting
                //var data = {
                    //'start_time': start_time,
                    //'sections': {},
                    //'gong': vals.gong
                    //};
                var data = [];
                data.push( encodeURIComponent( 'start_time' ) + '=' + encodeURIComponent( start_time.getTime() ) );
                data.push( encodeURIComponent( 'gong' ) + '=' + encodeURIComponent( vals.gong ) );
            
                var time = 0;
            
                for ( var i = 0; i < last; i++ ) {
                
                    data.push( encodeURIComponent( "sections[" + i + "][name]" ) + '=' + encodeURIComponent(vals.sections[i].name ) );
                    
                    data.push( encodeURIComponent( "sections[" + i + "][time]" ) + '=' + encodeURIComponent( Math.min( vals.sections[i]['time'], Math.max( 0, (elapsed - time) / 60 ) ) ) );
                    
                    //data.sections[i] = {};
                    //data.sections[i]['name'] = vals.sections[i].name;
                    //data.sections[i]['time'] = Math.min( vals.sections[i]['time'], Math.max( 0, (elapsed - time) / 60 ) );
                    //U.log(data.sections[i]['time']);
                    time += vals.sections[i]['time'] * 60;
                }
            
                //data = JSON.stringify( data );
            
                sendData(data);
            }
        };
        
        
        
        // Initialize
        var initialize = function() {
            
            setValues();
            createCanvasLayer();
            setDimensions();
            drawTimer();
            
            start();
            
            /*
            if ( vals.gong != null && U.audioSupport() ) {
                var format = U.supportedAudioFormat();
                
                gong = document.createElement( 'audio' );
                document.body.appendChild( gong );
                var src = "/assets/aud/gong." + format;
                
                gong.setAttribute( "src", src );
                alert( gong.readyState );
                gong.addEventListener( "canplaythrough", start, false );
                
                setTimeout( function() {
                    //alert( 'gong didn\'t load' );
                    if ( started == false ) {
                        gong.removeEventListener( "canplaythrough", start, false );
                        start();
                    }
                }, 5000 );
            }
            else {
                start();
            }
            */
        };
        
        
        // Trigger the meditation
        initialize();
        
        
        if ( e.preventDefault ) {
            e.preventDefault();
        }
        else {
            e.returnValue = false;
        }
        return false;
    };
    
    

    // ---- MEDITATE ------ //
    // -------------------- //
    
    // Check if a save message needs to be displayed
    var removeSaveMessage = function() {
        var div = U.$('meditate-message-saved');
        
        if ( div == null ) {
            return;
        }
        
        div.parentNode.removeChild( div );
    };
    
    window.onload = function() {
        var meditationForm = document.forms[0];
        U.addEvent( meditationForm, 'submit', removeSaveMessage );
        U.addEvent( meditationForm, 'submit', meditate );
    }
    
}());