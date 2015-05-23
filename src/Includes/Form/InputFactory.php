<?php
namespace Src\Lib\Form;

use Src\Lib\Form\Inputs\Button as Button;
use Src\Lib\Form\Inputs\Checkbox;
use Src\Lib\Form\Inputs\Color;
use Src\Lib\Form\Inputs\Date;
use Src\Lib\Form\Inputs\Datetime;
use Src\Lib\Form\Inputs\DatetimeLocal;
use Src\Lib\Form\Inputs\Email;
use Src\Lib\Form\Inputs\File;
use Src\Lib\Form\Inputs\Hidden;
use Src\Lib\Form\Inputs\Image;
use Src\Lib\Form\Inputs\Month;
use Src\Lib\Form\Inputs\Number;
use Src\Lib\Form\Inputs\Password;
use Src\Lib\Form\Inputs\Radio;
use Src\Lib\Form\Inputs\Range;
use Src\Lib\Form\Inputs\Reset;
use Src\Lib\Form\Inputs\Search;
use Src\Lib\Form\Inputs\Select;
use Src\Lib\Form\Inputs\Submit;
use Src\Lib\Form\Inputs\Tel;
use Src\Lib\Form\Inputs\Text;
use Src\Lib\Form\Inputs\Textarea;
use Src\Lib\Form\Inputs\Time;
use Src\Lib\Form\Inputs\Url;
use Src\Lib\Form\Inputs\Week;

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
		
		$class = 'Src\Lib\Form\Inputs\\' . $class;
		return new $class;
	}
}