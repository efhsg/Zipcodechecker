<?php
/**
 * Created by IntelliJ IDEA.
 * User: esg
 * Date: 06/05/2017
 * Time: 01:59
 */

namespace Stplus\ZipcodeChecker\Handlers;

use Geocoder\Model\AddressCollection;
use Geocoder\Provider\GoogleMaps;
use Ivory\HttpAdapter\CurlHttpAdapter;

class ZipcodeHandlerGoogle extends ZipcodeHandler
{

    private $geocoder;

    protected function fetchAdress(): bool
    {
        $this->retrieveCoordinatesFromGoogle($this->transformAddressForCoordinates());
        $this->getAddressCollectionFromGoogleWithCoordinates();
        if (null != $this->address->getStreet()) {
            return true;
        }
        return false;
    }

    private function retrieveCoordinatesFromGoogle($addressForCoordinates)
    {
        $resultsFromGoogle = $this->getAddressCollectionFromGoogle($addressForCoordinates);
        if ($resultsFromGoogle->count() > 0) {
            $this->address->setLatitude($resultsFromGoogle->first()->getCoordinates()->getLatitude());
            $this->address->setLongitude($resultsFromGoogle->first()->getCoordinates()->getLongitude());
        }
    }

    private function getAddressCollectionFromGoogle(string $address): AddressCollection
    {
        try {
            return $this->getGeoCoder()->geocode($address);
        } catch (\Exception $e) {
            return new AddressCollection();
        }
    }

    private final function getGeoCoder(): GoogleMaps
    {
        if (empty($this->geocoder)) {
            $adapter = new CurlHttpAdapter();
            $this->geocoder = new GoogleMaps($adapter);
            $this->geocoder->setLocale('nl-NL');
            $this->geocoder->limit(1);
        }
        return $this->geocoder;
    }

    private function getAddressCollectionFromGoogleWithCoordinates()
    {
        $resultsFromGoogle = $this->getGeoCoder()->reverse($this->address->getLatitude(),
            $this->address->getLongitude());
        if ($resultsFromGoogle->count() > 0) {
            $this->address->setStreet($resultsFromGoogle->first()->getStreetName());
            $this->address->setCity($resultsFromGoogle->first()->getLocality());
        }
    }

    private function transformAddressForCoordinates(): string
    {
        return $this->formatZipcode() . ', ' . $this->address->getCountry();
    }

    private function formatZipcode(): string
    {
        $zipcode = str_replace(' ', '', $this->address->getZipcode());
        return substr($zipcode, 0, 4) . ' ' . substr($zipcode, 4);
    }

}