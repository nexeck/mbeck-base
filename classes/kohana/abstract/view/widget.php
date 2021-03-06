<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Abstract View Widget
 *
 * @author Marcel Beck <fo3nik5@gmail.com>
 */

abstract class Kohana_Abstract_View_Widget extends Abstract_View_Layout {

	/**
	 * Setting render layout to false to ensure full layout is not created
	 * @var	boolean
	 */
	public $render_layout = false;

} // End Kohana_Abstract_View_Widget
