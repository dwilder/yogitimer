<?php
namespace Src\Modules\Content\Pages;

/*
 * Guide page
 */

class GuidePage
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
			<h1>Guide</h1>
        
			<p>Need help? Direction? Information? Try reviewing the guide to find what you need...</p>
            
            <h2>Navigating the Website</h2>
            
            <p>Click or tap the Menu link in the top right corner of the screen to expose a list of the pages you can access. Click or tap an option in the menu to get to the page you want to see. You can dismiss the menu by clicking or tapping the <b>X</b> icon at the top or the <b>Dismiss</b> button at the bottom of the menu.</p>
            
            <p>The Menu gives you access to <a href="#profile">your Profile,</a> <a href="#timer">the Meditation Timer,</a> and <a href="#journal">your Journal.</a></p>
            
            <p>It also gives you access to your personal settings, if you want to change your username, email address, password, or to customize your profile with your own images. It also gives you access to help pages, like this Guide, and to legal information about this service.</p>
            
            <a id="timer"></a>
            <h2>Using the Timer</h2>
            
            <p>The timer allows you to set a prepartion time, meditation time, and cool down time. You can also choose whether to include a gong sound at the transition times in your meditation. To change these settings, click or tap on the setting you want to change. A list of options will appear for that setting. Clicking or tapping the one you want will select it. Do this for each setting you want to change. When you are satisfied with your selections, click or tap the "Begin" button to start you meditation.</p>
            
            <p>During your meditation, a simple dial will be displayed. The dial represents the total time you have set for your preparation, meditation, and cool down times, where the preparation and cool down times will be shaded darker. As the time counts down, a darker pie shape begins to fill the timer in, expanding in a clockwise direction. When the wedge has expanded around to include the entire dial, total time is done. You can choose to end your meditation early by clicking the "End" button.</p>
            
            <p>At the end of your meditation, the timer will try to save your meditation time. If you're logged in, this should happen automatically. Otherwise, you will be prompted to log in to save your time. In either case, a short message will let you know what to do and give you some options.</p>
            
            <p><a href="/meditate">Start Meditating</a></p>
            
            <h3>Meditating</h3>
            
            <p>This application is intended to provide a tool to support meditation, not to provide instruction. However, I have provided brief instructions to get you going in case you haven't previously received instruction or want to try this approach. It is a foundational meditation common to many tradition.
            
            <p><a href="/meditating">Learn about Meditating</a></p>
            
            <a id="journal"></a>
            <h2>Using the Journal</h2>
            
            <p>Your meditation journal lists all your meditations that have been save, either where you have used the time, or where you have manually entered times. Meditations are listed in reverse chronological order, with the month name displayed are the top of the month. Where you have meditations listed on consecutive days, they will be grouped together; if you miss a day, there will be a gap between entries.</p>
            
            <p><a href="/journal">View your Journal</a></p>
            
            <p>You can manually add times in the journal by clicking or tapping the "Add Time" link. A new page will be displayed where you can set the date, time, and duration of your meditation. Make sure to save your entry.</p>
            
            <p><a href="/journal/add">Add a Meditation Time to your Journal</a></p>
            
            <p>You can edit times that you have manually added by clicking or tapping on the entry you want to edit. A new page will be displayed allowing you to edit the date, time, and duration, or to delete the entry. Make sure to save your changes.</p>
            
            <p>Meditations that have been automatically saved using the timer cannot be edited or deleted.</p>
            
            <a id="profile"></a>
            <h2>About Your Profile</h2>
            
            <p>Your profile is your way to get an overview of you meditation habits. It includes some metrics that I think are useful and that might inspire you to mediate.</p>
            
            <p><a href="/profile">View your Profile</a></p>
            
            <h3>Your Momentum Score</h3>
            
            <p>Momentum is a representation of how frequently you meditate and how that is impacting your habit of meditating. It is a score out of 100 based on the number of days you have meditated in the recent past, and the total number of hours you have meditated. The ball moves like a pendulum, and when your Momentum score gets high enough it will start swinging around.</p>
            
            <p><a href="/momentum">More about Momentum</a></p>
            
            <h3>Your Stability Score</h3>
            
            <p>Stability represents your ability to keep your mind focussed on the object of meditation. It is a score out of 100 based on the length of your recent meditations and the total number of hours you have meditated. The ball moves around randomly, like an untamed mind, occasionally settling somewhere. As your Stability score increases, the ball settles more frequently, and more often in the center - the focal point.</p>
            
            <p><a href="/stability">More about Stability</a></p>
            
            <h3>Your Timeline</h3>
            
            <p>A bar graph displays your daily meditation times for the past 12 months. The vertical axis is relative to your longest meditation during the previous 12 months. If you meditate the same amount every day, then this will look like a smooth line, whereas if you meditate infrequently you will see sporadic threads. If your meditations are getting longer as time goes on, then it will look like a ramp going up from left to right.
            
            <h3>Your Meditation Time</h3>
            
            <p>The listing for your meditation time includes the total number of hours you have meditated, plus total s for the current year and any previous year. This is the sum of hours where your time was saved automatically using the time, and any additional time you have entered in your journal. Hopefully, you will see some progress over the years.</p>
            
            <p>Meditation times are rounded to the quarter hour.</p>
            
            <h2>Still Haven't Found What You're Looking For?</h2>
            
            <p><a href="/contact">Try contacting me for support.</a></p>
EOT;

		return $html;
	}
}
