<?php
namespace Src\Lib\Template\Models;

use Src\Lib\User\User;

class ColophonMenu
{
	/*
	 * Store the user menu sections and menu items
	 */
	private $list = array(
		'terms' => 'Terms',
		'privacy' => 'Privacy'
	);
	
	/*
	 * Return the menu
	 */
	public function getMenu()
	{
		$user = User::getInstance();
        
		if ( ! $user->isSignedIn() ) {
			return $this->buildMenu();
		}
	}
	
	/*
	 * Build the menu
	 */
	private function buildMenu()
	{
		$html = '
			<nav class="colophon-navigation">
				<ul>
				';
				
		foreach ( $this->list as $guid => $text ) {
			$html .= '<li><a href="' . $guid . '">' . $text . '</a></li>';
		}
		
		$html .= "
				</ul>
			</nav>
			";
			
		return $html;
	}
}
