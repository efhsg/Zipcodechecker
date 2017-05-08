<?php
/**
 * Created by IntelliJ IDEA.
 * User: esg
 * Date: 05/05/2017
 * Time: 21:58
 */

namespace Stplus\ZipcodeChecker;


class Address
{
    private $streetnumber;
    private $zipcode;
    private $country;
    private $city;
    private $street;
    private $latitude;
    private $longitude;

    /**
     * Address constructor.
     * @param $streetnumber
     * @param $zipcode
     * @param $country
     */
    public function __construct($streetnumber, $zipcode, $country)
    {
        $this->streetnumber = $streetnumber;
        $this->zipcode = $zipcode;
        $this->country = $country;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getStreetnumber()
    {
        return $this->streetnumber;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }


}