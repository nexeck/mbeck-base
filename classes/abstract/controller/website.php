<?php
/**
 * @package
 * @author Marcel Beck <fo3nik5@gmail.com>
 * Date: 17.07.11
 * Time: 11:47
 */

abstract class Abstract_Controller_Website extends Controller {
	/**
	 * @var object the content View object
	 */
	public $view;

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
		if ($this->auto_render === true) {
			// If content is NULL, then there is no View to render
			if ($this->view === null)
				throw new Kohana_View_Exception('There was no View created for this request.');

			if (($this->is_internal === true) or ($this->is_ajax === true))
			{
				$this->view->render_layout = false;
			}
			$this->response->body($this->view);
		}

		parent::after();
	}

	abstract protected function _request_view();

} // Abstract_Controller_Base
