<?php
/**
 * @package
 * @author Marcel Beck <fo3nik5@gmail.com>
 * Date: 17.07.11
 * Time: 11:47
 */

abstract class Abstract_Controller_Base extends Controller {
	/**
	 * @var object the content View object
	 */
	public $view;

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
	 * @var bool is ajax Request
	 */
	public $is_ajax = FALSE;

	/**
	 * @var bool is internal Request
	 */
	public $is_internal = FALSE;

	/**
	 * @var Directory
	 */
	public $directory;

	/**
	 * @var Controller
	 */
	public $controller;

	/**
	 * @var Action
	 */
	public $action;

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
		// If content is NULL, then there is no View to render
		if ($this->view === NULL)
			throw new Kohana_View_Exception('There was no View created for this request.');

		if (($this->is_internal === TRUE) OR ($this->is_ajax === TRUE))
		{
			$this->view->render_layout = FALSE;
		}
		$this->response->body($this->view);
	}

	abstract protected function _request_view();
} // Abstract_Controller_Base
