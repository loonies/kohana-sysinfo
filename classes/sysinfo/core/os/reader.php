<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * OS reader interface
 *
 * // TODO SysInfo_OS_Reader::uptime should return only boot time,
 * // uptime should be calculated as `current-time - boot-time`
 *
 * @package    SysInfo
 * @category   OS
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
interface SysInfo_Core_OS_Reader {

	/**
	 * Reads operating system name and version
	 *
	 * @return  array
	 */
	public function os();

	/**
	 * Reads kernel version
	 *
	 * @return  string
	 */
	public function kernel();

	/**
	 * Reads host name
	 *
	 * @return  string
	 */
	public function hostname();

	/**
	 * Reads IP address
	 *
	 * @return  string
	 */
	public function ip();

	/**
	 * Reads system up time
	 *
	 * @return  int
	 */
	public function uptime();

	/**
	 * Reads system load
	 *
	 * @return  array
	 */
	public function load();

	/**
	 * Reads system architecture
	 *
	 * @return  string
	 */
	public function arch();

	/**
	 * Reads CPU info
	 *
	 * @return  array
	 */
	public function cpuinfo();

	/**
	 * Reads memory info
	 *
	 * @return  array
	 */
	public function meminfo();

	/**
	 * Reads HDD info
	 *
	 * @return  array
	 */
	public function scsi();

	/**
	 * Reads devices
	 *
	 * @return  array
	 */
	public function devices();

	/**
	 * Reads RAID units
	 *
	 * @return  array
	 */
	public function raid();

	/**
	 * Reads info about mounted file systems
	 *
	 * @return  array
	 */
	public function mounts();

	/**
	 * Reads network devices
	 *
	 * @return  array
	 */
	public function network();

	/**
	 * Reads process stats
	 *
	 * @return  array
	 */
	public function procstat();

	/**
	 * Reads number of logged in users
	 *
	 * @return  int
	 */
	public function users();
}
