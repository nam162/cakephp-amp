<?php
namespace Amp\Core;

use Cake\Core\Configure;

class AmpConfigure extends Configure
{
	public static function read($var = null, $default = null)
	{
		if (isset($var)) {
			$var = 'Amp.' . $var;
		} else {
			$var = 'Amp';
		}

		return parent::read($var, $default);
	}
}
