<?php defined('SYSPATH') OR die('No direct script access.');

return array(
	array(
		'file'  => '/etc/lsb-release',
		'regex' => '/^DISTRIB_ID=([^$]+)$\n^DISTRIB_RELEASE=([^$]+)$\n^DISTRIB_CODENAME=([^$]+)$\n/m',
		'name'  => FALSE
	),
	array(
		'file'  => '/etc/redhat-release',
		'regex' => '/^CentOS release ([\d\.]+) \(([^)]+)\)$/',
		'name'  => 'CentOS',
	),
	array(
		'file'  => '/etc/redhat-release',
		'regex' => '/^Red Hat.+release (\S+) \(([^)]+)\)$/',
		'name'  => 'RedHat',
	),
	array(
		'file'  => '/etc/fedora-release',
		'regex' => '/^Fedora(?: Core)? release (\d+) \(([^)]+)\)$/',
		'name'  => 'Fedora',
	),
	array(
		'file'  => '/etc/gentoo-release',
		'regex' => '/([\d\.]+)$/',
		'name'  => 'Gentoo',
	),
	array(
		'file'  => '/etc/SuSE-release',
		'regex' => '/^VERSION = ([\d\.]+)$/m',
		'name'  => 'openSUSE',
	),
	array(
		'file'  => '/etc/slackware-version',
		'regex' => '/([\d\.]+)$/',
		'name'  => 'Slackware'
	),
	array(
		'file'  => '/etc/arch-release',
		'regex' => '',
		'name'  => 'Arch'
	),
	array(
		'file'  => '/etc/mklinux-release',
		'regex' => '',
		'name'  => 'MkLinux'
	),
	array(
		'file'  => '/etc/tinysofa-release ',
		'regex' => '',
		'name'  => 'TinySofa'
	),
	array(
		'file'  => '/etc/turbolinux-release ',
		'regex' => '',
		'name'  => 'TurboLinux'
	),
	array(
		'file'  => '/etc/yellowdog-release ',
		'regex' => '',
		'name'  => 'YellowDog'
	),
	array(
		'file'  => '/etc/annvix-release ',
		'regex' => '',
		'name'  => 'Annvix'
	),
	array(
		'file'  => '/etc/arklinux-release ',
		'regex' => '',
		'name'  => 'Arklinux'
	),
	array(
		'file'  => '/etc/aurox-release ',
		'regex' => '',
		'name'  => 'AuroxLinux'
	),
	array(
		'file'  => '/etc/blackcat-release ',
		'regex' => '',
		'name'  => 'BlackCat'
	),
	array(
		'file'  => '/etc/cobalt-release ',
		'regex' => '',
		'name'  => 'Cobalt'
	),
	array(
		'file'  => '/etc/immunix-release ',
		'regex' => '',
		'name'  => 'Immunix'
	),
	array(
		'file'  => '/etc/lfs-release ',
		'regex' => '',
		'name'  => 'Linux-From-Scratch'
	),
	array(
		'file'  => '/etc/linuxppc-release ',
		'regex' => '',
		'name'  => 'Linux-PPC'
	),
	array(
		'file'  => '/etc/mklinux-release ',
		'regex' => '',
		'name'  => 'MkLinux'
	),
	array(
		'file'  => '/etc/nld-release ',
		'regex' => '',
		'name'  => 'NovellLinuxDesktop'
	),
	array(
		'file'  => '/etc/debian_version',
		'regex' => FALSE,
		'name'  => 'Debian'
	),
);
