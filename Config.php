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
	const			notset		= '__not_set';

	private			$filesRead	= array();
	private			$errors		= array();

	public			$delimiter	= ':';

	public function __call($method, $arguments = null)
	{
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

	public function addError($message)
	{
		array_push($this->errors, $message);
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

	public function set($key, $value) {

		if (substr($key, -2) == $this->delimiter . '+') {
			return $this->append(substr($name, 0, strlen($name) -2), $value);
		}

		$this->config[$key] = $value;

		return true;
	}

	public function append($name, $value)
	{
		$values = $this->getArray($name . $this->delimiter . '*');
		$index	= count($values) + 1;

		$this->set($name . $this->delimiter . $index, $value);

		return true;
	}

	public function get($name = null)
	{

		if (isset($this->config[$name])) {
			return $this->config[$name];
		}

		if($name == null) {
			return $this->config;
		}

		if (substr($name, -1) == '*') {

			$matches	= array();
			$search		= substr($name, 0, strlen($name) -1);

			foreach($this->config as $key => $val) {

				if (substr($key, 0, strlen($search)) == $search) {

					$matches[substr($key, strlen($search))] = $val;
				}
			}

			return $matches;
		}

		return self::notset;
	}

	static public function objectToArray( $object )
	{
		if ( (! is_object($object)) and (! is_array( $object ))) {

			return $object;
		}

		if (is_object($object)) {

			$object = get_object_vars($object);
		}

		return array_map('\opensourceame\Config::objectToArray', $object);
	}

	public function setFromArray($data)
	{
		if (is_object($data)) {
			$data = $this->objectToArray($data);
		}

		if (! is_array($data)) {
			return false;
		}

		$flat = $this->flattenArray($data);

		foreach ($flat as $key => $val) {
			$this->set($key, $val);
		}

		return true;
	}

	private function flattenArray($data, $prefix = false, & $flat = array())
	{
		if ($prefix !== false) {
			$prefix .= $this->delimiter;
		}

		foreach ($data as $key => $val) {

			if (is_array($val) and ! empty($val)) {

				$this->flattenArray($val, $prefix.$key, $flat);

			} else {

				$flat[$prefix.$key] = $val;
			}
		}

		return $flat;
	}

	public function registerFileRead($filename, $type = 'unknown')
	{
		$this->filesRead[$type][] = $filename;

		return true;
	}
}