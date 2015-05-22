<?php
namespace Src\Modules\Index\Models;

use Src\Modules\Index\Models\AbstractBlockModel;

class JoinBlockModel extends AbstractBlockModel
{
	/*
	 * Set default data
	 */
	public function setData() {
		$this->title = "Stay Focused";
		$this->action['text'] = "Create an Account";
		$this->action['guid'] = "signup";
	}
	
	/*
	 * Set subsections
	 */
	public function setSubsections() {
		$this->subsections[] = new JoinFormSubsectionModel;
		$this->subsections[] = new JoinProfileSubsectionModel;
	}
}
