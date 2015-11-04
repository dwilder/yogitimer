<?php
namespace Src\Modules\Content\Pages;

/*
 * About page
 */

class PrivacyPage
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
			<h1>Privacy Policy</h1>

            <p>I respect your privacy and in no way wish to use your private information for my personal gain. If you have chosen to use yogitimer.com (“the Service”), then I want to assure you that I have taken precautions to secure your information and prevent the use of your information by third parties. This policy applies to all information collected or submitted to the Service, or on any yogitimer.com applications for iPhone or any other devices and platforms.</p>

            <h2>What Personal Information Do I Collect?</h2>

            <p>I may request information that is personally identifiable. Significantly, you must supply an email address in order to create an account and store your meditation information with the Service. The email address you provide is used for signing in to your account or reseting your password, if you forget.</p>

            <p>From time to time, I may use your email to notify you of important account related matters, such as security, or changes to this policy.</p>

            <p>Should you choose to provide me with other information, such as by providing feedback or contacting me via email, I will collect you name and email address, in addition to any other content of the email, in order to send you a reply.</p>

            <p>I may add features to the Website that require additional personal information to use. You are under no obligation to use the additional services or provide additional personal information. When you create your account, I have asked you to also create a username to further minimize the requirement for your name should any features be added to the Website that would requirement a moniker.</p>

            <p>I store information about your meditations, so that you can review your past meditations and in order to provide additional metrics related to your meditations. This information is not available publicly or to other users of the Service.</p>

            <p>I use cookies on the website in order to keep you logged in.</p>

            <p>I may store additional information, such as your IP address, browser, or device.</p>

            <h2>What Do I Do With The Information I Collect?</h2>

            <p>I use the information I collect to improve the Service, enhance the security of your data, and for customer support issues.</p>

            <h2>With Whom May I Share The Information I Collect?</h2>

            <p>I do not share your personal information with third parties, except to the extend necessary to accomplish the Service’s functionality.</p>

            <p>I may share anonymous, aggregate statistics with outside parties, such as the number of people using the Service.</p>

            <p>I may disclose your information in response to subpoenas, court orders, or other legal requirements; to exercise my legal rights or defend against legal claims; to investigate, prevent, or take action regarding illegal activities, suspected fraud or abuse, violations or my policies; or to protect my rights and property.</p>

            <h2>Security</h2>

            <p>I implement a variety of security measures to help keep your information secure. If there is sufficient usage of the site, I will institute HTTPS. However, your best protection is to use a complex and unique password for your account.<!-- For example, any page where you are asked for your password uses HTTPS so that communications between your web browser and the Service are secure.--></p>

            <h2>Accessing Your Information</h2>

            <p>You may access or change your information, or delete your account at any time by logging into the Service. If you accidentally delete your account, or decide you want to restore it, your information is held for at least 30 days before being permanently deleted from the Service.</p>

            <h2>Children & Privacy</h2>

            <p>I never collect or maintain information on the Service from those I actually know are under 13, and no part of our Service is structured to attract anyone under 13.</p>

            <h2>Consent</h2>

            <p>By using the Service, you constant to this privacy policy.</p>

            <h2>Contacting Me</h2>

            <p>If you have questions regarding this privacy policy, you may email privacy@yogitimer.com.</p>

            <h2>Changes To This Policy</h2>

            <p>If I decide to change this privacy policy, I will post those changes on this page and up[date the Privacy Policy modification date below.</p>

            <p>This policy was last modified on July 20, 2015.</p>
            
EOT;

		return $html;
	}
}
