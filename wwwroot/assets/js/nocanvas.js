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
	var gong = new Audio('aud/gong.mp3');
	
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