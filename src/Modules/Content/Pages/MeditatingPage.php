<?php
namespace Src\Modules\Content\Pages;

/*
 * Meditating page
 */

class MeditatingPage
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
            <p><a href="/guide">From the Guide</a></p>
        
            <h1>Meditating</h1>

            <p>This application is not intended to provide any instruction, direction, or any other information that may be interpreted as describing a meditation process. There are plenty of resources out in the world, plenty of teachers, and plenty of instructions. If you have never meditated before and need something to get going, here is a basic meditation you can practice.</p>

            <h2>Breathing Meditation</h2>

            <p>Sit. You can sit in a chair with your feet flat on the ground or on a cushion with your legs crossed in front of you. Keep your back straight and rest your hands palm down on your thighs. Direct your gaze down in front of you at a 45 degree angle. Now focus on your breathing. Follow your breath as you inhale and as you exhale. When you notice that you are thinking and not paying attention to your breath, bring your attention back to your breath. Continue to practice in this way until your meditation time is over.</p>

            <h2>More Instructions</h2>

            <p><strong>Read.</strong> There are lots of great books on meditation from many perspectives.</p>

            <p><strong>Find a teacher.</strong> There is nothing better than discussing your meditation practice with someone who has practiced and experienced their own mind more intimately than you. Vet your teacher. Whatever instructions you receive, practice and see what results you are getting. Are the instructions you received having an effect. Discuss this with your instructor but trust your own experience. Your meditation is about your relationship with your mind.</p>
            
            <p><a href="/guide#meditating">&larr; Guide</a></p>
EOT;

		return $html;
	}
}
