<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * File info reader
 *
 * As every object in the *nix world is a file,
 * we are simple getting info by reading those files.
 *
 * @package    SysInfo
 * @category   System
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
class SysInfo_Core_System_Reader_File implements SysInfo_System_Reader {

	/**
	 * @var  string  File name to read
	 */
	protected $_filename;

	/**
	 * Creates a new file info reader
	 *
	 * @param   string  File name to read
	 * @return  void
	 */
	public function __construct($filename = NULL)
	{
		$this->_filename = $filename;
	}

	/**
	 * Sets a file name to read
	 *
	 * @param   string  File name to read
	 * @return  void
	 */
	public function filename($filename)
	{
		$this->_filename = $filename;
	}

	/**
	 * Find pathnames matching a pattern
	 *
	 * @param   string  The pattern
	 * @param   int     Flags
	 * @return  array
	 */
	public function glob($pattern, $flags = GLOB_NOSORT)
	{
		return (array) glob($pattern, $flags);
	}

	/**
	 * Can we read the current file?
	 *
	 * @return  bool
	 */
	public function is_valid()
	{
		return is_file($this->_filename) AND is_readable($this->_filename);
	}

	/**
	 * Implements [SysInfo_System_Reader::read]
	 *
	 * @see     SysInfo_System_Reader::read
	 * @throws  SysInfo_System_Reader_Exception
	 *
	 * @return  string
	 */
	public function read()
	{
		if ( ! $this->is_valid())
			throw new SysInfo_System_Reader_Exception('File does not exists or not readable [ :filename ]', array(
				':filename' => $this->_filename,
			));

		try
		{
			$contents = file_get_contents($this->_filename);
		}
		catch(Exception $e)
		{
			throw new SysInfo_System_Reader_Exception('Unable to get content of a file [ :filename ]', array(
				':filename' => $this->_filename,
			));
		}

		if ($contents === FALSE)
			throw new SysInfo_System_Reader_Exception('Failed reading a file [ :filename ]', array(
				':filename' => $this->_filename,
			));

		return trim($contents);
	}
}
