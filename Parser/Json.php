<?php

namespace opensourceame\Config\Parser;

class Json extends Parser
{
	private		$errors		= array(
					'No error',
					'The maximum stack depth has been exceeded',
					'Invalid or malformed JSON',
					'Control character error, possibly incorrectly encoded',
					'Syntax error',
					'Malformed UTF-8 characters, possibly incorrectly encoded',
				);
	public function parse($json)
	{
		// first check if we have been passed a file

		if (file_exists($json) and is_readable($json)) {
			return $this->parseFile($json);
		}

		// not a file, parse the text

		return $this->parseText($json);
	}

	public function parseFile($filename)
	{
		print_r(file_get_contents($filename));
		if (! is_readable($filename)) {
			$this->parent->addError("unable to read $filename");
		}

		$json = json_decode(file_get_contents($filename));

		if (! is_array($json)) {

			$this->parent->addError("unable to parse JSON in $filename: " . $this->errors[json_last_error()]);

			return false;
		}

		$this->parent->registerFileRead($filename, 'json');

		return $this->setFromArray($json);
	}

	public function parseText($text)
	{
		$json = json_decode($text);

		return $this->setFromArray($json);
	}

}
