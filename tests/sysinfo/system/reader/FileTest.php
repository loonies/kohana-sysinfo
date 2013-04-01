<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * SysInfo_System_Reader_File test
 *
 * @group  sysinfo
 * @group  sysinfo.system
 *
 * @package    SysInfo
 * @category   Tests
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2012, Miodrag Tokić
 * @license    MIT
 */
class SysInfo_System_Reader_FileTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var  vfsStreamFile
	 */
	protected $_file;

	protected function setUp()
	{
		if ( ! @include_once( 'vfsStream/vfsStream.php'))
		{
			$this->markTestSkipped('Test requires vfsStream library installed');
		}

		$root = vfsStream::setup('etc');

		$this->_file = vfsStream::newFile('foo', 0644)
			->withContent(' Lolimuz  ')
			->at($root);
	}

	/**
	 * @covers  SysInfo_System_Reader_File::__construct
	 * @covers  SysInfo_System_Reader_File::filename
	 */
	public function test_it_sets_file_name()
	{
		$reader = new SysInfo_System_Reader_File('/etc/foo');
		$this->assertAttributeSame('/etc/foo', '_filename', $reader, 'Using constructor');

		$reader->filename('/etc/bar');
		$this->assertAttributeSame('/etc/bar', '_filename', $reader, 'Using "filename" method');
	}

	/**
	 * @covers  SysInfo_System_Reader_file::read
	 */
	public function test_it_gets_file_content()
	{
		$reader = new SysInfo_System_Reader_File(vfsStream::url('etc/foo'));
		$this->assertSame('Lolimuz', $reader->read());
	}

	/**
	 * @covers  SysInfo_System_Reader_file::read
	 *
	 * @expectedException         SysInfo_System_Reader_Exception
	 * @expectedExceptionMessage  File does not exists or not readable [ vfs://etc/none ]
	 */
	public function test_it_throws_exception_if_file_doesnt_exists()
	{
		$reader = new SysInfo_System_Reader_File(vfsStream::url('etc/none'));
		$reader->read();
	}

	/**
	 * @covers  SysInfo_System_Reader_file::read
	 *
	 * @expectedException         SysInfo_System_Reader_Exception
	 * @expectedExceptionMessage  File does not exists or not readable [ vfs://etc/foo ]
	 */
	public function test_it_throws_exception_if_file_not_readable()
	{
		$this->_file->chmod(000);

		$reader = new SysInfo_System_Reader_File(vfsStream::url('etc/foo'));
		$reader->read();
	}

	/**
	 * @covers  SysInfo_System_Reader_File::glob
	 */
	public function test_it_finds_pathnames()
	{
		$path = realpath(__DIR__.'/../../../data/os/linux');

		$reader = new SysInfo_System_Reader_File;

		$expected = array(
			$path.'/proc/1039/status',
			$path.'/proc/1351/status',
			$path.'/proc/4330/status',
		);

		$this->assertSame($expected, $reader->glob($path.'/proc/*/status'));
	}
}
