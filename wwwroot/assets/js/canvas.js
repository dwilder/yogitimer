function canvasMeditation(e) {
	
	'use strict';
	// Get DOM elements
	var modal = $('modal');
	var timer = $('timer');
	var endLink = $('end-meditation'); // Get the End Meditation link element
	var stopped = false;
	
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
	var gong = new Audio('aud/gong.mp3');
	
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