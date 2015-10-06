<?php
namespace Src\Includes\Template\Models;

use Src\Config\Config;
use Src\Includes\User\User;

class HeaderMenu
{
	/*
	 * Store the user menu sections and menu items
	 */
	private $lists = array(
		'anonymous' => array(
            'meditate'  => 'Meditate',
			'login'     => 'Log In',
			'signup'    => 'Sign Up'
		),
		'authenticated' => array(
			'menu' => 'Menu'
		)
	);
    
    /*
     * Is the user logged in?
     */
    private $logged_in = false;
	
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
        $config = Config::getInstance();
        
        $user = User::getInstance();
		if ( $user->isSignedIn() ) {
			$this->logged_in = true;
		} else {
			$this->logged_in = false;
		}
        
		$html = '
			<nav class="header-navigation">
			';
		
		$html .= $this->buildTitle( $config->get('sitename') );
        
		if ( $this->logged_in ) {
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
        $img = '<img src="/assets/img/content/logo.png" alt="Lotus" />';
		if ( ! $this->guid ) {
			return '<h1 class="logo">' . $img . $text . '</h1>';
		}
        
        $url = '/';
        if ( $this->logged_in ) {
            $url .= 'profile';
        }
		return '<p class="logo"><a href="' . $url . '">' . $img . $text . '</a></p>';
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
        $html .= '<li class="header-navigation-anonmenu"><a href="#footer-navigation">Menu</a></li>';
		$html .= '</ul>';
			
		return $html;
	}
	
	/*
	 * Build the menu link. #id depends on login state of the user
	 */
	private function buildMenuLink()
	{
		return '<a href="#user-navigation" class="control header-navigation-menu">Menu</a>';		
	}
}
