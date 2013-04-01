<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * SysInfo_Info test
 *
 * @group  sysinfo
 * @group  sysinfo.base
 *
 * @package    SysInfo
 * @category   Tests
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
class SysInfo_InfoTest extends PHPUnit_Framework_TestCase {

	/**
	 * Provider for [test_it_sets_property]
	 *
	 * @return  array
	 */
	public function provider_test_it_sets_attribute()
	{
		return array(
			array('os',       'get_os',       array('name' => 'Arch', 'version' => NULL)),
			array('kernel',   'get_kernel',   'Linux'),
			array('hostname', 'get_hostname', 'bar'),
			array('ip',       'get_ip',       '1.1.2.2'),
			array('uptime',   'get_uptime',   12345),
			array('load',     'get_load',     array('1min' => '3', '5min' => '4', '15min' => '5')),
			array('arch',     'get_arch',     'x86'),
			array('users',    'get_users',    '2'),
		);
	}

	/**
	 * @covers  SysInfo_Info::os
	 * @covers  SysInfo_Info::kernel
	 * @covers  SysInfo_Info::hostname
	 * @covers  SysInfo_Info::ip
	 * @covers  SysInfo_Info::uptime
	 * @covers  SysInfo_Info::load
	 * @covers  SysInfo_Info::arch
	 * @covers  SysInfo_Info::users
	 *
	 * @covers  SysInfo_Info::get_os
	 * @covers  SysInfo_Info::get_kernel
	 * @covers  SysInfo_Info::get_hostname
	 * @covers  SysInfo_Info::get_ip
	 * @covers  SysInfo_Info::get_uptime
	 * @covers  SysInfo_Info::get_load
	 * @covers  SysInfo_Info::get_arch
	 * @covers  SysInfo_Info::get_users
	 *
	 * @dataProvider  provider_test_it_sets_attribute
	 *
	 * @param   string  Setter method name
	 * @param   string  Getter method name
	 * @param   mixed   Value
	 * @return  void
	 */
	public function test_it_sets_attribute($setter, $getter, $value)
	{
		$sysinfo = new SysInfo_Info;

		call_user_func(array($sysinfo, $setter), $value);

		$this->assertSame($value, call_user_func(array($sysinfo, $getter)));
	}
}
