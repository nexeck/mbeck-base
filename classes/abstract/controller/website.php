<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marcel.beck
 * Date: 08.04.11
 * Time: 15:39
 * To change this template use File | Settings | File Templates.
 */

abstract class Abstract_Controller_Website extends Kohana_Controller {

	/**
	 * @var object the content View object
	 */
	public $layout;

	/**
	 * @var	bool	auto render template
	 **/
	public $auto_render = TRUE;

	/**
	 * Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
	 *
	 * Can be set to a string or an array, for example array('login', 'admin') or 'login'
	 */
	public $auth_required = FALSE;

	/**
	 * Is Ajax Request
	 *
	 * @var bool
	 */
	public $is_ajax = FALSE;

	/**
	 * Is Internal Request
	 *
	 * @var bool
	 */
	public $is_internal = FALSE;

	/**
	 * Directory
	 *
	 * @var
	 */
	public $directory;

	/**
	 * Controller
	 *
	 * @var
	 */
	public $controller;

	/**
	 * Action
	 *
	 * @var
	 */
	public $action;

	/**
	 * The before() method is called before your controller action.
	 * In our template controller we override this method so that we can
	 * set up default values. These variables are then available to our
	 * controllers if they need to be modified.
	 */
	public function before() {

		// Set default title and content views (path only)
		$this->is_ajax = (bool)$this->request->is_ajax();
		$this->is_internal = (bool)!($this->request->is_initial());

		$this->directory = $this->request->directory();
		$this->controller = $this->request->controller();
		$this->action = $this->request->action();

		// Removes leading slash if this is not a subdirectory controller
		$controller_path = trim($this->directory.'/'.$this->controller.'/'.$this->action, '/');

		if ($this->auto_render === TRUE) {
			try
			{
				$this->layout = Kostache::factory($controller_path);
			}
			catch (Kohana_Exception $x)
			{
				/*
							 * The View class could not be found, so the controller action is
							 * repsonsible for making sure this is resolved.
							 */
				$this->layout = NULL;
			}
		}

		return parent::before();

	}

	/**
	 * The after() method is called after your controller action.
	 * In our template controller we override this method so that we can
	 * make any last minute modifications to the template before anything
	 * is rendered.
	 */
	public function after() {
		if ($this->auto_render === TRUE) {
			// If content is NULL, then there is no View to render
			if ($this->layout === NULL)
				throw new Kohana_View_Exception('There was no View created for this request.');

			if (($this->is_internal === TRUE) OR ($this->is_ajax === TRUE)) {
				$this->layout->render_layout = FALSE;
			}
			$this->response->body($this->layout->render());
		}

		return parent::after();
	}
}