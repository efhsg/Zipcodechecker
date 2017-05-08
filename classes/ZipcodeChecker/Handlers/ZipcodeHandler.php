<?php

namespace Stplus\ZipcodeChecker\Handlers;

use Stplus\ZipcodeChecker\Address;

abstract class ZipcodeHandler implements ZipcodeHandlerInterface
{

    private $nextHandler;
    /**
     * @var Address
     */
    protected $address;
    protected $memcacheD;

    public function setNextHandler(ZipcodeHandlerInterface $nextHandler)
    {
        $this->nextHandler = $nextHandler;

    }

    public function handle(Address $address, \Memcached $memcacheD): Address
    {
        $this->memcacheD = $memcacheD;

        echo get_class($this) . ' : ' . $address->getZipcode() . " => ";

        $this->address = $address;
        if ($this->fetchAdress()) {
            echo "Computer says YES!<br/>";
            $this->writeAdressToCache();
            return $this->address;
        } elseif ($this->nextHandler) {
            echo "Computer says no...<br/>";
            $this->nextHandler->handle($address, $memcacheD);
        }

        return $this->address;

    }

    protected function fetchAdress(): bool
    {
        return false;
    }

    private function writeAdressToCache()
    {
        if (null != $this->address->getStreet()) {
            $this->memcacheD->set(ZipcodeHandlerCache::getCacheKey($this->address), serialize($this->address));
            var_dump($this->memcacheD->get(ZipcodeHandlerCache::getCacheKey($this->address)));
        }
    }

}