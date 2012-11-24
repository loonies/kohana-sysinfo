<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * System info builder factory
 *
 * @package    SysInfo
 * @category   Base
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
class SysInfo_Core_Info_Builder_Factory {

	// OS reader class name
	const CLASS_OS_READER = 'SysInfo_OS_Reader_';

	/**
	 * Creates a new system info builder
	 *
	 * @return  SysInfo_Info_Builder
	 */
	public function create()
	{
		// Find out what we are dealing with
		$os = php_uname('s');

		$class = SysInfo_Info_Builder_Factory::CLASS_OS_READER.$os;

		if ( ! class_exists($class))
		{
			// There is no support for this operating system yet, but rest assured we are working on it..
			// If you have some kind of weird setup or operating system, please report an issue for inclusion.
			throw new SysInfo_OS_Exception('SysInfo does not support this operating system [ :os ]', array(':os' => $os));
		}

		switch ($os)
		{
			case 'Linux':
				$distros = Kohana::$config->load('distros')->as_array();
				$reader = new SysInfo_OS_Reader_Linux(new SysInfo_System_Reader_File, $distros);
				break;

			case 'FreeBSD':
				$reader = new SysInfo_OS_Reader_FreeBSD(new SysInfo_System_Reader_Command(SysInfo_OS_Reader_BSD::CMD_SYSCTL));
				break;

			default:
				throw new Kohana_Exception('A really big FUCK UP has been detected, as we should not reach this point!');
				break;
		}

		return new SysInfo_Info_Builder($reader);
	}
}
