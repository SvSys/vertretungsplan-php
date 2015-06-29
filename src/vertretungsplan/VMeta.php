<?php
namespace Vertretungsplan;
use JsonSerializable;

/**
 * Created by PhpStorm.
 * User: jan
 * Date: 29.06.15
 * Time: 13:59
 */
class VMeta implements JsonSerializable
{

    private $untis_ver, $lastUpdated, $day, $current, $max;

    function __construct($untis_ver, $lastUpdated, $day, $current, $max)
    {
        $this->untis_ver = $untis_ver;
        $this->lastUpdated = $lastUpdated;
        $this->day = $day;
        $this->current = $current;
        $this->max = $max;
    }

    /**
     * @return String Untis Version
     */
    public function getUntisVer()
    {
        return $this->untis_ver;
    }

    /**
     * @return String Last Updated
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @return String Day of the Vplan
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return int Current Page
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @return int Max Page
     */
    public function getMax()
    {
        return $this->max;
    }


    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        $json = array();
        foreach ($this as $key => $value) {
            $json[$key] = $value;
        }
        return $json;
    }
}