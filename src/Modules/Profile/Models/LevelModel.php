<?php
namespace Src\Modules\Profile\Models;

class LevelModel
{
    /*
     * Levels
     */
    private $levels = array(
        0 => 0,
        1 => 1,
        2 => 125,
        3 => 250,
        4 => 500,
        5 => 1000,
        6 => 2500,
        7 => 5000
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
            if ( $this->total_time >= $v ) {
                $level = $k;
            }
        }
        $this->level = $level;
    }
}
