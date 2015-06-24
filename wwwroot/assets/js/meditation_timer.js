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


// Meditate
function meditate(e) {
    
    'use strict';
    
    var modal, modal_inner, canvas, context, link;
	var stopped = false;
    
	var totalTime = 0;
	var elapsed = 0;
	
	// Store dimensions
	var screenHeight, screenWidth, minScreenSide;
	var canvasSide, timerRect, timerWidth;
	var maxTimerSide = 1024;
	var timerPadding = 40;
	var center, radius, innerRadius, lineThickness = 5, degrees;
    
	var times = [
		{
			title: 'Preparation',
			time: $('preparation').value,
			gonged: false
		},
		{
			title: 'Meditation',
			time: $('meditation').value,
			gonged: false
		},
		{
			title: 'Cool Down',
			time: $('cooldown').value
		}
	]
    
	// Calculate the total time
	function calculateTotalTime() {
		for ( var i = 0, count = times.length; i < count; i++ ) {
			totalTime += +times[i].time;
		}
	}
    
    function create( tag, classname ) {
        var element = document.createElement( tag );
        element.className = classname;
        return element;
    }
    
    function createModal() {
        modal = create( 'div', 'modal' );
        modal_inner = create( 'div', 'modal-inner' );
        
        canvas = create( 'canvas', 'meditate-canvas' );
        context = canvas.getContext('2d');
        
        var para = create( 'p', 'meditate-link' );
        link = create( 'a', 'link-button' );
        link.innerHTML = 'End';
    	addEvent( link, 'click', endMeditation );
        
        document.body.appendChild( modal );
        modal.appendChild( modal_inner );
        modal_inner.appendChild( canvas );
        modal_inner.appendChild( para );
        para.appendChild( link );
    }
    
	// Get the canvas size
	function setCanvasSize() {
		// Get the screen height and width
		screenHeight = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
		screenWidth = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
		// Figure out which one is smaller
		minScreenSide = ( screenWidth < screenHeight ) ? screenWidth : screenHeight;
		// Figure out if the timer is at its max size
		if ( (minScreenSide + 2*timerPadding ) > maxTimerSide ) {
			canvasSide = maxTimerSide - 2*timerPadding;
		} else {
			canvasSide = minScreenSide;
		}
		canvas.height = canvasSide;
		canvas.width = canvasSide;
		//logDimensions();
	}
    
	// Draw a circle on the canvas
	function drawTimer() {
		
		// Clear the canvas
		context.clearRect( 0, 0, canvasSide, canvasSide );
		
		center = canvasSide/2;
		radius = center - lineThickness - timerPadding;
		
		// Red circle
		context.beginPath();
		context.strokeStyle = '#8C8255';
		context.fillStyle = '#D0CFD7';
		context.lineWidth = lineThickness;
		context.arc( center, center, radius, (Math.PI/180)*0, (Math.PI/180)*360, false );
		
		context.stroke();
		context.fill();
		context.closePath();
		
		//addTicks();
		
		markTime();
	}
    
	// Mark the time
	function markTime() {
		radius = center - lineThickness - timerPadding;
		degrees = calculateDegrees( elapsed );
		
		// Red circle
		context.beginPath();
		context.fillStyle = '#383445';
		// Outer arc
		context.arc( center, center, radius, (Math.PI/180)*(-90), (Math.PI/180)*(-90 + degrees), false );
		// Line from the outer edge to the center
		context.lineTo( center, center );
		
		// Line from inner edge to start point
		context.lineTo( center, -radius + center );
		
		context.fill();
		context.closePath();
		
	}
	
	// Calculate the degrees around the circle
	function calculateDegrees( t ) {
		return (t/totalTime) * 360;
	}
	
	function start() {
		//gong.play();
		// Record the start time
		var start = new Date();
		var int = setInterval( function() {
			var now = new Date();
			elapsed = (now - start)/1000;
			//console.log( 'elapsed: ' + elapsed );
			drawTimer();
			if ( elapsed >= totalTime || stopped == true ) {
				clearInterval(int);
				//closeMeditation();
			}
			//checkGong();
		}, 20);
	}
	
	function endMeditation(ev) {
		'use strict';
		if (typeof ev == 'undefined') ev = window.event;
		stopped = true;
        modal.parentNode.removeChild(modal);
		// Prevent the default behaviour
		if (ev.preventDefault) {
			ev.preventDefault();
		} else {
			ev.returnValue = false;
		}
		return false;
	}
	
	function redrawCanvas() {
		setCanvasSize();
		drawTimer();
	}
	
	// Watch for resize events to redraw the timer to fit the window
	addEvent( window, 'resize', redrawCanvas );
    
	calculateTotalTime();

    createModal();
    
    setCanvasSize();
    
    start();
    
	// Prevent form submission
	if (e.preventDefault) {
		e.preventDefault();
	} else {
		e.returnValue = false;
	}
	return false;
}

// CANVAS
function canvasMeditation(e) {
	
	'use strict';
	// Get DOM elements
	var modal = $('modal');
	var timer = $('timer');
	var endLink = $('end-meditation'); // Get the End Meditation link element
	
	// Get form values
	var times = [
		{
			title: 'Preparation',
			time: $('p').value,
			gonged: false
		},
		{
			title: 'Meditation',
			time: $('mt').value,
			gonged: false
		},
		{
			title: 'Cool Down',
			time: $('cd').value
		}
	]
	var totalTime = 0;
	calculateTotalTime();
	var elapsed = 0;
	
	// Store dimensions
	var screenHeight, screenWidth, minScreenSide;
	var canvasSide, timerRect, timerWidth;
	var maxTimerSide = 512;
	var timerPadding = 40;
	var center, radius, innerRadius, lineThickness = 5, degrees;
	
	// Create an audio element for the gong sound
	var gong = new Audio('assets/aud/gong.mp3');
	
	// Create the canvas element
	var canvas = createCanvas( 'canvas', timer );
	
	// Get the drawing context
	var context = canvas.getContext('2d');
	setCanvasSize();
	
	// Watch for resize events to redraw the timer to fit the window
	addEvent( window, 'resize', redrawCanvas );
	
	// Set the event handler for the endLink
	addEvent( endLink, 'click', endMeditation );
	
	function closeMeditation() {
		stopped = true;
		gong.play();
		modal.className = 'modal';
		thankYou();
	}
	
	function endMeditation(ev) {
		'use strict';
		if (typeof ev == 'undefined') ev = window.event;
		stopped = true;
		// Prevent the default behaviour
		if (ev.preventDefault) {
			ev.preventDefault();
		} else {
			ev.returnValue = false;
		}
		return false;
	}
	
	// Calculate the total time
	function calculateTotalTime() {
		for ( var i = 0, count = times.length; i < count; i++ ) {
			totalTime += +times[i].time;
		}
	}
	
	// Create a div with an id
	function createCanvas( elementId, parentElement ) {
		if ( $(elementId) ) {
			var elem = $(elementId);
		} else {
			var elem = document.createElement('canvas');
			elem.id = elementId;
			parentElement.appendChild(elem);
		}
		return elem;
	}
	
	function redrawCanvas() {
		setCanvasSize();
		drawTimer();
	}
	
	// Get the canvas size
	function setCanvasSize() {
		// Get the screen height and width
		screenHeight = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
		screenWidth = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
		// Figure out which one is smaller
		minScreenSide = ( screenWidth < screenHeight ) ? screenWidth : screenHeight;
		// Figure out if the timer is at its max size
		if ( (minScreenSide + 2*timerPadding ) > maxTimerSide ) {
			canvasSide = maxTimerSide - 2*timerPadding;
		} else {
			canvasSide = minScreenSide;
		}
		canvas.height = canvasSide;
		canvas.width = canvasSide;
		//logDimensions();
	}
	
	// Log dimensions
	function logDimensions() {
		console.log( 'screenHeight: ' + screenHeight );
		console.log( 'screenWidth: ' + screenWidth );
		console.log( 'minScreenSide: ' + minScreenSide );
		console.log( 'maxTimerSide: ' + maxTimerSide );
		console.log( 'canvasSide: ' + canvasSide );
	}
	
	// Draw a circle on the canvas
	function drawTimer() {
		
		// Clear the canvas
		context.clearRect( 0, 0, canvasSide, canvasSide );
		
		center = canvasSide/2;
		radius = center - lineThickness - timerPadding;
		
		// Red circle
		context.beginPath();
		context.strokeStyle = '#979797';
		context.fillStyle = '#7B0B0B';
		context.lineWidth = lineThickness;
		context.arc( center, center, radius, (Math.PI/180)*0, (Math.PI/180)*360, false );
		
		context.stroke();
		context.fill();
		context.closePath();
		
		// Mustard circle
		radius = center - 20 - timerPadding;
		context.beginPath();
		context.strokeStyle = '#979797';
		context.fillStyle = '#F0CB8E';
		context.lineWidth = lineThickness;
		context.arc( center, center, radius, (Math.PI/180)*0, (Math.PI/180)*360, false );
		
		context.stroke();
		context.fill();
		context.closePath();
		
		addTicks();
		
		markTime();
	}
	
	// Add ticks to mark end of preparation time and beginning of cool down time
	function addTicks() {
		// Add a tick for preparation time
		if ( times[0].time > 0 && elapsed < times[0].time ) {
			drawTick( times[0].time );
		}
		if ( times[2].time > 0 && elapsed < (totalTime - times[2].time) ) {
			drawTick( totalTime - times[2].time );
		}
	}
	
	// Draw a tick
	function drawTick( t ) {
		radius = center - lineThickness - timerPadding;
		innerRadius = radius - 25;
		degrees = calculateDegrees( t );
		
		context.beginPath();
		context.strokeStyle = '#979797';
		context.lineWidth = lineThickness;
		context.moveTo(
			( radius * Math.sin( Math.PI/180 * degrees ) ) + center,
			( -radius * Math.cos( Math.PI/180 * degrees ) ) + center
		);
		context.lineTo(
			( (innerRadius - lineThickness/2) * Math.sin( Math.PI/180 * degrees ) ) + center,
			( -(innerRadius - lineThickness/2) * Math.cos( Math.PI/180 * degrees ) ) + center
		);
		context.stroke();
		context.closePath();
	}
	
	// Mark the time
	function markTime() {
		radius = center - lineThickness - timerPadding;
		innerRadius = radius - 25;
		degrees = calculateDegrees( elapsed );
		
		// Red circle
		context.beginPath();
		context.strokeStyle = '#979797';
		context.fillStyle = 'rgba(255,255,255,0.6)';
		context.lineWidth = lineThickness;
		// Outer arc
		context.arc( center, center, radius, (Math.PI/180)*(-90), (Math.PI/180)*(-90 + degrees), false );
		// Line from the outer edge to the inner edge
		// (x,y)	= (r*sin(theta), r*cos(theta))
		context.lineTo(
			( innerRadius * Math.sin( Math.PI/180 * degrees ) ) + center,
			( -innerRadius * Math.cos( Math.PI/180 * degrees ) ) + center	
		);
		
		// Inner arc
		context.arc( center, center, innerRadius, (Math.PI/180)*(-90 + degrees), (Math.PI/180)*(-90), true );
		
		// Line from inner edge to start point
		context.lineTo(
			center,
			-radius + center
		);
		
		context.stroke();
		context.fill();
		context.closePath();
		
	}
	
	// Calculate the degrees around the circle
	function calculateDegrees( t ) {
		return (t/totalTime) * 360;
	}
	
	// Check to see whether to play the gong
	function checkGong() {
		// Is there a prep time?
		if ( times[0].time > 0 && times[0].gonged == false && elapsed >= times[0].time ) {
			times[0].gonged = true;
			gong.play();
		}
		// Is there a cool down time?
		else if ( times[2].time > 0 && times[1].gonged == false && (totalTime - elapsed) <= ( times[2].time ) ) {
			times[1].gonged = true;
			gong.play();
		}
	}
	
	// Show the modal layer
	function showModal() {
		timer.className = 'modalTimer' ;
		modal.className = 'modal-visible' ;
	}
	
	function meditate() {
		gong.play();
		// Record the start time
		var start = new Date();
		var int = setInterval( function() {
			var now = new Date();
			elapsed = (now - start)/1000;
			//console.log( 'elapsed: ' + elapsed );
			drawTimer();
			if ( elapsed >= totalTime || stopped == true ) {
				clearInterval(int);
				closeMeditation();
			}
			checkGong();
		}, 20);
	}
	
	showModal();
	meditate();
	
	// Prevent form submission
	if (e.preventDefault) {
		e.preventDefault();
	} else {
		e.returnValue = false;
	}
	return false;
}


// NO CANVAS
// Create the function that displays the meditation timer and counts the time.
function noCanvasMeditation(e) {
	'use strict';
	if (typeof e == 'undefined') e = window.event;
	// Make sure the overlay is hidden
	$('overlay').style.display = 'none';
	
	// Get DOM elements
	var modal = $('modal');
	var timer = $('timer');
	var endLink = $('end-meditation');
	var stopped = false;
	
	// Get form values
	var times = [
		{
			title: 'Preparation',
			time: $('p').value
		},
		{
			title: 'Meditation',
			time: $('mt').value
		},
		{
			title: 'Cool Down',
			time: $('cd').value
		}
	]
	
	// Track the sections
	var currentSection = -1;
	
	// Create an audio element for the gong sound
	var gong = new Audio('assets/aud/gong.mp3');
	
	// Make or get divs for the display area
	var timerScale = createDiv( 'timer-scale', timer );
	var progressBar = createDiv( 'progress-bar', timerScale );
	var timerData = createDiv( 'timer-data', timer );
	var sectionTime = createDiv( 'section-time', timerData );
	var sectionTitle = createDiv( 'section-title', timerData );
	var currentDisplayTime = createDiv( 'current-time', timerData );
	var startTime = createDiv( 'start-time', timerData );

	// Set the event handler for the endLink
	addEvent( endLink, 'click', endMeditation );
	
	function closeMeditation() {
		stopped = true;
		gong.play();
		modal.className = 'modal';
		thankYou();
	}
	
	function endMeditation(ev) {
		'use strict';
		if (typeof ev == 'undefined') ev = window.event;
		stopped = true;
		// Prevent the default behaviour
		if (ev.preventDefault) {
			ev.preventDefault();
		} else {
			ev.returnValue = false;
		}
		return false;
	}
	
	// Create a div with an id
	function createDiv( elementId, parentElement ) {
		if ( $(elementId) ) {
			var div = $(elementId);
		} else {
			var div = document.createElement('div');
			div.id = elementId;
			parentElement.appendChild(div);
		}
		return div;
	}
	
	// Convert seconds to m:ss for display
	function convertTimeToMinutes( time ) {
		var min = 0, sec = '00';
		if ( ( time % 60 ) < 10 ) {
			sec = '0' + Math.floor( time % 60 );
		} else {
			sec = Math.floor( time % 60 );
		}
		if (time > 60) {
			min = Math.floor( time / 60 );
		}
		return min + ':' + sec;
	}
	
	// Increment the progress bar
	function showProgress( time, elapsed ) {
		progressBar.style.height = ( 100 - ((elapsed/time) * 100 )) + '%';
	}
	
	// Initialize the timer
	function resetTimer( time, title ) {
		progressBar.style.height = '100%';
		currentDisplayTime.innerHTML = '0:00';
		startTime.innerHTML = '0:00';
		sectionTime.innerHTML = convertTimeToMinutes(time);
		sectionTitle.innerHTML = title;
	}
	
	// Function to count up to the full time for the section
	function countTime( time ) {
		gong.play();
		// Record the start time
		var start = new Date();
		var elapsed = 0;
		var int = setInterval( function() {
			var now = new Date();
			elapsed = (now - start)/1000;
			currentDisplayTime.innerHTML = convertTimeToMinutes(elapsed);
			showProgress( time, elapsed );
			if ( elapsed >= time || stopped == true ) {
				clearInterval(int);
				startNextSection();
			}
		}, 200);
	}
	
	// Function to get the next section of the meditation
	function startNextSection() {
		for ( var i = 0, count = times.length; i < count; i+=1 ) {
			if ( times[i].time > 0 && i > currentSection ) {
				currentSection = i;
				resetTimer( times[i].time, times[i].title );
				countTime( times[i].time );
				return;
			}
		}
		closeMeditation();
	}
	
	// Display the modal
	modal.className = 'modal-visible';
	
	// Start the timer
	startNextSection();

	// Prevent form submission
	if (e.preventDefault) {
		e.preventDefault();
	} else {
		e.returnValue = false;
	}
	return false;
}




// INIT


function initAll() {
	'use strict';
    
	//var meditationForm = $('meditationForm');
    var theForm = document.forms[0];
	addEvent( theForm, 'submit', meditate );
    
	// Get the form
	//if ( isCanvasSupported() ) {
		//meditationForm.onsubmit = noCanvasMeditation;
	//	addEvent( meditationForm, 'submit', canvasMeditation );
	//} else {
	//	addEvent( meditationForm, 'submit', noCanvasMeditation );
	//}
}

window.onload = initAll;