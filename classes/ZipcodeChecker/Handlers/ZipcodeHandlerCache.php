<?php
/**
 * Created by IntelliJ IDEA.
 * User: esg
 * Date: 06/05/2017
 * Time: 01:59
 */

namespace Stplus\ZipcodeChecker\Handlers;


use Stplus\ZipcodeChecker\Address;

class ZipcodeHandlerCache extends ZipcodeHandler
{

    /**
     * @var Address
     */
    private $memcacheDAddress;

    protected function fetchAdress(): bool
    {
        $cached = $this->memcacheD->get(self::getCacheKey($this->address));
        if ($cached) {
            $this->fillAdress($cached);
            return true;
        }
        return false;
    }

    private function fillAdress($cached) {
//        Doesn't work (WTF!)
//        $this->address = unserialize($cached);
        $this->memcacheDAddress = unserialize($cached);
        $this->address->setCity($this->memcacheDAddress->getCity());
        $this->address->setStreet($this->memcacheDAddress->getStreet());
        $this->address->setLatitude($this->memcacheDAddress->getLatitude());
        $this->address->setLongitude($this->memcacheDAddress->getLongitude());
    }

    public static function getCacheKey(Address $address) : string
    {
        return (null != $address) ? ($address->getZipcode() . $address->getStreetnumber()) : null;
    }

}