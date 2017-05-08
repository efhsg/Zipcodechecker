<?php

namespace Stplus\ZipcodeChecker;

require __DIR__ . '/vendor/autoload.php';

$memcacheD = new \Memcached();
$memcacheD->addServer('127.0.0.1', 11211);
var_dump($memcacheD->flush());

