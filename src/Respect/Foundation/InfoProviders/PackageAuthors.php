<?php

namespace Respect\Foundation\InfoProviders;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class PackageAuthors extends AbstractProvider
{
	public function providerPackageIni()
	{
		$iniPath = realpath($this->projectFolder.'/package.ini');

		if (!file_exists($iniPath))
			return;

		$ini = parse_ini_file($iniPath, true);

		if (!isset($ini['package']['author']))
			return;

		if (isset($ini['package']['author']))
			$ini['package']['authors'] += array($ini['package']['author']);

		return implode(', ', $ini['package']['authors']);
	}

	public function providerGitBlame()
	{
		$authors = array_filter(explode("\n", shell_exec('git log --format="%aN <%aE>" | sort -u')));
		return implode(', ', $authors);
	}
}