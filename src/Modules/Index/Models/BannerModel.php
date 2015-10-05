<?php
namespace Src\Modules\Index\Models;

class BannerModel
{
	/*
	 * Store data
	 */
	private $content;
	private $foreground;
    private $midground;
    private $background;
	
	/*
	 * Assign values
	 */
	public function __construct()
	{
		$this->content = "Yogi Timer is a simple meditation timer and journal";
		$this->foreground = array(
            'Cut Through The Noise',
            'Reconnect',
            'Rest Your Mind',
            'Get Focussed'
		);
        $this->midground = array(
            'Meditate'
        );
        $this->background = array(
            'Equanimity',
            'Loving Kindness',
            'Compassion',
            'Joy',
            'Patience',
            'Generosity',
            'Diligence',
            'Exertion',
            'Meditation',
            'Wisdom',
            'Mindfulness',
            'Prajna',
            'Bodhicitta',
            'Egoless'
        );
	}
	
	/*
	 * Get values
	 */
	public function get( $data )
	{
		return $this->$data;
	}
}