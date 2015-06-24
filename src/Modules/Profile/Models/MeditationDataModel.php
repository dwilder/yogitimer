<?php
namespace Src\Modules\Profile\Models;

use Src\Includes\Data\MeditationRecords;

class MeditationDataModel
{
    /*
     * Store records object
     */
    private $meditation_records;
    
    /*
     * Store data
     */
    private $total_time = null;
    private $total_by_year = array();
    
    /*
     * Run
     */
    public function __construct()
    {
        $this->setMeditationRecords();
    }
    
    /*
     * Set the meditation records object
     */
    private function setMeditationRecords()
    {
        $this->meditation_records = new MeditationRecords();
        $this->meditation_records->read();
    }
    
    /*
     * Get records for a given interval
     */
    public function getTotalTimesByYear()
    {
        if ( empty( $this->total_by_year ) ) {
            $this->total_by_year = $this->meditation_records->getTotalTimesByYear();
        }
        return $this->total_by_year;
    }
    
    /*
     * Get the total time meditated
     */
    public function getTotalTime()
    {
        if ( ! $this->total_time ) {
            $this->setTotalTime();
        }
        return $this->total_time;
    }
    
    /*
     * Set the total time meditated
     */
    private function setTotalTime()
    {
        $this->total_time = $this->meditation_records->getTotalTime();
    }
    
    /*
     * Count records for the past x days
     */
    public function countDays( $days )
    {
        return $this->meditation_records->countDaysWithMeditations( $days );
    }
    
    /*
     * Count the amount of time meditated over a period of days
     */
    public function countTime( $days )
    {
        return $this->meditation_records->getSumOfMeditationTimes( $days );
    }
    
    /*
     * Get times for the past 365 days
     */
    public function getTotalTimesByDay()
    {
        return $this->meditation_records->getTotalTimesByDay();
    }
}
