<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Abstract View Layout
 *
 * @author Marcel Beck <fo3nik5@gmail.com>
 */

abstract class Abstract_View_Layout extends Kohana_Kostache_Layout {

	/**
	 * @var	string	character set of input and output
	 */
	public $charset;

	/**
	 * @var	string	target language: en-us, es-es, zh-cn, etc
	 */
	public $lang;

	/**
	 * @var	bool	are we in production?
	 */
	public $production;

	/**
	 * Layout
	 *
	 * @var string
	 */
	protected $_layout = 'layout/default';

	/**
	 * Partials
	 *
	 * @var array
	 */
	protected $_partials = array();

	/**
	 * Titel
	 *
	 * @var string
	 */
	public $title = 'Default Page Title';


	/**
	 * Var method to get the base url for the application
	 *
	 * @return string
	 */
	public function base()
	{
		return url::base(false, true);
	}

	/**
	 * Lambda function to alternate between a set of strings
	 *
	 * // This will alternate between 'one', 'two', 'three', and 'four'
	 * {{#alternate}}one|two|three|four{{/alternate}}
	 *
	 * @param	 string a pipe-separated list of strings
	 * @return	string
	 */
	public function alternate()
	{
		return function($string)
		{
			return call_user_func_array('Text::alternate', explode('|', $string));
		};
	}

	/**
	 * Lambda function to translate strings
	 *
	 * @param string
	 * @return string
	 */
	public function i18n()
	{
		return function($string)
		{
			return __($string);
		};
	}

	/**
	 * @return mixed
	 */
	public function logged_in()
	{
		return Auth::instance()->logged_in();
	}

	/**
	 * @return mixed
	 */
	public function is_admin()
	{
		return Auth::instance()->logged_in('admin');
	}

	/**
	 * @return mixed
	 */
	public function auth_get_username()
	{
		return Auth::instance()->get_user()->username;
	}

	/**
	 * Page Titel
	 *
	 * @return string
	 */
	public function title()
	{
		return __($this->title);
	}

	/**
	 * Hints
	 *
	 * @return array
	 */
	public function hints()
	{
		$data = array();

		if (($messages = Hint::get(null, null, true)) !== null)
		{
			foreach ($messages as $message)
			{
				$data[] = array
				(
					'type' => $message['type'],
					'text' => $message['text'],
				);
			}
		}
		return $data;
	}

	/**
	 * Profiler
	 *
	 * @return string|View
	 */
	public function profiler()
	{
		return Kohana::$environment > Kohana::STAGING ? View::factory('profiler/stats') : '';
	}

	/**
	 * Render Assets:css
	 *
	 * @return mixed
	 */
	public function assets_css()
	{
		return Assets::css();
	}

	/**
	 * Render Assets::js
	 *
	 * @return mixed
	 */
	public function assets_js()
	{
		return Assets::js();
	}

	/**
	 * Renders the template using the current view.
	 *
	 * @return	string
	 */
	public function render()
	{
		$this->charset = Kohana::$charset;
		$this->lang = I18n::$lang;
		$this->production = Kohana::$environment === Kohana::PRODUCTION;
		if (Kohana::$profiling === true)
		{
			// Start a new benchmark
			$benchmark = Profiler::start('Layout', __FUNCTION__);
		}

		$rendered = parent::render();

		if (isset($benchmark))
		{
			// Stop the benchmark
			Profiler::stop($benchmark);
		}

		return $rendered;
	}

} // End Abstract_View_Layout
