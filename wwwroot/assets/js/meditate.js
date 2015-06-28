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
    
    var sendDataToServer = function() {}; // Send the meditation to the server and see if the user needs to log in.
    var meditationSaved = function() {};
    var requestLogin = function() {};
    
    // -------------------- //
    // ---- MEDITATE ------ //
    
    var meditate = function(e) {
        
        if ( typeof e == 'undefined' ) e = window.event;
        
        // Elements
        
        // Values
        var vals = {
            'sections': {},
            'gong': null
        };
        
        // Set variables
        
        
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
                else { // It's a section
                    var n = iname.substr(9, 1); // number
                    var t = iname.substr(13, 4); // type
                    var v = inputs[i].value; // value

                    if ( typeof vals.sections[n] == 'undefined' ) {
                        vals.sections[n] = {};
                    }
                    
                    vals.sections[n][t] = v;
                }
            }
        };
        
        
        // Create the canvas layer (div, canvas, end link)
        var createCanvasLayer = function() {
            var layer = document.createElement('div');
            layer.className = 'modal-visible';
            
            
        }
        
        // Add an event handler to the window to redraw the canvas on resizing
        
        // Add an event handler to the end link to trigger the meditation ending function
        
        
        
        // Ping the server to see if the user is logged in
        
        // Create an audio object for the gong
        
        // Set the canvas size
        
        
        
        // Reset the canvas size and redraw the timer if the screen is resized
        
        
        
        // Draw the timer background
        
        // Draw sections for the preparation and cool down time
        
        // Draw the timer foreground
        
        // Draw the section name at the start of each section
        
        
        
        // Begin the meditation
        var start = function() {
            setValues();
        };
        
        // End the meditation
        
        // Remove the canvas layer
        
        
        
        // Call the function to send the data to the server and store it
        
        // If the user is logged in, show meditation saved. Else, show login or register.
        
        
        
        // Trigger the meditation
        start();
        
        
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
    
    window.onload = function() {
        var meditationForm = document.forms[0];
        U.addEvent( meditationForm, 'submit', meditate );
    }
    
}());