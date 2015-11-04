<?php
namespace Src\Includes\Data;

use Src\Includes\Database\DB;
use Src\Includes\User\User;

/*
 * Class to retrieve a user's meditation history.
 */
class MeditationRecords
{
    /*
     * Store the data
     */
    private $data = array();
    private $total_times_by_practice = array();
    
    /*
     * Return the data
     */
    public function get()
    {
        return $this->data;
    }
    
    /*
     * Get the data from the database
     */
    public function read( $user_id = null )
    {
        if ( ! $user_id ) {
            $user = User::getInstance();
            $user_id = $user->get('id');
        }
        
        $pdo = DB::getInstance();
        
        $q = 'SELECT * FROM meditation_records WHERE user_id=:user_id AND status=1 ORDER BY start_time DESC';
        
        $stmt = $pdo->prepare($q);
        $stmt->bindParam(':user_id', $user_id);
        
        if ( $stmt->execute() ) {
            $this->data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return true;
        }
        return false;
    }
    
    /*
     * Return the total time meditated
     */
    public function getTotalTime()
    {
        $time = 0;
        foreach ( $this->data as $data ) {
            $time += $data['duration'];
        }
        return $time;
    }
    
    /*
     * Get recent meditations
     */
    public function countDaysWithMeditations( $days )
    {
        $diff = $days * 24 * 60 * 60;
        $now = strtotime('now');
        $then = $now - $diff;
        $count = 0;
        $last = null;
        
        foreach ( $this->data as $data ) {
            $current = $data['start_time'];
            if ( strtotime( $current ) < $then ) {
                break;
            }
            // Check if last record and the current record were on the same day
            if ( substr( $current, 0, 10 ) == substr( $last, 0, 10 ) ) {
                continue;
            }
            $last = $current;
            $count += 1;
        }
        return $count;
    }
    
    /*
     * Get total time for recent meditations
     */
    public function getSumOfMeditationTimes( $days )
    {
        $diff = $days * 24 * 60 * 60;
        $now = strtotime('now');
        $then = $now - $diff;
        $minutes = 0;
        
        foreach ( $this->data as $data ) {
            $current = $data['start_time'];
            if ( strtotime( $current ) < $then ) {
                break;
            }
            $minutes += $data['duration'];
        }
        return $minutes;
    }
    
    /*
     * Get the total time for a given year
     */
    public function getTotalTimesByYear()
    {
        $times = array();
        
        foreach ( $this->data as $data ) {
            $year = substr( $data['start_time'], 0, 4 );
            if ( ! isset( $times[$year] ) ) {
                $times[$year] = 0;
            }
            $times[$year] += $data['duration'];
        }
        
        return $times;
    }
    
    /*
     * Get total meditation times per day for twelve months
     */
    public function getTotalTimesByDay()
    {
        $times = array();
        $num_days = 0;

        $start_year = date('Y');
        $start_month = date('m') + 1;
        
        if ( $start_month == 13 ) {
            $start_month = 1;
        }
        if ( $start_month != 1 ) {
            $start_year--;
        }
        
        $current_year = $start_year;
        $current_month = $start_month;
        $last_month = $start_month;
        $current_day = '01';
        
        for ( $i = 0; $i < 12; $i++ ) {

            if ( strlen( $current_month ) == 1 ) {
                $current_month = '0' . $current_month;
            }
            if ( $last_month == 12 && $current_month == 01 ) {
                $current_year++;
            }
            
            $days = cal_days_in_month( CAL_GREGORIAN, $current_month, $current_year );
            $num_days += $days;
            
            for ( $j = 1; $j <= $days; $j++ ) {
                $current_day = $j;
                if ( strlen($current_day) == 1 ) {
                    $current_day = '0' . $current_day;
                }
                $times[$current_year][$current_month][$current_day] = 0;
            }
            
            $last_month = $current_month;
            $current_month = ( $current_month % 12 ) + 1;
        }

        $start_date = $start_year . '-' . $start_month . '-01';
        $then = strtotime( $start_date );
        
        foreach ( $this->data as $data ) {
            if ( strtotime( $data['start_time'] ) < $then ) {
                break;
            }
            $year = substr( $data['start_time'], 0, 4 );
            $month = substr( $data['start_time'], 5, 2 );
            $day = substr( $data['start_time'], 8, 2 );
            
            $times[$year][$month][$day] += $data['duration'];
        }
        
        return $times;
    }
    
    /*
     * Get the total time for a given meditation practice
     */
    public function getTotalTimeByPractice( $id = 0 )
    {
        if ( empty( $this->total_times_by_practice ) ) {
            $this->setTotalTimesByPractice();
        }
        
        if ( isset( $this->total_times_by_practice[$id] ) ) {
            return $this->total_times_by_practice[$id];
        }
        return 0;
    }
    
    /*
     * Set the total times by practice
     */
    protected function setTotalTimesByPractice()
    {
        $totals = array();
        $totals[0] = 0;
        
        foreach ( $this->data as $data ) {
            if ( ! isset( $totals[ $data['meditation_practice_id'] ] ) ) {
                $totals[ $data['meditation_practice_id'] ] = 0;
            }
            $totals[$data['meditation_practice_id']] += $data['duration'];
        }
        
        $this->total_times_by_practice = $totals;
    }
}
