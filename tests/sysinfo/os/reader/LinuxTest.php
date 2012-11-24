<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * SysInfo_OS_Reader_Linux test
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
class SysInfo_OS_Reader_LinuxTest extends PHPUnit_Framework_TestCase {

	/**
	 * Reads content of a file
	 *
	 * @param   string  File name
	 * @return  string
	 */
	protected function read_file($filename)
	{
		$basedir = realpath(__DIR__.'/../../../data/os/linux');

		return file_get_contents($basedir.$filename);
	}

	/**
	 * Returns SysInfo_System_Reader_File mock
	 *
	 * @return  SysInfo_System_Reader_File
	 */
	protected function mock_system_reader()
	{
		return $this->getMockBuilder('SysInfo_System_Reader_File')
			->setMethods(array('filename', 'is_valid', 'read'))
			->getMock();
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::os
	 */
	public function test_os()
	{
		$system_reader = $this->mock_system_reader();

		$system_reader
			->expects($this->at(0))
			->method('filename')
			->with($this->equalTo('/etc/lsb-release'));

		$system_reader
			->expects($this->at(1))
			->method('is_valid')
			->will($this->returnValue(TRUE));

		$system_reader
			->expects($this->at(2))
			->method('read')
			->will($this->returnValue($this->read_file('/etc/lsb-release')));


		// Test
		$expected = array(
			'name'    => 'Ubuntu Linux',
			'version' => '11.10 (oneiric)',
		);

		$distros = array(
			array(
				'file'  => '/etc/lsb-release',
				'regex' => '/^DISTRIB_ID=([^$]+)$\n^DISTRIB_RELEASE=([^$]+)$\n^DISTRIB_CODENAME=([^$]+)$\n/m',
				'name'  => FALSE
			),
			array(
				'file'  => '/etc/arch-release',
				'regex' => '',
				'name'  => 'Arch'
			),
		);

		$os_reader = new SysInfo_OS_Reader_Linux($system_reader, $distros);

		$this->assertSame($expected, $os_reader->os());
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::os
	 */
	public function test_os_2()
	{
		$system_reader = $this->mock_system_reader();


		// Test
		$expected = array(
			'name'    => 'Linux',
			'version' => NULL,
		);

		$os_reader = new SysInfo_OS_Reader_Linux($system_reader);

		$this->assertSame($expected, $os_reader->os());
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::kernel
	 */
	public function test_kernel()
	{
		$system_reader = $this->mock_system_reader();

		$system_reader
			->expects($this->once())
			->method('filename')
			->with($this->equalTo(SysInfo_OS_Reader_Linux::PROC_VERSION));

		$system_reader
			->expects($this->once())
			->method('read')
			->will($this->returnValue($this->read_file(SysInfo_OS_Reader_Linux::PROC_VERSION)));


		// Test
		$os_reader = new SysInfo_OS_Reader_Linux($system_reader);

		$this->assertSame('3.0-ARCH (SMP)', $os_reader->kernel());
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::hostname
	 */
	public function test_hostname()
	{
		$system_reader = $this->mock_system_reader();

		$system_reader
			->expects($this->once())
			->method('filename')
			->with($this->equalTo(SysInfo_OS_Reader_Linux::PROC_HOSTNAME));

		$system_reader
			->expects($this->once())
			->method('read')
			->will($this->returnValue($this->read_file(SysInfo_OS_Reader_Linux::PROC_HOSTNAME)));


		// Test
		$os_reader = new SysInfo_OS_Reader_Linux($system_reader);

		$this->assertSame('fred', $os_reader->hostname());
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::ip
	 */
	public function test_ip()
	{
		$_SERVER['SERVER_ADDR'] = '10.11.12.13';


		// Test
		$os_reader = new SysInfo_OS_Reader_Linux;

		$this->assertSame('10.11.12.13', $os_reader->ip());
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::uptime
	 */
	public function test_uptime()
	{
		$system_reader = $this->mock_system_reader();

		$system_reader
			->expects($this->once())
			->method('filename')
			->with($this->equalTo(SysInfo_OS_Reader_Linux::PROC_UPTIME));

		$system_reader
			->expects($this->once())
			->method('read')
			->will($this->returnValue($this->read_file(SysInfo_OS_Reader_Linux::PROC_UPTIME)));


		// Test
		$os_reader = new SysInfo_OS_Reader_Linux($system_reader);

		$this->assertSame(366669, $os_reader->uptime());
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::load
	 */
	public function test_load()
	{
		$system_reader = $this->mock_system_reader();

		$system_reader
			->expects($this->once())
			->method('filename')
			->with($this->equalTo(SysInfo_OS_Reader_Linux::PROC_LOADAVG));

		$system_reader
			->expects($this->once())
			->method('read')
			->will($this->returnValue($this->read_file(SysInfo_OS_Reader_Linux::PROC_LOADAVG)));


		// Test
		$expected = array(
			'1min' => '0.31',
			'5min' => '0.16',
			'15min' => '0.18',
		);

		$os_reader = new SysInfo_OS_Reader_Linux($system_reader);

		$this->assertSame($expected, $os_reader->load());
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::arch
	 */
	public function test_arch()
	{
		$os_reader = new SysInfo_OS_Reader_Linux;

		$this->assertNull($os_reader->arch());
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::cpuinfo
	 */
	public function test_cpuinfo()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::meminfo
	 */
	public function test_meminfo()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::scsi
	 */
	public function test_scsi()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::devices
	 */
	public function test_devices()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::raid
	 */
	public function test_raid()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::mounts
	 */
	public function test_mounts()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::network
	 */
	public function test_network()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::procstat
	 */
	public function test_procstat()
	{
		$this->markTestIncomplete('TODO');
	}

	/**
	 * @covers  SysInfo_OS_Reader_Linux::users
	 */
	public function test_users()
	{
		$this->markTestIncomplete('TODO');
	}
}
