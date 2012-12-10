<?php

namespace opensourceame\Config\Parser;

class Yaml extends Parser
{
	public function parse($yaml)
	{
		// first check if we have been passed a file

		if (file_exists($yaml) and is_readable($yaml)) {
			return $this->parseFile($yaml);
		}

		// not a file, parse the text

		return $this->parseText($yaml);
	}

	public function parseFile($filename)
	{
		if (function_exists('yaml_parse_file'))  {

			$yaml = yaml_parse_file($filename);

		} else {

			$yaml = \Spyc::YAMLLoad($filename);
		}

		if (! is_array($yaml)) {

			return false;
		}

		$this->parent->registerFileRead($filename, 'yaml');

		return $this->setFromArray($yaml);
	}

	public function parseText($text)
	{
		$yaml = yaml_parse($text);

		return $this->setFromArray($yaml);
	}

}
