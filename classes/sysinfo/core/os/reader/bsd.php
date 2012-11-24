<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Common reader for BSD OSes
 *
 * @package    SysInfo
 * @category   OS
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
abstract class SysInfo_Core_OS_Reader_BSD implements SysInfo_OS_Reader {

	// Commands with useful info
	const CMD_SYSCTL = 'sysctl';
	const CMD_PS     = 'ps';

	// Sysctl values
	const SYSCTL_KERN_BOOTTIME = 'kern.boottime';
	const SYSCTL_VM_LOADAVG    = 'vm.loadavg';

	/**
	 * @var  SysInfo_System_Reader
	 */
	protected $_reader;

	/**
	 * Sets a system command reader
	 *
	 * @param   SysInfo_System_Reader_Command
	 * @return  void
	 */
	public function __construct(SysInfo_System_Reader_Command $reader = NULL)
	{
		$this->_reader = $reader;
	}

	/**
	 * Implements [SysInfo_OS_Reader::os]
	 *
	 * @see  SysInfo_OS_Reader::os
	 *
	 * @return  array
	 */
	public function os()
	{
		return array(
			'name'    => php_uname('s'),
			'version' => php_uname('r'),
		);
	}

	/**
	 * Implements [SysInfo_OS_Reader::kernel]
	 *
	 * @see  SysInfo_OS_Reader::kernel
	 *
	 * @return  string
	 */
	public function kernel()
	{
		// No kernel version in the BSD world
		return NULL;
	}

	/**
	 * Implements [SysInfo_OS_Reader::hostname]
	 *
	 * @see  SysInfo_OS_Reader::hostname
	 *
	 * @return  string
	 */
	public function hostname()
	{
		return php_uname('n');
	}

	/**
	 * Implements [SysInfo_OS_Reader::ip]
	 *
	 * @see  SysInfo_OS_Reader::ip
	 *
	 * @return  string
	 */
	public function ip()
	{
		$ip = $_SERVER['SERVER_ADDR'];

		return $ip ? $ip : gethostbyname($this->hostname());
	}

	/**
	 * Implements [SysInfo_OS_Reader::uptime]
	 *
	 * @see  SysInfo_OS_Reader::uptime
	 *
	 * @return  int
	 */
	public function uptime()
	{
		$this->_reader->command(SysInfo_OS_Reader_BSD::CMD_SYSCTL);
		$this->_reader->args(SysInfo_OS_Reader_BSD::SYSCTL_KERN_BOOTTIME);

		try
		{
			$content = $this->_reader->read();
		}
		catch(SysInfo_System_Reader_Exception $e)
		{
			return NULL;
		}

		if ( ! preg_match('/\{ sec \= (\d+).+$/', $content, $match))
		{
			return $output;
		}

		return time() - (int) $match[1];
	}

	/**
	 * Implements [SysInfo_OS_Reader::load]
	 *
	 * @see  SysInfo_OS_Reader::load
	 *
	 * @return  array
	 */
	public function load()
	{
		$output = array(
			'1min'  => NULL,
			'5min'  => NULL,
			'15min' => NULL,
		);

		$this->_reader->command(SysInfo_OS_Reader_BSD::CMD_SYSCTL);
		$this->_reader->args('vm.loadavg');

		try
		{
			$content = $this->_reader->read();
		}
		catch(SysInfo_System_Reader_Exception $e)
		{
			return $output;
		}

		if (preg_match('/(\d+\.\d{1,2}) (\d+\.\d{1,2}) (\d+\.\d{1,2})/', $content, $match) == 0)
		{
			return $output;
		}

		return array(
			'1min'  => $match[1],
			'5min'  => $match[2],
			'15min' => $match[3]
		);
	}

	/**
	 * Implements [SysInfo_OS_Reader::arch]
	 *
	 * @see  SysInfo_OS_Reader::arch
	 *
	 * @return  string
	 */
	public function arch()
	{
		return NULL;
	}

	/**
	 * Implements [SysInfo_OS_Reader::cpuinfo]
	 *
	 * @see  SysInfo_OS_Reader::cpuinfo
	 *
	 * @return  array
	 */
	public function cpuinfo()
	{
		return array();
	}

	/**
	 * Implements [SysInfo_OS_Reader::meminfo]
	 *
	 * @see  SysInfo_OS_Reader::meminfo
	 *
	 * @return  array
	 */
	public function meminfo()
	{
		return array();
	}

	/**
	 * Implements [SysInfo_OS_Reader::scsi]
	 *
	 * @see  SysInfo_OS_Reader::scsi
	 *
	 * @return  array
	 */
	public function scsi()
	{
		return array();
	}

	/**
	 * Implements [SysInfo_OS_Reader::devices]
	 *
	 * @see  SysInfo_OS_Reader::devices
	 *
	 * @return  array
	 */
	public function devices()
	{
		return array();
	}

	/**
	 * Implements [SysInfo_OS_Reader::raid]
	 *
	 * @see  SysInfo_OS_Reader::raid
	 *
	 * @return  array
	 */
	public function raid()
	{
		return array();
	}

	/**
	 * Implements [SysInfo_OS_Reader::mounts]
	 *
	 * @see  SysInfo_OS_Reader::mounts
	 *
	 * @return  array
	 */
	public function mounts()
	{
		return array();
	}

	/**
	 * Implements [SysInfo_OS_Reader::network]
	 *
	 * @see  SysInfo_OS_Reader::network
	 *
	 * @return  array
	 */
	public function network()
	{
		return array();
	}

	/**
	 * Implements [SysInfo_OS_Reader::procstat]
	 *
	 * @see  SysInfo_OS_Reader::procstat
	 *
	 * @return  array
	 */
	public function procstat()
	{
		$output = array(
			'running'  => 0,
			'zombie'   => 0,
			'sleeping' => 0,
			'stopped'  => 0,
			'total'    => 0,
			'threads'  => 0,
		);

		$this->_reader->command(SysInfo_OS_Reader_BSD::CMD_PS);
		$this->_reader->args('-ax');

		try
		{
			$content = $this->_reader->read();
		}
		catch(SysInfo_System_Reader_Exception $e)
		{
			return $output;
		}

		// Match them
		preg_match_all('/^\s*\d+\s+[\w?]+\s+([A-Z])\S*\s+.+$/m', $content, $processes, PREG_SET_ORDER);

		// Get total
		$output['total'] = count($processes);

		foreach ($processes as $process)
		{
			switch ($process[1])
			{
				case 'S':
				case 'I':
					$output['sleeping']++;
					break;

				case 'Z':
					$output['zombie']++;
					break;

				case 'R':
				case 'D':
				case 'O':
					$output['running']++;
					break;

				case 'T':
					$output['stopped']++;
					break;
			}
		}

		return $output;
	}

	/**
	 * Implements [SysInfo_OS_Reader::users]
	 *
	 * @see  SysInfo_OS_Reader::users
	 *
	 * @return  int
	 */
	public function users()
	{
		return NULL;
	}
}
