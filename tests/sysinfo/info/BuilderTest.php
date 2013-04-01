<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * SysInfo_Info_Builder test
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
class SysInfo_Info_BuilderTest extends PHPUnit_Framework_TestCase {

	/**
	 * @covers  SysInfo_Info_Builder::__construct
	 * @covers  SysInfo_Info_Builder::reader
	 */
	public function test_it_sets_os_reader()
	{
		$reader_a = $this->getMockBuilder('SysInfo_OS_Reader')
			->getMock();

		$reader_b = $this->getMockBuilder('SysInfo_OS_Reader')
			->getMock();

		$builder = new SysInfo_Info_Builder($reader_a);

		$this->assertAttributeSame($reader_a, '_reader', $builder, 'Set through "__construct" method');

		$builder->reader($reader_b);

		$this->assertAttributeSame($reader_b, '_reader', $builder, 'Set through "reader" method');
	}

	/**
	 * @covers  SysInfo_Info_Builder::build
	 */
	public function test_it_builds_sysinfo()
	{
		$methods = array(
			'os'       => array('name' => 'Arch', 'version' => NULL),
			'kernel'   => 'Linux',
			'hostname' => 'foo',
			'ip'       => '1.2.3.4',
			'uptime'   => 12345,
			'load'     => array('1min' => '', '5min' => '', '15min' => ''),
			'arch'     => 'x86',
			'cpuinfo'  => array(),
			'meminfo'  => array(),
			'scsi'     => array(),
			'devices'  => array(),
			'raid'     => array(),
			'mounts'   => array(),
			'network'  => array(),
			'procstat' => array(),
			'users'    => 3,
		);

		$reader = $this->getMockBuilder('SysInfo_OS_Reader')
			->setMethods(array_keys($methods))
			->getMock();

		foreach ($methods as $method => $value)
		{
			$reader
				->expects($this->once())
				->method($method)
				->will($this->returnValue($value));
		}

		$builder = new SysInfo_Info_Builder($reader);

		$builder->build(new SysInfo_Info);
	}
}
