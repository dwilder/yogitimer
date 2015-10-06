<?php
namespace Src\Modules\Content\Pages;

/*
 * Practices page
 */

class AboutpracticesPage
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
            <p><a href="/guide">From the Guide</a></p>
        
            <h1>Practices</h1>

            <p>Practices allow you track specific types of meditations. For example, you may have different types of breathing meditations that you practice, each one with a unique focus, and <b>Practices</b> allow you to track the number of hours for each of these practices individually.</p>
            
            <p>When you use Practices, the time you meditate is added to your total time, and your metrics include these meditations along with your other meditations, just like always. The benefit is that you can monitor your time spent on a Practice, and you can set a goal for a Practice, such as "10 hours". When you reach your goal, it is checked off to indicate that it is complete.</p>
            
            <p>When you use Practices, your Journal will show the name of the Practice for a given meditation. If you add meditation times to your Journal, you can also choose a Practice or just leave it as "Meditation".</p>
            
            <h2>Using Practices</h2>
            
            <p>To use Practices, you must be logged in. If you don't have an account, you'll need to <a href="/signup">sign up</a>. Open the menu and click on <a href="/practices">Practices</a>, then on the link that says <a href="/practices/add">Add a Practice</a>. You'll need to give your Practice a name, and you can set a goal if you want to. Hit <b>Save</b>. The Practice will be added to the list of your available Practices.</p>
            
            <p>When you navigate to the <a href="/meditate">Meditate</a> page, you will see a new option labeled <b>Practice</b>. You can click it and choose from the Practices that you have added. You can also select "Meditation" if you want your meditation to be saved without a specific Practice.</p>
            
            <p>When you navigate to your <a href="/journal">Journal</a>, Practices won't be apparent unless you have saved meditations using Practices. If you manually add or edit meditations, you can choose a Practice just like when you meditate. It's pretty easy.</p>

            <p><a href="/guide">&larr; Guide</a></p>
EOT;

		return $html;
	}
}
