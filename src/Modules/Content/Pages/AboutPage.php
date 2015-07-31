<?php
namespace Src\Modules\Content\Pages;

/*
 * About page
 */

class AboutPage
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
			<h1>About</h1>
        
			<p>This page covers basic information about this web application. In future, I may use this page to track changes.</p>
            
            <h2>Intention</h2>
            
            <p>I have created this application because:</p>
            
            <ol>
                <li>I enjoy building web applications.</li>
                <li>I need to be able to add unique tracking features for my meditations, and I would rather create features that I know are relevant than look for an existing applications that may fail to meet my needs.</li>
            </ol>
            
            <p>As my meditation practice grows and changes, this application will grow and change: it must continue to meet my needs and reflect my experience with meditation. Hopefully, you will find it an equally useful addition to your own meditation practice and path.</p>
            
            <h2>Usage</h2>
            
            <p>You can use the website for free. My intention is that users of the website will always be able to use the timer and journal features of the website free of charge.</p>
            
            <p>This meditation timer is intended for focussing the mind and is designed for minimal distraction. It is intended to be simple and easy to use. If you find anything awkward or difficult, <a href="/contact">please tell me about it</a>.</p>
            
            <h2>Author</h2>
            
            <p>I am a web designer and developer, as well as a devout meditation practitioner. I have worked as a User Experience Designer, Graphic Designer, and Web Developer. I have studied mathematics and physical sciences, and have long been a student of the mind. I have a background in hands on healing, working with subtle energies, and follow a course in the Buddhist science of the mind.</p>
            
            <p>You can see more of my work at <a href="http://davewilder.ca">davewilder.ca</a>.</p>
            
EOT;

		return $html;
	}
}
