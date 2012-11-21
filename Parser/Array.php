<?php

namespace opensourceame\Config\Parser;

/**
 * Note, this class name uses a different name to prevent an issue with using the reserved
 * word "Array"
 *
 * @author David Kelly
 *
 */
class ArrayParser extends Parser
{

	public function parse($data)
	{
		return $this->parent->setFromArray($data);
	}

}