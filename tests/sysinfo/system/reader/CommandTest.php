<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * SysInfo_System_Reader_Command test
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
class SysInfo_System_Reader_CommandTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var  vfsStreamDirectory
	 */
	protected $_root;

	protected function setUp()
	{
		if ( ! @include_once( 'vfsStream/vfsStream.php'))
		{
			$this->markTestSkipped('Test requires vfsStream library installed');
		}

		$fs = array(
			'bin'  => array(
				'cat' => '',
				'ls' => '',
			),
			'sbin' => array(
				'ip' => '',
				'mount' => '',
			),
		);

		$this->_root = vfsStream::setup('root', NULL, $fs);
	}

	/**
	 * @covers  SysInfo_System_Reader_Command::__construct
	 * @covers  SysInfo_System_Reader_Command::command
	 */
	public function test_it_sets_command()
	{
		$reader = new SysInfo_System_Reader_Command('/bin/foo');
		$this->assertAttributeSame('/bin/foo', '_command', $reader, 'Using constructor');

		$reader->command('/bin/bar');
		$this->assertAttributeSame('/bin/bar', '_command', $reader, 'Using "command" method');
	}

	/**
	 * @covers  SysInfo_System_Reader_Command::__construct
	 */
	public function test_it_has_default_search_paths_initially()
	{
		$paths = array('/bin', '/sbin', '/usr/bin', '/usr/sbin', '/usr/local/bin', '/usr/local/sbin');

		$reader = new SysInfo_System_Reader_Command;

		$this->assertAttributeSame($paths, '_paths', $reader);
	}

	/**
	 * @covers  SysInfo_System_Reader_Command::__construct
	 */
	public function test_it_sets_search_paths()
	{
		$paths = array('/bin/p1', '/sbin/p1');

		$reader = new SysInfo_System_Reader_Command(NULL, $paths);

		$this->assertAttributeSame($paths, '_paths', $reader);
	}

	/**
	 * @covers  SysInfo_System_Reader_Command::args
	 */
	public function test_it_sets_args()
	{
		$reader = new SysInfo_System_Reader_Command;

		$this->assertAttributeEmpty('_args', $reader, 'Arguments should be empty initially');

		$reader->args('-a -bc');

		$this->assertAttributeSame('-a -bc', '_args', $reader, 'Arguments should be set');
	}

	/**
	 * @covers  SysInfo_System_Reader_Command::read
	 *
	 * @expectedException         SysInfo_System_Reader_Exception
	 * @expectedExceptionMessage  Command to execute not set
	 */
	public function test_it_throws_exception_if_command_not_set()
	{
		$reader = new SysInfo_System_Reader_Command;

		$reader->read();
	}

	/**
	 * Since there is no "vfs://sbin/mound" command,
	 * test asserts exception code and message.
	 * This way we are sure that right command would be executed.
	 *
	 * @covers  SysInfo_System_Reader_Command::read
	 */
	public function test_it_executes_command()
	{
		$paths = array(
			vfsStream::url('bin'),
			vfsStream::url('sbin'),
		);

		$mount = $this->_root
			->getChild('sbin/mount')
			->chmod(0544);

		$reader = new SysInfo_System_Reader_Command('mount', $paths);

		try
		{
			$reader->read();
		}
		catch(SysInfo_System_Reader_Exception $e)
		{
			$this->assertSame(127, $e->getCode());
			$this->assertStringStartsWith('Error executing command [ vfs://sbin/mount 2>&1 ] with the message', $e->getMessage());
		}
	}

	/**
	 * @covers  SysInfo_System_Reader_Command::read
	 *
	 * @expectedException         SysInfo_System_Reader_Exception
	 * @expectedExceptionMessage  Unable to read system information by using command [ vfs://sbin/lol ]
	 */
	public function test_it_throws_exception_if_command_not_found()
	{
		$paths = array(
			vfsStream::url('bin'),
			vfsStream::url('sbin'),
		);

		$reader = new SysInfo_System_Reader_Command('lol', $paths);

		$reader->read();
	}
}
