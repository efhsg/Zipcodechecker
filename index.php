<?php

namespace Stplus\ZipcodeChecker;

use Stplus\ZipcodeChecker\Handlers\ZipcodeHandlerCache;

require __DIR__ . '/vendor/autoload.php';

$memcacheD = new \Memcached();
$memcacheD->addServer('127.0.0.1', 11211);
$cachePool = new MemcachedCachePool($memcacheD);

$chain = [];
$chain[] = new Handlers\ZipcodeHandlerCache();
$chain[] = new Handlers\ZipcodeHandlerApi();
$chain[] = new Handlers\ZipcodeHandlerGoogle();

// make the chain
foreach($chain as $key=>$handler){
    if(!empty($chain[$key+1])){
        $handler->setNextHandler($chain[$key+1]);
    }
}

// test data
$addressInput = new Address('9000','3068HL','Nederland');

// start thechain
$chain[0]->handle($addressInput, $cachePool);

var_dump($addressInput);


