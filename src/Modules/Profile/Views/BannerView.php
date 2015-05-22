<?php
namespace Src\Modules\Profile\Views;

class BannerView
{
	/*
	 * Store the username and profile images
	 */
	protected $username;
	protected $level;
	protected $profile;
	protected $background;
	
	/*
	 * Set the values
	 */
	public function setData( $data = array() )
	{
		$this->username = $data['username'];
		$this->level = $data['level'];
		$this->profile = $data['profile'];
		$this->background = $data['background'];
	}
	
	/*
	 * Build the profile banner
	 */
	public function getHtml()
	{
		$start = '<div class="profile-banner">';
		$end = '</div>';
		
		$html = '';
		$html .= $this->getImage( 'background' );
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
		if ( $this->$image ) {
			$html .= '<img src="' . $this->$image . '" alt="' . $image . ' image" />';
		} else {
			$html .= '<p>Failed to get ' . $image . ' image.</p>';
		}
		$html .= '</div>';
			
		return $html;
	}
	
	/*
	 * Build the username
	 */
	private function getUsername()
	{
		$html = '<div class="profile-banner-username">';
		$html .= htmlspecialchars( $this->username );
		$html .= '</div>';
		
		return $html;
	}
	
	/*
	 * Build the user level display
	 */
	private function getLevel()
	{
		$html = '<div class="profile-banner-level">';
		$html .= $this->level;
		$html .= '</div>';
		
		return $html;
	}
	
}
