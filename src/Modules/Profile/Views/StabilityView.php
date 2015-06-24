<?php
namespace Src\Modules\Profile\Views;

class StabilityView extends AbstractProfileDataView
{
	protected $title = 'Stability';
	
	protected function buildContent()
	{
		$this->content = '
        <div id="profile-data-stability" class="profile-data-small-display" data-stability="' . $this->data['stability'] . '">
            <canvas></canvas>
            <div id="profile-data-stability-overlay">
                <p class="profile-data-score"><span>' . $this->data['stability'] . '</span> / 100</p>
                <p class="profile-data-description">Meditate longer to increase your stability</p>
            </div>
        </div>

        <div class="profile-data-inspect">i</div>
        ';
	}
	
}
