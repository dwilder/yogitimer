<?php
namespace Src\Modules\Profile\Views;

use Src\Includes\SuperClasses\View;

class BannerView extends View
{
	/*
	 * Build the profile banner
	 */
	public function run()
	{
		$start = '<div class="profile-banner">';
		$end = '</div>';
		
		$html = '';
		$html .= $this->getImage( 'banner' );
		$html .= $this->getImage( 'profile' );
		$html .= $this->getUsername();
		$html .= $this->getLevel();
		
		return $start . $html . $end;
	}
	
	/*
	 * Build the images
	 */
	private function getImage( $image )
	{
		$html = '<div class="profile-banner-' . $image . '">';
			$html .= '<img src="' . $this->data[$image] . '" alt="' . $image . ' image" />';
		
		$html .= '</div>';
			
		return $html;
	}
	
	/*
	 * Build the username
	 */
	private function getUsername()
	{
		$html = '<div class="profile-banner-username">';
		$html .= htmlspecialchars( $this->data['username'] );
		$html .= '</div>';
		
		return $html;
	}
	
	/*
	 * Build the user level display
	 */
	private function getLevel()
	{
		$html = '<div class="profile-banner-level">';
        $html .= '<img src="/assets/img/icons/icon_level_';
		$html .= $this->data['level'];
        $html .= '.png" alt="Level ' . $this->data['level'] . '" />';
		$html .= '</div>';
		
		return $html;
	}
	
}
