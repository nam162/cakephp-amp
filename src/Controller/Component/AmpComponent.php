<?php
namespace Amp\Controller\Component;

use Cake\Controller\Component;

class AmpComponent extends Component
{
	public $Controller = null;

	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->Controller = $this->_registry->getController();
	}

	public function init()
	{
		$this->Controller->set('amp', $this->Controller->request->getParam('amp', false));
	}
}
