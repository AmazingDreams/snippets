<?php

class File_Manager {

	/**
	 * @var  String  Holds the filename (e.g. index.php)
	 */
	protected $_filename;

	/**
	 * @var  String  Holds the full path to that file
	 */
	protected $_dirpath;

	/**
	 * Create a new File manager object
	 *
	 * @param  String  Requested filename
	 */
	public function __construct($filename)
	{
		$this->_filename = $filename;

		if(is_dir($this->get_path($filename)))
		{
			$this->_dirpath  = $this->get_path($this->_filename);
			$this->_filename = $this->get_first_file();
		}
		else
		{
			$this->_dirpath = $this->get_path(dirname($filename));
		}
	}

	/**
	 * Get the first file in the current working directory
	 *
	 * @return  Mixed  Filename if one is found
	 *                 NULL if no file is found
	 */
	public function get_first_file()
	{
		foreach($this->read_current_working_directory() as $node)
		{
			// Check if the node is a file
			if(is_file($this->get_path($node)))
			{
				return $node;
			}
		}

		return NULL;
	}

	/**
	 * Reads the contents of given directory
	 *
	 * @param   String  Path to directory
	 * @return  Array   List of found nodes
	 */
	public function read_directory($directory_string)
	{
		$directory_string = $this->get_path($directory_string);

		// Check if directory exists
		if( ! ($directory = opendir($directory_string)))
		{
			return array();
		}

		$array = array();
		while($entry = readdir($directory))
		{
			// Skip files starting with '.'
			if(strpos($entry, '.') === 0) continue;
			
			$array[] = $entry;
		}
		closedir($directory);

		return $array;
	}

	/**
	 * Read the current working directory and order the files by date
	 *
	 * @return  Array  List of found nodes orderd by filemtime
	 */
	public function read_current_working_directory()
	{
		$array = array();

		foreach($this->read_directory($this->get_current_working_dir()) as $node)
		{
			$array[filemtime($this->get_path($node))] = $node;
		}

		krsort($array);

		return $array;
	}

	/**
	 * Get the base directory where the snippets are stored
	 *
	 * @return  String  Directory where the snippets are stored
	 */
	public function get_snippet_base_dir()
	{
		return INSTALL_DIR .'/'. Manager::$snippets;
	}

	/**
	 * Get the relative path from the snippet base directory to requested node
	 * This is used for getting the URL correct
	 *
	 * @param   String   Requested node
	 * @param   Boolean  Append the current working directory for you or is it already appended?
	 * @return  String   Relative path from snippet base directory
	 */
	public function get_snippet_path($nodename, $add_working_dir = TRUE)
	{
		$nodename = ($add_working_dir) ? "{$this->get_current_working_dir()}/$nodename" : $nodename;
		$nodename = $this->get_path($nodename);

		return str_replace($this->get_snippet_base_dir(), '', $nodename);
	}

	/**
	 * Get the full path to requested node
	 *
	 * @param    String  Requested node
	 * @return   String  Full path to requested node
	 */
	public function get_path($append)
	{
		if(strpos($append, '/') === 0)
		{
			return $append;
		}

		return "{$this->get_snippet_base_dir()}/$append";
	}


	/**
	 * Get the directory above the current working directory
	 *
	 * @return  Mixed  String if there is an up directory
	 *                 Null if there is not (because we already are in the base directory
	 */
	public function get_up_dir()
	{
		if(dirname($this->get_current_working_dir()) !== INSTALL_DIR)
		{
			return dirname($this->get_current_working_dir());
		}
		
		return NULL;
	}

	/**
	 * Get the current working directory
	 *
	 * @return  String  Full path to current working directory
	 */
	public function get_current_working_dir()
	{
		return $this->get_path($this->_dirpath);
	}

	/**
	 * Get the full path to the current working file
	 *
	 * @return  String  Full path to current working file
	 */
	public function get_current_working_file()
	{
		return $this->get_current_working_directory() .'/'. $this->_filename;
	}

	/**
	 * Get the current working file extension
	 *
	 * @return  String  Extension of current working file
	 */
	public function get_current_working_file_extension()
	{
		return preg_replace('/^.*\.([^.]+)$/D', '$1', $this->_filename);
	}
}
