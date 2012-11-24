<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * SysInfo_OS_Reader_BSD test
 *
 * @group  sysinfo
 * @group  sysinfo.os
 *
 * @package    SysInfo
 * @category   Tests
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
class SysInfo_OS_Reader_BSDTest extends PHPUnit_Framework_TestCase {

	/**
	 * Reads content of a file
	 *
	 * @param   string  File name
	 * @return  string
	 */
	protected function read_file($filename)
	{
		$basedir = realpath(__DIR__.'/../../../data/os/bsd');

		return file_get_contents($basedir.$filename);
	}

	/**
	 * Returns SysInfo_System_Reader_Command mock
	 *
	 * @return  SysInfo_System_Reader_Command
	 */
	protected function mock_system_reader()
	{
		return $this->getMockBuilder('SysInfo_System_Reader_Command')
			->setMethods(array('command', 'args', 'read'))
			->getMock();
	}

	/**
	 * Returns SysInfo_OS_Reader_BSD mock
	 *
	 * @return  SysInfo_OS_Reader_BSD
	 */
	protected function mock_os_reader($system_reader = NULL)
	{
		$os_reader = $this->getMockBuilder('SysInfo_OS_Reader_BSD');

		if ($system_reader !== NULL)
		{
			$os_reader->setConstructorArgs(array($system_reader));
		}

		return $os_reader->getMockForAbstractClass();
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::os
	 */
	public function test_os()
	{
		$this->markTestSkipped('Not testable');
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::kernel
	 */
	public function test_kernel()
	{
		$os_reader = $this->mock_os_reader();

		$this->assertNull($os_reader->kernel());
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::hostname
	 */
	public function test_hostname()
	{
		$this->markTestSkipped('Not testable');
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::ip
	 */
	public function test_ip()
	{
		$_SERVER['SERVER_ADDR'] = '10.11.12.13';


		// Test
		$os_reader = $this->mock_os_reader();

		$this->assertSame('10.11.12.13', $os_reader->ip());
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::uptime
	 */
	public function test_uptime()
	{
		$system_reader = $this->mock_system_reader();

		$system_reader
			->expects($this->once())
			->method('command')
			->with($this->equalTo(SysInfo_OS_Reader_BSD::CMD_SYSCTL));

		$system_reader
			->expects($this->once())
			->method('args')
			->with($this->equalTo(SysInfo_OS_Reader_BSD::SYSCTL_KERN_BOOTTIME));

		$system_reader
			->expects($this->once())
			->method('read')
			->will($this->returnValue($this->read_file('/sysctl/kern/boottime')));


		// Test
		$os_reader = $this->mock_os_reader($system_reader);

		$this->assertSame(time() - 1271934886, $os_reader->uptime());
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::load
	 */
	public function test_load()
	{
		$system_reader = $this->mock_system_reader();

		$system_reader
			->expects($this->once())
			->method('command')
			->with($this->equalTo(SysInfo_OS_Reader_BSD::CMD_SYSCTL));

		$system_reader
			->expects($this->once())
			->method('args')
			->with(SysInfo_OS_Reader_BSD::SYSCTL_VM_LOADAVG);

		$system_reader
			->expects($this->once())
			->method('read')
			->will($this->returnValue($this->read_file('/sysctl/vm/loadavg')));


		// Test
		$expected = array(
			'1min'  => '0.98',
			'5min'  => '1.39',
			'15min' => '1.50',
		);

		$os_reader = $this->mock_os_reader($system_reader);

		$this->assertSame($expected, $os_reader->load());
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::arch
	 */
	public function test_arch()
	{
		$os_reader = $this->mock_os_reader();

		$this->assertNull($os_reader->arch());
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::cpuinfo
	 */
	public function test_cpuinfo()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::meminfo
	 */
	public function test_meminfo()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::scsi
	 */
	public function test_scsi()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::devices
	 */
	public function test_devices()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::raid
	 */
	public function test_raid()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::mounts
	 */
	public function test_mounts()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::network
	 */
	public function test_network()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::procstat
	 */
	public function test_procstat()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_BSD::users
	 */
	public function test_users()
	{
		$this->markTestIncomplete('TODO');
	}
}
