<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Linux OS reader
 *
 * @package    SysInfo
 * @category   OS
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
class SysInfo_Core_OS_Reader_Linux implements SysInfo_OS_Reader {

	// "/proc" files with useful info
	const PROC_VERSION      = '/proc/version';
	const PROC_HOSTNAME     = '/proc/sys/kernel/hostname';
	const PROC_UPTIME       = '/proc/uptime';
	const PROC_LOADAVG      = '/proc/loadavg';
	const PROC_GLOB_STATUS  = '/proc/*/status';
	const PROC_GLOB_CMDLINE = '/proc/*/cmdline';

	/**
	 * @var  array  Distros info
	 */
	protected $_distros = array();

	/**
	 * @var  SysInfo_System_Reader
	 */
	protected $_reader;

	/**
	 * Creates a new Linux OS reader
	 *
	 * @param   SysInfo_System_Reader_File
	 * @param   array   Distros info
	 * @return  void
	 */
	public function __construct(SysInfo_System_Reader_File $reader = NULL, array $distros = NULL)
	{
		$this->_reader  = $reader;

		if ($distros !== NULL)
		{
			$this->_distros = $distros;
		}
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
		$output = array(
			'name'    => 'Linux',
			'version' => NULL,
		);

		$content = '';

		foreach ($this->_distros as $distro)
		{
			$this->_reader->filename($distro['file']);

			if ( ! $this->_reader->is_valid())
			{
				// Skip
				continue;
			}

			try
			{
				$content = $this->_reader->read();
			}
			catch(SysInfo_System_Reader_Exception $e)
			{
				// Skip
				continue;
			}

			if ($distro['regex'] === FALSE)
			{
				$output = array(
					'name'    => $distro['name'].' '.$output['name'],
					'version' => $content == '' ? NULL : $content
				);
			}
			elseif ($distro['regex'] === '')
			{
				$output = array(
					'name'    => $distro['name'].' '.$output['name'],
					'version' => NULL,
				);
			}
			elseif ($distro['name'] === FALSE AND preg_match($distro['regex'], $content, $match))
			{
				$output = array(
					'name'    => $match[1].' '.$output['name'],
					'version' => $match[2] . (isset($match[3]) ? ' ('.$match[3].')' : '')
				);
			}
			elseif(preg_match($distro['regex'], $content, $match))
			{
				$output = array(
					'name'    => $distro['name'].' '.$output['name'],
					'version' => $match[1] . (isset($match[2]) ? ' ('.$match[2].')' : '')
				);
			}

			// Done searching
			break;
		}

		return $output;
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
		$this->_reader->filename(SysInfo_OS_Reader_Linux::PROC_VERSION);

		try
		{
			$content = $this->_reader->read();
		}
		catch(SysInfo_System_Reader_Exception $e)
		{
			return NULL;
		}

        if (preg_match('/version (.*?) /', $content, $match))
        {
            $kernel = $match[1];

            if (preg_match('/SMP/', $content))
            {
                $kernel .= ' (SMP)';
            }

			return $kernel;
		}

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
		$this->_reader->filename(SysInfo_OS_Reader_Linux::PROC_HOSTNAME);

		try
		{
			$content = $this->_reader->read();
		}
		catch(SysInfo_System_Reader_Exception $e)
		{
			return NULL;
		}

		return $content;
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
		$this->_reader->filename(SysInfo_OS_Reader_Linux::PROC_UPTIME);

		try
		{
			$content = $this->_reader->read();
		}
		catch(SysInfo_System_Reader_Exception $e)
		{
			return NULL;
		}

		list($seconds) = explode(' ', $content, 1);

		return (int) ceil($seconds);
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
		$this->_reader->filename(SysInfo_OS_Reader_Linux::PROC_LOADAVG);

		try
		{
			$content = $this->_reader->read();
		}
		catch(SysInfo_System_Reader_Exception $e)
		{
			return $output;
		}

		$parts = explode(' ', $content);

		return array(
			'1min'  => $parts[0],
			'5min'  => $parts[1],
			'15min' => $parts[2]
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

		// Get process status files
		$files = $this->_reader->glob(SysInfo_OS_Reader_Linux::PROC_GLOB_STATUS);

		// Total processes
		$output['total'] = count($files);

		foreach ($files as $file)
		{
			$this->_reader->filename($file);

			if ( ! $this->_reader->is_valid())
			{
				// Skip
				continue;
			}

			try
			{
				$content = $this->_reader->read();
			}
			catch(SysInfo_System_Reader_Exception $e)
			{
				// Skip
				continue;
			}

			// Process state
			preg_match('/^State:\s+(\w)/m', $content, $state);

			switch ($state[1])
			{
				case 'D':
				case 'S':
					$output['sleeping']++;
					break;

				case 'Z':
					$output['zombie']++;
					break;

				case 'R':
					$output['running']++;
					break;

				case 'T':
					$output['stopped']++;
					break;
			}

			// Get threads
			preg_match('/^Threads:\s+(\d+)/m', $content, $threads);

			if ($threads)
			{
				// Extract number of threads
				list(, $threads) = $threads;
			}

			if (is_numeric($threads))
			{
				// Add number of threads
				$output['threads'] = $output['threads'] + $threads;
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
		$files = glob(SysInfo_OS_Reader_Linux::PROC_GLOB_CMDLINE, GLOB_NOSORT);

		$users = array();

		foreach ($files as $file)
		{
			$this->_reader->filename($file);

			if ( ! $this->_reader->is_valid())
			{
				// Skip
				continue;
			}

			try
			{
				$content = $this->_reader->read();
			}
			catch(SysInfo_System_Reader_Exception $e)
			{
				// Skip
				continue;
			}

			// Looking for users logged in to shell (bash, csh, etc)
			if (preg_match('/(?:bash|csh|zsh|ksh)$/', $content))
			{
				$owner = fileowner(dirname($file));

				if ( ! is_numeric($owner))
				{
					// Skip
					continue;
				}

				if ( ! in_array($owner, $users))
				{
					// Add a user
					$users[] = $owner;
				}
			}
		}

		return count($users);
	}
}
