<?php
namespace Src\Includes\Template\Models;

use Src\Includes\User\User;

class HeaderMenu
{
	/*
	 * Store the user menu sections and menu items
	 */
	private $lists = array(
		'anonymous' => array(
			'login' => 'Log In',
			'signup' => 'Sign Up'
		),
		'authenticated' => array(
			'menu' => 'Menu'
		)
	);
	
	/*
	 * Store the guid
	 */
	private $guid = null;
	
	/*
	 * Set the guid
	 */
	public function setGuid( $guid )
	{
		$this->guid = $guid;
	}
	
	/*
	 * Return the menu
	 */
	public function getMenu()
	{
		$html = '
			<nav class="header-navigation">
			';
		
		$html .= $this->buildTitle( 'Meditate' );
        
		$user = User::getInstance();
        
		if ( $user->isSignedIn() ) {
			$html .= $this->buildMenuLink();
		} else {
			$html .= $this->buildAnonMenu();
		}
		
		$html .= '
			</nav>
		';
		
		return $html;
	}
	
	/*
	 * Build the logo
	 */
	private function buildTitle( $text )
	{
		$html = '';
		if ( !$this->guid ) {
			return '<h1 class="logo">' . $text . '</h1>';
		} 
		return '<p class="logo"><a href="/">' . $text . '</a></p>';
	}
	
	/*
	 * Build the anonymous user links
	 */
	private function buildAnonMenu()
	{
		$html = '<ul class="header-navigation-anon">';
		foreach ( $this->lists['anonymous'] as $guid => $text ) {
			$html .= '<li class="header-navigation-' . $guid . '"><a href="/' . $guid . '">' . $text . '</a></li>';
		}
		$html .= '</ul>';
			
		return $html;
	}
	
	/*
	 * Build the menu link
	 */
	private function buildMenuLink()
	{
		$id = ( $this->userRole ) ? 'user-navigation' : 'site-navigation';
		
		return '<a href="#' . $id . '" class="control nav-banner-menu">Menu</a>';		
	}
}
