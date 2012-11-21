<?php

namespace opensourceame\Config\Parser;

class Yaml extends Parser
{
	private			$redis;
	private			$defaultSettings = array(
						'host'		=> 'localhost',
						'db'		=> 1,

					);

	public function parse($settings)
	{
		$this->settings		= array_merge($this->defaultSettings, $settings);

		$this->setupRedis();


	}


	protected function setupRedis()
	{
		if (is_object($this->redis)) {
			return true;
		}

		$this->redis = new Redis;

		try {
			$this->redis->connect($this->settings['host']);
			$this->redis->select($this->settings['db']);

		} catch (Exception $e) {

			throw new ErrorException('unable to connect to redis server');

			return false;
		}

		return true;
	}


}