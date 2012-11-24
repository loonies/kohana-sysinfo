<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * System info builder
 *
 * @package    SysInfo
 * @category   Base
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
class SysInfo_Core_Info_Builder {

	/**
	 * @var  SysInfo_OS_Reader
	 */
	protected $_reader;

	/**
	 * Creates a new system info builder
	 *
	 * @param   SysInfo_OS_Reader
	 * @return  void
	 */
	public function __construct(SysInfo_OS_Reader $reader = NULL)
	{
		$this->_reader = $reader;
	}

	/**
	 * Sets a OS reader
	 *
	 * @param   SysInfo_OS_Reader
	 * @return  void
	 */
	public function reader(SysInfo_OS_Reader $reader)
	{
		$this->_reader = $reader;
	}

	/**
	 * Fills SysInfo with informations
	 *
	 * @param   SysInfo_Info
	 * @return  SysInfo_Info
	 */
	public function build(SysInfo_Info $sysinfo)
	{
		return $sysinfo
			->os($this->_reader->os())
			->kernel($this->_reader->kernel())
			->hostname($this->_reader->hostname())
			->ip($this->_reader->ip())
			->uptime($this->_reader->uptime())
			->load($this->_reader->load())
			->arch($this->_reader->arch())
			->cpuinfo($this->_reader->cpuinfo())
			->meminfo($this->_reader->meminfo())
			->scsi($this->_reader->scsi())
			->devices($this->_reader->devices())
			->raid($this->_reader->raid())
			->mounts($this->_reader->mounts())
			->network($this->_reader->network())
			->procstat($this->_reader->procstat())
			->users($this->_reader->users());
	}
}
