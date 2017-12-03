<?php
namespace Amp\View;

use Cake\View\View;

class AmpView extends View
{
	public $amp = false;

	public function initialize()
	{
		parent::initialize();

		$this->amp = $this->get('amp', false);

		if ($this->amp) {
			$this->loadHelper('Html', ['className' => 'Amp.Amp']);
		} else {
			$this->loadHelper('Html', ['className' => 'Html']);
		}
	}
}
