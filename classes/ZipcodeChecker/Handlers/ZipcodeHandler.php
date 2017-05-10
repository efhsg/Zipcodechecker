<?php

namespace Stplus\ZipcodeChecker\Handlers;

use Cache\Adapter\Common\AbstractCachePool;
use Stplus\ZipcodeChecker\Address;

abstract class ZipcodeHandler implements ZipcodeHandlerInterface
{

    private $nextHandler;
    /**
     * @var Address
     */
    protected $address;

    /**
     * @var AbstractCachePool
     */
    protected $cachePool;

    public function setNextHandler(ZipcodeHandlerInterface $nextHandler)
    {
        $this->nextHandler = $nextHandler;

    }

    public function handle(Address $address, AbstractCachePool $cachePool): Address
    {
        $this->cachePool = $cachePool;

        echo get_class($this) . ' : ' . $address->getZipcode() . " => ";

        $this->address = $address;
        if ($this->fetchAdress()) {
            echo "Computer says YES!<br/>";
            $this->writeAdressToCache();
            return $this->address;
        } elseif ($this->nextHandler) {
            echo "Computer says no...<br/>";
            $this->nextHandler->handle($address, $cachePool);
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
            $this->cachePool->set(ZipcodeHandlerCache::getCacheKey($this->address), serialize($this->address));
            var_dump($this->cachePool->get(ZipcodeHandlerCache::getCacheKey($this->address)));
        }
    }

}