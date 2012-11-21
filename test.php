<?php

require_once 'Config.php';

$yaml = <<<END
this:
  is:
    a:
      test:  yay
END;

$config = new \opensourceame\Config;

$config->readYaml($yaml);

print_r($config);