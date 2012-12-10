<?php

namespace opensourceame\Config\Parser;

class Cli extends Parser
{
	public function parse()
	{
		$argc	= $GLOBALS['argc'];
		$argv	= $GLOBALS['argv'];

		for ($i = 1; $i < $argc; $i++) {

			if (substr($argv[$i], 0, 2) == '--') {

				$name 	= substr($argv[$i], 2);
				$value	= isset($argv[$i + 1]) ? $argv[$i + 1] : true;

				$this->parent->set($name, $value);
			}
		}
	}
}
