function $(id) {
	'use strict';
	return document.getElementById(id);
}

function addEvent( obj, type, fn ) {
	'use strict';
	if ( obj && obj.addEventListener ) {
		obj.addEventListener( type, fn, false );
	} else if ( obj && obj.attachEvent ) {
		obj.attachEvent( 'on' + type, fn );
	}
}

function isCanvasSupported() {
	'use strict';
	var canvas = document.createElement('canvas');
	return !!(canvas.getContext && canvas.getContext('2d'));
}

// Create a function that displays a Thank You for Meditating message
// if the User completes the meditation time.
function thankYou() {
	'use strict';
	// Get the element where the message will be displayed.
	var overlay = $('overlay');
	
	// Show the element:
	overlay.style.display = 'block';
	
	// Make the element disappear.
	setTimeout( function() {
		overlay.style.display = 'none';
	}, 10000);
}

function initAll() {
	'use strict';
	var meditationForm = $('meditationForm');
	// Get the form
	if ( isCanvasSupported() ) {
		//meditationForm.onsubmit = noCanvasMeditation;
		addEvent( meditationForm, 'submit', canvasMeditation );
	} else {
		addEvent( meditationForm, 'submit', noCanvasMeditation );
	}
}

window.onload = initAll;