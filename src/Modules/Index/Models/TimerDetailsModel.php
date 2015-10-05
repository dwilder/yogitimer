<?php
namespace Src\Modules\Index\Models;

class TimerDetailsModel
{
    private $title;
    private $text;
    private $images;
    private $alts;
    
    public function __construct()
    {
        $this->title    = 'Simple Timer';
        $this->text     = array(
            "Set up your meditation time, hit start, and let Yogi Timer mark your time.",
            "The timer is simple and distraction free so you can focus on your practice. The dial shows how much time has elapsed and works for all screen sizes."
        );
        $this->images   = array(
            'index_details_closeup.png',
            'index_details_phone.png',
            'index_details_tablet.png',
            'index_details_laptop.png',
        );
        $this->alts     = array(
            'The timer form lets you adjust preparation, meditation, and cool down times',
            'It works on a mobile phone',
            'It works on a tablet',
            'It works on a compuer'
        );
    }
    
    public function get( $data )
    {
        return $this->$data;
    }
}
