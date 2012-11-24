<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * System info reader interface
 *
 * @package    SysInfo
 * @category   System
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
interface SysInfo_Core_System_Reader {

	/**
	 * Reads a system info
	 *
	 * @return  mixed
	 */
	public function read();
}
