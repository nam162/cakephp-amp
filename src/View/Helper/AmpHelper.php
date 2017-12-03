<?php
namespace Amp\View\Helper;

use Amp\Core\AmpConfigure;
use Cake\Utility\Hash;
use Cake\View\Helper\HtmlHelper;

class AmpHelper extends HtmlHelper
{
	public $helpers = ['Url'];

	public function initialize(array $config)
	{
		parent::initialize($config);
	}

	/**
	 * AMP JSライブラリタグを出力
	 *
	 * @return string AMP JSライブラリタグ
	 */
	public function library()
	{
		return parent::script(AmpConfigure::read('library'), ['async']);
	}

	/**
	 * AMP Boilerplateタグを出力
	 *
	 * @return string AMP Boilerplateタグ
	 */
	public function boilerplate()
	{
		$boilerplate = AmpConfigure::read('Boilerplate');

		$default  = parent::tag('style', $boilerplate['default'], ['amp-boilerplate']);
		$noscript = parent::tag('style', $boilerplate['noscript'], ['amp-boilerplate']);

		return $default . parent::tag('noscript', $noscript, ['escape' => false]);
	}

	/**
	 * AMP カスタムJSライブラリタグを出力
	 * ・AMP無効時はタグを出力しない
	 *
	 * @param array $url ライブラリ名 => ライブラリURL
	 * @param array $options
	 * @return string AMP カスタムJSライブラリタグ
	 */
	public function script($url, array $options = [])
	{
		if (!$this->_View->amp) {
			return null;
		} else {
			$options += ['block' => null];

			$out = '';
			foreach ($url as $name => $path) {
				if (!isset($name)) {
					continue;
				}

				$out .= parent::script($path, ['async', 'custom-element' => 'amp-' . $name] + $options);
			}

			if (empty($options['block'])) {
				return $out;
			}

			if ($options['block'] === true) {
				$options['block'] = 'amp-' + __FUNCTION__;
			} else {
				$options['block'] = 'amp-' + $options['block'];
			}

			$this->_View->append($options['block'], $out);
		}
	}

	public function css($url, array $options = [])
	{
		$options += ['amp' => true];

		if ($options['amp'] === false) {
			return null;
		}

		$out = '';
		foreach ($url as $path) {
			$css = file_get_contents($this->Url->css(WWW_ROOT . 'css/' . $path));
			if (!empty($css)) {
				$out .= $css;
			}
		}

		$this->_View->append('amp-css', $out);
	}

	/**
	 * AMP 画像タグを出力
	 *
	 * @param $path
	 * @param array $options
	 * @return string AMP 画像タグ
	 */
	public function image($path, array $options = [])
	{
		$options += ['layout' => 'responsive', 'alt' => ''];

		$path = $this->Url->image($path);

		return parent::tag('amp-img', '', ['src' => $path] + $options);
	}
}
