<?php

require_once '../Config.php';

$yaml = <<<END
this:
  is:
    a:
      test:  yay

list:
  - first
  - second
  - third
END;

$json = <<<END
{
  "some": {
  	"json": "text"
  }
}
END;

$config = new \opensourceame\Config;

// read from YAML strings and files
$config->readYaml($yaml);
$config->readYaml('test.yaml');

// read from JSON strings and files
$config->readJson($json);
$config->readJson('test.json');

// read from the command line
$config->readCli();

print_r($config);

var_dump($config->get('this:is:a:test'));
var_dump($config->get('list:*'));