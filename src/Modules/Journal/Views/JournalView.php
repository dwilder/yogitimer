<?php
namespace Src\Modules\Journal\Views;

use Src\Includes\SuperClasses\View;

class JournalView extends View
{
    /*
     * Store objects
     */
    private $practices;
    
	/*
	 * Get the HTML content
	 */
	public function run()
	{
        $this->setPracticesMapping();
        
		$start = '<div class="journal-entries">';
		$end = '</div>';
		
		$header = $this->getHeaderHtml();
		
		$entries = $this->getEntriesHtml();
		
		$this->content = $start . $header . $entries . $end;
	}
    
    /*
     * Set up the array for mapping practice ids to names
     */
    private function setPracticesMapping()
    {
		$practices = $this->data['practices'];
        $this->practices = $practices->getIdToNameArray();
    }
	
	/*
	 * Build the HTML header
	 */
	protected function getHeaderHtml()
	{
		$ground = '<header class="page-header">';
		$path = '';
		$fruition = '</header>';
		
		$path .= '<h1>Journal</h1>';
		
		$path .= '<div class="page-header-link">';
		$path .= '<a href="/journal/add">Add Time</a>';
		$path .= '</div>';
		
		return $ground . $path . $fruition;
	}
	
	/*
	 * Build the HTML data structures
	 */
	protected function getEntriesHtml()
	{
		$html = '';
        
		if ( count( $this->data ) > 1 ) {
			$count = count( $this->data ) - 1;
			for ( $i = 0; $i < $count; $i++ ) {
                
                if ( $i == 0 ) {
                    // Always start with a new month
                    $html .= $this->getMonthBannerHtml( $this->data[$i]['start_time'] );
                }
                else {
    				// Check for a new month
    				$html .= ( $this->isNewMonth( $this->data[$i]['start_time'], $this->data[$i-1]['start_time'] ) ) ? $this->getMonthBannerHtml( $this->data[$i]['start_time'] ) : '';
                }
                
                if ( $i + 1 == $count ) {
                    // Always end the run at the end
    				$html .= $this->getEntryHtml( $this->data[$i], null );
                }
                else {
    				// Create html for an entry
    				$html .= $this->getEntryHtml( $this->data[$i], $this->data[$i+1]['start_time'] );
                }
			}
		}
		else {
			$html .= "<p>Your meditation times will be listed here... once you start.</p>";
		}
		
		return $html;
	}
	
	/*
	 * Build a month banner
	 */
	protected function getMonthBannerHtml( $time )
	{
		$ground = '<div class="journal-month-banner';
		// Create a gap if the last entry of the month is NOT the last day of the month.
		$ground .= ( !$this->isLastDayOfMonth( $time ) ) ? ' journal-month-banner-norun' : '';
		$ground .= '">';
		$path = '';
		$fruition = "</div>\n";
		
		$path = date( 'F Y', $time );
		
		return $ground . $path . $fruition;
	}
	
	/*
	 * Build an entry
	 */
	protected function getEntryHtml( $current_data, $previous_timestamp = null )
	{
		// Get the timestamp of the current date
		$ts = $current_data['start_time'];
		//echo date( 'd', $ts ) . ' ' . date( 'd', $previous_timestamp ) . ' <br />';
		$ground = '<div class="journal-entry';
		
		// Test if the previous meditation is the same day or the previous day
		if ( 
			!$this->isRun( $ts, $previous_timestamp )
			&&
			!$this->isFirstDayOfMonth( $ts )
		) {
			$ground .= ' journal-entry-startofrun';
		}
		$ground .= '">';
		$path = '';
		$fruition = "</div>\n";
		
		$path .= '<span class="journal-entry-date">' . date( 'D', $ts ) . ' ';
		$path .= date( 'j', $ts ) . '</span>, ';
		$path .= '<span class="journal-entry-time">' . date( 'g:ia', $ts ) . '</span> ';
		$path .= '<span class="journal-entry-duration">' . $this->formatDuration( $current_data['duration'] ) . '</span>';
        
        if ( isset( $this->practices[ $current_data['meditation_practice_id'] ] ) ) {
            $path .= '<span class="journal-entry-name">' . strip_tags( $this->practices[ $current_data['meditation_practice_id'] ] ) . '</span>';
        }
		
        if ( $current_data['add_method'] == 'form' ) {
    		$path = '<a href="/journal/edit/' . $current_data['id'] . '">' . $path . '</a>';
        }
        else {
    		$path = '<div class="journal-entry-organic">' . $path . '</div>';
        }
		
		return $ground . $path . $fruition;
	}
	
	/*
	 * Test if two timestamps are on the same day or one day apart
	 */
	protected function isRun( $current, $previous )
	{
		$cy = date( 'Y', $current );	// Current entry year
		$cd = date( 'z', $current );	// Current entry day of the year
		$py = date( 'Y', $previous );	// Previous entry year
		$pd = date( 'z', $previous ) ;	// Previous entry day of the year
		
		//echo "$cy $cd - $py $pd<br />";
		if ( ($cy == $py) && ( $cd == $pd || $cd == ($pd + 1) ) ) {
			//echo "RUN!!!<br />";
			return true;
		}
		//echo "STOP!!!<br />";
		return false;
	}
	
	/*
	 * Test if a timestamp is the first day of the month
	 */
	protected function isFirstDayOfMonth( $timestamp )
	{
		if ( date( 'j', $timestamp ) == 1 ) {
			return true;
		}
		
		return false;
	}
	
	/*
	 * Test if a timestamp is the first day of the month
	 */
	protected function isLastDayOfMonth( $timestamp )
	{
		if ( date( 'j', $timestamp ) == date( 't', $timestamp ) ) {
			return true;
		}
		
		return false;
	}
	
	/*
	 * Format the duration string
	 */
	protected function formatDuration( $time )
	{
		$string = '';
		$minutes = $time % 60;
		$hours = floor( $time/60 );
		
		// Hours
		if ( $hours == 1 ) {
			$string .= '1 hr ';
		} elseif ( $hours > 1 ) {
			$string .= $hours . ' hrs ';
		}
		
		// Minutes
		if ( $minutes == 1 ) {
			$string .= '1 min';
		} elseif ( $minutes > 1 ) {
			$string .= $minutes . ' min';
		}
		
		return $string;
	}
	
	/*
	 * Test if a new month banner is needed
	 */
	protected function isNewMonth( $current, $last )
	{
		if ( date( 'm', $current) == date( 'm', $last ) ) {
			return false;
		}
		
		return true;
	}
	
	/*
	 * Test if the current entry is the last entry of a month
	 */
	protected function isLastEntryOfMonth( $current, $previous )
	{
		// Test if the current entry is the last day of the month
		if ( date( 't', $current ) == date( 'd', $current ) ) {
			return true;
		}
		
		// Else: Test if the current entry and the previous entry are in the same month
		
	}
	
	// Create the HTML
	// - for the month header (month year)
	// - for each entry (edit link, date, day, start time, duration)
	
	// Scan through the data
	
	// Convert timestamp to day, month, year, hour:minute
	
	// For each meditation, check to see if it is
	// - first day of the month (add a class 'journal-entry-firstdayofmonth')
	// - last day of the month (add a class 'journal-entry-lastdayofmonth')
	// - does not have a meditation on the same or previous day if not first of the month (add a class 'journal-entry-startofrun')
	
}