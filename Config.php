<?php
/**
 * A config parsing class with multiple types of input and output
 *
 * @author 		David Kelly
 * @license		GPL v3
 *
 */
namespace opensourceame;

class Config
{
	const			version		= '0.1';

	private			$parsers	= array();
	private			$outputs	= array();

	public function __call($method, $arguments = null)
	{
		var_dump($method);
		if (! method_exists($this, $method)) {

			if (substr($method, 0, 4) == 'read') {

				$parser = substr($method, 4);
				$plugin = $this->getParser($parser);

				if ($plugin === false) {
					return false;
				}

				return call_user_func_array(array($plugin, 'parse'), $arguments);
			}

			if (substr($method, 0, 6) == 'saveTo') {

				$name 	= substr($method, 6);
				$plugin = $this->getOutput($name);

				if ($plugin === false) {
					return false;
				}

				return call_user_func_array(array($plugin, 'input'), $arguments);
			}


		}

	}

	private function getParser($name)
	{
		require_once __DIR__ . "/Parser/Parser.php";
		require_once __DIR__ . "/Parser/$name.php";

		if ($name == 'Array') {
			$name = 'ArrayParser';
		}

		$className	= '\\opensourceame\\Config\Parser\\' . $name;
		$plugin 	= new $className($this);

		return $plugin;
	}


	private function getOuput($name)
	{

	}

	public function setFromArray($data)
	{
		if (! is_array($data)) {
			return false;
		}

		$this->config = $data;

		return true;
	}

}