<?php
/**
 * Created by IntelliJ IDEA.
 * User: esg
 * Date: 05/05/2017
 * Time: 21:54
 */

namespace Stplus\ZipcodeChecker\Handlers;

use  Stplus\ZipcodeChecker\Address;

interface ZipcodeHandlerInterface
{
    public function setNextHandler(ZipcodeHandlerInterface $nextHandler);

    public function handle(Address $address, \Memcached $memcacheD): Address;
}