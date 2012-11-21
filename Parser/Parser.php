<?php

namespace opensourceame\Config\Parser;

class Parser
{
	protected		$parent			= null;

	public function __construct($parent)
	{
		$this->parent = $parent;
	}
}