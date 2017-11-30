<?php
namespace Amp\View\Helper;

use Amp\Core\AmpConfigure;
use Cake\Utility\Hash;
use Cake\View\Helper;

class AmpHelper extends Helper
{
	public $helpers = ['Html', 'Url'];

	/**
	 * AMP JSライブラリタグを出力
	 *
	 * @return string AMP JSライブラリタグ
	 */
	public function library()
	{
		return $this->Html->script(AmpConfigure::read('library'), ['async']);
	}

	/**
	 * AMP Boilerplateタグを出力
	 *
	 * @return string AMP Boilerplateタグ
	 */
	public function boilerplate()
	{
		$boilerplate = AmpConfigure::read('Boilerplate');

		$default  = $this->Html->tag('style', Hash::get($boilerplate, 'default', ''), ['amp-boilerplate']);
		$noscript = $this->Html->tag('style', Hash::get($boilerplate, 'noscript', ''), ['amp-boilerplate']);

		return $default . $this->Html->tag('noscript', $noscript, ['escape' => false]);
	}

	/**
	 * AMP カスタムJSライブラリタグを出力
	 *
	 * @param array $url ライブラリ名 => ライブラリURL
	 * @param array $options
	 * @return string AMP カスタムJSライブラリタグ
	 */
	public function script($url, array $options = [])
	{
		$options += ['block' => null];

		if ($options['block'] === true) {
			$options['block'] = 'amp-' . __FUNCTION__;
		}

		if (is_array($url)) {
			$out = '';
			foreach ($url as $name => $path) {
				$out .= $this->Html->script($path, $options + ['async', 'custom-element' => 'amp-' . $name]);
			}
		}

		if (empty($options['block'])) {
			return $out;
		}

		$this->_View->append($options['block'], $out);
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

		$path = $this->Url->image($path, $options);

		return $this->Html->tag('amp-img', '', ['src' => $path] + $options);
	}
}
