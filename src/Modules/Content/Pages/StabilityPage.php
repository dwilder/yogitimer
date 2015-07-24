<?php
namespace Src\Modules\Content\Pages;

/*
 * Stability page
 */

class StabilityPage
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
            <h1>Stability</h1>

            <p>The mind wanders. It wanders here. It wanders there. Sometimes it will come to rest in some dull state, not even aware of where it is. Often it zips around, spinning on its thoughts, bouncing off the walls. Our mind is wild. With meditation, we can tame it.</p>

            <p>As we direct our mind towards its object (that&#8217;s up to you), we can begin to train our mind to rest, to become stable. In our meditation, we can bring our mind back to rest, but this is challenging at first. Our mind keeps moving, becoming attached to thoughts, and running rampant. It may begin to settle, but still be agitated or dull, resting where it shouldn&#8217;t.</p>

            <p>When we practice for longer periods, we have more opportunities to practice bringing our mind back to its object. We do this whenever we see that our mind has wandered and we become very skillful at always bringing it back to its object. We can catch our mind wandering more easily and, with training, it wanders less and less. It stays with its object more and more. We can train our mind so well that it can remain fixed on its object, perfectly stable.</p>

            <h2>Stability Interpreted</h2>

            <p>Your Profile includes a stability score that is meant to give some insite into the progress of your meditation, the stability of your mind, and the stability you can achieve. This is interpreted as a ball experiencing random forces. It will move around erratically, the shift directions at random, and occasionally come to rest. As you gain stability, the ball will come to rest more frequently, is more likely to come to rest in the centre, will stay at rest for longer periods.</p>

            <h2>Finding Your Score</h2>

            <p>You can find your stability score by opening your Profile and tapping on the <em>Stability</em> box. This will show your score out of 100. That&#8217;s a nice round number that is convenient to work with and has no cosmic significance. It&#8217;s just a relative scale that might give you some idea of where your at and where you can get to.</p>

            <h2>Increasing Your Stability</h2>

            <p>So, you want a stable mind. The only way to get there is to practice making it stable. That takes time, and better if its longer periods of time. Remember, stability is about training your mind to come back to its object (of your choice) whenever it wanders and you&#8217;ll have more opportunities with this cycle if your meditation is longer. So, practice for longer periods of time.</p>
EOT;

		return $html;
	}
}
