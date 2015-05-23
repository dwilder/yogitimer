<?php
namespace Src\App;

use \Src\Config\Config;

class ErrorHandler
{
    /*
     * Init
     */
    public function __construct()
    {
        // Make the custom error handler the default error handler
        set_error_handler( array( $this, 'custom_error_handler' ) );
    }

    // Create an error handler
    public function custom_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {
	
        $config = Config::getInstance();
    
    	// Build the error message:
    	$message = "An error occurred in script '$e_file' on line $e_line: $e_message\n";
	
    	// Add the date and time:
    	$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n";
	
    	if ( ! $config->get('live') ) { // In development, print the error. 
		
    		// Show the message:
    		echo '<div class="error">' . nl2br($message);
		
    		// Add variable and backtrace:
    		echo '<pre>' . print_r($e_vars, 1) . "\n";
    		debug_print_backtrace();
    		echo '</pre></div>';
		
    	} else { // Don't show the error.
	
    		// Send an email to the admin:
    		$body = $message . "\n" . print_r ($e_vars, 1);
    		mail(ERROR_EMAIL, SITE_NAME . " Error!", $body, 'From: ' . SITE_EMAIL);
		
    		// Print an error if it ISN'T a notice
    		if ($e_number != E_NOTICE) {
    			echo '<div class="error">A system error occurred. We apologize for the inconvenienced.</div>';
    		}
	
    	} // End of !LIVE IF.

    } // End of custom_error_handler() definition.
}



