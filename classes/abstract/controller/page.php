<?php
/**
 * @package
 * @author Marcel Beck <fo3nik5@gmail.com>
 * Date: 17.07.11
 * Time: 11:48
 */

abstract class Abstract_Controller_Page extends Abstract_Controller_Website {

	protected function _request_view()
	{
		// Removes leading slash if this is not a subdirectory controller
		$controller_path = trim($this->directory . '/' . $this->controller . '/' . $this->action, '/');

		try
		{
			$view = Kostache::factory('page' . '/' . $controller_path);
		}
		catch (Kohana_View_Exception $x)
		{
			/*
			 * The View class could not be found, so the controller action is
			 * repsonsible for making sure this is resolved.
			 */
			$view = null;
		}

		return $view;
	}
} // Abstract_Controller_Page
