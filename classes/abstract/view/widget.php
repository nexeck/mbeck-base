<?php defined('SYSPATH') or die('No direct script access.');

abstract class Abstract_View_Widget extends Abstract_View_Layout {

	/**
	 * Setting render layout to FALSE to ensure full layout is not created
	 * @var	boolean
	 */
	public $render_layout = false;

} // End Abstract_View_Widget
