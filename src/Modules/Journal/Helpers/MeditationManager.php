<?php
namespace Src\Modules\Journal\Helpers;

/*
 * Testing meditation record access for edit and delete
 */
class MeditationManager
{
	/*
	 * Confirm that the user can modify a single meditation
	 */
	protected function setMeditationId()
	{
		// Set the mid
		$this->mid = htmlspecialchars( $_GET['mid'] );
		// Instantiate the single meditation class
		$this->Model = new ActionModel( $this->mid );
		
		if ( !$this->Model->userCanAccess() ) {
			$this->action = null;
			$this->mid = null;
			$this->Model = null;

			return false;
		}
		
		return true;
	}
}
