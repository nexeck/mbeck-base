<?php defined('SYSPATH') or die('No direct script access.');
 /**
 * Created by JetBrains PhpStorm.
 * User: marcel.beck
 * Date: 08.04.11
 * Time: 15:39
 * Contains methods useful to views that use layouts
 */
abstract class Abstract_View_Widget extends Abstract_View_Layout {

	/**
	 * Setting render layout to FALSE to ensure full layout is not created
	 * @var	boolean
	 */
	public $render_layout = FALSE;

} // End Abstract_View_Widget