<?php
namespace Amp\View\Helper;

use Cake\View\Helper\HtmlHelper as CakeHtmlHelper;

class HtmlHelper extends CakeHtmlHelper
{
	public function initialize(array $config)
	{
		parent::initialize($config);
	}

	/**
	 * JSタグを出力
	 * ・AMP有効時はタグを出力しない
	 *
	 * @param array $url ライブラリ名 => ライブラリURL
	 * @param array $options
	 * @return string AMP カスタムJSライブラリタグ
	 */
	public function script($url, array $options = [])
	{
		if ($this->_View->amp) {
			return null;
		} else {
			parent::sciprt($url, $options);
		}
	}
}
