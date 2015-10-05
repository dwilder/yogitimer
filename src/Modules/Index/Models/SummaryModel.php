<?php
namespace Src\Modules\Index\Models;

class SummaryModel
{
    private $title;
    private $items;
    
    public function __construct()
    {
        $this->title = "Boost Your Meditation";
        $this->items = array(
            array(
                'image' => 'index_summary_timer.png',
                'text'  => 'Use the online meditation timer',
                'alt'   => 'Meditation timer'
            ),
            array(
                'image' => 'index_summary_journal.png',
                'text'  => 'Track your sittings in the journal',
                'alt'   => 'Calendar image'
            ),
            array(
                'image' => 'index_summary_metrics.png',
                'text'  => 'Check your metrics for a boost!',
                'alt'   => 'Line chart going up'
            )
        );
    }
    
    public function get( $data )
    {
        return $this->$data;
    }
}
