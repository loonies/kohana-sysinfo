<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Command info reader
 *
 * Uses a command to read info.
 *
 * @package    SysInfo
 * @category   System
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
class SysInfo_Core_System_Reader_Command implements SysInfo_System_Reader {

	/**
	 * @var  array  Search paths
	 */
	protected $_paths = array('/bin', '/sbin', '/usr/bin', '/usr/sbin', '/usr/local/bin', '/usr/local/sbin');

	/**
	 * @var  string  Command to execute
	 */
	protected $_command = NULL;

	/**
	 * @var  string  Command arguments
	 */
	protected $_args = NULL;

	/**
	 * Creates a new command system reader
	 *
	 * @param   string  Command to execute
	 * @param   array   Search paths
	 * @return  void
	 */
	public function __construct($command = NULL, array $paths = NULL)
	{
		$this->_command = $command;

		if ($paths !== NULL)
		{
			$this->_paths = $paths;
		}
	}

	/**
	 * Sets command to execute
	 *
	 * @param   string
	 * @return  void
	 */
	public function command($command)
	{
		$this->_command = $command;
	}

	/**
	 * Sets command arguments
	 *
	 * @param   string
	 * @return  void
	 */
	public function args($args)
	{
		$this->_args = $args;
	}

	/**
	 * Implements [SysInfo_System_Reader::read]
	 *
	 * @see     SysInfo_System_Reader::read
	 * @throws  SysInfo_System_Reader_Exception
	 *
	 * @return  void
	 */
	public function read()
	{
		if ($this->_command === NULL)
			throw new SysInfo_System_Reader_Exception('Command to execute not set');

		foreach ($this->_paths as $path)
		{
			// Normalize path
			$path = rtrim($path, '/').'/';

			$command = $path.escapeshellcmd($this->_command);

			if (is_file($command) AND is_executable($command))
			{
				if ( ! empty($this->_args))
				{
					// Include arguments
					$command .= ' '.escapeshellarg($this->_args);
				}

				$command .= ' 2>&1';

				exec($command, $output, $code);

				$output = implode(PHP_EOL, $output);

				if ($code !== 0)
					throw new SysInfo_System_Reader_Exception('Error executing command [ :command ] with the message [ :message ]', array(
						':command' => $command,
						':message' => $output,
					), (int) $code);

				return $output;
			}
		}

		throw new SysInfo_System_Reader_Exception('Unable to read system information by using command [ :command ]', array(
			':command' => $command,
		));
	}
}
