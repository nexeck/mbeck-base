<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Abstract Controller Website
 *
 * @author Marcel Beck <fo3nik5@gmail.com>
 */

abstract class Abstract_Controller_Website extends Controller {
	/**
	 * @var object the content View object
	 */
	public $view = null;

	/**
	 * @var	bool	auto render template
	 **/
	protected $auto_render = true;

	/**
	 * Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
	 *
	 * Can be set to a string or an array, for example array('login', 'admin') or 'login'
	 */
	protected $auth_required = false;

	/**
	 * @var bool is ajax Request
	 */
	protected $is_ajax = false;

	/**
	 * @var bool is internal Request
	 */
	protected $is_internal = false;

	/**
	 * @var Directory
	 */
	protected $directory;

	/**
	 * @var Controller
	 */
	protected $controller;

	/**
	 * @var Action
	 */
	protected $action;

	public function before()
	{
		$this->is_ajax = (bool)$this->request->is_ajax();
		$this->is_internal = (bool)!($this->request->is_initial());

		$this->directory = $this->request->directory();
		$this->controller = $this->request->controller();
		$this->action = $this->request->action();

		$this->view = $this->_request_view();
	}

	/**
	 * Assigns the title to the template.
	 *
	 * @param	 string	 request method
	 * @return	void
	 */
	public function after()
	{
		if ($this->auto_render === true)
		{
			if ($this->view !== null)
			{
				if (($this->is_internal === true) or ($this->is_ajax === true))
				{
					$this->view->render_layout = false;
				}
				$this->response->body($this->view);
			}
		}

		parent::after();
	}

	/**
	 * Creates the View
	 *
	 * @return Kostache|null
	 */
	protected function _request_view()
	{
		$directory = $this->directory ? $this->directory . '_' : '';

		$view_name = 'View_' . $directory . $this->controller . '_' . $this->action;

		if (Kohana::find_file('classes', strtolower(str_replace('_', '/', $view_name))) === false)
		{
			return null;
		}

		return new $view_name;
	}

} // Abstract_Controller_Website
