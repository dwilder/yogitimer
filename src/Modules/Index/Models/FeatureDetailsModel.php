<?php
namespace Src\Modules\Index\Models;

class FeatureDetailsModel
{
    private $title;
    private $text;
    private $sections;
    
    public function __construct()
    {
        $this->title = "Things You'll Like";
        $this->text = "Create an account to track your meditations and your progress. Review recent sittings and check your metrics to see your improvement over the short term and the long term.";
        $this->sections = array(
            array(
                'title' => 'Auto-Save Enabled',
                'text'  => "Your meditations are <i>automatically saved</i> to your journal. Even if you start
logged out, you can log in at the end of your meditation to save your time.",
                'image' => 'index_details_autosave.png',
                'alt'   => 'Yogi Timer automatically saves your meditation times'
            ),
            array(
                'title' => 'Save Offline Meditations',
                'text'  => "Did you meditated without using Yogi Timer? No problem! Just log in, click
on <b>Journal</b> in the menu, and add a time.",
                'image' => 'index_details_journal.png',
                'alt'   => 'Use the journal to add meditations'
            ),
            array(
                'title' => 'Check Your Metrics',
                'text'  => "Get inspired by checking your progress. Use your <b>Momentum</b> and <b>Stability</b>
scores to inspire you to meditate longer and more frequently. Oh, it’s fun.",
                'image' => 'index_details_metrics.png',
                'alt'   => 'View statistics to check your progress'
            ),
            array(
                'title' => 'Track Practices by Type',
                'text'  => "Create categories for different types of meditations and keep track of your
total time for each of your <b>Practices</b>. Even <i>set goals</i> to complete a practice.",
                'image' => 'index_details_practices.png',
                'alt'   => 'Monitor practice types and set goals'
            ),
        );
    }
    
    public function get( $data )
    {
        return $this->$data;
    }
}
