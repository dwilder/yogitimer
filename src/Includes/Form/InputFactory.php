<?php
namespace Src\Includes\Form;

use Src\Includes\Form\Inputs\Button as Button;
use Src\Includes\Form\Inputs\Checkbox;
use Src\Includes\Form\Inputs\Color;
use Src\Includes\Form\Inputs\Date;
use Src\Includes\Form\Inputs\Datetime;
use Src\Includes\Form\Inputs\DatetimeLocal;
use Src\Includes\Form\Inputs\Email;
use Src\Includes\Form\Inputs\File;
use Src\Includes\Form\Inputs\Hidden;
use Src\Includes\Form\Inputs\Image;
use Src\Includes\Form\Inputs\Month;
use Src\Includes\Form\Inputs\Number;
use Src\Includes\Form\Inputs\Password;
use Src\Includes\Form\Inputs\Radio;
use Src\Includes\Form\Inputs\Range;
use Src\Includes\Form\Inputs\Reset;
use Src\Includes\Form\Inputs\Search;
use Src\Includes\Form\Inputs\Select;
use Src\Includes\Form\Inputs\Submit;
use Src\Includes\Form\Inputs\Tel;
use Src\Includes\Form\Inputs\Text;
use Src\Includes\Form\Inputs\Textarea;
use Src\Includes\Form\Inputs\Time;
use Src\Includes\Form\Inputs\Url;
use Src\Includes\Form\Inputs\Week;

/*
 * Creates form inputs and html elements
 */

class InputFactory
{
	/*
	 * Track inputs
	 */
	private $count = 0;
    
    /*
     * Input types => Class names
     */
    private $types = array(
        'button' => 'Button',
        'checkbox' => 'Checkbox',
        'color' => 'Color',
        'date' => 'Date',
        'datetime' => 'Datetime',
        'datetime-local' => 'DatetimeLocal',
        'email' => 'Email',
        'file' => 'File',
        'hidden' => 'Hidden',
        'image' => 'Image',
        'month' => 'Month',
        'number' => 'Number',
        'password' => 'Password',
        'radio' => 'Radio',
        'range' => 'Range',
        'reset' => 'Reset',
        'search' => 'Search',
        'select' => 'Select',
        'submit' => 'Submit',
        'tel' => 'Tel',
        'text' => 'Text',
        'textarea' => 'Textarea',
        'time' => 'Time',
        'url' => 'Url',
        'week' => 'Week'
    );
	
	/*
	 * Return an input
	 */
	public function newInput( $type )
	{
        if ( array_key_exists( $type, $this->types ) ) {
            $class = $this->types[$type];
        } else {
			$class = 'Text';
        }
		
		$class = 'Src\Includes\Form\Inputs\\' . $class;
		return new $class;
	}
}