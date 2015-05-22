<?php
namespace Src\Modules\Profile\Views;

class StabilityView extends AbstractProfileDataView
{
	protected $title = 'Stability';
	
	protected function buildContent()
	{
		$this->content = '<div id="profile-data-stability>" data-stability="' . $this->data['stability'] . '">' . $this->data['stability'] . '</div>';
	}
	
}
