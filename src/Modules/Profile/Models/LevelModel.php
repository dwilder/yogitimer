<?php
namespace Src\Modules\Profile\Models;

class LevelModel
{
    /*
     * Levels: Foundation, then 5 paths
     */
    private $levels = array(
        // Non-meditator
        0 => array(
            'hours' => 0,
            'text'  => 'The journey of 10,000 hours begins with one breath'
        ),
        // Hinayana
        // Shamatha
        1 => array( // Placement
            'hours' => 1,
            'text'  => 'A wild and crazy mind can only be tamed by placing it on its object'
        ),
        2 => array( // Continuous Placement
            'hours' => 10,
            'text'  => 'The mind must return again and again to its object and rest there'
        ),
        3 => array( // Repeated Placement
            'hours' => 30,
            'text'  => 'The mind must be trained not to stray from its object'
        ),
        4 => array( // Close Placement
            'hours' => 60,
            'text'  => 'The mind returns with focus to it\'s object'
        ),
        5 => array( // Taming
            'hours' => 100,
            'text'  => 'The mind leads, remaining watchful of distractions'
        ),
        6 => array( // Pacification
            'hours' => 150,
            'text'  => 'The mind releases attachment to thoughts'
        ),
        7 => array( // Thorough Pacification
            'hours' => 210,
            'text'  => 'The mind abandons agitation and dullness'
        ),
        8 => array( // One-Pointedness
            'hours' => 280,
            'text'  => 'The mind rests effortlessly on its object'
        ),
        9 => array( // Even Placement
            'hours' => 360,
            'text'  => 'The mind is immersed completely in meditation'
        ),
        
        // Mahayana
        // Path of Accumulation
        
        // Mindfulness
        10 => array( // Mindfulness of Body
            'hours' => 450,
            'text'  => 'The mind becomes unattached to the physical form'
        ),
        11 => array( // Mindfulness of Feeling
            'hours' => 500,
            'text'  => 'The mind becomes unattached to desire and revulsion'
        ),
        12 => array( // Mindfulness of Mind
            'hours' => 550,
            'text'  => 'The mind becomes unattached to thoughts of the three times'
        ),
        13 => array( // Mindfulness of Phenomena
            'hours' => 600,
            'text'  => 'The mind becomes unattached to the six sense objects'
        ),
        
        // Progressive Stages of Meditation on Emptiness
        14 => array( // Vaibashika
            'hours' => 650,
            'text'  => 'Joyful Non-Attachment'
        ),
        15 => array( // Sautrantika
            'hours' => 700,
            'text'  => 'Joyful Non-Attachment'
        ),
        16 => array( // Cittamatra
            'hours' => 750,
            'text'  => 'Joyful Non-Attachment'
        ),
        17 => array( // Rangtong
            'hours' => 800,
            'text'  => 'Joyful Non-Attachment'
        ),
        18 => array( // Shentong
            'hours' => 850,
            'text'  => 'Joyful Non-Attachment'
        ),
        19 => array( // Resting in 2-Fold Selflessness
            'hours' => 900,
            'text'  => 'Joyful Non-Attachment'
        ),
        
        // Four Reminders
        20 => array( // Precious Human Birth
            'hours' => 950,
            'text'  => 'Joyful Non-Attachment'
        ),
        21 => array( // Death and Impermanence
            'hours' => 1000,
            'text'  => 'Joyful Non-Attachment'
        ),
        22 => array( // Karma
            'hours' => 1050,
            'text'  => 'Joyful Non-Attachment'
        ),
        23 => array( // Retribution of Samsara
            'hours' => 1100,
            'text'  => 'Joyful Non-Attachment'
        ),
        
        // Four Immeasurables
        24 => array( // Equanimity
            'hours' => 950,
            'text'  => 'Joyful Non-Attachment'
        ),
        25 => array( // Love
            'hours' => 1000,
            'text'  => 'Joyful Non-Attachment'
        ),
        26 => array( // Compassion
            'hours' => 1050,
            'text'  => 'Joyful Non-Attachment'
        ),
        27 => array( // Joy
            'hours' => 1100,
            'text'  => 'Joyful Non-Attachment'
        ),
        // Path of Unification
        
        // Ten Bhumis
        // Path of Seeing
        28 => array( // Generosity
            'hours' => 5500,
            'text'  => 'Joyful Non-Attachment'
        ),
        // Path of Meditation
        29 => array( // Ethics / Diligence
            'hours' => 6000,
            'text'  => 'Stainless Equanimity'
        ),
        30 => array( // Patience
            'hours' => 6500,
            'text'  => ''
        ),
        31 => array( // Effort / Exertion
            'hours' => 7000,
            'text'  => ''
        ),
        32 => array( // Meditation
            'hours' => 7500,
            'text'  => ''
        ),
        33 => array( // Wisdom
            'hours' => 8000,
            'text'  => ''
        ),
        34 => array( // Gone Afar - Free of afflications, Spontaneously benefiting others
            'hours' => 8500,
            'text'  => 'Lama'
        ),
        35 => array( // Immovable - Completely absorbed in Dharma
            'hours' => 9000,
            'text'  => 'Arhat'
        ),
        36 => array( // Good Intelligence
            'hours' => 9500,
            'text'  => 'Bodhisattva'
        ),
        37 => array( // The Cloud of Dharma
            'hours' => 10000,
            'text'  => 'Buddha'
        )
        
        // Path of No More Learning
        
    );
    
    /*
     * Store the level
     */
    private $level = null;
    
    /*
     * Store the total time
     */
    private $total_time;
    
    /*
     * Set the total time
     */
    public function setTotalTime( $time )
    {
        $this->total_time = floor( $time/60 );
    }
    
    /*
     * Get the level
     */
    public function getLevel()
    {
        if ( ! $this->level ) {
            $this->setLevel();
        }
        return $this->level;
    }
    
    /*
     * Set the level
     */
    private function setLevel()
    {
        $level = 0;
        foreach ( $this->levels as $k => $v ) {
            if ( $this->total_time >= $v['hours'] ) {
                $level = $k;
            }
        }
        $this->level = $level;
    }
}
