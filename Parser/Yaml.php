<?php

namespace opensourceame\Config\Parser;

class Yaml extends Parser
{
	public function parse($yaml)
	{

		echo "FJKDLFJLK";
		// first check if we have been passed a file

		if (is_readable($yaml)) {
			return $this->parseFile($yaml);
		}

		return $this->parseText($yaml);
	}

	public function parseFile($configFile)
	{

		if (function_exists('yaml_parse_file'))  {

			$yaml = yaml_parse_file($configFile);

		} else {

			$yaml = \Spyc::YAMLLoad($configFile);
		}

		if (! is_array($yaml))
			return false;

		$this->parent->registerFileRead($configFile, 'yaml');

		return $this->parent->parseArray($yaml);

	}

	public function parseText($text)
	{
		$yaml = yaml_parse($text);

		print_r($yaml);
	}

}
