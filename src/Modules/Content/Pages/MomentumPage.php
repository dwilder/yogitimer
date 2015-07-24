<?php
namespace Src\Modules\Content\Pages;

/*
 * Momentum page
 */

class MomentumPage
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
            <h1>Momentum</h1>

            <p>Let&#8217;s start with the goal of have a daily meditation practice. Yes, that may be ambitious and lofty, but it&#8217;s something to work towards. We don&#8217;t need to be discouraged if we miss a day, or only meditate on Sundays. We are building up a habit of getting to the cushion.</p>

            <p>Before we have meditated for the first time, we have no momentum, but if we meditate even once, then we are likely to do it again. Our momentum increases. If we have meditated a lot during one month, then stop for a few weeks, our momentum decreases but we don&#8217;t lose it entirely. We can recall that it isn&#8217;t a big deal to get to the cushion again for a few minutes, and then we can get our momentum going again.</p>

            <p>When we have meditated a lot over the years, that habit naturally carries us. Even if we stop, we have a lot of momentum since we have built such a strong habit of meditating. If we have meditated well, then some amount of our momentum is always sustained, even if don&#8217;t meditated again for months or years. Our habit of meditating has become strong and it is very easy to start again.</p>

            <h2>Momentum Interpreted</h2>

            <p>Your Profile includes a momentum score intended to give you some encouragement to build your meditation practice. It&#8217;s a little ball caught in a gravity well, like a pendulum. As you gain momentum, it will swing higher. If you have enough momentum in your practice, it will begin swinging around in a circle and hit break neck speed as you meditate more and more.</p>

            <h2>Finding Your Score</h2>

            <p>You can get your momentum score by opening your Profile page and tapping the <em>Momentum</em> box. It&#8217;s a score out of 100. This is not &#8220;100 days&#8221;. 100 is just a convenient number to use as a benchmark. Momentum is a slippery quantity that has as much to do with long term practice as with the past few days.</p>

            <h2>Increasing Your Momentum</h2>

            <p>There is an easy way to increase your momentum: meditated daily. Even if it&#8217;s only a few minutes, it will help you build the habit. Momentum is about getting to the cushion on a daily basis. That is the practice of momentum.</p>
EOT;

		return $html;
	}
}
