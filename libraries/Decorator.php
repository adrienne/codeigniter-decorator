<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Decorator {
	
	private $_decorators_directory_name = 'decorators';
	
	private $_ci;
	private $_decorators_directory;

	public function __construct()
	{
		$this->_ci =& get_instance();

		$this->_decorators_directory = rtrim(APPPATH, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$this->_decorators_directory_name.DIRECTORY_SEPARATOR;

		log_message('debug', 'Decorator class initialized');
	}

	public function decorate($class = NULL, $method = NULL)
	{
		// try to guess the class
		if ( ! $class)
		{
			$class = $this->_ci->router->class.'_decorator';
		}

		// try to guess the method
		if ( ! $method)
		{
			$method = $this->_ci->router->method;
		}

		// set the full file path to be loaded
		$file = $this->_decorators_directory.$class.'.php';

		// see if a decorator exists
		if (file_exists($file))
		{
			// require the decorator
			require($file);

			// get the decorated data
			$decorator = new $class();
			return $decorator->{$method}();
		}
		else
		{
			show_error('Decorator <em>'.$this->_decorators_directory.$class.'</em> could not be found.');
		}
	}
}