<?php
namespace Src\Modules\Content\Pages;

/*
 * About page
 */

class SupportPage
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
			<h1>Support</h1>
        
			<p>If you have a problem, please check here before contacting me.</p>
            
            <h2>Browser Requirements</h2>
            
            <p>I have intentional create the timer to use Canvas with JavaScript. Most modern browsers support Canvas. If yours doesn't, consider updating to a modern version of Chrome, Firefox, Safari, etc. You will also need to have JavaScript enabled on your browser - this should be done automatically, but you may have switched it off or you may be using a browser that doesn't support JavaScript. You will need to use a browser with JavaScript enabled to use the timer.</p>
            
            <h2>FAQ</h2>
            
            <h3>The timer isn't working.</h3>
            
            <p>The timer uses JavaScript and HTML5 Canvas. You must use a browser that supports Canvas and has JavaScript enabled. Most current browsers will be just fine, but if your's doesn't, try Chrome.</p>
            
            <h3>My computer/device goes to sleep when I'm meditating.</h3>
            
            <p>You'll need to change the settings on your device so that it doesn't go to sleep at least for as long as you are meditating. If you use a Mac, try Caffiene, a menu bar app that prevents your computer from sleeping when it's activated.</p>
            
            <h2>Still Haven't Found What You're Looking For?</h2>
            
            <p><a href="/contact">Try contacting me for support.</a></p>
EOT;

		return $html;
	}
}
