<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * System info
 *
 * @package    SysInfo
 * @category   Base
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
class SysInfo_Core {

	/**
	 * @var  array  Operating system name and version
	 */
	protected $_os = array(
		'name'    => NULL,
		'version' => NULL,
	);

	/**
	 * @var  string  Kernel version
	 */
	protected $_kernel;

	/**
	 * @var  string  Host name
	 */
	protected $_hostname;

	/**
	 * @var  string  IP address
	 */
	protected $_ip;

	/**
	 * @var  int  System uptime
	 */
	protected $_uptime;

	/**
	 * @var  array  System load
	 */
	protected $_load = array(
		'1min'  => NULL,
		'5min'  => NULL,
		'15min' => NULL,
	);

	/**
	 * @var  string  System architecture
	 */
	protected $_arch;

	/**
	 * @var  array  CPU info
	 */
	protected $_cpuinfo;

	/**
	 * @var  array  Memory info
	 */
	protected $_meminfo;

	/**
	 * @var  array  HDD info
	 */
	protected $_scsi;

	/**
	 * @var  array  System devices
	 */
	protected $_devices;

	/**
	 * @var  array  RAID units
	 */
	protected $_raid;

	/**
	 * @var  array  Mounted file systems
	 */
	protected $_mounts;

	/**
	 * @var  array  Network devices
	 */
	protected $_network;

	/**
	 * @var  array  Process statuses
	 */
	protected $_procstat = array(
		'running'  => 0,
		'zombie'   => 0,
		'sleeping' => 0,
		'stopped'  => 0,
		'total'    => 0,
		'threads'  => 0,
	);

	/**
	 * @var  int  Number of logged in users
	 */
	protected $_users;

	/**
	 * Sets operating system name and version
	 *
	 * @param   array   Operating system name and version
	 * @return  SysInfo_Info
	 */
	public function os(array $os)
	{
		$this->_os = $os;

		return $this;
	}

	/**
	 * Sets kernel version
	 *
	 * @param   string  Kernel version
	 * @return  SysInfo_Info
	 */
	public function kernel($kernel)
	{
		$this->_kernel = $kernel;

		return $this;
	}

	/**
	 * Sets host name
	 *
	 * @param   string  Host name
	 * @return  SysInfo_Info
	 */
	public function hostname($hostname)
	{
		$this->_hostname = $hostname;

		return $this;
	}

	/**
	 * Sets IP address
	 *
	 * @param   string  IP address
	 * @return  SysInfo_Info
	 */
	public function ip($ip)
	{
		$this->_ip = $ip;

		return $this;
	}

	/**
	 * Sets system uptime
	 *
	 * @param   int   System uptime
	 * @return  SysInfo_Info
	 */
	public function uptime($uptime)
	{
		$this->_uptime = $uptime;

		return $this;
	}

	/**
	 * Sets system load
	 *
	 * @param   array   System load
	 * @return  SysInfo_Info
	 */
	public function load(array $load)
	{
		$this->_load = $load;

		return $this;
	}

	/**
	 * Sets system architecture
	 *
	 * @param   string  System architecture
	 * @return  SysInfo_Info
	 */
	public function arch($arch)
	{
		$this->_arch = $arch;

		return $this;
	}

	/**
	 * Sets CPU info
	 *
	 * @param   array   CPU info
	 * @return  SysInfo_Info
	 */
	public function cpuinfo(array $cpuinfo)
	{
		$this->_cpuinfo = $cpuinfo;

		return $this;
	}

	/**
	 * Sets memory info
	 *
	 * @param   array   Memory info
	 * @return  SysInfo_Info
	 */
	public function meminfo(array $meminfo)
	{
		$this->_meminfo = $meminfo;

		return $this;
	}

	/**
	 * Sets HDD info
	 *
	 * @param   array   HDD info
	 * @return  SysInfo_Info
	 */
	public function scsi(array $scsi)
	{
		$this->_scsi = $scsi;

		return $this;
	}

	/**
	 * Sets system devices
	 *
	 * @param   array   System devices
	 * @return  SysInfo_Info
	 */
	public function devices(array $devices)
	{
		$this->_devices = $devices;

		return $this;
	}

	/**
	 * Sets RAID units
	 *
	 * @param   array   RAID units
	 * @return  SysInfo_Info
	 */
	public function raid(array $raid)
	{
		$this->_raid = $raid;

		return $this;
	}

	/**
	 * Sets mounted file systems
	 *
	 * @param   array   Mounted file systems
	 * @return  SysInfo_Info
	 */
	public function mounts(array $mounts)
	{
		$this->_mounts = $mounts;

		return $this;
	}

	/**
	 * Sets network devices
	 *
	 * @param   array   Network devices
	 * @return  SysInfo_Info
	 */
	public function network(array $network)
	{
		$this->_network = $network;

		return $this;
	}

	/**
	 * Sets process statuses
	 *
	 * @param   array   Process statuses
	 * @return  SysInfo_Info
	 */
	public function procstat(array $procstat)
	{
		$this->_procstat = $procstat;

		return $this;
	}

	/**
	 * Sets number of logged in users
	 *
	 * @param   int     Number of logged in users
	 * @return  SysInfo_Info
	 */
	public function users($users)
	{
		$this->_users = $users;

		return $this;
	}

	/**
	 * Returns operating system name and version
	 *
	 * @return  array
	 */
	public function get_os()
	{
		return $this->_os;
	}

	/**
	 * Returns kernel version
	 *
	 * @return  string
	 */
	public function get_kernel()
	{
		return $this->_kernel;
	}

	/**
	 * Returns host name
	 *
	 * @return  string
	 */
	public function get_hostname()
	{
		return $this->_hostname;
	}

	/**
	 * Returns IP address
	 *
	 * @return  string
	 */
	public function get_ip()
	{
		return $this->_ip;
	}

	/**
	 * Returns system uptime
	 *
	 * @return  int
	 */
	public function get_uptime()
	{
		return $this->_uptime;
	}

	/**
	 * Returns system load
	 *
	 * @return  array
	 */
	public function get_load()
	{
		return $this->_load;
	}

	/**
	 * Returns system architecture
	 *
	 * @return  string
	 */
	public function get_arch()
	{
		return $this->_arch;
	}

	/**
	 * Returns CPU info
	 *
	 * @return  array
	 */
	public function get_cpuinfo()
	{
		return $this->_cpuinfo;
	}

	/**
	 * Returns memory info
	 *
	 * @return  array
	 */
	public function get_meminfo()
	{
		return $this->_meminfo;
	}

	/**
	 * Returns HDD info
	 *
	 * @return  array
	 */
	public function get_scsi()
	{
		return $this->_scsi;
	}

	/**
	 * Returns system devices
	 *
	 * @return  array
	 */
	public function get_devices()
	{
		return $this->_devices;
	}

	/**
	 * Returns RAID units
	 *
	 * @return  array
	 */
	public function get_raid()
	{
		return $this->_raid;
	}

	/**
	 * Returns mounted file systems
	 *
	 * @return  array
	 */
	public function get_mounts()
	{
		return $this->_mounts;
	}

	/**
	 * Returns network devices
	 *
	 * @return  array
	 */
	public function get_network()
	{
		return $this->_network;
	}

	/**
	 * Returns process statuses
	 *
	 * @return  array
	 */
	public function get_procstat()
	{
		return $this->_procstat;
	}

	/**
	 * Returns number of logged in users
	 *
	 * @return  int
	 */
	public function get_users()
	{
		return $this->_users;
	}
}
